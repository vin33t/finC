<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirportCodes;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Arr;
use App\Models\Countries;

class PassengerDetailsController extends Controller
{
    public function PassengerDetails(Request $request){
        // return $request;
        $flights=json_decode($request->flights,true);
        $return_flights=json_decode($request->return_flights,true);
        // return $flight;
        // foreach($flight as $flights){
        //     print_r($flights);
        //     echo "<br/><br/>";
        //     echo $flights[2]['price']['TotalPrice'];
        // }
        // echo $flight[2]['price']['TotalPrice'];
        // return 

        $countries=Countries::get();
        // return $countries;
        return view('flights.passenger-details',[
            'data'=>$flights,
            'return_flights'=>$return_flights,
            'per_flight_details'=>$request,
            'countries'=>$countries
        ]);
    } 
}
