<?php

namespace App\Http\Controllers\multicity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index(){
        return view('multicity.index');
    }
}
