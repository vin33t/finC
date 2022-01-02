<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Carbon;
use App\Models\Leads;
use App\Models\client;
use App\Models\invoice;
use App\Models\User;
use App\Models\settings;
use App\Models\Flight;
use App\Models\Passenger;

use Mail;
use App\Mail\SendCredentialsEmail;

class PaymentController extends Controller
{
    public function ShowPayment(Request $request){
        $flight=json_decode($request->flight);
        // return $flight;
        // return $request;
        // $flights=json_decode($request->flights,true);
        // return  $flights;
        // echo count($flights[0]);
        $is_has=Leads::where('email',$request->email)->get();
        if (count($is_has)>0) {
            // return $is_has;
        }else{
            // return "hii";
            $lead = new Leads;
            // $lead->user_id = Auth::user()->id;
            $lead->first_name = $request->first_name1;
            $lead->last_name = $request->last_name1;
            $lead->address = $request->add_1;
            $lead->city = $request->city;
            $lead->county = $request->county;
            $lead->postal_code = $request->postcode;
            $lead->country = $request->country;
            $lead->phone = $request->mob_no;
            $lead->email = $request->email;
            $lead->DOB = date('Y-m-d',strtotime($request->date_of_birth1));
            $lead->save();
        }
        
        $data=[];
        $datasegment='';
        if($flight!=null){
            foreach($flight[0] as $journeys){
                for ($i=0; $i < count($journeys); $i++) {
                    // return get_object_vars($journeys[$i]->Key)[0];
                    $datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                }
            }
        }else{
            $return_flights=json_decode($request->return_flights,true);
            $flights_outbound=json_decode($request->flights_outbound,true);
            $flights_inbound=json_decode($request->flights_inbound,true);
            // return $return_flights;

            foreach($flights_outbound as $journeys){
                for ($i=0; $i < count($journeys); $i++) {
                    // print_r($journeys[$i]);
                    // print_r($journeys1[$i]['Airline'][0]);
                    $datasegment.= '<air:AirSegment Key="'.$journeys[$i]['Key'][0].'" Group="'.$journeys[$i]['Group'][0].'" Carrier="'.$journeys[$i]['Airline'][0].'" FlightNumber="'.$journeys[$i]['Flight'][0].'" Origin="'.$journeys[$i]['From'][0].'" Destination="'.$journeys[$i]['To'][0].'" DepartureTime="'.$journeys[$i]['Depart'][0].'" ArrivalTime="'.$journeys[$i]['Arrive'][0].'" FlightTime="'.$journeys[$i]['FlightTime'][0].'" Distance="'.$journeys[$i]['Distance'][0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                    // $alldatasegment.= '<air:AirSegment Key="'.$journeys[$i]['Key'][0].'" Group="'.$journeys[$i]['Group'][0].'" Carrier="'.$journeys[$i]['Airline'][0].'" FlightNumber="'.$journeys[$i]['Flight'][0].'" Origin="'.$journeys[$i]['From'][0].'" Destination="'.$journeys[$i]['To'][0].'" DepartureTime="'.$journeys[$i]['Depart'][0].'" ArrivalTime="'.$journeys[$i]['Arrive'][0].'" FlightTime="'.$journeys[$i]['FlightTime'][0].'" Distance="'.$journeys[$i]['Distance'][0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                }
            }
            foreach($flights_inbound as $journeys){
                for ($i=0; $i < count($journeys); $i++) {
                    $datasegment.= '<air:AirSegment Key="'.$journeys[$i]['Key'][0].'" Group="'.$journeys[$i]['Group'][0].'" Carrier="'.$journeys[$i]['Airline'][0].'" FlightNumber="'.$journeys[$i]['Flight'][0].'" Origin="'.$journeys[$i]['From'][0].'" Destination="'.$journeys[$i]['To'][0].'" DepartureTime="'.$journeys[$i]['Depart'][0].'" ArrivalTime="'.$journeys[$i]['Arrive'][0].'" FlightTime="'.$journeys[$i]['FlightTime'][0].'" Distance="'.$journeys[$i]['Distance'][0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                    // $alldatasegment.= '<air:AirSegment Key="'.$journeys[$i]['Key'][0].'" Group="'.$journeys[$i]['Group'][0].'" Carrier="'.$journeys[$i]['Airline'][0].'" FlightNumber="'.$journeys[$i]['Flight'][0].'" Origin="'.$journeys[$i]['From'][0].'" Destination="'.$journeys[$i]['To'][0].'" DepartureTime="'.$journeys[$i]['Depart'][0].'" ArrivalTime="'.$journeys[$i]['Arrive'][0].'" FlightTime="'.$journeys[$i]['FlightTime'][0].'" Distance="'.$journeys[$i]['Distance'][0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                    // $returndatasegment.= '<air:AirSegment Key="'.$journeys[$i]['Key'][0].'" Group="'.$journeys[$i]['Group'][0].'" Carrier="'.$journeys[$i]['Airline'][0].'" FlightNumber="'.$journeys[$i]['Flight'][0].'" Origin="'.$journeys[$i]['From'][0].'" Destination="'.$journeys[$i]['To'][0].'" DepartureTime="'.$journeys[$i]['Depart'][0].'" ArrivalTime="'.$journeys[$i]['Arrive'][0].'" FlightTime="'.$journeys[$i]['FlightTime'][0].'" Distance="'.$journeys[$i]['Distance'][0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                }
            }
            
        }
        // return $datasegment;
        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;
        $travel_details=app('App\Http\Controllers\UtilityController')->TravelDetailsDatasagment($var_adults,$var_children,$var_infant);
        // return $travel_details;
        $var_country_code=$request->country_code;
        $var_currency_code=DB::table('countries')->where('country_code',$var_country_code)->value('currency_code');
        $currency_xml='';
        if($var_currency_code!=''){
            $currency_xml='<air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="'.$var_currency_code.'">
            <air:BrandModifiers ModifierType="FareFamilyDisplay" />
            </air:AirPricingModifiers>';
        }else{
            $currency_xml='<air:AirPricingModifiers/>'; 
        }


        $CREDENTIALS = app('App\Http\Controllers\UniversalConfigAPIController')->CREDENTIALS();
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
        // $TARGETBRANCH = 'P7141733';
        // $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        // $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');
        if($flight!=null){
            // return "hii";
        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
           <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
              <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirItinerary>
                '.$datasegment.'
              </air:AirItinerary>
              '.$currency_xml.$travel_details.'
              <air:AirPricingCommand/>
           </air:AirPriceReq>
        </soap:Body>
     </soap:Envelope>';
    // return $query;
            $message = <<<EOM
$query
EOM;
            $auth = base64_encode($CREDENTIALS);
            // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
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
            curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
            curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
            curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($soap_do);
            curl_close($soap_do);
            // return $return;
            $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
            // return $object ;
            // $data=$this->XMLData($object);
            $data =app('App\Http\Controllers\XMlToParseDataController')->AirPrice($object);
            
            // return $data;
        }else{
        
            // return $returndatasegment;
            // return "hii";
            $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
               <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
                  <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
                  <air:AirItinerary>
                    '.$datasegment.'
                  </air:AirItinerary>
                  <air:AirPricingModifiers/>
                  '.$travel_details.'
                  <air:AirPricingCommand/>
               </air:AirPriceReq>
            </soap:Body>
         </soap:Envelope>';
        // return $query;
        // $file='AirpriceReqXML';
        // file_put_contents($file, $query);
                $message = <<<EOM
$query
EOM;
            $auth = base64_encode($CREDENTIALS);
            // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
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
            curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
            curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
            curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
            $return = curl_exec($soap_do);
            curl_close($soap_do);
            // return $return;
            // $file='AirpriceResXML';
            // file_put_contents($file, $return);
            $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
            // return $object;
            // $flight_data=$this->XMLData_Round($object);
            $flight_data =app('App\Http\Controllers\XMlToParseDataController')->AirPrice($object);
            
            // return $flight_data;
            
            return view('flights.payment',[
                'data'=>$data,
                'return_flights'=>$flight_data,
                'per_flight_details'=>$request
            ]);
        }

        // return $data;

        return view('flights.payment',[
            'data'=>$data,
            // 'return_flights'=>$return_flight,
            'per_flight_details'=>$request
        ]);
    } 

    public function XMLData_old($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                if(count($jsons1)>1){
                    foreach($jsons1 as $jsons2){
                        // print_r($jsons2);
                        // echo "<br/>";
                        if(count($jsons2)>1){
                            foreach($jsons2 as $jsons3){
                                // print_r($jsons3);
                                // echo "<br/><br/><br/>";
                                if(is_array($jsons3)){
                                    // echo $count." count";
                                        // echo "<br/>"; 
                                    if($count==3){
                                        // print_r($jsons3);
                                        // echo "<br/><br/>"; 
                                        $count2=1;
                                        foreach($jsons3 as $fdn => $jsons4){
                                            // echo "count";
                                            // print_r($jsons4);
                                            // echo "<br/><br/>"; 
                                            if(strcmp($fdn, "$") == 0){
                                                // $details1["key"]=$jsons5;
                                                return $data;
                                                
                                                // return view('flights.flight-details',[
                                                //     'per_flight_details'=>$request,
                                                //     'data'=>$data
                                                // ]);
                                            }else{
                                                $journey=collect();     
                                                if($count2==2){
                                                    // print_r($jsons4);
                                                    // echo "<br/><br/>"; 
                                                    $details1=[];
                                                    foreach($jsons4 as $g => $jsons5){
                                                        //  print_r($jsons5);
                                                        //     echo "<br/>";
                                                        if(is_string($jsons5)){
                                                            if(strcmp($g, "@Key") == 0){
                                                                $details1["key"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Group") == 0){
                                                                $details1["Group"] =$jsons5;
                                                            }
                                                            if(strcmp($g, "@Carrier") == 0){
                                                                $details1["Carrier"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@FlightNumber") == 0){
                                                                $details1["FlightNumber"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Origin") == 0){
                                                                $details1["Origin"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Destination") == 0){
                                                                $details1["Destination"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@DepartureTime") == 0){
                                                                $details1["DepartureTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@ArrivalTime") == 0){
                                                                $details1["ArrivalTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@FlightTime") == 0){
                                                                $details1["FlightTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@TravelTime") == 0){
                                                                $details1["TravelTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Distance") == 0){
                                                                $details1["Distance"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@ClassOfService") == 0){
                                                                $details1["ClassOfService"]=$jsons5;
                                                            }
                                                        }else{
                                                            $details=[];
                                                            foreach($jsons5 as $k => $jsons6){
                                                                // print_r($jsons6);
                                                                // echo "<br/>";
                                                                if(is_string($jsons6)){
                                                                    if(strcmp($k, "@Key") == 0){
                                                                        $details["key"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Group") == 0){
                                                                        $details["Group"] =$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Carrier") == 0){
                                                                        $details["Carrier"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@FlightNumber") == 0){
                                                                        $details["FlightNumber"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Origin") == 0){
                                                                        $details["Origin"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Destination") == 0){
                                                                        $details["Destination"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@DepartureTime") == 0){
                                                                        $details["DepartureTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@ArrivalTime") == 0){
                                                                        $details["ArrivalTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@FlightTime") == 0){
                                                                        $details["FlightTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@TravelTime") == 0){
                                                                        $details["TravelTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Distance") == 0){
                                                                        $details["Distance"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@ClassOfService") == 0){
                                                                        $details["ClassOfService"]=$jsons6;
                                                                    }
                                                                    // $details["changeofplane"] =$jsons6;
                                                                    // $details["optionalservicesindicator"]=$jsons6; 
                                                                    // $details["availabilitysource"] =$jsons6;
                                                                    // $details["polledavailabilityoption"] =$jsons6;
                                                                    // print_r($jsons6);
                                                                    // echo "<br/>";
                                                                    // $journey->push($details);   
                                                                    // print_r($k." - ".$jsons6);
                                                                    // echo "<br/>";  

                                                                }
                                                            }
                                                            if(empty($details1) && !empty($details)){
                                                                $journey->push($details); 
                                                            }    
                                                        }
                                                    }
                                                    if(!empty($details1)){
                                                        $journey->push($details1);     
                                                    }
                                                    // return $journey;
                                                    $data->push(["journey"=>collect($journey)]);     
                                                }
                                            }
                                            $count2++;
                                        }

                                    }
                                    if($count==4){
                                        // print_r($jsons3);
                                        // echo "<br/><br/>";
                                        foreach($jsons3 as $jsons13){
                                            // print_r($jsons13);
                                            // echo "<br/><br/>";
                                            if(count($jsons13)==2){
                                                // print_r($jsons13);
                                                // echo "<br/><br/>";
                                                $count1=1;
                                                foreach($jsons13 as $jsons14){
                                                    // echo "count";
                                                    // print_r($jsons14);
                                                    // echo "<br/><br/><br/>";
                                                    if($count1==1){
                                                        // echo "count";
                                                        // print_r($jsons14);
                                                        // echo "<br/><br/><br/>";
                                                        $price=[];
                                                        $count15=1;
                                                        foreach($jsons14 as $p => $jsons15){
                                                            // echo $count15;
                                                            // print_r($jsons15);
                                                            // echo "<br/><br/><br/>";
                                                            if(is_string($jsons15)){
                                                                if(strcmp($p, "@Key") == 0){
                                                                    $price["Key"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@TotalPrice") == 0){
                                                                    $price["TotalPrice"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@BasePrice") == 0){
                                                                    $price["BasePrice"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@ApproximateTotalPrice") == 0){
                                                                    $price["ApproximateTotalPrice"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@ApproximateBasePrice") == 0){
                                                                    $price["ApproximateBasePrice"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@EquivalentBasePrice") == 0){
                                                                    $price["EquivalentBasePrice"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@Taxes") == 0){
                                                                    $price["Taxes"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@Fees") == 0){
                                                                    $price["Fees"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@ApproximateTaxes") == 0){
                                                                    $price["ApproximateTaxes"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@QuoteDate") == 0){
                                                                    $price["QuoteDate"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@FareInfoRef") == 0){
                                                                    $price["FareInfoRef"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@RuleNumber") == 0){
                                                                    $price["RuleNumber"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@Source") == 0){
                                                                    $price["Source"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@TariffNumber") == 0){
                                                                    $price["TariffNumber"] =$jsons15;
                                                                }
                                                            }else{
                                                                if($count15==13){
                                                                    // echo "hii";
                                                                    // print_r($jsons15);
                                                                    // echo "<br/><br/><br/>";
                                                                    $count16=1;
                                                                    $details4=[];
                                                                    $AirPricingInfo=[];
                                                                    foreach($jsons15 as $aPf=> $jsons16){
                                                                        // echo $count16;
                                                                        // print_r($jsons16);
                                                                        // echo "<br/><br/><br/>"; 
                                                                        if(is_string($jsons16)){
                                                                            if(strcmp($aPf, "@Key") == 0){
                                                                                $AirPricingInfo["Key"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@TotalPrice") == 0){
                                                                                $AirPricingInfo["TotalPrice"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@BasePrice") == 0){
                                                                                $AirPricingInfo["BasePrice"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@ApproximateTotalPrice") == 0){
                                                                                $AirPricingInfo["ApproximateTotalPrice"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@ApproximateBasePrice") == 0){
                                                                                $AirPricingInfo["ApproximateBasePrice"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@EquivalentBasePrice") == 0){
                                                                                $AirPricingInfo["EquivalentBasePrice"] =$jsons16;
                                                                            }  
                                                                            if(strcmp($aPf, "@ApproximateTaxes") == 0){
                                                                                $AirPricingInfo["ApproximateTaxes"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@Taxes") == 0){
                                                                                $AirPricingInfo["Taxes"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@LatestTicketingTime") == 0){
                                                                                $AirPricingInfo["LatestTicketingTime"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@PricingMethod") == 0){
                                                                                $AirPricingInfo["PricingMethod"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@Refundable") == 0){
                                                                                $AirPricingInfo["Refundable"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@IncludesVAT") == 0){
                                                                                $AirPricingInfo["IncludesVAT"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@ETicketability") == 0){
                                                                                $AirPricingInfo["ETicketability"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@PlatingCarrier") == 0){
                                                                                $AirPricingInfo["PlatingCarrier"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@ProviderCode") == 0){
                                                                                $AirPricingInfo["ProviderCode"] =$jsons16;
                                                                            }
                                                                        }
                                                                        if($count16==17){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            $FareInfo=[];
                                                                            $count50=1;
                                                                            foreach($jsons16 as $fI => $jsons17){
                                                                                // echo $count50;
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(is_string($jsons17)){
                                                                                    // print_r($fI."-".$jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    if(strcmp($fI, "@Key") == 0){
                                                                                        $FareInfo["Key"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($fI, "@FareBasis") == 0){
                                                                                        $FareInfo["FareBasis"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                                                        $FareInfo["PassengerTypeCode"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@Origin") == 0){
                                                                                        $FareInfo["Origin"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@Destination") == 0){
                                                                                        $FareInfo["Destination"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@EffectiveDate") == 0){
                                                                                        $FareInfo["EffectiveDate"] =$jsons17;
                                                                                    }  
                                                                                    if(strcmp($fI, "@DepartureDate") == 0){
                                                                                        $FareInfo["DepartureDate"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@Amount") == 0){
                                                                                        $FareInfo["Amount"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@NegotiatedFare") == 0){
                                                                                        $FareInfo["NegotiatedFare"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@NotValidBefore") == 0){
                                                                                        $FareInfo["NotValidBefore"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@TaxAmount") == 0){
                                                                                        $FareInfo["TaxAmount"] =$jsons17;
                                                                                    } 
                                                                                }
                                                                                if($count50==16){
                                                                                    $FareRuleKey=[];
                                                                                    foreach($jsons17 as $frk => $jsons18){
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(is_string($jsons18)){
                                                                                            // print_r($frk." - ".$jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(strcmp($frk, "@FareInfoRef") == 0){
                                                                                                $FareRuleKey["FareInfoRef"] =$jsons18;
                                                                                            } 
                                                                                            if(strcmp($frk, "@ProviderCode") == 0){
                                                                                                $FareRuleKey["ProviderCode"] =$jsons18;
                                                                                            } 
                                                                                            if(strcmp($frk, "$") == 0){
                                                                                                $FareRuleKey["FareRuleKeyValue"] =$jsons18;
                                                                                            } 
                                                                                        }
                                                                                    }
                                                                                }
                                                                                $count50++; 
                                                                            }
                                                                        }
                                                                        if($count16==18){
                                                                            $BookingInfo=[];
                                                                            foreach($jsons16 as $bki => $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(is_string($jsons17)){
                                                                                    // print_r($bki."-".$jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    if(strcmp($bki, "@BookingCode") == 0){
                                                                                        $BookingInfo["BookingCode"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@CabinClass") == 0){
                                                                                        $BookingInfo["CabinClass"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@FareInfoRef") == 0){
                                                                                        $BookingInfo["FareInfoRef"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@SegmentRef") == 0){
                                                                                        $BookingInfo["SegmentRef"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@HostTokenRef") == 0){
                                                                                        $BookingInfo["HostTokenRef"] =$jsons17;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==19){
                                                                            
                                                                            // print_r($jsons16);
                                                                            $TaxInfo=collect();
                                                                            foreach($jsons16 as $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                $TaxInfo1=[];
                                                                                foreach($jsons17 as $tki => $jsons18){
                                                                                    if(is_string($jsons18)){
                                                                                        // print_r($tki."-".$jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(strcmp($tki, "@Category") == 0){
                                                                                            $TaxInfo1["Category"] =$jsons18;
                                                                                        }
                                                                                        if(strcmp($tki, "@Amount") == 0){
                                                                                            $TaxInfo1["Amount"] =$jsons18;
                                                                                        }
                                                                                        if(strcmp($tki, "@Key") == 0){
                                                                                            $TaxInfo1["Key"] =$jsons18;
                                                                                        }
                                                                                    
                                                                                    }
                                                                                }
                                                                                $TaxInfo->push($TaxInfo1);

                                                                            }
                                                                        }
                                                                        if($count16==20){
                                                                            $FareCalc=[];
                                                                            foreach($jsons16 as $fcc => $jsons17){
                                                                                // print_r($jsons17);
                                                                                if(is_string($jsons17)){
                                                                                    if(strcmp($fcc, "$") == 0){
                                                                                        $FareCalc["FareCalc"] =$jsons17;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==21){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            $PassengerType=[];
                                                                            foreach($jsons16 as $pc => $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(is_string($jsons17)){
                                                                                    if(strcmp($pc, "@Code") == 0){
                                                                                        $PassengerType["Code"] =$jsons17;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==22){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            foreach($jsons16 as $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons17 as $c=> $jsons18){
                                                                                    if(is_string($jsons18)){
                                                                                        if(strcmp($c, "$") == 0){
                                                                                            $details4["changepenalty"]=$jsons18;
                                                                                        }
                                                                                        // print_r($c."- " .$jsons18);
                                                                                        // echo "<br/><br/><br/>"; 
                                                                                    }
                                                                                    
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==23){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            foreach($jsons16 as $jsons19){
                                                                                // print_r($jsons19);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons19 as $cc=> $jsons20){
                                                                                    if(is_string($jsons20)){
                                                                                        if(strcmp($cc, "$") == 0){
                                                                                            $details4["cancelpenalty"]=$jsons20;
                                                                                        }
                                                                                        // print_r($c."- " .$jsons20);
                                                                                        // echo "<br/><br/><br/>"; 
                                                                                    }
                                                                                    
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==24){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            $count17=1;   
                                                                            foreach($jsons16 as $jsons17){
                                                                                // echo $count17;
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>"; 
                                                                                if($count17==2){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count18=1;
                                                                                    foreach($jsons17 as $jsons18){
                                                                                        // echo $count18;
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if($count18==7){
                                                                                            // print_r($jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count19=1;
                                                                                            foreach($jsons18 as $jsons19){
                                                                                                // echo $count19;
                                                                                                // print_r($jsons19);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if($count19==2){
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count20=1;
                                                                                                    foreach($jsons19 as $jsons20){
                                                                                                        // print_r($jsons20);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if($count20==1){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            foreach($jsons20 as $bg=>$jsons21){
                                                                                                                // print_r($jsons21);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if(strcmp($bg, "$") == 0){	
                                                                                                                    $details4["baggageallowanceinfo"]=$jsons21;
                                                                                                                }	
                                                                                                            }
                                                                                                        }
                                                                                                        $count20++;
                                                                                                    }
                                                                                                }
                                                                                                $count19++;
                                                                                            }
                                                                                        }
                                                                                        $count18++;
                                                                                    }
                                                                                }
                                                                                if($count17==3){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count21=1;
                                                                                    foreach($jsons17 as $jsons18){
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        // if($count21==5){  //non stop flight  
                                                                                        if($count21==2 && is_array($jsons18)){
                                                                                            // print_r($jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count22=1;
                                                                                            foreach($jsons18 as $jsons19){
                                                                                                // echo $count22;
                                                                                                // print_r($jsons19);
                                                                                                // echo "<br/><br/><br/>"; 
                                                                                                if($count22==5){
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count23=1;
                                                                                                    foreach($jsons19 as $jsons20){
                                                                                                        // print_r($jsons20);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if($count23==2){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>"; 
                                                                                                            foreach($jsons20 as $cbb=>$jsons21){
                                                                                                                if(is_string($jsons21)){
                                                                                                                    // print_r($cbb."-".$jsons21);
                                                                                                                    // echo "<br/><br/><br/>";
                                                                                                                    if(strcmp($cbb, "$") == 0){	
                                                                                                                        $details4["carryonallowanceinfo"]=$jsons21;
                                                                                                                    }	
                                                                                                                }
                                                                                                                
                                                                                                            }
                                                                                                        }
                                                                                                        $count23++;
                                                                                                    }
                                                                                                }
                                                                                                $count22++;
                                                                                            }
                                                                                        }else{
                                                                                            if($count21==5){
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                $count25=1;
                                                                                                foreach($jsons18 as $jsons19){
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    if($count25==2){
                                                                                                        foreach($jsons19 as $cbb => $jsons20){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            if(is_string($jsons20)){
                                                                                                                // print_r($cbb."-".$jsons21);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if(strcmp($cbb, "$") == 0){	
                                                                                                                    $details4["carryonallowanceinfo"]=$jsons20;
                                                                                                                }	
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    $count25++;
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        $count21++;
                                                                                    }
                                                                                }
                                                                                
                                                                                $count17++;
                                                                            }
                                                                        }
                                                                        $count16++;
                                                                    }
                                                                    // return $details4 ;
                                                                    $data->push(["details"=>$details4]);
                                                                }
                                                            }
                                                            if($count15==15){
                                                                // print_r($jsons15);
                                                                // echo "<br/><br/><br/>";  
                                                                $HostToken=[];
                                                                foreach($jsons15 as $hst => $jsons16){
                                                                    if(is_string($jsons16)){
                                                                        if(strcmp($hst, "@Key") == 0){
                                                                            $HostToken["Key"] =$jsons16;
                                                                        }
                                                                        if(strcmp($hst, "$") == 0){
                                                                            $HostToken["HostTokenValue"] =$jsons16;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $count15++;
                                                        }
                                                        // return $price;
                                                        $data->push(["price"=>$price]);
                                                        $data->push(["AirPricingInfo"=>$AirPricingInfo]);
                                                        $data->push(["FareInfo"=>$FareInfo]);
                                                        $data->push(["FareRuleKey"=>$FareRuleKey]);
                                                        $data->push(["BookingInfo"=>$BookingInfo]);
                                                        $data->push(["HostToken"=>$HostToken]);
                                                        $data->push(["TaxInfo"=>$TaxInfo]);
                                                        $data->push(["FareCalc"=>$FareCalc]);
                                                        $data->push(["PassengerType"=>$PassengerType]);
                                                    }
                                                    $count1++;
                                                }
                                            }
                                        }
                                        // print_r($jsons3);
                                        // echo "<br/>"; 
                                    }
                                    $count++;
                                }
                               
                            }
                            // print_r($jsons2);
                            // echo "<br/><br/><br/><br/><br/>"; 
                        }
                    } 
                }
            }
        }
        return $data;
    }

    public function XMLData_Round($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
                    foreach($jsons as $jsons1){
                        if(count($jsons1)>1){
                            foreach($jsons1 as $jsons2){
                                // print_r($jsons2);
                                // echo "<br/>";
                                if(count($jsons2)>1){
                                    foreach($jsons2 as $jsons3){
                                        // print_r($jsons3);
                                        // echo "<br/><br/><br/>";
                                        if(is_array($jsons3)){
                                            // echo $count." count";
                                                // echo "<br/>"; 
                                            if($count==3){
                                                // print_r($jsons3);
                                                // echo "<br/><br/>"; 
                                                $count2=1;
                                                foreach($jsons3 as $fdn => $jsons4){
                                                    // echo "count";
                                                    // print_r($jsons4);
                                                    // echo "<br/><br/>"; 
                                                    if(strcmp($fdn, "$") == 0){
                                                        // $details1["key"]=$jsons5;
                                                        return $data;
                                                        
                                                        // return view('flights.flight-details',[
                                                        //     'per_flight_details'=>$request,
                                                        //     'data'=>$data
                                                        // ]);
                                                    }else{
                                                        $journey=collect();     
                                                        if($count2==2){
                                                            // print_r($jsons4);
                                                            // echo "<br/><br/>"; 
                                                            $details1=[];
                                                            foreach($jsons4 as $g => $jsons5){
                                                                //  print_r($jsons5);
                                                                //     echo "<br/>";
                                                                if(is_string($jsons5)){
                                                                    if(strcmp($g, "@Key") == 0){
                                                                        $details1["key"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@Group") == 0){
                                                                        $details1["Group"] =$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@Carrier") == 0){
                                                                        $details1["Carrier"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@FlightNumber") == 0){
                                                                        $details1["FlightNumber"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@Origin") == 0){
                                                                        $details1["Origin"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@Destination") == 0){
                                                                        $details1["Destination"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@DepartureTime") == 0){
                                                                        $details1["DepartureTime"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@ArrivalTime") == 0){
                                                                        $details1["ArrivalTime"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@FlightTime") == 0){
                                                                        $details1["FlightTime"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@TravelTime") == 0){
                                                                        $details1["TravelTime"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@Distance") == 0){
                                                                        $details1["Distance"]=$jsons5;
                                                                    }
                                                                    if(strcmp($g, "@ClassOfService") == 0){
                                                                        $details1["ClassOfService"]=$jsons5;
                                                                    }
                                                                }else{
                                                                    $details=[];
                                                                    foreach($jsons5 as $k => $jsons6){
                                                                        // print_r($jsons6);
                                                                        // echo "<br/>";
                                                                        if(is_string($jsons6)){
                                                                            if(strcmp($k, "@Key") == 0){
                                                                                $details["key"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@Group") == 0){
                                                                                $details["Group"] =$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@Carrier") == 0){
                                                                                $details["Carrier"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@FlightNumber") == 0){
                                                                                $details["FlightNumber"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@Origin") == 0){
                                                                                $details["Origin"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@Destination") == 0){
                                                                                $details["Destination"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@DepartureTime") == 0){
                                                                                $details["DepartureTime"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@ArrivalTime") == 0){
                                                                                $details["ArrivalTime"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@FlightTime") == 0){
                                                                                $details["FlightTime"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@TravelTime") == 0){
                                                                                $details["TravelTime"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@Distance") == 0){
                                                                                $details["Distance"]=$jsons6;
                                                                            }
                                                                            if(strcmp($k, "@ClassOfService") == 0){
                                                                                $details["ClassOfService"]=$jsons6;
                                                                            }
                                                                            // $details["changeofplane"] =$jsons6;
                                                                            // $details["optionalservicesindicator"]=$jsons6; 
                                                                            // $details["availabilitysource"] =$jsons6;
                                                                            // $details["polledavailabilityoption"] =$jsons6;
                                                                            // print_r($jsons6);
                                                                            // echo "<br/>";
                                                                            // $journey->push($details);   
                                                                            // print_r($k." - ".$jsons6);
                                                                            // echo "<br/>";  
        
                                                                        }
                                                                    }
                                                                    if(empty($details1) && !empty($details)){
                                                                        $journey->push($details); 
                                                                    }    
                                                                }
                                                            }
                                                            if(!empty($details1)){
                                                                $journey->push($details1);     
                                                            }
                                                            // return $journey;
                                                            $data->push(["journey"=>collect($journey)]);     
                                                        }
                                                    }
                                                    $count2++;
                                                }
        
                                            }
                                            if($count==4){
                                                // print_r($jsons3);
                                                // echo "<br/><br/>";
                                                foreach($jsons3 as $jsons13){
                                                    // print_r($jsons13);
                                                    // echo "<br/><br/>";
                                                    if(count($jsons13)==2){
                                                        // print_r($jsons13);
                                                        // echo "<br/><br/>";
                                                        $count1=1;
                                                        foreach($jsons13 as $jsons14){
                                                            // echo "count";
                                                            // print_r($jsons14);
                                                            // echo "<br/><br/><br/>";
                                                            if($count1==1){
                                                                // echo "count";
                                                                // print_r($jsons14);
                                                                // echo "<br/><br/><br/>";
                                                                $price=[];
                                                                $count15=1;
                                                                foreach($jsons14 as $p => $jsons15){
                                                                    // echo $count15;
                                                                    // print_r($jsons15);
                                                                    // echo "<br/><br/><br/>";
                                                                    if(is_string($jsons15)){
                                                                        if(strcmp($p, "@Key") == 0){
                                                                            $price["Key"]=$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@TotalPrice") == 0){
                                                                            $price["TotalPrice"]=$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@BasePrice") == 0){
                                                                            $price["BasePrice"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@ApproximateTotalPrice") == 0){
                                                                            $price["ApproximateTotalPrice"]=$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@ApproximateBasePrice") == 0){
                                                                            $price["ApproximateBasePrice"]=$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@EquivalentBasePrice") == 0){
                                                                            $price["EquivalentBasePrice"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@Taxes") == 0){
                                                                            $price["Taxes"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@Fees") == 0){
                                                                            $price["Fees"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@ApproximateTaxes") == 0){
                                                                            $price["ApproximateTaxes"]=$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@QuoteDate") == 0){
                                                                            $price["QuoteDate"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@FareInfoRef") == 0){
                                                                            $price["FareInfoRef"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@RuleNumber") == 0){
                                                                            $price["RuleNumber"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@Source") == 0){
                                                                            $price["Source"] =$jsons15;
                                                                        }
                                                                        if(strcmp($p, "@TariffNumber") == 0){
                                                                            $price["TariffNumber"] =$jsons15;
                                                                        }
                                                                    }else{
                                                                        if($count15==13){
                                                                            // echo "hii";
                                                                            // print_r($jsons15);
                                                                            // echo "<br/><br/><br/>";
                                                                            $count16=1;
                                                                            $details4=[];
                                                                            $AirPricingInfo=[];
                                                                            foreach($jsons15 as $aPf=> $jsons16){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>"; 
                                                                                if(is_string($jsons16)){
                                                                                    if(strcmp($aPf, "@Key") == 0){
                                                                                        $AirPricingInfo["Key"] =$jsons16;
                                                                                    }
                                                                                    if(strcmp($aPf, "@TotalPrice") == 0){
                                                                                        $AirPricingInfo["TotalPrice"] =$jsons16;
                                                                                    }
                                                                                    if(strcmp($aPf, "@BasePrice") == 0){
                                                                                        $AirPricingInfo["BasePrice"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@ApproximateTotalPrice") == 0){
                                                                                        $AirPricingInfo["ApproximateTotalPrice"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@ApproximateBasePrice") == 0){
                                                                                        $AirPricingInfo["ApproximateBasePrice"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@EquivalentBasePrice") == 0){
                                                                                        $AirPricingInfo["EquivalentBasePrice"] =$jsons16;
                                                                                    }  
                                                                                    if(strcmp($aPf, "@ApproximateTaxes") == 0){
                                                                                        $AirPricingInfo["ApproximateTaxes"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@Taxes") == 0){
                                                                                        $AirPricingInfo["Taxes"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@LatestTicketingTime") == 0){
                                                                                        $AirPricingInfo["LatestTicketingTime"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@PricingMethod") == 0){
                                                                                        $AirPricingInfo["PricingMethod"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@Refundable") == 0){
                                                                                        $AirPricingInfo["Refundable"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@IncludesVAT") == 0){
                                                                                        $AirPricingInfo["IncludesVAT"] =$jsons16;
                                                                                    }
                                                                                    if(strcmp($aPf, "@ETicketability") == 0){
                                                                                        $AirPricingInfo["ETicketability"] =$jsons16;
                                                                                    }
                                                                                    if(strcmp($aPf, "@PlatingCarrier") == 0){
                                                                                        $AirPricingInfo["PlatingCarrier"] =$jsons16;
                                                                                    } 
                                                                                    if(strcmp($aPf, "@ProviderCode") == 0){
                                                                                        $AirPricingInfo["ProviderCode"] =$jsons16;
                                                                                    }
                                                                                }
                                                                                if($count16==17){
                                                                                    // echo $count16;
                                                                                    // print_r($jsons16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $FareInfo1=collect();
                                                                                    $FareRuleKey1=collect();
                                                                                    foreach($jsons16 as $jsonss16) {
                                                                                        // echo $count16;
                                                                                        // print_r($jsonss16);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        $FareInfo=[];
                                                                                        $count50=1;
                                                                                        foreach($jsonss16 as $fI => $jsons17){
                                                                                            // echo $count50;
                                                                                            // print_r($jsons17);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(is_string($jsons17)){
                                                                                                // print_r($fI."-".$jsons17);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if(strcmp($fI, "@Key") == 0){
                                                                                                    $FareInfo["Key"] =$jsons17;
                                                                                                }
                                                                                                if(strcmp($fI, "@FareBasis") == 0){
                                                                                                    $FareInfo["FareBasis"] =$jsons17;
                                                                                                }
                                                                                                if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                                                                    $FareInfo["PassengerTypeCode"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@Origin") == 0){
                                                                                                    $FareInfo["Origin"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@Destination") == 0){
                                                                                                    $FareInfo["Destination"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@EffectiveDate") == 0){
                                                                                                    $FareInfo["EffectiveDate"] =$jsons17;
                                                                                                }  
                                                                                                if(strcmp($fI, "@DepartureDate") == 0){
                                                                                                    $FareInfo["DepartureDate"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@Amount") == 0){
                                                                                                    $FareInfo["Amount"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@NegotiatedFare") == 0){
                                                                                                    $FareInfo["NegotiatedFare"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@NotValidBefore") == 0){
                                                                                                    $FareInfo["NotValidBefore"] =$jsons17;
                                                                                                } 
                                                                                                if(strcmp($fI, "@TaxAmount") == 0){
                                                                                                    $FareInfo["TaxAmount"] =$jsons17;
                                                                                                } 
                                                                                            }
                                                                                            if($count50==16){
                                                                                                $FareRuleKey=[];
                                                                                                foreach($jsons17 as $frk => $jsons18){
                                                                                                    // print_r($jsons18);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    if(is_string($jsons18)){
                                                                                                        // print_r($frk." - ".$jsons18);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if(strcmp($frk, "@FareInfoRef") == 0){
                                                                                                            $FareRuleKey["FareInfoRef"] =$jsons18;
                                                                                                        } 
                                                                                                        if(strcmp($frk, "@ProviderCode") == 0){
                                                                                                            $FareRuleKey["ProviderCode"] =$jsons18;
                                                                                                        } 
                                                                                                        if(strcmp($frk, "$") == 0){
                                                                                                            $FareRuleKey["FareRuleKeyValue"] =$jsons18;
                                                                                                        } 
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            $count50++; 
                                                                                        }
                                                                                        $FareInfo1->push($FareInfo);
                                                                                        $FareRuleKey1->push($FareRuleKey);
                                                                                    }
                                                                                }
                                                                                if($count16==18){
                                                                                    // echo $count16;
                                                                                    // print_r($jsons16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $BookingInfo=collect();
                                                                                    foreach($jsons16 as $jsonss16) {
                                                                                        $BookingInfo1=[];
                                                                                        foreach($jsonss16 as $bki => $jsons17){
                                                                                            // print_r($jsons17);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(is_string($jsons17)){
                                                                                                // print_r($bki."-".$jsons17);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if(strcmp($bki, "@BookingCode") == 0){
                                                                                                    $BookingInfo1["BookingCode"] =$jsons17;
                                                                                                }
                                                                                                if(strcmp($bki, "@CabinClass") == 0){
                                                                                                    $BookingInfo1["CabinClass"] =$jsons17;
                                                                                                }
                                                                                                if(strcmp($bki, "@FareInfoRef") == 0){
                                                                                                    $BookingInfo1["FareInfoRef"] =$jsons17;
                                                                                                }
                                                                                                if(strcmp($bki, "@SegmentRef") == 0){
                                                                                                    $BookingInfo1["SegmentRef"] =$jsons17;
                                                                                                }
                                                                                                if(strcmp($bki, "@HostTokenRef") == 0){
                                                                                                    $BookingInfo1["HostTokenRef"] =$jsons17;
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        $BookingInfo->push($BookingInfo1); 
                                                                                    }
                                                                                }
                                                                                if($count16==19){
                                                                                    
                                                                                    // print_r($jsons16);
                                                                                    $TaxInfo=collect();
                                                                                    foreach($jsons16 as $jsons17){
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        $TaxInfo1=[];
                                                                                        foreach($jsons17 as $tki => $jsons18){
                                                                                            if(is_string($jsons18)){
                                                                                                // print_r($tki."-".$jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if(strcmp($tki, "@Category") == 0){
                                                                                                    $TaxInfo1["Category"] =$jsons18;
                                                                                                }
                                                                                                if(strcmp($tki, "@Amount") == 0){
                                                                                                    $TaxInfo1["Amount"] =$jsons18;
                                                                                                }
                                                                                                if(strcmp($tki, "@Key") == 0){
                                                                                                    $TaxInfo1["Key"] =$jsons18;
                                                                                                }
                                                                                            
                                                                                            }
                                                                                        }
                                                                                        $TaxInfo->push($TaxInfo1);
        
                                                                                    }
                                                                                }
                                                                                if($count16==20){
                                                                                    $FareCalc=[];
                                                                                    foreach($jsons16 as $fcc => $jsons17){
                                                                                        // print_r($jsons17);
                                                                                        if(is_string($jsons17)){
                                                                                            if(strcmp($fcc, "$") == 0){
                                                                                                $FareCalc["FareCalc"] =$jsons17;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                if($count16==21){
                                                                                    // echo $count16;
                                                                                    // print_r($jsons16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $PassengerType=[];
                                                                                    foreach($jsons16 as $pc => $jsons17){
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(is_string($jsons17)){
                                                                                            if(strcmp($pc, "@Code") == 0){
                                                                                                $PassengerType["Code"] =$jsons17;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                                if($count16==22){
                                                                                    // echo $count16;
                                                                                    // print_r($jsons16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    foreach($jsons16 as $jsons17){
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        foreach($jsons17 as $c=> $jsons18){
                                                                                            if(is_string($jsons18)){
                                                                                                if(strcmp($c, "$") == 0){
                                                                                                    $details4["changepenalty"]=$jsons18;
                                                                                                }
                                                                                                // print_r($c."- " .$jsons18);
                                                                                                // echo "<br/><br/><br/>"; 
                                                                                            }
                                                                                            
                                                                                        }
                                                                                    }
                                                                                }
                                                                                if($count16==23){
                                                                                    // echo $count16;
                                                                                    // print_r($jsons16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    foreach($jsons16 as $jsons19){
                                                                                        // print_r($jsons19);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        foreach($jsons19 as $cc=> $jsons20){
                                                                                            if(is_string($jsons20)){
                                                                                                if(strcmp($cc, "$") == 0){
                                                                                                    $details4["cancelpenalty"]=$jsons20;
                                                                                                }
                                                                                                // print_r($c."- " .$jsons20);
                                                                                                // echo "<br/><br/><br/>"; 
                                                                                            }
                                                                                            
                                                                                        }
                                                                                    }
                                                                                }
                                                                                if($count16==24){
                                                                                    // echo $count16;
                                                                                    // print_r($jsons16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count17=1;   
                                                                                    foreach($jsons16 as $jsons17){
                                                                                        // echo $count17;
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>"; 
                                                                                        if($count17==2){
                                                                                            // print_r($jsons17);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count18=1;
                                                                                            foreach($jsons17 as $jsons18){
                                                                                                // echo $count18;
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if($count18==7){
                                                                                                    // print_r($jsons18);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count19=1;
                                                                                                    foreach($jsons18 as $jsons19){
                                                                                                        // echo $count19;
                                                                                                        // print_r($jsons19);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if($count19==2){
                                                                                                            // print_r($jsons19);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            $count20=1;
                                                                                                            foreach($jsons19 as $jsons20){
                                                                                                                // print_r($jsons20);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if($count20==1){
                                                                                                                    // print_r($jsons20);
                                                                                                                    // echo "<br/><br/><br/>";
                                                                                                                    foreach($jsons20 as $bg=>$jsons21){
                                                                                                                        // print_r($jsons21);
                                                                                                                        // echo "<br/><br/><br/>";
                                                                                                                        if(strcmp($bg, "$") == 0){	
                                                                                                                            $details4["baggageallowanceinfo"]=$jsons21;
                                                                                                                        }	
                                                                                                                    }
                                                                                                                }
                                                                                                                $count20++;
                                                                                                            }
                                                                                                        }
                                                                                                        $count19++;
                                                                                                    }
                                                                                                }
                                                                                                $count18++;
                                                                                            }
                                                                                        }
                                                                                        if($count17==3){
                                                                                            // print_r($jsons17);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count21=1;
                                                                                            foreach($jsons17 as $jsons18){
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                // if($count21==5){  //non stop flight  
                                                                                                if($count21==2 && is_array($jsons18)){
                                                                                                    // print_r($jsons18);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count22=1;
                                                                                                    foreach($jsons18 as $jsons19){
                                                                                                        // echo $count22;
                                                                                                        // print_r($jsons19);
                                                                                                        // echo "<br/><br/><br/>"; 
                                                                                                        if($count22==5){
                                                                                                            // print_r($jsons19);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            $count23=1;
                                                                                                            foreach($jsons19 as $jsons20){
                                                                                                                // print_r($jsons20);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if($count23==2){
                                                                                                                    // print_r($jsons20);
                                                                                                                    // echo "<br/><br/><br/>"; 
                                                                                                                    foreach($jsons20 as $cbb=>$jsons21){
                                                                                                                        if(is_string($jsons21)){
                                                                                                                            // print_r($cbb."-".$jsons21);
                                                                                                                            // echo "<br/><br/><br/>";
                                                                                                                            if(strcmp($cbb, "$") == 0){	
                                                                                                                                $details4["carryonallowanceinfo"]=$jsons21;
                                                                                                                            }	
                                                                                                                        }
                                                                                                                        
                                                                                                                    }
                                                                                                                }
                                                                                                                $count23++;
                                                                                                            }
                                                                                                        }
                                                                                                        $count22++;
                                                                                                    }
                                                                                                }else{
                                                                                                    if($count21==5){
                                                                                                        // print_r($jsons18);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        $count25=1;
                                                                                                        foreach($jsons18 as $jsons19){
                                                                                                            // print_r($jsons19);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            if($count25==2){
                                                                                                                foreach($jsons19 as $cbb => $jsons20){
                                                                                                                    // print_r($jsons20);
                                                                                                                    // echo "<br/><br/><br/>";
                                                                                                                    if(is_string($jsons20)){
                                                                                                                        // print_r($cbb."-".$jsons21);
                                                                                                                        // echo "<br/><br/><br/>";
                                                                                                                        if(strcmp($cbb, "$") == 0){	
                                                                                                                            $details4["carryonallowanceinfo"]=$jsons20;
                                                                                                                        }	
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                            $count25++;
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                $count21++;
                                                                                            }
                                                                                        }
                                                                                        
                                                                                        $count17++;
                                                                                    }
                                                                                }
                                                                                $count16++;
                                                                            }
                                                                            // return $details4 ;
                                                                            $data->push(["details"=>$details4]);
                                                                        }
                                                                    }
                                                                    if($count15==15){
                                                                        // print_r($jsons15);
                                                                        // echo "<br/><br/><br/>";  
                                                                        $HostToken=collect();
                                                                        foreach($jsons15 as $jsonss15){
                                                                            $HostToken1=[];
                                                                            foreach($jsonss15 as $hst => $jsons16){
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>"; 
                                                                                if(is_string($jsons16)){
                                                                                    if(strcmp($hst, "@Key") == 0){
                                                                                        $HostToken1["Key"] =$jsons16;
                                                                                    }
                                                                                    if(strcmp($hst, "$") == 0){
                                                                                        $HostToken1["HostTokenValue"] =$jsons16;
                                                                                    }
                                                                                }
                                                                            }
                                                                            // HostToken1
                                                                            $HostToken->push($HostToken1); 
    
                                                                        }
                                                                    }
                                                                    $count15++;
                                                                }
                                                                // return $price;
                                                                $data->push(["price"=>$price]);
                                                                $data->push(["AirPricingInfo"=>$AirPricingInfo]);
                                                                $data->push(["FareInfo"=>$FareInfo1]);
                                                                $data->push(["FareRuleKey"=>$FareRuleKey1]);
                                                                $data->push(["BookingInfo"=>$BookingInfo]);
                                                                $data->push(["HostToken"=>$HostToken]);
                                                                $data->push(["TaxInfo"=>$TaxInfo]);
                                                                $data->push(["FareCalc"=>$FareCalc]);
                                                                $data->push(["PassengerType"=>$PassengerType]);
                                                            }
                                                            $count1++;
                                                        }
                                                    }
                                                }
                                                // print_r($jsons3);
                                                // echo "<br/>"; 
                                            }
                                            $count++;
                                        }
                                       
                                    }
                                    // print_r($jsons2);
                                    // echo "<br/><br/><br/><br/><br/>"; 
                                }
                            } 
                        }
                    }
        }
        return $data;
    }

    public function XMLData_Round_old($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
                foreach($jsons as $jsons1){
                    if(count($jsons1)>1){
                        foreach($jsons1 as $jsons2){
                            // print_r($jsons2);
                            // echo "<br/>";
                            if(count($jsons2)>1){
                                foreach($jsons2 as $jsons3){
                                    // print_r($jsons3);
                                    // echo "<br/><br/><br/>";
                                    if(is_array($jsons3)){
                                        // echo $count." count";
                                            // echo "<br/>"; 
                                        if($count==3){
                                            // print_r($jsons3);
                                            // echo "<br/><br/>"; 
                                            $count2=1;
                                            foreach($jsons3 as $fdn => $jsons4){
                                                // echo "count";
                                                // print_r($jsons4);
                                                // echo "<br/><br/>"; 
                                                if(strcmp($fdn, "$") == 0){
                                                    // $details1["key"]=$jsons5;
                                                    return $data;
                                                    
                                                    // return view('flights.flight-details',[
                                                    //     'per_flight_details'=>$request,
                                                    //     'data'=>$data
                                                    // ]);
                                                }else{
                                                    $journey=collect();     
                                                    if($count2==2){
                                                        // print_r($jsons4);
                                                        // echo "<br/><br/>"; 
                                                        $details1=[];
                                                        foreach($jsons4 as $g => $jsons5){
                                                            //  print_r($jsons5);
                                                            //     echo "<br/>";
                                                            if(is_string($jsons5)){
                                                                if(strcmp($g, "@Key") == 0){
                                                                    $details1["key"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Group") == 0){
                                                                    $details1["Group"] =$jsons5;
                                                                }
                                                                if(strcmp($g, "@Carrier") == 0){
                                                                    $details1["Carrier"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@FlightNumber") == 0){
                                                                    $details1["FlightNumber"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Origin") == 0){
                                                                    $details1["Origin"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Destination") == 0){
                                                                    $details1["Destination"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@DepartureTime") == 0){
                                                                    $details1["DepartureTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@ArrivalTime") == 0){
                                                                    $details1["ArrivalTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@FlightTime") == 0){
                                                                    $details1["FlightTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@TravelTime") == 0){
                                                                    $details1["TravelTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Distance") == 0){
                                                                    $details1["Distance"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@ClassOfService") == 0){
                                                                    $details1["ClassOfService"]=$jsons5;
                                                                }
                                                            }else{
                                                                $details=[];
                                                                foreach($jsons5 as $k => $jsons6){
                                                                    // print_r($jsons6);
                                                                    // echo "<br/>";
                                                                    if(is_string($jsons6)){
                                                                        if(strcmp($k, "@Key") == 0){
                                                                            $details["key"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Group") == 0){
                                                                            $details["Group"] =$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Carrier") == 0){
                                                                            $details["Carrier"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@FlightNumber") == 0){
                                                                            $details["FlightNumber"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Origin") == 0){
                                                                            $details["Origin"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Destination") == 0){
                                                                            $details["Destination"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@DepartureTime") == 0){
                                                                            $details["DepartureTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@ArrivalTime") == 0){
                                                                            $details["ArrivalTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@FlightTime") == 0){
                                                                            $details["FlightTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@TravelTime") == 0){
                                                                            $details["TravelTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Distance") == 0){
                                                                            $details["Distance"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@ClassOfService") == 0){
                                                                            $details["ClassOfService"]=$jsons6;
                                                                        }
                                                                        // $details["changeofplane"] =$jsons6;
                                                                        // $details["optionalservicesindicator"]=$jsons6; 
                                                                        // $details["availabilitysource"] =$jsons6;
                                                                        // $details["polledavailabilityoption"] =$jsons6;
                                                                        // print_r($jsons6);
                                                                        // echo "<br/>";
                                                                        // $journey->push($details);   
                                                                        // print_r($k." - ".$jsons6);
                                                                        // echo "<br/>";  
    
                                                                    }
                                                                }
                                                                if(empty($details1) && !empty($details)){
                                                                    $journey->push($details); 
                                                                }    
                                                            }
                                                        }
                                                        if(!empty($details1)){
                                                            $journey->push($details1);     
                                                        }
                                                        // return $journey;
                                                        $data->push(["journey"=>collect($journey)]);     
                                                    }
                                                }
                                                $count2++;
                                            }
    
                                        }
                                        if($count==4){
                                            // print_r($jsons3);
                                            // echo "<br/><br/>";
                                            foreach($jsons3 as $jsons13){
                                                // print_r($jsons13);
                                                // echo "<br/><br/>";
                                                if(count($jsons13)==2){
                                                    // print_r($jsons13);
                                                    // echo "<br/><br/>";
                                                    $count1=1;
                                                    foreach($jsons13 as $jsons14){
                                                        // echo "count";
                                                        // print_r($jsons14);
                                                        // echo "<br/><br/><br/>";
                                                        if($count1==1){
                                                            // echo "count";
                                                            // print_r($jsons14);
                                                            // echo "<br/><br/><br/>";
                                                            $price=[];
                                                            $count15=1;
                                                            foreach($jsons14 as $p => $jsons15){
                                                                // echo $count15;
                                                                // print_r($jsons15);
                                                                // echo "<br/><br/><br/>";
                                                                if(is_string($jsons15)){
                                                                    if(strcmp($p, "@Key") == 0){
                                                                        $price["Key"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@TotalPrice") == 0){
                                                                        $price["TotalPrice"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@BasePrice") == 0){
                                                                        $price["BasePrice"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@ApproximateTotalPrice") == 0){
                                                                        $price["ApproximateTotalPrice"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@ApproximateBasePrice") == 0){
                                                                        $price["ApproximateBasePrice"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@EquivalentBasePrice") == 0){
                                                                        $price["EquivalentBasePrice"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@Taxes") == 0){
                                                                        $price["Taxes"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@Fees") == 0){
                                                                        $price["Fees"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@ApproximateTaxes") == 0){
                                                                        $price["ApproximateTaxes"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@QuoteDate") == 0){
                                                                        $price["QuoteDate"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@FareInfoRef") == 0){
                                                                        $price["FareInfoRef"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@RuleNumber") == 0){
                                                                        $price["RuleNumber"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@Source") == 0){
                                                                        $price["Source"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@TariffNumber") == 0){
                                                                        $price["TariffNumber"] =$jsons15;
                                                                    }
                                                                }else{
                                                                    if($count15==13){
                                                                        // echo "hii";
                                                                        // print_r($jsons15);
                                                                        // echo "<br/><br/><br/>";
                                                                        $count16=1;
                                                                        $details4=[];
                                                                        $AirPricingInfo=[];
                                                                        foreach($jsons15 as $aPf=> $jsons16){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>"; 
                                                                            if(is_string($jsons16)){
                                                                                if(strcmp($aPf, "@Key") == 0){
                                                                                    $AirPricingInfo["Key"] =$jsons16;
                                                                                }
                                                                                if(strcmp($aPf, "@TotalPrice") == 0){
                                                                                    $AirPricingInfo["TotalPrice"] =$jsons16;
                                                                                }
                                                                                if(strcmp($aPf, "@BasePrice") == 0){
                                                                                    $AirPricingInfo["BasePrice"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@ApproximateTotalPrice") == 0){
                                                                                    $AirPricingInfo["ApproximateTotalPrice"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@ApproximateBasePrice") == 0){
                                                                                    $AirPricingInfo["ApproximateBasePrice"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@EquivalentBasePrice") == 0){
                                                                                    $AirPricingInfo["EquivalentBasePrice"] =$jsons16;
                                                                                }  
                                                                                if(strcmp($aPf, "@ApproximateTaxes") == 0){
                                                                                    $AirPricingInfo["ApproximateTaxes"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@Taxes") == 0){
                                                                                    $AirPricingInfo["Taxes"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@LatestTicketingTime") == 0){
                                                                                    $AirPricingInfo["LatestTicketingTime"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@PricingMethod") == 0){
                                                                                    $AirPricingInfo["PricingMethod"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@Refundable") == 0){
                                                                                    $AirPricingInfo["Refundable"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@IncludesVAT") == 0){
                                                                                    $AirPricingInfo["IncludesVAT"] =$jsons16;
                                                                                }
                                                                                if(strcmp($aPf, "@ETicketability") == 0){
                                                                                    $AirPricingInfo["ETicketability"] =$jsons16;
                                                                                }
                                                                                if(strcmp($aPf, "@PlatingCarrier") == 0){
                                                                                    $AirPricingInfo["PlatingCarrier"] =$jsons16;
                                                                                } 
                                                                                if(strcmp($aPf, "@ProviderCode") == 0){
                                                                                    $AirPricingInfo["ProviderCode"] =$jsons16;
                                                                                }
                                                                            }
                                                                            if($count16==17){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons16 as $jsonss16) {
                                                                                    // echo $count16;
                                                                                    // print_r($jsonss16);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $FareInfo=[];
                                                                                    $count50=1;
                                                                                    foreach($jsonss16 as $fI => $jsons17){
                                                                                        // echo $count50;
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(is_string($jsons17)){
                                                                                            // print_r($fI."-".$jsons17);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(strcmp($fI, "@Key") == 0){
                                                                                                $FareInfo["Key"] =$jsons17;
                                                                                            }
                                                                                            if(strcmp($fI, "@FareBasis") == 0){
                                                                                                $FareInfo["FareBasis"] =$jsons17;
                                                                                            }
                                                                                            if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                                                                $FareInfo["PassengerTypeCode"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@Origin") == 0){
                                                                                                $FareInfo["Origin"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@Destination") == 0){
                                                                                                $FareInfo["Destination"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@EffectiveDate") == 0){
                                                                                                $FareInfo["EffectiveDate"] =$jsons17;
                                                                                            }  
                                                                                            if(strcmp($fI, "@DepartureDate") == 0){
                                                                                                $FareInfo["DepartureDate"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@Amount") == 0){
                                                                                                $FareInfo["Amount"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@NegotiatedFare") == 0){
                                                                                                $FareInfo["NegotiatedFare"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@NotValidBefore") == 0){
                                                                                                $FareInfo["NotValidBefore"] =$jsons17;
                                                                                            } 
                                                                                            if(strcmp($fI, "@TaxAmount") == 0){
                                                                                                $FareInfo["TaxAmount"] =$jsons17;
                                                                                            } 
                                                                                        }
                                                                                        if($count50==16){
                                                                                            $FareRuleKey=[];
                                                                                            foreach($jsons17 as $frk => $jsons18){
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if(is_string($jsons18)){
                                                                                                    // print_r($frk." - ".$jsons18);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    if(strcmp($frk, "@FareInfoRef") == 0){
                                                                                                        $FareRuleKey["FareInfoRef"] =$jsons18;
                                                                                                    } 
                                                                                                    if(strcmp($frk, "@ProviderCode") == 0){
                                                                                                        $FareRuleKey["ProviderCode"] =$jsons18;
                                                                                                    } 
                                                                                                    if(strcmp($frk, "$") == 0){
                                                                                                        $FareRuleKey["FareRuleKeyValue"] =$jsons18;
                                                                                                    } 
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        $count50++; 
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($count16==18){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>";
                                                                                $BookingInfo=collect();
                                                                                foreach($jsons16 as $jsonss16) {
                                                                                    $BookingInfo1=[];
                                                                                    foreach($jsonss16 as $bki => $jsons17){
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(is_string($jsons17)){
                                                                                            // print_r($bki."-".$jsons17);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(strcmp($bki, "@BookingCode") == 0){
                                                                                                $BookingInfo1["BookingCode"] =$jsons17;
                                                                                            }
                                                                                            if(strcmp($bki, "@CabinClass") == 0){
                                                                                                $BookingInfo1["CabinClass"] =$jsons17;
                                                                                            }
                                                                                            if(strcmp($bki, "@FareInfoRef") == 0){
                                                                                                $BookingInfo1["FareInfoRef"] =$jsons17;
                                                                                            }
                                                                                            if(strcmp($bki, "@SegmentRef") == 0){
                                                                                                $BookingInfo1["SegmentRef"] =$jsons17;
                                                                                            }
                                                                                            if(strcmp($bki, "@HostTokenRef") == 0){
                                                                                                $BookingInfo1["HostTokenRef"] =$jsons17;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    $BookingInfo->push($BookingInfo1); 
                                                                                }
                                                                            }
                                                                            if($count16==19){
                                                                                
                                                                                // print_r($jsons16);
                                                                                $TaxInfo=collect();
                                                                                foreach($jsons16 as $jsons17){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $TaxInfo1=[];
                                                                                    foreach($jsons17 as $tki => $jsons18){
                                                                                        if(is_string($jsons18)){
                                                                                            // print_r($tki."-".$jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(strcmp($tki, "@Category") == 0){
                                                                                                $TaxInfo1["Category"] =$jsons18;
                                                                                            }
                                                                                            if(strcmp($tki, "@Amount") == 0){
                                                                                                $TaxInfo1["Amount"] =$jsons18;
                                                                                            }
                                                                                            if(strcmp($tki, "@Key") == 0){
                                                                                                $TaxInfo1["Key"] =$jsons18;
                                                                                            }
                                                                                        
                                                                                        }
                                                                                    }
                                                                                    $TaxInfo->push($TaxInfo1);
    
                                                                                }
                                                                            }
                                                                            if($count16==20){
                                                                                $FareCalc=[];
                                                                                foreach($jsons16 as $fcc => $jsons17){
                                                                                    // print_r($jsons17);
                                                                                    if(is_string($jsons17)){
                                                                                        if(strcmp($fcc, "$") == 0){
                                                                                            $FareCalc["FareCalc"] =$jsons17;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($count16==21){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>";
                                                                                $PassengerType=[];
                                                                                foreach($jsons16 as $pc => $jsons17){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    if(is_string($jsons17)){
                                                                                        if(strcmp($pc, "@Code") == 0){
                                                                                            $PassengerType["Code"] =$jsons17;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($count16==22){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons16 as $jsons17){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    foreach($jsons17 as $c=> $jsons18){
                                                                                        if(is_string($jsons18)){
                                                                                            if(strcmp($c, "$") == 0){
                                                                                                $details4["changepenalty"]=$jsons18;
                                                                                            }
                                                                                            // print_r($c."- " .$jsons18);
                                                                                            // echo "<br/><br/><br/>"; 
                                                                                        }
                                                                                        
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($count16==23){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons16 as $jsons19){
                                                                                    // print_r($jsons19);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    foreach($jsons19 as $cc=> $jsons20){
                                                                                        if(is_string($jsons20)){
                                                                                            if(strcmp($cc, "$") == 0){
                                                                                                $details4["cancelpenalty"]=$jsons20;
                                                                                            }
                                                                                            // print_r($c."- " .$jsons20);
                                                                                            // echo "<br/><br/><br/>"; 
                                                                                        }
                                                                                        
                                                                                    }
                                                                                }
                                                                            }
                                                                            if($count16==24){
                                                                                // echo $count16;
                                                                                // print_r($jsons16);
                                                                                // echo "<br/><br/><br/>";
                                                                                $count17=1;   
                                                                                foreach($jsons16 as $jsons17){
                                                                                    // echo $count17;
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>"; 
                                                                                    if($count17==2){
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        $count18=1;
                                                                                        foreach($jsons17 as $jsons18){
                                                                                            // echo $count18;
                                                                                            // print_r($jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if($count18==7){
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                $count19=1;
                                                                                                foreach($jsons18 as $jsons19){
                                                                                                    // echo $count19;
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    if($count19==2){
                                                                                                        // print_r($jsons19);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        $count20=1;
                                                                                                        foreach($jsons19 as $jsons20){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            if($count20==1){
                                                                                                                // print_r($jsons20);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                foreach($jsons20 as $bg=>$jsons21){
                                                                                                                    // print_r($jsons21);
                                                                                                                    // echo "<br/><br/><br/>";
                                                                                                                    if(strcmp($bg, "$") == 0){	
                                                                                                                        $details4["baggageallowanceinfo"]=$jsons21;
                                                                                                                    }	
                                                                                                                }
                                                                                                            }
                                                                                                            $count20++;
                                                                                                        }
                                                                                                    }
                                                                                                    $count19++;
                                                                                                }
                                                                                            }
                                                                                            $count18++;
                                                                                        }
                                                                                    }
                                                                                    if($count17==3){
                                                                                        // print_r($jsons17);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        $count21=1;
                                                                                        foreach($jsons17 as $jsons18){
                                                                                            // print_r($jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            // if($count21==5){  //non stop flight  
                                                                                            if($count21==2 && is_array($jsons18)){
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                $count22=1;
                                                                                                foreach($jsons18 as $jsons19){
                                                                                                    // echo $count22;
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>"; 
                                                                                                    if($count22==5){
                                                                                                        // print_r($jsons19);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        $count23=1;
                                                                                                        foreach($jsons19 as $jsons20){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            if($count23==2){
                                                                                                                // print_r($jsons20);
                                                                                                                // echo "<br/><br/><br/>"; 
                                                                                                                foreach($jsons20 as $cbb=>$jsons21){
                                                                                                                    if(is_string($jsons21)){
                                                                                                                        // print_r($cbb."-".$jsons21);
                                                                                                                        // echo "<br/><br/><br/>";
                                                                                                                        if(strcmp($cbb, "$") == 0){	
                                                                                                                            $details4["carryonallowanceinfo"]=$jsons21;
                                                                                                                        }	
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                            }
                                                                                                            $count23++;
                                                                                                        }
                                                                                                    }
                                                                                                    $count22++;
                                                                                                }
                                                                                            }else{
                                                                                                if($count21==5){
                                                                                                    // print_r($jsons18);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count25=1;
                                                                                                    foreach($jsons18 as $jsons19){
                                                                                                        // print_r($jsons19);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if($count25==2){
                                                                                                            foreach($jsons19 as $cbb => $jsons20){
                                                                                                                // print_r($jsons20);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if(is_string($jsons20)){
                                                                                                                    // print_r($cbb."-".$jsons21);
                                                                                                                    // echo "<br/><br/><br/>";
                                                                                                                    if(strcmp($cbb, "$") == 0){	
                                                                                                                        $details4["carryonallowanceinfo"]=$jsons20;
                                                                                                                    }	
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                        $count25++;
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            $count21++;
                                                                                        }
                                                                                    }
                                                                                    
                                                                                    $count17++;
                                                                                }
                                                                            }
                                                                            $count16++;
                                                                        }
                                                                        // return $details4 ;
                                                                        $data->push(["details"=>$details4]);
                                                                    }
                                                                }
                                                                if($count15==15){
                                                                    // print_r($jsons15);
                                                                    // echo "<br/><br/><br/>";  
                                                                    $HostToken=collect();
                                                                    foreach($jsons15 as $jsonss15){
                                                                        $HostToken1=[];
                                                                        foreach($jsonss15 as $hst => $jsons16){
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>"; 
                                                                            if(is_string($jsons16)){
                                                                                if(strcmp($hst, "@Key") == 0){
                                                                                    $HostToken1["Key"] =$jsons16;
                                                                                }
                                                                                if(strcmp($hst, "$") == 0){
                                                                                    $HostToken1["HostTokenValue"] =$jsons16;
                                                                                }
                                                                            }
                                                                        }
                                                                        // HostToken1
                                                                        $HostToken->push($HostToken1); 

                                                                    }
                                                                }
                                                                $count15++;
                                                            }
                                                            // return $price;
                                                            $data->push(["price"=>$price]);
                                                            $data->push(["AirPricingInfo"=>$AirPricingInfo]);
                                                            $data->push(["FareInfo"=>$FareInfo]);
                                                            $data->push(["FareRuleKey"=>$FareRuleKey]);
                                                            $data->push(["BookingInfo"=>$BookingInfo]);
                                                            $data->push(["HostToken"=>$HostToken]);
                                                            $data->push(["TaxInfo"=>$TaxInfo]);
                                                            $data->push(["FareCalc"=>$FareCalc]);
                                                            $data->push(["PassengerType"=>$PassengerType]);
                                                        }
                                                        $count1++;
                                                    }
                                                }
                                            }
                                            // print_r($jsons3);
                                            // echo "<br/>"; 
                                        }
                                        $count++;
                                    }
                                   
                                }
                                // print_r($jsons2);
                                // echo "<br/><br/><br/><br/><br/>"; 
                            }
                        } 
                    }
                }
        }
        return $data;
    }

    public function XMLData_old_new($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                if(count($jsons1)>1){
                    foreach($jsons1 as $jsons2){
                        // print_r($jsons2);
                        // echo "<br/>";
                        if(count($jsons2)>1){
                            foreach($jsons2 as $jsons3){
                                // print_r($jsons3);
                                // echo "<br/><br/><br/>";
                                if(is_array($jsons3)){
                                    // echo $count." count";
                                        // echo "<br/>"; 
                                    if($count==3){
                                        // print_r($jsons3);
                                        // echo "<br/><br/>"; 
                                        $count2=1;
                                        foreach($jsons3 as $fdn => $jsons4){
                                            // echo "count";
                                            // print_r($jsons4);
                                            // echo "<br/><br/>"; 
                                            if(strcmp($fdn, "$") == 0){
                                                // $details1["key"]=$jsons5;
                                                return $data;
                                                
                                                // return view('flights.flight-details',[
                                                //     'per_flight_details'=>$request,
                                                //     'data'=>$data
                                                // ]);
                                            }else{
                                                $journey=collect();     
                                                if($count2==2){
                                                    // print_r($jsons4);
                                                    // echo "<br/><br/>"; 
                                                    $details1=[];
                                                    foreach($jsons4 as $g => $jsons5){
                                                        //  print_r($jsons5);
                                                        //     echo "<br/>";
                                                        if(is_string($jsons5)){
                                                            if(strcmp($g, "@Key") == 0){
                                                                $details1["key"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Group") == 0){
                                                                $details1["Group"] =$jsons5;
                                                            }
                                                            if(strcmp($g, "@Carrier") == 0){
                                                                $details1["Carrier"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@FlightNumber") == 0){
                                                                $details1["FlightNumber"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Origin") == 0){
                                                                $details1["Origin"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Destination") == 0){
                                                                $details1["Destination"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@DepartureTime") == 0){
                                                                $details1["DepartureTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@ArrivalTime") == 0){
                                                                $details1["ArrivalTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@FlightTime") == 0){
                                                                $details1["FlightTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@TravelTime") == 0){
                                                                $details1["TravelTime"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@Distance") == 0){
                                                                $details1["Distance"]=$jsons5;
                                                            }
                                                            if(strcmp($g, "@ClassOfService") == 0){
                                                                $details1["ClassOfService"]=$jsons5;
                                                            }
                                                        }else{
                                                            $details=[];
                                                            foreach($jsons5 as $k => $jsons6){
                                                                // print_r($jsons6);
                                                                // echo "<br/>";
                                                                if(is_string($jsons6)){
                                                                    if(strcmp($k, "@Key") == 0){
                                                                        $details["key"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Group") == 0){
                                                                        $details["Group"] =$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Carrier") == 0){
                                                                        $details["Carrier"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@FlightNumber") == 0){
                                                                        $details["FlightNumber"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Origin") == 0){
                                                                        $details["Origin"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Destination") == 0){
                                                                        $details["Destination"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@DepartureTime") == 0){
                                                                        $details["DepartureTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@ArrivalTime") == 0){
                                                                        $details["ArrivalTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@FlightTime") == 0){
                                                                        $details["FlightTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@TravelTime") == 0){
                                                                        $details["TravelTime"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@Distance") == 0){
                                                                        $details["Distance"]=$jsons6;
                                                                    }
                                                                    if(strcmp($k, "@ClassOfService") == 0){
                                                                        $details["ClassOfService"]=$jsons6;
                                                                    }
                                                                    // $details["changeofplane"] =$jsons6;
                                                                    // $details["optionalservicesindicator"]=$jsons6; 
                                                                    // $details["availabilitysource"] =$jsons6;
                                                                    // $details["polledavailabilityoption"] =$jsons6;
                                                                    // print_r($jsons6);
                                                                    // echo "<br/>";
                                                                    // $journey->push($details);   
                                                                    // print_r($k." - ".$jsons6);
                                                                    // echo "<br/>";  

                                                                }
                                                            }
                                                            if(empty($details1) && !empty($details)){
                                                                $journey->push($details); 
                                                            }    
                                                        }
                                                    }
                                                    if(!empty($details1)){
                                                        $journey->push($details1);     
                                                    }
                                                    // return $journey;
                                                    $data->push(["journey"=>collect($journey)]);     
                                                }
                                            }
                                            $count2++;
                                        }

                                    }
                                    if($count==4){
                                        // print_r($jsons3);
                                        // echo "<br/><br/>";
                                        foreach($jsons3 as $jsons13){
                                            // print_r($jsons13);
                                            // echo "<br/><br/>";
                                            if(count($jsons13)==2){
                                                // print_r($jsons13);
                                                // echo "<br/><br/>";
                                                $count1=1;
                                                foreach($jsons13 as $jsons14){
                                                    // echo "count";
                                                    // print_r($jsons14);
                                                    // echo "<br/><br/><br/>";
                                                    if($count1==1){
                                                        // echo "count";
                                                        // print_r($jsons14);
                                                        // echo "<br/><br/><br/>";
                                                        $price=[];
                                                        $count15=1;
                                                        foreach($jsons14 as $p => $jsons15){
                                                            // echo $count15;
                                                            // print_r($jsons15);
                                                            // echo "<br/><br/><br/>";
                                                            if(is_string($jsons15)){
                                                                if(strcmp($p, "@Key") == 0){
                                                                    $price["Key"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@TotalPrice") == 0){
                                                                    $price["TotalPrice"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@BasePrice") == 0){
                                                                    $price["BasePrice"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@ApproximateTotalPrice") == 0){
                                                                    $price["ApproximateTotalPrice"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@ApproximateBasePrice") == 0){
                                                                    $price["ApproximateBasePrice"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@EquivalentBasePrice") == 0){
                                                                    $price["EquivalentBasePrice"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@Taxes") == 0){
                                                                    $price["Taxes"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@Fees") == 0){
                                                                    $price["Fees"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@ApproximateTaxes") == 0){
                                                                    $price["ApproximateTaxes"]=$jsons15;
                                                                }
                                                                if(strcmp($p, "@QuoteDate") == 0){
                                                                    $price["QuoteDate"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@FareInfoRef") == 0){
                                                                    $price["FareInfoRef"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@RuleNumber") == 0){
                                                                    $price["RuleNumber"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@Source") == 0){
                                                                    $price["Source"] =$jsons15;
                                                                }
                                                                if(strcmp($p, "@TariffNumber") == 0){
                                                                    $price["TariffNumber"] =$jsons15;
                                                                }
                                                            }else{
                                                                if($count15==13){
                                                                    // echo "hii";
                                                                    // print_r($jsons15);
                                                                    // echo "<br/><br/><br/>";
                                                                    $count16=1;
                                                                    $details4=[];
                                                                    $AirPricingInfo=[];
                                                                    foreach($jsons15 as $aPf=> $jsons16){
                                                                        // echo $count16;
                                                                        // print_r($jsons16);
                                                                        // echo "<br/><br/><br/>"; 
                                                                        if(is_string($jsons16)){
                                                                            if(strcmp($aPf, "@Key") == 0){
                                                                                $AirPricingInfo["Key"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@TotalPrice") == 0){
                                                                                $AirPricingInfo["TotalPrice"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@BasePrice") == 0){
                                                                                $AirPricingInfo["BasePrice"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@ApproximateTotalPrice") == 0){
                                                                                $AirPricingInfo["ApproximateTotalPrice"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@ApproximateBasePrice") == 0){
                                                                                $AirPricingInfo["ApproximateBasePrice"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@EquivalentBasePrice") == 0){
                                                                                $AirPricingInfo["EquivalentBasePrice"] =$jsons16;
                                                                            }  
                                                                            if(strcmp($aPf, "@ApproximateTaxes") == 0){
                                                                                $AirPricingInfo["ApproximateTaxes"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@Taxes") == 0){
                                                                                $AirPricingInfo["Taxes"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@LatestTicketingTime") == 0){
                                                                                $AirPricingInfo["LatestTicketingTime"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@PricingMethod") == 0){
                                                                                $AirPricingInfo["PricingMethod"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@Refundable") == 0){
                                                                                $AirPricingInfo["Refundable"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@IncludesVAT") == 0){
                                                                                $AirPricingInfo["IncludesVAT"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@ETicketability") == 0){
                                                                                $AirPricingInfo["ETicketability"] =$jsons16;
                                                                            }
                                                                            if(strcmp($aPf, "@PlatingCarrier") == 0){
                                                                                $AirPricingInfo["PlatingCarrier"] =$jsons16;
                                                                            } 
                                                                            if(strcmp($aPf, "@ProviderCode") == 0){
                                                                                $AirPricingInfo["ProviderCode"] =$jsons16;
                                                                            }
                                                                        }
                                                                        if($count16==17){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            $FareInfo=[];
                                                                            $count50=1;
                                                                            foreach($jsons16 as $fI => $jsons17){
                                                                                // echo $count50;
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(is_string($jsons17)){
                                                                                    // print_r($fI."-".$jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    if(strcmp($fI, "@Key") == 0){
                                                                                        $FareInfo["Key"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($fI, "@FareBasis") == 0){
                                                                                        $FareInfo["FareBasis"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                                                        $FareInfo["PassengerTypeCode"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@Origin") == 0){
                                                                                        $FareInfo["Origin"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@Destination") == 0){
                                                                                        $FareInfo["Destination"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@EffectiveDate") == 0){
                                                                                        $FareInfo["EffectiveDate"] =$jsons17;
                                                                                    }  
                                                                                    if(strcmp($fI, "@DepartureDate") == 0){
                                                                                        $FareInfo["DepartureDate"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@Amount") == 0){
                                                                                        $FareInfo["Amount"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@NegotiatedFare") == 0){
                                                                                        $FareInfo["NegotiatedFare"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@NotValidBefore") == 0){
                                                                                        $FareInfo["NotValidBefore"] =$jsons17;
                                                                                    } 
                                                                                    if(strcmp($fI, "@TaxAmount") == 0){
                                                                                        $FareInfo["TaxAmount"] =$jsons17;
                                                                                    } 
                                                                                }
                                                                                if($count50==16){
                                                                                    $FareRuleKey=[];
                                                                                    foreach($jsons17 as $frk => $jsons18){
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(is_string($jsons18)){
                                                                                            // print_r($frk." - ".$jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if(strcmp($frk, "@FareInfoRef") == 0){
                                                                                                $FareRuleKey["FareInfoRef"] =$jsons18;
                                                                                            } 
                                                                                            if(strcmp($frk, "@ProviderCode") == 0){
                                                                                                $FareRuleKey["ProviderCode"] =$jsons18;
                                                                                            } 
                                                                                            if(strcmp($frk, "$") == 0){
                                                                                                $FareRuleKey["FareRuleKeyValue"] =$jsons18;
                                                                                            } 
                                                                                        }
                                                                                    }
                                                                                }
                                                                                $count50++; 
                                                                            }
                                                                        }
                                                                        if($count16==18){
                                                                            $BookingInfo=[];
                                                                            foreach($jsons16 as $bki => $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(is_string($jsons17)){
                                                                                    // print_r($bki."-".$jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    if(strcmp($bki, "@BookingCode") == 0){
                                                                                        $BookingInfo["BookingCode"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@CabinClass") == 0){
                                                                                        $BookingInfo["CabinClass"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@FareInfoRef") == 0){
                                                                                        $BookingInfo["FareInfoRef"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@SegmentRef") == 0){
                                                                                        $BookingInfo["SegmentRef"] =$jsons17;
                                                                                    }
                                                                                    if(strcmp($bki, "@HostTokenRef") == 0){
                                                                                        $BookingInfo["HostTokenRef"] =$jsons17;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==19){
                                                                            
                                                                            // print_r($jsons16);
                                                                            $TaxInfo=collect();
                                                                            foreach($jsons16 as $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                $TaxInfo1=[];
                                                                                foreach($jsons17 as $tki => $jsons18){
                                                                                    if(is_string($jsons18)){
                                                                                        // print_r($tki."-".$jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if(strcmp($tki, "@Category") == 0){
                                                                                            $TaxInfo1["Category"] =$jsons18;
                                                                                        }
                                                                                        if(strcmp($tki, "@Amount") == 0){
                                                                                            $TaxInfo1["Amount"] =$jsons18;
                                                                                        }
                                                                                        if(strcmp($tki, "@Key") == 0){
                                                                                            $TaxInfo1["Key"] =$jsons18;
                                                                                        }
                                                                                    
                                                                                    }
                                                                                }
                                                                                $TaxInfo->push($TaxInfo1);

                                                                            }
                                                                        }
                                                                        if($count16==20){
                                                                            $FareCalc=[];
                                                                            foreach($jsons16 as $fcc => $jsons17){
                                                                                // print_r($jsons17);
                                                                                if(is_string($jsons17)){
                                                                                    if(strcmp($fcc, "$") == 0){
                                                                                        $FareCalc["FareCalc"] =$jsons17;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==21){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            $PassengerType=[];
                                                                            foreach($jsons16 as $pc => $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(is_string($jsons17)){
                                                                                    if(strcmp($pc, "@Code") == 0){
                                                                                        $PassengerType["Code"] =$jsons17;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==22){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            foreach($jsons16 as $jsons17){
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons17 as $c=> $jsons18){
                                                                                    if(is_string($jsons18)){
                                                                                        if(strcmp($c, "$") == 0){
                                                                                            $details4["changepenalty"]=$jsons18;
                                                                                        }
                                                                                        // print_r($c."- " .$jsons18);
                                                                                        // echo "<br/><br/><br/>"; 
                                                                                    }
                                                                                    
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==23){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            foreach($jsons16 as $jsons19){
                                                                                // print_r($jsons19);
                                                                                // echo "<br/><br/><br/>";
                                                                                foreach($jsons19 as $cc=> $jsons20){
                                                                                    if(is_string($jsons20)){
                                                                                        if(strcmp($cc, "$") == 0){
                                                                                            $details4["cancelpenalty"]=$jsons20;
                                                                                        }
                                                                                        // print_r($c."- " .$jsons20);
                                                                                        // echo "<br/><br/><br/>"; 
                                                                                    }
                                                                                    
                                                                                }
                                                                            }
                                                                        }
                                                                        if($count16==24){
                                                                            // echo $count16;
                                                                            // print_r($jsons16);
                                                                            // echo "<br/><br/><br/>";
                                                                            $count17=1;   
                                                                            foreach($jsons16 as $jsons17){
                                                                                // echo $count17;
                                                                                // print_r($jsons17);
                                                                                // echo "<br/><br/><br/>"; 
                                                                                if($count17==2){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count18=1;
                                                                                    foreach($jsons17 as $jsons18){
                                                                                        // echo $count18;
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if($count18==7){
                                                                                            // print_r($jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count19=1;
                                                                                            foreach($jsons18 as $jsons19){
                                                                                                // echo $count19;
                                                                                                // print_r($jsons19);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if($count19==2){
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count20=1;
                                                                                                    foreach($jsons19 as $jsons20){
                                                                                                        // print_r($jsons20);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if($count20==1){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            foreach($jsons20 as $bg=>$jsons21){
                                                                                                                // print_r($jsons21);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if(strcmp($bg, "$") == 0){	
                                                                                                                    $details4["baggageallowanceinfo"]=$jsons21;
                                                                                                                }	
                                                                                                            }
                                                                                                        }
                                                                                                        $count20++;
                                                                                                    }
                                                                                                }
                                                                                                $count19++;
                                                                                            }
                                                                                        }
                                                                                        $count18++;
                                                                                    }
                                                                                }
                                                                                if($count17==3){
                                                                                    // print_r($jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count21=1;
                                                                                    foreach($jsons17 as $jsons18){
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        // if($count21==5){  //non stop flight  
                                                                                        if($count21==2 && is_array($jsons18)){
                                                                                            // print_r($jsons18);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count22=1;
                                                                                            foreach($jsons18 as $jsons19){
                                                                                                // echo $count22;
                                                                                                // print_r($jsons19);
                                                                                                // echo "<br/><br/><br/>"; 
                                                                                                if($count22==5){
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    $count23=1;
                                                                                                    foreach($jsons19 as $jsons20){
                                                                                                        // print_r($jsons20);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if($count23==2){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>"; 
                                                                                                            foreach($jsons20 as $cbb=>$jsons21){
                                                                                                                if(is_string($jsons21)){
                                                                                                                    // print_r($cbb."-".$jsons21);
                                                                                                                    // echo "<br/><br/><br/>";
                                                                                                                    if(strcmp($cbb, "$") == 0){	
                                                                                                                        $details4["carryonallowanceinfo"]=$jsons21;
                                                                                                                    }	
                                                                                                                }
                                                                                                                
                                                                                                            }
                                                                                                        }
                                                                                                        $count23++;
                                                                                                    }
                                                                                                }
                                                                                                $count22++;
                                                                                            }
                                                                                        }else{
                                                                                            if($count21==5){
                                                                                                // print_r($jsons18);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                $count25=1;
                                                                                                foreach($jsons18 as $jsons19){
                                                                                                    // print_r($jsons19);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    if($count25==2){
                                                                                                        foreach($jsons19 as $cbb => $jsons20){
                                                                                                            // print_r($jsons20);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            if(is_string($jsons20)){
                                                                                                                // print_r($cbb."-".$jsons21);
                                                                                                                // echo "<br/><br/><br/>";
                                                                                                                if(strcmp($cbb, "$") == 0){	
                                                                                                                    $details4["carryonallowanceinfo"]=$jsons20;
                                                                                                                }	
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    $count25++;
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        $count21++;
                                                                                    }
                                                                                }
                                                                                
                                                                                $count17++;
                                                                            }
                                                                        }
                                                                        $count16++;
                                                                    }
                                                                    // return $details4 ;
                                                                    $data->push(["details"=>$details4]);
                                                                }
                                                            }
                                                            if($count15==15){
                                                                // print_r($jsons15);
                                                                // echo "<br/><br/><br/>";  
                                                                $HostToken=[];
                                                                foreach($jsons15 as $hst => $jsons16){
                                                                    if(is_string($jsons16)){
                                                                        if(strcmp($hst, "@Key") == 0){
                                                                            $HostToken["Key"] =$jsons16;
                                                                        }
                                                                        if(strcmp($hst, "$") == 0){
                                                                            $HostToken["HostTokenValue"] =$jsons16;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $count15++;
                                                        }
                                                        // return $price;
                                                        $data->push(["price"=>$price]);
                                                        $data->push(["AirPricingInfo"=>$AirPricingInfo]);
                                                        $data->push(["FareInfo"=>$FareInfo]);
                                                        $data->push(["FareRuleKey"=>$FareRuleKey]);
                                                        $data->push(["BookingInfo"=>$BookingInfo]);
                                                        $data->push(["HostToken"=>$HostToken]);
                                                        $data->push(["TaxInfo"=>$TaxInfo]);
                                                        $data->push(["FareCalc"=>$FareCalc]);
                                                        $data->push(["PassengerType"=>$PassengerType]);
                                                    }
                                                    $count1++;
                                                }
                                            }
                                        }
                                        // print_r($jsons3);
                                        // echo "<br/>"; 
                                    }
                                    $count++;
                                }
                               
                            }
                            // print_r($jsons2);
                            // echo "<br/><br/><br/><br/><br/>"; 
                        }
                    } 
                }
            }
        }
        return $data;
    } 

    public function XMLData($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
                foreach($jsons as $jsons1){
                    if(count($jsons1)>1){
                        foreach($jsons1 as $jsons2){
                            // print_r($jsons2);
                            // echo "<br/>";
                            if(count($jsons2)>1){
                                foreach($jsons2 as $jsons3){
                                    // print_r($jsons3);
                                    // echo "<br/><br/><br/>";
                                    if(is_array($jsons3)){
                                        // echo $count." count";
                                            // echo "<br/>"; 
                                        if($count==3){
                                            // print_r($jsons3);
                                            // echo "<br/><br/>"; 
                                            $count2=1;
                                            foreach($jsons3 as $fdn => $jsons4){
                                                // echo "count";
                                                // print_r($jsons4);
                                                // echo "<br/><br/>"; 
                                                if(strcmp($fdn, "$") == 0){
                                                    // $details1["key"]=$jsons5;
                                                    return $data;
                                                    
                                                    // return view('flights.flight-details',[
                                                    //     'per_flight_details'=>$request,
                                                    //     'data'=>$data
                                                    // ]);
                                                }else{
                                                    $journey=collect();     
                                                    if($count2==2){
                                                        // print_r($jsons4);
                                                        // echo "<br/><br/>"; 
                                                        $details1=[];
                                                        foreach($jsons4 as $g => $jsons5){
                                                            //  print_r($jsons5);
                                                            //     echo "<br/>";
                                                            if(is_string($jsons5)){
                                                                if(strcmp($g, "@Key") == 0){
                                                                    $details1["key"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Group") == 0){
                                                                    $details1["Group"] =$jsons5;
                                                                }
                                                                if(strcmp($g, "@Carrier") == 0){
                                                                    $details1["Carrier"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@FlightNumber") == 0){
                                                                    $details1["FlightNumber"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Origin") == 0){
                                                                    $details1["Origin"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Destination") == 0){
                                                                    $details1["Destination"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@DepartureTime") == 0){
                                                                    $details1["DepartureTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@ArrivalTime") == 0){
                                                                    $details1["ArrivalTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@FlightTime") == 0){
                                                                    $details1["FlightTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@TravelTime") == 0){
                                                                    $details1["TravelTime"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@Distance") == 0){
                                                                    $details1["Distance"]=$jsons5;
                                                                }
                                                                if(strcmp($g, "@ClassOfService") == 0){
                                                                    $details1["ClassOfService"]=$jsons5;
                                                                }
                                                            }else{
                                                                $details=[];
                                                                foreach($jsons5 as $k => $jsons6){
                                                                    // print_r($jsons6);
                                                                    // echo "<br/>";
                                                                    if(is_string($jsons6)){
                                                                        if(strcmp($k, "@Key") == 0){
                                                                            $details["key"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Group") == 0){
                                                                            $details["Group"] =$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Carrier") == 0){
                                                                            $details["Carrier"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@FlightNumber") == 0){
                                                                            $details["FlightNumber"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Origin") == 0){
                                                                            $details["Origin"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Destination") == 0){
                                                                            $details["Destination"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@DepartureTime") == 0){
                                                                            $details["DepartureTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@ArrivalTime") == 0){
                                                                            $details["ArrivalTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@FlightTime") == 0){
                                                                            $details["FlightTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@TravelTime") == 0){
                                                                            $details["TravelTime"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@Distance") == 0){
                                                                            $details["Distance"]=$jsons6;
                                                                        }
                                                                        if(strcmp($k, "@ClassOfService") == 0){
                                                                            $details["ClassOfService"]=$jsons6;
                                                                        }
                                                                        // $details["changeofplane"] =$jsons6;
                                                                        // $details["optionalservicesindicator"]=$jsons6; 
                                                                        // $details["availabilitysource"] =$jsons6;
                                                                        // $details["polledavailabilityoption"] =$jsons6;
                                                                        // print_r($jsons6);
                                                                        // echo "<br/>";
                                                                        // $journey->push($details);   
                                                                        // print_r($k." - ".$jsons6);
                                                                        // echo "<br/>";  

                                                                    }
                                                                }
                                                                if(empty($details1) && !empty($details)){
                                                                    $journey->push($details); 
                                                                }    
                                                            }
                                                        }
                                                        if(!empty($details1)){
                                                            $journey->push($details1);     
                                                        }
                                                        // return $journey;
                                                        $data->push(["journey"=>collect($journey)]);     
                                                    }
                                                }
                                                $count2++;
                                            }

                                        }
                                        if($count==4){
                                            // print_r($jsons3);
                                            // echo "<br/><br/>";
                                            foreach($jsons3 as $jsons13){
                                                // print_r($jsons13);
                                                // echo "<br/><br/>";
                                                if(count($jsons13)==2){
                                                    // print_r($jsons13);
                                                    // echo "<br/><br/>";
                                                    $count1=1;
                                                    foreach($jsons13 as $jsons14){
                                                        // echo "count";
                                                        // print_r($jsons14);
                                                        // echo "<br/><br/><br/>";
                                                        if($count1==1){
                                                            // echo $count1;
                                                            // print_r($jsons14);
                                                            // echo "<br/><br/><br/>";
                                                            $price=[];
                                                            foreach($jsons14 as $p => $jsons15){
                                                                // echo $count15;
                                                                // print_r($jsons15);
                                                                // echo "<br/><br/><br/>";
                                                                if(is_string($jsons15)){
                                                                    if(strcmp($p, "@Key") == 0){
                                                                        $price["Key"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@TotalPrice") == 0){
                                                                        $price["TotalPrice"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@BasePrice") == 0){
                                                                        $price["BasePrice"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@ApproximateTotalPrice") == 0){
                                                                        $price["ApproximateTotalPrice"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@ApproximateBasePrice") == 0){
                                                                        $price["ApproximateBasePrice"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@EquivalentBasePrice") == 0){
                                                                        $price["EquivalentBasePrice"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@Taxes") == 0){
                                                                        $price["Taxes"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@Fees") == 0){
                                                                        $price["Fees"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@ApproximateTaxes") == 0){
                                                                        $price["ApproximateTaxes"]=$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@QuoteDate") == 0){
                                                                        $price["QuoteDate"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@FareInfoRef") == 0){
                                                                        $price["FareInfoRef"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@RuleNumber") == 0){
                                                                        $price["RuleNumber"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@Source") == 0){
                                                                        $price["Source"] =$jsons15;
                                                                    }
                                                                    if(strcmp($p, "@TariffNumber") == 0){
                                                                        $price["TariffNumber"] =$jsons15;
                                                                    }
                                                                }
                                                            }
                                                            if(array_key_exists('air:AirPricingInfo', $jsons14)){
                                                                // print_r($jsons14['air:AirPricingInfo']);
                                                                // echo "<br/><br/>";
                                                                $AirPricingInfo=[];
                                                                foreach($jsons14['air:AirPricingInfo'] as $aPf=> $jsons16){
                                                                    // echo $count16;
                                                                    // print_r($jsons16);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($jsons16)){
                                                                        if(strcmp($aPf, "@Key") == 0){
                                                                            $AirPricingInfo["Key"] =$jsons16;
                                                                        }
                                                                        if(strcmp($aPf, "@TotalPrice") == 0){
                                                                            $AirPricingInfo["TotalPrice"] =$jsons16;
                                                                        }
                                                                        if(strcmp($aPf, "@BasePrice") == 0){
                                                                            $AirPricingInfo["BasePrice"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@ApproximateTotalPrice") == 0){
                                                                            $AirPricingInfo["ApproximateTotalPrice"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@ApproximateBasePrice") == 0){
                                                                            $AirPricingInfo["ApproximateBasePrice"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@EquivalentBasePrice") == 0){
                                                                            $AirPricingInfo["EquivalentBasePrice"] =$jsons16;
                                                                        }  
                                                                        if(strcmp($aPf, "@ApproximateTaxes") == 0){
                                                                            $AirPricingInfo["ApproximateTaxes"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@Taxes") == 0){
                                                                            $AirPricingInfo["Taxes"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@LatestTicketingTime") == 0){
                                                                            $AirPricingInfo["LatestTicketingTime"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@PricingMethod") == 0){
                                                                            $AirPricingInfo["PricingMethod"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@Refundable") == 0){
                                                                            $AirPricingInfo["Refundable"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@IncludesVAT") == 0){
                                                                            $AirPricingInfo["IncludesVAT"] =$jsons16;
                                                                        }
                                                                        if(strcmp($aPf, "@ETicketability") == 0){
                                                                            $AirPricingInfo["ETicketability"] =$jsons16;
                                                                        }
                                                                        if(strcmp($aPf, "@PlatingCarrier") == 0){
                                                                            $AirPricingInfo["PlatingCarrier"] =$jsons16;
                                                                        } 
                                                                        if(strcmp($aPf, "@ProviderCode") == 0){
                                                                            $AirPricingInfo["ProviderCode"] =$jsons16;
                                                                        }
                                                                    }
                                                                }
                                                                if(array_key_exists('air:FareInfo', $jsons14['air:AirPricingInfo'])){
                                                                    // print_r($jsons14['air:AirPricingInfo']['air:FareInfo']);
                                                                    $FareInfo=[];
                                                                    foreach($jsons14['air:AirPricingInfo']['air:FareInfo'] as $fI => $jsons17){
                                                                        // echo $count50;
                                                                        // print_r($jsons17);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(is_string($jsons17)){
                                                                            // print_r($fI."-".$jsons17);
                                                                            // echo "<br/><br/><br/>";
                                                                            if(strcmp($fI, "@Key") == 0){
                                                                                $FareInfo["Key"] =$jsons17;
                                                                            }
                                                                            if(strcmp($fI, "@FareBasis") == 0){
                                                                                $FareInfo["FareBasis"] =$jsons17;
                                                                            }
                                                                            if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                                                $FareInfo["PassengerTypeCode"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@Origin") == 0){
                                                                                $FareInfo["Origin"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@Destination") == 0){
                                                                                $FareInfo["Destination"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@EffectiveDate") == 0){
                                                                                $FareInfo["EffectiveDate"] =$jsons17;
                                                                            }  
                                                                            if(strcmp($fI, "@DepartureDate") == 0){
                                                                                $FareInfo["DepartureDate"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@Amount") == 0){
                                                                                $FareInfo["Amount"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@NegotiatedFare") == 0){
                                                                                $FareInfo["NegotiatedFare"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@NotValidBefore") == 0){
                                                                                $FareInfo["NotValidBefore"] =$jsons17;
                                                                            } 
                                                                            if(strcmp($fI, "@TaxAmount") == 0){
                                                                                $FareInfo["TaxAmount"] =$jsons17;
                                                                            } 
                                                                        }
                                                                    }
                                                                    if(array_key_exists('air:FareRuleKey', $jsons14['air:AirPricingInfo']['air:FareInfo'])){
                                                                        // print_r($jsons14['air:AirPricingInfo']['air:FareInfo']['air:FareRuleKey']);
                                                                        $FareRuleKey=[];
                                                                        foreach($jsons14['air:AirPricingInfo']['air:FareInfo']['air:FareRuleKey'] as $frk => $jsons18){
                                                                            // print_r($jsons18);
                                                                            // echo "<br/><br/><br/>";
                                                                            if(is_string($jsons18)){
                                                                                // print_r($frk." - ".$jsons18);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(strcmp($frk, "@FareInfoRef") == 0){
                                                                                    $FareRuleKey["FareInfoRef"] =$jsons18;
                                                                                } 
                                                                                if(strcmp($frk, "@ProviderCode") == 0){
                                                                                    $FareRuleKey["ProviderCode"] =$jsons18;
                                                                                } 
                                                                                if(strcmp($frk, "$") == 0){
                                                                                    $FareRuleKey["FareRuleKeyValue"] =$jsons18;
                                                                                } 
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if(array_key_exists('air:BookingInfo', $jsons14['air:AirPricingInfo'])){
                                                                    $BookingInfo1=collect();
                                                                    $BookingInfo=[];
                                                                    foreach($jsons14['air:AirPricingInfo']['air:BookingInfo'] as $bki => $jsons17){
                                                                        // print_r($jsons17);
                                                                        // echo "<br/><br/><br/>";
                                                                        $BookingInfo0=[];
                                                                        if(is_string($jsons17)){
                                                                            // print_r($bki."-".$jsons17);
                                                                            // echo "<br/><br/><br/>";
                                                                            if(strcmp($bki, "@BookingCode") == 0){
                                                                                $BookingInfo["BookingCode"] =$jsons17;
                                                                            }
                                                                            if(strcmp($bki, "@CabinClass") == 0){
                                                                                $BookingInfo["CabinClass"] =$jsons17;
                                                                            }
                                                                            if(strcmp($bki, "@FareInfoRef") == 0){
                                                                                $BookingInfo["FareInfoRef"] =$jsons17;
                                                                            }
                                                                            if(strcmp($bki, "@SegmentRef") == 0){
                                                                                $BookingInfo["SegmentRef"] =$jsons17;
                                                                            }
                                                                            if(strcmp($bki, "@HostTokenRef") == 0){
                                                                                $BookingInfo["HostTokenRef"] =$jsons17;
                                                                            }
                                                                        }else{
                                                                            foreach($jsons17 as $bki => $jsons18){
                                                                                if(is_string($jsons18)){
                                                                                    // print_r($bki."-".$jsons17);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    if(strcmp($bki, "@BookingCode") == 0){
                                                                                        $BookingInfo0["BookingCode"] =$jsons18;
                                                                                    }
                                                                                    if(strcmp($bki, "@CabinClass") == 0){
                                                                                        $BookingInfo0["CabinClass"] =$jsons18;
                                                                                    }
                                                                                    if(strcmp($bki, "@FareInfoRef") == 0){
                                                                                        $BookingInfo0["FareInfoRef"] =$jsons18;
                                                                                    }
                                                                                    if(strcmp($bki, "@SegmentRef") == 0){
                                                                                        $BookingInfo0["SegmentRef"] =$jsons18;
                                                                                    }
                                                                                    if(strcmp($bki, "@HostTokenRef") == 0){
                                                                                        $BookingInfo0["HostTokenRef"] =$jsons18;
                                                                                    }
                                                                                }
                                                                            } 
                                                                        }
                                                                        if(empty($BookingInfo) && !empty($BookingInfo0)){
                                                                            $BookingInfo1->push($BookingInfo);
                                                                        }
                                                                        // $BookingInfo1->push($BookingInfo);
                                                                    }
                                                                    if(!empty($BookingInfo)){
                                                                        $BookingInfo1->push($BookingInfo);
                                                                    }
                                                                }
                                                                if(array_key_exists('air:TaxInfo', $jsons14['air:AirPricingInfo'])){
                                                                    $TaxInfo=collect();
                                                                    $TaxInfo1=[];
                                                                    foreach($jsons14['air:AirPricingInfo']['air:TaxInfo'] as $jsons17){
                                                                        // print_r($jsons17);
                                                                        // echo "<br/><br/><br/>";
                                                                        foreach($jsons17 as $tki => $jsons18){
                                                                            if(is_string($jsons18)){
                                                                                // print_r($tki."-".$jsons18);
                                                                                // echo "<br/><br/><br/>";
                                                                                if(strcmp($tki, "@Category") == 0){
                                                                                    $TaxInfo1["Category"] =$jsons18;
                                                                                }
                                                                                if(strcmp($tki, "@Amount") == 0){
                                                                                    $TaxInfo1["Amount"] =$jsons18;
                                                                                }
                                                                                if(strcmp($tki, "@Key") == 0){
                                                                                    $TaxInfo1["Key"] =$jsons18;
                                                                                }
                                                                            
                                                                            }
                                                                        }
                                                                        $TaxInfo->push($TaxInfo1);
                                                                    }
                                                                }
                                                                if(array_key_exists('air:FareCalc', $jsons14['air:AirPricingInfo'])){
                                                                    $FareCalc=[];
                                                                    foreach($jsons14['air:AirPricingInfo']['air:FareCalc'] as $fcc => $jsons17){
                                                                        // print_r($jsons17);
                                                                        if(is_string($jsons17)){
                                                                            if(strcmp($fcc, "$") == 0){
                                                                                $FareCalc["FareCalc"] =$jsons17;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if(array_key_exists('air:PassengerType', $jsons14['air:AirPricingInfo'])){
                                                                    // print_r();
                                                                    $PassengerType=[];
                                                                    foreach($jsons14['air:AirPricingInfo']['air:PassengerType'] as $pc => $jsons17){
                                                                        // print_r($jsons17);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(is_string($jsons17)){
                                                                            if(strcmp($pc, "@Code") == 0){
                                                                                $PassengerType["Code"] =$jsons17;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $details4=[];
                                                                if(array_key_exists('air:ChangePenalty', $jsons14['air:AirPricingInfo'])){
                                                                    // print_r($jsons14['air:AirPricingInfo']['air:ChangePenalty']);
                                                                    // echo "<br/><br/>";
                                                                    // if(array_key_exists('air:Percentage', $jsons14['air:AirPricingInfo']['air:ChangePenalty'])){
                                                                    //     // print_r($jsons14['air:AirPricingInfo']['air:ChangePenalty']['air:Percentage']);
                                                                    //     // echo "<br/><br/>";
                                                                    //     foreach($jsons14['air:AirPricingInfo']['air:ChangePenalty']['air:Percentage'] as $c=> $jsons18){
                                                                    //         if(is_string($jsons18)){
                                                                    //             if(strcmp($c, "$") == 0){
                                                                    //                 $details4["changepenalty"]=$jsons18;
                                                                    //             }
                                                                    //         }
                                                                            
                                                                    //     }
                                                                    // }
                                                                    foreach($jsons14['air:AirPricingInfo']['air:ChangePenalty'] as $jsons17){
                                                                        // print_r($jsons17);
                                                                        // echo "<br/><br/><br/>";
                                                                        foreach($jsons17 as $c=> $jsons18){
                                                                            if(is_string($jsons18)){
                                                                                if(strcmp($c, "$") == 0){
                                                                                    $details4["changepenalty"]=$jsons18;
                                                                                }
                                                                                // print_r($c."- " .$jsons18);
                                                                                // echo "<br/><br/><br/>"; 
                                                                            }
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                                if(array_key_exists('air:CancelPenalty', $jsons14['air:AirPricingInfo'])){
                                                                    // print_r($jsons14['air:AirPricingInfo']['air:CancelPenalty']);
                                                                    // echo "<br/><br/>";
                                                                    // if(array_key_exists('air:Percentage', $jsons14['air:AirPricingInfo']['air:CancelPenalty'])){
                                                                    //     // print_r($jsons14['air:AirPricingInfo']['air:CancelPenalty']['air:Percentage']);
                                                                    //     // echo "<br/><br/>";
                                                                    //     foreach($jsons14['air:AirPricingInfo']['air:CancelPenalty']['air:Percentage'] as $c=> $jsons18){
                                                                    //         if(is_string($jsons18)){
                                                                    //             if(strcmp($c, "$") == 0){
                                                                    //                 $details4["cancelpenalty"]=$jsons18;
                                                                    //             }
                                                                    //         }
                                                                            
                                                                    //     }
                                                                    // }
                                                                    foreach($jsons14['air:AirPricingInfo']['air:CancelPenalty'] as $jsons19){
                                                                        // print_r($jsons19);
                                                                        // echo "<br/><br/><br/>";
                                                                        foreach($jsons19 as $cc=> $jsons20){
                                                                            if(is_string($jsons20)){
                                                                                if(strcmp($cc, "$") == 0){
                                                                                    $details4["cancelpenalty"]=$jsons20;
                                                                                }
                                                                                // print_r($c."- " .$jsons20);
                                                                                // echo "<br/><br/><br/>"; 
                                                                            }
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                                if(array_key_exists('air:BaggageAllowances', $jsons14['air:AirPricingInfo'])){
                                                                    // print_r($jsons14['air:AirPricingInfo']['air:BaggageAllowances']);
                                                                    // echo "<br/><br/>";
                                                                    $count17=1;   
                                                                    foreach($jsons14['air:AirPricingInfo']['air:BaggageAllowances'] as $jsons17){
                                                                        // echo $count17;
                                                                        // print_r($jsons17);
                                                                        // echo "<br/><br/><br/>"; 
                                                                        if($count17==2){
                                                                            // print_r($jsons17);
                                                                            // echo "<br/><br/><br/>";
                                                                            $count18=1;
                                                                            foreach($jsons17 as $jsons18){
                                                                                // echo $count18;
                                                                                // print_r($jsons18);
                                                                                // echo "<br/><br/><br/>";
                                                                                if($count18==7){
                                                                                    // print_r($jsons18);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count19=1;
                                                                                    foreach($jsons18 as $jsons19){
                                                                                        // echo $count19;
                                                                                        // print_r($jsons19);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        if($count19==2){
                                                                                            // print_r($jsons19);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count20=1;
                                                                                            foreach($jsons19 as $jsons20){
                                                                                                // print_r($jsons20);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if($count20==1){
                                                                                                    // print_r($jsons20);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    foreach($jsons20 as $bg=>$jsons21){
                                                                                                        // print_r($jsons21);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if(strcmp($bg, "$") == 0){	
                                                                                                            $details4["baggageallowanceinfo"]=$jsons21;
                                                                                                        }	
                                                                                                    }
                                                                                                }
                                                                                                $count20++;
                                                                                            }
                                                                                        }
                                                                                        $count19++;
                                                                                    }
                                                                                }
                                                                                $count18++;
                                                                            }
                                                                        }
                                                                        if($count17==3){
                                                                            // print_r($jsons17);
                                                                            // echo "<br/><br/><br/>";
                                                                            $count21=1;
                                                                            foreach($jsons17 as $jsons18){
                                                                                // print_r($jsons18);
                                                                                // echo "<br/><br/><br/>";
                                                                                // if($count21==5){  //non stop flight  
                                                                                if($count21==2 && is_array($jsons18)){
                                                                                    // print_r($jsons18);
                                                                                    // echo "<br/><br/><br/>";
                                                                                    $count22=1;
                                                                                    foreach($jsons18 as $jsons19){
                                                                                        // echo $count22;
                                                                                        // print_r($jsons19);
                                                                                        // echo "<br/><br/><br/>"; 
                                                                                        if($count22==5){
                                                                                            // print_r($jsons19);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            $count23=1;
                                                                                            foreach($jsons19 as $jsons20){
                                                                                                // print_r($jsons20);
                                                                                                // echo "<br/><br/><br/>";
                                                                                                if($count23==2){
                                                                                                    // print_r($jsons20);
                                                                                                    // echo "<br/><br/><br/>"; 
                                                                                                    foreach($jsons20 as $cbb=>$jsons21){
                                                                                                        if(is_string($jsons21)){
                                                                                                            // print_r($cbb."-".$jsons21);
                                                                                                            // echo "<br/><br/><br/>";
                                                                                                            if(strcmp($cbb, "$") == 0){	
                                                                                                                $details4["carryonallowanceinfo"]=$jsons21;
                                                                                                            }	
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                                }
                                                                                                $count23++;
                                                                                            }
                                                                                        }
                                                                                        $count22++;
                                                                                    }
                                                                                }else{
                                                                                    if($count21==5){
                                                                                        // print_r($jsons18);
                                                                                        // echo "<br/><br/><br/>";
                                                                                        $count25=1;
                                                                                        foreach($jsons18 as $jsons19){
                                                                                            // print_r($jsons19);
                                                                                            // echo "<br/><br/><br/>";
                                                                                            if($count25==2){
                                                                                                foreach($jsons19 as $cbb => $jsons20){
                                                                                                    // print_r($jsons20);
                                                                                                    // echo "<br/><br/><br/>";
                                                                                                    if(is_string($jsons20)){
                                                                                                        // print_r($cbb."-".$jsons21);
                                                                                                        // echo "<br/><br/><br/>";
                                                                                                        if(strcmp($cbb, "$") == 0){	
                                                                                                            $details4["carryonallowanceinfo"]=$jsons20;
                                                                                                        }	
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            $count25++;
                                                                                        }
                                                                                    }
                                                                                }
                                                                                $count21++;
                                                                            }
                                                                        }
                                                                        
                                                                        $count17++;
                                                                    }
                                                                }
                                                                $data->push(["details"=>$details4]);
                                                            }
                                                            if(array_key_exists('common_v42_0:HostToken', $jsons14)){
                                                                // print_r($jsons14['common_v42_0:HostToken']);
                                                                $HostToken=[];
                                                                foreach($jsons15 as $hst => $jsons16){
                                                                        if(is_string($jsons16)){
                                                                            if(strcmp($hst, "@Key") == 0){
                                                                                $HostToken["Key"] =$jsons16;
                                                                            }
                                                                            if(strcmp($hst, "$") == 0){
                                                                                $HostToken["HostTokenValue"] =$jsons16;
                                                                            }
                                                                        }
                                                                }
                                                            }
                                                            // return $price;
                                                            $data->push(["price"=>$price]);
                                                            $data->push(["AirPricingInfo"=>$AirPricingInfo]);
                                                            $data->push(["FareInfo"=>$FareInfo]);
                                                            $data->push(["FareRuleKey"=>$FareRuleKey]);
                                                            $data->push(["BookingInfo"=>$BookingInfo1]);
                                                            $data->push(["HostToken"=>$HostToken]);
                                                            $data->push(["TaxInfo"=>$TaxInfo]);
                                                            $data->push(["FareCalc"=>$FareCalc]);
                                                            $data->push(["PassengerType"=>$PassengerType]);
                                                        }
                                                        $count1++;
                                                    }
                                                }
                                            }
                                            // print_r($jsons3);
                                            // echo "<br/>"; 
                                        }
                                        $count++;
                                    }
                                
                                }
                                // print_r($jsons2);
                                // echo "<br/><br/><br/><br/><br/>"; 
                            }
                        } 
                    }
                }
        }
        return $data;
    }

    public function PaymentCredit(Request $request){
        // return $request;
        // db query
        $converted=Leads::where('email',$request->email)->value('converted');
        if ($converted==1) {
            // return $converted."  if";
            $client_id=Leads::where('email',$request->email)->value('client_id');
            $unique_id = client::where('id',$client_id)->value('unique_id');
            // return $client_id;
            // "receiver_name": "304", clients_id

        }else{
            // return $request;
            // return $converted."  else";
            $lead_id=Leads::where('email',$request->email)->value('id');
            // return $lead_id;
            $client = new client;
            
            $test_client = client::where('unique_id','CLDC0001')->get();
            if ($test_client->count()>0) {
                $latest = client::orderBy('id','desc')->take(1)->get();
                $client_prev_no = $latest[0]->unique_id;
                $unique_id = 'CLDC000'.(substr($client_prev_no,4,7)+1);
            }else{
                $unique_id = 'CLDC0001';
            }
            
            $client->unique_id = $unique_id;
            // $client->creator_id = Auth::user()->id;
            $client->first_name = $request->first_name1;
            $client->last_name = $request->last_name1;
            $client->address = $request->add_1.", ".$request->add_2;
            $client->postal_code = $request->postcode;
            $client->city = $request->city;
            // $client->county = $request->county;
            $client->country = $request->country;
            $client->DOB = Carbon::parse($request->date_of_birth1)->format('d-m-Y');
            $client->email = $request->email;
            $client->phone = $request->mob_no;
            $client->permanent = 0;
            $client->client_type = $request->client_type;
            $client->save();

            // $request->lead_id  // mean id
            $lead = Leads::find($lead_id);
            $lead->client_id = $client->id;
            $lead->converted = 1;
            $lead->save();

            $client = client::where('email',$request->email)->take(1)->get();
            $user = new User;
            $user->name = $client[0]->first_name ." ". $client[0]->last_name;
            $user->email = $client[0]->email;
            $user->password = bcrypt('pass@123');
            
            // $user->assignRole('Client');
            $user->save();
            $client[0]->user_id = $user->id;
            $client[0]->save();
            // $invite->delete();
            DB::table('model_has_roles')->insert([
                'role_id' => 11,
                'model_type'=>'App\User',
                'model_id' => $user->id,
            ]);
            $email=$request->email;
            $LeaderName=$request->first_name1." ".$request->last_name1;
            // Mail::to($email)->send(new SendCredentialsEmail($LeaderName,$email));

            $client_id=isset($client->id)?$client->id:$client[0]->id;
            // return $client_id;
        }
        // return $request;
        
        // return $request;
        
       
        // return $invoice;







        
        $flight=json_decode($request->flight, true);
        // return $flight;
        // return $flight[0]['journey'];
        // return $flight[2];
        // return $flight[2]['price']['TotalPrice'];

        $var_country_code=$request->country_code;
        $var_currency_code=DB::table('countries')->where('country_code',$var_country_code)->value('currency_code');
        $currency_xml='';
        if($var_currency_code!=''){
            $currency_xml='<air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="'.$var_currency_code.'">
            <air:BrandModifiers ModifierType="FareFamilyDisplay" />
            </air:AirPricingModifiers>';
        }else{
            // $currency_xml='<air:AirPricingModifiers/>'; 
        }
        
        $datasegment='';
        foreach($flight[0] as $journeys){
            for ($i=0; $i < count($journeys); $i++) {
                // echo get_object_vars($journeys[$i]->Key)[0];
                // return $journeys[$i]['key'];
                $datasegment.='<air:AirSegment Key="'.$journeys[$i]['key'].'" Group="'.$journeys[$i]['Group'].'" Carrier="'.$journeys[$i]['Carrier'].'" FlightNumber="'.$journeys[$i]['FlightNumber'].'" ProviderCode="1G" Origin="'.$journeys[$i]['Origin'].'" Destination="'.$journeys[$i]['Destination'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" Distance="'.$journeys[$i]['Distance'].'" ClassOfService="'.$journeys[$i]['ClassOfService'].'" Equipment="E90" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
                <air:CodeshareInfo OperatingCarrier="'.$journeys[$i]['Carrier'].'"></air:CodeshareInfo>
                <air:FlightDetails Key="" Origin="'.$journeys[$i]['Origin'].'" Destination="'.$journeys[$i]['Destination'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" Distance="'.$journeys[$i]['Distance'].'"/>
                </air:AirSegment>
                ';
                // $datasegment.='<air:AirSegment Key="'.$journeys[$i]['key'].'" Group="'.$journeys[$i]['Group'].'" Carrier="'.$journeys[$i]['Carrier'].'" FlightNumber="'.$journeys[$i]['FlightNumber'].'" ProviderCode="1G" Origin="'.$journeys[$i]['Origin'].'" Destination="'.$journeys[$i]['Destination'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" Distance="'.$journeys[$i]['Distance'].'" ClassOfService="'.$journeys[$i]['ClassOfService'].'" Equipment="E90" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
                // <air:CodeshareInfo OperatingCarrier="'.$journeys[$i]['Carrier'].'"></air:CodeshareInfo>
                // <air:FlightDetails Key="" Origin="'.$journeys[$i]['Origin'].'" Destination="'.$journeys[$i]['Destination'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" Distance="'.$journeys[$i]['Distance'].'"/>
                // </air:AirSegment>
                // ';
            }
        }
        // return count($journeys);
        // return $datasegment;
        // AirPricingInfo 
        // return $flight;
        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;
        $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo='';
        foreach($flight[3] as $AirPricingInfo){
            for ($i=0; $i < count($AirPricingInfo); $i++) {
                // echo $AirPricingInfo[$i]['TotalPrice'];
                // FareInfo
                foreach($flight[4] as $FareInfo){
                    // FareRuleKey
                    foreach($flight[5] as $FareRuleKey){
                        // BookingInfo 
                        foreach($flight[6] as $BookingInfo){
                            if(count($journeys)>1) {
                                // return "hii";
                                $var1='<air:AirPricingInfo PricingMethod="Auto" Key="'.$AirPricingInfo[$i]['Key'].'" TotalPrice="'.$AirPricingInfo[$i]['TotalPrice'].'" BasePrice="'.$AirPricingInfo[$i]['BasePrice'].'" ApproximateTotalPrice="'.$AirPricingInfo[$i]['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$AirPricingInfo[$i]['ApproximateBasePrice'].'" Taxes="'.$AirPricingInfo[$i]['Taxes'].'" ProviderCode="'.$AirPricingInfo[$i]['ProviderCode'].'">';
                                // if($i==0){
                                //     $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[$i]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[$i]['DepartureDate'].'" Amount="'.$FareInfo[$i]['Amount'].'" EffectiveDate="'.$FareInfo[$i]['EffectiveDate'].'" Destination="'.$FareInfo[$i]['Destination'].'" Origin="'.$FareInfo[$i]['Origin'].'" PassengerTypeCode="'.$FareInfo[$i]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[$i]['FareBasis'].'">
                                //         <air:FareRuleKey FareInfoRef="'.$FareRuleKey[$i]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[$i]['ProviderCode'].'">'.$FareRuleKey[$i]['FareRuleKeyValue'].'</air:FareRuleKey>
                                //     </air:FareInfo>
                                //     <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i+1)]['DepartureDate'].'" Amount="'.$FareInfo[($i+1)]['Amount'].'" EffectiveDate="'.$FareInfo[($i+1)]['EffectiveDate'].'" Destination="'.$FareInfo[($i+1)]['Destination'].'" Origin="'.$FareInfo[($i+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i+1)]['FareBasis'].'">
                                //         <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i+1)]['ProviderCode'].'">'.$FareRuleKey[($i+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                //     </air:FareInfo>
                                //     <air:BookingInfo BookingCode="'.$BookingInfo[$i]['BookingCode'].'" CabinClass="'.$BookingInfo[$i]['CabinClass'].'" FareInfoRef="'.$BookingInfo[$i]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[$i]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[$i]['HostTokenRef'].'" />
                                //     <air:BookingInfo BookingCode="'.$BookingInfo[($i+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i+1)]['HostTokenRef'].'" />
                                //     ';
                                // }else{
                                if(count($journeys)==2){  
                                    // return count($journeys);
                                    // return count($AirPricingInfo);
                                    
                                    // return $journeys[(($i*2)+1)]['Carrier']; 
                                    // return $FareInfo[(($i*2)+1)]['Key']; 
                                    // if($journeys[0]['Carrier']==$journeys[1]['Carrier'] && count($AirPricingInfo)==1){
                                    //     // return "hii";
                                    //     $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                    // ';
                                    // }else 
                                    // if($journeys[0]['Carrier']==$journeys[1]['Carrier'] && count($AirPricingInfo)>1){
                                    if(isset($FareInfo[($i)]['Key']) && isset($FareRuleKey[($i)]['FareInfoRef']) && isset($BookingInfo[($i*2)]['BookingCode'])){
                                        // return "hii";
                                        $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i)]['DepartureDate'].'" Amount="'.$FareInfo[($i)]['Amount'].'" EffectiveDate="'.$FareInfo[($i)]['EffectiveDate'].'" Destination="'.$FareInfo[($i)]['Destination'].'" Origin="'.$FareInfo[($i)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i)]['FareBasis'].'">
                                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i)]['ProviderCode'].'">'.$FareRuleKey[($i)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    </air:FareInfo>
                                    <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                    <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                    ';
                                    }
                                    // else if(isset($FareInfo[($i*2)]['Key']) && isset($FareInfo[(($i*2)+1)]['Key'])){
                                    //         $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                    //         <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    //     </air:FareInfo>
                                    //     <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*2)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*2)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*2)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*2)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*2)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*2)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*2)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*2)+1)]['FareBasis'].'">
                                    //         <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*2)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*2)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*2)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    //     </air:FareInfo>
                                    //     <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                    //     <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                    //     ';
                                    // }
                                    else{
                                        return $this->BookingFailedResponce($request);
                                        
                                    }
                                    
                                }else{
                                    // }else if(count($journeys)==3){
                                    //     $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*3)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*3)]['DepartureDate'].'" Amount="'.$FareInfo[($i*3)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*3)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*3)]['Destination'].'" Origin="'.$FareInfo[($i*3)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*3)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*3)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*3)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*3)]['ProviderCode'].'">'.$FareRuleKey[($i*3)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*3)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*3)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*3)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*3)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*3)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*3)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*3)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*3)+1)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*3)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*3)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*3)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*3)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*3)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*3)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*3)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*3)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*3)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*3)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*3)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*3)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*3)+1)]['HostTokenRef'].'" />
                                    // '; 
                                    $journeyCount=count($journeys);
                                    if(isset($FareInfo[($i*$journeyCount)]['Key']) && isset($FareInfo[(($i*$journeyCount)+1)]['Key'])){
                                        $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*$journeyCount)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*$journeyCount)]['DepartureDate'].'" Amount="'.$FareInfo[($i*$journeyCount)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*$journeyCount)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*$journeyCount)]['Destination'].'" Origin="'.$FareInfo[($i*$journeyCount)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*$journeyCount)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*$journeyCount)]['FareBasis'].'">
                                    <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*$journeyCount)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*$journeyCount)]['ProviderCode'].'">'.$FareRuleKey[($i*$journeyCount)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    </air:FareInfo>
                                    <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*$journeyCount)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*$journeyCount)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*$journeyCount)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*$journeyCount)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*$journeyCount)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*$journeyCount)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*$journeyCount)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*$journeyCount)+1)]['FareBasis'].'">
                                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*$journeyCount)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*$journeyCount)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*$journeyCount)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    </air:FareInfo>
                                    <air:BookingInfo BookingCode="'.$BookingInfo[($i*$journeyCount)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*$journeyCount)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*$journeyCount)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*$journeyCount)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*$journeyCount)]['HostTokenRef'].'" />
                                    <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+1)]['HostTokenRef'].'" />
                                    '; 
                                    }else{
                                        return $this->BookingFailedResponce($request);
                                        
                                    }
                                }
                                // return "hii";
                                $var_adtcount='';
                                // return $var_adults;
                                if ($i==0) {
                                    // return $var_adults;
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        // return $j;
                                        $var_adtcount.='<air:PassengerType Code="ADT" BookingTravelerRef="ADT'.$j.'"/>';
                                    }
                                }
                                if($i==1){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="CNN" BookingTravelerRef="CNN'.$j.'"/>';
                                    } 
                                }
                                if($i==2){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="INF" BookingTravelerRef="INF'.$j.'"/>';
                                    } 
                                }
                                // return $var_adtcount;
                                $var2='</air:AirPricingInfo>';
                                // $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.=$var1.$fare_info.$var_adtcount.$var2;
                                $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.=$var1.$fare_info.$var_adtcount.$currency_xml.$var2;
                            }else{
                                $var1='<air:AirPricingInfo PricingMethod="Auto" Key="'.$AirPricingInfo[$i]['Key'].'" TotalPrice="'.$AirPricingInfo[$i]['TotalPrice'].'" BasePrice="'.$AirPricingInfo[$i]['BasePrice'].'" ApproximateTotalPrice="'.$AirPricingInfo[$i]['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$AirPricingInfo[$i]['ApproximateBasePrice'].'" Taxes="'.$AirPricingInfo[$i]['Taxes'].'" ProviderCode="'.$AirPricingInfo[$i]['ProviderCode'].'">
                                <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[$i]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[$i]['DepartureDate'].'" Amount="'.$FareInfo[$i]['Amount'].'" EffectiveDate="'.$FareInfo[$i]['EffectiveDate'].'" Destination="'.$FareInfo[$i]['Destination'].'" Origin="'.$FareInfo[$i]['Origin'].'" PassengerTypeCode="'.$FareInfo[$i]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[$i]['FareBasis'].'">
                                    <air:FareRuleKey FareInfoRef="'.$FareRuleKey[$i]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[$i]['ProviderCode'].'">'.$FareRuleKey[$i]['FareRuleKeyValue'].'</air:FareRuleKey>
                                </air:FareInfo>
                                <air:BookingInfo BookingCode="'.$BookingInfo[$i]['BookingCode'].'" CabinClass="'.$BookingInfo[$i]['CabinClass'].'" FareInfoRef="'.$BookingInfo[$i]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[$i]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[$i]['HostTokenRef'].'" />
                                ';
                                $var_adtcount='';
                                if ($i==0) {
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="ADT" BookingTravelerRef="ADT'.$j.'" />';
                                    }
                                }
                                if($i==1){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="CNN" BookingTravelerRef="CNN'.$j.'" />';
                                    } 
                                }
                                if($i==2){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="INF" BookingTravelerRef="INF'.$j.'" />';
                                    } 
                                }
                                $var2='</air:AirPricingInfo>';
                                // $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.=$var1.$var_adtcount.$var2;
                                $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.=$var1.$var_adtcount.$currency_xml.$var2;
                            }
                        }
                    }
                }
            }
        }
        // return $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo;

        // return $flight;
        // BookingInfo
        $booking_info='';
        foreach($flight[6] as $BookingInfo){
            for ($i=0; $i < count($BookingInfo); $i++) {
                // $booking_info.= $BookingInfo[$i]['BookingCode'];
                $booking_info.='<air:BookingInfo BookingCode="'.$BookingInfo[$i]['BookingCode'].'" CabinClass="'.$BookingInfo[$i]['CabinClass'].'" FareInfoRef="'.$BookingInfo[$i]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[$i]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[$i]['HostTokenRef'].'"/>';
            }
        }
        // return $booking_info;
        // host token 
        // return $flight;
        $hostToken='';
        foreach($flight[7] as $hashToken){
            // print_r($hashToken);
            // echo "<br/><br/>";
            for ($i=0; $i < count($hashToken); $i++) {
                // echo $hashToken[$i]['Key'];
                $hostToken.='<HostToken Key="'.$hashToken[$i]['Key'].'" xmlns="http://www.travelport.com/schema/common_v42_0">'.$hashToken[$i]['HostTokenvalue'].'</HostToken>';
            }
        }
        // return $hostToken;

        

        $booking_traveler_details='';
        for ($j=1; $j <= $var_adults; $j++) { 
            $title = "title".$j;
            $first_name = "first_name".$j;
            $last_name = "last_name".$j;
            $gender = "gender".$j;
            $date_of_birth = "date_of_birth".$j;
            $seating = "seating".$j;
            $assistance = "assistance".$j;
            $meal = "meal".$j;

            if ($request->gender=="Male") {
                $gender="M";
            }else{
                $gender="F"; 
            }
            // return $request->$title ;
            $booking_traveler_details.='<com:BookingTraveler Key="ADT'.$j.'" TravelerType="ADT" DOB="'.date("Y-m-d",strtotime($request->$date_of_birth)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BookingTravelerName Prefix="'.$request->$title.'" First="'.$request->$first_name.'" Last="'.$request->$last_name.'"/>
            <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="'.$request->email.'"/>
            <com:SSR Type="DOCS" Carrier="AI" FreeText=""/>
            <com:Address>
                <com:AddressName>'.$request->add_1.'</com:AddressName>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:City>'.$request->city.'</com:City>
                <com:State>'.$request->state_code.'</com:State>
                <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                <com:Country>IN</com:Country>
            </com:Address>
            </com:BookingTraveler>';
        }
        for ($j=1; $j <= $var_children; $j++) { 
            $title = "children_title".$j;
            $first_name = "children_first_name".$j;
            $last_name = "children_last_name".$j;
            $gender = "children_gender".$j;
            $date_of_birth = "children_date_of_birth".$j;
            $seating = "children_seating".$j;
            $assistance = "children_assistance".$j;
            $meal = "children_meal".$j;

            if ($request->gender=="Male") {
                $gender="M";
            }else{
                $gender="F"; 
            }

            $booking_traveler_details.='<com:BookingTraveler Key="CNN'.$j.'" TravelerType="CNN" DOB="'.date("Y-m-d",strtotime($request->$date_of_birth)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BookingTravelerName Prefix="'.$request->$title.'" First="'.$request->$first_name.'" Last="'.$request->$last_name.'"/>
            <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="'.$request->email.'"/>
            <com:SSR Type="DOCS" Carrier="AI" FreeText=""/>
            <com:Address>
                <com:AddressName>'.$request->add_1.'</com:AddressName>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:City>'.$request->city.'</com:City>
                <com:State>'.$request->state_code.'</com:State>
                <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                <com:Country>IN</com:Country>
            </com:Address>
            </com:BookingTraveler>';
        } 
        for ($j=1; $j <= $var_infant; $j++) { 
            $title = "infant_title".$j;
            $first_name = "infant_first_name".$j;
            $last_name = "infant_last_name".$j;
            $gender = "infant_gender".$j;
            $date_of_birth = "infant_date_of_birth".$j;
            $seating = "infant_seating".$j;
            $assistance = "infant_assistance".$j;
            $meal = "infant_meal".$j;

            if ($request->gender=="Male") {
                $gender="M";
            }else{
                $gender="F"; 
            }
            $booking_traveler_details.='<com:BookingTraveler Key="INF'.$j.'" TravelerType="INF" DOB="'.date("Y-m-d",strtotime($request->$date_of_birth)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BookingTravelerName Prefix="'.$request->$title.'" First="'.$request->$first_name.'" Last="'.$request->$last_name.'"/>
            <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="'.$request->email.'"/>
            <com:SSR Type="DOCS" Carrier="AI" FreeText=""/>
            <com:Address>
                <com:AddressName>'.$request->add_1.'</com:AddressName>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:City>'.$request->city.'</com:City>
                <com:State>'.$request->state_code.'</com:State>
                <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                <com:Country>IN</com:Country>
            </com:Address>
            </com:BookingTraveler>';
        } 
        // return $booking_traveler_details;
        // return $datasegment;


        $CREDENTIALS = app('App\Http\Controllers\UniversalConfigAPIController')->CREDENTIALS();
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
        // $TARGETBRANCH = 'P7141733';
        // $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        // $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');
        // return $request->gender1;
        
        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <univ:AirCreateReservationReq RetainReservation="Both" TraceId="trace" TargetBranch="'.$TARGETBRANCH.'" AuthorizedBy="user" xmlns:univ="http://www.travelport.com/schema/universal_v42_0">
                <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
                '.$booking_traveler_details.'
                <GeneralRemark UseProviderNativeMode="true" TypeInGds="Basic" xmlns="http://www.travelport.com/schema/common_v42_0">
                    <RemarkData>Booking 1</RemarkData>
                </GeneralRemark>
                <com:ContinuityCheckOverride Key="" xmlns:com="http://www.travelport.com/schema/common_v42_0">true</com:ContinuityCheckOverride>
                <com:FormOfPayment Key="" Type="Credit" xmlns:com="http://www.travelport.com/schema/common_v42_0">
                    <com:CreditCard Type="CA" Number="5555555555555557" ExpDate="2022-03" Name="JAYA KUMAR" CVV="123" Key="">
                        <com:BillingAddress>
                            <com:AddressName>Jan Testora</com:AddressName>
                            <com:Street>6901 S. Havana</com:Street>
                            <com:Street>Apt 2</com:Street>
                            <com:City>Englewood</com:City>
                            <com:State>CO</com:State>
                            <com:PostalCode>8011</com:PostalCode>
                            <com:Country>AU</com:Country>
                        </com:BillingAddress>
                    </com:CreditCard>
                </com:FormOfPayment>
                <air:AirPricingSolution Key="'.$flight[2]['price']['Key'].'" TotalPrice="'.$flight[2]['price']['TotalPrice'].'" BasePrice="'.$flight[2]['price']['BasePrice'].'" ApproximateTotalPrice="'.$flight[2]['price']['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$flight[2]['price']['ApproximateBasePrice'].'" Taxes="'.$flight[2]['price']['Taxes'].'" Fees="'.$flight[2]['price']['Fees'].'" ApproximateTaxes="'.$flight[2]['price']['ApproximateTaxes'].'" QuoteDate="'.$flight[2]['price']['QuoteDate'].'" xmlns:air="http://www.travelport.com/schema/air_v42_0">
                    '.$datasegment
                    .$var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.
                    $hostToken.'
                </air:AirPricingSolution>
                <com:ActionStatus TicketDate="T*" Type="ACTIVE" ProviderCode="'.$Provider.'" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
            </univ:AirCreateReservationReq>
        </soap:Body>
    </soap:Envelope>';
    // return $query;
            $message = <<<EOM
$query
EOM;
        $auth = base64_encode($CREDENTIALS);
        // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
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
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($soap_do);
        curl_close($soap_do);
        // return $return;
        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);
        // return $object;
        $data=collect();
        foreach($object as $json1){
            // print_r($json1);
            // echo "<br/><br/>";
            foreach($json1 as $json2){
                // print_r($json2);
                // echo "<br/><br/>";  
                if(count($json2)>1){
                    // print_r($json2);
                    foreach($json2 as $json3){
                        // print_r($json3);
                        // echo "<br/><br/>";
                        if(count($json3)>1){
                            // print_r($json3);
                            $count=1;
                            foreach($json3 as $json4){
                                // print_r($json4);
                                // echo "<br/><br/>";
                                if($count==6){
                                    // print_r($json4);
                                    $count1=1;
                                    foreach($json4 as $key => $json5){
                                        // echo $count1;
                                        // print_r($json5);
                                        // echo "<br/><br/>";
                                        if(is_string($json5)){
                                            // print_r( $key." -- ".$json5); 
                                            if(strcmp($key, "@LocatorCode") == 0){
                                                $data['UniversalRecord']=$json5;
                                            }
                                        }
                                        if( $count1==8){
                                            $count2=1;
                                            foreach($json5 as $airkey => $json6){
                                                // echo $count2;
                                                // print_r($json6);
                                                // echo "<br/><br/>";
                                                if(strcmp($airkey, "@LocatorCode") == 0){
                                                    $data['AirReservation']=$json6;
                                                }
                                                if($count2==9){
                                                    // print_r($json6);
                                                    // echo "<br/><br/>";
                                                    $AirPricingInfo1=collect();
                                                    $AirPricingInfo=[];
                                                    $AirPricingInfo0=[];
                                                    foreach($json6 as $api => $json7){
                                                        // print_r($json7);
                                                        // echo "<br/><br/>";
                                                        if(is_string($json7)){
                                                            // print_r( $api." -- ".$json7); 
                                                            // echo "<br/><br/>";
                                                            if(strcmp($api, "@Key") == 0){
                                                                $AirPricingInfo['Key']=$json7;
                                                            }
                                                            if(strcmp($api, "@TotalPrice") == 0){
                                                                $AirPricingInfo['TotalPrice']=$json7;
                                                            }
                                                            if(strcmp($api, "@BasePrice") == 0){
                                                                $AirPricingInfo['BasePrice']=$json7;
                                                            }
                                                            if(strcmp($api, "@ApproximateTotalPrice") == 0){
                                                                $AirPricingInfo['ApproximateTotalPrice']=$json7;
                                                            }
                                                            if(strcmp($api, "@ApproximateBasePrice") == 0){
                                                                $AirPricingInfo['ApproximateBasePrice']=$json7;
                                                            }
                                                            if(strcmp($api, "@EquivalentBasePrice") == 0){
                                                                $AirPricingInfo['EquivalentBasePrice']=$json7;
                                                            }
                                                            if(strcmp($api, "@Taxes") == 0){
                                                                $AirPricingInfo['Taxes']=$json7;
                                                            }
                                                            if(strcmp($api, "@LatestTicketingTime") == 0){
                                                                $AirPricingInfo['LatestTicketingTime']=$json7;
                                                            }
                                                            if(strcmp($api, "@TrueLastDateToTicket") == 0){
                                                                $AirPricingInfo['TrueLastDateToTicket']=$json7;
                                                            }
                                                            if(strcmp($api, "@PricingMethod") == 0){
                                                                $AirPricingInfo['PricingMethod']=$json7;
                                                            }
                                                            if(strcmp($api, "@Refundable") == 0){
                                                                $AirPricingInfo['Refundable']=$json7;
                                                            }
                                                            if(strcmp($api, "@Exchangeable") == 0){
                                                                $AirPricingInfo['Exchangeable']=$json7;
                                                            }
                                                            if(strcmp($api, "@IncludesVAT") == 0){
                                                                $AirPricingInfo['IncludesVAT']=$json7;
                                                            }
                                                            if(strcmp($api, "@ETicketability") == 0){
                                                                $AirPricingInfo['ETicketability']=$json7;
                                                            }
                                                            if(strcmp($api, "@ProviderCode") == 0){
                                                                $AirPricingInfo['ProviderCode']=$json7;
                                                            }
                                                            if(strcmp($api, "@ProviderReservationInfoRef") == 0){
                                                                $AirPricingInfo['ProviderReservationInfoRef']=$json7;
                                                            }
                                                            if(strcmp($api, "@AirPricingInfoGroup") == 0){
                                                                $AirPricingInfo['AirPricingInfoGroup']=$json7;
                                                            }
                                                            if(strcmp($api, "@PricingType") == 0){
                                                                $AirPricingInfo['PricingType']=$json7;
                                                            }
                                                            if(strcmp($api, "@ElStat") == 0){
                                                                $AirPricingInfo['ElStat']=$json7;
                                                            }
                                                            if(strcmp($api, "@FareCalculationInd") == 0){
                                                                $AirPricingInfo['FareCalculationInd']=$json7;
                                                            }


                                                        }else{
                                                            // print_r($json7);
                                                            // echo "<br/><br/>";
                                                           foreach($json7 as $api => $json8) {
                                                            if(is_string($json8)){
                                                                // print_r( $api." -- ".$json7); 
                                                                // echo "<br/><br/>";
                                                                if(strcmp($api, "@Key") == 0){
                                                                    $AirPricingInfo0['Key']=$json8;
                                                                }
                                                                if(strcmp($api, "@TotalPrice") == 0){
                                                                    $AirPricingInfo0['TotalPrice']=$json8;
                                                                }
                                                                if(strcmp($api, "@BasePrice") == 0){
                                                                    $AirPricingInfo0['BasePrice']=$json8;
                                                                }
                                                                if(strcmp($api, "@ApproximateTotalPrice") == 0){
                                                                    $AirPricingInfo0['ApproximateTotalPrice']=$json8;
                                                                }
                                                                if(strcmp($api, "@ApproximateBasePrice") == 0){
                                                                    $AirPricingInfo0['ApproximateBasePrice']=$json8;
                                                                }
                                                                if(strcmp($api, "@EquivalentBasePrice") == 0){
                                                                    $AirPricingInfo0['EquivalentBasePrice']=$json8;
                                                                }
                                                                if(strcmp($api, "@Taxes") == 0){
                                                                    $AirPricingInfo0['Taxes']=$json8;
                                                                }
                                                                if(strcmp($api, "@LatestTicketingTime") == 0){
                                                                    $AirPricingInfo0['LatestTicketingTime']=$json8;
                                                                }
                                                                if(strcmp($api, "@TrueLastDateToTicket") == 0){
                                                                    $AirPricingInfo0['TrueLastDateToTicket']=$json8;
                                                                }
                                                                if(strcmp($api, "@PricingMethod") == 0){
                                                                    $AirPricingInfo0['PricingMethod']=$json8;
                                                                }
                                                                if(strcmp($api, "@Refundable") == 0){
                                                                    $AirPricingInfo0['Refundable']=$json8;
                                                                }
                                                                if(strcmp($api, "@Exchangeable") == 0){
                                                                    $AirPricingInfo0['Exchangeable']=$json8;
                                                                }
                                                                if(strcmp($api, "@IncludesVAT") == 0){
                                                                    $AirPricingInfo0['IncludesVAT']=$json8;
                                                                }
                                                                if(strcmp($api, "@ETicketability") == 0){
                                                                    $AirPricingInfo0['ETicketability']=$json8;
                                                                }
                                                                if(strcmp($api, "@ProviderCode") == 0){
                                                                    $AirPricingInfo0['ProviderCode']=$json8;
                                                                }
                                                                if(strcmp($api, "@ProviderReservationInfoRef") == 0){
                                                                    $AirPricingInfo0['ProviderReservationInfoRef']=$json8;
                                                                }
                                                                if(strcmp($api, "@AirPricingInfoGroup") == 0){
                                                                    $AirPricingInfo0['AirPricingInfoGroup']=$json8;
                                                                }
                                                                if(strcmp($api, "@PricingType") == 0){
                                                                    $AirPricingInfo0['PricingType']=$json8;
                                                                }
                                                                if(strcmp($api, "@ElStat") == 0){
                                                                    $AirPricingInfo0['ElStat']=$json8;
                                                                }
                                                                if(strcmp($api, "@FareCalculationInd") == 0){
                                                                    $AirPricingInfo0['FareCalculationInd']=$json8;
                                                                }
    
    
                                                            }
                                                           }

                                                        }
                                                        if(empty($AirPricingInfo) && !empty($AirPricingInfo0)){
                                                            $AirPricingInfo1->push($AirPricingInfo0);
                                                        }
                                                    }
                                                    if(!empty($AirPricingInfo)){
                                                        $AirPricingInfo1->push($AirPricingInfo);
                                                    }
                                                    // $data(['AirPricingInfo']=$AirPricingInfo;
                                                    $data->push(['AirPricingInfo'=>collect($AirPricingInfo1)]);

                                                }
                                                $count2++;
                                            } 
                                        }
                                        $count1++;
                                    }
                                }
                                $count++;
                            }
                        }

                    }
                }
            }
        }
        // return $data;
        if(count($data)==0){
            // return "hii";
            $unidata=[];
            $alldetails=[];
            return view('flights.confirm-booking',[
                'searched'=>$request,
                'airreservation'=>$data,
                'airticketing'=>$alldetails,
                'unidata'=>$unidata
            ]);
        }
        // return $data[0];
        // echo $data['UniversalRecord']." <br/>";
        $AirPricingInfoRef='';
        foreach($data[0] as $datas){
            foreach($datas as $datas1){
                // echo $datas1['Key'];
                $AirPricingInfoRef.='<air:AirPricingInfoRef Key="'.$datas1['Key'].'" />';
            }
        }
        // print_r($data[0]);
        // return $data[0];

        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <air:AirTicketingReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" TraceId="trace" xmlns:air="http://www.travelport.com/schema/air_v42_0">
            <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
            <air:AirReservationLocatorCode>'.$data['AirReservation'].'</air:AirReservationLocatorCode>
            '.$AirPricingInfoRef.'
            </air:AirTicketingReq>   
        </soap:Body>
    </soap:Envelope>';
    // return $query;
            $message = <<<EOM
$query
EOM;
        $auth = base64_encode($CREDENTIALS);
        // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
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
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        $return1 = curl_exec($soap_do);
        curl_close($soap_do);
        // return $return1;
        $dom1 = new \DOMDocument();
        $dom1->loadXML($return1);
        $json1 = new \FluentDOM\Serializer\Json\RabbitFish($dom1);
        $object1 = json_decode($json1,true);
        // return $object1;
        $alldetails=[];
        // $AirTicketingReq=collect();
        foreach($object1 as $jsonss){
            foreach($jsonss as $jsonss1){
                // print_r($jsonss1);
                // echo "<br/><br/>";
                if(count($jsonss1)==2){
                    // print_r($jsonss1);
                    // echo "<br/><br/>";
                    foreach($jsonss1 as $jsonss2){
                        // print_r($jsonss2);
                        // echo "<br/><br/>";
                        // if(count($jsonss2)==2){
                        //     print_r($jsonss2);
                        //     echo "<br/><br/>";
                            $count_tic=1;
                            $alldetails=[];
                            foreach($jsonss2 as $key => $jsonss3){
                                // echo $count_tic;
                                // print_r($jsonss3);
                                // echo "<br/><br/>";
                                if(is_string($jsonss3)){
                                    // print_r($k." - ".$jsonss3);
                                    // echo "<br/><br/>";  
                                    if(strcmp($key, "@TransactionId") == 0){
                                        $alldetails['TransactionId']=$jsonss3;
                                    }
                                    if(strcmp($key, "@ResponseTime") == 0){
                                        $alldetails['ResponseTime']=$jsonss3;
                                    }
                                }
                                if($count_tic==5){
                                    // print_r($jsonss3);
                                    // echo "<br/><br/>";
                                    $count_tic1=1;
                                    foreach($jsonss3 as $key2 => $jsonss4){
                                        // echo $count_tic1;
                                        // print_r($jsonss4);
                                        // echo "<br/><br/>"; 
                                        if(is_string($jsonss4)){
                                            // print_r($key2." - ".$jsonss4);
                                            // echo "<br/><br/>";
                                            if(strcmp($key2, "@Code") == 0){
                                                $alldetails['Code']=$jsonss4;
                                            }
                                            if(strcmp($key2, "@BookingTravelerRef") == 0){
                                                $alldetails['BookingTravelerRef']=$jsonss4;
                                            }
                                        }
                                        if($count_tic1==5){
                                            foreach($jsonss4 as $valk => $jsonss5){
                                                // print_r($jsonss5);
                                                // echo "<br/><br/>";
                                                if(is_string($jsonss5)){
                                                    // print_r($valk." - ".$jsonss5);
                                                    // echo "<br/><br/>";  
                                                    if(strcmp($valk, "@Key") == 0){
                                                        $alldetails['AirPricingInfoRef']=$jsonss5;
                                                    }
                                                }
                                            }
                                        }
                                        if($count_tic1==6){
                                            // print_r($jsonss4);
                                            // echo "<br/><br/>";
                                            foreach($jsonss4 as $valk => $jsonss5){
                                                // print_r($jsonss5);
                                                // echo "<br/><br/>";
                                                if(is_string($jsonss5)){
                                                    // print_r($valk." - ".$jsonss5);
                                                    // echo "<br/><br/>";  
                                                    if(strcmp($valk, "@Prefix") == 0){
                                                        $alldetails['Prefix']=$jsonss5;
                                                    }
                                                    if(strcmp($valk, "@First") == 0){
                                                        $alldetails['First']=$jsonss5;
                                                    }
                                                    if(strcmp($valk, "@Last") == 0){
                                                        $alldetails['Last']=$jsonss5;
                                                    }
                                                }
                                            }
                                        }
                                        $count_tic1++;
                                    }
                                }
                                
                                $count_tic++;
                            }

                        // }
                    }
                }
            }
        }
        // return $data;
        
        // Universal Record RetrieveReq
        $xml_data =app('App\Http\Controllers\UtilityController')->UniversalRecordRetrieveReq($data['UniversalRecord']);
        // return $xml_data;
        $api_url='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService';
        $return2 =app('App\Http\Controllers\UtilityController')->universal_API($xml_data,$api_url);
        // return $return2;
        $object2 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return2);
        $unidata =app('App\Http\Controllers\XMlToParseDataController')->UniversalRecord($object2);

        // return $unidata;
        // return $data;
        // return $request;

        // db code here

        $country_code=$request->country_code;
        if($country_code==''){
            $country_code='GB'; 
        }

        $currency_code=DB::table('countries')->where('country_code',$country_code)->value('currency_code');
        $currency=DB::table('countries')->where('country_code',$country_code)->value('currency_symbal');



        if (count($unidata[1]['journey'])>1) {
            $journey_stop=["1"];
        }else{
            $journey_stop=["0"];
        }
        $universal_pnr=$data['UniversalRecord'];
        $pnr=$unidata[3]['UniversalRecord']['LocatorCode'];
        $segment_one_flight=[];
        $segment_one_from=[];
        $segment_one_to=[];
        $segment_one_carrier=[];
        $segment_one_class=[];
        $segment_one_Flight_No=[];
        $segment_one_departure=[];
        $segment_one_country_Departure=[];
        $segment_one_country_Arrival=[];
        $segment_one_arrival=[];
        $segment_one_Duration=[];
        $segment_one_terminal_arrival=[];
        $segment_one_terminal_departure=[];
        foreach ($unidata[1]['journey'] as $key => $value) {
            // return $value;
            // return $value['Carrier'];
            array_push($segment_one_flight,$value['Carrier']);
            array_push($segment_one_from,$value['Origin']);
            array_push($segment_one_to,$value['Destination']);
            array_push($segment_one_carrier,7);  // baggage
            array_push($segment_one_class,$value['CabinClass']);
            array_push($segment_one_Flight_No,$value['FlightNumber']);
            array_push($segment_one_departure,$value['DepartureTime']);
            array_push($segment_one_country_Departure,'');  //country name
            array_push($segment_one_country_Arrival,'');//country name
            array_push($segment_one_arrival,$value['ArrivalTime']);
            array_push($segment_one_Duration, \Carbon\Carbon::parse($value['DepartureTime'])->diff(\Carbon\Carbon::parse($value['ArrivalTime']))->format('%Hh %Im'));  //duration 
            array_push($segment_one_terminal_arrival,isset($value['OriginTerminal'])?$value['OriginTerminal']:'');
            array_push($segment_one_terminal_departure,isset($value['DestinationTerminal'])?$value['DestinationTerminal']:'');
        }

        $verify=[];
        $pax_type=[];
        $first_name=[];
        $last_name=[];
        $DOB=[];
        
        foreach ($unidata[0]['personal_details'] as $key => $value) {
            array_push($verify,null);
            array_push($pax_type,$value['TravelerType']);
            array_push($first_name,$value['First']);
            array_push($last_name,$value['Last']);
            array_push($DOB,$value['DOB']);
        }
        
        
        $segment_one_fare_cost=[];
        $segment_one_fare_sell=[];
        foreach ($unidata[2]['price'] as $key => $value) {
            array_push($segment_one_fare_cost,str_replace($currency_code,'',$value['TotalPrice']));
            array_push($segment_one_fare_sell,str_replace($currency_code,'',$value['TotalPrice']));
        }

        $service_name=["Flight"];
        $journey_type=["ONE WAY"];
        $universal_pnr=[$universal_pnr];
        $pnr=[$pnr];
        $agency_pcc=[null];
        $booking_date=[date('Y-m-d')];
        $airline_ref=[null];

        $jsonData=[];
        $jsonData['service_name']=$service_name;
        $jsonData['journey_type']=$journey_type;
        $jsonData['journey_stop']=$journey_stop;
        $jsonData['universal_pnr']=$universal_pnr;
        $jsonData['pnr']=$pnr;
        $jsonData['agency_pcc']=$agency_pcc;
        $jsonData['booking_date']=$booking_date;
        $jsonData['airline_ref']=$airline_ref;
        $jsonData['segment_one_flight']=$segment_one_flight;  
        $jsonData['segment_one_from']=$segment_one_from;
        $jsonData['segment_one_to']=$segment_one_to;
        $jsonData['segment_one_carrier']=$segment_one_carrier;
        $jsonData['segment_one_class']=$segment_one_class;
        $jsonData['segment_one_Flight_No']=$segment_one_Flight_No;
        $jsonData['segment_one_departure']=$segment_one_departure;
        $jsonData['segment_one_country_Departure']=$segment_one_country_Departure;
        $jsonData['segment_one_country_Arrival']=$segment_one_country_Arrival;
        $jsonData['segment_one_arrival']=$segment_one_arrival;
        $jsonData['segment_one_Duration']=$segment_one_Duration;
        $jsonData['segment_one_terminal_arrival']=$segment_one_terminal_arrival;
        $jsonData['segment_one_terminal_departure']=$segment_one_terminal_departure;
        $jsonData['verify']=$verify;
        $jsonData['pax_type']=$pax_type;
        $jsonData['first_name']=$first_name;
        $jsonData['last_name']=$last_name;
        $jsonData['DOB']=$DOB;
        $jsonData['segment_one_fare_cost']=$segment_one_fare_cost;
        $jsonData['segment_one_fare_sell']=$segment_one_fare_sell;
        // $data=[];
        // return $jsonData;

        // return $client_id;
        $total=0;
        foreach($unidata[2] as $key => $datas){
            // return $request;
            $total+=(str_replace($currency_code,'',$datas[0]['TotalPrice'])*$request->adults);
            if(isset($datas[1])){
            $total+=(str_replace($currency_code,'',$datas[1]['TotalPrice'])*$request->children);
            }
            if(isset($datas[2])){
            $total+=(str_replace($currency_code,'',$datas[2]['TotalPrice'])*$request->infant);
            }
        }
        // return $unidata;
        // return $total;
        // echo number_format($var_tot,2);

        // $client_id=307;
        $billing_address='cc\r\nkolkata\r\n700159\r\nhinduism\r\nindia';
        $invoice = invoice::where('invoice_no', 'CLDI0002778')->get();
        if ($invoice->count() > 0) {
            $latest = invoice::withTrashed()->orderBy('created_at', 'desc')->take(1)->get();
            // return $latest;
            $invoice_prev_no = $latest[0]->invoice_no;
            try {
                $invoice_no = 'CLDI000' . (substr($invoice_prev_no, 4, 7) + 1);
                // return $invoice_no;
            } catch (Exception $e) {
                $latest = invoice::withTrashed()->orderBy('created_at', 'desc')->get();

                $insize = count($latest);
                for ($i = 0; $i < $insize; $i++) {

                    $invoice_prev_no = $latest[$i]->invoice_no;

                    if ($invoice_prev_no[3] == "R" or $invoice_prev_no[3] == "C") {
                        continue;
                    } else {
                        $invoice_no = 'CLDI000' . (substr($invoice_prev_no, 4, 7) + 1);
                        break;
                    }
                }

            }

            while (1) {

                $checknumber = invoice::where('invoice_no', '=', $invoice_no)->first();
                if ($checknumber === null) {
                    // checknumber doesn't exist
                    break;
                } else {

                    $invoice_no = 'CLDI000' . (substr($invoice_no, 4, 7) + 1);
                }

            }

        } else {
            $invoice_no = 'CLDI0002778';
        }

        $dt = Carbon::now();
        $date_today = $dt->timezone('Europe/London');
        $date = $date_today->toDateString();
        $invoice = new invoice;
        $client = client::find($client_id);
        $invoice->client_id = $client->id;
        if($request->diff_receiver_name){
            $invoice->receiver_name = $request->diff_receiver_name;
        } else {
            $invoice->receiver_name = strtoupper($client->first_name . ' ' . $client->last_name);
        }
        $invoice->billing_address = strtoupper($billing_address);
        $invoice->invoice_date = date('Y-m-d');
        $invoice->invoice_no = $invoice_no;
        if (!empty($request->discount)) {
            $invoice->discount = str_replace(',', '', $request->discount);
        } else {
            $request->discount = 0.0;
        }
        $invoice->currency = $currency;
        // $invoice->total = str_replace(',', '', $request->total);
        // $invoice->discounted_total = str_replace(',', '', $total) - str_replace(',', '', $request->discount);
        $invoice->total = $total;
        $invoice->discounted_total =  $total -  $request->discount;
        $invoice->mail_sent = $date;
        $invoice->remarks = $request->remarks;
        $invoice->save();
        $tax = settings::all();
        if ($tax[0]->enable == 'yes') {
            $invoice->VAT_percentage = $tax[0]->tax;
            $invoice->VAT_amount = ($tax[0]->tax) / 100 * (str_replace(',', '', $invoice->discounted_total));
        }
        // return $invoice;
        $invoice->paid = 0;
        $request->credit_amount=$total;
        // return $request->credit_amount;
        if ($request->credit_amount != null) {
            $invoice->credit = 1;
            $invoice->credit_amount = $invoice->credit_amount +  $request->credit_amount;
            $invoice->paid = $invoice->paid + $request->credit_amount;
        }
        

        $invoice->pending_amount = $invoice->discounted_total + $invoice->VAT_amount - $invoice->paid;
        $invoice->save();
        $flight_counter = 0;
        $visa_counter = 0;
        $insurance_counter = 0;
        $hotel_counter = 0;
        $local_sight_sceen_counter = 0;
        $local_transport_counter = 0;
        $car_rental_counter = 0;
        $other_facilities_counter = 0;

        // return $unidata[1]['journey'][0];
        // return $universal_pnr;
        // return $journey_type[0];
        $flight = new Flight;
        $flight->invoice_id = $invoice->id;
        $flight->universal_pnr = strtoupper($universal_pnr[0]);
        $flight->booking_date = strtoupper($booking_date[0]);
        $flight->pnr = strtoupper($pnr[0]);
        $flight->agency_pcc = strtoupper($agency_pcc[0]);
        $flight->airline_ref = strtoupper($airline_ref[0]);
        $flight->total_amount = number_format($total,2);
        $flight->segment_one_from = strtoupper($unidata[1]['journey'][0]['Origin']);
        // $flight->segment_two_from = isset($value['segment_two_from']) ? strtoupper($value['segment_two_from'][0]) : '';
        $flight->segment_one_to = strtoupper($unidata[1]['journey'][0]['Destination']);
        // $flight->segment_two_to = isset($value['segment_two_to']) ? strtoupper($value['segment_two_to'][0]) : '';
        $flight->segment_one_carrier = isset($unidata[1]['journey'][0]['segment_one_carrier']) ? strtoupper($unidata[1]['journey'][0]['segment_one_carrier'][0]) : '';
        // $flight->segment_two_carrier = isset($value['segment_two_carrier']) ? strtoupper($value['segment_two_carrier'][0]) : '';
        $flight->segment_one_flight = strtoupper($unidata[1]['journey'][0]['Carrier']);
        // $flight->segment_two_flight = isset($value['segment_two_flight']) ? strtoupper($value['segment_two_flight'][0]) : '';
        $flight->segment_one_class = strtoupper($unidata[1]['journey'][0]['CabinClass']);
        // $flight->segment_two_class = isset($value['segment_two_class']) ? strtoupper($value['segment_two_class'][0]) : '';
        $flight->segment_one_departure = strtoupper($unidata[1]['journey'][0]['DepartureTime']);
        // $flight->segment_two_departure = isset($value['segment_two_departure']) ? strtoupper($value['segment_two_departure'][0]) : '';
        $flight->segment_one_arrival = strtoupper($unidata[1]['journey'][0]['ArrivalTime']);
        // $flight->segment_two_arrival = isset($value['segment_two_arrival']) ? strtoupper($value['segment_two_arrival'][0]) : '';
        $flight->json_data = json_encode($jsonData);
        $flight->journey_type = $journey_type[0];
        $flight->journey_stop = $journey_stop[0];
        $flight->save();

        // return $flight;
        // return $unidata[1]['journey'][0];
        // return $currency;
        // return $unidata[2]['price'][0]['TotalPrice'];
        foreach($unidata[0]['personal_details'] as $key =>$unidatadata){
            // echo  $data['TravelerType'];
            // return $unidata[2]['price'][0]['TotalPrice'];
            $passenger = new Passenger;
            $passenger->flight_id = $flight->id;
            $passenger->pax_type = $unidatadata['TravelerType'];
            $passenger->first_name = $unidatadata['First'];
            $passenger->last_name = $unidatadata['Last'];
            $passenger->DOB = $unidatadata['DOB'];
            if ($unidatadata['TravelerType']=='ADT') {
                $passenger->segment_one_fare_cost = isset($unidata[2]['price'][0]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][0]['TotalPrice']) : '0.00';
                $passenger->segment_one_fare_sell = isset($unidata[2]['price'][0]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][0]['TotalPrice']) : '0.00';
            }else if ($unidatadata['TravelerType']=='CNN') {
                $passenger->segment_one_fare_cost = isset($unidata[2]['price'][1]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][1]['TotalPrice']) : '0.00';
                $passenger->segment_one_fare_sell = isset($unidata[2]['price'][1]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][1]['TotalPrice']) : '0.00';
            }else if ($unidatadata['TravelerType']=='INF') {
                $passenger->segment_one_fare_cost = isset($unidata[2]['price'][2]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][2]['TotalPrice']) : '0.00';
                $passenger->segment_one_fare_sell = isset($unidata[2]['price'][2]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][2]['TotalPrice']) : '0.00';
            }
            // $passenger->segment_one_fare_cost = isset($value['segment_one_fare_cost'][$index]) ? str_replace(',', '', $value['segment_one_fare_cost'][$index]) : '0.00';
            // $passenger->segment_two_fare_cost = isset($value['segment_two_fare_cost'][$index]) ? str_replace(',', '', $value['segment_two_fare_cost'][$index]) : '0.00';
            // $passenger->segment_one_fare_sell = isset($value['segment_one_fare_sell'][$index]) ? str_replace(',', '', $value['segment_one_fare_sell'][$index]) : '0.00';
            // $passenger->segment_two_fare_sell = isset($value['segment_two_fare_sell'][$index]) ? str_replace(',', '', $value['segment_two_fare_sell'][$index]) : '0.00';
            $passenger->save();
        }
        foreach (invoice::all() as $inv) {
            if ($inv->pending_amount < 0) {
                $inv->advance = 0 - $inv->pending_amount;
                $inv->pending_amount = 0;
                $inv->save();
            }
            if ($inv->pending_amount == 0) {
                $inv->status = 1;
                $inv->save();
            }
            if ($inv->pending_amount > 0) {
                $inv->status = 0;
                $inv->save();
            }
        }

        $invoice_id=$invoice->id;

        // return $data;
        return view('flights.confirm-booking',[
            'searched'=>$request,
            'airreservation'=>$data,
            'airticketing'=>$alldetails,
            'unidata'=>$unidata,
            'invoice_no'=>$invoice_no,
            'unique_id'=>$unique_id

        ]);

    }

    public function BookingFailedResponce($request){
        $data=[];
        $alldetails=[];
        $unidata=[];
        return view('flights.confirm-booking',[
            'searched'=>$request,
            'airreservation'=>$data,
            'airticketing'=>$alldetails,
            'unidata'=>$unidata
        ]);
    }
}
