<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use SoapClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;

class TestController extends Controller
{
    public function Test3(){
        // $client = new SoapClient('https://www.dataaccess.com/webservicesserver/NumberConversion.wso?wsdl', array('soap_version'=>SOAP_1_1,'ubiNum' => 1,'exceptions' => true));
        // $response = $client->NumberToWords();
        // $response = $client->someFunction();
        // var_dump($response);
        // return "hii";
        // return view('index');
    }
    public function Test1(){
        $client = new SoapClient('https://www.dataaccess.com/webservicesserver/NumberConversion.wso?wsdl', array('soap_version'=>SOAP_1_1,'ubiNum' => 1,'exceptions' => true));
        $response = $client->NumberToWords();
        $response = $client->someFunction();
        var_dump($response);
        // return "hii";
    }

    public function Test33(){
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $query = '<LowFareSearchReq xmlns="http://www.travelport.com/schema/air_v42_0" TraceId="f07c8f10-5c90-4888-a735-9a820730fa74" TargetBranch="P7087680" ReturnUpsellFare="true">
        <BillingPointOfSaleInfo xmlns="http://www.travelport.com/schema/common_v42_0" OriginApplication="uAPI" />
        <SearchAirLeg>
          <SearchOrigin>
            <CityOrAirport xmlns="http://www.travelport.com/schema/common_v42_0" Code="DEL" PreferCity="true" />
          </SearchOrigin>
          <SearchDestination>
            <CityOrAirport xmlns="http://www.travelport.com/schema/common_v42_0" Code="CCU" PreferCity="true" />
          </SearchDestination>
          <SearchDepTime PreferredTime="2021-06-10" />
        </SearchAirLeg>
        <AirSearchModifiers>
          <PreferredProviders>
            <Provider xmlns="http://www.travelport.com/schema/common_v42_0" Code="1G" />
            <Provider xmlns="http://www.travelport.com/schema/common_v42_0" Code="ACH" />
          </PreferredProviders>
        </AirSearchModifiers>
        <SearchPassenger xmlns="http://www.travelport.com/schema/common_v42_0" Code="ADT" />
        <AirPricingModifiers>
          <AccountCodes>
            <AccountCode xmlns="http://www.travelport.com/schema/common_v42_0" Code="-" />
          </AccountCodes>
        </AirPricingModifiers>
      </LowFareSearchReq>';
    //   $message = <<<EOM $query EOM;
      $message =" <<<EOM $query EOM";
    // $message = $query ;
             $auth = base64_encode($CREDENTIALS);
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

             $content = $this->prettyPrint($return);
            //  $flights = ($this->parseOutput($content));
     
            return $content;
             
           
        // return "hii";
    }

    public function prettyPrint1($result){
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($result);
        $dom->formatOutput = true;
        //call function to write request/response in file
//        outputWriter($file,$dom->saveXML());
        return $dom->saveXML();
    }

