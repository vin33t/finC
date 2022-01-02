<?php

namespace App\Http\Controllers;

use App\AirportCodes;
use App\User;
use Carbon\Carbon;
use Dompdf\Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;
class FlightController extends Controller
{
    public function search(Request $request){
//        return $request;
        try {
            $flightFrom = str_replace(')', '', explode('(', $request->flightFrom)[1]);
            $flightTo = str_replace(')', '', explode('(', $request->flightDestination)[1]);
//            return $flightTo;
            $TARGETBRANCH = 'P7141733';
            $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
            $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
            $returnSearch = '';
            $searchLegModifier = '';
            if ($request->tripType == 'oneWay') {
                $PreferredDate = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->flightDeparture))->format('Y-m-d');
            } else {
//                return Carbon::createFromFormat('d/m/Y',$date1)->format('Y-m-d');
//                return Carbon::createFromFormat('')
//                return Carbon::parse(str_replace(' ','',explode('-',$request->daterange)[0]));
//                return  Carbon::createFromFormat('d/m/Y',explode('-',$request->daterange)[0]);

                $returnDate = Carbon::createFromFormat('d/m/Y',str_replace(' ','',explode('-',$request->daterange)[1]))->format('Y-m-d');
                $PreferredDate = Carbon::createFromFormat('d/m/Y',str_replace(' ','',explode('-',$request->daterange)[0]))->format('Y-m-d');
                $returnSearch = '
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="' . $flightTo . '"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="' . $flightFrom . '"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="' . $returnDate . '">
            </air:SearchDepTime>
            ' . $searchLegModifier . '
         </air:SearchAirLeg>';
            }
            if ($request->travelClass != 'All') {
                $searchLegModifier = ' <air:AirLegModifiers>
              	<air:PreferredCabins>
              	<com:CabinClass xmlns="http://www.travelport.com/schema/common_v42_0" Type="' . $request->travelClass . '"></com:CabinClass>
              	</air:PreferredCabins>
              </air:AirLegModifiers>';
            }

