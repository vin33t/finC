<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function Show(Request $request){
        // return $request;
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
        return $request;
        $options=json_decode($request->options,true);
        // return $options;
        // return $options['OptionId'];
        // return $options['Rooms']['Room']['RoomId'];
        $allxmldata='';
        if($request->hotel_room > 1){
            // return $options['Rooms']['Room'][0]['RoomId'];
            return "hh";
        }else{
            // room1_hotel_adults
            // room1_hotel_child
            // room1_hotel_infant
            return $options['Rooms']['Room']['RoomId'];
            // $allxmldata

        }
        // if(isset($options['Rooms']['Room']['RoomId'])){
        //     return $options['Rooms']['Room']['RoomId'];
        // }else{
        //     return $options['Rooms']['Room'];
        // }
        $first_name1=$request->first_name1;
        $last_name1=$request->last_name1;
        // return $first_name1;

        $xmldata='';
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
                            <Room>
                                <RoomId>'.$options['Rooms']['Room']['RoomId'].'</RoomId>
                                <PaxNames>
                                    <AdultName>
                                        <Title>Mr.</Title>
                                        <FirstName>'.$first_name1.'</FirstName>
                                        <LastName>'.$last_name1.'</LastName>
                                    </AdultName>
                                </PaxNames>
                            </Room>
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
                // return [];
                // return $data->push($json['Body']['Error']);
            }else if(array_key_exists('HotelBooking',$json['Body'])){
                // return $json['Body']['HotelBooking'];
                // $hotel= $json['Body']['HotelBooking'];
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
        if(isset($json['Body']['HotelBooking']['BookingReference'])){
            $xml1 = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>HotelBookingDetails</RequestType>
                    </Head>
                    <Body>
                        <CheckInDates>
                            <CheckInDateStart>2021-09-02</CheckInDateStart>
                            <CheckInDateEnd>2021-09-04</CheckInDateEnd>
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
            return view('hotel.confirm-booking',[
                'bookdetails'=>$bookdetails,
                'searched'=>$request
            ]);

        }else{
            return view('hotel.confirm-booking',[
                'bookdetails'=>$bookdetails,
                'searched'=>$request
            ]);
        }
       


    }
}
