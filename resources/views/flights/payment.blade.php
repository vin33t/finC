@extends('common.master')
@section('content')


<?php 
    $country_code=$per_flight_details->country_code;
    if($country_code==''){
        $country_code='GB'; 
    }
    $currency_code=DB::table('countries')->where('country_code',$country_code)->value('currency_code');
    $currency_symbal=DB::table('countries')->where('country_code',$country_code)->value('currency_symbal');
?>
<section class="search-packages bg-light-gray py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="confirmation-step">
                    <li><a href="#" class="active"><span>1</span> Flight Details</a></li>
                    <li><a href="#" class="active"><span>2</span> Passenger Details</a></li>
                    <li><a href="#" class="active"><span>3</span> Payment</a></li>
                    <li><a href="#"><span>4</span> Confirm</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <h4 class="font-weight-500">Payment Details</h4><hr>
                    <!-- <form class="passanger-details" action=""> -->
                        <div id="accordion" class="w-100 passanger-details">
                            <div class="card-body border rounded set mb-3">
                                <div class="card-header bg-primary-light font-weight-500 h6 border-0" id="headingOne">
                                    <a href="javascript:void(0)" class="" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                                        Credit or Debit Card
                                    </a>
                                </div>
                                <form name="credit_or_debit" method="POST" action="@if(isset($return_flights)){{route('roundpaymentcredit')}}@else{{route('paymentcredit')}}@endif">
                                @csrf
                                <div id="collapse1" class="collapse show mt-2" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="alert alert-warning"><i class="las la-credit-card"></i> We also accept <b>International Cards</b> for payments on transaction. </div>
                                    <img src="{{ asset('public/images/payment-cards.png') }}" alt="cards" class="img-fluid"/>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Card Number</label>
                                                <input type="text" class="form-control" placeholder="Enter Number" name=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name on Card</label>
                                                <input type="text" class="form-control" placeholder="Enter Name" name=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Expiry Date</label>
                                                <input type="text" maxlength="4" class="form-control" placeholder="MM/YY" name=""/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>CVV</label>
                                                <input type="password" maxkength="4" class="form-control" placeholder="" name=""/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @for($i=1;$i<=$per_flight_details->adults; $i++)
                                    <input type="hidden" name="title{{$i}}" id="title{{$i}}" value="<?php  $title='title'.$i; echo $per_flight_details->$title;?>" />
                                    <input type="hidden" name="first_name{{$i}}" id="first_name{{$i}}" value="<?php  $first_name='first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                    <input type="hidden" name="last_name{{$i}}" id="last_name{{$i}}" value="<?php  $last_name='last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                    <input type="hidden" name="gender{{$i}}" id="gender{{$i}}" value="<?php  $gender='gender'.$i; echo $per_flight_details->$gender;?>" />
                                    <input type="hidden" name="date_of_birth{{$i}}" id="date_of_birth{{$i}}" value="<?php  $date_of_birth='date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                    <input type="hidden" name="seating{{$i}}" id="seating{{$i}}" value="<?php  $seating='seating'.$i; echo $per_flight_details->$seating;?>" />
                                    <input type="hidden" name="assistance{{$i}}" id="assistance{{$i}}" value="<?php  $assistance='assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                    <input type="hidden" name="meal{{$i}}" id="meal{{$i}}" value="<?php $meal='meal'.$i; echo $per_flight_details->$meal;?>" />
                                    @endfor
                                    @for($i=1;$i<=$per_flight_details->children; $i++)
                                    <input type="hidden" name="children_title{{$i}}" id="children_title{{$i}}" value="<?php  $title='children_title'.$i; echo $per_flight_details->$title;?>" />
                                    <input type="hidden" name="children_first_name{{$i}}" id="children_first_name{{$i}}" value="<?php  $first_name='children_first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                    <input type="hidden" name="children_last_name{{$i}}" id="children_last_name{{$i}}" value="<?php  $last_name='children_last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                    <input type="hidden" name="children_gender{{$i}}" id="children_gender{{$i}}" value="<?php  $gender='children_gender'.$i; echo $per_flight_details->$gender;?>" />
                                    <input type="hidden" name="children_date_of_birth{{$i}}" id="children_date_of_birth{{$i}}" value="<?php  $date_of_birth='children_date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                    <input type="hidden" name="children_seating{{$i}}" id="children_seating{{$i}}" value="<?php  $seating='children_seating'.$i; echo $per_flight_details->$seating;?>" />
                                    <input type="hidden" name="children_assistance{{$i}}" id="children_assistance{{$i}}" value="<?php  $assistance='children_assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                    <input type="hidden" name="children_meal{{$i}}" id="children_meal{{$i}}" value="<?php $meal='children_meal'.$i; echo $per_flight_details->$meal;?>" />
                                    @endfor

                                    @for($i=1;$i<=$per_flight_details->infant; $i++)
                                    <input type="hidden" name="infant_title{{$i}}" id="infant_title{{$i}}" value="<?php  $title='infant_title'.$i; echo $per_flight_details->$title;?>" />
                                    <input type="hidden" name="infant_first_name{{$i}}" id="infant_first_name{{$i}}" value="<?php  $first_name='infant_first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                    <input type="hidden" name="infant_last_name{{$i}}" id="infant_last_name{{$i}}" value="<?php  $last_name='infant_last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                    <input type="hidden" name="infant_gender{{$i}}" id="infant_gender{{$i}}" value="<?php  $gender='infant_gender'.$i; echo $per_flight_details->$gender;?>" />
                                    <input type="hidden" name="infant_date_of_birth{{$i}}" id="infant_date_of_birth{{$i}}" value="<?php  $date_of_birth='infant_date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                    <input type="hidden" name="infant_seating{{$i}}" id="infant_seating{{$i}}" value="<?php  $seating='infant_seating'.$i; echo $per_flight_details->$seating;?>" />
                                    <input type="hidden" name="infant_assistance{{$i}}" id="infant_assistance{{$i}}" value="<?php  $assistance='infant_assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                    <input type="hidden" name="infant_meal{{$i}}" id="infant_meal{{$i}}" value="<?php $meal='infant_meal'.$i; echo $per_flight_details->$meal;?>" />
                                    @endfor

                                    <input type="hidden" name="postcode" id="postcode" value="{{$per_flight_details->postcode}}" />
                                    <input type="hidden" name="add_1" id="add_1" value="{{$per_flight_details->add_1}}" />
                                    <input type="hidden" name="add_2" id="add_2" value="{{$per_flight_details->add_2}}" />
                                    <input type="hidden" name="city" id="city" value="{{$per_flight_details->city}}" />
                                    <input type="hidden" name="state_code" id="state_code" value="{{$per_flight_details->state_code}}" />
                                    <input type="hidden" name="country" id="country" value="{{$per_flight_details->country}}" />

                                    <input type="hidden" name="email" id="email" value="{{$per_flight_details->email}}" />
                                    <input type="hidden" name="mob_no" id="mob_no" value="{{$per_flight_details->mob_no}}" />

                                    <input type="hidden" name="adults" id="adults" value="{{$per_flight_details->adults}}" />
                                    <input type="hidden" name="children" id="children" value="{{$per_flight_details->children}}" />
                                    <input type="hidden" name="infant" id="infant" value="{{$per_flight_details->infant}}" />
                                    <input type="hidden" name="country_code" id="country_code" value="{{$per_flight_details->country_code}}" />
                                    <!-- <input type="text" name="passenger_details" id="passenger_details" value="" /> -->
                                    @if(isset($return_flights))
                                    <input type="hidden" name="return_flight" id="return_flight" value="{{json_encode($return_flights)}}" />
                                    <input type="submit" name="" id="submit_credit" class="btn btn-primary" value="Pay {{$currency_symbal}} {{number_format((float)(str_replace($currency_code,'',$return_flights[2]['price']['ApproximateBasePrice']))+(str_replace($currency_code,'',$return_flights[2]['price']['Taxes'])),2, '.', '')}}" />
                                    @else
                                    <input type="hidden" name="flight" id="flight" value="{{json_encode($data)}}" />
                                    <input type="submit" name="" id="submit_credit" class="btn btn-primary" value="Pay {{$currency_symbal}} {{number_format((float)(str_replace($currency_code,'',$data[2]['price']['ApproximateBasePrice']))+(str_replace($currency_code,'',$data[2]['price']['Taxes'])),2,'.', '')}}" />
                                    <!-- <a href="confirm-booking.php" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a> -->
                                    @endif
                                </div>
                                </form>
                            </div>
                            <div class="card-body border rounded set mb-3">
                                <div class="card-header bg-primary-light font-weight-500 h6 border-0" id="headingTwo">
                                    <a href="javascript:void(0)" class="collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapseTwo">
                                        Net Banking
                                    </a>
                                </div>
                                <div id="collapse2" class="collapse mt-2" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="SBI" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="SBI">SBI</span>
                                                        <img src="{{ asset('public/images/sbi.png') }}" alt="SBI"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="ICICI" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="ICICI">ICICI</span>
                                                        <img src="{{ asset('public/images/icici.png') }}" alt="ICICI"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="HDFC" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="HDFC">HDFC</span>
                                                        <img src="{{ asset('public/images/HDFC.png') }}" alt="HDFC"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="AXIS" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="AXIS">AXIS</span>
                                                        <img src="{{ asset('public/images/AXIS.png') }}" alt="AXIS"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                            <label class="custom-control-label" for="customCheck">By clicking on Pay , I agree to accept the <a href="#">Booking Terms</a> & Cloud Travels General <a href="#">Terms of use and services</a></label>
                                        </div>
                                        <form name="credit_or_debit" method="POST" action="@if(isset($return_flights)){{route('roundpaymentcredit')}}@else{{route('paymentcredit')}}@endif">
                                        @csrf
                                            @for($i=1;$i<=$per_flight_details->adults; $i++)
                                            <input type="hidden" name="title{{$i}}" id="title{{$i}}" value="<?php  $title='title'.$i; echo $per_flight_details->$title;?>" />
                                            <input type="hidden" name="first_name{{$i}}" id="first_name{{$i}}" value="<?php  $first_name='first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                            <input type="hidden" name="last_name{{$i}}" id="last_name{{$i}}" value="<?php  $last_name='last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                            <input type="hidden" name="gender{{$i}}" id="gender{{$i}}" value="<?php  $gender='gender'.$i; echo $per_flight_details->$gender;?>" />
                                            <input type="hidden" name="date_of_birth{{$i}}" id="date_of_birth{{$i}}" value="<?php  $date_of_birth='date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                            <input type="hidden" name="seating{{$i}}" id="seating{{$i}}" value="<?php  $seating='seating'.$i; echo $per_flight_details->$seating;?>" />
                                            <input type="hidden" name="assistance{{$i}}" id="assistance{{$i}}" value="<?php  $assistance='assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                            <input type="hidden" name="meal{{$i}}" id="meal{{$i}}" value="<?php $meal='meal'.$i; echo $per_flight_details->$meal;?>" />
                                            @endfor
                                            @for($i=1;$i<=$per_flight_details->children; $i++)
                                            <input type="hidden" name="children_title{{$i}}" id="children_title{{$i}}" value="<?php  $title='children_title'.$i; echo $per_flight_details->$title;?>" />
                                            <input type="hidden" name="children_first_name{{$i}}" id="children_first_name{{$i}}" value="<?php  $first_name='children_first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                            <input type="hidden" name="children_last_name{{$i}}" id="children_last_name{{$i}}" value="<?php  $last_name='children_last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                            <input type="hidden" name="children_gender{{$i}}" id="children_gender{{$i}}" value="<?php  $gender='children_gender'.$i; echo $per_flight_details->$gender;?>" />
                                            <input type="hidden" name="children_date_of_birth{{$i}}" id="children_date_of_birth{{$i}}" value="<?php  $date_of_birth='children_date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                            <input type="hidden" name="children_seating{{$i}}" id="children_seating{{$i}}" value="<?php  $seating='children_seating'.$i; echo $per_flight_details->$seating;?>" />
                                            <input type="hidden" name="children_assistance{{$i}}" id="children_assistance{{$i}}" value="<?php  $assistance='children_assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                            <input type="hidden" name="children_meal{{$i}}" id="children_meal{{$i}}" value="<?php $meal='children_meal'.$i; echo $per_flight_details->$meal;?>" />
                                            @endfor

                                            @for($i=1;$i<=$per_flight_details->infant; $i++)
                                            <input type="hidden" name="infant_title{{$i}}" id="infant_title{{$i}}" value="<?php  $title='infant_title'.$i; echo $per_flight_details->$title;?>" />
                                            <input type="hidden" name="infant_first_name{{$i}}" id="infant_first_name{{$i}}" value="<?php  $first_name='infant_first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                            <input type="hidden" name="infant_last_name{{$i}}" id="infant_last_name{{$i}}" value="<?php  $last_name='infant_last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                            <input type="hidden" name="infant_gender{{$i}}" id="infant_gender{{$i}}" value="<?php  $gender='infant_gender'.$i; echo $per_flight_details->$gender;?>" />
                                            <input type="hidden" name="infant_date_of_birth{{$i}}" id="infant_date_of_birth{{$i}}" value="<?php  $date_of_birth='infant_date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                            <input type="hidden" name="infant_seating{{$i}}" id="infant_seating{{$i}}" value="<?php  $seating='infant_seating'.$i; echo $per_flight_details->$seating;?>" />
                                            <input type="hidden" name="infant_assistance{{$i}}" id="infant_assistance{{$i}}" value="<?php  $assistance='infant_assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                            <input type="hidden" name="infant_meal{{$i}}" id="infant_meal{{$i}}" value="<?php $meal='infant_meal'.$i; echo $per_flight_details->$meal;?>" />
                                            @endfor

                                            <input type="hidden" name="postcode" id="postcode" value="{{$per_flight_details->postcode}}" />
                                            <input type="hidden" name="add_1" id="add_1" value="{{$per_flight_details->add_1}}" />
                                            <input type="hidden" name="add_2" id="add_2" value="{{$per_flight_details->add_2}}" />
                                            <input type="hidden" name="city" id="city" value="{{$per_flight_details->city}}" />
                                            <input type="hidden" name="state_code" id="state_code" value="{{$per_flight_details->state_code}}" />
                                            <input type="hidden" name="country" id="country" value="{{$per_flight_details->country}}" />

                                            <input type="hidden" name="email" id="email" value="{{$per_flight_details->email}}" />
                                            <input type="hidden" name="mob_no" id="mob_no" value="{{$per_flight_details->mob_no}}" />

                                            <input type="hidden" name="adults" id="adults" value="{{$per_flight_details->adults}}" />
                                            <input type="hidden" name="children" id="children" value="{{$per_flight_details->children}}" />
                                            <input type="hidden" name="infant" id="infant" value="{{$per_flight_details->infant}}" />
                                    <input type="hidden" name="country_code" id="country_code" value="{{$per_flight_details->country_code}}" />
                                            <!-- <input type="text" name="passenger_details" id="passenger_details" value="" /> -->
                                            @if(isset($return_flights))
                                            <input type="hidden" name="return_flight" id="return_flight" value="{{json_encode($return_flights)}}" />
                                            <input type="submit" name="" id="submit_credit" class="btn btn-primary" value="Pay {{$currency_symbal}} {{number_format((float)(str_replace($currency_code,'',$return_flights[2]['price']['ApproximateBasePrice']))+(str_replace($currency_code,'',$return_flights[2]['price']['Taxes'])),2, '.', '')}}" />
                                            @else
                                            <input type="hidden" name="flight" id="flight" value="{{json_encode($data)}}" />
                                            <input type="submit" name="" id="submit_credit" class="btn btn-primary" value="Pay {{$currency_symbal}} {{number_format((float)(str_replace($currency_code,'',$data[2]['price']['ApproximateBasePrice']))+(str_replace($currency_code,'',$data[2]['price']['Taxes'])),2,'.', '')}}" />
                                            <!-- <a href="confirm-booking.php" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a> -->
                                            @endif
                                        <!-- <a href="confirm-booking.php" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a> -->
                                        </form>
                                </div>
                            </div>
                            <div class="card-body border rounded set mb-3">
                                <div class="card-header bg-primary-light font-weight-500 h6" id="headingThree">
                                    <a href="javascript:void(0)" class="collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapseThree">
                                        Paypal
                                    </a>
                                </div>
                                <div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="custom-control custom-radio align-items-center d-flex">
                                            <input type="radio" class="custom-control-input" id="paypal" name="bank" value="">
                                            <span class="custom-control-label mr-2" for="paypal">Paypal</span>
                                            <img src="{{ asset('public/images/paypal.png') }}" alt="paypal" class="ml-auto" style="width:150px;"/>
                                        </div>
                                        <form name="credit_or_debit" method="POST" action="@if(isset($return_flights)){{route('roundpaymentcredit')}}@else{{route('paymentcredit')}}@endif">
                                        @csrf
                                            @for($i=1;$i<=$per_flight_details->adults; $i++)
                                            <input type="hidden" name="title{{$i}}" id="title{{$i}}" value="<?php  $title='title'.$i; echo $per_flight_details->$title;?>" />
                                            <input type="hidden" name="first_name{{$i}}" id="first_name{{$i}}" value="<?php  $first_name='first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                            <input type="hidden" name="last_name{{$i}}" id="last_name{{$i}}" value="<?php  $last_name='last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                            <input type="hidden" name="gender{{$i}}" id="gender{{$i}}" value="<?php  $gender='gender'.$i; echo $per_flight_details->$gender;?>" />
                                            <input type="hidden" name="date_of_birth{{$i}}" id="date_of_birth{{$i}}" value="<?php  $date_of_birth='date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                            <input type="hidden" name="seating{{$i}}" id="seating{{$i}}" value="<?php  $seating='seating'.$i; echo $per_flight_details->$seating;?>" />
                                            <input type="hidden" name="assistance{{$i}}" id="assistance{{$i}}" value="<?php  $assistance='assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                            <input type="hidden" name="meal{{$i}}" id="meal{{$i}}" value="<?php $meal='meal'.$i; echo $per_flight_details->$meal;?>" />
                                            @endfor
                                            @for($i=1;$i<=$per_flight_details->children; $i++)
                                            <input type="hidden" name="children_title{{$i}}" id="children_title{{$i}}" value="<?php  $title='children_title'.$i; echo $per_flight_details->$title;?>" />
                                            <input type="hidden" name="children_first_name{{$i}}" id="children_first_name{{$i}}" value="<?php  $first_name='children_first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                            <input type="hidden" name="children_last_name{{$i}}" id="children_last_name{{$i}}" value="<?php  $last_name='children_last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                            <input type="hidden" name="children_gender{{$i}}" id="children_gender{{$i}}" value="<?php  $gender='children_gender'.$i; echo $per_flight_details->$gender;?>" />
                                            <input type="hidden" name="children_date_of_birth{{$i}}" id="children_date_of_birth{{$i}}" value="<?php  $date_of_birth='children_date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                            <input type="hidden" name="children_seating{{$i}}" id="children_seating{{$i}}" value="<?php  $seating='children_seating'.$i; echo $per_flight_details->$seating;?>" />
                                            <input type="hidden" name="children_assistance{{$i}}" id="children_assistance{{$i}}" value="<?php  $assistance='children_assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                            <input type="hidden" name="children_meal{{$i}}" id="children_meal{{$i}}" value="<?php $meal='children_meal'.$i; echo $per_flight_details->$meal;?>" />
                                            @endfor

                                            @for($i=1;$i<=$per_flight_details->infant; $i++)
                                            <input type="hidden" name="infant_title{{$i}}" id="infant_title{{$i}}" value="<?php  $title='infant_title'.$i; echo $per_flight_details->$title;?>" />
                                            <input type="hidden" name="infant_first_name{{$i}}" id="infant_first_name{{$i}}" value="<?php  $first_name='infant_first_name'.$i; echo $per_flight_details->$first_name;?>" />
                                            <input type="hidden" name="infant_last_name{{$i}}" id="infant_last_name{{$i}}" value="<?php  $last_name='infant_last_name'.$i; echo $per_flight_details->$last_name;?>" />
                                            <input type="hidden" name="infant_gender{{$i}}" id="infant_gender{{$i}}" value="<?php  $gender='infant_gender'.$i; echo $per_flight_details->$gender;?>" />
                                            <input type="hidden" name="infant_date_of_birth{{$i}}" id="infant_date_of_birth{{$i}}" value="<?php  $date_of_birth='infant_date_of_birth'.$i; echo $per_flight_details->$date_of_birth;?>" />
                                            <input type="hidden" name="infant_seating{{$i}}" id="infant_seating{{$i}}" value="<?php  $seating='infant_seating'.$i; echo $per_flight_details->$seating;?>" />
                                            <input type="hidden" name="infant_assistance{{$i}}" id="infant_assistance{{$i}}" value="<?php  $assistance='infant_assistance'.$i; echo $per_flight_details->$assistance;?>" />
                                            <input type="hidden" name="infant_meal{{$i}}" id="infant_meal{{$i}}" value="<?php $meal='infant_meal'.$i; echo $per_flight_details->$meal;?>" />
                                            @endfor

                                            <input type="hidden" name="postcode" id="postcode" value="{{$per_flight_details->postcode}}" />
                                            <input type="hidden" name="add_1" id="add_1" value="{{$per_flight_details->add_1}}" />
                                            <input type="hidden" name="add_2" id="add_2" value="{{$per_flight_details->add_2}}" />
                                            <input type="hidden" name="city" id="city" value="{{$per_flight_details->city}}" />
                                            <input type="hidden" name="state_code" id="state_code" value="{{$per_flight_details->state_code}}" />
                                            <input type="hidden" name="country" id="country" value="{{$per_flight_details->country}}" />

                                            <input type="hidden" name="email" id="email" value="{{$per_flight_details->email}}" />
                                            <input type="hidden" name="mob_no" id="mob_no" value="{{$per_flight_details->mob_no}}" />

                                            <input type="hidden" name="adults" id="adults" value="{{$per_flight_details->adults}}" />
                                            <input type="hidden" name="children" id="children" value="{{$per_flight_details->children}}" />
                                            <input type="hidden" name="infant" id="infant" value="{{$per_flight_details->infant}}" />
                                    <input type="hidden" name="country_code" id="country_code" value="{{$per_flight_details->country_code}}" />
                                            <!-- <input type="text" name="passenger_details" id="passenger_details" value="" /> -->
                                            @if(isset($return_flights))
                                            <input type="hidden" name="return_flight" id="return_flight" value="{{json_encode($return_flights)}}" />
                                            <input type="submit" name="" id="submit_credit" class="btn btn-primary" value="Pay {{$currency_symbal}} {{number_format((float)(str_replace($currency_code,'',$return_flights[2]['price']['ApproximateBasePrice']))+(str_replace($currency_code,'',$return_flights[2]['price']['Taxes'])),2, '.', '')}}" />
                                            @else
                                            <input type="hidden" name="flight" id="flight" value="{{json_encode($data)}}" />
                                            <input type="submit" name="" id="submit_credit" class="btn btn-primary" value="Pay {{$currency_symbal}} {{number_format((float)(str_replace($currency_code,'',$data[2]['price']['ApproximateBasePrice']))+(str_replace($currency_code,'',$data[2]['price']['Taxes'])),2,'.', '')}}" />
                                            <!-- <a href="confirm-booking.php" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a> -->
                                            @endif
                                        </form>
                                        <!-- <a href="confirm-booking.php" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
            @if(isset($return_flights))
            <div class="col-md-3">
                <div class="card">
                    <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                    <span class="text-muted">Travelers {{$per_flight_details->adults}} Adult</span>
                    <table class="table table-small mt-2 mb-0">
                    @foreach($return_flights[3] as $price)
                        @for($i=0;$i< count($price);$i++)
                        @if($i==0)
                        <!-- {{$price[$i]['ApproximateBasePrice']}} -->
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Adult</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->adults}} adult(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        @elseif($i==1)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Child</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->children}} child(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        @elseif($i==2)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Infant</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->infant}} infant(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        @endif
                        @endfor
                    @endforeach
                        <!-- <tr>
                            <td>Other taxes</td>
                            <td class="text-right"><i class="las la-pound-sign"></i>0.0</td>
                        </tr> -->
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Total Price</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$return_flights[2]['price']['TotalPrice'])),2)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @else
            <div class="col-md-3">
                <div class="card">
                    <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                    <span class="text-muted">Travelers {{$per_flight_details->adults}} Adult</span>
                    <table class="table table-small mt-2 mb-0">
                    @foreach($data[3] as $price)
                        @for($i=0;$i< count($price);$i++)
                        @if($i==0)
                        <!-- {{$price[$i]['ApproximateBasePrice']}} -->
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Adult</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->adults}} adult(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        @elseif($i==1)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Child</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->children}} child(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        @elseif($i==2)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Infant</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->infant}} infant(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        @endif
                        @endfor
                    @endforeach
                        <!-- <tr>
                            <td>Other taxes</td>
                            <td class="text-right"><i class="las la-pound-sign"></i>0.0</td>
                        </tr> -->
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Total Price</td>
                            <td class="text-right text-danger">{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$data[2]['price']['TotalPrice'])),2)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection


@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();

        
    });
</script>
@endsection