<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelCurrency;
use App\Models\HotelGuestDetails;
use App\Models\HotelGuestRoom;
use App\Models\HotelPaymentDetails;
use App\Models\HotelGuestRoomDetails;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use PDF;
use Mail;
use App\Mail\HotelBookinInvoiceEmail;

use Illuminate\Support\Carbon;
use App\Models\Leads;
use App\Models\client;
use App\Models\invoice;
use App\Models\User;
use App\Models\settings;
use App\Models\Flight;
use App\Models\Passenger;

class PaymentController extends Controller
{
    public function Show(Request $request){
        // return $request;
        // db code 
        // return $request;
        $is_has=Leads::where('email',$request->email)->get();
        if (count($is_has)>0) {
            // return $is_has;
        }else{
            // return "hii";
            $lead = new Leads;
            // $lead->user_id = Auth::user()->id;
            $lead->first_name = $request->first_name1;
            $lead->last_name = $request->last_name1;
            $lead->address = $request->add_1;
            $lead->city = $request->city;
            $lead->county = $request->county;
            $lead->postal_code = $request->postcode;
            $lead->country = $request->country;
            $lead->phone = $request->mob_no;
            $lead->email = $request->email;
            $lead->DOB = date('Y-m-d',strtotime($request->date_of_birth1));
            $lead->save();
        }




        $options=json_decode($request->option,true);
        // return $option[0];
        // $options=$option[0];
        // return $options;
        return view('hotel.payment',[
            'options'=>$options,
            'searched'=>$request
        ]);
    }

    public function Confirm(Request $request){

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
            $client_id=$client->id;
            // return $client_id;
        }





        



        // return $request;
        $check_in=\Carbon\Carbon::parse($request->check_in)->format('Y-m-d');
        $check_out=\Carbon\Carbon::parse($request->check_out)->format('Y-m-d');
        // return $check_in;
        $options=json_decode($request->options,true);
        // return $options;
        // return $options['OptionId'];
        // return $options['Rooms']['Room']['RoomId'];
        $allxmldata='';
        if($request->hotel_room > 1){
            // return "hh";
            for ($i=1; $i <= $request->hotel_room; $i++) { 
                // echo $i;
                $adult = 'room'.$i.'_hotel_adults';
                // echo "</br>";
                $child ='room'.$i.'_hotel_child';
                // echo "</br>";
                $infant ='room'.$i.'_hotel_infant';
                // echo "</br>";
                $allxmldata0='<Room>
                     <RoomId>'.$options['Rooms']['Room'][($i-1)]['RoomId'].'</RoomId>
                     <PaxNames>';
                $allxmldata1='';
                for ($j=1; $j <= $request->$adult; $j++) { 
                    $firstname= 'room'.$i.'_first_name'.$j;
                    $lastname= 'room'.$i.'_last_name'.$j;
                    // echo "</br>";
                    $allxmldata1.='<AdultName>
                         <Title>Mr.</Title>
                         <FirstName>'.$request->$firstname.'</FirstName>
                         <LastName>'.$request->$lastname.'</LastName>
                     </AdultName>';
                }
                $allxmldata2='';
                if($request->$child>0){
                    $child1_first= 'room'.$i.'_child1_first_name';
                    $child1_last= 'room'.$i.'_child1_last_name';
                    $allxmldata2='<ChildName>
                        <FirstName>'.$request->$child1_first.'</FirstName>
                        <LastName>'.$request->$child1_last.'</LastName>
                    </ChildName>';
                }
                $allxmldata3='';
                if($request->$infant>0){
                    $child2_first= 'room'.$i.'_child2_first_name';
                    $child2_last= 'room'.$i.'_child2_last_name';
                    $allxmldata3='<ChildName>
                        <FirstName>'.$request->$child2_first.'</FirstName>
                        <LastName>'.$request->$child2_last.'</LastName>
                    </ChildName>';
                }
                $allxmldata4='</PaxNames>
                </Room>';
                $allxmldata.=$allxmldata0.$allxmldata1.$allxmldata2.$allxmldata3.$allxmldata4;
                $allxmldata0='';
                $allxmldata1='';
                $allxmldata2='';
                $allxmldata3='';
                $allxmldata4='';
            }
            // room1_hotel_adults": "2",
            // "room1_hotel_child": "11",
            // "room1_hotel_infant": "7",
            // return $options['Rooms']['Room'][0]['RoomId'];
            // $allxmldata0='<Room>
            //     <RoomId>'.$options['Rooms']['Room']['RoomId'].'</RoomId>
            //     <PaxNames>';
            // $allxmldata1='';
            

            

        }else{
            // room1_hotel_adults
            // room1_hotel_child
            // room1_hotel_infant
            // return $options['Rooms']['Room']['RoomId'];
            // $allxmldata
            $i=1;
            $adult = 'room'.$i.'_hotel_adults';
            // echo "</br>";
            $child ='room'.$i.'_hotel_child';
            // echo "</br>";
            $infant ='room'.$i.'_hotel_infant';
            
            $allxmldata0='<Room>
                <RoomId>'.$options['Rooms']['Room']['RoomId'].'</RoomId>
                <PaxNames>';
                $allxmldata1='';
                for ($j=1; $j <= $request->$adult; $j++) { 
                    $firstname= 'room'.$i.'_first_name'.$j;
                    $lastname= 'room'.$i.'_last_name'.$j;
                    // echo "</br>";
                    $allxmldata1.='<AdultName>
                         <Title>Mr.</Title>
                         <FirstName>'.$request->$firstname.'</FirstName>
                         <LastName>'.$request->$lastname.'</LastName>
                     </AdultName>';
                }
                $allxmldata2='';
                if($request->$child>0){
                    $child1_first= 'room'.$i.'_child1_first_name';
                    $child1_last= 'room'.$i.'_child1_last_name';
                    $allxmldata2='<ChildName>
                        <FirstName>'.$request->$child1_first.'</FirstName>
                        <LastName>'.$request->$child1_last.'</LastName>
                    </ChildName>';
                }
                $allxmldata3='';
                if($request->$infant>0){
                    $child2_first= 'room'.$i.'_child2_first_name';
                    $child2_last= 'room'.$i.'_child2_last_name';
                    $allxmldata3='<ChildName>
                        <FirstName>'.$request->$child2_first.'</FirstName>
                        <LastName>'.$request->$child2_last.'</LastName>
                    </ChildName>';
                }
                $allxmldata4='</PaxNames>
                </Room>';
                $allxmldata.=$allxmldata0.$allxmldata1.$allxmldata2.$allxmldata3.$allxmldata4;
            


        }
        // return $allxmldata;
        // if(isset($options['Rooms']['Room']['RoomId'])){
        //     return $options['Rooms']['Room']['RoomId'];
        // }else{
        //     return $options['Rooms']['Room'];
        // }
        // $first_name1=$request->first_name1;
        // $last_name1=$request->last_name1;
        // return $first_name1;

