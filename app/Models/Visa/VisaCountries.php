<?php

namespace App\Models\Visa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaCountries extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function CountryPair(){
        return $this->hasMany('App\Models\Visa\CountryPair','visaCountryParentId');
    }
}
