<?php

namespace App\Http\Controllers\multicity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AirportCodes;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;
use DB;

class FlightDetailsController extends Controller
{
    public function FlightDetails(Request $request){
        // return $request;
        $flights1=json_decode($request->flights1);
        $flights2=json_decode($request->flights2);
        $flights3=json_decode($request->flights3);
        
        // return $flights3;
        $datasegment1='';        
        $data1=[];

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
        // return $datasegment1;
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
    //  return $query1;
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
        // return $data3;
        
        // return $request;
        return view('multicity.flight-details',[
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
}
