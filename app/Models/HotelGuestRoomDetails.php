<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelGuestRoomDetails extends Model
{
    use HasFactory,Notifiable;
    protected $table='hotel_guest_room_details';
    protected $fillable = [
        'booking_reference',
        'pax_type',
        'room_no',
        'first_name',
        'last_name',
        'created_by',
        'updated_by',
    ]; 
}
