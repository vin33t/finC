<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientDoc extends Model
{
    protected $table = 'client_docs';

    public function client()
    {
        return $this->belongsTo('App\client');
    }
}
