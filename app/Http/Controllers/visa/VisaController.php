<?php

namespace App\Http\Controllers\visa;

use App\Http\Controllers\Controller;
use App\Models\Visa\VisaCountries;
use Illuminate\Http\Request;

class VisaController extends Controller
{
    public function details(Request $request){
//        dd($request->all());
        $visaFrom = VisaCountries::find($request->visaFrom);
        $visaTo = VisaCountries::find($request->visaTo);

        return view('visa.visa')->with([
            'visaFrom' => $visaFrom,
            'visaTo' => $visaTo
        ]);
    }
}
