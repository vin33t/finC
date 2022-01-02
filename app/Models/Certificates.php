<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function invoice(){
        return $this->belongsTo('App\Models\invoice', 'invoice_id');
    }

    public function tenure(){
        return $this->belongsTo('App\Models\CertificateLog', 'certificate_log_id');
    }
}
