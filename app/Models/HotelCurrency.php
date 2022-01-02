<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelCurrency extends Model
{
    use HasFactory,Notifiable;
    protected $table='hotel_currency';
    protected $fillable = [
        'currency','icon','created_by','updated_by',
    ]; 
}
