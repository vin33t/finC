<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HotelCities;
use App\Models\HotelCountries;
use App\Models\HotelCurrency;

class MasterController extends Controller
{
    // public function Index(){
    //     return "hii";
    // }
    // get hotel details 
    public function Index7(){
        // return "hii";
        // <HotelId>1009075</HotelId>

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
                            <HotelId>1378664</HotelId>
                            <HotelId>1672669</HotelId>
                            <HotelId>2453597</HotelId>
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
                $hotelDetails= $json['Body']['Hotels']['Hotel'];
                // array_push($hotelDetails,$hotels);
            }
        }
        return $hotelDetails;
    }
    //get hotels
    public function Index5(){
        // return "hii";
        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';
        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>GetHotels</RequestType>
                    </Head>
                    <Body>
                        <CountryCode>GB</CountryCode>
                    </Body>
                </Request>';


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=" . $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
    // get cities 
    public function Index(){
        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';
        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>GetCities</RequestType>
                    </Head>
                    <Body/>
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
            }else if(array_key_exists('Countries',$json['Body'])){
                $Countries=$json['Body']['Countries'];
                // return $Countries;
                $a=[];
                $b=collect();
                foreach($Countries as $Country){
                    foreach($Country as $Countryy){
                        // return $Countryy;
                        // return $Countryy['CountryCode'];
                        if(array_key_exists('Cities',$Countryy)){
                            // return $Countryy['Cities'];
                            // $count=1;
                            
                            foreach($Countryy['Cities']['City'] as $city){
                                // return $city;
                                // echo $count;
                                // echo $Countryy['CountryCode'];
                                // echo $city['CityId'];
                                // echo $city['CityName'];
                                // echo $city[0];
                                // echo "</br></br>";
                                // echo $city[1];
                                // echo "</br></br>";
                                // print_r($city);
                                // echo "</br></br>";
                                // $count++;
                                // HotelCountries::
                                // if (count($Countryy['Cities']['City'])>18402) {
                                $a['country_code']=isset($Countryy['CountryCode'])?$Countryy['CountryCode']:"mismatched";
                                $a['city_id']=isset($city['CityId'])?$city['CityId']:"mismatched";
                                $a['city_name']=isset($city['CityName'])?$city['CityName']:"mismatched";
                                // array_push($b,$a);
                                $b->push($a);
                                // HotelCities::create(array(
                                //     'country_code'=>isset($Countryy['CountryCode'])?$Countryy['CountryCode']:"mismatched",
                                //     'city_id'=>isset($city['CityId'])?$city['CityId']:"mismatched",
                                //     'city_name'=>isset($city['CityName'])?$city['CityName']:"mismatched",
                                // ));
                                // }

                            }
                        }

                    }
                }
                
            }
        }
        return $b;
        foreach($b as $c){
        //    echo $c['country_code'];
           HotelCities::create(array(
                'country_code'=>$c['country_code'],
                'city_id'=>$c['city_id'],
                'city_name'=>$c['city_name'],
            ));
            
        }

    }
    // Indexs
    public function Indexs(){
        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';
        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>GetCities</RequestType>
                    </Head>
                    <Body/>
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
        return $object;

        foreach($object as $json){
            if(array_key_exists('Error',$json['Body'])){
                // return $json['Body']['Error'];
                // return $data;
            }else if(array_key_exists('Countries',$json['Body'])){
                $Countries=$json['Body']['Countries'];
                // return $Countries;
                $a=[];
                $b=collect();
                foreach($Countries as $Country){
                    foreach($Country as $Countryy){
                        // return $Countryy;
                        // return $Countryy['CountryCode'];
                        if(array_key_exists('Cities',$Countryy)){
                            // return $Countryy['Cities'];
                            // $count=1;
                            
                            foreach($Countryy['Cities']['City'] as $city){
                                // return $city;
                                // echo $count;
                                // echo $Countryy['CountryCode'];
                                // echo $city['CityId'];
                                // echo $city['CityName'];
                                // echo $city[0];
                                // echo "</br></br>";
                                // echo $city[1];
                                // echo "</br></br>";
                                // print_r($city);
                                // echo "</br></br>";
                                // $count++;
                                // HotelCountries::
                                // if (count($Countryy['Cities']['City'])>18402) {
                                $a['country_code']=isset($Countryy['CountryCode'])?$Countryy['CountryCode']:"mismatched";
                                $a['city_id']=isset($city['CityId'])?$city['CityId']:"mismatched";
                                $a['city_name']=isset($city['CityName'])?$city['CityName']:"mismatched";
                                // array_push($b,$a);
                                $b->push($a);
                                // HotelCities::create(array(
                                //     'country_code'=>isset($Countryy['CountryCode'])?$Countryy['CountryCode']:"mismatched",
                                //     'city_id'=>isset($city['CityId'])?$city['CityId']:"mismatched",
                                //     'city_name'=>isset($city['CityName'])?$city['CityName']:"mismatched",
                                // ));
                                // }

                            }
                        }

                    }
                }
                
            }
        }
        // return $b;
        foreach($b as $c){
        //    echo $c['country_code'];
           HotelCities::create(array(
                'country_code'=>$c['country_code'],
                'city_id'=>$c['city_id'],
                'city_name'=>$c['city_name'],
            ));
            
        }

    }
    // get countries 
    public function Index1(){
        $Username='4e136e82c5b549a71dabbc9627cb4673';
        $Password='Y1qgGuaZiHN0';
        $url = "http://xmldemo.travellanda.com/xmlv1";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <Request>
                    <Head>
                        <Username>'.$Username.'</Username>
                        <Password>'.$Password.'</Password>
                        <RequestType>GetCountries</RequestType>
                    </Head>
                    <Body/>
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
            }else if(array_key_exists('Countries',$json['Body'])){
                $Countries=$json['Body']['Countries'];
                // return $Countries;
                foreach($Countries['Country'] as $Country){
                    // return $Country;
                    // return $Country['CountryCode'];
                    // return $Country['CountryName'];
                    HotelCountries::create(array(
                        'country_code'=>isset($Country['CountryCode'])?$Country['CountryCode']:"mismatched",
                        'country_name'=>isset($Country['CountryName'])?$Country['CountryName']:"mismatched",
                    ));

                }
                
                
            }
        }
    }

    // hotel search
    public function Test(){
        // return "hii";
        $checkinDate='2021-08-20';
        $checkoutDate='2021-08-22';
        $adults=1;
        $children=5;
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
                            <CityId>117976</CityId>
                        </CityIds>
                        <CheckInDate>'.$checkinDate.'</CheckInDate>
                        <CheckOutDate>'.$checkoutDate.'</CheckOutDate>
                        <Rooms>
                            <Room>
                                <NumAdults>'.$adults.'</NumAdults>
                                <Children>
                                    <ChildAge>'.$children.'</ChildAge>
                                </Children>
                            </Room>
                            
                        </Rooms>
                        <Nationality>IN</Nationality>
                        <Currency>USD</Currency>
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
        $object=$this->XMlToJSON($return);
        // return $object;
        $data=collect();
        // $data=[];

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
                // return $json['Body']['Hotels'];
                $data->push($json['Body']['Hotels']);
            }
            
        }
        // $arr1=["daa1","daa12"];
        // $data->push($arr1);

        return $data;
        foreach ($data as $value1) {
            foreach ($value1 as $value2) {
                // echo count($value2);
                // print_r($value ['HotelId']);

                for ($i=0; $i < count($value2); $i++) { 
                    echo $i;
                    print_r($value2[$i]);
                    echo "<br/><br/><br/>";
                }

                // foreach($value2 as $value3){
                //     print_r($value3['HotelId']);
                //     echo "<br/><br/><br/>";
                // }
                // echo "<br/><br/><br/>";
            }
        }

        
    }

    public function XMlToJSON($return){
        $dom = new \DOMDocument();
        $dom->loadXML($return);
        $json = new \FluentDOM\Serializer\Json\RabbitFish($dom);
        $object = json_decode($json,true);
        return $object;
    }
}
