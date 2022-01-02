<?php

namespace App\Http\Controllers\multicity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller
{
    public function ShowPayment(Request $request){
        // return $request;
        $flights1=json_decode($request->flights);
        $flights2=json_decode($request->flights2);
        $flights3=json_decode($request->flights3);

        // return $flights1;
        $all_datasegment='';
        $datasegment1='';
        $data=[];


        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;
        $travel_class =app('App\Http\Controllers\UtilityController')->TravelDetailsDatasagment($var_adults,$var_children,$var_infant);
        // return $travel_class;

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
       
        foreach($flights1 as $journeys){
            $datasegment1.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
        }
        if($flights2 !=''){
            foreach($flights2 as $journeys){
                $datasegment1.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            }
        }
        if($flights3 !=''){
            foreach($flights3 as $journeys){
                $datasegment1.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            }
        }

        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH

        $query1 = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
           <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
              <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirItinerary>
                '.$datasegment1.'
              </air:AirItinerary>
              '.$currency_xml.$travel_class.'
              <air:AirPricingCommand/>
           </air:AirPriceReq>
        </soap:Body>
     </soap:Envelope>';
            $message = <<<EOM
$query1
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
        // return $object;
        $data =app('App\Http\Controllers\XMlToParseDataController')->AirPrice($object);
        // return $data;
        return view('multicity.payment',[
            'flights1'=>$data,
            'searched'=>$request
        ]);
      
    }

    

    public function XMLToJson($return){
        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);
        return $object;
    }

    public function DataParser_old($object){
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
                                // echo "<br/>";
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
                                        foreach($jsons3 as $jsons13){
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
                                                                    foreach($jsons15 as $jsons16){
                                                                        // echo $count16;
                                                                        // print_r($jsons16);
                                                                        // echo "<br/><br/><br/>"; 
                                                                        // if($count16==21){
                                                                        //     echo $count16;
                                                                        //     print_r($jsons16);
                                                                        //     echo "<br/><br/><br/>";
                                                                        // }
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
                                                            $count15++;
                                                        }
                                                        // return $price;
                                                        $data->push(["price"=>$price]);
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

    public function DataParser($object){
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
                                                                                    if(is_array($jsons16)){
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
                                                                                        if(is_array($jsons17)){
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

    public function PaymentCredit(Request $request){
        // return $request;
        $flight=json_decode($request->flight1, true);
        // return $flight;
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
            }
        }
        // return count($journeys);

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
                                
                                if(count($journeys)==2){    
                                    if(isset($FareInfo[($i*2)]['Key']) && isset($FareInfo[(($i*2)+1)]['Key'])){
                                        $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                            <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                        </air:FareInfo>
                                        <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*2)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*2)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*2)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*2)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*2)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*2)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*2)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*2)+1)]['FareBasis'].'">
                                            <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*2)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*2)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*2)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                        </air:FareInfo>
                                        <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                        <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                        ';
                                    }else{
                                        return $this->BookingFailedResponce($request);
                                        
                                    }
                                    
                                }else{
                                // }else if(count($journeys)==3){
                                    $journeyCount=count($journeys);
                                    if(isset($FareInfo[($i*2)]['Key']) && isset($FareInfo[(($i*2)+1)]['Key'])){
                                        $fare_info='';
                                            $fare_info1='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                        </air:FareInfo>
                                        <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*2)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*2)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*2)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*2)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*2)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*2)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*2)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*2)+1)]['FareBasis'].'">
                                            <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*2)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*2)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*2)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                        </air:FareInfo>';
                                        $bbb_info='';
                                        for ($m=0; $m <$journeyCount ; $m++) { 
                                            $bbb_info.='<air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+$m)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+$m)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+$m)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+$m)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+$m)]['HostTokenRef'].'" />';
                                        }
                                        // $bbb_info='<air:BookingInfo BookingCode="'.$BookingInfo[($i*$journeyCount)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*$journeyCount)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*$journeyCount)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*$journeyCount)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*$journeyCount)]['HostTokenRef'].'" />
                                        // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+1)]['HostTokenRef'].'" />
                                        // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+2)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+2)]['HostTokenRef'].'" />
                                        // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+3)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+3)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+3)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+3)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+3)]['HostTokenRef'].'" />
                                        // '; 
                                        $fare_info=$fare_info1.$bbb_info;
                                    }
                                    // if(isset($FareInfo[($i*$journeyCount)]['Key']) && isset($BookingInfo[($i*$journeyCount)]['BookingCode'])){
                                    // $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*$journeyCount)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*$journeyCount)]['DepartureDate'].'" Amount="'.$FareInfo[($i*$journeyCount)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*$journeyCount)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*$journeyCount)]['Destination'].'" Origin="'.$FareInfo[($i*$journeyCount)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*$journeyCount)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*$journeyCount)]['FareBasis'].'">
                                    // <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*$journeyCount)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*$journeyCount)]['ProviderCode'].'">'.$FareRuleKey[($i*$journeyCount)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*$journeyCount)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*$journeyCount)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*$journeyCount)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*$journeyCount)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*$journeyCount)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*$journeyCount)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*$journeyCount)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*$journeyCount)+1)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*$journeyCount)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*$journeyCount)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*$journeyCount)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*$journeyCount)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*$journeyCount)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*$journeyCount)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*$journeyCount)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*$journeyCount)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+1)]['HostTokenRef'].'" />
                                    // '; 
                                    // }
                                    else{
                                        return $this->BookingFailedResponce($request);
                                        
                                    }
                                }
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
                                        $var_adtcount.='<air:PassengerType Code="INF" BookingTravelerRef="INF'.$j.'"/>';
                                    } 
                                }
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


        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        
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
        $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
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
        
        // return $data[0];
        // echo $data['UniversalRecord']." <br/>";
        if(count($data)==0){
            // return "hii";
            $unidata=[];
            $alldetails=[];
            return view('multicity.confirm-booking',[
                'return_searched'=>$request,
                'return_airreservation'=>$data,
                'return_airticketing'=>$alldetails,
                'return_unidata'=>$unidata
            ]);
        }
        // return $data['UniversalRecord'];
        // return $data['AirPricingInfo']['Key'];
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
        $object1 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return1);
        // return $object1;
        $alldetails=[];
        // return $data;
        
        // Universal Record RetrieveReq
        $xml_data =app('App\Http\Controllers\UtilityController')->UniversalRecordRetrieveReq($data['UniversalRecord']);

        $api_url='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService';
        $return2 =app('App\Http\Controllers\UtilityController')->universal_API($xml_data,$api_url);
        
        $object2 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return2);
        $unidata =app('App\Http\Controllers\XMlToParseDataController')->UniversalRecord($object2);

        // return $data;
        // return $request;
        return view('multicity.confirm-booking',[
            'return_searched'=>$request,
            'multicity_airreservation'=>$data,
            'return_airticketing'=>$alldetails,
            'return_unidata'=>$unidata
        ]);

    }

    public function BookingFailedResponce($request){
        $data=[];
        $alldetails=[];
        $unidata=[];
        return view('multicity.confirm-booking',[
            'return_searched'=>$request,
            'multicity_airreservation'=>$data,
            'return_airticketing'=>$alldetails,
            'return_unidata'=>$unidata
        ]);
    }
}
