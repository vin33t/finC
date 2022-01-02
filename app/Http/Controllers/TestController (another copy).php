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
$f=$this->parseOutput($content);
return $f;
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
	
	// if($xml)
	// 	echo "Processing! Please wait!";
	// else{
	// 	trigger_error("Encoding Error!", E_USER_ERROR);
	// }

	$Results = $xml->children('SOAP',true);
	foreach($Results->children('SOAP',true) as $fault){
		if(strcmp($fault->getName(),'Fault') == 0){
			trigger_error("Error occurred request/response processing!", E_USER_ERROR);
		}
	}
	
	
	$count = 0;
	$fileName = public_path('flight/')."flights.txt";
	if(file_exists($fileName)){
		file_put_contents($fileName, "");
	}

	$data = collect();
    
	foreach($Results->children('air',true) as $lowFare){		
		foreach($lowFare->children('air',true) as $airPriceSol){	
            		
			if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){		
               		
				$count = $count + 1;
				file_put_contents($fileName, "Air Pricing Solutions Details ".$count.":\r\n", FILE_APPEND);
				file_put_contents($fileName,"--------------------------------------\r\n", FILE_APPEND);
				foreach($airPriceSol->children('air',true) as $journey){					
					if(strcmp($journey->getName(),'Journey') == 0){
						file_put_contents($fileName,"\r\nJourney Details: ", FILE_APPEND);
						file_put_contents($fileName,"\r\n", FILE_APPEND);
						file_put_contents($fileName,"--------------------------------------\r\n", FILE_APPEND);						
                        $Journey= collect();
                        $journeydetails = collect();
                        foreach($journey->children('air', true) as $segmentRef){	
                           						
							if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){								
                                
                                foreach($segmentRef->attributes() as $a => $b){	
                                   
									$segment = $this->ListAirSegments($b, $lowFare);
									foreach($segment->attributes() as $c => $d){
                                        if(strcmp($c, "Origin") == 0){
                                            $journeydetails->push(['From'=>$d]);
											file_put_contents($fileName,"From ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "Destination") == 0){
                                            $journeydetails->push(['To'=>$d]);
											file_put_contents($fileName,"To ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "Carrier") == 0){		
                                            $journeydetails->push(['Airline'=>$d]);									
											file_put_contents($fileName,"Airline: ".$d."\r\n", FILE_APPEND);	
										}
										if(strcmp($c, "FlightNumber") == 0){	
                                            $journeydetails->push(['flight'=>$d]);
											file_put_contents($fileName,"Flight ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "DepartureTime") == 0){	
                                            $journeydetails->push(['Depart'=>$d]);										
											file_put_contents($fileName,"Depart ".$d."\r\n", FILE_APPEND);	
										}
										if(strcmp($c, "ArrivalTime") == 0){	
                                            $journeydetails->push(['Arrive'=>$d]);										
											file_put_contents($fileName,"Arrive ".$d."\r\n", FILE_APPEND);	
										}	

									
									}
                                 
								}
                                
                              
							}
						}	
						 $Journey->push(['journey'=>collect($journeydetails)]);				
											
					}					
				}
				
               $data->push(['flight'=>collect($Journey)]);
               file_put_contents($fileName,"\r\n", FILE_APPEND);
			}
			
		}
	}
	
	// print_r($data) ;
    // echo $data;
    return $data;
	// echo "\r\n"."Processing Done. Please check results in files.";

}

}
