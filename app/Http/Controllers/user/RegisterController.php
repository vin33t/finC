<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Session;

class RegisterController extends Controller
{
    public function ShowRegister(){
        return view('user.register');
    }
    public function Register(Request $request){
        // return $request;
        $user_details=UserLogin::where('user_id',$request->email)->where('user_type','U')->get();
        if(count($user_details)>0){
            return redirect()->back()->with('error','error');
        }else{
            // return $request;
            UserLogin::create(array(
                'user_id'   =>$request->email,
                'user_pass' =>Hash::make($request->password),
                'first_name'=>$request->first_name    ,
                'last_name' =>$request->last_name,
                'mobile'    =>$request->phone,
                'user_type' =>"U" ,
                'created_by'=>$request->first_name ,
            ));
            return redirect()->back()->with('success','success');
        }
    }
}
