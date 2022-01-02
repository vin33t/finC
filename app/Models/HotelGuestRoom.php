<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelGuestRoom extends Model
{
    use HasFactory,Notifiable;
    protected $table='hotel_guest_room';
    protected $fillable = [
        'booking_reference',
        'room_name',
        'room_no',
        'num_adults',
        'num_children',
        'created_by',
        'updated_by',
    ]; 
}
