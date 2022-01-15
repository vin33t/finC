<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test',[App\Http\Controllers\TestController::class,'Test']);
Route::get('/test1',[App\Http\Controllers\TestController::class,'Test1']);
Route::get('/showjson',[App\Http\Controllers\TestController::class,'ShowJson']);


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[App\Http\Controllers\HomeController::class,'ShowIndex']);
Route::get('/index',[App\Http\Controllers\HomeController::class,'ShowIndex'])->name('index');
Route::get('/searchairport',[App\Http\Controllers\HomeController::class,'SearchAirport'])->name('searchairport');
// Route::post('/searchairport',[App\Http\Controllers\HomeController::class,'SearchAirport'])->name('searchairport');


// Route::get('/flights',[App\Http\Controllers\FlightsController::class,'Search'])->name('flights');
Route::post('/flights',[App\Http\Controllers\FlightController::class,'Search'])->name('flights');
Route::get('/flights',[App\Http\Controllers\FlightController::class,'Search'])->name('flights');
// Route::post('/flightDetails',[App\Http\Controllers\FlightDetailsController::class,'FlightDetails'])->name('flightDetails');
Route::post('/flightDetails',[App\Http\Controllers\FlightController::class,'FlightDetails'])->name('flightDetails');

Route::post('/BaggageCancelRuleajax',[App\Http\Controllers\FlightDetailsController::class,'FlightDetails'])->name('BaggageCancelRuleajax');
Route::post('/BaggageCancelRuleReturnajax',[App\Http\Controllers\FlightDetailsController::class,'FlightDetailsReturn'])->name('BaggageCancelRuleReturnajax');

Route::post('/passengerDetails',[App\Http\Controllers\PassengerDetailsController::class,'PassengerDetails'])->name('passengerDetails');
// Route::get('/flightDetails',[App\Http\Controllers\FlightsController::class,'FlightDetails'])->name('flightDetails');
// Route::get('/passengerDetails',[App\Http\Controllers\FlightsController::class,'PassengerDetails'])->name('passengerDetails');
Route::post('/showpayment',[App\Http\Controllers\PaymentController::class,'ShowPayment'])->name('showpayment');
Route::post('/paymentcredit',[App\Http\Controllers\PaymentController::class,'PaymentCredit'])->name('paymentcredit');

Route::get('/confirmBooking',[App\Http\Controllers\FlightsController::class,'ConfirmBooking'])->name('confirmBooking');


                // round trip
Route::post('/roundflightDetails',[App\Http\Controllers\RoundFlightController::class,'FlightDetails'])->name('roundflightDetails');
Route::post('/roundpaymentcredit',[App\Http\Controllers\RoundPaymentController::class,'PaymentCredit'])->name('roundpaymentcredit');
Route::post('/roundBaggageCancelRuleReturnajax',[App\Http\Controllers\RoundFlightController::class,'FlightDetailsAJax'])->name('roundBaggageCancelRuleReturnajax');

            // Multi City
Route::get('/multicity',[App\Http\Controllers\multicity\HomeController::class,'Index'])->name('multicityindex');
Route::post('/multicityflight',[App\Http\Controllers\multicity\FlightController::class,'Search'])->name('multicityflight');
// Route::get('/multicityflight',[App\Http\Controllers\multicity\FlightController::class,'Search'])->name('multicityflight');
Route::post('/multicityflightdetails',[App\Http\Controllers\multicity\FlightDetailsController::class,'FlightDetails'])->name('multicityflightdetails');
Route::post('/multicitypassengerDetails',[App\Http\Controllers\multicity\PassengerDetailsController::class,'PassengerDetails'])->name('multicitypassengerDetails');

Route::post('/multicityshowpayment',[App\Http\Controllers\multicity\PaymentController::class,'ShowPayment'])->name('multicityshowpayment');
Route::post('/multicitypaymentcredit',[App\Http\Controllers\multicity\PaymentController::class,'PaymentCredit'])->name('multicitypaymentcredit');


// 404 not found page
Route::get('/errorPage',[App\Http\Controllers\HomeController::class,'Error'])->name('errorPage');



            // Start Hotel Section

Route::get('/searchhotel',[App\Http\Controllers\HomeController::class,'SearchHotel'])->name('searchhotel');

// Route::get('/hotels',[App\Http\Controllers\hotel\MasterController::class,'Index'])->name('hotels');
// Route::get('/hotelss',[App\Http\Controllers\hotel\MasterController::class,'Indexs'])->name('hotelss');


Route::post('/hotels',[App\Http\Controllers\hotel\HotelController::class,'Search'])->name('hotels');
Route::post('/hoteldetails',[App\Http\Controllers\hotel\HotelDetailsController::class,'Show'])->name('hoteldetails');
Route::post('/guestdetails',[App\Http\Controllers\hotel\GuestDetailsController::class,'Show'])->name('guestdetails');
Route::post('/hotelpayment',[App\Http\Controllers\hotel\PaymentController::class,'Show'])->name('hotelpayment');
Route::post('/hotelpaymentcredit',[App\Http\Controllers\hotel\PaymentController::class,'Confirm'])->name('hotelpaymentcredit');
// Route::post('/confirmbooking',[App\Http\Controllers\hotel\PaymentController::class,'Confirm'])->name('hotelpaymentcredit');


Route::get('/testhotel',[App\Http\Controllers\hotel\TestController::class,'Test'])->name('testhotel');

            // End Hotel Section

            // =================================================
    Route::get('/contactus',[App\Http\Controllers\HomeController::class,'ContactUs'])->name('contactus');

    Route::get('/login',[App\Http\Controllers\user\LoginController::class,'ShowLogin'])->name('login');
    Route::post('/login',[App\Http\Controllers\user\LoginController::class,'Login'])->name('login');
    Route::get('/logout',[App\Http\Controllers\user\LoginController::class,'Logout'])->name('logout');
    Route::get('/register',[App\Http\Controllers\user\RegisterController::class,'ShowRegister'])->name('register');
    Route::post('/register',[App\Http\Controllers\user\RegisterController::class,'Register'])->name('register');
    Route::get('/dashboard',[App\Http\Controllers\user\HomeController::class,'Show'])->name('dashboard');
    Route::post('/editprofile',[App\Http\Controllers\user\HomeController::class,'EditProfile'])->name('editprofile');
    Route::post('/passwordChange',[App\Http\Controllers\user\HomeController::class,'ChangePassword'])->name('passwordChange');
    Route::get('/bookinghotels',[App\Http\Controllers\user\HomeController::class,'BookingHotels'])->name('bookinghotels');
    Route::get('/generateinvoicehotel',[App\Http\Controllers\user\HomeController::class,'HotelInvoice'])->name('generateinvoicehotel');

    Route::get('/forgotpassword',[App\Http\Controllers\user\LoginController::class,'ShowForget'])->name('forgotpassword');
    Route::post('/forgotpassword',[App\Http\Controllers\user\LoginController::class,'Forget'])->name('forgotpassword');
    Route::get('/resetpassword/{emailid?}',[App\Http\Controllers\user\LoginController::class,'ShowReset'])->name('resetpassword');
    Route::post('/resetpassword',[App\Http\Controllers\user\LoginController::class,'Reset'])->name('resetpassword');


//        send Mail
Route::get('/sendmail',[App\Http\Controllers\hotel\TestController::class,'Send'])->name('sendmail');



Route::prefix('visa')->group(function() {
    Route::post('details',[App\Http\Controllers\visa\VisaController::class,'details'])->name('visa.details');
});
