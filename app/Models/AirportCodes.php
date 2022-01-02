<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

class AirportCodes extends Model
{
    use HasFactory,Notifiable,SearchableTrait;
    // protected $primaryKey = 'sl_no';
    protected $table='airport_codes';
    protected $fillable = [
        'id','name','code',
    ]; 

    protected $searchable = [
        'columns' => [
            'airport_codes.name' => 10,
            'airport_codes.code' => 5,
        ]
    ];
}
