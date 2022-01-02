<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

class HotelCities extends Model
{
    use HasFactory,Notifiable,SearchableTrait;
    // protected $primaryKey = 'sl_no';
    protected $table='hotel_cities';
    protected $fillable = [
        'country_code','city_id','city_name',
    ]; 

    protected $searchable = [
        'columns' => [
            'hotel_cities.city_id' => 10,
            'hotel_cities.city_name' => 5,
        ]
    ];
}
