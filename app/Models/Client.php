<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';

    public function invoices()
    {
        return $this->hasMany('App\Models\invoice');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function family()
    {
        return $this->hasMany('App\Models\ClientFamily');
    }

    public function docs()
    {
        return $this->hasMany('App\Models\ClientDoc');
    }

    public function requests()
    {
        return $this->hasMany('App\Models\ClientRequests');
    }

    public function lead()
    {
        return $this->hasOne('App\Models\Leads');
    }
}
