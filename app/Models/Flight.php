<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $table = 'flights';

    public function invoice()
    {
        return $this->belongsTo('App\Models\invoice');
    }
    
    public function passengers()
    {
        return $this->hasMany('App\Models\Passenger');
    }
}
