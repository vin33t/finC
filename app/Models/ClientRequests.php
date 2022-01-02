<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequests extends Model
{
    use HasFactory;
    protected $table = 'client_requests';

    public function client()
    {
        return $this->belongsTo('App\client');
    }
}
