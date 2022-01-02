<?php

namespace App\Http\Controllers\multicity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function ShowPayment(Request $request){
        return $request;
        $flights1=json_decode($request->flights1);
        $flights2=json_decode($request->flights2);
        $flights3=json_decode($request->flights3);

        $flights4=json_decode($request->flights4);
        $flights5=json_decode($request->flights5);
        $flights6=json_decode($request->flights6);

        // return $flights1;
        $all_datasegment='';
        $datasegment1='';
        $datasegment2='';
        $datasegment3='';
        $data1=[];
        $data2=[];
        $data3=[];
        $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
        
        // foreach($flights1[0] as $journeys){
        //     for ($i=0; $i <count($journeys) ; $i++) { 
        //         // echo $journeys[$i]->key;
        //         $datasegment1.= '<air:AirSegment Key="'.$journeys[$i]->key.'" Group="'.$journeys[$i]->Group.'" Carrier="'.$journeys[$i]->Carrier.'" FlightNumber="'.$journeys[$i]->FlightNumber.'" Origin="'.$journeys[$i]->Origin.'" Destination="'.$journeys[$i]->Destination.'" DepartureTime="'.$journeys[$i]->DepartureTime.'" ArrivalTime="'.$journeys[$i]->ArrivalTime.'" FlightTime="'.$journeys[$i]->FlightTime.'" Distance="'.$journeys[$i]->Distance.'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
        //         $all_datasegment.= '<air:AirSegment Key="'.$journeys[$i]->key.'" Group="'.$journeys[$i]->Group.'" Carrier="'.$journeys[$i]->Carrier.'" FlightNumber="'.$journeys[$i]->FlightNumber.'" Origin="'.$journeys[$i]->Origin.'" Destination="'.$journeys[$i]->Destination.'" DepartureTime="'.$journeys[$i]->DepartureTime.'" ArrivalTime="'.$journeys[$i]->ArrivalTime.'" FlightTime="'.$journeys[$i]->FlightTime.'" Distance="'.$journeys[$i]->Distance.'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
        //     }
        // }
        // foreach($flights1 as $journeys){
        //     echo get_object_vars($journeys->Key)[0];
        //     print_r($journeys);
        // }
        // return "hii";
        foreach($flights1 as $journeys){
            // for ($i=0; $i <count($journeys) ; $i++) { 
            $all_datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            // $datasegment3.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            // }
        }
        // return $datasegment1;
        //flight1
        // $xmldata=app('App\Http\Controllers\UtilityController')->universal_API_FlightDetails($datasegment1);
        // $return1 =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
        // //flight1 return data
        // $object1 = $this->XMLToJson($return1);
        // $data1= $this->DataParser($object1);

        if($flights2 !=null){
            // foreach($flights2[0] as $journeys){
            //     for ($i=0; $i <count($journeys) ; $i++) { 
            //         $datasegment2.= '<air:AirSegment Key="'.$journeys[$i]->key.'" Group="'.$journeys[$i]->Group.'" Carrier="'.$journeys[$i]->Carrier.'" FlightNumber="'.$journeys[$i]->FlightNumber.'" Origin="'.$journeys[$i]->Origin.'" Destination="'.$journeys[$i]->Destination.'" DepartureTime="'.$journeys[$i]->DepartureTime.'" ArrivalTime="'.$journeys[$i]->ArrivalTime.'" FlightTime="'.$journeys[$i]->FlightTime.'" Distance="'.$journeys[$i]->Distance.'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            //         $all_datasegment.= '<air:AirSegment Key="'.$journeys[$i]->key.'" Group="'.$journeys[$i]->Group.'" Carrier="'.$journeys[$i]->Carrier.'" FlightNumber="'.$journeys[$i]->FlightNumber.'" Origin="'.$journeys[$i]->Origin.'" Destination="'.$journeys[$i]->Destination.'" DepartureTime="'.$journeys[$i]->DepartureTime.'" ArrivalTime="'.$journeys[$i]->ArrivalTime.'" FlightTime="'.$journeys[$i]->FlightTime.'" Distance="'.$journeys[$i]->Distance.'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            //     }
            // }

            foreach($flights2 as $journeys){
                // for ($i=0; $i <count($journeys) ; $i++) { 
                $all_datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                // $datasegment3.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                // }
            }

             // flight2
            // $xmldata1=app('App\Http\Controllers\UtilityController')->universal_API_FlightDetails($datasegment2);
            // $return2 =app('App\Http\Controllers\UtilityController')->universal_API($xmldata1,$api_url);
            // // return  $return2;
            // $object2 = $this->XMLToJson($return2);
            // $data2= $this->DataParser($object2);
        }
        if($flights3 !=null){
            // foreach($flights3[0] as $journeys){
            //     for ($i=0; $i <count($journeys) ; $i++) { 
            //         $datasegment3.= '<air:AirSegment Key="'.$journeys[$i]->key.'" Group="'.$journeys[$i]->Group.'" Carrier="'.$journeys[$i]->Carrier.'" FlightNumber="'.$journeys[$i]->FlightNumber.'" Origin="'.$journeys[$i]->Origin.'" Destination="'.$journeys[$i]->Destination.'" DepartureTime="'.$journeys[$i]->DepartureTime.'" ArrivalTime="'.$journeys[$i]->ArrivalTime.'" FlightTime="'.$journeys[$i]->FlightTime.'" Distance="'.$journeys[$i]->Distance.'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            //         $all_datasegment.= '<air:AirSegment Key="'.$journeys[$i]->key.'" Group="'.$journeys[$i]->Group.'" Carrier="'.$journeys[$i]->Carrier.'" FlightNumber="'.$journeys[$i]->FlightNumber.'" Origin="'.$journeys[$i]->Origin.'" Destination="'.$journeys[$i]->Destination.'" DepartureTime="'.$journeys[$i]->DepartureTime.'" ArrivalTime="'.$journeys[$i]->ArrivalTime.'" FlightTime="'.$journeys[$i]->FlightTime.'" Distance="'.$journeys[$i]->Distance.'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            //     }
            // }

            foreach($flights3 as $journeys){
                // for ($i=0; $i <count($journeys) ; $i++) { 
                $all_datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                // $datasegment3.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
                // }
            }

            // $xmldata2=app('App\Http\Controllers\UtilityController')->universal_API_FlightDetails($datasegment3);
            // $return3 =app('App\Http\Controllers\UtilityController')->universal_API($xmldata2,$api_url);
            // // return  $return3 ;
            // $object3 = $this->XMLToJson($return3);
            // $data3= $this->DataParser($object3);
        }

