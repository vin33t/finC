<?php

namespace App\Http\Controllers\hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigAPIController extends Controller
{
    public function HotelUser()
    {
        return "4e136e82c5b549a71dabbc9627cb4673";
    }

    public function HotelPass()
    {
        return "Y1qgGuaZiHN0";
    }

    public function HotelURL()
    {
        $url = "http://xmldemo.travellanda.com/xmlv1";
        return $url;
    }
}
