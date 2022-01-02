<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirportCodes;
use App\Models\HotelCities;
use App\Models\HotelCurrency;

class HomeController extends Controller
{
    public function ShowIndex(){
        $hotel_currency=HotelCurrency::get();
        return view('index',['hotel_currency'=>$hotel_currency]);
    }

    public function SearchAirport1(Request $request){
        $query=$request->input('query');
        $data = AirportCodes::select("name","code")
        // ->where("code","LIKE","%{$query}%")
        ->where("name","LIKE","%{$query}%")
        ->orWhere("code","LIKE","%{$query}%")
        ->get();
        return response()->json($data);
        // return response($data);
    }
    public function SearchAirport(Request $request){
        return AirportCodes::search($request->get('q'))->select('name','code')->get()->map(function($airport){
            return $airport->name . ' ('. $airport->code.')';
        });
    }

    public function Error(){
        return view('error');
    }

    public function SearchHotel(Request $request){
        return HotelCities::search($request->get('q'))->select('city_name','country_code')->get()->map(function($airport){
        // return HotelCities::search($request->get('q'))->select('city_name','city_id')->get()->map(function($airport){
            // return $airport->city_name . ' ('. $airport->city_id.')';
            return $airport->city_name . ' ('. $airport->country_code.')';
        });
    }


    public function ContactUs(){
        return view('contact-us');
    }
}
