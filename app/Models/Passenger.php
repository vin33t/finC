<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    protected $table = 'passengers';
    
    public function flight()
    {
        return $this->belongsTo('App\Models\Flight');
    }
}
