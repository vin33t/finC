<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserLogin extends Model
{
    use HasFactory,Notifiable;
    protected $table='user_login';
    protected $fillable = [
        'user_id',
        'user_pass',
        'first_name',
        'last_name',
        'mobile',
        'user_type',
        'profile_img',
        'created_by',
        'updated_by',
    ]; 
}
