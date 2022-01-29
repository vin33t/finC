<?php

namespace App\Models\Visa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryPair extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function VisaTo(){
        return $this->belongsTo('App\Models\Visa\VisaCountries','visaCountryChildId');
    }
    public function VisaFrom(){
        return $this->belongsTo('App\Models\Visa\VisaCountries','visaCountryParentId');
    }

    public function Visa(){
        return $this->hasMany('App\Models\Visa\CountryPairVisa', 'visaCountryPairId');
    }
}
