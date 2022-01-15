<?php

namespace App\Models\Visa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryPair extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function VisaToCountry(){
        return $this->hasMany('App\Models\Visa\CountryPair','');
    }
}
