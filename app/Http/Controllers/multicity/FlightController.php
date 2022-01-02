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

class FlightController extends Controller
{
    public function search(Request $request){
        // return $request;
        $return_flights=[];
        $return_stops=[];
        $return_airlines=[];
        $flights=[];
        $stops=[];
        $airlines=[];
        $multicityCount=3;
        if(isset(explode('(',$request->from1)[1])){
            $var_from1 =  str_replace(')','',explode('(',$request->from1)[1]);
        }else{
            return redirect()->route('errorPage')->with('searcherror','searcherror');
        }

        if(isset(explode('(',$request->to1)[1])){
            $var_to1 =  str_replace(')','',explode('(',$request->to1)[1]);
        }else{
            return redirect()->route('errorPage')->with('searcherror','searcherror');
        }

        // $var_from2 =  str_replace(')','',explode('(',$request->from2)[1]);
        // $var_to2 =  str_replace(')','',explode('(',$request->to2)[1]);
       

        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;

        // return $request;
        $var_country_code=$request->country_code;
        $var_currency_code=DB::table('countries')->where('country_code',$var_country_code)->value('currency_code');
        // return $var_currency_code;
        $currency_xml='';
        if($var_currency_code!=''){
            $currency_xml='<air:AirPricingModifiers FaresIndicator="PublicFaresOnly" CurrencyType="'.$var_currency_code.'">
            <air:AccountCodes>
                <com:AccountCode xmlns="http://www.travelport.com/schema/common_v42_0" Code="-" />
            </air:AccountCodes>
            </air:AirPricingModifiers>';
        }
        

        $var_flight0_date = Carbon::parse($request->flight0_date)->format('Y-m-d');
        // $var_flight1_date = Carbon::parse($request->flight1_date)->format('Y-m-d');

        $travel_details='';
        for ($i=1; $i <= $var_adults; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="ADT'.$i.'" Code="ADT" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=1; $i <= $var_children; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="CNN'.$i.'" Code="CNN" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }
        for ($i=1; $i <= $var_infant; $i++) { 
            $travel_details.='<com:SearchPassenger BookingTravelerRef="INF'.$i.'" Code="INF" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>';
        }


        $searchLegModifier = '<air:AirLegModifiers>
                    <air:PreferredCabins>
                <com:CabinClass xmlns="http://www.travelport.com/schema/common_v42_0" Type="'.$request->travel_class.'"></com:CabinClass>
            </air:PreferredCabins>
        </air:AirLegModifiers>';
        $datasegment='';
        $datasegment.='<air:SearchAirLeg>
        <air:SearchOrigin>
           <com:Airport Code="'.$var_from1.'"/>
        </air:SearchOrigin>
        <air:SearchDestination>
           <com:Airport Code="'.$var_to1.'"/>
        </air:SearchDestination>
        <air:SearchDepTime PreferredTime="'.$var_flight0_date.'">
        </air:SearchDepTime>    
        '.$searchLegModifier.'        
     </air:SearchAirLeg>';
        // return $datasegment;
        if($request->from2!='' && $request->to2!='' && $request->flight1_date!=''){
            if(isset(explode('(',$request->from2)[1])){
                $var_from2 =  str_replace(')','',explode('(',$request->from2)[1]);
            }else{
                return redirect()->route('errorPage')->with('searcherror','searcherror');
            }
            if(isset(explode('(',$request->to2)[1])){
                $var_to2 =  str_replace(')','',explode('(',$request->to2)[1]);
            }else{
                return redirect()->route('errorPage')->with('searcherror','searcherror');
            }
            $var_flight1_date = Carbon::parse($request->flight1_date)->format('Y-m-d');
            $datasegment.=' <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="'.$var_from2.'"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="'.$var_to2.'"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="'.$var_flight1_date.'">
            </air:SearchDepTime>  
            '.$searchLegModifier.'          
         </air:SearchAirLeg>';
        }
        if($request->from3!='' && $request->to3!='' && $request->flight2_date!=''){
            if(isset(explode('(',$request->from3)[1])){
                $var_from3 =  str_replace(')','',explode('(',$request->from3)[1]);
            }else{
                return redirect()->route('errorPage')->with('searcherror','searcherror');
            }
            if (isset(explode('(',$request->to3)[1])) {
                $var_to3 =  str_replace(')','',explode('(',$request->to3)[1]);
            }else{
                return redirect()->route('errorPage')->with('searcherror','searcherror');
            }
            $var_flight2_date = Carbon::parse($request->flight2_date)->format('Y-m-d');
            $datasegment.=' <air:SearchAirLeg>
            <air:SearchOrigin>
               <com:Airport Code="'.$var_from3.'"/>
            </air:SearchOrigin>
            <air:SearchDestination>
               <com:Airport Code="'.$var_to3.'"/>
            </air:SearchDestination>
            <air:SearchDepTime PreferredTime="'.$var_flight2_date.'">
            </air:SearchDepTime>  
            '.$searchLegModifier.'          
         </air:SearchAirLeg>';
        }
        if($request->from4!='' && $request->to4!='' && $request->flight3_date!=''){
            $var_from4 =  str_replace(')','',explode('(',$request->from4)[1]);
            $var_to4 =  str_replace(')','',explode('(',$request->to4)[1]);
            $var_flight3_date = Carbon::parse($request->flight3_date)->format('Y-m-d');
            $datasegment.=' <air:SearchAirLeg>
                <air:SearchOrigin>
                <com:Airport Code="'.$var_from4.'"/>
                </air:SearchOrigin>
                <air:SearchDestination>
                <com:Airport Code="'.$var_to4.'"/>
                </air:SearchDestination>
                <air:SearchDepTime PreferredTime="'.$var_flight3_date.'">
                </air:SearchDepTime>  
                '.$searchLegModifier.'          
            </air:SearchAirLeg>';
        }

        if($request->from5!='' && $request->to5!='' && $request->flight4_date!=''){
            $var_from5 =  str_replace(')','',explode('(',$request->from5)[1]);
            $var_to5 =  str_replace(')','',explode('(',$request->to5)[1]);
            $var_flight4_date = Carbon::parse($request->flight4_date)->format('Y-m-d');
            $datasegment.=' <air:SearchAirLeg>
                <air:SearchOrigin>
                <com:Airport Code="'.$var_from5.'"/>
                </air:SearchOrigin>
                <air:SearchDestination>
                <com:Airport Code="'.$var_to5.'"/>
                </air:SearchDestination>
                <air:SearchDepTime PreferredTime="'.$var_flight4_date.'">
                </air:SearchDepTime>  
                '.$searchLegModifier.'          
            </air:SearchAirLeg>';
        }

        if($request->from6!='' && $request->to6!='' && $request->flight5_date!=''){
            $var_from6 =  str_replace(')','',explode('(',$request->from6)[1]);
            $var_to6 =  str_replace(')','',explode('(',$request->to6)[1]);
            $var_flight5_date = Carbon::parse($request->flight5_date)->format('Y-m-d');
            $datasegment.=' <air:SearchAirLeg>
                <air:SearchOrigin>
                <com:Airport Code="'.$var_from6.'"/>
                </air:SearchOrigin>
                <air:SearchDestination>
                <com:Airport Code="'.$var_to6.'"/>
                </air:SearchDestination>
                <air:SearchDepTime PreferredTime="'.$var_flight5_date.'">
                </air:SearchDepTime>   
                '.$searchLegModifier.'         
            </air:SearchAirLeg>';
        }

        // return $multicityCount;
        // return $datasegment;

        $var_direct_flight='';
        $var_flexi='';
        // flight 1
        // $travel_class=$request->travel_class;
        // $flightFrom=$var_from1;
        // $flightTo=$var_to1;
        // $SearchDate=$var_flight0_date;
        // $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$SearchDate);
        // $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
        // $return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
        // $content = $this->prettyPrint($return);
        // $flights = ($this->parseOutput($content));
        // $stops=$this->Stops($flights,$var_direct_flight,$var_flexi);
        // $airlines=$this->Airline($flights,$var_direct_flight,$var_flexi);
        // return $flights;

        // flight 2
        // $travel_class=$request->travel_class;
        // $flightFrom=$var_from2;
        // $flightTo=$var_to2;
        // $SearchDate=$var_flight1_date;
        // $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$SearchDate);
        // $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
        // $return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
        // $content = $this->prettyPrint($return);
        // $flights1 = ($this->parseOutput($content));
        // $stops1=$this->Stops($flights1,$var_direct_flight,$var_flexi);
        // $airlines1=$this->Airline($flights1,$var_direct_flight,$var_flexi);
        // return $flights1;

        // flight 3
        // $travel_class=$request->travel_class;
        // $flightFrom=$var_from3;
        // $flightTo=$var_to3;
        // $SearchDate=$var_flight2_date;
        // $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$SearchDate);
        // $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
        // $return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
        // $content = $this->prettyPrint($return);
        // $flights2 = ($this->parseOutput($content));
        // $stops2=$this->Stops($flights2,$var_direct_flight,$var_flexi);
        // $airlines2=$this->Airline($flights2,$var_direct_flight,$var_flexi);
        // return $flights2;
        // return $datasegment; 
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        
        $query = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
        <soapenv:Header/>
        <soapenv:Body>
           <air:LowFareSearchReq TraceId="trace" AuthorizedBy="user" SolutionResult="true" TargetBranch="'.$TARGETBRANCH.'" xmlns:air="http://www.travelport.com/schema/air_v42_0" xmlns:com="http://www.travelport.com/schema/common_v42_0">
              <com:BillingPointOfSaleInfo OriginApplication="UAPI"/>
              '.$datasegment.'
              <air:AirSearchModifiers>
                 <air:PreferredProviders>
                    <com:Provider Code="'.$Provider.'"/>
                 </air:PreferredProviders>
              </air:AirSearchModifiers>
              '.$travel_details.$currency_xml.'
           </air:LowFareSearchReq>
        </soapenv:Body>
     </soapenv:Envelope>';
    //  return $query;
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
        $content = $this->prettyPrint($return);
        $multiflights=$this->parseOutput($content);
        // return $multiflights; 
        // $min_val=min(count($flights),count($flights1),count($flights2));
        // $min_val=max(count($flights),count($flights1),count($flights2));
        // // $multiflights=[];
        // // $totalarr=[];
        // $multiflights = collect();

        // for ($i=0; $i <$min_val ; $i++) { 
        //     // echo $i;
        //     $totalarr=[];
        //     if(isset($flights[$i])){
        //     array_push($totalarr,$flights[$i]);
        //     }
        //     if(isset($flights1[$i])){
        //     array_push($totalarr,$flights1[$i]);
        //     }
        //     if(isset($flights2[$i])){
        //     array_push($totalarr,$flights2[$i]);
        //     }
        //     // array_push($totalarr,$flights[$i],$flights1[$i],$flights2[$i]);
        //     // $multiflights['multiflights']=$totalarr;
        //     $multiflights->push(['multiflights'=>collect($totalarr)]);				

        //     // $totalarr='';

        // }
        // return $multiflights;
        // return count($flights)." - ". count($flights1)." - ".count($flights2);
        // return $request;
        // return $flights[0];
        // return $return_flights[0];

        // return $multiflights; 
        // foreach($multiflights as $multiflightss){
        //     foreach($multiflightss as $datas){
        //         // foreach($datas[0] as $datass){
        //         //     // echo count($datass);
        //         //     // echo "<br/><br/>";
        //         //     $count=1;
        //         //     foreach($datass as $datass11){
        //         //         // $count=$count+1;
        //         //         // echo count($datass);
        //         //         print_r($datass11);
        //         //         echo "<br/><br/>";
        //         //         if($count==count($datass)){
        //         //         foreach($datass11 as $datass1){
        //         //             for ($i=0; $i < count($datass1); $i++) { 
        //         //             echo $datass1[$i]['From'];
        //         //                 echo "<br/><br/>";
        //         //             }
        //         //         }
        //         //         }
        //         //         $count++;
        //         //     }
        //         // }
        //         foreach($datas[1] as $datass){
        //             // echo count($datass);
        //             print_r($datass);
        //             echo "<br/><br/>";
        //         }
        //     }
        // }
        if($request->price_order == "price_order"){
            $multiflights= array_reverse(collect($multiflights)->toArray());
            // $search = collect($search)->sortByDesc('available_from_dt')->toArray();

        }
        $var_direct_flight='';
        $var_flexi='';
        $airlines=$this->Airline($multiflights,$var_direct_flight,$var_flexi);
        $stops=$this->Stops($multiflights,$var_direct_flight,$var_flexi);
        // return rsort($stops);
        
        return view('multicity.flights',[
            'searched' => $request,
            'multiflights'=>$multiflights,
            'airlines'=>$airlines,
            'stops'=>$stops,
        ]);
        
    }
    public function prettyPrint($result){
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($result);
        $dom->formatOutput = true;
        //call function to write request/response in file
        //   outputWriter($file,$dom->saveXML());
        return $dom->saveXML();
    }