        if($flights4 !=null){
            foreach($flights4 as $journeys){
                $all_datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
               
            }
        }
        if($flights5 !=null){
            foreach($flights5 as $journeys){
                $all_datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
               
            }
        }
        if($flights6 !=null){
            foreach($flights6 as $journeys){
                $all_datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys->Key)[0].'" Group="'.get_object_vars($journeys->Group)[0].'" Carrier="'.get_object_vars($journeys->Airline)[0].'" FlightNumber="'.get_object_vars($journeys->Flight)[0].'" Origin="'.get_object_vars($journeys->From)[0].'" Destination="'.get_object_vars($journeys->To)[0].'" DepartureTime="'.get_object_vars($journeys->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys->Arrive)[0].'" FlightTime="'.get_object_vars($journeys->FlightTime)[0].'" Distance="'.get_object_vars($journeys->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
               
            }
        }

        // return $all_datasegment;
        // return $data1;
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        
        
        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
           <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
              <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirItinerary>
                '.$all_datasegment.'
              </air:AirItinerary>
              <air:AirPricingModifiers/>
              <com:SearchPassenger Key="1" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirPricingCommand/>
           </air:AirPriceReq>
        </soap:Body>
     </soap:Envelope>';
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
        $object = $this->XMLToJson($return);
        // return $object;
        $data= $this->DataParser($object);
        // $data =app('App\Http\Controllers\XMlToParseDataController')->AirPrice($object);

