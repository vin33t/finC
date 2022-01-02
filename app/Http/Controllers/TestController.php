<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use SoapClient;
use Carbon\Carbon;
// use GuzzleHttp\Client;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\invoice;
use App\Models\client;
use App\Models\settings;
use App\Models\Flight;
use App\Models\Passenger;

class TestController extends Controller
{

public function Test11(){
  // return Hash::make('ADT1');
    $TARGETBRANCH = 'P7141733';
    $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
    $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
    $returnSearch = '';
    $searchLegModifier = '';
    $query = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
    <soapenv:Body>
       <univ:UniversalRecordRetrieveReq TargetBranch="'.$TARGETBRANCH.'" TraceId="trace" xmlns:univ="http://www.travelport.com/schema/universal_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
          <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
          <univ:UniversalRecordLocatorCode>14A3FI</univ:UniversalRecordLocatorCode>
       </univ:UniversalRecordRetrieveReq>
    </soapenv:Body>
 </soapenv:Envelope>';
// return $query; 13WX71 13WUOT ---multiple 147OL2  --- single adt 147ON3  --- 3type 14A3FI
        $message = <<<EOM
$query
EOM;
    $auth = base64_encode($CREDENTIALS);
    $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
    // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");
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
    $return2 = curl_exec($soap_do);
    curl_close($soap_do);
    // return $return2;

    $dom2 = new \DOMDocument();
    $dom2->loadXML($return2);
    $json2 = new \FluentDOM\Serializer\Json\RabbitFish($dom2);
    $object = json_decode($json2,true);
    // return $object;

    // array_key_exists($index, $array);
    // universal:UniversalRecordRetrieveRsp
    // $unidata=collect();
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
        // foreach($unidata[0] as $unidatas){
        //     // print_r($unidatas);
        //     // foreach($unidatas[0] as $unidatass){
        //     //     print_r($unidatass);
        //     // echo $unidatas[0]['DOB'];

        //     foreach($unidatas as $unidatass1){
        //         // echo $unidatass1['DOB'];
        //         // for ($i=1; $i <= count($unidatass1); $i++) { 
        //         //     echo $unidatass1[$i]['Carrier'];
        //         //     echo "<br/>";

        //         // }
        //     }
        //     // }
        //     // echo "<br/>";
        //     // foreach($unidatas[1] as $unidatass){
        //     //     print_r($unidatass);
        //     //     // for ($i=1; $i <= count($unidatass); $i++) { 
        //     //     //     echo $unidatass[$i]['Carrier'];
        //     //     // }
        //     // }
        // }
}

public function Test(Request $request)
{
    // return "hii";
    // 16QO87  via
    // 16QMOE    single
    // 16UOD0 via round
    $xml_data='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
            <univ:UniversalRecordRetrieveReq TargetBranch="P7141733" TraceId="trace" xmlns:univ="http://www.travelport.com/schema/universal_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
                <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
                <univ:UniversalRecordLocatorCode>172WOF</univ:UniversalRecordLocatorCode>
            </univ:UniversalRecordRetrieveReq>
        </soapenv:Body>
        </soapenv:Envelope>';
        $api_url='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService';
        $return2 =app('App\Http\Controllers\UtilityController')->universal_API($xml_data,$api_url);
        // return $return2;
        $object2 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return2);
        // return $object2;
        $unidata =app('App\Http\Controllers\XMlToParseDataController')->UniversalRecord($object2);
        // return $unidata;
        return $unidata[3]['UniversalRecord']['LocatorCode'];


        if (count($unidata[1]['journey'])>2) {
            $journey_stop=["1"];
        }else{
            $journey_stop=["0"];
        }
        // return $journey_stop;
        $universal_pnr=$unidata[3]['UniversalRecord']['LocatorCode'];

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

        $round_push= count($unidata[1]['journey'])/2;