            $query = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Header/>
   <soapenv:Body>
      <air:LowFareSearchReq TraceId="trace" AuthorizedBy="user" SolutionResult="true" TargetBranch="' . $TARGETBRANCH . '" xmlns:air="http://www.travelport.com/schema/air_v33_0" xmlns:com="http://www.travelport.com/schema/common_v33_0">
         <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="' . $flightFrom . '"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="' . $flightTo . '"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="' . $PreferredDate . '">
            </air:SearchDepTime>
            ' . $searchLegModifier . '
         </air:SearchAirLeg>
        ' . $returnSearch . '
         <air:AirSearchModifiers>
            <air:PreferredProviders>
               <com:Provider Code="' . $Provider . '"/>
            </air:PreferredProviders>
         </air:AirSearchModifiers>
		 <com:SearchPassenger BookingTravelerRef="1" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v33_0"/>
      </air:LowFareSearchReq>
   </soapenv:Body>
</soapenv:Envelope>';
            $message = <<<EOM
$query
EOM;

//        return $query;
            $auth = base64_encode("$CREDENTIALS");
            $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");
            /*("https://americas.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");*/
            $header = array(
                "Content-Type: text/xml;charset=UTF-8",
                "Accept: gzip,deflate",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: \"\"",
                "Authorization: Basic $auth",
                "Content-length: " . strlen($message),
            );
//        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($soap_do, CURLOPT_POST, true );
            curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
            curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
            curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($soap_do);
            curl_close($soap_do);
//        return $return;
//        $file = "001-".$Provider."_LowFareSearchRsp.xml"; // file name to save the response xml for test only(if you want to save the request/response)
            $content = $this->prettyPrint($return);
            $flights = ($this->parseOutput($content));
//        return $flights->first()['flight']['journey'];
//        return $flights;
//        outputWriter($file, $return);
            $airlines = [];
            foreach ($flights as $flight) {
                array_push($airlines, $flight['flight']['journey']['Airline']);
            }
            $airlines = array_unique($airlines);
            return view('flight.flight.flights')->with('searched', $request)->with('flights', $flights)->with('airlines', $airlines);
        }
        catch (\Exception $e){
            dd($e);
//            return redirect()->back()->withErrors($e);
//            return redirect()->back()->withErrors(['No Flights Found for the searched criteria']);
        }
    }
    public function prettyPrint($result){
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($result);
        $dom->formatOutput = true;
        //call function to write request/response in file
//        outputWriter($file,$dom->saveXML());
        return $dom->saveXML();
    }

    public function parseOutput($content){	//parse the Search response to get values to use in detail request
//        dd($content);
        $data = collect();
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        //echo $LowFareSearchRsp;
        $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);

        if(!$xml){
            trigger_error("Encoding Error!", E_USER_ERROR);
        }

        $Results = $xml->children('SOAP',true);
        foreach($Results->children('SOAP',true) as $fault){
            if(strcmp($fault->getName(),'Fault') == 0){
                trigger_error("Error occurred request/response processing!", E_USER_ERROR);
            }
        }

        $count = 0;

        foreach($Results->children('air',true) as $lowFare){
            foreach($lowFare->children('air',true) as $airPriceSol){
                $flight = collect();
                if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){
                    $count = $count + 1;


                    // Journey Details
                    foreach($airPriceSol->children('air',true) as $journey){
                        $flightJourney = [];
                        if(strcmp($journey->getName(),'Journey') == 0){
                            foreach($journey->children('air', true) as $segmentRef){
                                if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){
                                    foreach($segmentRef->attributes() as $a => $b){
                                        $segment = $this->ListAirSegments($b, $lowFare);
//                                        dd($segment->attributes());
                                        foreach($segment->attributes() as $c => $d){
                                            if(strcmp($c, "Origin") == 0){
//                                                $flightJourney->push('From :'.$d);
//                                                array_push($flightJourney, 'From: '.$d);
                                                $flightJourney['From'] = $d;
                                            }
                                            if(strcmp($c, "Destination") == 0){
//                                                $flightJourney->push('To :'.$d);
//                                                array_push($flightJourney, 'To: '.$d);
                                                $flightJourney['To'] = $d;
                                            }
                                            if(strcmp($c, "Carrier") == 0){
//                                                $flightJourney->push('Airline :'.$d);
                                                $flightJourney['Airline'] = $d;
//                                                array_push($flightJourney, 'Airline: '.$d);
                                            }
                                            if(strcmp($c, "FlightNumber") == 0){
//                                                $flightJourney->push('Flight :'.$d);
                                                $flightJourney['Flight'] = $d;
//                                                array_push($flightJourney, 'Flight: '.$d);
                                            }
                                            if(strcmp($c, "DepartureTime") == 0){
//                                                $flightJourney->push('Depart :'.$d);
                                                $flightJourney['Depart'] = $d;
//                                                array_push($flightJourney, 'Depart: '.$d);
                                            }
                                            if(strcmp($c, "ArrivalTime") == 0){
                                                $flightJourney['Arrive'] = $d;
//                                                $flightJourney->push('Arrive :'.$d);
//                                                array_push($flightJourney, 'Arrive: '.$d);
                                            }
//                                            if(strcmp($c, "DestinationTerminal") == 0){
//                                                $flightJourney['DestinationTerminal'] = $d;
////                                                $flightJourney->push('Arrive :'.$d);
////                                                array_push($flightJourney, 'Arrive: '.$d);
//                                            }
                                        }

                                    }
                                }
                            }

                        }
                        if(count($flightJourney)){
//                            $flight->push(['Journey'=>$flightJourney]);
//                            array_push($flight,['journey'=>$flightJourney]);
                            $flight['journey'] = collect($flightJourney);
                        }
                    }

                    // Price Details
                    foreach($airPriceSol->children('air',true) as $priceInfo){
                        $flightPrice = [];
                        if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0){
                            foreach($priceInfo->attributes() as $e => $f){
                                if(strcmp($e, "ApproximateBasePrice") == 0){
//                                    $flightPrice->push('Approx. Base Price: '.$f);
                                    $flightPrice['Approx Base Price'] = $f;
//                                    array_push($flightPrice, 'Approx. Base Price: '.$f);

                                }
                                if(strcmp($e, "ApproximateTaxes") == 0){
//                                    $flightPrice->push('Approx Taxes: '.$f);
                                    $flightPrice['Approx Taxes'] = $f;
//                                    array_push($flightPrice, 'Approx. Taxes: '.$f);
                                }
                                if(strcmp($e, "ApproximateTotalPrice") == 0){
//                                    $flightPrice->push('Approx Total Value: '.$f);
                                    $flightPrice['Approx Total Value'] = $f;
//                                    array_push($flightPrice, 'Approx. Total Price: '.$f);
                                }
                                if(strcmp($e, "BasePrice") == 0){
//                                    $flightPrice->push('Base Price'.$f);
                                    $flightPrice['Base Price'] = $f;
//                                    array_push($flightPrice, 'Base Price: '.$f);
                                }
                                if(strcmp($e, "Taxes") == 0){
//                                    $flightPrice->push('Taxes '.$f);
                                    $flightPrice['Taxes'] = $f;
//                                    array_push($flightPrice, 'Taxes: '.$f);
                                }
                                if(strcmp($e, "TotalPrice") == 0){
//                                    $flightPrice->push('Total Price '.$f);
                                    $flightPrice['Total Price'] = $f;
//                                    array_push($flightPrice, 'Total Price: '.$f);
                                }

                            }
                            foreach($priceInfo->children('air',true) as $bookingInfo){
                                if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
                                    foreach($bookingInfo->attributes() as $e => $f){
                                        if(strcmp($e, "CabinClass") == 0){
//                                            $flightPrice->push('Cabin Class'.$f);
                                            $flightPrice['Cabin Class'] = $f;
//                                            array_push($flightPrice, 'Cabin Class'.$f);
                                        }
                                    }
                                }
                            }
                            foreach($priceInfo->children('air',true) as $bookingInfo){
                                if(strcmp($bookingInfo->getName(),'CancelPenalty') == 0){
                                    foreach($bookingInfo->attributes() as $e => $f){
//                                        dd($e);
                                        if(strcmp($e, "CabinClass") == 0){
                                            $flightPrice['Cabin Class'] = $f;
                                        }
                                    }
                                }
                            }

                        }
                        if(count($flightPrice)){
//                            $flight->push(['price'=>$flightPrice]);
                            $flight['price'] = collect($flightPrice);
                        }

                    }














                }
                if($flight->count()){
                    $data->push(['flight'=>collect($flight)]);
                }
            }
        }
        return $data;

    }

    public function ListAirSegments($key, $lowFare){
        foreach($lowFare->children('air',true) as $airSegmentList){
            if(strcmp($airSegmentList->getName(),'AirSegmentList') == 0){
                foreach($airSegmentList->children('air', true) as $airSegment){
                    if(strcmp($airSegment->getName(),'AirSegment') == 0){
                        foreach($airSegment->attributes() as $a => $b){
                            if(strcmp($a,'Key') == 0){
                                if(strcmp($b, $key) == 0){
                                    return $airSegment;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function SearchAirport(Request $request){
        return AirportCodes::search($request->get('q'))->select('name','code')->get()->map(function($airport){
            return $airport->name . '('. $airport->code.')';
        });
    }

    public function Book(Request $request){
//        return $request;
//        session()->put('details',$request);
        return view('flight.flight.details')->with('details',$request);
    }

    public function Passengers(Request $request){
//        dd(session()->get('details'));
        return view('flight.flight.passengerDetails')->with('details',$request);
    }

    public function Payment(Request $request){
//        return $request;
        return view('flight.flight.payment')->with('details',$request);
    }

    public function Invoice(Request $request){
//        return $request;
        return view('flight.flight.invoice')->with('details',$request);
    }

    function attemptLogin($email,$password){
        if(\Auth::attempt(["email" => $email , "password" => $password])){
            return true;
        }
        else{
            return false;
        }
    }
    public function loginAttempt(Request $request){
        if($this->attemptLogin($request->email,$request->password)){
            return User::where('email',$request->email)->first()->client;
        }
        else{
            return response()->json(['Wrong Password'])->setStatusCode(Response::HTTP_UNAUTHORIZED, Response::$statusTexts[Response::HTTP_UNAUTHORIZED]);
        }
    }




}
