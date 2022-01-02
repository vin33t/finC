<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Session;

class LoginController extends Controller
{
    public function ShowLogin(){
        return view('user.login');
    }

    public function Login(Request $request){
        // return $request;
        $user_details=UserLogin::where('user_id',$request->email)->where('user_type','U')->get();
        if(count($user_details)>0){
            // return $user_details;
            foreach($user_details as $user_detailss){
                $user_pass=$user_detailss->user_pass;
            }
            if(Hash::check($request->password, $user_pass)){
                session()->flush();
                Session::put('user_details', $user_details); 
                return redirect()->route('index');
                // return redirect()->route('dashboard');
            }else{
            return redirect()->back()->with('error','error');
            }
        }else{
            return redirect()->back()->with('error','error');
        }
    }

    public function Logout(){
        session()->flush();
        return redirect()->route('login');
    }

    public function ShowForget(){
        return view('user.forgot-password');
    }

    public function Forget(Request $request){
        // return $request;
        $is=UserLogin::where('user_id',$request->email)->get();
        if (count($is)>0) {
            // eyJpdiI6Ik5sNGZpc29rRE52N3VQZHdaQzhuTUE9PSIsInZhbHVlIjoiWlJsMUF0V255WWJ4THdzR3k5MXJQdEI3NG1KZHVYYkNqWUtSL0swRVIrRT0iLCJtYWMiOiI3YjA0MTU5NmM1MmQ2MzM2ZWY3NGM4NjFlNWViMTIyYjA0Yjc5NzUwOTk1YzA1NjFhODE2NGZlZDdkYjg0Mjc5In0=
            // return Crypt::encryptString($request->email);
            return redirect()->back()->with('success','success');
            // return $is;
        }else{
            return redirect()->back()->with('error','error');
        } 
    }

    public function ShowReset($emailid){
        $emailid=Crypt::decryptString($emailid);
        // return $emailid;
        $id=DB::table('user_login')->where('user_id',$emailid)->value('id');
        // return $id;
        return view('user.reset-password',['id'=>$id]);
        // $data=UserLogin::find($id);
        // $data->user_pass
    }

    public function Reset(Request $request){
        // return $request;
        $id=$request->id;
        $data=UserLogin::find($id);
        $data->user_pass =Hash::make($request->password);
        $data->save();
        return redirect()->back()->with('success','success');

    }
}
