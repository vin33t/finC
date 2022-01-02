<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelGuestDetails extends Model
{
    use HasFactory,Notifiable;
    protected $table='hotel_guest_details';
    protected $fillable = [
        'user_id',
        'booking_reference',
        'booking_status',
        'payment_status',
        'booking_time',
        'your_reference',
        'currency',
        'total_price',
        'hotel_id',
        'hotel_name',
        'city',
        'check_in_date',
        'check_out_date',
        'leader_name',
        'nationality',
        'board_type',
        'cancellation_deadline',
        'post_code',
        'add_1',
        'add_2',
        'guest_city',
        'country',
        'mobile',
        'email',
        'created_by',
        'updated_by',
    ]; 
}
