<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;

class FlightsController extends Controller
{
    public function search(Request $request){
        $flightFrom =  str_replace(')','',explode('(',$request->addFrom)[1]);
        $flightTo =  str_replace(')','',explode('(',$request->addTo)[1]);
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');
        if($request->travel_class != 'All'){
            $searchLegModifier = ' <air:AirLegModifiers PreferNonStop="false">
              	<air:PreferredCabins>
              	<com:CabinClass xmlns="http://www.travelport.com/schema/common_v42_0" Type="'. $request ->travel_class.'"></com:CabinClass>
              	</air:PreferredCabins>
              </air:AirLegModifiers>';
        }
        if($request->returning_date != null) {
            $returnDate = Carbon::parse($request->returning_date)->format('Y-m-d');
            $returnSearch = '
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="'.$flightTo.'"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="'.$flightFrom.'"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="'.$returnDate.'">
            </air:SearchDepTime>
            '. $searchLegModifier.'
         </air:SearchAirLeg>';
        }

            $query = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
   <soapenv:Body>
      <air:LowFareSearchReq ReturnUpsellFare="true" TraceId="trace" AuthorizedBy="user" SolutionResult="true" TargetBranch="'.$TARGETBRANCH.'" xmlns:air="http://www.travelport.com/schema/air_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
         <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="'.$flightFrom.'"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="'.$flightTo.'"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="'.$PreferredDate.'">
            </air:SearchDepTime>
            '. $searchLegModifier.'
         </air:SearchAirLeg>
        '. $returnSearch .'
         <air:AirSearchModifiers >
            <air:PreferredProviders>
               <com:Provider Code="'.$Provider.'"/>
            </air:PreferredProviders>
         </air:AirSearchModifiers>
		 <com:SearchPassenger BookingTravelerRef="1" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0" />
         <air:AirPricingModifiers>
         <air:AccountCodes>
           <com:AccountCode xmlns:com="http://www.travelport.com/schema/common_v42_0" Code="-" />
         </air:AccountCodes>
         </air:AirPricingModifiers>
        </air:LowFareSearchReq>
   </soapenv:Body>
</soapenv:Envelope>';
            $message = <<<EOM
$query
EOM;
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
            "Content-length: ".strlen($message),
        );
//        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($soap_do, CURLOPT_POST, true );
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($soap_do);
        curl_close($soap_do);
        // return $result ;
        // echo "<pre>";
        // var_dump($result);
        // print_r($result);
        // $val=json_encode($result);
        // $val=json_decode(json_encode($result),true);
        // print_r($val);
        // return "hii";

        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($result);
        $dom->formatOutput = true;
        //call function to write request/response in file
//        outputWriter($file,$dom->saveXML());
        $content = $dom->saveXML();
        // return $content;
            //parse the Search response to get values to use in detail request
            $data = collect();
            $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
            //echo $LowFareSearchRsp;
            // return $LowFareSearchRsp;
            $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);
            // return $xml;
            if(!$xml){
                trigger_error("Encoding Error!", E_USER_ERROR);
            }
    
            $Results = $xml->children('SOAP',true);
            foreach($Results->children('SOAP',true) as $fault){
                if(strcmp($fault->getName(),'Fault') == 0){
                    trigger_error("Error occurred request/response processing!", E_USER_ERROR);
                }
            }
    
            // $count = 0;
            // return $Results;
            foreach($Results->children('air',true) as $lowFare){		
                foreach($lowFare->children('air',true) as $airPriceSol){	
                            
                    if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){		
                        // $count = $count + 1;
                        foreach($airPriceSol->children('air',true) as $journey){					
                            if(strcmp($journey->getName(),'Journey') == 0){
                                $Journey= collect();
                                $journeydetails = collect();
                                foreach($journey->children('air', true) as $segmentRef){	
                                    if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){								
                                        $details=[];
                                        foreach($segmentRef->attributes() as $a => $b){	
                                            $segment = $this->ListAirSegments($b, $lowFare);
                                            foreach($segment->attributes() as $c => $d){
                                                if(strcmp($c, "Origin") == 0){
                                                    $details["From"]=$d;
                                                }
                                                if(strcmp($c, "Destination") == 0){
                                                    $details["To"]=$d;
                                                }
                                                if(strcmp($c, "Carrier") == 0){		
                                                    $details["Airline"]=$d;								
                                                }
                                                if(strcmp($c, "FlightNumber") == 0){	
                                                    $details["Flight"]=$d;
                                                }
                                                if(strcmp($c, "DepartureTime") == 0){	
                                                    $details["Depart"]=$d;										
                                                }
                                                if(strcmp($c, "ArrivalTime") == 0){	
                                                    $details["Arrive"]=$d;
                                                }	
                                            }
                                        }
                                        $journeydetails->push($details);
                                    }
                                }	
                                $Journey->push(['journey'=>collect($journeydetails)]);				
                            }					
                        }
                       // Price Details
                        foreach($airPriceSol->children('air',true) as $priceInfo){
                            $flightPrice = [];
                            if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0){
                                foreach($priceInfo->attributes() as $e => $f){
                                    if(strcmp($e, "ApproximateBasePrice") == 0){
                                        $flightPrice['Approx Base Price'] = $f;
                                    }
                                    if(strcmp($e, "ApproximateTaxes") == 0){
                                        $flightPrice['Approx Taxes'] = $f;
                                    }
                                    if(strcmp($e, "ApproximateTotalPrice") == 0){
                                        $flightPrice['Approx Total Value'] = $f;
                                    }
                                    if(strcmp($e, "BasePrice") == 0){
                                        $flightPrice['Base Price'] = $f;
                                    }
                                    if(strcmp($e, "Taxes") == 0){
                                        $flightPrice['Taxes'] = $f;
                                    }
                                    if(strcmp($e, "TotalPrice") == 0){
                                        $flightPrice['Total Price'] = $f;
                                    }
                                }
                                foreach($priceInfo->children('air',true) as $bookingInfo){
                                    if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
                                        foreach($bookingInfo->attributes() as $e => $f){
                                            if(strcmp($e, "CabinClass") == 0){
                                                $flightPrice['Cabin Class'] = $f;
                                            }
                                        }
                                    }
                                }
                            }
                            if(count($flightPrice)){
                                $Journey->push(['price'=>$flightPrice]);
                                // $flight['price'] = collect($flightPrice);
                            }
                        }
                        $data->push(['flight'=>collect($Journey)]);
                        // file_put_contents($fileName,"\r\n", FILE_APPEND);
                    }
                }
            }
            
            return $data;
            $airlines = [];
            $stops= [];
            // return count($data);
            foreach($data as $datas){
                foreach($datas as $flights){
                    foreach($flights[0] as $journeys){
                        for ($i=0; $i < count($journeys); $i++) { 
                            echo $journeys[$i]['Airline'];
                            array_push($airlines,$journeys[$i]['Airline']);
                        }
                        array_push($stops,count($journeys));
                        // print_r($journeys) ;
                        // echo $journeys[0]['Airline'];
                        echo "<br/><br/>";
                    }
                    foreach($flights[1] as $prices){
                        echo  $prices['Total Price'];
                        print_r($prices) ;
                        echo "<br/><br/>";
                    }
                    // print_r($flight) ;
                    // echo "<br/><br/>";
                }
                // print_r($datas) ;
                echo "<br/><br/>";
            }
            // $airlines = array_unique($airlines);
            // return $airlines ;
            $stops = array_unique($stops);
            return $stops ;
            
        
    }
   

    public function ListAirSegments($key, $lowFare){
        foreach($lowFare->children('air',true) as $airSegmentList){
            if(strcmp($airSegmentList->getName(),'AirSegmentList') == 0){
                foreach($airSegmentList->children('air', true) as $airSegment){
                    if(strcmp($airSegment->getName(),'AirSegment') == 0){
                        foreach($airSegment->attributes() as $i => $j){
                            if(strcmp($i,'Key') == 0){
                                if(strcmp($j, $key) == 0){
                                    // if(strcmp($j, $key) == 0){
                                    // return $j;
                                    return $airSegment;
                                }
                            }
                        }
                    }
                    // return $airSegment;
                }
            }
        }
    }
    
    public function FlightDetails(){
        return view('flights.flight-details');
    }

    public function PassengerDetails(){
        return view('flights.passenger-details');
    }
    public function Payment(){
        return view('flights.payment');
    }
    public function ConfirmBooking(){
        return view('flights.confirm-booking');
    }
}
