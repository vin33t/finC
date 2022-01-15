<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\HotelCities;
use App\Models\HotelCountries;
use DB;
use App\Models\HotelCurrency;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class HotelController extends Controller
{
    public function Search(Request $request){
        // return "hii";
        // return $request;
        $currency=$request->currency;
        $check_in = explode(' - ',$request->checkInOut)[0];
        $check_out = explode(' - ',$request->checkInOut)[1];
        // return $currency;
        if(isset(explode('(',$request->city_name)[0]) && isset(explode('(',$request->city_name)[1])){
            $city_name =  str_replace(')','',explode('(',$request->city_name)[0]);
            $country_code =  str_replace(')','',explode('(',$request->city_name)[1]);
        }else{
            // return "addFrom";
            return redirect()->route('errorPage')->with('searcherror','searcherror');
        }

        // return $city_name;
        $cityId=DB::table('hotel_cities')->where('country_code',$country_code)->where('city_name',$city_name)->value('city_id');
        // return $cityId;
        $checkinDate = Carbon::parse($check_in)->format('Y-m-d');
        $checkoutDate = Carbon::parse($check_out)->format('Y-m-d');

        $room=$request->hotel_room;
        // return $room;
        $xmldata='';
        for ($i=1; $i <= $room; $i++) {
            // echo $i;
            // echo "</br>";
            // room1_hotel_adults
            // room1_hotel_child
            // room1_hotel_infant
            $room_adult="room".$i."_hotel_adults";
            $room_child="room".$i."_hotel_child";
            $room_infant="room".$i."_hotel_infant";
            // return $room_child;
            $xmldata1='';
            if($request->$room_child>0){
                $xmldata1='<ChildAge>'.$request->$room_child.'</ChildAge>';
            }
            $xmldata2='';
            if($request->$room_infant>0){
                $xmldata2='<ChildAge>'.$request->$room_infant.'</ChildAge>';
            }

            $xmldata0='<Room>
                <NumAdults>'.$request->$room_adult.'</NumAdults>
                <Children>';

            $xmldata3='</Children>
            </Room>';
            $xmldata.=$xmldata0.$xmldata1.$xmldata2.$xmldata3;
        }
        // return $xmldata;

        $adults=$request->hotel_adults;
        $children=$request->hotel_child;
        $infant=$request->hotel_infant;
        // $checkinDate='2021-08-20';
        // $checkoutDate='2021-08-22';
        // $adults=1;
        // $children=5;

        // if($children>0 && $infant>0){
        //     $children_xml='<Children>
        //         <ChildAge>'.$children.'</ChildAge>
        //         <ChildAge>'.$infant.'</ChildAge>
        //     </Children>';
        // }else if($children>0){
        //     $children_xml='<Children>
        //         <ChildAge>'.$children.'</ChildAge>
        //     </Children>';
        // }else if($infant>0){
        //     $children_xml='<Children>
        //         <ChildAge>'.$infant.'</ChildAge>
        //     </Children>';
        // }else{
        //     $children_xml='';
        // }
        // return $children_xml;

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
                            '.$xmldata.'
                        </Rooms>
                        <Nationality>'.$country_code.'</Nationality>
                        <Currency>'.$currency.'</Currency>
                        <AvailableOnly>0</AvailableOnly>
                    </Body>
                </Request>';

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $return = curl_exec($ch);
        curl_close($ch);
        $object =app('App\Http\Controllers\XMlToParseDataController')->XMlToJSON($return);
        $data=[];
        $data1=collect();
        foreach($object as $json){
            if(array_key_exists('Error',$json['Body'])){
            }else if(array_key_exists('Hotels',$json['Body'])){
                $hotels=$json['Body']['Hotels'];

                if(count($hotels)>0){
                    if(array_key_exists('HotelId',$hotels['Hotel'])){
                        array_push($data,$hotels['Hotel']);
                        $data1->push(['Hotel' => $data]);
                    }else{
                        $data1->push(['Hotel' => Collect($hotels['Hotel'])]);
                    }

                }
            }

        }
        $allhotelid=[];
        $pricearr=[];
        if(count($data1)>0){
            foreach ($data1[0] as $value2) {
                for ($i=0; $i < count($value2); $i++) {
                    $hotel_id=$value2[$i]['HotelId'];
                    $price=isset($value2[$i]['Options']['Option'][0]['TotalPrice'])?json_decode($value2[$i]['Options']['Option'][0]['TotalPrice']):json_decode($value2[$i]['Options']['Option']['TotalPrice']);
                    array_push($allhotelid,$hotel_id);
                    array_push($pricearr,$price);
                }

            }
        }

        sort($pricearr);

        $hotelDetails=[];
        if(count($allhotelid)>0){
            $HotelIds='';
            foreach($allhotelid as $allhotelids){
                $HotelIds.='<HotelId>'.$allhotelids.'</HotelId>';
            }
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
        // return $hotelDetails;
        // return $hotelDetails[0];
        // return $hotelDetails[0]['Facilities']['Facility'];
        // return $hotelDetails[0]['Images']['Image'][0];

        // return $hotelDetails[0]['HotelName'];
        $allfacilities=[];
        foreach($hotelDetails as $hotelDetailss){
            // return $hotelDetailss;
            // for ($i=0; $i < count($hotelDetailss); $i++) {
            //     return $hotelDetailss['Facilities']['Facility'];
            // }
            // echo $hotelDetailss['HotelName'];
            // echo $hotelDetailss['Description'];
            // return $hotelDetailss['Facilities']['Facility'];
            // echo $hotelDetailss['Images']['Image'][0];
            if(isset($hotelDetailss['Facilities']['Facility'])){
                foreach($hotelDetailss['Facilities']['Facility'] as $facility){
                    // print_r($facility);
                    // echo "<br/>";
                    if(is_array($facility)){
                        if($facility['FacilityType'] =='Hotel Facilities'){
                            $Facility=$facility['FacilityName'];
                            array_push($allfacilities,$Facility);
                        }
                    }else{
                        $cateory=$hotelDetailss['Facilities']['Facility']['FacilityName'];
                        array_push($allfacilities,$cateory);
                        // print_r( $key." -- ".$facility);
                        // echo $hotelDetailss['Facilities']['Facility']['FacilityName'];
                        // echo "<br/>";
                    }
                }
            }

            // if($facility['FacilityType'] =='Hotel Facilities'){}


        }
        $allfacilities=array_unique($allfacilities);

        // return $data1;
        // $vl="2.5";
        // return json_decode($vl);
        // return $hotelDetails;
//        $data1 = $this->paginate($data1[0]['Hotel']);
        //dd($data1);
        //	$data1[0]['Hotel'] = $this->paginate($data1[0]['Hotel']);
        //dd($data1);
//        foreach($data1 as $data){
//            dd($data);
//        }
//        dd($data1);
//        dd($hotelDetails);
        $hotel_currency=HotelCurrency::get();
        return view('hotel.hotels',[
            'hotels'=>$data1,
            'hotelDetails'=>$hotelDetails,
            'searched'=>$request,
            'allfacilities'=>array_slice($allfacilities,0,8),
            'pricearr'=>$pricearr,
            'hotel_currency'=>$hotel_currency
        ]);
    }
    function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}


