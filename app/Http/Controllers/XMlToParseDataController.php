<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class XMlToParseDataController extends Controller
{
    // api return xml data, this data convert to json format
    public function XMlToJSON($return){
        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);
        return $object;
    }

    // json data to parse particular record Air Price Req
    // some note: - this function one way flight price user whole code same
    public function AirPrice_old($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                // print_r($jsons1);
                // echo "<br/><br/>";
                if(array_key_exists('SOAP:Fault',$jsons1)){
                    // return "Error No data Found";
                    return $data;
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
        return $data;
    }

    public function AirPrice($object){
        $data=collect();
        $journey=collect();
        $count=1;
        foreach($object as $jsons){
            foreach($jsons as $jsons1){
                // print_r($jsons1);
                // echo "<br/><br/>";
                if(array_key_exists('SOAP:Fault',$jsons1)){
                    // return "Error No data Found";
                    return $data;
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
                                if(isset($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0])){
                                
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

                                }else{
                                    // return "else";




                                    $price=[];
                                    foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'] as $p => $jsons15){
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

                                    if(array_key_exists('air:AirPricingInfo',$jsons2['air:AirPriceResult']['air:AirPricingSolution'])){
                                        $jsons14=$jsons2['air:AirPriceResult']['air:AirPricingSolution']['air:AirPricingInfo'];
                                        // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'];
                                        $AirPricingInfo1=[];
                                        foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution']['air:AirPricingInfo'] as $key => $value){
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
                                                                                if(is_array($jsons19)){
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
                                    if(array_key_exists('common_v42_0:HostToken',$jsons2['air:AirPriceResult']['air:AirPricingSolution'])){
                                        // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['common_v42_0:HostToken'];
                                        $HostToken1=[];
                                        foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution']['common_v42_0:HostToken'] as $key => $value){
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
        }
        return $data;
    }

    // json data to parse particular record Air Create Reservation Req
    public function AirCreateReservation($object){
        $data=collect();
        foreach($object as $revjson){
            foreach($revjson as $revjson1){
                // print_r($revjson1);
                // echo "<br/><br/><br/>";
                if(count($revjson1)>1){
                    if(array_key_exists('SOAP:Fault',$revjson1)){
                        // echo "error";
                        // return "error";
                        return $data;
                        // echo "<br/><br/><br/>";
                    }else{
                        // return $revjson1;
                        if(array_key_exists('universal:AirCreateReservationRsp',$revjson1)){
                            // return $revjson1['universal:AirCreateReservationRsp'];
                            if(array_key_exists('universal:UniversalRecord',$revjson1['universal:AirCreateReservationRsp'])){
                                // return $revjson1['universal:AirCreateReservationRsp']['universal:UniversalRecord'];
                                $unirec=$revjson1['universal:AirCreateReservationRsp']['universal:UniversalRecord'];
                                foreach($unirec as $key => $unirecs){
                                    if(is_string($unirecs)){
                                        if(strcmp($key, "@LocatorCode") == 0){
                                            $data['UniversalRecord']=$unirecs;
                                        }
                                    }
                                }
                                if(array_key_exists('air:AirReservation',$unirec)) {
                                    // return $unirec['air:AirReservation'];
                                    foreach($unirec['air:AirReservation'] as $key => $value){
                                        if(is_string($value)) {
                                            if(strcmp($key, "@LocatorCode") == 0){
                                                $data['AirReservation']=$value;
                                            }
                                        }
                                    }
                                    if(array_key_exists('air:AirPricingInfo',$unirec['air:AirReservation'])){
                                        // return $unirec['air:AirReservation']['air:AirPricingInfo'];
                                        $AirPricingInfo=[];
                                        foreach($unirec['air:AirReservation']['air:AirPricingInfo'] as $api => $json7){
                                            if(is_string($json7)){
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
                                            }
                                        }
                                        $data['AirPricingInfo']=$AirPricingInfo;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    // json data to parse particular record Universal Record
    public function UniversalRecord_old($object){
        $unidata=collect();
        foreach($object as $unvjson){
            foreach($unvjson as $unvjson1){
                // print_r($unvjson1);
                // echo "<br/><br/><br/>";
                if(count($unvjson1)>1){
                    if(array_key_exists('SOAP:Fault',$unvjson1)){
                        echo "error";
                        return "error";
                        // echo "<br/><br/><br/>";
                    }else{
                        // print_r($unvjson1);
                        // echo "<br/><br/><br/>";
                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']);
                        // echo "<br/><br/><br/>";
                        if(array_key_exists('universal:UniversalRecordRetrieveRsp',$unvjson1)){
                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']);
                            $Transaction_details=[];
                            foreach($unvjson1['universal:UniversalRecordRetrieveRsp'] as $key => $value){
                                if(is_string($value)){
                                    if(strcmp($key, "@TransactionId") == 0){
                                        $Transaction_details['TransactionId']=$value;
                                    }
                                }
                            }
                            $UniversalRecord=[];
                            if(array_key_exists('universal:UniversalRecord',$unvjson1['universal:UniversalRecordRetrieveRsp'])){
                                // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']);
                                foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'] as $key => $value){
                                    if(is_string($value)){
                                        if(strcmp($key, "@LocatorCode") == 0){
                                            $UniversalRecord['LocatorCode']=$value;
                                        }
                                        if(strcmp($key, "@Version") == 0){
                                            $UniversalRecord['Version']=$value;
                                        }
                                        if(strcmp($key, "@Status") == 0){
                                            $UniversalRecord['Status']=$value;
                                        }
                                    }
                                }
                            }
                            $per_details=[];
                            if(array_key_exists('common_v42_0:BookingTraveler',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'])){
                                // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']);
                                foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'] as $key => $value){
                                    if(is_string($value)){
                                        if(strcmp($key, "@TravelerType") == 0){
                                            $per_details['TravelerType']=$value;
                                        }
                                        if(strcmp($key, "@DOB") == 0){
                                            $per_details['DOB']=$value;
                                        }
                                        if(strcmp($key, "@Status") == 0){
                                            $per_details['Gender']=$value;
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:BookingTravelerName',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:BookingTravelerName']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:BookingTravelerName'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@Prefix") == 0){
                                                $per_details['Prefix']=$value;
                                            }
                                            if(strcmp($key, "@First") == 0){
                                                $per_details['First']=$value;
                                            }
                                            if(strcmp($key, "@Last") == 0){
                                                $per_details['Last']=$value;
                                            }
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:PhoneNumber',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:PhoneNumber']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:PhoneNumber'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@Type") == 0){
                                                $per_details['Type']=$value;
                                            }
                                            if(strcmp($key, "@Location") == 0){
                                                $per_details['Location']=$value;
                                            }
                                            if(strcmp($key, "@Number") == 0){
                                                $per_details['Number']=$value;
                                            }
                                            if(strcmp($key, "@Text") == 0){
                                                $per_details['Text']=$value;
                                            }
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:Email',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Email']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Email'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@EmailID") == 0){
                                                $per_details['EmailID']=$value;
                                            }
                                            
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:Address',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']);
                                    if(array_key_exists('common_v42_0:AddressName',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:AddressName']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:AddressName'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['Address']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:Street',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Street']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Street'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['Street']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:City',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:City']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:City'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['City']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:State',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:State']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:State'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['State']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:PostalCode',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:PostalCode']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:PostalCode'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['PostalCode']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:Country',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Country']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Country'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['Country']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                }
                            }
                            $journey1=collect();
                            $price=[];
                            if(array_key_exists('air:AirReservation',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'])){
                                // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']);
                                if(array_key_exists('air:AirSegment',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']);
                                    $Journey=[];
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $value){
                                        // print_r($value);
                                        // echo "<br/><br/>";
                                        foreach($value as $key => $value1){
                                            if(is_string($value1)){
                                                if(strcmp($key, "@Key") == 0){
                                                    $Journey["Key"]=$value1;
                                                }
                                                if(strcmp($key, "Group") == 0){
                                                    $Journey["Group"]=$value1;
                                                }
                                                if(strcmp($key, "@Carrier") == 0){
                                                    $Journey['Carrier']=$value1;
                                                }
                                                if(strcmp($key, "@CabinClass") == 0){
                                                    $Journey['CabinClass']=$value1;
                                                }
                                                if(strcmp($key, "@FlightNumber") == 0){
                                                    $Journey['FlightNumber']=$value1;
                                                }
                                                if(strcmp($key, "@Origin") == 0){
                                                    $Journey['Origin']=$value1;
                                                }
                                                if(strcmp($key, "@Destination") == 0){
                                                    $Journey['Destination']=$value1;
                                                }
                                                if(strcmp($key, "@DepartureTime") == 0){
                                                    $Journey['DepartureTime']=$value1;
                                                }
                                                if(strcmp($key, "@ArrivalTime") == 0){
                                                    $Journey['ArrivalTime']=$value1;
                                                }
                                                if(strcmp($key, "@TravelTime") == 0){
                                                    $Journey['TravelTime']=$value1;
                                                }
                                                if(strcmp($key, "@Distance") == 0){
                                                    $Journey['Distance']=$value1;
                                                }
                                                if(strcmp($key, "@ChangeOfPlane") == 0){
                                                    $Journey['ChangeOfPlane']=$value1;
                                                }
                                            }
                                        }
                                        if(array_key_exists('air:FlightDetails',$value)){
                                            // print_r($value['air:FlightDetails']);
                                            // echo "<br/><br/>";
                                            foreach($value['air:FlightDetails'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "@OriginTerminal") == 0){
                                                        $Journey['OriginTerminal']=$value1;
                                                    }
                                                    if(strcmp($key, "@DestinationTerminal") == 0){
                                                        $Journey['DestinationTerminal']=$value1;
                                                    }
                                                }
                                            }
                                        }
                                        $journey1->push($Journey);
                                    }
                                }
                                if(array_key_exists('air:AirPricingInfo',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@Key") == 0){
                                                $price['Key']=$value;
                                            }
                                            if(strcmp($key, "@TotalPrice") == 0){
                                                $price['TotalPrice']=$value;
                                            }
                                            if(strcmp($key, "@BasePrice") == 0){
                                                $price['BasePrice']=$value;
                                            }
                                            if(strcmp($key, "@ApproximateTotalPrice") == 0){
                                                $price['ApproximateTotalPrice']=$value;
                                            }
                                            if(strcmp($key, "@ApproximateBasePrice") == 0){
                                                $price['ApproximateBasePrice']=$value;
                                            }
                                            if(strcmp($key, "@EquivalentBasePrice") == 0){
                                                $price['EquivalentBasePrice']=$value;
                                            }
                                            if(strcmp($key, "@Taxes") == 0){
                                                $price['Taxes']=$value;
                                            }
                                            if(strcmp($key, "@LatestTicketingTime") == 0){
                                                $price['LatestTicketingTime']=$value;
                                            }
                                            if(strcmp($key, "@TrueLastDateToTicket") == 0){
                                                $price['TrueLastDateToTicket']=$value;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
                    }
                    // unvjson7
                    $unidata->push(['personal_details'=>collect($per_details)]);
                    $unidata->push(['journey'=>collect($journey1)]);
                    $unidata->push(['price'=>collect($price)]);
                    $unidata->push(['UniversalRecord'=>collect($UniversalRecord)]);
                    $unidata->push(['Transaction_details'=>collect($Transaction_details)]);
                }
            }
        }
        return $unidata;
    }

    public function UniversalRecord($object){
        $unidata=collect();
        foreach($object as $unvjson){
            foreach($unvjson as $unvjson1){
                // print_r($unvjson1);
                // echo "<br/><br/><br/>";
                if(count($unvjson1)>1){
                    if(array_key_exists('SOAP:Fault',$unvjson1)){
                        echo "error";
                        return "error";
                        // echo "<br/><br/><br/>";
                    }else{
                        // print_r($unvjson1);
                        // echo "<br/><br/><br/>";
                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']);
                        // echo "<br/><br/><br/>";
                        if(array_key_exists('universal:UniversalRecordRetrieveRsp',$unvjson1)){
                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']);
                            $Transaction_details=[];
                            foreach($unvjson1['universal:UniversalRecordRetrieveRsp'] as $key => $value){
                                if(is_string($value)){
                                    if(strcmp($key, "@TransactionId") == 0){
                                        $Transaction_details['TransactionId']=$value;
                                    }
                                }
                            }
                            $UniversalRecord=[];
                            if(array_key_exists('universal:UniversalRecord',$unvjson1['universal:UniversalRecordRetrieveRsp'])){
                                // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']);
                                foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'] as $key => $value){
                                    if(is_string($value)){
                                        if(strcmp($key, "@LocatorCode") == 0){
                                            $UniversalRecord['LocatorCode']=$value;
                                        }
                                        if(strcmp($key, "@Version") == 0){
                                            $UniversalRecord['Version']=$value;
                                        }
                                        if(strcmp($key, "@Status") == 0){
                                            $UniversalRecord['Status']=$value;
                                        }
                                    }
                                }
                            }
                            if(array_key_exists('universal:ProviderReservationInfo',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'])){
                                foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['universal:ProviderReservationInfo'] as $key => $value){
                                    if(is_string($value)){
                                        if(strcmp($key, "@LocatorCode") == 0){
                                            $UniversalRecord['LocatorCode']=$value;
                                        }
                                        // if(strcmp($key, "@Version") == 0){
                                        //     $UniversalRecord['Version']=$value;
                                        // }
                                        // if(strcmp($key, "@Status") == 0){
                                        //     $UniversalRecord['Status']=$value;
                                        // }
                                    }
                                }
                            }
                            $per_details1=collect();
                            $per_details=[];
                            $per_details0=[];
                            if(array_key_exists('common_v42_0:BookingTraveler',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'])){
                                // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']);
                                // return ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']);
                                // return is_array($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']);
                                foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'] as $key => $value){
                                    // $per_details0=[];
                                    if(is_string($value)){
                                        if(strcmp($key, "@TravelerType") == 0){
                                            $per_details['TravelerType']=$value;
                                        }
                                        if(strcmp($key, "@DOB") == 0){
                                            $per_details['DOB']=$value;
                                        }
                                        if(strcmp($key, "@Status") == 0){
                                            $per_details['Gender']=$value;
                                        }
                                    }else{
                                      // print_r($value);
                                      // echo "<br/><br/><br/><br/><br/><br/>";
                                      // return ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']);
                                      foreach($value as $key => $value1){
                                        if(is_string($value1)){
                                          // print_r($key."----".$value1);
                                          // echo "<br/><br/>";
                                          if(strcmp($key, "@TravelerType") == 0){
                                              $per_details0['TravelerType']=$value1;
                                          }
                                          if(strcmp($key, "@DOB") == 0){
                                              $per_details0['DOB']=$value1;
                                          }
                                          if(strcmp($key, "@Gender") == 0){
                                              $per_details0['Gender']=$value1;
                                          }
                                        }
                                      }
                                      if(array_key_exists('common_v42_0:BookingTravelerName',$value)){
                                        // return $value['common_v42_0:BookingTravelerName'];
                                        foreach($value['common_v42_0:BookingTravelerName'] as $key => $value1){
                                          // print_r($value1);
                                          // echo "<br/><br/>";
                                            if(is_string($value1)){
                                              // print_r($key."----".$value1);
                                              // echo "<br/><br/>";
                                                if(strcmp($key, "@Prefix") == 0){
                                                    $per_details0['Prefix']=$value1;
                                                }
                                                if(strcmp($key, "@First") == 0){
                                                    $per_details0['First']=$value1;
                                                }
                                                if(strcmp($key, "@Last") == 0){
                                                    $per_details0['Last']=$value1;
                                                }
                                            }
                                        }
                                      }
                                      if(array_key_exists('common_v42_0:PhoneNumber',$value)){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:PhoneNumber']);
                                        foreach($value['common_v42_0:PhoneNumber'] as $key => $value1){
                                            if(is_string($value1)){
                                                if(strcmp($key, "@Type") == 0){
                                                    $per_details0['Type']=$value1;
                                                }
                                                if(strcmp($key, "@Location") == 0){
                                                    $per_details0['Location']=$value1;
                                                }
                                                if(strcmp($key, "@Number") == 0){
                                                    $per_details0['Number']=$value1;
                                                }
                                                if(strcmp($key, "@Text") == 0){
                                                    $per_details0['Text']=$value1;
                                                }
                                            }
                                        }
                                      }
                                      if(array_key_exists('common_v42_0:Email',$value)){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Email']);
                                        foreach($value['common_v42_0:Email'] as $key => $value1){
                                            if(is_string($value1)){
                                                if(strcmp($key, "@EmailID") == 0){
                                                    $per_details0['EmailID']=$value1;
                                                }
                                                
                                            }
                                        }
                                      }
                                      if(array_key_exists('common_v42_0:Address',$value)){
                                        if(array_key_exists('common_v42_0:AddressName',$value['common_v42_0:Address'])){
                                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:AddressName']);
                                            foreach($value['common_v42_0:Address']['common_v42_0:AddressName'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "$") == 0){
                                                        $per_details0['Address']=$value1;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                        if(array_key_exists('common_v42_0:Street',$value['common_v42_0:Address'])){
                                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Street']);
                                            foreach($value['common_v42_0:Address']['common_v42_0:Street'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "$") == 0){
                                                        $per_details0['Street']=$value1;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                        if(array_key_exists('common_v42_0:City',$value['common_v42_0:Address'])){
                                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:City']);
                                            foreach($value['common_v42_0:Address']['common_v42_0:City'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "$") == 0){
                                                        $per_details0['City']=$value1;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                        if(array_key_exists('common_v42_0:State',$value['common_v42_0:Address'])){
                                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:State']);
                                            foreach($value['common_v42_0:Address']['common_v42_0:State'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "$") == 0){
                                                        $per_details0['State']=$value1;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                        if(array_key_exists('common_v42_0:PostalCode',$value['common_v42_0:Address'])){
                                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:PostalCode']);
                                            foreach($value['common_v42_0:Address']['common_v42_0:PostalCode'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "$") == 0){
                                                        $per_details0['PostalCode']=$value1;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                        if(array_key_exists('common_v42_0:Country',$value['common_v42_0:Address'])){
                                            // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Country']);
                                            foreach($value['common_v42_0:Address']['common_v42_0:Country'] as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "$") == 0){
                                                        $per_details0['Country']=$value1;
                                                    }
                                                    
                                                }
                                            }
                                        }
                                      }
                                      
                                      if(empty($per_details) && !empty($per_details0)){
                                        $per_details1->push($per_details0);
                                      }
                                    }
                                }
                                if(array_key_exists('common_v42_0:BookingTravelerName',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:BookingTravelerName']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:BookingTravelerName'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@Prefix") == 0){
                                                $per_details['Prefix']=$value;
                                            }
                                            if(strcmp($key, "@First") == 0){
                                                $per_details['First']=$value;
                                            }
                                            if(strcmp($key, "@Last") == 0){
                                                $per_details['Last']=$value;
                                            }
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:PhoneNumber',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:PhoneNumber']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:PhoneNumber'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@Type") == 0){
                                                $per_details['Type']=$value;
                                            }
                                            if(strcmp($key, "@Location") == 0){
                                                $per_details['Location']=$value;
                                            }
                                            if(strcmp($key, "@Number") == 0){
                                                $per_details['Number']=$value;
                                            }
                                            if(strcmp($key, "@Text") == 0){
                                                $per_details['Text']=$value;
                                            }
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:Email',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Email']);
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Email'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@EmailID") == 0){
                                                $per_details['EmailID']=$value;
                                            }
                                            
                                        }
                                    }
                                }
                                if(array_key_exists('common_v42_0:Address',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']);
                                    if(array_key_exists('common_v42_0:AddressName',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:AddressName']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:AddressName'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['Address']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:Street',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Street']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Street'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['Street']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:City',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:City']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:City'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['City']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:State',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:State']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:State'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['State']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:PostalCode',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:PostalCode']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:PostalCode'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['PostalCode']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                    if(array_key_exists('common_v42_0:Country',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address'])){
                                        // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Country']);
                                        foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['common_v42_0:BookingTraveler']['common_v42_0:Address']['common_v42_0:Country'] as $key => $value){
                                            if(is_string($value)){
                                                if(strcmp($key, "$") == 0){
                                                    $per_details['Country']=$value;
                                                }
                                                
                                            }
                                        }
                                    }
                                }
                                if(!empty($per_details)){
                                  $per_details1->push($per_details);
                                }
                            }
                            $journey1=collect();
                            $price1=collect();
                            $price=[];
                            if(array_key_exists('air:AirReservation',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord'])){
                                // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']);
                                if(array_key_exists('air:AirSegment',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation'])){
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']);
                                    // return ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']);
                                    $json_flight=($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirSegment']);
                                    $Journey=[];
                                    $Journey0=[];
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirSegment'] as $key => $value){
                                      // print_r($value);
                                        // echo "<br/><br/>";
                                        if(is_string($value)){
                                            if(strcmp($key, "@Key") == 0){
                                                $Journey0["Key"]=$value;
                                            }
                                            if(strcmp($key, "Group") == 0){
                                                $Journey0["Group"]=$value;
                                            }
                                            if(strcmp($key, "@Carrier") == 0){
                                                $Journey0['Carrier']=$value;
                                            }
                                            if(strcmp($key, "@CabinClass") == 0){
                                                $Journey0['CabinClass']=$value;
                                            }
                                            if(strcmp($key, "@FlightNumber") == 0){
                                                $Journey0['FlightNumber']=$value;
                                            }
                                            if(strcmp($key, "@Origin") == 0){
                                                $Journey0['Origin']=$value;
                                            }
                                            if(strcmp($key, "@Destination") == 0){
                                                $Journey0['Destination']=$value;
                                            }
                                            if(strcmp($key, "@DepartureTime") == 0){
                                                $Journey0['DepartureTime']=$value;
                                            }
                                            if(strcmp($key, "@ArrivalTime") == 0){
                                                $Journey0['ArrivalTime']=$value;
                                            }
                                            if(strcmp($key, "@TravelTime") == 0){
                                                $Journey0['TravelTime']=$value;
                                            }
                                            if(strcmp($key, "@Distance") == 0){
                                                $Journey0['Distance']=$value;
                                            }
                                            if(strcmp($key, "@ChangeOfPlane") == 0){
                                                $Journey0['ChangeOfPlane']=$value;
                                            }
                                        }else{
                                            foreach($value as $key => $value1){
                                                if(is_string($value1)){
                                                    if(strcmp($key, "@Key") == 0){
                                                        $Journey["Key"]=$value1;
                                                    }
                                                    if(strcmp($key, "Group") == 0){
                                                        $Journey["Group"]=$value1;
                                                    }
                                                    if(strcmp($key, "@Carrier") == 0){
                                                        $Journey['Carrier']=$value1;
                                                    }
                                                    if(strcmp($key, "@CabinClass") == 0){
                                                        $Journey['CabinClass']=$value1;
                                                    }
                                                    if(strcmp($key, "@FlightNumber") == 0){
                                                        $Journey['FlightNumber']=$value1;
                                                    }
                                                    if(strcmp($key, "@Origin") == 0){
                                                        $Journey['Origin']=$value1;
                                                    }
                                                    if(strcmp($key, "@Destination") == 0){
                                                        $Journey['Destination']=$value1;
                                                    }
                                                    if(strcmp($key, "@DepartureTime") == 0){
                                                        $Journey['DepartureTime']=$value1;
                                                    }
                                                    if(strcmp($key, "@ArrivalTime") == 0){
                                                        $Journey['ArrivalTime']=$value1;
                                                    }
                                                    if(strcmp($key, "@TravelTime") == 0){
                                                        $Journey['TravelTime']=$value1;
                                                    }
                                                    if(strcmp($key, "@Distance") == 0){
                                                        $Journey['Distance']=$value1;
                                                    }
                                                    if(strcmp($key, "@ChangeOfPlane") == 0){
                                                        $Journey['ChangeOfPlane']=$value1;
                                                    }
                                                }
                                            }
                                            if(array_key_exists('air:FlightDetails',$value)){
                                                // print_r($value['air:FlightDetails']);
                                                // echo "<br/><br/>";
                                                foreach($value['air:FlightDetails'] as $key => $value1){
                                                    if(is_string($value1)){
                                                        if(strcmp($key, "@OriginTerminal") == 0){
                                                            $Journey['OriginTerminal']=$value1;
                                                        }
                                                        if(strcmp($key, "@DestinationTerminal") == 0){
                                                            $Journey['DestinationTerminal']=$value1;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        
                                        if(empty($Journey0) && !empty($Journey)){
                                          $journey1->push($Journey);
                                        }
                                    }
                                    if(array_key_exists('air:FlightDetails',$json_flight)){
                                      // print_r($value['air:FlightDetails']);
                                      // echo "<br/><br/>";
                                      foreach($json_flight['air:FlightDetails'] as $key => $value1){
                                          if(is_string($value1)){
                                              if(strcmp($key, "@OriginTerminal") == 0){
                                                  $Journey0['OriginTerminal']=$value1;
                                              }
                                              if(strcmp($key, "@DestinationTerminal") == 0){
                                                  $Journey0['DestinationTerminal']=$value1;
                                              }
                                          }
                                      }
                                    }
                                    if(!empty($Journey0) ){
                                        $journey1->push($Journey0);
                                    }
                                }
                                if(array_key_exists('air:AirPricingInfo',$unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation'])){
                                    // return ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']);
                                    // print_r ($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo']);
                                    $price0=[];
                                    foreach($unvjson1['universal:UniversalRecordRetrieveRsp']['universal:UniversalRecord']['air:AirReservation']['air:AirPricingInfo'] as $key => $value){
                                        if(is_string($value)){
                                            if(strcmp($key, "@Key") == 0){
                                                $price['Key']=$value;
                                            }
                                            if(strcmp($key, "@TotalPrice") == 0){
                                                $price['TotalPrice']=$value;
                                            }
                                            if(strcmp($key, "@BasePrice") == 0){
                                                $price['BasePrice']=$value;
                                            }
                                            if(strcmp($key, "@ApproximateTotalPrice") == 0){
                                                $price['ApproximateTotalPrice']=$value;
                                            }
                                            if(strcmp($key, "@ApproximateBasePrice") == 0){
                                                $price['ApproximateBasePrice']=$value;
                                            }
                                            if(strcmp($key, "@EquivalentBasePrice") == 0){
                                                $price['EquivalentBasePrice']=$value;
                                            }
                                            if(strcmp($key, "@Taxes") == 0){
                                                $price['Taxes']=$value;
                                            }
                                            if(strcmp($key, "@LatestTicketingTime") == 0){
                                                $price['LatestTicketingTime']=$value;
                                            }
                                            if(strcmp($key, "@TrueLastDateToTicket") == 0){
                                                $price['TrueLastDateToTicket']=$value;
                                            }
                                        }else{
                                          foreach($value as $key => $value1){
                                            if(is_string($value1)){
                                              if(strcmp($key, "@Key") == 0){
                                                  $price0['Key']=$value1;
                                              }
                                              if(strcmp($key, "@TotalPrice") == 0){
                                                  $price0['TotalPrice']=$value1;
                                              }
                                              if(strcmp($key, "@BasePrice") == 0){
                                                  $price0['BasePrice']=$value1;
                                              }
                                              if(strcmp($key, "@ApproximateTotalPrice") == 0){
                                                  $price0['ApproximateTotalPrice']=$value1;
                                              }
                                              if(strcmp($key, "@ApproximateBasePrice") == 0){
                                                  $price0['ApproximateBasePrice']=$value1;
                                              }
                                              if(strcmp($key, "@EquivalentBasePrice") == 0){
                                                  $price0['EquivalentBasePrice']=$value1;
                                              }
                                              if(strcmp($key, "@Taxes") == 0){
                                                  $price0['Taxes']=$value1;
                                              }
                                              if(strcmp($key, "@LatestTicketingTime") == 0){
                                                  $price0['LatestTicketingTime']=$value1;
                                              }
                                              if(strcmp($key, "@TrueLastDateToTicket") == 0){
                                                  $price0['TrueLastDateToTicket']=$value1;
                                              }
                                          }
                                          }
                                        }
                                        if(empty($price) && !empty($price0)){
                                          $price1->push($price0);
                                        }
                                    }
                                    if(!empty($price) ){
                                      $price1->push($price);
                                    }
                                }
                            }
                        }
                        
                    }
                    // unvjson7
                    $unidata->push(['personal_details'=>collect($per_details1)]);
                    $unidata->push(['journey'=>collect($journey1)]);
                    $unidata->push(['price'=>collect($price1)]);
                    $unidata->push(['UniversalRecord'=>collect($UniversalRecord)]);
                    $unidata->push(['Transaction_details'=>collect($Transaction_details)]);
                }
            }
        }    
        return $unidata;
    }

    public function DBjsonData($unidata,$currency_code,$currency)
    {
        # code...
    }
}
