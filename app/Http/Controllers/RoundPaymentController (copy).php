<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoundPaymentController extends Controller
{
    public function PaymentCredit(Request $request){
        // return $request;
        $flight=json_decode($request->return_flight, true);
        return $flight;
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
                $booking_info.='<air:BookingInfo BookingCode="'.$BookingInfo[$i]['BookingCode'].'" CabinClass="'.$BookingInfo[$i]['CabinClass'].'" FareInfoRef="'.$BookingInfo[$i]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[$i]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[$i]['HostTokenRef'].'"/>';
            }
        }
        // return $booking_info;
        $Fare_Info_FareRuleKey='';
        foreach($flight[4] as $FareInfo){
            // print_r($FareInfo);
            for ($i=0; $i < count($FareInfo); $i++) { 
                // echo $FareInfo[$i]['Key'];
                // echo "<br/>";
                // echo $FareInfo[$i]['Origin'];
                // echo "<br/>";
                foreach($flight[5] as $FareRuleKey){
                    if($FareInfo[$i]['Key']==$FareRuleKey[$i]['FareInfoRef']){
                        $Fare_Info_FareRuleKey.='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[$i]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[$i]['DepartureDate'].'" Amount="'.$FareInfo[$i]['Amount'].'" EffectiveDate="'.$FareInfo[$i]['EffectiveDate'].'" Destination="'.$FareInfo[$i]['Destination'].'" Origin="'.$FareInfo[$i]['Origin'].'" PassengerTypeCode="'.$FareInfo[$i]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[$i]['FareBasis'].'">
                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[$i]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[$i]['ProviderCode'].'">'.$FareRuleKey[$i]['FareRuleKeyValue'].'</air:FareRuleKey>
                        </air:FareInfo>';
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
        $data=[];
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
                                                // if($count2==9){}
                                                if($count2==9){
                                                    // print_r($json6);
                                                    // echo "<br/><br/>";
                                                    $AirPricingInfo=[];
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


                                                        }
                                                    }
                                                    $data['AirPricingInfo']=$AirPricingInfo;
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
        // return $data['AirPricingInfo']['Key'];
        // echo $data['UniversalRecord']." <br/>";

        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <air:AirTicketingReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" TraceId="trace" xmlns:air="http://www.travelport.com/schema/air_v42_0">
            <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
            <air:AirReservationLocatorCode>'.$data['AirReservation'].'</air:AirReservationLocatorCode>
            <air:AirPricingInfoRef Key="'.$data['AirPricingInfo']['Key'].'" />
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
        // return $alldetails;
        // Universal record
        $query = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Body>
           <univ:UniversalRecordRetrieveReq TargetBranch="'.$TARGETBRANCH.'" TraceId="trace" xmlns:univ="http://www.travelport.com/schema/universal_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
              <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
              <univ:UniversalRecordLocatorCode>'.$data['UniversalRecord'].'</univ:UniversalRecordLocatorCode>
           </univ:UniversalRecordRetrieveReq>
        </soapenv:Body>
     </soapenv:Envelope>';
    // return $query; 
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
        // return $object2;

        // array_key_exists($index, $array);
        // universal:UniversalRecordRetrieveRsp
        $unidata=collect();
        foreach($object2 as $unvjson){
            foreach($unvjson as $unvjson1){
                // print_r($unvjson1);
                // echo "<br/><br/><br/>";
                if(count($unvjson1)>1){
                    if(array_key_exists('SOAP:Fault',$unvjson1)){
                        echo "error";
                        // echo "<br/><br/><br/>";
                    }else{
                        // print_r ($unvjson1['common_v42_0:BookingTravelerName']);
                        // echo "<br/><br/><br/>";
                        // echo "hhh";
                        foreach($unvjson1 as $unvjson2){
                            if(count($unvjson2)>1){
                                $count=1;
                                foreach($unvjson2 as $unvjson3){
                                    // echo $count;
                                    // print_r ($unvjson3);
                                    // echo "<br/><br/><br/>";
                                    if($count==5){
                                        $count1=1;
                                        foreach($unvjson3 as $key => $unvjson4){
                                            // echo $count1;
                                            // print_r ($unvjson4);
                                            // echo "<br/><br/><br/>";
                                            if(is_string($unvjson4)){
                                                // print_r ($key." - ".$unvjson4);
                                                // echo "<br/><br/><br/>";
                                            }
                                            if($count1==5){
                                                // print_r ($unvjson4);
                                                // echo "<br/><br/><br/>";
                                                $per_details=[];
                                                $count2=1;
                                                foreach($unvjson4 as $key =>$unvjson5){
                                                    // echo $count2;
                                                    // print_r ($unvjson5);
                                                    // echo "<br/><br/><br/>";
                                                    if(is_string($unvjson5)){
                                                        // print_r ($key." - ".$unvjson5);
                                                        // echo "<br/><br/><br/>";
                                                        if(strcmp($key, "@Key") == 0){
                                                            $per_details['Key']=$unvjson5;
                                                        }
                                                        if(strcmp($key, "@TravelerType") == 0){
                                                            $per_details['TravelerType']=$unvjson5;
                                                        }
                                                        if(strcmp($key, "@Gender") == 0){
                                                            $per_details['Gender']=$unvjson5;
                                                        }
                                                    }
                                                    // if($count2==7){}
                                                    if($count2==6){
                                                        foreach($unvjson5 as $key => $unvjson6){
                                                            // print_r ($unvjson6);
                                                            // echo "<br/><br/><br/>";
                                                            if(is_string($unvjson6)){
                                                                // print_r($key." - ".$unvjson6);
                                                                if(strcmp($key, "@Prefix") == 0){
                                                                    $per_details['Prefix']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@First") == 0){
                                                                    $per_details['First']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@Last") == 0){
                                                                    $per_details['Last']=$unvjson6;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if($count2==7){
                                                        foreach($unvjson5 as $key => $unvjson6){
                                                            // print_r ($unvjson6);
                                                            // echo "<br/><br/><br/>";
                                                            if(is_string($unvjson6)){
                                                                // print_r($key." - ".$unvjson6);
                                                                // echo "<br/><br/><br/>";
                                                                if(strcmp($key, "@Key") == 0){
                                                                    $per_details['Key']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@Type") == 0){
                                                                    $per_details['Type']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@Number") == 0){
                                                                    $per_details['Number']=$unvjson6;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if($count2==8){
                                                        foreach($unvjson5 as $key => $unvjson6){
                                                            // print_r ($unvjson6);
                                                            // echo "<br/><br/><br/>";
                                                            if(is_string($unvjson6)){
                                                                // print_r($key." - ".$unvjson6);
                                                                // echo "<br/><br/><br/>";
                                                                if(strcmp($key, "@Key") == 0){
                                                                    $per_details['Key']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@Type") == 0){
                                                                    $per_details['Type']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@EmailID") == 0){
                                                                    $per_details['EmailID']=$unvjson6;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if($count2==10){
                                                        $count3=1;
                                                        foreach($unvjson5 as $unvjson6){
                                                            // echo $count3;
                                                            // print_r ($unvjson6);
                                                            // echo "<br/><br/><br/>";
                                                            if($count3==3){
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($unvjson7)){
                                                                        // print_r($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "$") == 0){
                                                                            $per_details['Address']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            if($count3==4){
                                                                $count4=1;
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if($count4==1){
                                                                        // print_r ($unvjson7);
                                                                        // echo "<br/><br/><br/>"; 
                                                                        foreach($unvjson7 as $key => $unvjson8){
                                                                            // print_r($key." - ".$unvjson7);
                                                                            // echo "<br/><br/><br/>";
                                                                            if(is_string($unvjson8)){
                                                                                if(strcmp($key, "$") == 0){
                                                                                    $per_details['street']=$unvjson8;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    if($count4==2){
                                                                        // print_r ($unvjson7);
                                                                        // echo "<br/><br/><br/>"; 
                                                                        foreach($unvjson7 as $key => $unvjson8){
                                                                            // print_r($key." - ".$unvjson7);
                                                                            // echo "<br/><br/><br/>";
                                                                            if(is_string($unvjson8)){
                                                                                if(strcmp($key, "$") == 0){
                                                                                    $per_details['street1']=$unvjson8;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    $count4++;
                                                                }
                                                                
                                                            }
                                                            if($count3==5){
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($unvjson7)){
                                                                        // print_r($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "$") == 0){
                                                                            $per_details['City']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            if($count3==6){
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($unvjson7)){
                                                                        // print_r($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "$") == 0){
                                                                            $per_details['State']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            if($count3==7){
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($unvjson7)){
                                                                        // print_r($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "$") == 0){
                                                                            $per_details['PostalCode']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            if($count3==8){
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($unvjson7)){
                                                                        // print_r($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "$") == 0){
                                                                            $per_details['Country']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            if($count3==9){
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>"; 
                                                                    if(is_string($unvjson7)){
                                                                        // print_r($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "$") == 0){
                                                                            $per_details['Key']=$unvjson6;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                            }
                                                            $count3++;
                                                        }
                                                    }
                                                    $count2++;
                                                }
                                            }
                                            if ($count1==7) {}
                                            if ($count1==8) {
                                                // print_r ($unvjson4);
                                                // echo "<br/><br/><br/>";
                                                $count10=1;
                                                foreach($unvjson4 as $unvjson5){
                                                    // echo $count10;
                                                    // print_r ($unvjson5);
                                                    // echo "<br/><br/><br/>";
                                                    if($count10==8){
                                                        // print_r ($unvjson5);
                                                        // echo "<br/><br/><br/>";
                                                        $journey1=collect();
                                                        $outbound_journey1=collect();
                                                        $inbound_journey1=collect();
                                                        $roundcount=1;
                                                        foreach($unvjson5 as $key => $unvjson55){
                                                            // echo count($unvjson55);
                                                            // print_r (count($unvjson55));
                                                            // print_r ($unvjson55);
                                                            // echo "<br/><br/><br/>";
                                                            $count12=1;
                                                            $journey=[];
                                                            foreach($unvjson55 as $key => $unvjson6){
                                                                // print_r ($unvjson6);
                                                                // echo "<br/><br/><br/>";
                                                                if(is_string($unvjson6)){
                                                                    // print_r ($key." - ".$unvjson6);
                                                                    // echo "<br/><br/><br/>";
                                                                    if(strcmp($key, "Key") == 0){
                                                                        $journey["Key"]=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "Group") == 0){
                                                                        $journey["Group"]=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@Carrier") == 0){
                                                                        $journey['Carrier']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@CabinClass") == 0){
                                                                        $journey['CabinClass']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@FlightNumber") == 0){
                                                                        $journey['FlightNumber']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@Origin") == 0){
                                                                        $journey['Origin']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@Destination") == 0){
                                                                        $journey['Destination']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@DepartureTime") == 0){
                                                                        $journey['DepartureTime']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@ArrivalTime") == 0){
                                                                        $journey['ArrivalTime']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@TravelTime") == 0){
                                                                        $journey['TravelTime']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@Distance") == 0){
                                                                        $journey['Distance']=$unvjson6;
                                                                    }
                                                                    if(strcmp($key, "@ChangeOfPlane") == 0){
                                                                        $journey['ChangeOfPlane']=$unvjson6;
                                                                    }
                                                                }
                                                                if($count12==26){
                                                                // print_r ($unvjson6);
                                                                // echo "<br/><br/><br/>";
                                                                foreach($unvjson6 as $key => $unvjson7){
                                                                    // print_r ($unvjson7);
                                                                    // echo "<br/><br/><br/>";
                                                                    if(is_string($unvjson7)){
                                                                        // print_r ($key." - ".$unvjson7);
                                                                        // echo "<br/><br/><br/>";
                                                                        if(strcmp($key, "@OriginTerminal") == 0){
                                                                            $journey['OriginTerminal']=$unvjson7;
                                                                        }
                                                                        if(strcmp($key, "@DestinationTerminal") == 0){
                                                                            $journey['DestinationTerminal']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                                }
                                                                $count12++;
                                                            }
                                                            if($roundcount==1){
                                                                $outbound_journey1->push($journey);
                                                            }
                                                            if($roundcount==2){
                                                                $inbound_journey1->push($journey);
                                                            }
                                                            $roundcount++;
                                                        }
                                                        $journey1->push(['outbound_journey'=>collect($outbound_journey1)]);
                                                        $journey1->push(['inbound_journey'=>collect($inbound_journey1)]);
                                                        // $journey1->push($outbound_journey1);
                                                        // $journey1->push($inbound_journey1);

                                                    }
                                                    if($count10==9){
                                                        // print_r ($unvjson5);
                                                        // echo "<br/><br/><br/>";
                                                        $price=[];
                                                        $count11=1;
                                                        foreach($unvjson5 as $key => $unvjson6){
                                                            // echo $count11;
                                                            // print_r ($unvjson6);
                                                            // echo "<br/><br/><br/>";
                                                            if(is_string($unvjson6)){
                                                                // print_r ($key." - ".$unvjson6);
                                                                // echo "<br/><br/><br/>";
                                                                if(strcmp($key, "@Key") == 0){
                                                                    $price['Key']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@TotalPrice") == 0){
                                                                    $price['TotalPrice']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@BasePrice") == 0){
                                                                    $price['BasePrice']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@ApproximateTotalPrice") == 0){
                                                                    $price['ApproximateTotalPrice']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@ApproximateBasePrice") == 0){
                                                                    $price['ApproximateBasePrice']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@EquivalentBasePrice") == 0){
                                                                    $price['EquivalentBasePrice']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@Taxes") == 0){
                                                                    $price['Taxes']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@LatestTicketingTime") == 0){
                                                                    $price['LatestTicketingTime']=$unvjson6;
                                                                }
                                                                if(strcmp($key, "@TrueLastDateToTicket") == 0){
                                                                    $price['TrueLastDateToTicket']=$unvjson6;
                                                                }
                                                            }
                                                            if ($count11==22) {
                                                                foreach($unvjson6 as $key =>$unvjson7){
                                                                    if(is_string($unvjson7)){
                                                                        if(strcmp($key, "@BookingCode") == 0){
                                                                            $price['BookingCode']=$unvjson7;
                                                                        }
                                                                        if(strcmp($key, "@CabinClass") == 0){
                                                                            $price['CabinClass']=$unvjson7;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            $count11++; 
                                                        }
                                                    }
                                                    $count10++;
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
                    // unvjson7
                    $unidata->push(['personal_details'=>collect($per_details)]);
                    $unidata->push(['journey'=>collect($journey1)]);
                    $unidata->push(['price'=>collect($price)]);
                }
            }
        }

        // return $data;
        // return $request;
        return view('flights.confirm-booking',[
            'return_searched'=>$request,
            'return_airreservation'=>$data,
            'return_airticketing'=>$alldetails,
            'return_unidata'=>$unidata
        ]);

    }
}