    public function parseOutput_old($content){	//parse the Search response to get values to use in detail request
        $data = collect();
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        //echo $LowFareSearchRsp;
        // return $LowFareSearchRsp;
        $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);
        // return $xml;
        if(!$xml){
            trigger_error("Encoding Error!", E_USER_ERROR);
        }

        $Results = $xml->children('SOAP',true);
        foreach($Results->children('SOAP',true) as $fault){
            if(strcmp($fault->getName(),'Fault') == 0){
                // trigger_error("Error occurred request/response processing!", E_USER_ERROR);
                return $data;
            }
        }

        $count = 0;
        // return $Results;
        foreach($Results->children('air',true) as $lowFare){		
            foreach($lowFare->children('air',true) as $airPriceSol){	
                        
                if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){		
                    // $count = $count + 1;
                    foreach($airPriceSol->children('air',true) as $journey){					
                        if(strcmp($journey->getName(),'Journey') == 0){
                            $Journey= collect();
                            $journeydetails = collect();
                            foreach($journey->children('air', true) as $segmentRef){	
                                if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){								
                                    $details=[];
                                    foreach($segmentRef->attributes() as $a => $b){	
                                        $segment = $this->ListAirSegments($b, $lowFare);
                                        foreach($segment->attributes() as $c => $d){
                                            // $details[$c]=$d;
                                            if(strcmp($c, "Key") == 0){
                                                $details["Key"]=$d;
                                            }
                                            if(strcmp($c, "Group") == 0){
                                                $details["Group"]=$d;
                                            }
                                            if(strcmp($c, "Origin") == 0){
                                                $details["From"]=$d;
                                            }
                                            if(strcmp($c, "Destination") == 0){
                                                $details["To"]=$d;
                                            }
                                            if(strcmp($c, "Carrier") == 0){		
                                                $details["Airline"]=$d;								
                                            }
                                            if(strcmp($c, "FlightNumber") == 0){	
                                                $details["Flight"]=$d;
                                            }
                                            if(strcmp($c, "DepartureTime") == 0){	
                                                $details["Depart"]=$d;										
                                            }
                                            if(strcmp($c, "ArrivalTime") == 0){	
                                                $details["Arrive"]=$d;
                                            }
                                            if(strcmp($c, "FlightTime") == 0){	
                                                $details["FlightTime"]=$d;
                                            }
                                            if(strcmp($c, "Distance") == 0){	
                                                $details["Distance"]=$d;
                                            }		
                                        }
                                    }
                                    $journeydetails->push($details);
                                }
                            }	
                            $Journey->push(['journey'=>collect($journeydetails)]);				
                        }					
                    }
                   // Price Details
                    foreach($airPriceSol->children('air',true) as $priceInfo){
                        $flightPrice = [];
                        if(strcmp($priceInfo->getName(),'AirPricingInfo') == 0){
                            foreach($priceInfo->attributes() as $e => $f){
                                if(strcmp($e, "ApproximateBasePrice") == 0){
                                    $flightPrice['Approx Base Price'] = $f;
                                }
                                if(strcmp($e, "ApproximateTaxes") == 0){
                                    $flightPrice['Approx Taxes'] = $f;
                                }
                                if(strcmp($e, "ApproximateTotalPrice") == 0){
                                    $flightPrice['Approx Total Value'] = $f;
                                }
                                if(strcmp($e, "BasePrice") == 0){
                                    $flightPrice['Base Price'] = $f;
                                }
                                if(strcmp($e, "Taxes") == 0){
                                    $flightPrice['Taxes'] = $f;
                                }
                                if(strcmp($e, "TotalPrice") == 0){
                                    $flightPrice['Total Price'] = $f;
                                }
                            }
                            foreach($priceInfo->children('air',true) as $bookingInfo){
                                if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
                                    foreach($bookingInfo->attributes() as $e => $f){
                                        if(strcmp($e, "CabinClass") == 0){
                                            $flightPrice['Cabin Class'] = $f;
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
                    // file_put_contents($fileName,"\r\n", FILE_APPEND);
                }
            }
        }
        
        return $data;

    }

    public function parseOutput($content){	//parse the Search response to get values to use in detail request
        $data = collect();
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        //echo $LowFareSearchRsp;
        $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);	
        
        if(!$xml){
            trigger_error("Encoding Error!", E_USER_ERROR);
        }
    
        $Results = $xml->children('SOAP',true);
        foreach($Results->children('SOAP',true) as $fault){
            if(strcmp($fault->getName(),'Fault') == 0){
                return $data;
                // trigger_error("Error occurred request/response processing!", E_USER_ERROR);
            }
        }
        
        
        $count = 0;
        $fileName = public_path('flight/')."flights.txt";
        if(file_exists($fileName)){
            file_put_contents($fileName, "");
        }
    
        // $data = collect();
        
        foreach($Results->children('air',true) as $lowFare){		
            foreach($lowFare->children('air',true) as $airPriceSol){	
                        
                if(strcmp($airPriceSol->getName(),'AirPricingSolution') == 0){		
                    $count = $count + 1;
                    $Journey= collect();
                    $Journey_Outbound_Inbound= collect();
                    $var_toggle_journey_conunt=0;
                    foreach($airPriceSol->children('air',true) as $journey){					
                        if(strcmp($journey->getName(),'Journey') == 0){
                            $var_toggle_journey_conunt+=1;
                            $journeydetails = collect();
                            foreach($journey->children('air', true) as $segmentRef){	
                                                       
                                if(strcmp($segmentRef->getName(),'AirSegmentRef') == 0){								
                                    $details=[];
                                    foreach($segmentRef->attributes() as $a => $b){	
                                       
                                        $segment = $this->ListAirSegments($b, $lowFare);
                                        foreach($segment->attributes() as $c => $d){
                                            if(strcmp($c, "Key") == 0){
                                                $details["Key"]=$d;
                                            }
                                            if(strcmp($c, "Group") == 0){
                                                $details["Group"]=$d;
                                            }
                                            if(strcmp($c, "Origin") == 0){
                                                // $journeydetails->push(['From'=>$d]);
                                                $details["From"]=$d;
                                            }
                                            if(strcmp($c, "Destination") == 0){
                                                // $journeydetails->push(['To'=>$d]);
                                                $details["To"]=$d;
                                            }
                                            if(strcmp($c, "Carrier") == 0){		
                                                // $journeydetails->push(['Airline'=>$d]);	
                                                $details["Airline"]=$d;								
                                            }
                                            if(strcmp($c, "FlightNumber") == 0){	
                                                // $journeydetails->push(['flight'=>$d]);
                                                $details["Flight"]=$d;
                                            }
                                            if(strcmp($c, "DepartureTime") == 0){	
                                                // $journeydetails->push(['Depart'=>$d]);	
                                                $details["Depart"]=$d;										
                                            }
                                            if(strcmp($c, "ArrivalTime") == 0){	
                                                // $journeydetails->push(['Arrive'=>$d]);
                                                $details["Arrive"]=$d;
                                            }	
                                            if(strcmp($c, "FlightTime") == 0){	
                                                $details["FlightTime"]=$d;
                                            }
                                            if(strcmp($c, "Distance") == 0){	
                                                $details["Distance"]=$d;
                                            }		
                                           
                                        }
                                        
                                    }
                                    $journeydetails->push($details);
                                }
                            }	
                                            
                            if($var_toggle_journey_conunt==1)
                            {
                                $Journey_Outbound_Inbound->push(['flight1'=>collect($journeydetails)]);	
                            }
                            else if($var_toggle_journey_conunt==2)
                            {
                                $Journey_Outbound_Inbound->push(['flight2'=>collect($journeydetails)]);	
                            }
                            else if($var_toggle_journey_conunt==3)
                            {
                                $Journey_Outbound_Inbound->push(['flight3'=>collect($journeydetails)]);	
                            }
                            else if($var_toggle_journey_conunt==4)
                            {
                                $Journey_Outbound_Inbound->push(['flight4'=>collect($journeydetails)]);	
                            }
                            else if($var_toggle_journey_conunt==5)
                            {
                                $Journey_Outbound_Inbound->push(['flight5'=>collect($journeydetails)]);	
                            }	
                            else if($var_toggle_journey_conunt==6)
                            {
                                $Journey_Outbound_Inbound->push(['flight6'=>collect($journeydetails)]);	
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
                                    $flightPrice['Approx Base Price'] = $f;
                                }
                                if(strcmp($e, "ApproximateTaxes") == 0){
                                    $flightPrice['Approx Taxes'] = $f;
                                }
                                if(strcmp($e, "ApproximateTotalPrice") == 0){
                                    $flightPrice['Approx Total Value'] = $f;
                                }
                                if(strcmp($e, "BasePrice") == 0){
                                    $flightPrice['Base Price'] = $f;
                                }
                                if(strcmp($e, "Taxes") == 0){
                                    $flightPrice['Taxes'] = $f;
                                }
                                if(strcmp($e, "TotalPrice") == 0){
                                    $flightPrice['Total Price'] = $f;
                                }
    
                            }
                            foreach($priceInfo->children('air',true) as $bookingInfo){
                                if(strcmp($bookingInfo->getName(),'BookingInfo') == 0){
                                    foreach($bookingInfo->attributes() as $e => $f){
                                        if(strcmp($e, "CabinClass") == 0){
                                            $flightPrice['Cabin Class'] = $f;
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
                }
            }
        }
        
        // print_r($data) ;
        // echo $data;
        return $data;
        // echo "\r\n"."Processing Done. Please check results in files.";
    
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


    public function Stops($data,$var_direct_flight,$var_flexi){
        $return_stops= [];
        foreach($data as $flight){
            foreach($flight as $flight_data){
                foreach($flight_data[0] as $datas){
                    foreach($datas[0] as $journeys){
                    // foreach($datas[1] as $journeys1){

                    // }
                        if($var_direct_flight=="DF" && count($journeys)>1 && $var_flexi=="")
                        {
                            continue;
                        }
                        else if($var_direct_flight=="DF" && count($journeys)>1 && $var_flexi=="F")
                        {
                            continue;
                        }
                       
                        array_push($return_stops,count($journeys)-1);
                    }
                }
            }
        }
        // $return_stops = collect($return_stops)->sortByDesc('available_from_dt')->toArray();
        $return_stops = array_unique($return_stops);
        return $return_stops;
    }
    public function Airline($data,$var_direct_flight,$var_flexi){
        $return_airlines = [];
        foreach($data as $flight){
            foreach($flight as $flight_data){
                foreach($flight_data[0] as $datas){
                    foreach($datas[0] as $journeys){
                        for ($i=0; $i < count($journeys); $i++) { 
                            if($var_direct_flight=="DF" && count($journeys)>1 && $var_flexi=="")
                            {
                                continue;
                            }
                            else if($var_direct_flight=="DF" && count($journeys)>1 && $var_flexi=="F")
                            {
                                continue;
                            }
                            // elseif ($var_direct_flight=="" && count($journeys)==1 && $var_flexi=="F") {
                            //     continue;
                            // }
                            array_push($return_airlines,$journeys[$i]['Airline']);
                        }
                    }
                }
            }
        }
        $return_airlines = array_unique($return_airlines);
        return $return_airlines;
    }

}
