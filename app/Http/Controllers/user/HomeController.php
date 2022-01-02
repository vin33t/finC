<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\HotelCurrency;
use App\Models\HotelGuestDetails;
use App\Models\HotelGuestRoom;
use App\Models\HotelPaymentDetails;
use App\Models\HotelGuestRoomDetails;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('is_user');
    }

    public function Show(){
        $id=Session::get('user_details')[0]['id'];
        $details=UserLogin::where('id',$id)->get();
        return view('user.dashboard',['details'=>$details]);
    }

    public function EditProfile(Request $request){
        // return $request;
        $id=$request->id;
        $data=UserLogin::find($id);
        $profile_img='';
        if ($request->hasFile('file')) {
            $profile_pic_path = $request->file('file');
            $profile_img=date('YmdHis') .'_'.$id.'.'.$profile_pic_path->getClientOriginalExtension();
            // $image_resize=$this->resizeSCImageLarge($profile_pic_path);
            // $image_resize->save(public_path('gurudwara-image/' . $profilepicname));

            $destinationPath = public_path('user-image/');
            $profile_pic_path->move($destinationPath,$profile_img);

            if($data->profile_img!=null){
                $filesc = public_path('user-image/') . $data->profile_img;
                if (file_exists($filesc) != null) {
                    unlink($filesc);
                }
            } 

        }else{
            $profile_img= $data->profile_img;
        }
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        $data->mobile=$request->mobile;
        $data->profile_img=$profile_img;
        $data->save();

        return redirect()->back()->with('success','success');
    }

    public function ChangePassword(Request $request){
        // return $request;
        $id=$request->id;
        $data=UserLogin::find($id);
        $data->user_pass= Hash::make($request->new_password);
        $data->save();

        return redirect()->back()->with('success','success');
    }

    public function BookingHotels(){
        $id=Session::get('user_details')[0]['id'];
        // return Session::get('user_details')[0]['user_id'];
        $details=HotelGuestDetails::where('user_id',$id)->orderBy('created_at', 'desc')->get();
        // return $details;
        return view('user.hotels',['details'=>$details]);
    }
    public function HotelInvoice(Request $request){
        $booking_reference=$request->booking_reference;
        // return $booking_reference;
        $invoice_data= DB::table('hotel_guest_details')
                ->leftjoin('hotel_guest_room', 'hotel_guest_details.booking_reference', '=', 'hotel_guest_room.booking_reference')
                // ->leftjoin('hotel_guest_room_details', 'hotel_guest_room.booking_reference', '=', 'hotel_guest_room_details.booking_reference')
                ->leftjoin('hotel_payment_details', 'hotel_guest_room.booking_reference', '=', 'hotel_payment_details.booking_reference')
                ->select('hotel_guest_details.*', 'hotel_guest_room.*', 'hotel_payment_details.*')
                ->where('hotel_guest_details.booking_reference',$booking_reference)
                // ->where('td_sc_profile.on_off_flag', '=', "Y")
                // ->where('td_sc_profile.badge_type', '=', $badge_code)
                // ->where('td_sc_profile.trade_description', 'LIKE', "%{$search_trade_type}%")
                // ->where('td_sc_profile.sc_lat', '=', $lat)
                // ->where('td_sc_profile.sc_long', '=', $long)
                // ->where('td_sc_profile.booking_reference', '=', $booking_reference)
                ->orderBy('hotel_guest_details.created_at', 'desc')
                ->get();
        // return $invoice_data;
        $guest_details=HotelGuestRoomDetails::where('booking_reference',$booking_reference)->get();
        // return $guest_details;
        return view('user.invoice',['invoice_data'=>$invoice_data,'guest_details'=>$guest_details]);
    }
}
