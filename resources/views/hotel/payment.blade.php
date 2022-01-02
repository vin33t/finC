@extends('common.master')
@section('content')


<section class="search-packages bg-light-gray py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="confirmation-step">
                    <li><a href="#" class="active"><span>1</span> Hotel Details</a></li>
                    <li><a href="#" class="active"><span>2</span> Guest Details</a></li>
                    <li><a href="#" class="active"><span>3</span> Payment</a></li>
                    <li><a href="#"><span>4</span> Confirm</a></li>
                </ul>
            </div>
            <div class="col-md-8">
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
                                <form name="credit_or_debit" method="post" action="{{route('hotelpaymentcredit')}}">
                                @csrf
                                <div id="collapse1" class="collapse show mt-2" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="alert alert-warning"><i class="las la-credit-card"></i> We also accept <b>International Cards</b> for payments on transaction. </div>
                                        <img src="{{ asset('public/images/payment-cards.png')}}" alt="cards" class="img-fluid"/>
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
                                        @for($j=1; $j <=$searched->hotel_room; $j++)
                                            <?php 
                                                $var_adult='room'.$j.'_hotel_adults';
                                                $var_child='room'.$j.'_hotel_child';
                                                $var_infant='room'.$j.'_hotel_infant';
                                                // room1_first_name1
                                            ?>
                                            <!-- {{$searched->$var_adult}} -->
                                            @for($i=1; $i <=$searched->$var_adult; $i++ )
                                            <input type="hidden" name="room{{$j}}_first_name{{$i}}" id="room{{$j}}_first_name{{$i}}" value="<?php  $first_name='room'.$j.'_first_name'.$i; echo $searched->$first_name;?>" />
                                            <input type="hidden" name="room{{$j}}_last_name{{$i}}" id="room{{$j}}_last_name{{$i}}" value="<?php  $last_name='room'.$j.'_last_name'.$i; echo $searched->$last_name;?>" />
                                            @endfor
                                            @if($searched->$var_child > 0 )
                                            <input type="hidden" name="room{{$j}}_child1_first_name" id="room{{$j}}_child1_first_name" value="<?php $child_first='room'.$j.'_child1_first_name';  echo $searched->$child_first;?>" />
                                            <input type="hidden" name="room{{$j}}_child1_last_name" id="room{{$j}}_child1_last_name" value="<?php $child_last='room'.$j.'_child1_last_name';  echo $searched->$child_last;?>" />
                                            @endif
                                            @if($searched->$var_infant > 0 )
                                            <input type="hidden" name="room{{$j}}_child2_first_name" id="room{{$j}}_child2_first_name" value="<?php $child2_first='room'.$j.'_child2_first_name'; echo $searched->$child2_first;?>" />
                                            <input type="hidden" name="room{{$j}}_child2_last_name" id="room{{$j}}_child2_last_name" value="<?php $child2_last='room'.$j.'_child2_last_name';  echo $searched->$child2_last;?>" />
                                            @endif
                                        @endfor

                                        <input type="text" name="post_code" value="{{$searched->post_code}}" hidden>
                                        <input type="text" name="add_1" value="{{$searched->add_1}}" hidden>
                                        <input type="text" name="add_2" value="{{$searched->add_2}}" hidden>
                                        <input type="text" name="city" value="{{$searched->city}}" hidden>
                                        <input type="text" name="state" value="{{$searched->state}}" hidden>
                                        <input type="text" name="contact_no" value="{{$searched->contact_no}}" hidden>
                                        <input type="text" name="email" value="{{$searched->email}}" hidden>
                                        <input type="text" name="country" value="" hidden>

                                        <input type="text" name="options" value="{{json_encode($options)}}" hidden>
                                        <input type="text" name="GST" value="{{$searched->GST}}" hidden>
                                        <input type="text" name="Convenience_Fees" value="{{$searched->Convenience_Fees}}" hidden>
                                        <input type="text" name="Taxes_and_Fees" value="{{$searched->Taxes_and_Fees}}" hidden>
                                        <input type="text" name="price" value="{{$searched->price}}" hidden>
                                        <input type="text" name="check_in" value="{{$searched->check_in}}" hidden>
                                        <input type="text" name="check_out" value="{{$searched->check_out}}" hidden>
                                        <input type="text" name="city_name" value="{{$searched->city_name}}" hidden>
                                        <input type="text" name="hotel_room" value="{{$searched->hotel_room}}" hidden>
                                        <input type="text" name="currency" value="{{$searched->currency}}" hidden>

                                        <input type="text" name="room1_hotel_adults" value="{{$searched->room1_hotel_adults}}" hidden>
                                        <input type="text" name="room1_hotel_child" value="{{$searched->room1_hotel_child}}" hidden>
                                        <input type="text" name="room1_hotel_infant" value="{{$searched->room1_hotel_infant}}" hidden>

                                        <input type="text" name="room2_hotel_adults" value="{{$searched->room2_hotel_adults}}" hidden>
                                        <input type="text" name="room2_hotel_child" value="{{$searched->room2_hotel_child}}" hidden>
                                        <input type="text" name="room2_hotel_infant" value="{{$searched->room2_hotel_infant}}" hidden>

                                        <input type="text" name="room3_hotel_adults" value="{{$searched->room3_hotel_adults}}" hidden>
                                        <input type="text" name="room3_hotel_child" value="{{$searched->room3_hotel_child}}" hidden>
                                        <input type="text" name="room3_hotel_infant" value="{{$searched->room3_hotel_infant}}" hidden>

                                        <input type="text" name="room4_hotel_adults" value="{{$searched->room4_hotel_adults}}" hidden>
                                        <input type="text" name="room4_hotel_child" value="{{$searched->room4_hotel_child}}" hidden>
                                        <input type="text" name="room4_hotel_infant" value="{{$searched->room4_hotel_infant}}" hidden>
                                        <button type="submit" class="btn btn-primary" onclick="showLoder();">Pay 
                                        <!-- <i class="las la-pound-sign"></i>  -->
                                        <?php 
                                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                            echo " ";
                                        ?>
                                        {{ number_format(( $searched->price +$searched->GST+$searched->Convenience_Fees+$searched->Taxes_and_Fees),2) }}</button>
                                        <!-- <a href="confirm-booking.php" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a> -->
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
                                                        <img src="{{ asset('public/images/sbi.png')}}" alt="SBI"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="ICICI" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="ICICI">ICICI</span>
                                                        <img src="{{ asset('public/images/icici.png')}}" alt="ICICI"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="HDFC" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="HDFC">HDFC</span>
                                                        <img src="{{ asset('public/images/HDFC.png')}}" alt="HDFC"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="card card-body">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="AXIS" name="bank" value="">
                                                        <span class="custom-control-label mr-2" for="AXIS">AXIS</span>
                                                        <img src="{{ asset('public/images/AXIS.png')}}" alt="AXIS"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                            <label class="custom-control-label" for="customCheck">By clicking on Pay , I agree to accept the <a href="#">Booking Terms</a> & Cloud Travels General <a href="#">Terms of use and services</a></label>
                                          </div>
                                        <a href="#" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a>
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
                                            <img src="{{ asset('public/images/paypal.png')}}" alt="paypal" class="ml-auto" style="width:150px;"/>
                                        </div>
                                        <a href="#" class="btn btn-primary">Pay <i class="las la-pound-sign"></i>88.00</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </form> -->
                </div>
            </div>
            <!-- <div class="col-md-3">
                <div class="card">
                    <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                    <span class="text-muted">Travelers 1 Adult</span>
                    <table class="table table-small mt-2 mb-0">
                        <tr>
                            <td>Base Fare x 1</td>
                            <td class="text-right"><i class="las la-pound-sign"></i>80.00</td>
                        </tr>
                        <tr>
                            <td>Taxes x 1</td>
                            <td class="text-right"><i class="las la-pound-sign"></i>8.00</td>
                        </tr>
                        <tr>
                            <td>Other taxes</td>
                            <td class="text-right"><i class="las la-pound-sign"></i>0.0</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td>Total</td>
                            <td class="text-right text-danger"><i class="las la-pound-sign"></i>88.00</td>
                        </tr>
                    </table>
                </div>
            </div> -->

            <div class="col-md-4">
                <div class="card">
                    <h4 class="font-weight-500">Fare Summary</h4><hr>
                    <div class="row align-items-center">
                        <div class="col-6 border-right"><p class="m-0 text-dark">Check In <br><span class="font-weight-600">{{ Carbon\Carbon::parse($searched->check_in)->format('d/m/Y')}}</span></p></div>
                        <div class="col-6"><p class="m-0 text-dark">Check Out <br><span class="font-weight-600">{{ Carbon\Carbon::parse($searched->check_out)->format('d/m/Y')}}</span></p></div>
                    </div><hr>
                    <p>{{($searched->room1_hotel_adults+$searched->room2_hotel_adults+$searched->room3_hotel_adults+$searched->room4_hotel_adults)}} Adults 
                    <?php 
                            $child=0;
                            if($searched->room1_hotel_child>0){
                                $child+=1;
                            }
                            if($searched->room2_hotel_child>0){
                                $child+=1;
                            }
                            if($searched->room3_hotel_child>0){
                                $child+=1;
                            }
                            if($searched->room4_hotel_child>0){
                                $child+=1;
                            }
                            if($searched->room1_hotel_infant>0){
                                $child+=1;
                            }
                            if($searched->room2_hotel_infant>0){
                                $child+=1;
                            }
                            if($searched->room3_hotel_infant>0){
                                $child+=1;
                            }
                            if($searched->room4_hotel_infant>0){
                                $child+=1;
                            }
                            if($child>0){
                                echo ", ".$child." Child ";
                            }
                        ?>  
                    <br>in {{$searched->hotel_room}} Room for {{ \Carbon\Carbon::parse($searched->check_in)->diff(\Carbon\Carbon::parse($searched->check_out))->format('%d')  }} Night</p><hr>
                    <p class="text-dark">Room Charges (GST Extra)
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{ $searched->price }}</span>
                    </p>
                    <p class="text-dark">GST on Room Charges
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{number_format($searched->GST,2)}}</span>
                    </p>
                    <p class="text-dark">Convenience Fees
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{number_format($searched->Convenience_Fees,2)}}</span>
                    </p>
                    <p class="text-dark">Taxes & Fees
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{number_format($searched->Taxes_and_Fees,2)}}</span>
                    </p><hr>
                    <p class="mb-4 font-weight-600">Total<span class="text-danger float-right">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{ number_format(( $searched->price +$searched->GST+$searched->Convenience_Fees+$searched->Taxes_and_Fees),2) }}</span></p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')
<script>
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();
    });
</script>
@endsection