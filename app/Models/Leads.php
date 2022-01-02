<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $table = 'leads';

    public function user()
    {   
    	return $this->belongsTo('App\Models\User');
    }
    
    public function client()
    {   
    	return $this->belongsTo('App\Models\Client');
    }
}
