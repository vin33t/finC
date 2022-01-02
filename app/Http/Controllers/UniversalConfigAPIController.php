<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UniversalConfigAPIController extends Controller
{
    public function TARGETBRANCH(){
        return 'P7141733';
    }
    
    public function Provider(){
        return '1G';
    }

    public function CREDENTIALS(){
        return 'Universal API/uAPI4648209292-e1e4ba84:9Jw*C+4c/5';
    }
    
}
