<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelCountries extends Model
{
    use HasFactory,Notifiable;
    protected $table='hotel_countries';
    protected $fillable = [
        'country_code','country_name',
    ]; 
}
