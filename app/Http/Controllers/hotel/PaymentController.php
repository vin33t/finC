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
use App\Mail\SendCredentialsEmail;

use Illuminate\Support\Carbon;
use App\Models\Leads;
use App\Models\client;
use App\Models\invoice;
use App\Models\User;
use App\Models\settings;
use App\Models\Flight;
use App\Models\Passenger;
use App\Models\invoiceInfo;

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
            // return $request;
            // return "hii";
            $lead = new Leads;
            // $lead->user_id = Auth::user()->id;
            $lead->first_name = $request->room1_first_name1;
            $lead->last_name = $request->room1_last_name1;
            $lead->address = $request->add_1.', '.$request->add_2;
            $lead->city = $request->city;
            // $lead->county = $request->county;
            $lead->postal_code = $request->post_code;
            $lead->country = $request->state;
            $lead->phone = $request->contact_no;
            $lead->email = $request->email;
            // $lead->DOB = date('Y-m-d',strtotime($request->date_of_birth1));
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
            $client->first_name = $request->room1_first_name1;
            $client->last_name = $request->room1_last_name1;
            $client->address = $request->add_1.", ".$request->add_2;
            $client->postal_code = $request->post_code;
            $client->city = $request->city;
            // $client->county = $request->county;
            $client->country = $request->state;
            // $client->DOB = Carbon::parse($request->date_of_birth1)->format('d-m-Y');
            $client->email = $request->email;
            $client->phone = $request->contact_no;
            $client->permanent = 0;
            // $client->client_type = $request->client_type;
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

                // db insert
                $currency_code=$bookdetails[0]['Currency'];
                $currency=DB::table('hotel_currency')->where('currency',$currency_code)->value('icon');
                $total=$bookdetails[0]['TotalPrice'];
                $request->remarks="Non refunded";

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
                
               
                if(isset($bookdetails[0]['Rooms']['Room']['RoomName'])){
                    // return $bookdetails[0]['Rooms']['Room']['RoomName'];
                    // HotelGuestRoom::create(array(
                    //     'booking_reference'=>$bookdetails[0]['BookingReference'],
                    //     'room_name'=>$bookdetails[0]['Rooms']['Room']['RoomName'],
                    //     'room_no'=>1,
                    //     'num_adults'=>$bookdetails[0]['Rooms']['Room']['NumAdults'],
                    //     'num_children'=>$bookdetails[0]['Rooms']['Room']['NumChildren'],
                    // ));
                    $invoice_info = new invoiceInfo;
                    $invoice_info->invoice_id = $invoice->id;
                    $invoice_info->receiver_name = $invoice->receiver_name;
                    $invoice_info->service_name = 'Hotel';

                    $invoice_info->hotel_applicant_name = strtoupper($bookdetails[0]['LeaderName']);
                    $invoice_info->hotel_city = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_country = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_id = $bookdetails[0]['HotelId'];
                    $invoice_info->hotel_name = strtoupper($bookdetails[0]['HotelName']);
                    $invoice_info->hotel_room_name = strtoupper($bookdetails[0]['Rooms']['Room']['RoomName']);
                    $invoice_info->check_in_date = $bookdetails[0]['CheckInDate'];
                    $invoice_info->check_out_date = $bookdetails[0]['CheckOutDate'];
                    $invoice_info->no_of_adults = $bookdetails[0]['Rooms']['Room']['NumAdults'];
                    $invoice_info->no_of_children = $bookdetails[0]['Rooms']['Room']['NumChildren'];
                    $invoice_info->no_of_rooms = 1;
                    $invoice_info->hotel_applicant_othername = '';
                    $invoice_info->hotel_remarks = '';
                    $invoice_info->hotel_amount = $total;
                    $invoice_info->hotel_booking_reference_number = $bookdetails[0]['BookingReference'];
                    if($request->hotel_company_name){
                        $invoice_info->hotel_company_name = $request->hotel_company_name[$hotel_counter];
                    }
                    $invoice_info->save();


                    

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
                    // HotelGuestRoom::create(array(
                    //     'booking_reference'=>$bookdetails[0]['BookingReference'],
                    //     'room_name'=>$room['RoomName'],
                    //     'room_no'=>$room_no,
                    //     'num_adults'=>$num_adults,
                    //     'num_children'=>$num_children,
                    // ));
                    $invoice_info = new invoiceInfo;
                    $invoice_info->invoice_id = $invoice->id;
                    $invoice_info->receiver_name = $invoice->receiver_name;
                    $invoice_info->service_name = 'Hotel';

                    $invoice_info->hotel_applicant_name = strtoupper($bookdetails[0]['LeaderName']);
                    $invoice_info->hotel_city = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_country = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_id = $bookdetails[0]['HotelId'];
                    $invoice_info->hotel_name = strtoupper($bookdetails[0]['HotelName']);
                    $invoice_info->hotel_room_name = strtoupper($room['RoomName']);
                    $invoice_info->check_in_date = $bookdetails[0]['CheckInDate'];
                    $invoice_info->check_out_date = $bookdetails[0]['CheckOutDate'];
                    $invoice_info->no_of_adults = $num_adults;
                    $invoice_info->no_of_children = $num_children;
                    $invoice_info->no_of_rooms = $room_no;
                    $invoice_info->hotel_applicant_othername = '';
                    $invoice_info->hotel_remarks = '';
                    $invoice_info->hotel_amount = $total;
                    $invoice_info->hotel_booking_reference_number = $bookdetails[0]['BookingReference'];
                    if($request->hotel_company_name){
                        $invoice_info->hotel_company_name = $request->hotel_company_name[$hotel_counter];
                    }
                    $invoice_info->save();
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
                    'searched'=>$request,
                    'invoice_no'=>$invoice_no,
                    'unique_id'=>$unique_id
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
               

                // db insert
                $currency_code=$bookdetails[0]['Currency'];
                $currency=DB::table('hotel_currency')->where('currency',$currency_code)->value('icon');
                $total=$bookdetails[0]['TotalPrice'];
                $request->remarks="Non refunded";

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
                
                
               
                if(isset($bookdetails[0]['Rooms']['Room']['RoomName'])){
                    // return $bookdetails[0]['Rooms']['Room']['RoomName'];
                    // HotelGuestRoom::create(array(
                    //     'booking_reference'=>$bookdetails[0]['BookingReference'],
                    //     'room_name'=>$bookdetails[0]['Rooms']['Room']['RoomName'],
                    //     'room_no'=>1,
                    //     'num_adults'=>$bookdetails[0]['Rooms']['Room']['NumAdults'],
                    //     'num_children'=>$bookdetails[0]['Rooms']['Room']['NumChildren'],
                    // ));
                    $invoice_info = new invoiceInfo;
                    $invoice_info->invoice_id = $invoice->id;
                    $invoice_info->receiver_name = $invoice->receiver_name;
                    $invoice_info->service_name = 'Hotel';

                    $invoice_info->hotel_applicant_name = strtoupper($bookdetails[0]['LeaderName']);
                    $invoice_info->hotel_city = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_country = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_id = $bookdetails[0]['HotelId'];
                    $invoice_info->hotel_name = strtoupper($bookdetails[0]['HotelName']);
                    $invoice_info->hotel_room_name = strtoupper($bookdetails[0]['Rooms']['Room']['RoomName']);
                    $invoice_info->check_in_date = $bookdetails[0]['CheckInDate'];
                    $invoice_info->check_out_date = $bookdetails[0]['CheckOutDate'];
                    $invoice_info->no_of_adults = $bookdetails[0]['Rooms']['Room']['NumAdults'];
                    $invoice_info->no_of_children = $bookdetails[0]['Rooms']['Room']['NumChildren'];
                    $invoice_info->no_of_rooms = 1;
                    $invoice_info->hotel_applicant_othername = '';
                    $invoice_info->hotel_remarks = '';
                    $invoice_info->hotel_amount = $total;
                    $invoice_info->hotel_booking_reference_number = $bookdetails[0]['BookingReference'];
                    if($request->hotel_company_name){
                        $invoice_info->hotel_company_name = $request->hotel_company_name[$hotel_counter];
                    }
                    $invoice_info->save();

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
                    // HotelGuestRoom::create(array(
                    //     'booking_reference'=>$bookdetails[0]['BookingReference'],
                    //     'room_name'=>$room['RoomName'],
                    //     'room_no'=>$room_no,
                    //     'num_adults'=>$num_adults,
                    //     'num_children'=>$num_children,
                    // ));
                    $invoice_info = new invoiceInfo;
                    $invoice_info->invoice_id = $invoice->id;
                    $invoice_info->receiver_name = $invoice->receiver_name;
                    $invoice_info->service_name = 'Hotel';

                    $invoice_info->hotel_applicant_name = strtoupper($bookdetails[0]['LeaderName']);
                    $invoice_info->hotel_city = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_country = strtoupper($bookdetails[0]['City']);
                    $invoice_info->hotel_id = $bookdetails[0]['HotelId'];
                    $invoice_info->hotel_name = strtoupper($bookdetails[0]['HotelName']);
                    $invoice_info->hotel_room_name = strtoupper($room['RoomName']);
                    $invoice_info->check_in_date = $bookdetails[0]['CheckInDate'];
                    $invoice_info->check_out_date = $bookdetails[0]['CheckOutDate'];
                    $invoice_info->no_of_adults = $num_adults;
                    $invoice_info->no_of_children = $num_children;
                    $invoice_info->no_of_rooms = $room_no;
                    $invoice_info->hotel_applicant_othername = '';
                    $invoice_info->hotel_remarks = '';
                    $invoice_info->hotel_amount = $total;
                    $invoice_info->hotel_booking_reference_number = $bookdetails[0]['BookingReference'];
                    if($request->hotel_company_name){
                        $invoice_info->hotel_company_name = $request->hotel_company_name[$hotel_counter];
                    }
                    $invoice_info->save();
                }
                // end add details database
                $guestdetails=HotelGuestRoomDetails::where('booking_reference',$bookdetails[0]['BookingReference'])->get();
                
                // start mail send code here
                
                // end mail send code here
                
                return view('hotel.confirm-booking',[
                    'bookdetails'=>$bookdetails,
                    'guestdetails'=>$guestdetails,
                    'searched'=>$request,
                    'invoice_no'=>$invoice_no,
                    'unique_id'=>$unique_id
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