    public function parseOutput1($content){	//parse the Search response to get values to use in detail request
        $data = collect();
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        //echo $LowFareSearchRsp;
        $xml = simplexml_load_String($LowFareSearchRsp, null, null, 'SOAP', true);

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
                                        dd($e);
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

public function Test(){
    $TARGETBRANCH = 'P7141733';
    $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
$Provider = '1G';//1G/1V/1P/ACH
$PreferredDate = date('Y-m-d', strtotime("+75 day"));
$message = <<<EOM
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Header/>
   <soapenv:Body>
      <air:LowFareSearchReq TraceId="trace" AuthorizedBy="user" SolutionResult="true" TargetBranch="$TARGETBRANCH" xmlns:air="http://www.travelport.com/schema/air_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
         <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="CCU"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="DEL"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="$PreferredDate">
            </air:SearchDepTime>            
         </air:SearchAirLeg>
         <air:AirSearchModifiers>
            <air:PreferredProviders>
               <com:Provider Code="$Provider"/>
            </air:PreferredProviders>
         </air:AirSearchModifiers>
		 <com:SearchPassenger BookingTravelerRef="1" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
      </air:LowFareSearchReq>
   </soapenv:Body>
</soapenv:Envelope>
EOM;


$file = "001-".$Provider."_LowFareSearchReq.xml"; // file name to save the request xml for test only(if you want to save the request/response)
$this->prettyPrint($message,$file);//call function to pretty print xml


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
//curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 30); 
//curl_setopt($soap_do, CURLOPT_TIMEOUT, 30); 
// curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false); 
// curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
// curl_setopt($soap_do, CURLOPT_POST, true ); 
curl_setopt($soap_do, CURLOPT_POSTFIELDS, $message); 
curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header); 
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($soap_do);
curl_close($soap_do);
// return $return;
$file = "001-".$Provider."_LowFareSearchRsp.xml"; // file name to save the response xml for test only(if you want to save the request/response)
$content = $this->prettyPrint($return,$file);
$this->parseOutput($content);
//outputWriter($file, $return);
//print_r(curl_getinfo($soap_do));
}



//Pretty print XML
public function prettyPrint($result,$file){
	$dom = new \DOMDocument;
	$dom->preserveWhiteSpace = false;
	$dom->loadXML($result);
	$dom->formatOutput = true;		
	//call function to write request/response in file	
	// outputWriter($file,$dom->saveXML());	
	return $dom->saveXML();
}

//function to write output in a file
function outputWriter($file,$content){	
	file_put_contents($file, $content); // Write request/response and save them in the File
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


public function parseOutput($content){	//parse the Search response to get values to use in detail request
	$LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
	//echo $LowFareSearchRsp;
	$xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);	
	
	if($xml)
		echo "Processing! Please wait!";
	else{
		trigger_error("Encoding Error!", E_USER_ERROR);
	}

	$Results = $xml->children('SOAP',true);
	foreach($Results->children('SOAP',true) as $fault){
		if(strcmp($fault->getName(),'Fault') == 0){
			trigger_error("Error occurred request/response processing!", E_USER_ERROR);
		}
	}
	
	/*$count = $count + 1;
						file_put_contents($fileName,"\r\n"."Air Segment ".$count."\r\n"."\r\n", FILE_APPEND);
						foreach($hp->attributes() as $a => $b	){
								$GLOBALS[$a] = "$b";
								//echo "$a"." : "."$b";
								file_put_contents($fileName,$a." : ".$b."\r\n", FILE_APPEND);
						}*/
	
	$count = 0;
	$fileName = public_path('flight/')."flights.txt";
	if(file_exists($fileName)){
		file_put_contents($fileName, "");
	}
    $data = collect();
	foreach($Results->children('air',true) as $lowFare){		
		foreach($lowFare->children('air',true) as $airPriceSol){	
            $flight = collect();		
			if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){				
				$count = $count + 1;
				file_put_contents($fileName, "Air Pricing Solutions Details ".$count.":\r\n", FILE_APPEND);
				file_put_contents($fileName,"--------------------------------------\r\n", FILE_APPEND);
				foreach($airPriceSol->children('air',true) as $journey){					
					if(strcmp($journey->getName(),'Journey') == 0){
						file_put_contents($fileName,"\r\nJourney Details: ", FILE_APPEND);
						file_put_contents($fileName,"\r\n", FILE_APPEND);
						file_put_contents($fileName,"--------------------------------------\r\n", FILE_APPEND);						
						// $journey=[];
                        $flightJourney = [];
                        $flightJourney1 = [];
                        foreach($journey->children('air', true) as $segmentRef){							
							if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){								
								foreach($segmentRef->attributes() as $a => $b){									
									$segment = $this->ListAirSegments($b, $lowFare);									
									foreach($segment->attributes() as $c => $d){
										if(strcmp($c, "Origin") == 0){
                                            // if (in_array("From", $flightJourney)){
                                            // $flightJourney['From'] = $d;
                                            // }else{
                                            //     $flightJourney['From1'] = $d;
                                            // }
                                            $flightJourney['From'] = $d;
											file_put_contents($fileName,"From ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "Destination") == 0){
                                            $flightJourney['To'] = $d;
											file_put_contents($fileName,"To ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "Carrier") == 0){											
                                            $flightJourney['Airline'] = $d;
											file_put_contents($fileName,"Airline: ".$d."\r\n", FILE_APPEND);	
										}
										if(strcmp($c, "FlightNumber") == 0){
                                            $flightJourney['Flight'] = $d;
											file_put_contents($fileName,"Flight ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "DepartureTime") == 0){											
                                            $flightJourney['Depart'] = $d;
											file_put_contents($fileName,"Depart ".$d."\r\n", FILE_APPEND);	
										}
										if(strcmp($c, "ArrivalTime") == 0){											
                                            $flightJourney['Arrive'] = $d;
											file_put_contents($fileName,"Arrive ".$d."\r\n", FILE_APPEND);	
										}
                                $flight['journey'] = collect($flightJourney);				
                                        	

									}
									
								}
                                // $flight['journey'] = collect($flightJourney);				

                                
							}
						}	
																	
					}					
				}
				foreach($airPriceSol->children('air',true) as $priceInfo){
					if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0){
						file_put_contents($fileName,"\r\nPricing Details: ", FILE_APPEND);
						file_put_contents($fileName,"\r\n", FILE_APPEND);
						file_put_contents($fileName,"--------------------------------------\r\n", FILE_APPEND);
						foreach($priceInfo->attributes() as $e => $f){
								if(strcmp($e, "ApproximateBasePrice") == 0){
									file_put_contents($fileName,"Approx. Base Price: ".$f."\r\n", FILE_APPEND);
								}
								if(strcmp($e, "ApproximateTaxes") == 0){
									file_put_contents($fileName,"Approx. Taxes: ".$f."\r\n", FILE_APPEND);
								}
								if(strcmp($e, "ApproximateTotalPrice") == 0){											
									file_put_contents($fileName,"Approx. Total Price: ".$f."\r\n", FILE_APPEND);	
								}
								if(strcmp($e, "BasePrice") == 0){
									file_put_contents($fileName,"Base Price: ".$f."\r\n", FILE_APPEND);
								}
								if(strcmp($e, "Taxes") == 0){											
									file_put_contents($fileName,"Taxes: ".$f."\r\n", FILE_APPEND);	
								}
								if(strcmp($e, "TotalPrice") == 0){											
									file_put_contents($fileName,"Total Price: ".$f."\r\n", FILE_APPEND);	
								}
								
						}
						foreach($priceInfo->children('air',true) as $bookingInfo){
							if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
								foreach($bookingInfo->attributes() as $e => $f){
									if(strcmp($e, "CabinClass") == 0){
										file_put_contents($fileName,"Cabin Class: ".$f."\r\n", FILE_APPEND);
									}
								}
							}
						}
						
					}
				}
                $data->push(['flight'=>collect($flight)]);
				file_put_contents($fileName,"\r\n", FILE_APPEND);
			}
			
		}
	}
	// $Token = 'Token';
	// $TokenKey = 'TokenKey';
	// $fileName = "tokens.txt";
	// if(file_exists($fileName)){
	// 	file_put_contents($fileName, "");
	// }
	// foreach($Results->children('air',true) as $nodes){
	// 	foreach($nodes->children('air',true) as $hsr){
	// 		if(strcmp($hsr->getName(),'HostTokenList') == 0){			
	// 			foreach($hsr->children('common_v29_0', true) as $ht){
	// 				if(strcmp($ht->getName(), 'HostToken') == 0){
	// 					$GLOBALS[$Token] = $ht[0];
	// 					foreach($ht->attributes() as $a => $b){
	// 						if(strcmp($a, 'Key') == 0){
	// 							file_put_contents($fileName,$TokenKey.":".$b."\r\n", FILE_APPEND);
	// 						}
	// 					}						
	// 					file_put_contents($fileName,$Token.":".$ht[0]."\r\n", FILE_APPEND);
	// 				}
	// 			}
	// 		}
	// 	}
	// }
	echo $data;
	echo "\r\n"."Processing Done. Please check results in files.";

}

}
