<?php

namespace App\Http\Controllers;

use App\Models\AirportCodes;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        if(isset(explode('(',$request->addFrom)[1])){
            $var_flightFrom =  str_replace(')','',explode('(',$request->addFrom)[1]);
        }else{
            // return "addFrom";
            return redirect()->route('errorPage')->with('searcherror','searcherror');
        }
        if(isset(explode('(',$request->addTo)[1])){
            $var_flightTo =  str_replace(')','',explode('(',$request->addTo)[1]);
        }else{
            return redirect()->route('errorPage')->with('searcherror','searcherror');
            // return "addTo";
        }
        // $var_flightFrom =  str_replace(')','',explode('(',$request->addFrom)[1]);
        // $var_flightTo =  str_replace(')','',explode('(',$request->addTo)[1]);


        $var_PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');
        $var_direct_flight=$request->direct_flight;
        $var_flexi=$request->flexi;

        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;
        $var_country_code=$request->country_code;
        $var_currency_code=DB::table('countries')->where('country_code',$var_country_code)->value('currency_code');
        // return $var_currency_code;

        if($request->returning_date != null) {
            $new_return_flight=collect();
            $var_returnDate = Carbon::parse($request->returning_date)->format('Y-m-d');
            $travel_class=$request->travel_class;
            $flightFrom=$var_flightTo;
            $flightTo=$var_flightFrom;
            $SearchPreferredDate=$var_PreferredDate;
            $SearchDate=$var_returnDate;
            $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXMLReturn($travel_class,$flightFrom,$flightTo,$SearchPreferredDate,$SearchDate,$var_adults,$var_children,$var_infant,$var_currency_code);
            // $file='LowFareSearchReqXML';
            // file_put_contents($file, $xmldata);
            $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
            $return_return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
            // return $return_return ;
            // $file='LowFareSearchResXML';
            // file_put_contents($file, $return_return);
            if($return_return==null){
                // return $return;
                return redirect()->route('errorPage');
            }
            $return_content = $this->prettyPrint($return_return);
            $return_flights = $this->parseOutputReturn($return_content);
            // $return_stops=$this->Stops($return_flights,$var_direct_flight,$var_flexi);
            // $return_airlines=$this->Airline($return_flights,$var_direct_flight,$var_flexi);
            // return $return_flights;
            if($var_flexi=='F'){
                // $var_PreferredDate
                // $var_returnDate
                $var_PreferredDate1=date('Y-m-d', strtotime($var_PreferredDate. ' - 1 days'));
                $var_returnDate1=date('Y-m-d', strtotime($var_returnDate. ' + 1 days'));
                // return $old_date1;
                if($var_PreferredDate1>=date('Y-m-d') && $var_returnDate1>=date('Y-m-d')){
                    $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXMLReturn($travel_class,$flightFrom,$flightTo,$var_PreferredDate1,$var_returnDate1,$var_adults,$var_children,$var_infant,$var_currency_code);
                    $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
                    $return_return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
                    $return_content = $this->prettyPrint($return_return);
                    $return_flights1 = $this->parseOutputReturn($return_content);
                    // $new_return_flight->push($return_flights1);
                    foreach($return_flights1 as $return_flightss){
                        if(count($return_flightss)<3){
                            $new_return_flight->push($return_flightss);
                        }
                    }
                }
                $var_PreferredDate2=date('Y-m-d', strtotime($var_PreferredDate. ' + 1 days'));
                $var_returnDate2=date('Y-m-d', strtotime($var_returnDate. ' + 2 days'));
                if($var_PreferredDate2>=date('Y-m-d') && $var_returnDate2>=date('Y-m-d')){
                    $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXMLReturn($travel_class,$flightFrom,$flightTo,$var_PreferredDate2,$var_returnDate2,$var_adults,$var_children,$var_infant,$var_currency_code);
                    $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
                    $return_return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
                    $return_content = $this->prettyPrint($return_return);
                    $return_flights1 = $this->parseOutputReturn($return_content);
                    // $new_return_flight->push($return_flights1);
                    foreach($return_flights1 as $return_flightss){
                        if(count($return_flightss)<3){
                            $new_return_flight->push($return_flightss);
                        }
                    }
                }
                // return $return_flights1;
                // return $new_return_flight;
                // return $return_flights;
                //     if (strtotime($old_date1) <= strtotime(date('Y-m-d'))) {
                // return "hii";
            }
            foreach($return_flights as $return_flightss){
                $new_return_flight->push($return_flightss);
            }
            // return $new_return_flight;

            //for stops loop
            foreach($new_return_flight as $flight){
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
                            // else if ($var_direct_flight=="" && count($journeys)==1 && $var_flexi=="F") {
                            //     continue;
                            // }
                            array_push($return_stops,count($journeys)-1);
                        }
                    }
                }
            }
            $return_stops = array_unique($return_stops);
            // for airline loops
            foreach($new_return_flight as $flight){
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

            if($request->price_order == "price_order"){
                $new_return_flight= array_reverse(collect($new_return_flight)->toArray());
                // $search = collect($search)->sortByDesc('available_from_dt')->toArray();
            }
        }else{
            $new_flight=collect();
            $travel_class=$request->travel_class;
            $flightFrom=$var_flightFrom;
            $flightTo=$var_flightTo;
            $SearchDate=$var_PreferredDate;
            $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$SearchDate,$var_adults,$var_children,$var_infant,$var_currency_code);
            // return $xmldata;
            $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
            $return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
            // return $return;
            if($return==null){
                // return $return;
                return redirect()->route('errorPage');
            }
            $content = $this->prettyPrint($return);
            $flights = $this->parseOutput($content);
            
            // return $flights ;
            // if($var_flexi=='F'){
            //     $old_date1=date('Y-m-d', strtotime($var_PreferredDate. ' - 1 days'));
            //     // return $old_date1;
            //     $new_date1=date('Y-m-d', strtotime($var_PreferredDate. ' + 1 days'));
            //     if (strtotime($old_date1) <= strtotime(date('Y-m-d'))) {
            //         return "hii";
            //         $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$old_date1);
            //         // $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
            //         $return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
            //         $content = $this->prettyPrint($return);
            //         $flights1 = $this->parseOutput($content);
            //         // array_push($flights,$flights1);
            //         foreach($flights as $data){
            //             $new_flight->push($data);
            //         }
            //     }
            //     // return $date1;
            //     $xmldata=app('App\Http\Controllers\UtilityController')->Universal_API_SearchXML($travel_class,$flightFrom,$flightTo,$new_date1);
            //     // $api_url = "https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/AirService";
            //     $return =app('App\Http\Controllers\UtilityController')->universal_API($xmldata,$api_url);
            //     $content = $this->prettyPrint($return);
            //     $flights2 = $this->parseOutput($content);
            //     // array_push($flights,$flights2);
            //     // $new_flight->push()
            //     foreach($flights2  as $datas ){
            //         $new_flight->push($datas);
            //     }
            // }
            // return $new_flight;
            // return $flights2;

            $stops=$this->Stops($flights,$var_direct_flight,$var_flexi);
            $airlines=$this->Airline($flights,$var_direct_flight,$var_flexi);
            // return $flights;

            if($request->price_order == "price_order"){
                $flights= array_reverse(collect($flights)->toArray());
                // $search = collect($search)->sortByDesc('available_from_dt')->toArray();

            }
            // else{
            //     // $flights = collect($flights)->sortBy('Total Price')->toArray();
            // }
            if($request->departure_order == "ASC"){
                $flights = collect($flights)->sortBy('Depart')->toArray();
                // return $flights;
            }else if($request->departure_order == "DESC"){

            }
        }
        // return $request;
        // return $flights[0];
        // return $return_flights[0];
        // foreach($flights[0] as $data){
        //     foreach($data[0] as $datas){
        //         echo $datas[0]['Airline'];
        //         // print_r($datas);
        //         // echo "<br/>";
        //     }
        // }
        // return $new_return_flight;
        if($request->returning_date!=''){
            return view('flights.flight-round',[
                'searched' => $request,
                'return_flights'=>$new_return_flight,
                'return_stops'=>$return_stops,
                'return_airlines'=>$return_airlines
            ]);
        }else{
            return view('flights.flights',[
                'searched' => $request,
                'flights'=>$flights,
                'airlines'=>$airlines,
                'stops'=>$stops,
                'return_flights'=>$return_flights,
                'return_stops'=>$return_stops,
                'return_airlines'=>$return_airlines
            ]);
        }
    }
    public function prettyPrint($result){
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($result);
        $dom->formatOutput = true;
        //call function to write request/response in file
//        outputWriter($file,$dom->saveXML());
        return $dom->saveXML();
    }

    public function parseOutput($content){	//parse the Search response to get values to use in detail request
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

    public function parseOutputReturn($content){
        $data = collect();
        	//parse the Search response to get values to use in detail request
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        //echo $LowFareSearchRsp;
        $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);	
        
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
                                $Journey_Outbound_Inbound->push(['outbound'=>collect($journeydetails)]);	
                            }
                            else if($var_toggle_journey_conunt==2)
                            {
                                $Journey_Outbound_Inbound->push(['inbound'=>collect($journeydetails)]);	
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

    public function SearchAirport(Request $request){
        return AirportCodes::search($request->get('q'))->select('name','code')->get()->map(function($airport){
            return $airport->name . '('. $airport->code.')';
        });
    }

    public function FlightDetails(Request $request){
        // return $request;
        $flights=json_decode($request->flights);
        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;
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
        // return $flights;
        // echo count($flights[0]);
        $datasegment='';
        foreach($flights[0] as $journeys){
            for ($i=0; $i < count($journeys); $i++) {
                $datasegment.= '<air:AirSegment Key="'.get_object_vars($journeys[$i]->Key)[0].'" Group="'.get_object_vars($journeys[$i]->Group)[0].'" Carrier="'.get_object_vars($journeys[$i]->Airline)[0].'" FlightNumber="'.get_object_vars($journeys[$i]->Flight)[0].'" Origin="'.get_object_vars($journeys[$i]->From)[0].'" Destination="'.get_object_vars($journeys[$i]->To)[0].'" DepartureTime="'.get_object_vars($journeys[$i]->Depart)[0].'" ArrivalTime="'.get_object_vars($journeys[$i]->Arrive)[0].'" FlightTime="'.get_object_vars($journeys[$i]->FlightTime)[0].'" Distance="'.get_object_vars($journeys[$i]->Distance)[0].'" ETicketability="Yes" ProviderCode="1G" ></air:AirSegment>';
            }
        }
        $travel_details=app('App\Http\Controllers\UtilityController')->TravelDetailsDatasagment($var_adults,$var_children,$var_infant);
        // return $travel_details;
        // foreach($flights[1] as $prices){
        // }
        // $TARGETBRANCH = 'P7141733';CREDENTIALS
        // $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $CREDENTIALS = app('App\Http\Controllers\UniversalConfigAPIController')->CREDENTIALS();
        $Provider =app('App\Http\Controllers\UniversalConfigAPIController')->Provider();
        $TARGETBRANCH =app('App\Http\Controllers\UniversalConfigAPIController')->TARGETBRANCH();
        
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
              '.$currency_xml.$travel_details.'
              <air:AirPricingCommand/>
           </air:AirPriceReq>
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
       
        // $data=collect();
        // $journey=collect();
        // $count=1;
        // foreach($object as $jsons){
        //     foreach($jsons as $jsons1){
        //         // print_r($jsons1);
        //         // echo "<br/><br/>";
        //         if(array_key_exists('SOAP:Fault',$jsons1)){
        //             return "Error No data Found";
        //         }else{
        //             foreach($jsons1 as $jsons2){
        //                 if(is_array($jsons2)){
        //                     // count($jsons1)>1
        //                     // print_r($jsons2);
        //                     // echo "<br/><br/>";
        //                     // print_r(array_key_exists('air:AirItinerary',$jsons2));
        //                     if(array_key_exists('air:AirItinerary',$jsons2)){
        //                         // print_r($jsons2['air:AirItinerary']['air:AirSegment']);
        //                         // echo "<br/><br/>";
        //                         $details1=[];
        //                         foreach($jsons2['air:AirItinerary']['air:AirSegment'] as $g => $jsons5){
        //                             //  print_r($jsons5);
        //                             //     echo "<br/>";
        //                             if(is_string($jsons5)){
        //                                 if(strcmp($g, "@Key") == 0){
        //                                     $details1["key"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@Group") == 0){
        //                                     $details1["Group"] =$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@Carrier") == 0){
        //                                     $details1["Carrier"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@FlightNumber") == 0){
        //                                     $details1["FlightNumber"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@Origin") == 0){
        //                                     $details1["Origin"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@Destination") == 0){
        //                                     $details1["Destination"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@DepartureTime") == 0){
        //                                     $details1["DepartureTime"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@ArrivalTime") == 0){
        //                                     $details1["ArrivalTime"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@FlightTime") == 0){
        //                                     $details1["FlightTime"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@TravelTime") == 0){
        //                                     $details1["TravelTime"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@Distance") == 0){
        //                                     $details1["Distance"]=$jsons5;
        //                                 }
        //                                 if(strcmp($g, "@ClassOfService") == 0){
        //                                     $details1["ClassOfService"]=$jsons5;
        //                                 }
        //                             }else{
        //                                 $details=[];
        //                                 foreach($jsons5 as $k => $jsons6){
        //                                     // print_r($jsons6);
        //                                     // echo "<br/>";
        //                                     if(is_string($jsons6)){
        //                                         if(strcmp($k, "@Key") == 0){
        //                                             $details["key"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@Group") == 0){
        //                                             $details["Group"] =$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@Carrier") == 0){
        //                                             $details["Carrier"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@FlightNumber") == 0){
        //                                             $details["FlightNumber"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@Origin") == 0){
        //                                             $details["Origin"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@Destination") == 0){
        //                                             $details["Destination"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@DepartureTime") == 0){
        //                                             $details["DepartureTime"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@ArrivalTime") == 0){
        //                                             $details["ArrivalTime"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@FlightTime") == 0){
        //                                             $details["FlightTime"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@TravelTime") == 0){
        //                                             $details["TravelTime"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@Distance") == 0){
        //                                             $details["Distance"]=$jsons6;
        //                                         }
        //                                         if(strcmp($k, "@ClassOfService") == 0){
        //                                             $details["ClassOfService"]=$jsons6;
        //                                         }
        //                                         // $details["changeofplane"] =$jsons6;
        //                                         // $details["optionalservicesindicator"]=$jsons6; 
        //                                         // $details["availabilitysource"] =$jsons6;
        //                                         // $details["polledavailabilityoption"] =$jsons6;
        //                                         // print_r($jsons6);
        //                                         // echo "<br/>";
        //                                         // $journey->push($details);   
        //                                         // print_r($k." - ".$jsons6);
                                            
        //                                     }
        //                                 }
        //                                 if(empty($details1) && !empty($details)){
        //                                     $journey->push($details); 
        //                                 }    
        //                             }
        //                         }
        //                         if(!empty($details1)){
        //                             $journey->push($details1);     
        //                         }
        //                         // return $journey;
        //                         $data->push(["journey"=>collect($journey)]);      

        //                     }
        //                     if(array_key_exists('air:AirPriceResult',$jsons2)){
        //                         // print_r($jsons2['air:AirPriceResult']);
        //                         // return $jsons2['air:AirPriceResult'];
        //                         // echo "<br/><br/>";
        //                         // print_r($jsons2['air:AirPriceResult']['air:AirPricingSolution']);
        //                         // return count($jsons2['air:AirPriceResult']['air:AirPricingSolution']);

        //                         // some error on indexing
        //                         // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'];
        //                         // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0];
        //                         $price=[];
        //                         foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0] as $p => $jsons15){
        //                             if(is_string($jsons15)){
        //                                 if(strcmp($p, "@Key") == 0){
        //                                     $price["Key"]=$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@TotalPrice") == 0){
        //                                     $price["TotalPrice"]=$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@BasePrice") == 0){
        //                                     $price["BasePrice"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@ApproximateTotalPrice") == 0){
        //                                     $price["ApproximateTotalPrice"]=$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@ApproximateBasePrice") == 0){
        //                                     $price["ApproximateBasePrice"]=$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@EquivalentBasePrice") == 0){
        //                                     $price["EquivalentBasePrice"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@Taxes") == 0){
        //                                     $price["Taxes"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@Fees") == 0){
        //                                     $price["Fees"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@ApproximateTaxes") == 0){
        //                                     $price["ApproximateTaxes"]=$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@QuoteDate") == 0){
        //                                     $price["QuoteDate"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@FareInfoRef") == 0){
        //                                     $price["FareInfoRef"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@RuleNumber") == 0){
        //                                     $price["RuleNumber"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@Source") == 0){
        //                                     $price["Source"] =$jsons15;
        //                                 }
        //                                 if(strcmp($p, "@TariffNumber") == 0){
        //                                     $price["TariffNumber"] =$jsons15;
        //                                 }
        //                             }
                                
        //                         }
        //                         // $data->push(["price"=>collect($price)]);     
        //                         $AirPricingInfo=collect();
        //                         $FareInfo1=collect();
        //                         $FareRuleKey1=collect();
        //                         $BookingInfo1=collect();
        //                         $TaxInfo=collect();

        //                         if(array_key_exists('air:AirPricingInfo',$jsons2['air:AirPriceResult']['air:AirPricingSolution'][0])){
        //                             $jsons14=$jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'];
        //                             // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'];
        //                             $AirPricingInfo1=[];
        //                             foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['air:AirPricingInfo'] as $key => $value){
        //                                 $AirPricingInfo0=[];
        //                                 if(is_string($value)){
        //                                     if(strcmp($key, "@Key") == 0){
        //                                         $AirPricingInfo1["Key"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@TotalPrice") == 0){
        //                                         $AirPricingInfo1["TotalPrice"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@BasePrice") == 0){
        //                                         $AirPricingInfo1["BasePrice"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@ApproximateTotalPrice") == 0){
        //                                         $AirPricingInfo1["ApproximateTotalPrice"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@ApproximateBasePrice") == 0){
        //                                         $AirPricingInfo1["ApproximateBasePrice"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@EquivalentBasePrice") == 0){
        //                                         $AirPricingInfo1["EquivalentBasePrice"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@ApproximateTaxes") == 0){
        //                                         $AirPricingInfo1["ApproximateTaxes"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@Taxes") == 0){
        //                                         $AirPricingInfo1["Taxes"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@LatestTicketingTime") == 0){
        //                                         $AirPricingInfo1["LatestTicketingTime"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@PricingMethod") == 0){
        //                                         $AirPricingInfo1["PricingMethod"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@Refundable") == 0){
        //                                         $AirPricingInfo1["Refundable"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@IncludesVAT") == 0){
        //                                         $AirPricingInfo1["IncludesVAT"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@ETicketability") == 0){
        //                                         $AirPricingInfo1["ETicketability"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@PlatingCarrier") == 0){
        //                                         $AirPricingInfo1["PlatingCarrier"]=$value;
        //                                     }
        //                                     if(strcmp($key, "@ProviderCode") == 0){
        //                                         $AirPricingInfo1["ProviderCode"]=$value;
        //                                     }
        //                                 }else{
        //                                     foreach($value as $key => $value1){
        //                                         if(is_string($value1)){
        //                                             if(strcmp($key, "@Key") == 0){
        //                                                 $AirPricingInfo0["Key"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@TotalPrice") == 0){
        //                                                 $AirPricingInfo0["TotalPrice"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@BasePrice") == 0){
        //                                                 $AirPricingInfo0["BasePrice"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@ApproximateTotalPrice") == 0){
        //                                                 $AirPricingInfo0["ApproximateTotalPrice"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@ApproximateBasePrice") == 0){
        //                                                 $AirPricingInfo0["ApproximateBasePrice"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@EquivalentBasePrice") == 0){
        //                                                 $AirPricingInfo0["EquivalentBasePrice"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@ApproximateTaxes") == 0){
        //                                                 $AirPricingInfo0["ApproximateTaxes"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@Taxes") == 0){
        //                                                 $AirPricingInfo0["Taxes"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@LatestTicketingTime") == 0){
        //                                                 $AirPricingInfo0["LatestTicketingTime"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@PricingMethod") == 0){
        //                                                 $AirPricingInfo0["PricingMethod"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@Refundable") == 0){
        //                                                 $AirPricingInfo0["Refundable"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@IncludesVAT") == 0){
        //                                                 $AirPricingInfo0["IncludesVAT"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@ETicketability") == 0){
        //                                                 $AirPricingInfo0["ETicketability"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@PlatingCarrier") == 0){
        //                                                 $AirPricingInfo0["PlatingCarrier"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "@ProviderCode") == 0){
        //                                                 $AirPricingInfo0["ProviderCode"]=$value1;
        //                                             }
        //                                         }
        //                                     }

        //                                     // start multiple travel add adult and child
                                            
        //                                     // return $value;
        //                                     // print_r($value);
        //                                     // print_r($value['air:FareInfo']);
        //                                     // echo "<br/><br/><br/>";

        //                                     // fareInfo and fareRule key
        //                                     if(array_key_exists('air:FareInfo',$value)){
        //                                         $FareInfo=[];
        //                                         foreach($value['air:FareInfo'] as $fI => $jsons17){
        //                                             $FareInfo0=[];
        //                                             // echo $count50;
        //                                             // print_r($jsons17);
        //                                             // echo "<br/><br/><br/>";
        //                                             // $FareRuleKey1=collect();
        //                                             if(is_string($jsons17)){
        //                                                 // print_r($fI."-".$jsons17);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 if(strcmp($fI, "@Key") == 0){
        //                                                     $FareInfo["Key"] =$jsons17;
        //                                                 }
        //                                                 if(strcmp($fI, "@FareBasis") == 0){
        //                                                     $FareInfo["FareBasis"] =$jsons17;
        //                                                 }
        //                                                 if(strcmp($fI, "@PassengerTypeCode") == 0){
        //                                                     $FareInfo["PassengerTypeCode"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@Origin") == 0){
        //                                                     $FareInfo["Origin"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@Destination") == 0){
        //                                                     $FareInfo["Destination"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@EffectiveDate") == 0){
        //                                                     $FareInfo["EffectiveDate"] =$jsons17;
        //                                                 }  
        //                                                 if(strcmp($fI, "@DepartureDate") == 0){
        //                                                     $FareInfo["DepartureDate"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@Amount") == 0){
        //                                                     $FareInfo["Amount"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@NegotiatedFare") == 0){
        //                                                     $FareInfo["NegotiatedFare"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@NotValidBefore") == 0){
        //                                                     $FareInfo["NotValidBefore"] =$jsons17;
        //                                                 } 
        //                                                 if(strcmp($fI, "@TaxAmount") == 0){
        //                                                     $FareInfo["TaxAmount"] =$jsons17;
        //                                                 } 
        //                                             }else{
        //                                                 foreach($jsons17 as $fI =>$jsons18){
        //                                                     if(is_string($jsons18)){
        //                                                         // print_r($fI."-".$jsons17);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         if(strcmp($fI, "@Key") == 0){
        //                                                             $FareInfo0["Key"] =$jsons18;
        //                                                         }
        //                                                         if(strcmp($fI, "@FareBasis") == 0){
        //                                                             $FareInfo0["FareBasis"] =$jsons18;
        //                                                         }
        //                                                         if(strcmp($fI, "@PassengerTypeCode") == 0){
        //                                                             $FareInfo0["PassengerTypeCode"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@Origin") == 0){
        //                                                             $FareInfo0["Origin"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@Destination") == 0){
        //                                                             $FareInfo0["Destination"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@EffectiveDate") == 0){
        //                                                             $FareInfo0["EffectiveDate"] =$jsons18;
        //                                                         }  
        //                                                         if(strcmp($fI, "@DepartureDate") == 0){
        //                                                             $FareInfo0["DepartureDate"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@Amount") == 0){
        //                                                             $FareInfo0["Amount"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@NegotiatedFare") == 0){
        //                                                             $FareInfo0["NegotiatedFare"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@NotValidBefore") == 0){
        //                                                             $FareInfo0["NotValidBefore"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($fI, "@TaxAmount") == 0){
        //                                                             $FareInfo0["TaxAmount"] =$jsons18;
        //                                                         } 
        //                                                     }
        //                                                 }
        //                                                 // print_r($jsons17['air:FareRuleKey']);
        //                                                 // echo "<br/><br/>";
        //                                                 if(array_key_exists('air:FareRuleKey', $jsons17)){
        //                                                     $FareRuleKey0=[];
        //                                                     foreach($jsons17['air:FareRuleKey'] as $frk => $jsons19){
        //                                                         if(is_string($jsons19)){
        //                                                             if(strcmp($frk, "@FareInfoRef") == 0){
        //                                                                 $FareRuleKey0["FareInfoRef"] =$jsons19;
        //                                                             } 
        //                                                             if(strcmp($frk, "@ProviderCode") == 0){
        //                                                                 $FareRuleKey0["ProviderCode"] =$jsons19;
        //                                                             } 
        //                                                             if(strcmp($frk, "$") == 0){
        //                                                                 $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
        //                                                             } 
        //                                                         }
        //                                                     }
        //                                                     $FareRuleKey1->push($FareRuleKey0);
        //                                                 }
        //                                             }

        //                                             if(empty($FareInfo) && !empty($FareInfo0)){
        //                                                 $FareInfo1->push($FareInfo0);
        //                                             }
        //                                             // $FareRuleKey1=collect();
        //                                             if(array_key_exists('air:FareRuleKey', $value['air:FareInfo'])){
        //                                                 // print_r($value['air:FareInfo']['air:FareRuleKey']);
        //                                                 // echo "<br/><br/>";
        //                                                 $FareRuleKey=[];
                                                        
        //                                                 foreach($value['air:FareInfo']['air:FareRuleKey'] as $frk => $jsons18){
        //                                                     // print_r($jsons18);
        //                                                     // echo "<br/><br/><br/>";
        //                                                     $FareRuleKey0=[];
        //                                                     if(is_string($jsons18)){
        //                                                         // print_r($frk." - ".$jsons18);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         if(strcmp($frk, "@FareInfoRef") == 0){
        //                                                             $FareRuleKey["FareInfoRef"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($frk, "@ProviderCode") == 0){
        //                                                             $FareRuleKey["ProviderCode"] =$jsons18;
        //                                                         } 
        //                                                         if(strcmp($frk, "$") == 0){
        //                                                             $FareRuleKey["FareRuleKeyValue"] =$jsons18;
        //                                                         } 
        //                                                     }else{
        //                                                         foreach($jsons18 as $frk => $jsons19){
        //                                                             if(is_string($jsons19)){
        //                                                                 // print_r($frk." - ".$jsons18);
        //                                                                 // echo "<br/><br/><br/>";
        //                                                                 if(strcmp($frk, "@FareInfoRef") == 0){
        //                                                                     $FareRuleKey0["FareInfoRef"] =$jsons19;
        //                                                                 } 
        //                                                                 if(strcmp($frk, "@ProviderCode") == 0){
        //                                                                     $FareRuleKey0["ProviderCode"] =$jsons19;
        //                                                                 } 
        //                                                                 if(strcmp($frk, "$") == 0){
        //                                                                     $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
        //                                                                 } 
        //                                                             }
        //                                                         }
        //                                                         // if(empty($FareRuleKey) && !empty($FareRuleKey0)){
        //                                                         //     $FareRuleKey1->push($FareRuleKey0);
        //                                                         // }
        //                                                     }
        //                                                 }
        //                                                 // if(!empty($FareRuleKey)){
        //                                                 //     $FareRuleKey1->push($FareRuleKey);
        //                                                 // }
        //                                             }
        //                                         }
        //                                         if(!empty($FareInfo)){
        //                                             $FareInfo1->push($FareInfo);
        //                                         }
        //                                         if(!empty($FareRuleKey)){
        //                                             $FareRuleKey1->push($FareRuleKey);
        //                                         }
        //                                     }
        //                                     if(array_key_exists('air:BookingInfo', $value)){
        //                                         // $BookingInfo1=collect();
        //                                         $BookingInfo=[];
        //                                         foreach($value['air:BookingInfo'] as $bki => $jsons17){
        //                                             $BookingInfo0=[];
        //                                             // print_r($jsons17);
        //                                             // echo "<br/><br/><br/>";
        //                                             if(is_string($jsons17)){
        //                                                 // print_r($bki."-".$jsons17);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 if(strcmp($bki, "@BookingCode") == 0){
        //                                                     $BookingInfo["BookingCode"] =$jsons17;
        //                                                 }
        //                                                 if(strcmp($bki, "@CabinClass") == 0){
        //                                                     $BookingInfo["CabinClass"] =$jsons17;
        //                                                 }
        //                                                 if(strcmp($bki, "@FareInfoRef") == 0){
        //                                                     $BookingInfo["FareInfoRef"] =$jsons17;
        //                                                 }
        //                                                 if(strcmp($bki, "@SegmentRef") == 0){
        //                                                     $BookingInfo["SegmentRef"] =$jsons17;
        //                                                 }
        //                                                 if(strcmp($bki, "@HostTokenRef") == 0){
        //                                                     $BookingInfo["HostTokenRef"] =$jsons17;
        //                                                 }
        //                                             }else{
        //                                                 foreach($jsons17 as $bki => $jsons18){
        //                                                     if(is_string($jsons18)){
        //                                                         // print_r($bki."-".$jsons17);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         if(strcmp($bki, "@BookingCode") == 0){
        //                                                             $BookingInfo0["BookingCode"] =$jsons18;
        //                                                         }
        //                                                         if(strcmp($bki, "@CabinClass") == 0){
        //                                                             $BookingInfo0["CabinClass"] =$jsons18;
        //                                                         }
        //                                                         if(strcmp($bki, "@FareInfoRef") == 0){
        //                                                             $BookingInfo0["FareInfoRef"] =$jsons18;
        //                                                         }
        //                                                         if(strcmp($bki, "@SegmentRef") == 0){
        //                                                             $BookingInfo0["SegmentRef"] =$jsons18;
        //                                                         }
        //                                                         if(strcmp($bki, "@HostTokenRef") == 0){
        //                                                             $BookingInfo0["HostTokenRef"] =$jsons18;
        //                                                         }
        //                                                     }
        //                                                 } 
        //                                             }
        //                                             if(empty($BookingInfo) && !empty($BookingInfo0)){
        //                                                 $BookingInfo1->push($BookingInfo0);
        //                                             }
        //                                         }
        //                                         // if(empty($BookingInfo) && !empty($BookingInfo0)){
        //                                         //     $BookingInfo1->push($BookingInfo0);
        //                                         // }
        //                                         if(!empty($BookingInfo)){
        //                                             $BookingInfo1->push($BookingInfo);
        //                                         }
        //                                     }
        //                                     if(array_key_exists('air:TaxInfo', $value)){
        //                                         // $TaxInfo=collect();
        //                                         $TaxInfo1=[];
        //                                         foreach($value['air:TaxInfo'] as $jsons17){
        //                                             // print_r($jsons17);
        //                                             // echo "<br/><br/><br/>";
        //                                             foreach($jsons17 as $tki => $jsons18){
        //                                                 if(is_string($jsons18)){
        //                                                     // print_r($tki."-".$jsons18);
        //                                                     // echo "<br/><br/><br/>";
        //                                                     if(strcmp($tki, "@Category") == 0){
        //                                                         $TaxInfo1["Category"] =$jsons18;
        //                                                     }
        //                                                     if(strcmp($tki, "@Amount") == 0){
        //                                                         $TaxInfo1["Amount"] =$jsons18;
        //                                                     }
        //                                                     if(strcmp($tki, "@Key") == 0){
        //                                                         $TaxInfo1["Key"] =$jsons18;
        //                                                     }
                                                        
        //                                                 }
        //                                             }
        //                                             $TaxInfo->push($TaxInfo1);
        //                                         }
        //                                     }
        //                                     if(array_key_exists('air:FareCalc', $value)){
        //                                         $FareCalc=[];
        //                                         foreach($value['air:FareCalc'] as $fcc => $jsons17){
        //                                             // print_r($jsons17);
        //                                             if(is_string($jsons17)){
        //                                                 if(strcmp($fcc, "$") == 0){
        //                                                     $FareCalc["FareCalc"] =$jsons17;
        //                                                 }
        //                                             }
        //                                         }
        //                                     }
        //                                     if(array_key_exists('air:PassengerType', $value)){
        //                                         // print_r();
        //                                         $PassengerType=[];
        //                                         foreach($value['air:PassengerType'] as $pc => $jsons17){
        //                                             // print_r($jsons17);
        //                                             // echo "<br/><br/><br/>";
        //                                             if(is_string($jsons17)){
        //                                                 if(strcmp($pc, "@Code") == 0){
        //                                                     $PassengerType["Code"] =$jsons17;
        //                                                 }
        //                                             }
        //                                         }
        //                                     }
        //                                     $details4=[];
        //                                     if(array_key_exists('air:ChangePenalty', $value)){
        //                                         // $details4=[];
        //                                         foreach($value['air:ChangePenalty'] as $jsons17){
        //                                             // print_r($jsons17);
        //                                             // echo "<br/><br/><br/>";
        //                                             foreach($jsons17 as $c=> $jsons18){
        //                                                 if(is_string($jsons18)){
        //                                                     if(strcmp($c, "$") == 0){
        //                                                         $details4["changepenalty"]=$jsons18;
        //                                                     }
        //                                                     // print_r($c."- " .$jsons18);
        //                                                     // echo "<br/><br/><br/>"; 
        //                                                 }
                                                        
        //                                             }
        //                                         }
        //                                     }
        //                                     if(array_key_exists('air:CancelPenalty', $value)){
                                            
        //                                         foreach($value['air:CancelPenalty'] as $jsons19){
        //                                             // print_r($jsons19);
        //                                             // echo "<br/><br/><br/>";
        //                                             foreach($jsons19 as $cc=> $jsons20){
        //                                                 if(is_string($jsons20)){
        //                                                     if(strcmp($cc, "$") == 0){
        //                                                         $details4["cancelpenalty"]=$jsons20;
        //                                                     }
        //                                                     // print_r($c."- " .$jsons20);
        //                                                     // echo "<br/><br/><br/>"; 
        //                                                 }
                                                        
        //                                             }
        //                                         }
        //                                     }
        //                                     if(array_key_exists('air:BaggageAllowances', $value)){
        //                                         // print_r($jsons14['air:BaggageAllowances']);
        //                                         // echo "<br/><br/>";
        //                                         $count17=1;   
        //                                         foreach($value['air:BaggageAllowances'] as $jsons17){
        //                                             // echo $count17;
        //                                             // print_r($jsons17);
        //                                             // echo "<br/><br/><br/>"; 
        //                                             if($count17==2){
        //                                                 // print_r($jsons17);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 $count18=1;
        //                                                 foreach($jsons17 as $jsons18){
        //                                                     // echo $count18;
        //                                                     // print_r($jsons18);
        //                                                     // echo "<br/><br/><br/>";
        //                                                     if($count18==7){
        //                                                         // print_r($jsons18);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         $count19=1;
        //                                                         foreach($jsons18 as $jsons19){
        //                                                             // echo $count19;
        //                                                             // print_r($jsons19);
        //                                                             // echo "<br/><br/><br/>";
        //                                                             if($count19==2){
        //                                                                 // print_r($jsons19);
        //                                                                 // echo "<br/><br/><br/>";
        //                                                                 $count20=1;
        //                                                                 foreach($jsons19 as $jsons20){
        //                                                                     // print_r($jsons20);
        //                                                                     // echo "<br/><br/><br/>";
        //                                                                     if($count20==1){
        //                                                                         // print_r($jsons20);
        //                                                                         // echo "<br/><br/><br/>";
        //                                                                         foreach($jsons20 as $bg=>$jsons21){
        //                                                                             // print_r($jsons21);
        //                                                                             // echo "<br/><br/><br/>";
        //                                                                             if(strcmp($bg, "$") == 0){	
        //                                                                                 $details4["baggageallowanceinfo"]=$jsons21;
        //                                                                             }	
        //                                                                         }
        //                                                                     }
        //                                                                     $count20++;
        //                                                                 }
        //                                                             }
        //                                                             $count19++;
        //                                                         }
        //                                                     }
        //                                                     $count18++;
        //                                                 }
        //                                             }
        //                                             if($count17==3){
        //                                                 // print_r($jsons17);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 $count21=1;
        //                                                 foreach($jsons17 as $jsons18){
        //                                                     // print_r($jsons18);
        //                                                     // echo "<br/><br/><br/>";
        //                                                     // if($count21==5){  //non stop flight  
        //                                                     if($count21==2 && is_array($jsons18)){
        //                                                         // print_r($jsons18);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         $count22=1;
        //                                                         foreach($jsons18 as $jsons19){
        //                                                             // echo $count22;
        //                                                             // print_r($jsons19);
        //                                                             // echo "<br/><br/><br/>"; 
        //                                                             if($count22==5){
        //                                                                 // print_r($jsons19);
        //                                                                 // echo "<br/><br/><br/>";
        //                                                                 $count23=1;
        //                                                                 foreach($jsons19 as $jsons20){
        //                                                                     // print_r($jsons20);
        //                                                                     // echo "<br/><br/><br/>";
        //                                                                     if($count23==2){
        //                                                                         // print_r($jsons20);
        //                                                                         // echo "<br/><br/><br/>"; 
        //                                                                         foreach($jsons20 as $cbb=>$jsons21){
        //                                                                             if(is_string($jsons21)){
        //                                                                                 // print_r($cbb."-".$jsons21);
        //                                                                                 // echo "<br/><br/><br/>";
        //                                                                                 if(strcmp($cbb, "$") == 0){	
        //                                                                                     $details4["carryonallowanceinfo"]=$jsons21;
        //                                                                                 }	
        //                                                                             }
                                                                                    
        //                                                                         }
        //                                                                     }
        //                                                                     $count23++;
        //                                                                 }
        //                                                             }
        //                                                             $count22++;
        //                                                         }
        //                                                     }else{
        //                                                         if($count21==5){
        //                                                             // print_r($jsons18);
        //                                                             // echo "<br/><br/><br/>";
        //                                                             $count25=1;
        //                                                             foreach($jsons18 as $jsons19){
        //                                                                 // print_r($jsons19);
        //                                                                 // echo "<br/><br/><br/>";
        //                                                                 if($count25==2){
        //                                                                     foreach($jsons19 as $cbb => $jsons20){
        //                                                                         // print_r($jsons20);
        //                                                                         // echo "<br/><br/><br/>";
        //                                                                         if(is_string($jsons20)){
        //                                                                             // print_r($cbb."-".$jsons21);
        //                                                                             // echo "<br/><br/><br/>";
        //                                                                             if(strcmp($cbb, "$") == 0){	
        //                                                                                 $details4["carryonallowanceinfo"]=$jsons20;
        //                                                                             }	
        //                                                                         }
        //                                                                     }
        //                                                                 }
        //                                                                 $count25++;
        //                                                             }
        //                                                         }
        //                                                     }
        //                                                     $count21++;
        //                                                 }
        //                                             }
                                                    
        //                                             $count17++;
        //                                         }
        //                                     }

        //                                     // end multiple travel add adult and child

        //                                 }
        //                                 if(empty($AirPricingInfo1) && !empty($AirPricingInfo0)){
        //                                     $AirPricingInfo->push($AirPricingInfo0);
        //                                 }
        //                             }
        //                             if(!empty($AirPricingInfo1)){
        //                                 $AirPricingInfo->push($AirPricingInfo1);
        //                             }
        //                             if(array_key_exists('air:FareInfo', $jsons14)){
        //                                 // print_r($jsons14['air:FareInfo']);
        //                                 // return $jsons14['air:FareInfo'];
        //                                 // $FareInfo1=collect();
        //                                 $FareRuleKey1=collect();
        //                                 $FareInfo1=collect();
        //                                 $FareInfo=[];
        //                                 foreach($jsons14['air:FareInfo'] as $fI => $jsons17){
        //                                     $FareInfo0=[];
        //                                     // echo $count50;
        //                                     // print_r($jsons17);
        //                                     // echo "<br/><br/><br/>";
        //                                     // $FareRuleKey1=collect();
        //                                     if(is_string($jsons17)){
        //                                         // print_r($fI."-".$jsons17);
        //                                         // echo "<br/><br/><br/>";
        //                                         if(strcmp($fI, "@Key") == 0){
        //                                             $FareInfo["Key"] =$jsons17;
        //                                         }
        //                                         if(strcmp($fI, "@FareBasis") == 0){
        //                                             $FareInfo["FareBasis"] =$jsons17;
        //                                         }
        //                                         if(strcmp($fI, "@PassengerTypeCode") == 0){
        //                                             $FareInfo["PassengerTypeCode"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@Origin") == 0){
        //                                             $FareInfo["Origin"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@Destination") == 0){
        //                                             $FareInfo["Destination"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@EffectiveDate") == 0){
        //                                             $FareInfo["EffectiveDate"] =$jsons17;
        //                                         }  
        //                                         if(strcmp($fI, "@DepartureDate") == 0){
        //                                             $FareInfo["DepartureDate"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@Amount") == 0){
        //                                             $FareInfo["Amount"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@NegotiatedFare") == 0){
        //                                             $FareInfo["NegotiatedFare"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@NotValidBefore") == 0){
        //                                             $FareInfo["NotValidBefore"] =$jsons17;
        //                                         } 
        //                                         if(strcmp($fI, "@TaxAmount") == 0){
        //                                             $FareInfo["TaxAmount"] =$jsons17;
        //                                         } 
        //                                     }else{
        //                                         foreach($jsons17 as $fI =>$jsons18){
        //                                             if(is_string($jsons18)){
        //                                                 // print_r($fI."-".$jsons17);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 if(strcmp($fI, "@Key") == 0){
        //                                                     $FareInfo0["Key"] =$jsons18;
        //                                                 }
        //                                                 if(strcmp($fI, "@FareBasis") == 0){
        //                                                     $FareInfo0["FareBasis"] =$jsons18;
        //                                                 }
        //                                                 if(strcmp($fI, "@PassengerTypeCode") == 0){
        //                                                     $FareInfo0["PassengerTypeCode"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@Origin") == 0){
        //                                                     $FareInfo0["Origin"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@Destination") == 0){
        //                                                     $FareInfo0["Destination"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@EffectiveDate") == 0){
        //                                                     $FareInfo0["EffectiveDate"] =$jsons18;
        //                                                 }  
        //                                                 if(strcmp($fI, "@DepartureDate") == 0){
        //                                                     $FareInfo0["DepartureDate"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@Amount") == 0){
        //                                                     $FareInfo0["Amount"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@NegotiatedFare") == 0){
        //                                                     $FareInfo0["NegotiatedFare"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@NotValidBefore") == 0){
        //                                                     $FareInfo0["NotValidBefore"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($fI, "@TaxAmount") == 0){
        //                                                     $FareInfo0["TaxAmount"] =$jsons18;
        //                                                 } 
        //                                             }
        //                                         }
        //                                         // print_r($jsons17['air:FareRuleKey']);
        //                                         // echo "<br/><br/>";
        //                                         if(array_key_exists('air:FareRuleKey', $jsons17)){
        //                                             $FareRuleKey0=[];
        //                                             foreach($jsons17['air:FareRuleKey'] as $frk => $jsons19){
        //                                                 if(is_string($jsons19)){
        //                                                     if(strcmp($frk, "@FareInfoRef") == 0){
        //                                                         $FareRuleKey0["FareInfoRef"] =$jsons19;
        //                                                     } 
        //                                                     if(strcmp($frk, "@ProviderCode") == 0){
        //                                                         $FareRuleKey0["ProviderCode"] =$jsons19;
        //                                                     } 
        //                                                     if(strcmp($frk, "$") == 0){
        //                                                         $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
        //                                                     } 
        //                                                 }
        //                                             }
        //                                             $FareRuleKey1->push($FareRuleKey0);
        //                                         }
        //                                     }

        //                                     if(empty($FareInfo) && !empty($FareInfo0)){
        //                                         $FareInfo1->push($FareInfo0);
        //                                     }
        //                                     // $FareRuleKey1=collect();
        //                                     if(array_key_exists('air:FareRuleKey', $jsons14['air:FareInfo'])){
        //                                         // print_r($jsons14['air:FareInfo']['air:FareRuleKey']);
        //                                         $FareRuleKey=[];
                                                
        //                                         foreach($jsons14['air:FareInfo']['air:FareRuleKey'] as $frk => $jsons18){
        //                                             // print_r($jsons18);
        //                                             // echo "<br/><br/><br/>";
        //                                             $FareRuleKey0=[];
        //                                             if(is_string($jsons18)){
        //                                                 // print_r($frk." - ".$jsons18);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 if(strcmp($frk, "@FareInfoRef") == 0){
        //                                                     $FareRuleKey["FareInfoRef"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($frk, "@ProviderCode") == 0){
        //                                                     $FareRuleKey["ProviderCode"] =$jsons18;
        //                                                 } 
        //                                                 if(strcmp($frk, "$") == 0){
        //                                                     $FareRuleKey["FareRuleKeyValue"] =$jsons18;
        //                                                 } 
        //                                             }else{
        //                                                 foreach($jsons18 as $frk => $jsons19){
        //                                                     if(is_string($jsons19)){
        //                                                         // print_r($frk." - ".$jsons18);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         if(strcmp($frk, "@FareInfoRef") == 0){
        //                                                             $FareRuleKey0["FareInfoRef"] =$jsons19;
        //                                                         } 
        //                                                         if(strcmp($frk, "@ProviderCode") == 0){
        //                                                             $FareRuleKey0["ProviderCode"] =$jsons19;
        //                                                         } 
        //                                                         if(strcmp($frk, "$") == 0){
        //                                                             $FareRuleKey0["FareRuleKeyValue"] =$jsons19;
        //                                                         } 
        //                                                     }
        //                                                 }
        //                                                 // if(empty($FareRuleKey) && !empty($FareRuleKey0)){
        //                                                 //     $FareRuleKey1->push($FareRuleKey0);
        //                                                 // }
        //                                             }
        //                                         }
        //                                         // if(!empty($FareRuleKey)){
        //                                         //     $FareRuleKey1->push($FareRuleKey);
        //                                         // }
        //                                     }
        //                                 }
        //                                 if(!empty($FareInfo)){
        //                                     $FareInfo1->push($FareInfo);
        //                                 }
        //                                 if(!empty($FareRuleKey)){
        //                                     $FareRuleKey1->push($FareRuleKey);
        //                                 }
                                        
                                        
        //                             }
        //                             if(array_key_exists('air:BookingInfo', $jsons14)){
        //                                 $BookingInfo1=collect();
        //                                 $BookingInfo=[];
        //                                 foreach($jsons14['air:BookingInfo'] as $bki => $jsons17){
        //                                     $BookingInfo0=[];
        //                                     // print_r($jsons17);
        //                                     // echo "<br/><br/><br/>";
        //                                     if(is_string($jsons17)){
        //                                         // print_r($bki."-".$jsons17);
        //                                         // echo "<br/><br/><br/>";
        //                                         if(strcmp($bki, "@BookingCode") == 0){
        //                                             $BookingInfo["BookingCode"] =$jsons17;
        //                                         }
        //                                         if(strcmp($bki, "@CabinClass") == 0){
        //                                             $BookingInfo["CabinClass"] =$jsons17;
        //                                         }
        //                                         if(strcmp($bki, "@FareInfoRef") == 0){
        //                                             $BookingInfo["FareInfoRef"] =$jsons17;
        //                                         }
        //                                         if(strcmp($bki, "@SegmentRef") == 0){
        //                                             $BookingInfo["SegmentRef"] =$jsons17;
        //                                         }
        //                                         if(strcmp($bki, "@HostTokenRef") == 0){
        //                                             $BookingInfo["HostTokenRef"] =$jsons17;
        //                                         }
        //                                     }else{
        //                                         foreach($jsons17 as $bki => $jsons18){
        //                                             if(is_string($jsons18)){
        //                                                 // print_r($bki."-".$jsons17);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 if(strcmp($bki, "@BookingCode") == 0){
        //                                                     $BookingInfo0["BookingCode"] =$jsons18;
        //                                                 }
        //                                                 if(strcmp($bki, "@CabinClass") == 0){
        //                                                     $BookingInfo0["CabinClass"] =$jsons18;
        //                                                 }
        //                                                 if(strcmp($bki, "@FareInfoRef") == 0){
        //                                                     $BookingInfo0["FareInfoRef"] =$jsons18;
        //                                                 }
        //                                                 if(strcmp($bki, "@SegmentRef") == 0){
        //                                                     $BookingInfo0["SegmentRef"] =$jsons18;
        //                                                 }
        //                                                 if(strcmp($bki, "@HostTokenRef") == 0){
        //                                                     $BookingInfo0["HostTokenRef"] =$jsons18;
        //                                                 }
        //                                             }
        //                                         } 
        //                                     }
        //                                     if(empty($BookingInfo) && !empty($BookingInfo0)){
        //                                         $BookingInfo1->push($BookingInfo0);
        //                                     }
        //                                 }
        //                                 if(!empty($BookingInfo)){
        //                                     $BookingInfo1->push($BookingInfo);
        //                                 }
        //                             }
        //                             if(array_key_exists('air:TaxInfo', $jsons14)){
        //                                 $TaxInfo=collect();
        //                                 $TaxInfo1=[];
        //                                 foreach($jsons14['air:TaxInfo'] as $jsons17){
        //                                     // print_r($jsons17);
        //                                     // echo "<br/><br/><br/>";
        //                                     foreach($jsons17 as $tki => $jsons18){
        //                                         if(is_string($jsons18)){
        //                                             // print_r($tki."-".$jsons18);
        //                                             // echo "<br/><br/><br/>";
        //                                             if(strcmp($tki, "@Category") == 0){
        //                                                 $TaxInfo1["Category"] =$jsons18;
        //                                             }
        //                                             if(strcmp($tki, "@Amount") == 0){
        //                                                 $TaxInfo1["Amount"] =$jsons18;
        //                                             }
        //                                             if(strcmp($tki, "@Key") == 0){
        //                                                 $TaxInfo1["Key"] =$jsons18;
        //                                             }
                                                
        //                                         }
        //                                     }
        //                                     $TaxInfo->push($TaxInfo1);
        //                                 }
        //                             }
        //                             if(array_key_exists('air:FareCalc', $jsons14)){
        //                                 $FareCalc=[];
        //                                 foreach($jsons14['air:FareCalc'] as $fcc => $jsons17){
        //                                     // print_r($jsons17);
        //                                     if(is_string($jsons17)){
        //                                         if(strcmp($fcc, "$") == 0){
        //                                             $FareCalc["FareCalc"] =$jsons17;
        //                                         }
        //                                     }
        //                                 }
        //                             }
        //                             if(array_key_exists('air:PassengerType', $jsons14)){
        //                                 // print_r();
        //                                 $PassengerType=[];
        //                                 foreach($jsons14['air:PassengerType'] as $pc => $jsons17){
        //                                     // print_r($jsons17);
        //                                     // echo "<br/><br/><br/>";
        //                                     if(is_string($jsons17)){
        //                                         if(strcmp($pc, "@Code") == 0){
        //                                             $PassengerType["Code"] =$jsons17;
        //                                         }
        //                                     }
        //                                 }
        //                             }
        //                             // $details4=[];
        //                             if(array_key_exists('air:ChangePenalty', $jsons14)){
        //                                 $details4=[];
        //                                 foreach($jsons14['air:ChangePenalty'] as $jsons17){
        //                                     // print_r($jsons17);
        //                                     // echo "<br/><br/><br/>";
        //                                     foreach($jsons17 as $c=> $jsons18){
        //                                         if(is_string($jsons18)){
        //                                             if(strcmp($c, "$") == 0){
        //                                                 $details4["changepenalty"]=$jsons18;
        //                                             }
        //                                             // print_r($c."- " .$jsons18);
        //                                             // echo "<br/><br/><br/>"; 
        //                                         }
                                                
        //                                     }
        //                                 }
        //                             }
        //                             if(array_key_exists('air:CancelPenalty', $jsons14)){
                                       
        //                                 foreach($jsons14['air:CancelPenalty'] as $jsons19){
        //                                     // print_r($jsons19);
        //                                     // echo "<br/><br/><br/>";
        //                                     foreach($jsons19 as $cc=> $jsons20){
        //                                         if(is_string($jsons20)){
        //                                             if(strcmp($cc, "$") == 0){
        //                                                 $details4["cancelpenalty"]=$jsons20;
        //                                             }
        //                                             // print_r($c."- " .$jsons20);
        //                                             // echo "<br/><br/><br/>"; 
        //                                         }
                                                
        //                                     }
        //                                 }
        //                             }
        //                             if(array_key_exists('air:BaggageAllowances', $jsons14)){
        //                                 // print_r($jsons14['air:BaggageAllowances']);
        //                                 // return $jsons14['air:BaggageAllowances'];
        //                                 // echo "<br/><br/>";
        //                                 $count17=1;   
        //                                 foreach($jsons14['air:BaggageAllowances'] as $jsons17){
        //                                     // echo $count17;
        //                                     // print_r($jsons17);
        //                                     // echo "<br/><br/><br/>"; 
        //                                     if($count17==2){
        //                                         // print_r($jsons17);
        //                                         // echo "<br/><br/><br/>";
        //                                         $count18=1;
        //                                         foreach($jsons17 as $jsons18){
        //                                             // echo $count18;
        //                                             // print_r($jsons18);
        //                                             // echo "<br/><br/><br/>";
        //                                             if($count18==7){
        //                                                 // print_r($jsons18);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 $count19=1;
        //                                                 foreach($jsons18 as $jsons19){
        //                                                     // echo $count19;
        //                                                     // print_r($jsons19);
        //                                                     // echo "<br/><br/><br/>";
        //                                                     if($count19==2){
        //                                                         // print_r($jsons19);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         $count20=1;
        //                                                         foreach($jsons19 as $jsons20){
        //                                                             // print_r($jsons20);
        //                                                             // echo "<br/><br/><br/>";
        //                                                             if($count20==1){
        //                                                                 // print_r($jsons20);
        //                                                                 // echo "<br/><br/><br/>";
        //                                                                 foreach($jsons20 as $bg=>$jsons21){
        //                                                                     // print_r($jsons21);
        //                                                                     // echo "<br/><br/><br/>";
        //                                                                     if(strcmp($bg, "$") == 0){	
        //                                                                         $details4["baggageallowanceinfo"]=$jsons21;
        //                                                                     }	
        //                                                                 }
        //                                                             }
        //                                                             $count20++;
        //                                                         }
        //                                                     }
        //                                                     $count19++;
        //                                                 }
        //                                             }
        //                                             $count18++;
        //                                         }
        //                                     }
        //                                     if($count17==3){
        //                                         // print_r($jsons17);
        //                                         // echo "<br/><br/><br/>";
        //                                         $count21=1;
        //                                         foreach($jsons17 as $jsons18){
        //                                             // print_r($jsons18);
        //                                             // echo "<br/><br/><br/>";
        //                                             // if($count21==5){  //non stop flight  
        //                                             if($count21==2 && is_array($jsons18)){
        //                                                 // print_r($jsons18);
        //                                                 // echo "<br/><br/><br/>";
        //                                                 $count22=1;
        //                                                 foreach($jsons18 as $jsons19){
        //                                                     // echo $count22;
        //                                                     // print_r($jsons19);
        //                                                     // echo "<br/><br/><br/>"; 
        //                                                     if($count22==5){
        //                                                         // print_r($jsons19);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         $count23=1;
        //                                                         foreach($jsons19 as $jsons20){
        //                                                             // print_r($jsons20);
        //                                                             // echo "<br/><br/><br/>";
        //                                                             if($count23==2){
        //                                                                 // print_r($jsons20);
        //                                                                 // echo "<br/><br/><br/>"; 
        //                                                                 foreach($jsons20 as $cbb=>$jsons21){
        //                                                                     if(is_string($jsons21)){
        //                                                                         // print_r($cbb."-".$jsons21);
        //                                                                         // echo "<br/><br/><br/>";
        //                                                                         if(strcmp($cbb, "$") == 0){	
        //                                                                             $details4["carryonallowanceinfo"]=$jsons21;
        //                                                                         }	
        //                                                                     }
                                                                            
        //                                                                 }
        //                                                             }
        //                                                             $count23++;
        //                                                         }
        //                                                     }
        //                                                     $count22++;
        //                                                 }
        //                                             }else{
        //                                                 if($count21==5){
        //                                                     // print_r($jsons18);
        //                                                     // echo "<br/><br/><br/>";
        //                                                     $count25=1;
        //                                                     foreach($jsons18 as $jsons19){
        //                                                         // print_r($jsons19);
        //                                                         // echo "<br/><br/><br/>";
        //                                                         if($count25==2){
        //                                                             foreach($jsons19 as $cbb => $jsons20){
        //                                                                 // print_r($jsons20);
        //                                                                 // echo "<br/><br/><br/>";
        //                                                                 if(is_string($jsons20)){
        //                                                                     // print_r($cbb."-".$jsons21);
        //                                                                     // echo "<br/><br/><br/>";
        //                                                                     if(strcmp($cbb, "$") == 0){	
        //                                                                         $details4["carryonallowanceinfo"]=$jsons20;
        //                                                                     }	
        //                                                                 }
        //                                                             }
        //                                                         }
        //                                                         $count25++;
        //                                                     }
        //                                                 }
        //                                             }
        //                                             $count21++;
        //                                         }
        //                                     }
                                            
        //                                     $count17++;
        //                                 }
        //                             }
        //                             $data->push(["details"=>$details4]);
        //                         }
        //                         $data->push(["price"=>collect($price)]);     
        //                         $data->push(["AirPricingInfo"=>collect($AirPricingInfo)]);     
        //                         $data->push(["FareInfo"=>$FareInfo1]);
        //                         $data->push(["FareRuleKey"=>$FareRuleKey1]);
        //                         $data->push(["BookingInfo"=>$BookingInfo1]);

        //                         $HostToken=collect();
        //                         if(array_key_exists('common_v42_0:HostToken',$jsons2['air:AirPriceResult']['air:AirPricingSolution'][0])){
        //                             // return $jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['common_v42_0:HostToken'];
        //                             $HostToken1=[];
        //                             foreach($jsons2['air:AirPriceResult']['air:AirPricingSolution'][0]['common_v42_0:HostToken'] as $key => $value){
        //                                 $HostToken0=[];
        //                                 if(is_string($value)){
        //                                     if(strcmp($key, "@Key") == 0){
        //                                         $HostToken1["Key"]=$value;
        //                                     }
        //                                     if(strcmp($key, "$") == 0){
        //                                         $HostToken1["HostTokenvalue"]=$value;
        //                                     }
        //                                 }else{
        //                                     foreach($value as $key => $value1){
        //                                         if(is_string($value1)){
        //                                             if(strcmp($key, "@Key") == 0){
        //                                                 $HostToken0["Key"]=$value1;
        //                                             }
        //                                             if(strcmp($key, "$") == 0){
        //                                                 $HostToken0["HostTokenvalue"]=$value1;
        //                                             }
        //                                         }
        //                                     }
        //                                 }
        //                                 if($HostToken0!=null){
        //                                     $HostToken->push($HostToken0);
        //                                 }
        //                             }
        //                             if($HostToken1!=null){
        //                                 $HostToken->push($HostToken1);
        //                             }
        //                         }
        //                         $data->push(["HostToken"=>collect($HostToken)]);     
        //                         $data->push(["TaxInfo"=>$TaxInfo]);
        //                         $data->push(["FareCalc"=>$FareCalc]);
        //                         $data->push(["PassengerType"=>$PassengerType]);

        //                     }
                            
        //                 }
        //             } 

        //         }
        //     }
        // }

        $data =app('App\Http\Controllers\XMlToParseDataController')->AirPrice($object);
        // return $data;


        // echo $data[1]['details']['changepenalty'];
        // echo $data[1]['details']['cancelpenalty'];
        // echo $data[1]['details']['baggageallowanceinfo'];
        // echo $data[1]['details']['carryonallowanceinfo'];

       
        // echo $data[0]['journey'];
        // echo count($data[0]);
        // foreach($data[0] as $datas){
        //     echo count($datas);
        //     for ($i=0; $i < count($datas); $i++) { 
        //         echo $datas[$i]['key'];
        //     }
        // }
        // return $data;
        return view('flights.flight-details',[
            'per_flight_details'=>$request,
            'data'=>$data
        ]);
        // return view('flights.flight-details');
    }

    


    public function Stops($data,$direct_flight,$flexi){
        $stops= [];
        foreach($data as $datas){
            foreach($datas as $datass){
                foreach($datass[0] as $journeys){
                    if($direct_flight=="DF" && count($journeys)>1 && $flexi=="")
                    {
                        continue;
                    }elseif ($direct_flight=="" && count($journeys)==1 && $flexi=="F") {
                        continue;
                    }
                    array_push($stops,count($journeys)-1);
                }
            }
        }
        $stops = array_unique($stops);
        return $stops;
    }
    public function Airline($data,$direct_flight,$flexi){
        $airlines = [];
        foreach($data as $datas){
            foreach($datas as $datass){
                foreach($datass[0] as $journeys){
                    for ($i=0; $i < count($journeys); $i++) { 
                    if($direct_flight=="DF" && count($journeys)>1 && $flexi=="")
                    {
                        continue;
                    }elseif ($direct_flight=="" && count($journeys)==1 && $flexi=="F") {
                        continue;
                    }
                        array_push($airlines,$journeys[$i]['Airline']);
                    }
                }
            }
        }
        $airlines = array_unique($airlines);
        return $airlines;
    }

    public function SOAPFault($content){
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);
        if(!$xml){
            trigger_error("Encoding Error!", E_USER_ERROR);
        }

        $Results = $xml->children('SOAP',true);
        foreach($Results->children('SOAP',true) as $fault){
            if(strcmp($fault->getName(),'Fault') == 0){
                // trigger_error("Error occurred request/response processing!", E_USER_ERROR);
                return "SOAP Fault";
            }
        }
        return $Results;
    }

    public function parseOutputSingle($content){	//parse the Search response to get values to use in detail request
        $data = collect();
        $LowFareSearchRsp = $content; //use this if response is not saved anywhere else use above variable
        //echo $LowFareSearchRsp;
        // return $LowFareSearchRsp;
        $xml = simplexml_load_String("$LowFareSearchRsp", null, null, 'SOAP', true);
        // $json = json_encode($xml);
        // return $json;
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
         //return $Results;
        foreach($Results->children('air',true) as $airpricersp){
            // if(strcmp($airpricersp->getName(),'Airitinerary') == -32){	
            foreach($airpricersp->children('air',true) as $a=> $airpricerspdel){
                $AirItinerary= collect();
               
                if(strcmp($airpricerspdel->getName(),'AirItinerary') == 0){
                    // return "hii";
                    foreach($airpricerspdel->children('air',true) as $Airitinerary){
                        $AirSegmentS=collect();
                        if(strcmp($Airitinerary->getName(),'AirSegment') == 0){
                            foreach($airpricerspdel->children('air',true) as $AirSegment){
                                $details=[];
					            foreach($AirSegment->attributes() as $e => $f){
                                    $details[$e] = $f;
                                    
                                }
                                $AirSegmentS->push($details);
                            }
                        
                      
                        }   
                    
                    }
                    // $data->push(["AirSegment"=>collect($AirSegmentS)]);     
                }
                
               // return $AirItinerary;
                $pricedetilas=collect();
                if(strcmp($airpricerspdel->getName(),'AirPriceResult') == 0){
                    foreach($airpricerspdel->children('air',true) as $airpricingsolution){
                         //return $airpricingsolution->getName();
                        if(strcmp($airpricingsolution->getName(),'AirPricingSolution') == 0){
                        $Countairsegmentref=0;
                        foreach($airpricingsolution->children('air',true) as $airsegmentref){
                            $Countairsegmentref+=1;
                            if(strcmp($airsegmentref->getName(),'AirSegmentRef') == 0 && $Countairsegmentref==1){

                                $Countsss="";
                                 $Countsss.=$airsegmentref->getName()." ";
                                foreach($airsegmentref->children('air',true) as $airsegmentrefS){
                                return $airsegmentrefS->getName();
                                // $Countsss ++;
                                }
                                return $Countsss;
                            }
                            
                        }
                       
                     }
                    }
                }
                
            }
           
        }
         
        //return $data;

    }

    public function XMLData($object){
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
                                                // return $data;
                                                return view('flights.flight-details',[
                                                    'per_flight_details'=>$request,
                                                    'data'=>$data
                                                ]);
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