        // $xmldata='';
            // <ChildName>
            // <FirstName>First Name 5</FirstName>
            // <LastName>Last Name 5</LastName>
            // </ChildName>

        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';

        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>HotelBooking</RequestType>
                    </Head>
                    <Body>
                        <OptionId>'.$options['OptionId'].'</OptionId>
                        <YourReference>XMLTEST</YourReference>
                        <Rooms>
                            '.$allxmldata.'  
                        </Rooms>
                    </Body>
                </Request>';


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);
        curl_close($ch);
        // return $return;
        $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
        // return $object;
        // $data=collect();
        foreach($object as $json){
            if(array_key_exists('Error',$json['Body'])){
                // return $json['Body']['Error'];
                $errorText= $json['Body']['Error']['ErrorText'];
                // return $json['Body']['Error']['ErrorText'];
                return view('hotel.confirm-booking',[
                    'bookdetails'=>[],
                    'errorText'=>$errorText,
                    'searched'=>$request
                ]);
                // return [];
                // return $data->push($json['Body']['Error']);
            }else if(array_key_exists('HotelBooking',$json['Body'])){
                // return $json['Body']['HotelBooking'];
                $hotel= $json['Body']['HotelBooking'];
                // return $hotel['BookingReference'];
                // if(array_key_exists('HotelId',$hotel['Hotel'])){
                //     // return $hotel['Hotel']['HotelId'];
                //     array_push($hotelDetails,$hotel['Hotel']);
                // }else{
                //     $hotelDetails= $json['Body']['Hotels']['Hotel'];
                //     // array_push($hotelDetails,$hotels);
                // }
                
            }
        }
        $bookdetails=[];
        if(isset($hotel['BookingReference'])){
            $xml1 = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>HotelBookingDetails</RequestType>
                    </Head>
                    <Body>
                        <CheckInDates>
                            <CheckInDateStart>'.$check_in.'</CheckInDateStart>
                            <CheckInDateEnd>'.$check_out.'</CheckInDateEnd>
                        </CheckInDates>
                    </Body>
                </Request>';

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $xml1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $return1 = curl_exec($ch);
            curl_close($ch);
            // return $return;
            $object1 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return1);
            // return $object1;
            foreach($object1 as $json){
                $bookdetails=$json['Body']['Bookings']['HotelBooking'];
                // return $bookdetails;
            }

            if(isset($bookdetails[0]['BookingReference'])){
                // start add details database
                $contact_no=$request->contact_no;
                $email=$request->email;
                $f_name=$request->room1_first_name1;
                $l_name=$request->room1_last_name1;
                $passwords='';
                $user_details=UserLogin::where('user_id',$email)->get();
                if(count($user_details)>0){
                    foreach($user_details as $user){
                        $user_id=$user->id;
                    }
                    session()->flush();
                    Session::put('user_details', $user_details); 
                }else{
                    if(isset(Session::get('user_details')[0]['id'])){
                        // $user_details1=UserLogin::where('id',Session::get('user_details')[0]['id'])->get();
                        $user_id=Session::get('user_details')[0]['id'];
                    }else{
                        $passwords=substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 6)), 0, 6);

                        UserLogin::create(array(
                            'user_id'=>$email,
                            'user_pass'=>Hash::make($passwords),
                            'first_name'=>$f_name,
                            'last_name'=>$l_name,
                            'mobile'=>$contact_no,
                            'user_type'=>'U',
                            'created_by'=>$f_name,
                        ));
                        $user_details1=UserLogin::where('user_id',$email)->get();
                        // $user_id=1;
                        foreach($user_details1 as $user){
                            $user_id=$user->id;
                        }
                        session()->flush();
                        Session::put('user_details', $user_details1); 
                        // $user_id=DB::table('user_login')->where('user_id',$email)->value('id');
                    }
                }

                HotelPaymentDetails::create(array(
                    'booking_reference' => $bookdetails[0]['BookingReference'],
                    'payment_id' => 'XMLTEST',
                    'room_charges'=> $bookdetails[0]['TotalPrice'],
                    'gst' => $request->GST,
                    'convenience_fees' => $request->Convenience_Fees,
                    'taxes_and_fees' => $request->Taxes_and_Fees,
                ));
                
                HotelGuestDetails::create(array(
                    'user_id'=>$user_id,
                    'booking_reference'=>$bookdetails[0]['BookingReference'],
                    'booking_status'=>$bookdetails[0]['BookingStatus'],
                    'payment_status'=>$bookdetails[0]['PaymentStatus'],
                    'booking_time'=>$bookdetails[0]['BookingTime'],
                    'your_reference'=>$bookdetails[0]['YourReference'],
                    'currency'=>$bookdetails[0]['Currency'],
                    'total_price'=>$bookdetails[0]['TotalPrice'],
                    'hotel_id'=>$bookdetails[0]['HotelId'],
                    'hotel_name'=>$bookdetails[0]['HotelName'],
                    'city'=>$bookdetails[0]['City'],
                    'check_in_date'=>$bookdetails[0]['CheckInDate'],
                    'check_out_date'=>$bookdetails[0]['CheckOutDate'],
                    'leader_name'=>$bookdetails[0]['LeaderName'],
                    'nationality'=>$bookdetails[0]['Nationality'],
                    'board_type'=>$bookdetails[0]['BoardType'],
                    'cancellation_deadline'=>$bookdetails[0]['CancellationDeadline'],
                    'post_code'=>$request->post_code,
                    'add_1'=>$request->add_1,
                    'add_2'=>$request->add_2,
                    'guest_city'=>$request->city,
                    'country'=>$request->state,
                    'mobile'=>$request->contact_no,
                    'email'=>$request->email,
                ));
                if(isset($bookdetails[0]['Rooms']['Room']['RoomName'])){
                    // return $bookdetails[0]['Rooms']['Room']['RoomName'];
                    HotelGuestRoom::create(array(
                        'booking_reference'=>$bookdetails[0]['BookingReference'],
                        'room_name'=>$bookdetails[0]['Rooms']['Room']['RoomName'],
                        'room_no'=>1,
                        'num_adults'=>$bookdetails[0]['Rooms']['Room']['NumAdults'],
                        'num_children'=>$bookdetails[0]['Rooms']['Room']['NumChildren'],
                    ));
                    
                    for ($i=1; $i <=$bookdetails[0]['Rooms']['Room']['NumAdults']; $i++) { 
                        $first_name='room1_first_name'.$i;
                        $last_name='room1_last_name'.$i;
                        HotelGuestRoomDetails::create(array(
                            'booking_reference'=>$bookdetails[0]['BookingReference'],
                            'pax_type' => 'ADULT',
                            'room_no' => 1,
                            'first_name' => $request->$first_name,
                            'last_name' => $request->$last_name,
                        ));
                    }
                    for ($j=1; $j <=$bookdetails[0]['Rooms']['Room']['NumChildren']; $j++) { 
                        // room1_child1_first_name
                        $first_name='room'.$count.'_child'.$j.'_first_name';
                        $last_name='room'.$count.'_child'.$j.'_last_name';
                        HotelGuestRoomDetails::create(array(
                            'booking_reference'=>$bookdetails[0]['BookingReference'],
                            'pax_type' => 'CHILD',
                            'room_no' => 1,
                            'first_name' => $request->$first_name,
                            'last_name' => $request->$last_name,
                        ));
                    }
                    
                }else{
                    // return $bookdetails[0]['Rooms']['Room'];
                    $rooms = $bookdetails[0]['Rooms']['Room'];
                    $count=1;
                    $room_no=0;
                    $num_adults=0;
                    $num_children=0;
                    foreach($rooms as $room){
                        // HotelGuestRoom::create(array(
                        //     'booking_reference'=>$bookdetails[0]['BookingReference'],
                        //     'room_name'=>$room['RoomName'],
                        //     'room_no'=>$count,
                        //     'num_adults'=>$room['NumAdults'],
                        //     'num_children'=>$room['NumChildren'],
                        // ));
                        $room_no=$room_no+1;
                        $num_adults=$num_adults + $room['NumAdults'];
                        $num_children=$num_children + $room['NumChildren'];
                        for ($i=1; $i <=$room['NumAdults']; $i++) { 
                            $first_name='room'.$count.'_first_name'.$i;
                            $last_name='room'.$count.'_last_name'.$i;
                            HotelGuestRoomDetails::create(array(
                                'booking_reference'=>$bookdetails[0]['BookingReference'],
                                'pax_type' => 'ADULT',
                                'room_no' => $count,
                                'first_name' => $request->$first_name,
                                'last_name' => $request->$last_name,
                            ));
                        }
                        for ($j=1; $j <=$room['NumChildren']; $j++) { 
                            // room1_child1_first_name
                            $first_name='room'.$count.'_child'.$j.'_first_name';
                            $last_name='room'.$count.'_child'.$j.'_last_name';
                            HotelGuestRoomDetails::create(array(
                                'booking_reference'=>$bookdetails[0]['BookingReference'],
                                'pax_type' => 'CHILD',
                                'room_no' => $count,
                                'first_name' => $request->$first_name,
                                'last_name' => $request->$last_name,
                            ));
                        }
                        $count++;
                    }
                    HotelGuestRoom::create(array(
                        'booking_reference'=>$bookdetails[0]['BookingReference'],
                        'room_name'=>$room['RoomName'],
                        'room_no'=>$room_no,
                        'num_adults'=>$num_adults,
                        'num_children'=>$num_children,
                    ));
                }
                // end add details database
                $guestdetails=HotelGuestRoomDetails::where('booking_reference',$bookdetails[0]['BookingReference'])->get();

                // start mail send code here
                $pdfdata["bookdetails"] = $bookdetails[0];
                $pdfdata["guestdetails"] = $guestdetails;
                // $pdfdata["searched"] = $request;
                $pdfdata["add_1"]= $request->add_1;
                $pdfdata["add_2"]= $request->add_2;
                $pdfdata["city"]= $request->city;
                $pdfdata["state"]= $request->state;
                $pdfdata["post_code"]= $request->post_code;
                $pdfdata["contact_no"]= $request->contact_no;
                $pdfdata["currency"]= $request->currency;
                $pdfdata["GST"]= $request->GST;
                $pdfdata["Convenience_Fees"]= $request->Convenience_Fees;
                $pdfdata["Taxes_and_Fees"]= $request->Taxes_and_Fees;
                $LeaderName=$bookdetails[0]['LeaderName'];
                // return $pdfdata;
                $pdf = PDF::loadView('emails.hotel.invoice', $pdfdata);
                // Mail::to($email)->send(new HotelBookinInvoiceEmail($LeaderName,$email,$passwords,$pdf));

                // end mail send code here

                return view('hotel.confirm-booking',[
                    'bookdetails'=>$bookdetails,
                    'guestdetails'=>$guestdetails,
                    'searched'=>$request
                ]);
            }else{
                $xmldata=app('App\Http\Controllers\hotel\UtilityController')->HotelBookingDetails($check_in,$check_out);
                $returndata=app('App\Http\Controllers\hotel\UtilityController')->Hotel_API($xmldata);
                $object2 =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($returndata);
                foreach($object2 as $json){
                    $bookdetails=$json['Body']['Bookings']['HotelBooking'];
                    // return $bookdetails;
                }
                // start add details database
                $contact_no=$request->contact_no;
                $email=$request->email;
                $f_name=$request->room1_first_name1;
                $l_name=$request->room1_last_name1;
                $user_details=UserLogin::where('user_id',$email)->get();
                if(count($user_details)>0){
                    foreach($user_details as $user){
                        $user_id=$user->id;
                    }
                    session()->flush();
                    Session::put('user_details', $user_details); 
                }else{
                    if(isset(Session::get('user_details')[0]['id'])){
                        // $user_details1=UserLogin::where('id',Session::get('user_details')[0]['id'])->get();
                        $user_id=Session::get('user_details')[0]['id'];
                    }else{
                        UserLogin::create(array(
                            'user_id'=>$email,
                            'user_pass'=>Hash::make(uniqid('pass_')),
                            'first_name'=>$f_name,
                            'last_name'=>$l_name,
                            'mobile'=>$contact_no,
                            'user_type'=>'U',
                            'created_by'=>$f_name,
                        ));
                        $user_details1=UserLogin::where('user_id',$email)->get();
                        // $user_id=1;
                        foreach($user_details1 as $user){
                            $user_id=$user->id;
                        }
                        session()->flush();
                        Session::put('user_details', $user_details1); 
                        // $user_id=DB::table('user_login')->where('user_id',$email)->value('id');
                    }
                }

                HotelPaymentDetails::create(array(
                    'booking_reference' => $bookdetails[0]['BookingReference'],
                    'payment_id' => 'XMLTEST',
                    'room_charges'=> $bookdetails[0]['TotalPrice'],
                    'gst' => $request->GST,
                    'convenience_fees' => $request->Convenience_Fees,
                    'taxes_and_fees' => $request->Taxes_and_Fees,
                ));
                
                HotelGuestDetails::create(array(
                    'user_id'=>$user_id,
                    'booking_reference'=>$bookdetails[0]['BookingReference'],
                    'booking_status'=>$bookdetails[0]['BookingStatus'],
                    'payment_status'=>$bookdetails[0]['PaymentStatus'],
                    'booking_time'=>$bookdetails[0]['BookingTime'],
                    'your_reference'=>$bookdetails[0]['YourReference'],
                    'currency'=>$bookdetails[0]['Currency'],
                    'total_price'=>$bookdetails[0]['TotalPrice'],
                    'hotel_id'=>$bookdetails[0]['HotelId'],
                    'hotel_name'=>$bookdetails[0]['HotelName'],
                    'city'=>$bookdetails[0]['City'],
                    'check_in_date'=>$bookdetails[0]['CheckInDate'],
                    'check_out_date'=>$bookdetails[0]['CheckOutDate'],
                    'leader_name'=>$bookdetails[0]['LeaderName'],
                    'nationality'=>$bookdetails[0]['Nationality'],
                    'board_type'=>$bookdetails[0]['BoardType'],
                    'cancellation_deadline'=>$bookdetails[0]['CancellationDeadline'],
                    'post_code'=>$request->post_code,
                    'add_1'=>$request->add_1,
                    'add_2'=>$request->add_2,
                    'guest_city'=>$request->city,
                    'country'=>$request->state,
                    'mobile'=>$request->contact_no,
                    'email'=>$request->email,
                ));
                if(isset($bookdetails[0]['Rooms']['Room']['RoomName'])){
                    // return $bookdetails[0]['Rooms']['Room']['RoomName'];
                    HotelGuestRoom::create(array(
                        'booking_reference'=>$bookdetails[0]['BookingReference'],
                        'room_name'=>$bookdetails[0]['Rooms']['Room']['RoomName'],
                        'room_no'=>1,
                        'num_adults'=>$bookdetails[0]['Rooms']['Room']['NumAdults'],
                        'num_children'=>$bookdetails[0]['Rooms']['Room']['NumChildren'],
                    ));
                    for ($i=1; $i <=$bookdetails[0]['Rooms']['Room']['NumAdults']; $i++) { 
                        $first_name='room1_first_name'.$i;
                        $last_name='room1_last_name'.$i;
                        HotelGuestRoomDetails::create(array(
                            'booking_reference'=>$bookdetails[0]['BookingReference'],
                            'pax_type' => 'ADULT',
                            'room_no' => 1,
                            'first_name' => $request->$first_name,
                            'last_name' => $request->$last_name,
                        ));
                    }
                    for ($j=1; $j <=$bookdetails[0]['Rooms']['Room']['NumChildren']; $j++) { 
                        // room1_child1_first_name
                        $first_name='room'.$count.'_child'.$j.'_first_name';
                        $last_name='room'.$count.'_child'.$j.'_last_name';
                        HotelGuestRoomDetails::create(array(
                            'booking_reference'=>$bookdetails[0]['BookingReference'],
                            'pax_type' => 'CHILD',
                            'room_no' => 1,
                            'first_name' => $request->$first_name,
                            'last_name' => $request->$last_name,
                        ));
                    }
                    
                }else{
                    // return $bookdetails[0]['Rooms']['Room'];
                    $rooms = $bookdetails[0]['Rooms']['Room'];
                    $count=1;
                    $room_no=0;
                    $num_adults=0;
                    $num_children=0;
                    foreach($rooms as $room){
                        // HotelGuestRoom::create(array(
                        //     'booking_reference'=>$bookdetails[0]['BookingReference'],
                        //     'room_name'=>$room['RoomName'],
                        //     'room_no'=>$count,
                        //     'num_adults'=>$room['NumAdults'],
                        //     'num_children'=>$room['NumChildren'],
                        // ));
                        $room_no=$room_no+1;
                        $num_adults=$num_adults + $room['NumAdults'];
                        $num_children=$num_children + $room['NumChildren'];
                        for ($i=1; $i <=$room['NumAdults']; $i++) { 
                            $first_name='room'.$count.'_first_name'.$i;
                            $last_name='room'.$count.'_last_name'.$i;
                            HotelGuestRoomDetails::create(array(
                                'booking_reference'=>$bookdetails[0]['BookingReference'],
                                'pax_type' => 'ADULT',
                                'room_no' => $count,
                                'first_name' => $request->$first_name,
                                'last_name' => $request->$last_name,
                            ));
                        }
                        for ($j=1; $j <=$room['NumChildren']; $j++) { 
                            // room1_child1_first_name
                            $first_name='room'.$count.'_child'.$j.'_first_name';
                            $last_name='room'.$count.'_child'.$j.'_last_name';
                            HotelGuestRoomDetails::create(array(
                                'booking_reference'=>$bookdetails[0]['BookingReference'],
                                'pax_type' => 'CHILD',
                                'room_no' => $count,
                                'first_name' => $request->$first_name,
                                'last_name' => $request->$last_name,
                            ));
                        }
                        $count++;
                    }
                    HotelGuestRoom::create(array(
                        'booking_reference'=>$bookdetails[0]['BookingReference'],
                        'room_name'=>$room['RoomName'],
                        'room_no'=>$room_no,
                        'num_adults'=>$num_adults,
                        'num_children'=>$num_children,
                    ));
                }
                // end add details database
                $guestdetails=HotelGuestRoomDetails::where('booking_reference',$bookdetails[0]['BookingReference'])->get();
                
                // start mail send code here
                
                // end mail send code here
                
                return view('hotel.confirm-booking',[
                    'bookdetails'=>$bookdetails,
                    'guestdetails'=>$guestdetails,
                    'searched'=>$request
                ]);
            }

        }else{
            return view('hotel.confirm-booking',[
                'bookdetails'=>$bookdetails,
                'searched'=>$request
            ]);
        }
       


    }
}
