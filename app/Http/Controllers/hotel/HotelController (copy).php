<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\HotelCities;
use App\Models\HotelCountries;
use DB;

class HotelController extends Controller
{
    public function Search(Request $request){
        // return "hii";
        // return $request;
        $city_name =  str_replace(')','',explode('(',$request->city_name)[0]);
        $country_code =  str_replace(')','',explode('(',$request->city_name)[1]);
        // return $city_name;
        $cityId=DB::table('hotel_cities')->where('country_code',$country_code)->where('city_name',$city_name)->value('city_id');
        // return $cityId;
        $checkinDate = Carbon::parse($request->check_in)->format('Y-m-d');
        $checkoutDate = Carbon::parse($request->check_out)->format('Y-m-d');

        $room=$request->hotel_room;
        $adults=$request->hotel_adults;
        $children=$request->hotel_child;
        $infant=$request->hotel_infant;
        // $checkinDate='2021-08-20';
        // $checkoutDate='2021-08-22';
        // $adults=1;
        // $children=5;

        if($children>0){
            $children_xml='<Children>
                <ChildAge>'.$children.'</ChildAge>
            </Children>';
        }else{
            $children_xml='';  
        }

        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';

        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>HotelSearch</RequestType>
                    </Head>
                    <Body>
                        <CityIds>
                            <CityId>'.$cityId.'</CityId>
                        </CityIds>
                        <CheckInDate>'.$checkinDate.'</CheckInDate>
                        <CheckOutDate>'.$checkoutDate.'</CheckOutDate>
                        <Rooms>
                            <Room>
                                <NumAdults>'.$adults.'</NumAdults>
                                '.$children_xml.'
                                
                            </Room>
                        </Rooms>
                        <Nationality>'.$country_code.'</Nationality>
                        <Currency>GBP</Currency>
                        <AvailableOnly>0</AvailableOnly>
                    </Body>
                </Request>';
        // return $xml;

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
        $data=[];
        $data1=collect();
        foreach($object as $json){
            // print_r($json);
            // echo "<br/><br/><br/>";
            // return $json['Head'];
            // return $json['Body'];
            // return $json['Body']['Hotels'];

            if(array_key_exists('Error',$json['Body'])){
                // return $json['Body']['Error'];
                // return $data;
            }else if(array_key_exists('Hotels',$json['Body'])){
                $hotels=$json['Body']['Hotels'];
                // return $hotels;
                
                // return $hotels['Hotel'];
                // return count($hotels);
                if(count($hotels)>0){
                    // return
                    if(array_key_exists('HotelId',$hotels['Hotel'])){
                        array_push($data,$hotels['Hotel']);
                        $data1->push(['Hotel' => $data]);
                    }else{
                        $data1->push(['Hotel' => Collect($hotels['Hotel'])]);
                        //array_push($data1,$hotels);
                    }
                    
                }
                // array_push($data,$hotels);
            }
            
        }
        // $arr1=["daa1","daa12"];
        // array_push($data,$arr1);
        // $data->push($arr1);

        // return $data1;
        $allhotelid=[];
        // return count($data[0]);
        // if(count($data[0])==1){
        //     // return $data[0];
        //     $hotel_id=$data[0]['Hotel']['HotelId'];
        //     array_push($allhotelid,$hotel_id);
        // }else{
            foreach ($data1[0] as $value2) {
                // return count($value2);
                // print_r($value2 ['HotelId']);
                for ($i=0; $i < count($value2); $i++) { 
                    // echo $i;
                    // return $value2[$i];
                    // print_r($value2[$i]['Options']['Option'][0]['TotalPrice']);
                    // return $value2[$i]['Options']['Option'][0]['TotalPrice'];
                    // return $value2[$i]['HotelId'];
                    $hotel_id=$value2[$i]['HotelId'];
                    array_push($allhotelid,$hotel_id);
                    // return $value2[$i]['Options'];
                    // return $value2[$i]['Options']['Option'][0];
                    // print_r($value2[$i]);
                    // echo "<br/><br/><br/>";
                }
            
            }
        // }
        // return $allhotelid;
        $hotelDetails=[];
        if(count($allhotelid)>0){
            $HotelIds='';
            foreach($allhotelid as $allhotelids){
                // echo $allhotelids;
                // echo "--";
                $HotelIds.='<HotelId>'.$allhotelids.'</HotelId>';
            }
            // return $HotelIds;
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
                                '.$HotelIds.'
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
        }
        // return $hotelDetails[0];
        // return $hotelDetails[0]['Facilities']['Facility'];
        // return $hotelDetails[0]['Images']['Image'][0];

        // return $hotelDetails[0]['HotelName'];
        // foreach($hotelDetails[0] as $hotelDetailss){
        //     // return $hotelDetailss;
        //     echo $hotelDetailss['HotelName'];
        //     echo $hotelDetailss['Description'];
        //     echo $hotelDetailss['Facilities']['Facility'];
        //     echo $hotelDetailss['Images']['Image'][0];
            
        // }
        // return $request;
        return view('hotel.hotels',[
            'hotels'=>$data1,
            'hotelDetails'=>$hotelDetails,
            'searched'=>$request
        ]);
    }
}
