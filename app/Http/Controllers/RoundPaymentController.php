<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Carbon;
use App\Models\Leads;
use App\Models\client;
use App\Models\invoice;
use App\Models\User;
use App\Models\settings;
use App\Models\Flight;
use App\Models\Passenger;

use Mail;
use App\Mail\SendCredentialsEmail;

class RoundPaymentController extends Controller
{
    public function PaymentCredit(Request $request){
        // return $request;

        $converted=Leads::where('email',$request->email)->value('converted');
        if ($converted==1) {
            // return $converted."  if";
            $client_id=Leads::where('email',$request->email)->value('client_id');
            $unique_id = client::where('id',$client_id)->value('unique_id');
            // return $client_id;
            // "receiver_name": "304", clients_id

        }else{
            // return $request;
            // return $converted."  else";
            $lead_id=Leads::where('email',$request->email)->value('id');
            // return $lead_id;
            $client = new client;
            
            $test_client = client::where('unique_id','CLDC0001')->get();
            if ($test_client->count()>0) {
                $latest = client::orderBy('id','desc')->take(1)->get();
                $client_prev_no = $latest[0]->unique_id;
                $unique_id = 'CLDC000'.(substr($client_prev_no,4,7)+1);
            }else{
                $unique_id = 'CLDC0001';
            }
            
            $client->unique_id = $unique_id;
            // $client->creator_id = Auth::user()->id;
            $client->first_name = $request->first_name1;
            $client->last_name = $request->last_name1;
            $client->address = $request->add_1.", ".$request->add_2;
            $client->postal_code = $request->postcode;
            $client->city = $request->city;
            // $client->county = $request->county;
            $client->country = $request->country;
            $client->DOB = Carbon::parse($request->date_of_birth1)->format('d-m-Y');
            $client->email = $request->email;
            $client->phone = $request->mob_no;
            $client->permanent = 0;
            $client->client_type = $request->client_type;
            $client->save();

            // $request->lead_id  // mean id
            $lead = Leads::find($lead_id);
            $lead->client_id = $client->id;
            $lead->converted = 1;
            $lead->save();

            $client = client::where('email',$request->email)->take(1)->get();
            $user = new User;
            $user->name = $client[0]->first_name ." ". $client[0]->last_name;
            $user->email = $client[0]->email;
            $user->password = bcrypt('pass@123');
            
            // $user->assignRole('Client');
            $user->save();
            $client[0]->user_id = $user->id;
            $client[0]->save();
            // $invite->delete();
            DB::table('model_has_roles')->insert([
                'role_id' => 11,
                'model_type'=>'App\User',
                'model_id' => $user->id,
            ]);

            $email=$request->email;
            $LeaderName=$request->first_name1." ".$request->last_name1;
            // Mail::to($email)->send(new SendCredentialsEmail($LeaderName,$email));

            $client_id=isset($client->id)?$client->id:$client[0]->id;
            // return $client_id;
        }

        
        









        // return $request;
        $flight=json_decode($request->return_flight, true);
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
            }
        }
        // return count($journeys);

        // AirPricingInfo 
        // return $flight;
        $var_adults=$request->adults;
        $var_children=$request->children;
        $var_infant=$request->infant;
        $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo='';
        foreach($flight[3] as $AirPricingInfo){
            for ($i=0; $i < count($AirPricingInfo); $i++) {
                // echo $AirPricingInfo[$i]['TotalPrice'];
                // FareInfo
                foreach($flight[4] as $FareInfo){
                    // FareRuleKey
                    foreach($flight[5] as $FareRuleKey){
                        // BookingInfo 
                        foreach($flight[6] as $BookingInfo){
                            if(count($journeys)>1) {
                                // return "hii";
                                $var1='<air:AirPricingInfo PricingMethod="Auto" Key="'.$AirPricingInfo[$i]['Key'].'" TotalPrice="'.$AirPricingInfo[$i]['TotalPrice'].'" BasePrice="'.$AirPricingInfo[$i]['BasePrice'].'" ApproximateTotalPrice="'.$AirPricingInfo[$i]['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$AirPricingInfo[$i]['ApproximateBasePrice'].'" Taxes="'.$AirPricingInfo[$i]['Taxes'].'" ProviderCode="'.$AirPricingInfo[$i]['ProviderCode'].'">';
                                
                                if(count($journeys)==2){ 
                                    // return "hii2" ;
                                    // if(isset($FareInfo[($i)]['Key']) && isset($FareRuleKey[($i)]['FareInfoRef']) && isset($BookingInfo[($i*2)]['BookingCode'])){
                                    //     // return "hii";
                                    //     $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i)]['DepartureDate'].'" Amount="'.$FareInfo[($i)]['Amount'].'" EffectiveDate="'.$FareInfo[($i)]['EffectiveDate'].'" Destination="'.$FareInfo[($i)]['Destination'].'" Origin="'.$FareInfo[($i)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i)]['ProviderCode'].'">'.$FareRuleKey[($i)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                    // ';
                                    // }
                                    if(isset($FareInfo[($i*2)]['Key']) && isset($FareInfo[(($i*2)+1)]['Key'])){
                                        $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    </air:FareInfo>
                                    <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*2)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*2)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*2)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*2)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*2)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*2)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*2)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*2)+1)]['FareBasis'].'">
                                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*2)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*2)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*2)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    </air:FareInfo>
                                    <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                    <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                    ';
                                    }
                                    // else if(isset($FareInfo[($i*2)]['Key']) && isset($FareInfo[(($i*2)+1)]['Key'])){
                                    //     $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*2)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*2)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*2)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*2)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*2)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*2)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*2)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*2)+1)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*2)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*2)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*2)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*2)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*2)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*2)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*2)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*2)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*2)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*2)+1)]['HostTokenRef'].'" />
                                    // ';
                                    // }
                                    else{
                                        // return "else";
                                        return $this->BookingFailedResponce($request);
                                        
                                    }
                                    
                                }else{
                                    // }else if(count($journeys)==3){
                                    // $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*3)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*3)]['DepartureDate'].'" Amount="'.$FareInfo[($i*3)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*3)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*3)]['Destination'].'" Origin="'.$FareInfo[($i*3)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*3)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*3)]['FareBasis'].'">
                                    // <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*3)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*3)]['ProviderCode'].'">'.$FareRuleKey[($i*3)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*3)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*3)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*3)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*3)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*3)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*3)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*3)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*3)+1)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*3)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*3)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*3)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*3)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*3)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*3)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*3)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*3)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*3)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*3)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*3)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*3)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*3)+1)]['HostTokenRef'].'" />
                                    // '; 
                                    $journeyCount=count($journeys);
                                    // $journeyCount=count($AirPricingInfo);
                                    // return "hii3";
                                    // return $journeyCount;
                                    // return $flight;

                                    if(isset($FareInfo[($i*2)]['Key']) && isset($FareInfo[(($i*2)+1)]['Key'])){
                                        $fare_info='';
                                            $fare_info1='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*2)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*2)]['DepartureDate'].'" Amount="'.$FareInfo[($i*2)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*2)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*2)]['Destination'].'" Origin="'.$FareInfo[($i*2)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*2)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*2)]['FareBasis'].'">
                                        <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*2)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*2)]['ProviderCode'].'">'.$FareRuleKey[($i*2)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                        </air:FareInfo>
                                        <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*2)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*2)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*2)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*2)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*2)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*2)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*2)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*2)+1)]['FareBasis'].'">
                                            <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*2)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*2)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*2)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                        </air:FareInfo>';
                                        $bbb_info='';
                                        for ($m=0; $m <$journeyCount ; $m++) { 
                                            $bbb_info.='<air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+$m)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+$m)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+$m)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+$m)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+$m)]['HostTokenRef'].'" />';
                                        }
                                        // $bbb_info='<air:BookingInfo BookingCode="'.$BookingInfo[($i*$journeyCount)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*$journeyCount)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*$journeyCount)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*$journeyCount)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*$journeyCount)]['HostTokenRef'].'" />
                                        // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+1)]['HostTokenRef'].'" />
                                        // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+2)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+2)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+2)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+2)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+2)]['HostTokenRef'].'" />
                                        // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+3)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+3)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+3)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+3)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+3)]['HostTokenRef'].'" />
                                        // '; 
                                        $fare_info=$fare_info1.$bbb_info;
                                    }
                                    // else if(isset($FareInfo[($i*$journeyCount)]['Key']) && isset($FareInfo[(($i*$journeyCount)+1)]['Key'])){
                                    //     $fare_info='<air:FareInfo PromotionalFare="false" Key="'.$FareInfo[($i*$journeyCount)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[($i*$journeyCount)]['DepartureDate'].'" Amount="'.$FareInfo[($i*$journeyCount)]['Amount'].'" EffectiveDate="'.$FareInfo[($i*$journeyCount)]['EffectiveDate'].'" Destination="'.$FareInfo[($i*$journeyCount)]['Destination'].'" Origin="'.$FareInfo[($i*$journeyCount)]['Origin'].'" PassengerTypeCode="'.$FareInfo[($i*$journeyCount)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[($i*$journeyCount)]['FareBasis'].'">
                                    // <air:FareRuleKey FareInfoRef="'.$FareRuleKey[($i*$journeyCount)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[($i*$journeyCount)]['ProviderCode'].'">'.$FareRuleKey[($i*$journeyCount)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[(($i*$journeyCount)+1)]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[(($i*$journeyCount)+1)]['DepartureDate'].'" Amount="'.$FareInfo[(($i*$journeyCount)+1)]['Amount'].'" EffectiveDate="'.$FareInfo[(($i*$journeyCount)+1)]['EffectiveDate'].'" Destination="'.$FareInfo[(($i*$journeyCount)+1)]['Destination'].'" Origin="'.$FareInfo[(($i*$journeyCount)+1)]['Origin'].'" PassengerTypeCode="'.$FareInfo[(($i*$journeyCount)+1)]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[(($i*$journeyCount)+1)]['FareBasis'].'">
                                    //     <air:FareRuleKey FareInfoRef="'.$FareRuleKey[(($i*$journeyCount)+1)]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[(($i*$journeyCount)+1)]['ProviderCode'].'">'.$FareRuleKey[(($i*$journeyCount)+1)]['FareRuleKeyValue'].'</air:FareRuleKey>
                                    // </air:FareInfo>
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[($i*$journeyCount)]['BookingCode'].'" CabinClass="'.$BookingInfo[($i*$journeyCount)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[($i*$journeyCount)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[($i*$journeyCount)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[($i*$journeyCount)]['HostTokenRef'].'" />
                                    // <air:BookingInfo BookingCode="'.$BookingInfo[(($i*$journeyCount)+1)]['BookingCode'].'" CabinClass="'.$BookingInfo[(($i*$journeyCount)+1)]['CabinClass'].'" FareInfoRef="'.$BookingInfo[(($i*$journeyCount)+1)]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[(($i*$journeyCount)+1)]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[(($i*$journeyCount)+1)]['HostTokenRef'].'" />
                                    // '; 
                                    // }
                                    else{
                                        return $this->BookingFailedResponce($request);
                                        
                                    }
                                }
                                $var_adtcount='';
                                if ($i==0) {
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="ADT" BookingTravelerRef="ADT'.$j.'" />';
                                    }
                                }
                                if($i==1){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="CNN" BookingTravelerRef="CNN'.$j.'" />';
                                    } 
                                }
                                if($i==2){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="INF" BookingTravelerRef="INF'.$j.'"/>';
                                    } 
                                }
                                $var2='</air:AirPricingInfo>';
                                $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.=$var1.$fare_info.$var_adtcount.$var2;
                                // return $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo;
                            }else{
                                $var1='<air:AirPricingInfo PricingMethod="Auto" Key="'.$AirPricingInfo[$i]['Key'].'" TotalPrice="'.$AirPricingInfo[$i]['TotalPrice'].'" BasePrice="'.$AirPricingInfo[$i]['BasePrice'].'" ApproximateTotalPrice="'.$AirPricingInfo[$i]['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$AirPricingInfo[$i]['ApproximateBasePrice'].'" Taxes="'.$AirPricingInfo[$i]['Taxes'].'" ProviderCode="'.$AirPricingInfo[$i]['ProviderCode'].'">
                                <air:FareInfo PromotionalFare="false" Key="'.$FareInfo[$i]['Key'].'" FareFamily="Economy Saver" DepartureDate="'.$FareInfo[$i]['DepartureDate'].'" Amount="'.$FareInfo[$i]['Amount'].'" EffectiveDate="'.$FareInfo[$i]['EffectiveDate'].'" Destination="'.$FareInfo[$i]['Destination'].'" Origin="'.$FareInfo[$i]['Origin'].'" PassengerTypeCode="'.$FareInfo[$i]['PassengerTypeCode'].'" FareBasis="'.$FareInfo[$i]['FareBasis'].'">
                                    <air:FareRuleKey FareInfoRef="'.$FareRuleKey[$i]['FareInfoRef'].'" ProviderCode="'.$FareRuleKey[$i]['ProviderCode'].'">'.$FareRuleKey[$i]['FareRuleKeyValue'].'</air:FareRuleKey>
                                </air:FareInfo>
                                <air:BookingInfo BookingCode="'.$BookingInfo[$i]['BookingCode'].'" CabinClass="'.$BookingInfo[$i]['CabinClass'].'" FareInfoRef="'.$BookingInfo[$i]['FareInfoRef'].'" SegmentRef="'.$BookingInfo[$i]['SegmentRef'].'" HostTokenRef="'.$BookingInfo[$i]['HostTokenRef'].'" />
                                ';
                                $var_adtcount='';
                                if ($i==0) {
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="ADT" BookingTravelerRef="ADT'.$j.'" />';
                                    }
                                }
                                if($i==1){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="CNN" BookingTravelerRef="CNN'.$j.'" />';
                                    } 
                                }
                                if($i==2){
                                    for ($j=1; $j <= $var_adults; $j++) { 
                                        $var_adtcount.='<air:PassengerType Code="INF" BookingTravelerRef="INF'.$j.'" />';
                                    } 
                                }
                                $var2='</air:AirPricingInfo>';
                                $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.=$var1.$var_adtcount.$var2;
                            }
                        }
                    }
                }
            }
        }
        // return $var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo;

        
        // host token 
        // return $flight;
        $hostToken='';
        foreach($flight[7] as $hashToken){
            // print_r($hashToken);
            // echo "<br/><br/>";
            for ($i=0; $i < count($hashToken); $i++) {
                // echo $hashToken[$i]['Key'];
                $hostToken.='<HostToken Key="'.$hashToken[$i]['Key'].'" xmlns="http://www.travelport.com/schema/common_v42_0">'.$hashToken[$i]['HostTokenvalue'].'</HostToken>';
            }
        }
        // return $hostToken;

        $booking_traveler_details='';
        for ($j=1; $j <= $var_adults; $j++) { 
            $title = "title".$j;
            $first_name = "first_name".$j;
            $last_name = "last_name".$j;
            $gender = "gender".$j;
            $date_of_birth = "date_of_birth".$j;
            $seating = "seating".$j;
            $assistance = "assistance".$j;
            $meal = "meal".$j;

            if ($request->gender=="Male") {
                $gender="M";
            }else{
                $gender="F"; 
            }
            // return $request->$title ;
            $booking_traveler_details.='<com:BookingTraveler Key="ADT'.$j.'" TravelerType="ADT" DOB="'.date("Y-m-d",strtotime($request->$date_of_birth)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BookingTravelerName Prefix="'.$request->$title.'" First="'.$request->$first_name.'" Last="'.$request->$last_name.'"/>
            <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="'.$request->email.'"/>
            <com:SSR Type="DOCS" Carrier="AI" FreeText=""/>
            <com:Address>
                <com:AddressName>'.$request->add_1.'</com:AddressName>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:City>'.$request->city.'</com:City>
                <com:State>'.$request->state_code.'</com:State>
                <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                <com:Country>IN</com:Country>
            </com:Address>
            </com:BookingTraveler>';
        }
        for ($j=1; $j <= $var_children; $j++) { 
            $title = "children_title".$j;
            $first_name = "children_first_name".$j;
            $last_name = "children_last_name".$j;
            $gender = "children_gender".$j;
            $date_of_birth = "children_date_of_birth".$j;
            $seating = "children_seating".$j;
            $assistance = "children_assistance".$j;
            $meal = "children_meal".$j;

            if ($request->gender=="Male") {
                $gender="M";
            }else{
                $gender="F"; 
            }

            $booking_traveler_details.='<com:BookingTraveler Key="CNN'.$j.'" TravelerType="CNN" DOB="'.date("Y-m-d",strtotime($request->$date_of_birth)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BookingTravelerName Prefix="'.$request->$title.'" First="'.$request->$first_name.'" Last="'.$request->$last_name.'"/>
            <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="'.$request->email.'"/>
            <com:SSR Type="DOCS" Carrier="AI" FreeText=""/>
            <com:Address>
                <com:AddressName>'.$request->add_1.'</com:AddressName>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:City>'.$request->city.'</com:City>
                <com:State>'.$request->state_code.'</com:State>
                <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                <com:Country>IN</com:Country>
            </com:Address>
            </com:BookingTraveler>';
        } 
        for ($j=1; $j <= $var_infant; $j++) { 
            $title = "infant_title".$j;
            $first_name = "infant_first_name".$j;
            $last_name = "infant_last_name".$j;
            $gender = "infant_gender".$j;
            $date_of_birth = "infant_date_of_birth".$j;
            $seating = "infant_seating".$j;
            $assistance = "infant_assistance".$j;
            $meal = "infant_meal".$j;

            if ($request->gender=="Male") {
                $gender="M";
            }else{
                $gender="F"; 
            }
            $booking_traveler_details.='<com:BookingTraveler Key="INF'.$j.'" TravelerType="INF" DOB="'.date("Y-m-d",strtotime($request->$date_of_birth)).'" Gender="'.$gender.'" Nationality="IN" xmlns:com="http://www.travelport.com/schema/common_v42_0">
            <com:BookingTravelerName Prefix="'.$request->$title.'" First="'.$request->$first_name.'" Last="'.$request->$last_name.'"/>
            <com:PhoneNumber Key="" Number="'.$request->mob_no.'" Type="Home" Text="Abc-Xy"/>
            <com:Email Type="Home" EmailID="'.$request->email.'"/>
            <com:SSR Type="DOCS" Carrier="AI" FreeText=""/>
            <com:Address>
                <com:AddressName>'.$request->add_1.'</com:AddressName>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:Street>'.$request->add_2.'</com:Street>
                <com:City>'.$request->city.'</com:City>
                <com:State>'.$request->state_code.'</com:State>
                <com:PostalCode>'.$request->postcode.'</com:PostalCode>
                <com:Country>IN</com:Country>
            </com:Address>
            </com:BookingTraveler>';
        } 
        // return $booking_traveler_details;
        // return $datasegment;
        $TARGETBRANCH = 'P7141733';
        $CREDENTIALS = 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
        $Provider = '1G'; // Any provider you want to use like 1G/1P/1V/ACH
        $returnSearch = '';
        $searchLegModifier = '';
        // $PreferredDate = Carbon::parse($request->departure_date)->format('Y-m-d');
        // return $request->gender1;
        
        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <univ:AirCreateReservationReq RetainReservation="Both" TraceId="trace" TargetBranch="'.$TARGETBRANCH.'" AuthorizedBy="user" xmlns:univ="http://www.travelport.com/schema/universal_v42_0">
                <com:BillingPointOfSaleInfo OriginApplication="UAPI" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
                '.$booking_traveler_details.'
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
                <air:AirPricingSolution Key="'.$flight[2]['price']['Key'].'" TotalPrice="'.$flight[2]['price']['TotalPrice'].'" BasePrice="'.$flight[2]['price']['BasePrice'].'" ApproximateTotalPrice="'.$flight[2]['price']['ApproximateTotalPrice'].'" ApproximateBasePrice="'.$flight[2]['price']['ApproximateBasePrice'].'" Taxes="'.$flight[2]['price']['Taxes'].'" Fees="'.$flight[2]['price']['Fees'].'" ApproximateTaxes="'.$flight[2]['price']['ApproximateTaxes'].'" QuoteDate="'.$flight[2]['price']['QuoteDate'].'" xmlns:air="http://www.travelport.com/schema/air_v42_0">
                    '.$datasegment
                    .$var_AirPricingInfo_FareInfo_FareRuleKey_BookingInfo.
                    $hostToken.'
                </air:AirPricingSolution>
                <com:ActionStatus TicketDate="T*" Type="ACTIVE" ProviderCode="'.$Provider.'" xmlns:com="http://www.travelport.com/schema/common_v42_0"/>
            </univ:AirCreateReservationReq>
        </soap:Body>
    </soap:Envelope>';
    // return $query;
    // $file='AirCreateReservationReq';
    // file_put_contents($file, $query);
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
        // $file='AirCreateReservationRes';
        // file_put_contents($file, $return);
        $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
        // return $object;
        $data=collect();
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
                                                // echo $count2." ";
                                                // print_r($json6);
                                                // echo "<br/><br/>";
                                                if(strcmp($airkey, "@LocatorCode") == 0){
                                                    $data['AirReservation']=$json6;
                                                }
                                                if($count2==9){
                                                    // print_r($json6);
                                                    // echo "<br/><br/>";
                                                    $AirPricingInfo1=collect();
                                                    $AirPricingInfo=[];
                                                    $AirPricingInfo0=[];
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


                                                        }else{
                                                            // print_r($json7);
                                                            // echo "<br/><br/>";
                                                            foreach($json7 as $api => $json8) {
                                                                if(is_string($json8)){
                                                                    // print_r( $api." -- ".$json7); 
                                                                    // echo "<br/><br/>";
                                                                    if(strcmp($api, "@Key") == 0){
                                                                        $AirPricingInfo0['Key']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@TotalPrice") == 0){
                                                                        $AirPricingInfo0['TotalPrice']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@BasePrice") == 0){
                                                                        $AirPricingInfo0['BasePrice']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@ApproximateTotalPrice") == 0){
                                                                        $AirPricingInfo0['ApproximateTotalPrice']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@ApproximateBasePrice") == 0){
                                                                        $AirPricingInfo0['ApproximateBasePrice']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@EquivalentBasePrice") == 0){
                                                                        $AirPricingInfo0['EquivalentBasePrice']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@Taxes") == 0){
                                                                        $AirPricingInfo0['Taxes']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@LatestTicketingTime") == 0){
                                                                        $AirPricingInfo0['LatestTicketingTime']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@TrueLastDateToTicket") == 0){
                                                                        $AirPricingInfo0['TrueLastDateToTicket']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@PricingMethod") == 0){
                                                                        $AirPricingInfo0['PricingMethod']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@Refundable") == 0){
                                                                        $AirPricingInfo0['Refundable']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@Exchangeable") == 0){
                                                                        $AirPricingInfo0['Exchangeable']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@IncludesVAT") == 0){
                                                                        $AirPricingInfo0['IncludesVAT']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@ETicketability") == 0){
                                                                        $AirPricingInfo0['ETicketability']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@ProviderCode") == 0){
                                                                        $AirPricingInfo0['ProviderCode']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@ProviderReservationInfoRef") == 0){
                                                                        $AirPricingInfo0['ProviderReservationInfoRef']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@AirPricingInfoGroup") == 0){
                                                                        $AirPricingInfo0['AirPricingInfoGroup']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@PricingType") == 0){
                                                                        $AirPricingInfo0['PricingType']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@ElStat") == 0){
                                                                        $AirPricingInfo0['ElStat']=$json8;
                                                                    }
                                                                    if(strcmp($api, "@FareCalculationInd") == 0){
                                                                        $AirPricingInfo0['FareCalculationInd']=$json8;
                                                                    }
        
        
                                                                }
                                                            }

                                                        }
                                                        if(empty($AirPricingInfo) && !empty($AirPricingInfo0)){
                                                            $AirPricingInfo1->push($AirPricingInfo0);
                                                        }
                                                    }
                                                    if(!empty($AirPricingInfo)){
                                                        $AirPricingInfo1->push($AirPricingInfo);
                                                    }
                                                    // $data(['AirPricingInfo']=$AirPricingInfo;
                                                    $data->push(['AirPricingInfo'=>collect($AirPricingInfo1)]);

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
        if(count($data)==0){
            // return "hii";
            $unidata=[];
            $alldetails=[];
            return view('flights.confirm-booking',[
                'return_searched'=>$request,
                'return_airreservation'=>$data,
                'return_airticketing'=>$alldetails,
                'return_unidata'=>$unidata
            ]);
        }
        // return $data[0];
        // echo $data['UniversalRecord']." <br/>";
        $AirPricingInfoRef='';
        foreach($data[0] as $datas){
            foreach($datas as $datas1){
                // echo $datas1['Key'];
                $AirPricingInfoRef.='<air:AirPricingInfoRef Key="'.$datas1['Key'].'" />';
            }
        }
        // print_r($data[0]);
        // return $data[0];

        $query = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <air:AirTicketingReq AuthorizedBy="user" TargetBranch="'.$TARGETBRANCH.'" TraceId="trace" xmlns:air="http://www.travelport.com/schema/air_v42_0">
            <BillingPointOfSaleInfo OriginApplication="UAPI" xmlns="http://www.travelport.com/schema/common_v42_0"/>
            <air:AirReservationLocatorCode>'.$data['AirReservation'].'</air:AirReservationLocatorCode>
            '.$AirPricingInfoRef.'
            </air:AirTicketingReq>   
        </soap:Body>
    </soap:Envelope>';
    // return $query;
    // $file='AirTicketingReq';
    //     file_put_contents($file, $query);
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
        // $file='AirTicketingRes';
        // file_put_contents($file, $return1);
        $object1 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return1);
        // return $object1;
        $alldetails=[];
        // return $data;
        
        // Universal Record RetrieveReq
        $xml_data =app('App\Http\Controllers\UtilityController')->UniversalRecordRetrieveReq($data['UniversalRecord']);
        // return $xml_data;
        // $file='UniversalRecordRetrieveReq';
        // file_put_contents($file, $xml_data);
        $api_url='https://apac.universal-api.pp.travelport.com/B2BGateway/connect/uAPI/UniversalRecordService';
        $return2 =app('App\Http\Controllers\UtilityController')->universal_API($xml_data,$api_url);
        // return $return2;
        // $file='UniversalRecordRetrieveRes';
        // file_put_contents($file, $return2);
        $object2 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return2);
        $unidata =app('App\Http\Controllers\XMlToParseDataController')->UniversalRecord($object2);

        // return $unidata;
        // return $data;
        // return $request;

        // db code here
        $country_code=$request->country_code;
        if($country_code==''){
            $country_code='GB'; 
        }

        $currency_code=DB::table('countries')->where('country_code',$country_code)->value('currency_code');
        $currency=DB::table('countries')->where('country_code',$country_code)->value('currency_symbal');

        if (count($unidata[1]['journey'])>2) {
            $journey_stop=["1"];
        }else{
            $journey_stop=["0"];
        }
        // return $journey_stop;
        $universal_pnr=$data['UniversalRecord'];
        $pnr=$unidata[3]['UniversalRecord']['LocatorCode'];

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
        

        $segment_one_fare_cost=[];
        $segment_one_fare_sell=[];
        foreach ($unidata[2]['price'] as $key => $value) {
            array_push($segment_one_fare_cost,str_replace($currency_code,'',$value['TotalPrice']));
            array_push($segment_one_fare_sell,str_replace($currency_code,'',$value['TotalPrice']));
        }

        $service_name=["Flight"];
        $journey_type=["RETURN"];
        $universal_pnr=[$universal_pnr];
        $pnr=[$pnr];
        $agency_pcc=[null];
        $booking_date=[date('Y-m-d')];
        $airline_ref=[null];

        $jsonData=[];
        $jsonData['service_name']=$service_name;
        $jsonData['journey_type']=$journey_type;
        $jsonData['journey_stop']=$journey_stop;
        $jsonData['universal_pnr']=$universal_pnr;
        $jsonData['pnr']=$pnr;
        $jsonData['agency_pcc']=$agency_pcc;
        $jsonData['booking_date']=$booking_date;
        $jsonData['airline_ref']=$airline_ref;
        $jsonData['segment_one_flight']=$segment_one_flight;  
        $jsonData['segment_one_from']=$segment_one_from;
        $jsonData['segment_one_to']=$segment_one_to;
        $jsonData['segment_one_carrier']=$segment_one_carrier;
        $jsonData['segment_one_class']=$segment_one_class;
        $jsonData['segment_one_Flight_No']=$segment_one_Flight_No;
        $jsonData['segment_one_departure']=$segment_one_departure;
        $jsonData['segment_one_country_Departure']=$segment_one_country_Departure;
        $jsonData['segment_one_country_Arrival']=$segment_one_country_Arrival;
        $jsonData['segment_one_arrival']=$segment_one_arrival;
        $jsonData['segment_one_Duration']=$segment_one_Duration;
        $jsonData['segment_one_terminal_arrival']=$segment_one_terminal_arrival;
        $jsonData['segment_one_terminal_departure']=$segment_one_terminal_departure;
        $jsonData['segment_two_flight']=$segment_two_flight;  
        $jsonData['segment_two_from']=$segment_two_from;
        $jsonData['segment_two_to']=$segment_two_to;
        $jsonData['segment_two_carrier']=$segment_two_carrier;
        $jsonData['segment_two_class']=$segment_two_class;
        $jsonData['segment_two_Flight_No']=$segment_two_Flight_No;
        $jsonData['segment_two_departure']=$segment_two_departure;
        $jsonData['segment_two_country_Departure']=$segment_two_country_Departure;
        $jsonData['segment_two_country_Arrival']=$segment_two_country_Arrival;
        $jsonData['segment_two_arrival']=$segment_two_arrival;
        $jsonData['segment_two_Duration']=$segment_two_Duration;
        $jsonData['segment_two_terminal_arrival']=$segment_two_terminal_arrival;
        $jsonData['segment_two_terminal_departure']=$segment_two_terminal_departure;
        $jsonData['verify']=$verify;
        $jsonData['pax_type']=$pax_type;
        $jsonData['first_name']=$first_name;
        $jsonData['last_name']=$last_name;
        $jsonData['DOB']=$DOB;
        $jsonData['segment_one_fare_cost']=$segment_one_fare_cost;
        $jsonData['segment_one_fare_sell']=$segment_one_fare_sell;
        // $data=[];
        // return $jsonData;

        $total=0;
        foreach($unidata[2] as $key => $datas){
            // return $request;
            $total+=(str_replace($currency_code,'',$datas[0]['TotalPrice'])*$request->adults);
            if(isset($datas[1])){
            $total+=(str_replace($currency_code,'',$datas[1]['TotalPrice'])*$request->children);
            }
            if(isset($datas[2])){
            $total+=(str_replace($currency_code,'',$datas[2]['TotalPrice'])*$request->infant);
            }
        }
        $billing_address='cc\r\nkolkata\r\n700159\r\nhinduism\r\nindia';
        $invoice = invoice::where('invoice_no', 'CLDI0002778')->get();
        if ($invoice->count() > 0) {
            $latest = invoice::withTrashed()->orderBy('created_at', 'desc')->take(1)->get();
            // return $latest;
            $invoice_prev_no = $latest[0]->invoice_no;
            try {
                $invoice_no = 'CLDI000' . (substr($invoice_prev_no, 4, 7) + 1);
                // return $invoice_no;
            } catch (Exception $e) {
                $latest = invoice::withTrashed()->orderBy('created_at', 'desc')->get();

                $insize = count($latest);
                for ($i = 0; $i < $insize; $i++) {

                    $invoice_prev_no = $latest[$i]->invoice_no;

                    if ($invoice_prev_no[3] == "R" or $invoice_prev_no[3] == "C") {
                        continue;
                    } else {
                        $invoice_no = 'CLDI000' . (substr($invoice_prev_no, 4, 7) + 1);
                        break;
                    }
                }

            }
            while (1) {

                $checknumber = invoice::where('invoice_no', '=', $invoice_no)->first();
                if ($checknumber === null) {
                    // checknumber doesn't exist
                    break;
                } else {

                    $invoice_no = 'CLDI000' . (substr($invoice_no, 4, 7) + 1);
                }

            }

        } else {
            $invoice_no = 'CLDI0002778';
        }

        $dt = Carbon::now();
        $date_today = $dt->timezone('Europe/London');
        $date = $date_today->toDateString();
        $invoice = new invoice;
        $client = client::find($client_id);
        $invoice->client_id = $client->id;
        if($request->diff_receiver_name){
            $invoice->receiver_name = $request->diff_receiver_name;
        } else {
            $invoice->receiver_name = strtoupper($client->first_name . ' ' . $client->last_name);
        }
        $invoice->billing_address = strtoupper($billing_address);
        $invoice->invoice_date = date('Y-m-d');
        $invoice->invoice_no = $invoice_no;
        if (!empty($request->discount)) {
            $invoice->discount = str_replace(',', '', $request->discount);
        } else {
            $request->discount = 0.0;
        }
        $invoice->currency = $currency;
        // $invoice->total = str_replace(',', '', $request->total);
        // $invoice->discounted_total = str_replace(',', '', $total) - str_replace(',', '', $request->discount);
        $invoice->total = $total;
        $invoice->discounted_total =  $total -  $request->discount;
        $invoice->mail_sent = $date;
        $invoice->remarks = $request->remarks;
        $invoice->save();
        $tax = settings::all();
        if ($tax[0]->enable == 'yes') {
            $invoice->VAT_percentage = $tax[0]->tax;
            $invoice->VAT_amount = ($tax[0]->tax) / 100 * (str_replace(',', '', $invoice->discounted_total));
        }
        // return $invoice;
        $invoice->paid = 0;
        $request->credit_amount=$total;
        // return $request->credit_amount;
        if ($request->credit_amount != null) {
            $invoice->credit = 1;
            $invoice->credit_amount = $invoice->credit_amount +  $request->credit_amount;
            $invoice->paid = $invoice->paid + $request->credit_amount;
        }
        

        $invoice->pending_amount = $invoice->discounted_total + $invoice->VAT_amount - $invoice->paid;
        $invoice->save();
        $flight_counter = 0;
        $visa_counter = 0;
        $insurance_counter = 0;
        $hotel_counter = 0;
        $local_sight_sceen_counter = 0;
        $local_transport_counter = 0;
        $car_rental_counter = 0;
        $other_facilities_counter = 0;

        // return $unidata[1]['journey'][0];
        // return $universal_pnr;
        // return $journey_type[0];
        $flight = new Flight;
        $flight->invoice_id = $invoice->id;
        $flight->universal_pnr = strtoupper($universal_pnr[0]);
        $flight->booking_date = strtoupper($booking_date[0]);
        $flight->pnr = strtoupper($pnr[0]);
        $flight->agency_pcc = strtoupper($agency_pcc[0]);
        $flight->airline_ref = strtoupper($airline_ref[0]);
        $flight->total_amount = number_format($total,2);
        $flight->segment_one_from = strtoupper($unidata[1]['journey'][0]['Origin']);
        // $round_push
        $flight->segment_two_from = isset($unidata[1]['journey'][$round_push]['Origin']) ? strtoupper($unidata[1]['journey'][$round_push]['Origin']) : '';
        $flight->segment_one_to = strtoupper($unidata[1]['journey'][0]['Destination']);
        $flight->segment_two_to = isset($unidata[1]['journey'][$round_push]['Destination']) ? strtoupper($unidata[1]['journey'][$round_push]['Destination']) : '';
        $flight->segment_one_carrier = isset($unidata[1]['journey'][0]['segment_one_carrier']) ? strtoupper($unidata[1]['journey'][0]['segment_one_carrier'][0]) : '';
        $flight->segment_two_carrier = isset($unidata[1]['journey'][$round_push]['segment_one_carrier']) ? strtoupper($unidata[1]['journey'][$round_push]['segment_one_carrier']) : '';
        $flight->segment_one_flight = strtoupper($unidata[1]['journey'][0]['Carrier']);
        $flight->segment_two_flight = isset($unidata[1]['journey'][$round_push]['Carrier']) ? strtoupper($unidata[1]['journey'][$round_push]['Carrier']) : '';
        $flight->segment_one_class = strtoupper($unidata[1]['journey'][0]['CabinClass']);
        $flight->segment_two_class = isset($unidata[1]['journey'][$round_push]['CabinClass']) ? strtoupper($unidata[1]['journey'][$round_push]['CabinClass']) : '';
        $flight->segment_one_departure = strtoupper($unidata[1]['journey'][0]['DepartureTime']);
        $flight->segment_two_departure = isset($unidata[1]['journey'][$round_push]['DepartureTime']) ? strtoupper($unidata[1]['journey'][$round_push]['DepartureTime']) : '';
        $flight->segment_one_arrival = strtoupper($unidata[1]['journey'][0]['ArrivalTime']);
        $flight->segment_two_arrival = isset($unidata[1]['journey'][$round_push]['ArrivalTime']) ? strtoupper($unidata[1]['journey'][$round_push]['ArrivalTime']) : '';
        $flight->json_data = json_encode($jsonData);
        $flight->journey_type = $journey_type[0];
        $flight->journey_stop = $journey_stop[0];
        $flight->save();

        // return $flight;
        // return $unidata[1]['journey'][0];
        // return $currency;
        // return $unidata[2]['price'][0]['TotalPrice'];
        foreach($unidata[0]['personal_details'] as $key =>$data){
            // echo  $data['TravelerType'];
            // return $unidata[2]['price'][0]['TotalPrice'];
            $passenger = new Passenger;
            $passenger->flight_id = $flight->id;
            $passenger->pax_type = $data['TravelerType'];
            $passenger->first_name = $data['First'];
            $passenger->last_name = $data['Last'];
            $passenger->DOB = $data['DOB'];
            if ($data['TravelerType']=='ADT') {
                $passenger->segment_one_fare_cost = isset($unidata[2]['price'][0]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][0]['TotalPrice']) : '0.00';
                $passenger->segment_one_fare_sell = isset($unidata[2]['price'][0]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][0]['TotalPrice']) : '0.00';
            }else if ($data['TravelerType']=='CNN') {
                $passenger->segment_one_fare_cost = isset($unidata[2]['price'][1]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][1]['TotalPrice']) : '0.00';
                $passenger->segment_one_fare_sell = isset($unidata[2]['price'][1]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][1]['TotalPrice']) : '0.00';
            }else if ($data['TravelerType']=='INF') {
                $passenger->segment_one_fare_cost = isset($unidata[2]['price'][2]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][2]['TotalPrice']) : '0.00';
                $passenger->segment_one_fare_sell = isset($unidata[2]['price'][2]['TotalPrice']) ? str_replace($currency_code, '', $unidata[2]['price'][2]['TotalPrice']) : '0.00';
            }
            // $passenger->segment_one_fare_cost = isset($value['segment_one_fare_cost'][$index]) ? str_replace(',', '', $value['segment_one_fare_cost'][$index]) : '0.00';
            // $passenger->segment_two_fare_cost = isset($value['segment_two_fare_cost'][$index]) ? str_replace(',', '', $value['segment_two_fare_cost'][$index]) : '0.00';
            // $passenger->segment_one_fare_sell = isset($value['segment_one_fare_sell'][$index]) ? str_replace(',', '', $value['segment_one_fare_sell'][$index]) : '0.00';
            // $passenger->segment_two_fare_sell = isset($value['segment_two_fare_sell'][$index]) ? str_replace(',', '', $value['segment_two_fare_sell'][$index]) : '0.00';
            $passenger->save();
        }
        foreach (invoice::all() as $inv) {
            if ($inv->pending_amount < 0) {
                $inv->advance = 0 - $inv->pending_amount;
                $inv->pending_amount = 0;
                $inv->save();
            }
            if ($inv->pending_amount == 0) {
                $inv->status = 1;
                $inv->save();
            }
            if ($inv->pending_amount > 0) {
                $inv->status = 0;
                $inv->save();
            }
        }

        // return $invoice;

        $invoice_id=$invoice->id;

        return view('flights.confirm-booking',[
            'return_searched'=>$request,
            'return_airreservation'=>$data,
            'return_airticketing'=>$alldetails,
            'return_unidata'=>$unidata,
            'invoice_no'=>$invoice_no,
            'unique_id'=>$unique_id
        ]);

    }

    public function BookingFailedResponce($request){
        $data=[];
        $alldetails=[];
        $unidata=[];
        return view('flights.confirm-booking',[
            'return_searched'=>$request,
            'return_airreservation'=>$data,
            'return_airticketing'=>$alldetails,
            'return_unidata'=>$unidata
        ]);
    }
}
