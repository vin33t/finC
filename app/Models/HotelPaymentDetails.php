<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HotelPaymentDetails extends Model
{
    use HasFactory,Notifiable;
    protected $table='hotel_payment_details';
    protected $fillable = [
        'booking_reference',
        'payment_id',
        'room_charges',
        'gst',
        'convenience_fees',
        'taxes_and_fees',
        'created_by',
        'updated_by',
    ]; 
}