        $segment_two_flight=[];      
        $segment_two_from=[];
        $segment_two_to=[];
        $segment_two_carrier=[];
        $segment_two_class=[];
        $segment_two_Flight_No=[];
        $segment_two_departure=[];
        $segment_two_country_Departure=[];
        $segment_two_country_Arrival=[];
        $segment_two_arrival=[];
        $segment_two_Duration=[];
        $segment_two_terminal_arrival=[];
        $segment_two_terminal_departure=[];
        $jcount=1;
        foreach ($unidata[1]['journey'] as $key => $value) {
            // return $value;
            // return $value['Carrier'];
            if ($jcount>$round_push) {
                array_push($segment_two_flight,$value['Carrier']);
                array_push($segment_two_from,$value['Origin']);
                array_push($segment_two_to,$value['Destination']);
                array_push($segment_two_carrier,7);  // baggage
                array_push($segment_two_class,$value['CabinClass']);
                array_push($segment_two_Flight_No,$value['FlightNumber']);
                array_push($segment_two_departure,$value['DepartureTime']);
                array_push($segment_two_country_Departure,'');  //country name
                array_push($segment_two_country_Arrival,'');//country name
                array_push($segment_two_arrival,$value['ArrivalTime']);
                array_push($segment_two_Duration, \Carbon\Carbon::parse($value['DepartureTime'])->diff(\Carbon\Carbon::parse($value['ArrivalTime']))->format('%Hh %Im'));  //duration 
                array_push($segment_two_terminal_arrival,isset($value['OriginTerminal'])?$value['OriginTerminal']:'');
                array_push($segment_two_terminal_departure,isset($value['DestinationTerminal'])?$value['DestinationTerminal']:'');
            }else{
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
            $jcount++;
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
        $country_code=$request->country_code;
        if($country_code==''){
            $country_code='GB'; 
        }
        $currency_code=DB::table('countries')->where('country_code',$country_code)->value('currency_code');
        $currency=DB::table('countries')->where('country_code',$country_code)->value('currency_symbal');

        $segment_one_fare_cost=[];
        $segment_one_fare_sell=[];
        foreach ($unidata[2]['price'] as $key => $value) {
            array_push($segment_one_fare_cost,str_replace($currency_code,'',$value['TotalPrice']));
            array_push($segment_one_fare_sell,str_replace($currency_code,'',$value['TotalPrice']));
        }

        $service_name=["Flight"];
        $journey_type=["RETURN"];
        $universal_pnr=[$universal_pnr];
        $pnr=[null];
        $agency_pcc=[null];
        $booking_date=[date('Y-m-d')];
        $airline_ref=[null];

        $jsondata['service_name']=$service_name;
        $jsondata['journey_type']=$journey_type;
        $jsondata['journey_stop']=$journey_stop;
        $jsondata['universal_pnr']=$universal_pnr;
        $jsondata['pnr']=$pnr;
        $jsondata['agency_pcc']=$agency_pcc;
        $jsondata['booking_date']=$booking_date;
        $jsondata['airline_ref']=$airline_ref;
        $jsondata['segment_one_flight']=$segment_one_flight;  
        $jsondata['segment_one_from']=$segment_one_from;
        $jsondata['segment_one_to']=$segment_one_to;
        $jsondata['segment_one_carrier']=$segment_one_carrier;
        $jsondata['segment_one_class']=$segment_one_class;
        $jsondata['segment_one_Flight_No']=$segment_one_Flight_No;
        $jsondata['segment_one_departure']=$segment_one_departure;
        $jsondata['segment_one_country_Departure']=$segment_one_country_Departure;
        $jsondata['segment_one_country_Arrival']=$segment_one_country_Arrival;
        $jsondata['segment_one_arrival']=$segment_one_arrival;
        $jsondata['segment_one_Duration']=$segment_one_Duration;
        $jsondata['segment_one_terminal_arrival']=$segment_one_terminal_arrival;
        $jsondata['segment_one_terminal_departure']=$segment_one_terminal_departure;

        $jsondata['segment_two_flight']=$segment_two_flight;  
        $jsondata['segment_two_from']=$segment_two_from;
        $jsondata['segment_two_to']=$segment_two_to;
        $jsondata['segment_two_carrier']=$segment_two_carrier;
        $jsondata['segment_two_class']=$segment_two_class;
        $jsondata['segment_two_Flight_No']=$segment_two_Flight_No;
        $jsondata['segment_two_departure']=$segment_two_departure;
        $jsondata['segment_two_country_Departure']=$segment_two_country_Departure;
        $jsondata['segment_two_country_Arrival']=$segment_two_country_Arrival;
        $jsondata['segment_two_arrival']=$segment_two_arrival;
        $jsondata['segment_two_Duration']=$segment_two_Duration;
        $jsondata['segment_two_terminal_arrival']=$segment_two_terminal_arrival;
        $jsondata['segment_two_terminal_departure']=$segment_two_terminal_departure;
        


        $jsondata['verify']=$verify;
        $jsondata['pax_type']=$pax_type;
        $jsondata['first_name']=$first_name;
        $jsondata['last_name']=$last_name;
        $jsondata['DOB']=$DOB;
        $jsondata['segment_one_fare_cost']=$segment_one_fare_cost;
        $jsondata['segment_one_fare_sell']=$segment_one_fare_sell;
        // $data=[];
        return $jsondata;
        // return $unidata;

        // "receiver_name": "304",
        return $unidata[0]['personal_details'];

        foreach($unidata[0]['personal_details'] as $key =>$data){
            echo  $data['TravelerType'];
            // return $unidata[2]['price'][0]['TotalPrice'];
        }
        



        

}

public function Testold(Request $request)
{
    // return "hii";
    // 16QO87  via
    // 16QMOE    single
    // 16UOD0 via round
    $xml_data='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
            <univ:UniversalRecordRetrieveReq TargetBranch="P7141733" TraceId="trace" xmlns:univ="http://www.travelport.com/schema/universal_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
                <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
                <univ:UniversalRecordLocatorCode>16UOD0</univ:UniversalRecordLocatorCode>
            </univ:UniversalRecordRetrieveReq>
        </soapenv:Body>
        </soapenv:Envelope>';
        $api_url='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService';
        $return2 =app('App\Http\Controllers\UtilityController')->universal_API($xml_data,$api_url);
        // return $return2;
        $object2 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return2);
        // return $object2;
        $unidata =app('App\Http\Controllers\XMlToParseDataController')->UniversalRecord($object2);
        // return $unidata;
        // return $unidata[3]['UniversalRecord']['LocatorCode'];


        if (count($unidata[1]['journey'])>1) {
            $journey_stop=["1"];
        }else{
            $journey_stop=["0"];
        }
        $universal_pnr=$unidata[3]['UniversalRecord']['LocatorCode'];

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

        return $unidata[1]['journey'];
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
        $country_code=$request->country_code;
        if($country_code==''){
            $country_code='GB'; 
        }
        $currency_code=DB::table('countries')->where('country_code',$country_code)->value('currency_code');
        $currency=DB::table('countries')->where('country_code',$country_code)->value('currency_symbal');

        $segment_one_fare_cost=[];
        $segment_one_fare_sell=[];
        foreach ($unidata[2]['price'] as $key => $value) {
            array_push($segment_one_fare_cost,str_replace($currency_code,'',$value['TotalPrice']));
            array_push($segment_one_fare_sell,str_replace($currency_code,'',$value['TotalPrice']));
        }

        $service_name=["Flight"];
        $journey_type=["ONE WAY"];
        $universal_pnr=[$universal_pnr];
        $pnr=[null];
        $agency_pcc=[null];
        $booking_date=[date('Y-m-d')];
        $airline_ref=[null];

        $jsondata['service_name']=$service_name;
        $jsondata['journey_type']=$journey_type;
        $jsondata['journey_stop']=$journey_stop;
        $jsondata['universal_pnr']=$universal_pnr;
        $jsondata['pnr']=$pnr;
        $jsondata['agency_pcc']=$agency_pcc;
        $jsondata['booking_date']=$booking_date;
        $jsondata['airline_ref']=$airline_ref;
        $jsondata['segment_one_flight']=$segment_one_flight;  
        $jsondata['segment_one_from']=$segment_one_from;
        $jsondata['segment_one_to']=$segment_one_to;
        $jsondata['segment_one_carrier']=$segment_one_carrier;
        $jsondata['segment_one_class']=$segment_one_class;
        $jsondata['segment_one_Flight_No']=$segment_one_Flight_No;
        $jsondata['segment_one_departure']=$segment_one_departure;
        $jsondata['segment_one_country_Departure']=$segment_one_country_Departure;
        $jsondata['segment_one_country_Arrival']=$segment_one_country_Arrival;
        $jsondata['segment_one_arrival']=$segment_one_arrival;
        $jsondata['segment_one_Duration']=$segment_one_Duration;
        $jsondata['segment_one_terminal_arrival']=$segment_one_terminal_arrival;
        $jsondata['segment_one_terminal_departure']=$segment_one_terminal_departure;

       


        $jsondata['verify']=$verify;
        $jsondata['pax_type']=$pax_type;
        $jsondata['first_name']=$first_name;
        $jsondata['last_name']=$last_name;
        $jsondata['DOB']=$DOB;
        $jsondata['segment_one_fare_cost']=$segment_one_fare_cost;
        $jsondata['segment_one_fare_sell']=$segment_one_fare_sell;
        // $data=[];
        // return $jsondata;
        // return $unidata;

        // "receiver_name": "304",
        return $unidata[0]['personal_details'];

        foreach($unidata[0]['personal_details'] as $key =>$data){
            echo  $data['TravelerType'];
            // return $unidata[2]['price'][0]['TotalPrice'];
        }
        



        

}

public function Test1()
{
    $jsondata=[];
    // $data=collect();
    // $journey=collect();
    // $data->push($details1);    
    $universal_pnr='U';


    $service_name=["Flight"];
    $journey_type=["one way"];
    $journey_stop=["1"];

    $universal_pnr=[$universal_pnr];
	$pnr=[null];
	$agency_pcc=[null];
    $booking_date=[date('Y-m-d')];
    $airline_ref=[null];

    $jsondata['service_name']=$service_name;
    $jsondata['journey_type']=$journey_type;
    $jsondata['journey_stop']=$journey_stop;
    $jsondata['universal_pnr']=$universal_pnr;
    $jsondata['pnr']=$pnr;
    $jsondata['agency_pcc']=$agency_pcc;
    $jsondata['booking_date']=$booking_date;
    $jsondata['airline_ref']=$airline_ref;
    // $data=[];
    return $jsondata;
}
   
public function Test12(){
    $TARGETBRANCH = 'P7141733';
    $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
$Provider = '1G';//1G/1V/1P/ACH
$PreferredDate = date('Y-m-d', strtotime("+2 day"));
$returnDate= date('Y-m-d', strtotime("+3 day"));
$returnDate1= date('Y-m-d', strtotime("+5 day"));
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
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="DEL"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="PNQ"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="$returnDate">
            </air:SearchDepTime>            
         </air:SearchAirLeg>
         <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="PNQ"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="MAA"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="$returnDate1">
            </air:SearchDepTime>            
         </air:SearchAirLeg>
         <air:AirSearchModifiers>
            <air:PreferredProviders>
               <com:Provider Code="$Provider"/>
            </air:PreferredProviders>
         </air:AirSearchModifiers>
		  <com:SearchPassenger BookingTravelerRef="1" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
      <air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="USD">
      <air:AccountCodes>
        <com:AccountCode xmlns="http://www.travelport.com/schema/common_v42_0" Code="-" />
      </air:AccountCodes>
      </air:AirPricingModifiers>
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
// return $content;
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
                $Journey= collect();
                $Journey_Outbound_Inbound= collect();
                $var_toggle_journey_conunt=0;
				foreach($airPriceSol->children('air',true) as $journey){					
					if(strcmp($journey->getName(),'Journey') == 0){
                        $var_toggle_journey_conunt+=1;
						file_put_contents($fileName,"\r\nJourney Details: ", FILE_APPEND);
						file_put_contents($fileName,"\r\n", FILE_APPEND);
						file_put_contents($fileName,"--------------------------------------\r\n", FILE_APPEND);						
                        $journeydetails = collect();
                        foreach($journey->children('air', true) as $segmentRef){	
                           						
							if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){								
                                $details=[];
                                foreach($segmentRef->attributes() as $a => $b){	
                                   
									$segment = $this->ListAirSegments($b, $lowFare);
									foreach($segment->attributes() as $c => $d){
                                        if(strcmp($c, "Origin") == 0){
                                            // $journeydetails->push(['From'=>$d]);
                                            $details["From"]=$d;
											file_put_contents($fileName,"From ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "Destination") == 0){
                                            // $journeydetails->push(['To'=>$d]);
                                            $details["To"]=$d;
											file_put_contents($fileName,"To ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "Carrier") == 0){		
                                            // $journeydetails->push(['Airline'=>$d]);	
                                            $details["Airline"]=$d;								
											file_put_contents($fileName,"Airline: ".$d."\r\n", FILE_APPEND);	
										}
										if(strcmp($c, "FlightNumber") == 0){	
                                            // $journeydetails->push(['flight'=>$d]);
                                            $details["Flight"]=$d;
											file_put_contents($fileName,"Flight ".$d."\r\n", FILE_APPEND);
										}
										if(strcmp($c, "DepartureTime") == 0){	
                                            // $journeydetails->push(['Depart'=>$d]);	
                                            $details["Depart"]=$d;										
											file_put_contents($fileName,"Depart ".$d."\r\n", FILE_APPEND);	
										}
										if(strcmp($c, "ArrivalTime") == 0){	
                                            // $journeydetails->push(['Arrive'=>$d]);
                                            $details["Arrive"]=$d;
											file_put_contents($fileName,"Arrive ".$d."\r\n", FILE_APPEND);	
										
                                        }	
                                       
									}
                                    
								}
                                $journeydetails->push($details);
                                
									
							}
						}	
										
						
                        if($var_toggle_journey_conunt==1)
                        {
                            $Journey_Outbound_Inbound->push(['outbound'=>collect($journeydetails)]);	
                        }
                        else if($var_toggle_journey_conunt==2)
                        {
                            $Journey_Outbound_Inbound->push(['inbound'=>collect($journeydetails)]);	
                        }
                        else if($var_toggle_journey_conunt==3)
                        {
                            $Journey_Outbound_Inbound->push(['inbound1'=>collect($journeydetails)]);	
                        }	
                       			
					}					
				}
                $Journey->push(['journey'=>collect($Journey_Outbound_Inbound)]);
               // Price Details
                foreach($airPriceSol->children('air',true) as $priceInfo){
                    $flightPrice = [];
                    if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0){
                        foreach($priceInfo->attributes() as $e => $f){
                            if(strcmp($e, "ApproximateBasePrice") == 0){
                                // $flightPrice->push('Approx. Base Price: '.$f);
                                $flightPrice['Approx Base Price'] = $f;
                                // array_push($flightPrice, 'Approx. Base Price: '.$f);
                            }
                            if(strcmp($e, "ApproximateTaxes") == 0){
                                // $flightPrice->push('Approx Taxes: '.$f);
                                $flightPrice['Approx Taxes'] = $f;
                                // array_push($flightPrice, 'Approx. Taxes: '.$f);
                            }
                            if(strcmp($e, "ApproximateTotalPrice") == 0){
                                // $flightPrice->push('Approx Total Value: '.$f);
                                $flightPrice['Approx Total Value'] = $f;
                                // array_push($flightPrice, 'Approx. Total Price: '.$f);
                            }
                            if(strcmp($e, "BasePrice") == 0){
                                // $flightPrice->push('Base Price'.$f);
                                $flightPrice['Base Price'] = $f;
                                // array_push($flightPrice, 'Base Price: '.$f);
                            }
                            if(strcmp($e, "Taxes") == 0){
                                // $flightPrice->push('Taxes '.$f);
                                $flightPrice['Taxes'] = $f;
                                // array_push($flightPrice, 'Taxes: '.$f);
                            }
                            if(strcmp($e, "TotalPrice") == 0){
                                // $flightPrice->push('Total Price '.$f);
                                $flightPrice['Total Price'] = $f;
                                // array_push($flightPrice, 'Total Price: '.$f);
                            }

                        }
                        foreach($priceInfo->children('air',true) as $bookingInfo){
                            if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
                                foreach($bookingInfo->attributes() as $e => $f){
                                    if(strcmp($e, "CabinClass") == 0){
                                        // $flightPrice->push('Cabin Class'.$f);
                                        // $flightPrice[$e] = $f;
                                        $flightPrice['Cabin Class'] = $f;
                                        // array_push($flightPrice, 'Cabin Class'.$f);
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
                file_put_contents($fileName,"\r\n", FILE_APPEND);
 
            
            
            }

			
		}
	}
	
	// print_r($data) ;
    // echo $data;
    return $data;
	// echo "\r\n"."Processing Done. Please check results in files.";

}

    

    public function ShowJson1(){
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        $query = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
           <univ:UniversalRecordRetrieveReq TargetBranch="'.$TARGETBRANCH.'" TraceId="trace" xmlns:univ="http://www.travelport.com/schema/universal_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
              <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <univ:UniversalRecordLocatorCode>13UIBZ</univ:UniversalRecordLocatorCode>
           </univ:UniversalRecordRetrieveReq>
        </soapenv:Body>
     </soapenv:Envelope>';
    // return $query; 13WX71 13WUOT
            $message = <<<EOM
$query
EOM;
        $auth = base64_encode($CREDENTIALS);
        $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService");
        // $soap_do = curl_init("https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService");
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
        $return2 = curl_exec($soap_do);
        curl_close($soap_do);
        // return $return2;
    
        $dom2 = new \DOMDocument();
        $dom2->loadXML($return2);
        $json2 = new \FluentDOM\Serializer\Json\RabbitFish($dom2);
        $object2 = json_decode($json2,true);
        return $object2;
    
    }

}
