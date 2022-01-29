<?php

namespace App\Models\Visa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryPairVisa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Category(){
        return $this->belongsTo('App\Models\Visa\VisaCategories','visaCategoryId');
    }
    public function Pair(){
        return $this->belongsTo('App\Models\Visa\CountryPair','visaCountryPairId');
    }

}
