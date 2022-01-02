<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoiceInfo extends Model
{
    use HasFactory;
    protected $table = 'invoice_infos';
    
    public function invoice()
    {
        return $this->belongsTo('App\Models\invoice');
    }
}
