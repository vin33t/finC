<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;

class FlightDetailsController extends Controller
{
    public function FlightDetails_old(Request $request){
        $count=$request->count;
        // $flights=$request->flights;
         // $flights=json_decode($request->flights);
        // $flights=json_decode($request->input('flights'));
        $flights=$request->flights;
        // $arrNewResult = array();
        // $arrNewResult['changepenalty'] = "gii";
        // foreach($flights[0] as $journeys){
        //     for ($i=0; $i < count($journeys); $i++) {
        //         // $arrNewResult['Key']=str_replace('["','',$journeys[$i]['Key']);
        //         $arrNewResult['key']=$journeys[$i]['Key'];
        //     }
        // }

        // // $arrNewResult = array();
        // // $arrNewResult['changepenalty'] = "gii";
        // // $arrNewResult['count'] = count($flights[0]);
        // $status_json = json_encode($arrNewResult);
        // echo $status_json;

        // return  $flightss;
        // echo count($flights[0]);
        $datasegment='';
        foreach($flights[0] as $journeys){
            for ($i=0; $i < count($journeys); $i++) {
                // $datasegment.= implode('[', $journeys[$i]['Key']);
                // $datasegment.= str_replace('["','',$journeys[$i]['Key']);
                // $datasegment.= "<air:AirSegment Key='".implode('[', $journeys[$i]['Key'])."' Group='".implode('[', $journeys[$i]['Group'])."' Carrier='".implode('[', $journeys[$i]['Airline'])."' FlightNumber='".implode('[', $journeys[$i]['Flight'])."' Origin='".implode('[', $journeys[$i]['From'])."' Destination='".implode('[', $journeys[$i]['To'])."' DepartureTime='".implode('[', $journeys[$i]['Depart'])."' ArrivalTime='".implode('[', $journeys[$i]['Arrive'])."' FlightTime='".implode('[', $journeys[$i]['FlightTime'])."' Distance='".implode('[', $journeys[$i]['Distance'])."' ETicketability='Yes' ProviderCode='1G' ></air:AirSegment>";
                $datasegment.= '<air:AirSegment Key="'.implode('[', $journeys[$i]['Key']).'" Group="'.implode('[', $journeys[$i]['Group']).'" Carrier="'.implode('[', $journeys[$i]['Airline']).'" FlightNumber="'.implode('[', $journeys[$i]['Flight']).'" Origin="'.implode('[', $journeys[$i]['From']).'" Destination="'.implode('[', $journeys[$i]['To']).'" DepartureTime="'.implode('[', $journeys[$i]['Depart']).'" ArrivalTime="'.implode('[', $journeys[$i]['Arrive']).'" FlightTime="'.implode('[', $journeys[$i]['FlightTime']).'" Distance="'.implode('[', $journeys[$i]['Distance']).'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            }
        }
        // $arrNewResult['count'] = $datasegment;
        // $status_json = json_encode($arrNewResult);
        // echo $status_json;
        // $datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" Equipment="E90" ChangeOfPlane="false" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="Polled avail used" OptionalServicesIndicator="false" AvailabilitySource="S" AvailabilityDisplayType="Fare Shop/Optimal Shop" ProviderCode="1G" ClassOfService="W"></air:AirSegment>';
        // echo  get_object_vars($journeys[$i]->Key)[0]; echo "<br/>";

        // return $datasegment;
        // foreach($flights[1] as $prices){
        // }
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');

        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
           <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
              <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirItinerary>
                '.$datasegment.'
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

        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);

        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                if(count($jsons1)>1){
                    foreach($jsons1 as $jsons2){
                        // print_r($jsons3);
                        if(count($jsons2)>1){
                            foreach($jsons2 as $jsons3){
                                if(is_array($jsons3)){
                                    // echo $count." count";
                                        // echo "<br/>";
                                    if($count==3){
                                        // print_r($jsons3);
                                        // echo "<br/><br/>";
                                        $count2=1;
                                        foreach($jsons3 as $jsons4){
                                            // echo "count";
                                            // print_r($jsons4);
                                            // echo "<br/><br/>";
                                            $journey=collect();
                                            if($count2==2){
                                                // print_r($jsons4);
                                                // echo "<br/><br/>";
                                                $details1=[];
                                                // please check this position
                                                if(is_array($jsons4)){
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
                                                                }
                                                            }
                                                            if(empty($details1) && !empty($details)){
                                                                $journey->push($details);
                                                            }
                                                        }
                                                    }
                                                }
                                                if(!empty($details1)){
                                                    $journey->push($details1);
                                                }
                                                // return $journey;
                                                $data->push(["journey"=>collect($journey)]);
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
        // return $data;

        $arrNewResult = array();
        // $arrNewResult['changepenalty'] = $data[1]['details']['changepenalty'];
        $arrNewResult['changepenalty'] = isset($data[1]['details']['changepenalty'])?$data[1]['details']['changepenalty']:'';
        $arrNewResult['cancelpenalty'] = isset($data[1]['details']['cancelpenalty'])?$data[1]['details']['cancelpenalty']:'';
        $arrNewResult['baggageallowanceinfo'] = isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:'';
        $arrNewResult['carryonallowanceinfo'] = isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'';
        $status_json = json_encode($arrNewResult);
        echo $status_json;
        // echo $data[0]['journey'];
        // echo count($data[0]);
        // foreach($data[0] as $datas){
        //     echo count($datas);
        // }
        // return $request;
        // return view('flights.flight-details',[
        //     'per_flight_details'=>$request,
        //     'data'=>$data
        // ]);
        // return view('flights.flight-details');
    }

    public function FlightDetails(Request $request){
        $count=$request->count;
        $currency_code=$request->currency_code;

        // $flights=$request->flights;
         // $flights=json_decode($request->flights);
        // $flights=json_decode($request->input('flights'));
        $flights=$request->flights;
        // $arrNewResult = array();
        // $arrNewResult['changepenalty'] = "gii";
        // foreach($flights[0] as $journeys){
        //     for ($i=0; $i < count($journeys); $i++) {
        //         // $arrNewResult['Key']=str_replace('["','',$journeys[$i]['Key']);
        //         $arrNewResult['key']=$journeys[$i]['Key'];
        //     }
        // }

        // // $arrNewResult = array();
        // // $arrNewResult['changepenalty'] = "gii";
        // // $arrNewResult['count'] = count($flights[0]);
        // $status_json = json_encode($arrNewResult);
        // echo $status_json;

        // return  $flightss;
        // echo count($flights[0]);
        $currency_xml='';
        if($currency_code!=''){
            $currency_xml='<air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="'.$currency_code.'">
            <air:BrandModifiers ModifierType="FareFamilyDisplay" />
            </air:AirPricingModifiers>';
        }else{
            $currency_xml='<air:AirPricingModifiers/>';
        }


        $datasegment='';
        foreach($flights[0] as $journeys){
            for ($i=0; $i < count($journeys); $i++) {
                // $datasegment.= implode('[', $journeys[$i]['Key']);
                // $datasegment.= str_replace('["','',$journeys[$i]['Key']);
                // $datasegment.= "<air:AirSegment Key='".implode('[', $journeys[$i]['Key'])."' Group='".implode('[', $journeys[$i]['Group'])."' Carrier='".implode('[', $journeys[$i]['Airline'])."' FlightNumber='".implode('[', $journeys[$i]['Flight'])."' Origin='".implode('[', $journeys[$i]['From'])."' Destination='".implode('[', $journeys[$i]['To'])."' DepartureTime='".implode('[', $journeys[$i]['Depart'])."' ArrivalTime='".implode('[', $journeys[$i]['Arrive'])."' FlightTime='".implode('[', $journeys[$i]['FlightTime'])."' Distance='".implode('[', $journeys[$i]['Distance'])."' ETicketability='Yes' ProviderCode='1G' ></air:AirSegment>";
                $datasegment.= '<air:AirSegment Key="'.implode('[', $journeys[$i]['Key']).'" Group="'.implode('[', $journeys[$i]['Group']).'" Carrier="'.implode('[', $journeys[$i]['Airline']).'" FlightNumber="'.implode('[', $journeys[$i]['Flight']).'" Origin="'.implode('[', $journeys[$i]['From']).'" Destination="'.implode('[', $journeys[$i]['To']).'" DepartureTime="'.implode('[', $journeys[$i]['Depart']).'" ArrivalTime="'.implode('[', $journeys[$i]['Arrive']).'" FlightTime="'.implode('[', $journeys[$i]['FlightTime']).'" Distance="'.implode('[', $journeys[$i]['Distance']).'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            }
        }
        // $arrNewResult['count'] = $datasegment;
        // $status_json = json_encode($arrNewResult);
        // echo $status_json;
        // $datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" Equipment="E90" ChangeOfPlane="false" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="Polled avail used" OptionalServicesIndicator="false" AvailabilitySource="S" AvailabilityDisplayType="Fare Shop/Optimal Shop" ProviderCode="1G" ClassOfService="W"></air:AirSegment>';
        // echo  get_object_vars($journeys[$i]->Key)[0]; echo "<br/>";

        // return $datasegment;
        // foreach($flights[1] as $prices){
        // }
        $CREDENTIALS = app('App\Http\Controllers\UniversalConfigAPIController')->CREDENTIALS();
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();

        // $TARGETBRANCH = 'P7141733';
        // $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        // $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');

        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
           <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
              <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirItinerary>
                '.$datasegment.'
              </air:AirItinerary>
              '.$currency_xml.'
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

        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);

        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                // print_r($jsons1);
                // echo "<br/><br/>";
                if(array_key_exists('SOAP:Fault',$jsons1)){
                    // return "Error No data Found";
                }else{
                    foreach($jsons1 as $jsons2){
                        if(is_array($jsons2)){
                            // count($jsons1)>1
                            // print_r($jsons2);
                            // echo "<br/><br/>";
                            // print_r(array_key_exists('air:AirItinerary',$jsons2));
                            if(array_key_exists('air:AirItinerary',$jsons2)){
                                // print_r($jsons2['air:AirItinerary']['air:AirSegment']);
                                // echo "<br/><br/>";
                                $details1=[];
                                foreach($jsons2['air:AirItinerary']['air:AirSegment'] as $g => $jsons5){
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
                            if(array_key_exists('air:AirPriceResult',$jsons2)){
                                // print_r($jsons2['air:AirPriceResult']);
                                // return $jsons2['air:AirPriceResult'];
                                // echo "<br/><br/>";
                                // print_r($jsons2['air:AirPriceResult']['air:AirPricingSolution']);
                                // return count($jsons2['air:AirPriceResult']['air:AirPricingSolution']);

                                // some error on indexing
                                // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'];
                                // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0];
                                $price=[];
                                foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0] as $p => $jsons15){
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
                                // $data->push(["price"=>collect($price)]);
                                $AirPricingInfo=collect();
                                $FareInfo1=collect();
                                $FareRuleKey1=collect();
                                $BookingInfo1=collect();
                                $TaxInfo=collect();

                                if(array_key_exists('air:AirPricingInfo',$jsons2['air:AirPriceResult']['air:AirPricingSolution'][0])){
                                    $jsons14=$jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'];
                                    // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'];
                                    $AirPricingInfo1=[];
                                    foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'] as $key => $value){
                                        $AirPricingInfo0=[];
                                        if(is_string($value)){
                                            if(strcmp($key, "@Key") == 0){
                                                $AirPricingInfo1["Key"]=$value;
                                            }
                                            if(strcmp($key, "@TotalPrice") == 0){
                                                $AirPricingInfo1["TotalPrice"]=$value;
                                            }
                                            if(strcmp($key, "@BasePrice") == 0){
                                                $AirPricingInfo1["BasePrice"]=$value;
                                            }
                                            if(strcmp($key, "@ApproximateTotalPrice") == 0){
                                                $AirPricingInfo1["ApproximateTotalPrice"]=$value;
                                            }
                                            if(strcmp($key, "@ApproximateBasePrice") == 0){
                                                $AirPricingInfo1["ApproximateBasePrice"]=$value;
                                            }
                                            if(strcmp($key, "@EquivalentBasePrice") == 0){
                                                $AirPricingInfo1["EquivalentBasePrice"]=$value;
                                            }
                                            if(strcmp($key, "@ApproximateTaxes") == 0){
                                                $AirPricingInfo1["ApproximateTaxes"]=$value;
                                            }
                                            if(strcmp($key, "@Taxes") == 0){
                                                $AirPricingInfo1["Taxes"]=$value;
                                            }
                                            if(strcmp($key, "@LatestTicketingTime") == 0){
                                                $AirPricingInfo1["LatestTicketingTime"]=$value;
                                            }
                                            if(strcmp($key, "@PricingMethod") == 0){
                                                $AirPricingInfo1["PricingMethod"]=$value;
                                            }
                                            if(strcmp($key, "@Refundable") == 0){
                                                $AirPricingInfo1["Refundable"]=$value;
                                            }
                                            if(strcmp($key, "@IncludesVAT") == 0){
                                                $AirPricingInfo1["IncludesVAT"]=$value;
                                            }
                                            if(strcmp($key, "@ETicketability") == 0){
                                                $AirPricingInfo1["ETicketability"]=$value;
                                            }
                                            if(strcmp($key, "@PlatingCarrier") == 0){
                                                $AirPricingInfo1["PlatingCarrier"]=$value;
                                            }
                                            if(strcmp($key, "@ProviderCode") == 0){
                                                $AirPricingInfo1["ProviderCode"]=$value;
                                            }
                                        }else{
                                            foreach($value as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "@Key") == 0){
                                                        $AirPricingInfo0["Key"]=$value1;
                                                    }
                                                    if(strcmp($key, "@TotalPrice") == 0){
                                                        $AirPricingInfo0["TotalPrice"]=$value1;
                                                    }
                                                    if(strcmp($key, "@BasePrice") == 0){
                                                        $AirPricingInfo0["BasePrice"]=$value1;
                                                    }
                                                    if(strcmp($key, "@ApproximateTotalPrice") == 0){
                                                        $AirPricingInfo0["ApproximateTotalPrice"]=$value1;
                                                    }
                                                    if(strcmp($key, "@ApproximateBasePrice") == 0){
                                                        $AirPricingInfo0["ApproximateBasePrice"]=$value1;
                                                    }
                                                    if(strcmp($key, "@EquivalentBasePrice") == 0){
                                                        $AirPricingInfo0["EquivalentBasePrice"]=$value1;
                                                    }
                                                    if(strcmp($key, "@ApproximateTaxes") == 0){
                                                        $AirPricingInfo0["ApproximateTaxes"]=$value1;
                                                    }
                                                    if(strcmp($key, "@Taxes") == 0){
                                                        $AirPricingInfo0["Taxes"]=$value1;
                                                    }
                                                    if(strcmp($key, "@LatestTicketingTime") == 0){
                                                        $AirPricingInfo0["LatestTicketingTime"]=$value1;
                                                    }
                                                    if(strcmp($key, "@PricingMethod") == 0){
                                                        $AirPricingInfo0["PricingMethod"]=$value1;
                                                    }
                                                    if(strcmp($key, "@Refundable") == 0){
                                                        $AirPricingInfo0["Refundable"]=$value1;
                                                    }
                                                    if(strcmp($key, "@IncludesVAT") == 0){
                                                        $AirPricingInfo0["IncludesVAT"]=$value1;
                                                    }
                                                    if(strcmp($key, "@ETicketability") == 0){
                                                        $AirPricingInfo0["ETicketability"]=$value1;
                                                    }
                                                    if(strcmp($key, "@PlatingCarrier") == 0){
                                                        $AirPricingInfo0["PlatingCarrier"]=$value1;
                                                    }
                                                    if(strcmp($key, "@ProviderCode") == 0){
                                                        $AirPricingInfo0["ProviderCode"]=$value1;
                                                    }
                                                }
                                            }

                                            // start multiple travel add adult and child

                                            // return $value;
                                            // print_r($value);
                                            // print_r($value['air:FareInfo']);
                                            // echo "<br/><br/><br/>";

                                            // fareInfo and fareRule key
                                            if(array_key_exists('air:FareInfo',$value)){
                                                $FareInfo=[];
                                                foreach($value['air:FareInfo'] as $fI => $jsons17){
                                                    $FareInfo0=[];
                                                    // echo $count50;
                                                    // print_r($jsons17);
                                                    // echo "<br/><br/><br/>";
                                                    // $FareRuleKey1=collect();
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
                                                    }else{
                                                        foreach($jsons17 as $fI =>$jsons18){
                                                            if(is_string($jsons18)){
                                                                // print_r($fI."-".$jsons17);
                                                                // echo "<br/><br/><br/>";
                                                                if(strcmp($fI, "@Key") == 0){
                                                                    $FareInfo0["Key"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@FareBasis") == 0){
                                                                    $FareInfo0["FareBasis"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                                    $FareInfo0["PassengerTypeCode"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@Origin") == 0){
                                                                    $FareInfo0["Origin"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@Destination") == 0){
                                                                    $FareInfo0["Destination"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@EffectiveDate") == 0){
                                                                    $FareInfo0["EffectiveDate"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@DepartureDate") == 0){
                                                                    $FareInfo0["DepartureDate"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@Amount") == 0){
                                                                    $FareInfo0["Amount"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@NegotiatedFare") == 0){
                                                                    $FareInfo0["NegotiatedFare"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@NotValidBefore") == 0){
                                                                    $FareInfo0["NotValidBefore"] =$jsons18;
                                                                }
                                                                if(strcmp($fI, "@TaxAmount") == 0){
                                                                    $FareInfo0["TaxAmount"] =$jsons18;
                                                                }
                                                            }
                                                        }
                                                        // print_r($jsons17['air:FareRuleKey']);
                                                        // echo "<br/><br/>";
                                                        if(array_key_exists('air:FareRuleKey', $jsons17)){
                                                            $FareRuleKey0=[];
                                                            foreach($jsons17['air:FareRuleKey'] as $frk => $jsons19){
                                                                if(is_string($jsons19)){
                                                                    if(strcmp($frk, "@FareInfoRef") == 0){
                                                                        $FareRuleKey0["FareInfoRef"] =$jsons19;
                                                                    }
                                                                    if(strcmp($frk, "@ProviderCode") == 0){
                                                                        $FareRuleKey0["ProviderCode"] =$jsons19;
                                                                    }
                                                                    if(strcmp($frk, "$") == 0){
                                                                        $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
                                                                    }
                                                                }
                                                            }
                                                            $FareRuleKey1->push($FareRuleKey0);
                                                        }
                                                    }

                                                    if(empty($FareInfo) && !empty($FareInfo0)){
                                                        $FareInfo1->push($FareInfo0);
                                                    }
                                                    // $FareRuleKey1=collect();
                                                    if(array_key_exists('air:FareRuleKey', $value['air:FareInfo'])){
                                                        // print_r($value['air:FareInfo']['air:FareRuleKey']);
                                                        // echo "<br/><br/>";
                                                        $FareRuleKey=[];

                                                        foreach($value['air:FareInfo']['air:FareRuleKey'] as $frk => $jsons18){
                                                            // print_r($jsons18);
                                                            // echo "<br/><br/><br/>";
                                                            $FareRuleKey0=[];
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
                                                            }else{
                                                                foreach($jsons18 as $frk => $jsons19){
                                                                    if(is_string($jsons19)){
                                                                        // print_r($frk." - ".$jsons18);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($frk, "@FareInfoRef") == 0){
                                                                            $FareRuleKey0["FareInfoRef"] =$jsons19;
                                                                        }
                                                                        if(strcmp($frk, "@ProviderCode") == 0){
                                                                            $FareRuleKey0["ProviderCode"] =$jsons19;
                                                                        }
                                                                        if(strcmp($frk, "$") == 0){
                                                                            $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
                                                                        }
                                                                    }
                                                                }
                                                                // if(empty($FareRuleKey) && !empty($FareRuleKey0)){
                                                                //     $FareRuleKey1->push($FareRuleKey0);
                                                                // }
                                                            }
                                                        }
                                                        // if(!empty($FareRuleKey)){
                                                        //     $FareRuleKey1->push($FareRuleKey);
                                                        // }
                                                    }
                                                }
                                                if(!empty($FareInfo)){
                                                    $FareInfo1->push($FareInfo);
                                                }
                                                if(!empty($FareRuleKey)){
                                                    $FareRuleKey1->push($FareRuleKey);
                                                }
                                            }
                                            if(array_key_exists('air:BookingInfo', $value)){
                                                // $BookingInfo1=collect();
                                                $BookingInfo=[];
                                                foreach($value['air:BookingInfo'] as $bki => $jsons17){
                                                    $BookingInfo0=[];
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
                                                        $BookingInfo1->push($BookingInfo0);
                                                    }
                                                }
                                                // if(empty($BookingInfo) && !empty($BookingInfo0)){
                                                //     $BookingInfo1->push($BookingInfo0);
                                                // }
                                                if(!empty($BookingInfo)){
                                                    $BookingInfo1->push($BookingInfo);
                                                }
                                            }
                                            if(array_key_exists('air:TaxInfo', $value)){
                                                // $TaxInfo=collect();
                                                $TaxInfo1=[];
                                                foreach($value['air:TaxInfo'] as $jsons17){
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
                                            if(array_key_exists('air:FareCalc', $value)){
                                                $FareCalc=[];
                                                foreach($value['air:FareCalc'] as $fcc => $jsons17){
                                                    // print_r($jsons17);
                                                    if(is_string($jsons17)){
                                                        if(strcmp($fcc, "$") == 0){
                                                            $FareCalc["FareCalc"] =$jsons17;
                                                        }
                                                    }
                                                }
                                            }
                                            if(array_key_exists('air:PassengerType', $value)){
                                                // print_r();
                                                $PassengerType=[];
                                                foreach($value['air:PassengerType'] as $pc => $jsons17){
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
                                            if(array_key_exists('air:ChangePenalty', $value)){
                                                // $details4=[];
                                                foreach($value['air:ChangePenalty'] as $jsons17){
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
                                            if(array_key_exists('air:CancelPenalty', $value)){

                                                foreach($value['air:CancelPenalty'] as $jsons19){
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
                                            if(array_key_exists('air:BaggageAllowances', $value)){
                                                // print_r($jsons14['air:BaggageAllowances']);
                                                // echo "<br/><br/>";
                                                $count17=1;
                                                foreach($value['air:BaggageAllowances'] as $jsons17){
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

                                            // end multiple travel add adult and child

                                        }
                                        if(empty($AirPricingInfo1) && !empty($AirPricingInfo0)){
                                            $AirPricingInfo->push($AirPricingInfo0);
                                        }
                                    }
                                    if(!empty($AirPricingInfo1)){
                                        $AirPricingInfo->push($AirPricingInfo1);
                                    }
                                    if(array_key_exists('air:FareInfo', $jsons14)){
                                        // print_r($jsons14['air:FareInfo']);
                                        // return $jsons14['air:FareInfo'];
                                        // $FareInfo1=collect();
                                        $FareRuleKey1=collect();
                                        $FareInfo1=collect();
                                        $FareInfo=[];
                                        foreach($jsons14['air:FareInfo'] as $fI => $jsons17){
                                            $FareInfo0=[];
                                            // echo $count50;
                                            // print_r($jsons17);
                                            // echo "<br/><br/><br/>";
                                            // $FareRuleKey1=collect();
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
                                            }else{
                                                foreach($jsons17 as $fI =>$jsons18){
                                                    if(is_string($jsons18)){
                                                        // print_r($fI."-".$jsons17);
                                                        // echo "<br/><br/><br/>";
                                                        if(strcmp($fI, "@Key") == 0){
                                                            $FareInfo0["Key"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@FareBasis") == 0){
                                                            $FareInfo0["FareBasis"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@PassengerTypeCode") == 0){
                                                            $FareInfo0["PassengerTypeCode"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@Origin") == 0){
                                                            $FareInfo0["Origin"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@Destination") == 0){
                                                            $FareInfo0["Destination"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@EffectiveDate") == 0){
                                                            $FareInfo0["EffectiveDate"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@DepartureDate") == 0){
                                                            $FareInfo0["DepartureDate"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@Amount") == 0){
                                                            $FareInfo0["Amount"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@NegotiatedFare") == 0){
                                                            $FareInfo0["NegotiatedFare"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@NotValidBefore") == 0){
                                                            $FareInfo0["NotValidBefore"] =$jsons18;
                                                        }
                                                        if(strcmp($fI, "@TaxAmount") == 0){
                                                            $FareInfo0["TaxAmount"] =$jsons18;
                                                        }
                                                    }
                                                }
                                                // print_r($jsons17['air:FareRuleKey']);
                                                // echo "<br/><br/>";
                                                if(array_key_exists('air:FareRuleKey', $jsons17)){
                                                    $FareRuleKey0=[];
                                                    foreach($jsons17['air:FareRuleKey'] as $frk => $jsons19){
                                                        if(is_string($jsons19)){
                                                            if(strcmp($frk, "@FareInfoRef") == 0){
                                                                $FareRuleKey0["FareInfoRef"] =$jsons19;
                                                            }
                                                            if(strcmp($frk, "@ProviderCode") == 0){
                                                                $FareRuleKey0["ProviderCode"] =$jsons19;
                                                            }
                                                            if(strcmp($frk, "$") == 0){
                                                                $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
                                                            }
                                                        }
                                                    }
                                                    $FareRuleKey1->push($FareRuleKey0);
                                                }
                                            }

                                            if(empty($FareInfo) && !empty($FareInfo0)){
                                                $FareInfo1->push($FareInfo0);
                                            }
                                            // $FareRuleKey1=collect();
                                            if(array_key_exists('air:FareRuleKey', $jsons14['air:FareInfo'])){
                                                // print_r($jsons14['air:FareInfo']['air:FareRuleKey']);
                                                $FareRuleKey=[];

                                                foreach($jsons14['air:FareInfo']['air:FareRuleKey'] as $frk => $jsons18){
                                                    // print_r($jsons18);
                                                    // echo "<br/><br/><br/>";
                                                    $FareRuleKey0=[];
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
                                                    }else{
                                                        foreach($jsons18 as $frk => $jsons19){
                                                            if(is_string($jsons19)){
                                                                // print_r($frk." - ".$jsons18);
                                                                // echo "<br/><br/><br/>";
                                                                if(strcmp($frk, "@FareInfoRef") == 0){
                                                                    $FareRuleKey0["FareInfoRef"] =$jsons19;
                                                                }
                                                                if(strcmp($frk, "@ProviderCode") == 0){
                                                                    $FareRuleKey0["ProviderCode"] =$jsons19;
                                                                }
                                                                if(strcmp($frk, "$") == 0){
                                                                    $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
                                                                }
                                                            }
                                                        }
                                                        // if(empty($FareRuleKey) && !empty($FareRuleKey0)){
                                                        //     $FareRuleKey1->push($FareRuleKey0);
                                                        // }
                                                    }
                                                }
                                                // if(!empty($FareRuleKey)){
                                                //     $FareRuleKey1->push($FareRuleKey);
                                                // }
                                            }
                                        }
                                        if(!empty($FareInfo)){
                                            $FareInfo1->push($FareInfo);
                                        }
                                        if(!empty($FareRuleKey)){
                                            $FareRuleKey1->push($FareRuleKey);
                                        }


                                    }
                                    if(array_key_exists('air:BookingInfo', $jsons14)){
                                        $BookingInfo1=collect();
                                        $BookingInfo=[];
                                        foreach($jsons14['air:BookingInfo'] as $bki => $jsons17){
                                            $BookingInfo0=[];
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
                                                $BookingInfo1->push($BookingInfo0);
                                            }
                                        }
                                        if(!empty($BookingInfo)){
                                            $BookingInfo1->push($BookingInfo);
                                        }
                                    }
                                    if(array_key_exists('air:TaxInfo', $jsons14)){
                                        $TaxInfo=collect();
                                        $TaxInfo1=[];
                                        foreach($jsons14['air:TaxInfo'] as $jsons17){
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
                                    if(array_key_exists('air:FareCalc', $jsons14)){
                                        $FareCalc=[];
                                        foreach($jsons14['air:FareCalc'] as $fcc => $jsons17){
                                            // print_r($jsons17);
                                            if(is_string($jsons17)){
                                                if(strcmp($fcc, "$") == 0){
                                                    $FareCalc["FareCalc"] =$jsons17;
                                                }
                                            }
                                        }
                                    }
                                    if(array_key_exists('air:PassengerType', $jsons14)){
                                        // print_r();
                                        $PassengerType=[];
                                        foreach($jsons14['air:PassengerType'] as $pc => $jsons17){
                                            // print_r($jsons17);
                                            // echo "<br/><br/><br/>";
                                            if(is_string($jsons17)){
                                                if(strcmp($pc, "@Code") == 0){
                                                    $PassengerType["Code"] =$jsons17;
                                                }
                                            }
                                        }
                                    }
                                    // $details4=[];
                                    if(array_key_exists('air:ChangePenalty', $jsons14)){
                                        $details4=[];
                                        foreach($jsons14['air:ChangePenalty'] as $jsons17){
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
                                    if(array_key_exists('air:CancelPenalty', $jsons14)){

                                        foreach($jsons14['air:CancelPenalty'] as $jsons19){
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
                                    if(array_key_exists('air:BaggageAllowances', $jsons14)){
                                        // print_r($jsons14['air:BaggageAllowances']);
                                        // return $jsons14['air:BaggageAllowances'];
                                        // echo "<br/><br/>";
                                        $count17=1;
                                        foreach($jsons14['air:BaggageAllowances'] as $jsons17){
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
                                $data->push(["price"=>collect($price)]);
                                $data->push(["AirPricingInfo"=>collect($AirPricingInfo)]);
                                $data->push(["FareInfo"=>$FareInfo1]);
                                $data->push(["FareRuleKey"=>$FareRuleKey1]);
                                $data->push(["BookingInfo"=>$BookingInfo1]);

                                $HostToken=collect();
                                if(array_key_exists('common_v42_0:HostToken',$jsons2['air:AirPriceResult']['air:AirPricingSolution'][0])){
                                    // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['common_v42_0:HostToken'];
                                    $HostToken1=[];
                                    foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['common_v42_0:HostToken'] as $key => $value){
                                        $HostToken0=[];
                                        if(is_string($value)){
                                            if(strcmp($key, "@Key") == 0){
                                                $HostToken1["Key"]=$value;
                                            }
                                            if(strcmp($key, "$") == 0){
                                                $HostToken1["HostTokenvalue"]=$value;
                                            }
                                        }else{
                                            foreach($value as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "@Key") == 0){
                                                        $HostToken0["Key"]=$value1;
                                                    }
                                                    if(strcmp($key, "$") == 0){
                                                        $HostToken0["HostTokenvalue"]=$value1;
                                                    }
                                                }
                                            }
                                        }
                                        if($HostToken0!=null){
                                            $HostToken->push($HostToken0);
                                        }
                                    }
                                    if($HostToken1!=null){
                                        $HostToken->push($HostToken1);
                                    }
                                }
                                $data->push(["HostToken"=>collect($HostToken)]);
                                $data->push(["TaxInfo"=>$TaxInfo]);
                                $data->push(["FareCalc"=>$FareCalc]);
                                $data->push(["PassengerType"=>$PassengerType]);

                            }

                        }
                    }

                }
            }
        }
        // return $data;

        $arrNewResult = array();
        // $arrNewResult['changepenalty'] = $data[1]['details']['changepenalty'];
        $arrNewResult['changepenalty'] = isset($data[1]['details']['changepenalty'])?$data[1]['details']['changepenalty']:'';
        $arrNewResult['cancelpenalty'] = isset($data[1]['details']['cancelpenalty'])?$data[1]['details']['cancelpenalty']:'';
        $arrNewResult['baggageallowanceinfo'] = isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:'';
        $arrNewResult['carryonallowanceinfo'] = isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'';
        $status_json = json_encode($arrNewResult);
        echo $status_json;
        // echo $data[0]['journey'];
        // echo count($data[0]);
        // foreach($data[0] as $datas){
        //     echo count($datas);
        // }
        // return $request;
        // return view('flights.flight-details',[
        //     'per_flight_details'=>$request,
        //     'data'=>$data
        // ]);
        // return view('flights.flight-details');
    }

    public function FlightDetailsReturn(Request $request){
        $count=$request->count;
        // $flights=$request->flights;
         // $flights=json_decode($request->flights);
        // $flights=json_decode($request->input('flights'));
        $flights=$request->flights;
        // $flights=json_decode($request->flights,true);
        // $arrNewResult = array();
        // $arrNewResult['changepenalty'] = "gii";
        // foreach($flights[0] as $journeys){
        //     for ($i=0; $i < count($journeys); $i++) {
        //         // $arrNewResult['Key']=str_replace('["','',$journeys[$i]['Key']);
        //         $arrNewResult['key']=$journeys[$i]['Key'];
        //     }
        // }

        // // $arrNewResult = array();
        // // $arrNewResult['changepenalty'] = "gii";
        // // $arrNewResult['count'] = count($flights[0]);
        // $status_json = json_encode($arrNewResult);
        // echo $status_json;

        // return  $flightss;
        // echo count($flights[0]);
        $datasegment='';
        foreach($flights as $journeys){
            for ($i=0; $i < count($journeys); $i++) {
                // $datasegment.= implode('[', $journeys[$i]['Key']);
                // $datasegment.= str_replace('["','',$journeys[$i]['Key']);
                // $datasegment.= "<air:AirSegment Key='".implode('[', $journeys[$i]['Key'])."' Group='".implode('[', $journeys[$i]['Group'])."' Carrier='".implode('[', $journeys[$i]['Airline'])."' FlightNumber='".implode('[', $journeys[$i]['Flight'])."' Origin='".implode('[', $journeys[$i]['From'])."' Destination='".implode('[', $journeys[$i]['To'])."' DepartureTime='".implode('[', $journeys[$i]['Depart'])."' ArrivalTime='".implode('[', $journeys[$i]['Arrive'])."' FlightTime='".implode('[', $journeys[$i]['FlightTime'])."' Distance='".implode('[', $journeys[$i]['Distance'])."' ETicketability='Yes' ProviderCode='1G' ></air:AirSegment>";
                $datasegment.= '<air:AirSegment Key="'.implode('[', $journeys[$i]['Key']).'" Group="'.implode('[', $journeys[$i]['Group']).'" Carrier="'.implode('[', $journeys[$i]['Airline']).'" FlightNumber="'.implode('[', $journeys[$i]['Flight']).'" Origin="'.implode('[', $journeys[$i]['From']).'" Destination="'.implode('[', $journeys[$i]['To']).'" DepartureTime="'.implode('[', $journeys[$i]['Depart']).'" ArrivalTime="'.implode('[', $journeys[$i]['Arrive']).'" FlightTime="'.implode('[', $journeys[$i]['FlightTime']).'" Distance="'.implode('[', $journeys[$i]['Distance']).'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            }
        }
        // $arrNewResult['count'] = $datasegment;
        // $status_json = json_encode($arrNewResult);
        // echo $status_json;
        // $datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" Equipment="E90" ChangeOfPlane="false" ParticipantLevel="Secure Sell" LinkAvailability="true" PolledAvailabilityOption="Polled avail used" OptionalServicesIndicator="false" AvailabilitySource="S" AvailabilityDisplayType="Fare Shop/Optimal Shop" ProviderCode="1G" ClassOfService="W"></air:AirSegment>';
        // echo  get_object_vars($journeys[$i]->Key)[0]; echo "<br/>";

        // return $datasegment;
        // foreach($flights[1] as $prices){
        // }
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');

        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
           <air:AirPriceReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" FareRuleType="long" xmlns:air="http://www.travelport.com/schema/air_v42_0">
              <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <air:AirItinerary>
                '.$datasegment.'
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

        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);

        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                if(count($jsons1)>1){
                    foreach($jsons1 as $jsons2){
                        // print_r($jsons3);
                        if(count($jsons2)>1){
                            foreach($jsons2 as $jsons3){
                                if(is_array($jsons3)){
                                    // echo $count." count";
                                        // echo "<br/>";
                                    if($count==3){
                                        // print_r($jsons3);
                                        // echo "<br/><br/>";
                                        $count2=1;
                                        foreach($jsons3 as $jsons4){
                                            // echo "count";
                                            // print_r($jsons4);
                                            // echo "<br/><br/>";
                                            $journey=collect();
                                            if($count2==2){
                                                // print_r($jsons4);
                                                // echo "<br/><br/>";
                                                $details1=[];
                                                // please check this position
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
        // return $data;

        $arrNewResult = array();
        // $arrNewResult['changepenalty'] = $data[1]['details']['changepenalty'];
        $arrNewResult['changepenalty'] = isset($data[1]['details']['changepenalty'])?$data[1]['details']['changepenalty']:'';
        $arrNewResult['cancelpenalty'] = isset($data[1]['details']['cancelpenalty'])?$data[1]['details']['cancelpenalty']:'';
        $arrNewResult['baggageallowanceinfo'] = isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:'';
        $arrNewResult['carryonallowanceinfo'] = isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'';
        $status_json = json_encode($arrNewResult);
        echo $status_json;
        // echo $data[0]['journey'];
        // echo count($data[0]);
        // foreach($data[0] as $datas){
        //     echo count($datas);
        // }
        // return $request;
        // return view('flights.flight-details',[
        //     'per_flight_details'=>$request,
        //     'data'=>$data
        // ]);
        // return view('flights.flight-details');
    }
}