        // return $data;
        return view('multicity.payment',[
            'flights1'=>$data,
            'flights2'=>$data2,
            'flights3'=>$data3,
            'searched'=>$request
        ]);
      
    }

    // public function PaymentCredit(Request $request){
    //     // return $request;
    //     // $flight1=$request->flight1;
    //     // return $flight1;
    //     // return "We are working on";
    //     $flight=json_decode($request->flight1, true);
    //     // return $flight;
    //     $datasegment='';
    //     foreach($flight[0] as $journeys){
    //         for ($i=0; $i < count($journeys); $i++) {
    //             // echo get_object_vars($journeys[$i]->Key)[0];
    //             // return $journeys[$i]['key'];
    //             $datasegment.='<air:AirSegment Key="'.$journeys[$i]['key'].'" Group="'.$journeys[$i]['Group'].'" Carrier="'.$journeys[$i]['Carrier'].'" FlightNumber="'.$journeys[$i]['FlightNumber'].'" ProviderCode="1G" Origin="'.$journeys[$i]['Origin'].'" Destination="'.$journeys[$i]['Destination'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" Distance="'.$journeys[$i]['Distance'].'" ClassOfService="'.$journeys[$i]['ClassOfService'].'" Equipment="E90" ChangeOfPlane="false" OptionalServicesIndicator="false" AvailabilitySource="S" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="O and D cache or polled status used with different local status" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked">
    //             <air:CodeshareInfo OperatingCarrier="'.$journeys[$i]['Carrier'].'"></air:CodeshareInfo>
    //             <air:FlightDetails Key="" Origin="'.$journeys[$i]['Origin'].'" Destination="'.$journeys[$i]['Destination'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" Distance="'.$journeys[$i]['Distance'].'"/>
    //             </air:AirSegment>
    //             ';
    //             // $datasegment.='<AirSegment ProviderCode="1G" Key="'.$journeys[$i]['key'].'" Carrier="'.$journeys[$i]['Carrier'].'" ClassOfService="'.$journeys[$i]['ClassOfService'].'" Distance="'.$journeys[$i]['Destination'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" Destination="'.$journeys[$i]['Destination'].'" Origin="'.$journeys[$i]['Origin'].'" FlightNumber="'.$journeys[$i]['FlightNumber'].'" Group="'.$journeys[$i]['Group'].'" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked" OptionalServicesIndicator="false">
    //             // <CodeshareInfo OperatingCarrier="'.$journeys[$i]['Carrier'].'"/>
    //             // </AirSegment>';
    //         }
    //     }
    //     return $datasegment;
    // }

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
                // $datasegment.='<AirSegment ProviderCode="1G" Key="'.$journeys[$i]['key'].'" Carrier="'.$journeys[$i]['Carrier'].'" ClassOfService="'.$journeys[$i]['ClassOfService'].'" Distance="'.$journeys[$i]['Destination'].'" TravelTime="'.$journeys[$i]['TravelTime'].'" FlightTime="'.$journeys[$i]['FlightTime'].'" ArrivalTime="'.$journeys[$i]['ArrivalTime'].'" DepartureTime="'.$journeys[$i]['DepartureTime'].'" Destination="'.$journeys[$i]['Destination'].'" Origin="'.$journeys[$i]['Origin'].'" FlightNumber="'.$journeys[$i]['FlightNumber'].'" Group="'.$journeys[$i]['Group'].'" AvailabilityDisplayType="Fare Specific Fare Quote Unbooked" OptionalServicesIndicator="false">
                // <CodeshareInfo OperatingCarrier="'.$journeys[$i]['Carrier'].'"/>
                // </AirSegment>';
            }
        }
        // return $datasegment;

        // return $flight[7];
        $hash_token='';
        foreach($flight[7] as $hashToken){
            // print_r($hashToken);
            // echo "<br/><br/>";
            for ($i=0; $i < count($hashToken); $i++) {
                // echo $hashToken[$i]['Key'];
                $hash_token.='<HostToken Key="'.$hashToken[$i]['Key'].'" xmlns="http://www.travelport.com/schema/common_v42_0">'.$hashToken[$i]['HostTokenValue'].'</HostToken>';
            }
        }
        // return $hash_token;
        $booking_info='';
        foreach($flight[6] as $BookingInfo){
            // print_r($hashToken);
            // echo "<br/><br/>";
            for ($i=0; $i < count($BookingInfo); $i++) {
                // echo $hashToken[$i]['Key'];
                if(isset($BookingInfo[$i]['BookingCode'])){
                $booking_info.='<air:BookingInfo BookingCode="'.$BookingInfo[$i]['BookingCode'].'" CabinClass="'.$BookingInfo[$i]['CabinClass'].'" FareInfoRef="'.$BookingInfo[$i]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[$i]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[$i]['HostTokenRef'].'"/>';
                }
            }
        }
        
        // return $booking_info;
        $Fare_Info_FareRuleKey='';
        if($flight[4]!=''){
            foreach($flight[4] as $FareInfo){
                // print_r($FareInfo);
                for ($i=0; $i < count($FareInfo); $i++) { 
                    // echo $FareInfo[$i]['Key'];
                    // echo "<br/>";
                    // echo $FareInfo[$i]['Origin'];
                    // echo "<br/>";
                    foreach($flight[5] as $FareRuleKey){
                        if(isset($FareInfo[$i]['Key']) && isset($FareRuleKey[$i]['FareInfoRef'])){
                            if($FareInfo[$i]['Key']==$FareRuleKey[$i]['FareInfoRef']){
                            $Fare_Info_FareRuleKey.='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[$i]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[$i]['DepartureDate'].'" Amount="'.$FareInfo[$i]['Amount'].'" EffectiveDate="'.$FareInfo[$i]['EffectiveDate'].'" Destination="'.$FareInfo[$i]['Destination'].'" Origin="'.$FareInfo[$i]['Origin'].'" PassengerTypeCode="'.$FareInfo[$i]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[$i]['FareBasis'].'">
                            <air:FareRuleKey FareInfoRef="'.$FareRuleKey[$i]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[$i]['ProviderCode'].'">'.$FareRuleKey[$i]['FareRuleKeyValue'].'</air:FareRuleKey>
                            </air:FareInfo>';
                            }
                        }
                        // echo $FareInfo[$i]['Key'];
                        // echo "<br/>";
                        // echo $FareInfo[$i]['Origin'];
                        // echo "<br/>";
                        // echo $FareRuleKey[$i]['FareInfoRef'];
                        // echo "<br/>";
                        // echo $FareRuleKey[$i]['ProviderCode'];
                        // echo "<br/>";
                    }
                }
            }
        }
        // return $Fare_Info_FareRuleKey;
        // return "hii";

        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');
        // return $request->gender1;
        if ($request->gender1=="Male") {
            $gender="M";
        }else{
            $gender="F"; 
        }
        // return $request->first_name1;
        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <univ:AirCreateReservationReq RetainReservation="Both" TraceId="trace" TargetBranch="'.$TARGETBRANCH.'" AuthorizedBy="user" xmlns:univ="http://www.travelport.com/schema/universal_v42_0">
                <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
                <com:BookingTraveler TravelerType="ADT" DOB="'.date("Y-m-d",strtotime($request->date_of_birth1)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
                    <com:BookingTravelerName Prefix="'.$request->title1.'" First="'.$request->first_name1.'" Last="'.$request->last_name1.'"/>
                    <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
                    <com:Email Type="Home" EmailID="'.$request->email.'"/>
                    <com:SSR Key="1" Type="DOCS" Carrier="AI" FreeText="P/CA/F9850356/GB/04JAN80/M/01JAN14/LINDELOEV/CARSTENGJELLERUPMr"/>
                    <com:Address>
                        <com:AddressName>'.$request->add_1.'</com:AddressName>
                        <com:Street>'.$request->add_2.'</com:Street>
                        <com:Street>'.$request->add_2.'</com:Street>
                        <com:City>'.$request->city.'</com:City>
                        <com:State>'.$request->state_code.'</com:State>
                        <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                        <com:Country>IN</com:Country>
                    </com:Address>
                </com:BookingTraveler>
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
                <air:AirPricingSolution Key="'.$flight[2]['price']['Key'].'" TotalPrice="'.$flight[2]['price']['TotalPrice'].'" BasePrice="'.$flight[2]['price']['BasePrice'].'" ApproximateTotalPrice="'.$flight[2]['price']['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$flight[2]['price']['ApproximateBasePrice'].'" EquivalentBasePrice="'.$flight[2]['price']['EquivalentBasePrice'].'" Taxes="'.$flight[2]['price']['Taxes'].'" Fees="'.$flight[2]['price']['Fees'].'" ApproximateTaxes="'.$flight[2]['price']['ApproximateTaxes'].'" QuoteDate="'.$flight[2]['price']['QuoteDate'].'" xmlns:air="http://www.travelport.com/schema/air_v42_0">
                    '.$datasegment.'
                    <air:AirPricingInfo PricingMethod="Auto" Key="'.$flight[3]['AirPricingInfo']['Key'].'" TotalPrice="'.$flight[3]['AirPricingInfo']['TotalPrice'].'" BasePrice="'.$flight[3]['AirPricingInfo']['BasePrice'].'" ApproximateTotalPrice="'.$flight[3]['AirPricingInfo']['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$flight[3]['AirPricingInfo']['ApproximateBasePrice'].'" Taxes="'.$flight[3]['AirPricingInfo']['Taxes'].'" ProviderCode="1G">
                    '.$Fare_Info_FareRuleKey.$booking_info.'
                    <air:PassengerType Code="ADT" />
                    </air:AirPricingInfo>
                    '.$hash_token.' 
                </air:AirPricingSolution>
                <com:ActionStatus TicketDate="T*" Type="ACTIVE" ProviderCode="'.$Provider.'" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
            </univ:AirCreateReservationReq>
        </soap:Body>
    </soap:Envelope>';
    // return $query;
            $message = <<<EOM
$query
EOM;
        $api_url='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService';
        $return =app('App\Http\Controllers\UtilityController')->universal_API($message,$api_url);
        // return $return;
        $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
        // return $object;
        $data =app('App\Http\Controllers\XMlToParseDataController')->AirCreateReservation($object);
        // return $data;
        // return count($data);
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

        // Air Ticketing Req retreve responce
        $xml_data1 =app('App\Http\Controllers\UtilityController')->universal_API_AirTicketing($data['AirReservation'],$data['AirPricingInfo']['Key']);
        $api_url1='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService';
        $return1 =app('App\Http\Controllers\UtilityController')->universal_API($xml_data1,$api_url1);
        // return $return1;
        $object1 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return1);
        // return $object1;
        $alldetails=[];
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
                            // $alldetails=[];
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
        // return $alldetails;
        // Universal record retreve responce
        

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
}
