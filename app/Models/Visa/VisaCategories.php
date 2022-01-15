<?php

namespace App\Models\Visa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaCategories extends Model
{
    use HasFactory;

    public function CountryPair(){
        return $this->hasMany('App\Models\Visa\CountryPairVisa','visaCategoryId');
    }
}
