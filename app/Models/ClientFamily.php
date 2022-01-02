<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFamily extends Model
{
    use HasFactory;
    protected $table = 'client_families';

    public function client()
    {
        return $this->belongsTo('App\client');
    }
}
