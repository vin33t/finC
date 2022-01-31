<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelCurrency;

class HotelDetailsController extends Controller
{
    public function Show(Request $request){
        // return $request;
        $Options=json_decode($request->Options,true);
        // return $Options;

        $hotelids=$request->hotel_id;
        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';

        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>GetHotelDetails</RequestType>
                    </Head>
                    <Body>
                        <HotelIds>
                            <HotelId>'.$hotelids.'</HotelId>
                        </HotelIds>
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
        $hotelDetails=[];
        foreach($object as $json){
            if(array_key_exists('Error',$json['Body'])){
                // return $json['Body']['Error'];
                // return $data;
            }else if(array_key_exists('Hotels',$json['Body'])){
                // return $json['Body']['Hotels'];
                $hotel= $json['Body']['Hotels'];
                if(array_key_exists('HotelId',$hotel['Hotel'])){
                    // return $hotel['Hotel']['HotelId'];
                    array_push($hotelDetails,$hotel['Hotel']);
                }else{
                    $hotelDetails= $json['Body']['Hotels']['Hotel'];
                    // array_push($hotelDetails,$hotels);
                }

            }
        }
        // return $hotelDetails;

        $xmloptions='';
        if(isset($Options['OptionId'])){
            // $xmloptions='<OptionId>'.$Options['OptionId'].'</OptionId>';
            $Optionsss=$Options['OptionId'];
            // return $Options['OptionId'];
        }else{
            $Optionsss=$Options[0]['OptionId'];
        }
        // foreach($Options as $Option){
        //     $xmloptions.='<OptionId>'.$Option['OptionId'].'</OptionId>';
        //     // echo $Option['OptionId'];
        //     // echo "<br/>";
        // }
        // return $xmloptions;

        $xml1 = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>HotelPolicies</RequestType>

                    </Head>
                    <Body>
                        <OptionId>'.$Optionsss.'</OptionId>
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
        $Policies=[];
        foreach($object1 as $json){
            if(array_key_exists('Error',$json['Body'])){
                // return $json['Body']['Error'];
                // return $data;
            }else if(array_key_exists('Policies',$json['Body'])){
                $Policies= $json['Body'];
                // $hotel= $json['Body']['Hotels'];
                // if(array_key_exists('HotelId',$hotel['Hotel'])){
                //     // return $hotel['Hotel']['HotelId'];
                //     array_push($hotelDetails,$hotel['Hotel']);
                // }else{
                //     $hotelDetails= $json['Body']['Hotels']['Hotel'];
                //     // array_push($hotelDetails,$hotels);
                // }

            }
        }


        // return $Policies;
        // return $Options;
        // return $Options;
        // return $request;
        $hotel_currency=HotelCurrency::get();
//        dd($request);
        return view('hotel.hotel-details',[
            'hotelDetails'=>$hotelDetails,
            'options'=>$Options,
            'policies'=>$Policies,
            'hotel_currency'=>$hotel_currency,
            'searched'=>$request,
        ]);

    }
}
