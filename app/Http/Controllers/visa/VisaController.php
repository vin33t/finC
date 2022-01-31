<?php

namespace App\Http\Controllers\visa;

use App\Http\Controllers\Controller;
use App\Models\Visa\CountryPair;
use App\Models\Visa\CountryPairVisa;
use App\Models\Visa\VisaCountries;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisaController extends Controller
{
    public function details(Request $request){
//        dd($request->all());
        $visaFrom = VisaCountries::find($request->visaFrom);
        $visaTo = VisaCountries::find($request->visaTo);
        $countryPair = CountryPair::where('visaCountryParentId',$request->visaFrom)->where('visaCountryChildId',$request->visaTo)->get();
        if($countryPair->count()){
            $countryPair = $countryPair->first();
        } else {
            return redirect()->back();
        }
        return view('visa.visa')->with([
            'visaFrom' => $visaFrom,
            'visaTo' => $visaTo,
            'countryPair'=> $countryPair
        ]);
    }

    public function apply($id, $type){
        $dt = Carbon::now();
        $dt->timezone('Asia/Kolkata');
        $date_today = $dt->timezone('Europe/London');
        $date = $date_today->toDateString();
        $visa = CountryPairVisa::find($id);
        return view('visa.apply')->with('visa',$visa)->with('type',$type)->with('date',$date);

    }
}
