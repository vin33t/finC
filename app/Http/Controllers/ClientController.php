<?php

namespace App\Http\Controllers;

use App\client;
use App\ClientFamily;
use App\employee;
use App\Invite;
use App\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $v =Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'county' => 'required',
            'country' => 'required',
            'DOB' => array('required','regex:/[0-9]{4,4}\-[0-9]{2}\-[0-9]{2}/'),
            'phone' => 'required',
        ]);
        if(employee::where('email', $request->email)->first()){
            $v->errors()->add('Email', 'Email exists as an employee');
            return redirect()->back()->withErrors($v)->withInput();
        }
        elseif(client::where('email', $request->email)->first()){
            $v->errors()->add('Email', 'Email exists as a client');
            return redirect()->back()->withErrors($v)->withInput();
        }
        elseif(User::where('email', $request->email)->first()){
            $v->errors()->add('Email', 'Email exists as an admin');
            return redirect()->back()->withErrors($v)->withInput();
        }
        else{
            if ($v->fails()) {
                return redirect()->back()->withErrors($v)->withInput();
            }
        }

        $test_client = client::where('unique_id','CLDC0001')->get();
        if ($test_client->count()>0) {
            $latest = client::orderBy('id','desc')->take(1)->get();
            $client_prev_no = $latest[0]->unique_id;
            $unique_id = 'CLDC000'.(substr($client_prev_no,4,7)+1);
        }
        else{
            $unique_id = 'CLDC0001';
        }

        $client = new client;
        $client->unique_id = $unique_id;
        $client->creator_id = Auth::user()->id;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->address = $request->address;
        $client->postal_code = $request->postal_code;
        $client->city = $request->city;
        $client->county = $request->county;
        $client->country = $request->country;
        $client->DOB = Carbon::parse($request->DOB)->format('d-m-Y');
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->permanent = $request->permanent;
        $client->client_type = $request->client_type;
        if ($request->permanent == 1 ){
            $client->currency = $request->currency;
            $client->credit_limit = $request->credit_limit;
        }
        $client->passport = $request->passport;
        if ($request->passport == 1 ) {
            $client->passport_no = $request->passport_no;

            $client->passport_expiry_date =$request->passport_expiry_date;
            //  $client->passport_expiry_date = $request->passport_expiry_date;
            //    $client->passport_issue_date = $request->passport_issue_date;
            $client->passport_issue_date =$request->passport_issue_date;
            $client->passport_place = $request->passport_place;
            if($request->hasFile('passport_front')){
                $passport_front = $request->passport_front;
                $passport_front_new_name = time().$passport_front->getClientOriginalName();
                $passport_front->move('uploads/passport',$passport_front_new_name);
                $client->passport_front = 'uploads/passport/'.$passport_front_new_name;
            }
            if($request->hasFile('passport_back')){
                $passport_back = $request->passport_back;
                $passport_back_new_name = time().$passport_back->getClientOriginalName();
                $passport_back->move('uploads/passport',$passport_back_new_name);
                $client->passport_back = 'uploads/passport/'.$passport_back_new_name;
            }
            if($request->hasFile('letter')){
                $letter = $request->letter;
                $letter_new_name = time().$letter->getClientOriginalName();
                $letter->move('uploads/passport',$letter_new_name);
                $letter->move('uploads/passport',$letter_new_name);
                $client->letter = 'uploads/passport/'.$letter_new_name;
            }
        }
        $client->save();
        if($request->member_name){
            foreach($request->member_name as $index=>$member_name){
                $client_family = new ClientFamily;
                $client_family->client_id = $client->id;
                $client_family->member_name = $member_name;

                //	$client_family->passport_expiry_date=Carbon::parse($request->passport_expiry_date[$index])->format('d-m-Y');
                $client_family->passport_expiry_date= $request->passport_expiry_date[$index];

                //	$client_family->passport_issue_date=Carbon::parse($request->passport_issue_date[$index])->format('d-m-Y');
                $client_family->passport_issue_date=$request->passport_issue_date[$index];

                //   $client_family->member_DOB = Carbon::parse($request->member_DOB[$index])->format('d-m-Y');
                $client_family->member_DOB =date("d-m-Y",strtotime($request->member_DOB[$index]));

                $client_family->member_passport_no = $request->member_passport_no[$index];
                $client_family->member_passport_place = $request->member_passport_place[$index];
                if($request->hasFile('member_passport_front')){
                    $member_passport_front = $request->member_passport_front[$index];
                    $member_passport_front_new_name = time().$member_passport_front->getClientOriginalName();
                    $member_passport_front->move('uploads/passport',$member_passport_front_new_name);
                    $client_family->member_passport_front = 'uploads/passport/'.$member_passport_front_new_name;
                }
                if($request->hasFile('member_passport_back')){
                    $member_passport_back = $request->member_passport_back[$index];
                    $member_passport_back_new_name = time().$member_passport_back->getClientOriginalName();
                    $member_passport_back->move('uploads/passport',$member_passport_back_new_name);
                    $client_family->member_passport_back = 'uploads/passport/'.$member_passport_back_new_name;
                }
                $client_family->save();
            }
        }
        if ($request->passport == 1 and $client->confirmation == 0) {
            do {
                $token = str_random();
            }while (client::where('token', $token)->first());
            $client->token = $token;
            $client->save();
            $contactEmail = $client->email;
            Mail::send('emails.clientConfirmation',['token'=>$token,'name'=>$client->first_name.' '.$client->last_name,'client'=>$client], function($message) use ($contactEmail)
            {
                $message->to($contactEmail)->subject( 'Regards permission for keeping your documents and Personal Details' );
            });
        }

        do {
            $token = str_random();
        } while (Invite::where('token', $token)->first());

        $invite = new Invite;
        $invite->email = $client->email;
        $invite->token = $token;
        $invite->save();
        $client->invite_id = $invite->id;
        $client->save();
        $contactEmail = $client->email;
        $data = array('token'=>$token,'name'=>$client->first_name.' '.$client->last_name);
        Mail::send('emails.inviteClient', $data, function($message) use ($contactEmail)
        {
            $message->to($contactEmail)->subject('Activate Your Account!!');
        });
        Session::flash('success','Client Created Successfully');
        return redirect()->route('clients');
    }

}
