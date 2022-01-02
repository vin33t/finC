@extends('common.master')
@section('content')

<div class="middle">
    <section class="search-packages py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="confirmation-step">
                        <li><a href="#" class="active"><span>1</span> Hotel Details</a></li>
                        <li><a href="#" class="active"><span>2</span> Guest Details</a></li>
                        <li><a href="#"><span>3</span> Payment</a></li>
                        <li><a href="#"><span>4</span> Confirm</a></li>
                    </ul>
                </div>

                @if(count($hotelDetails) > 0)
                <div class="col-md-8">
                    <div class="card">
                        <div class="media media-wrap mb-5">
                            <div class="align-self-start hotels-image-media mb-3 mb-md-0 mr-sm-3" style="background:url('{{isset($hotelDetails[0]['Images']['Image'][0])?$hotelDetails[0]['Images']['Image'][0]:$hotelDetails[$i]['Images']['Image']}}') no-repeat center center;background-size:cover;"></div>
                            <div class="media-body">
                                <h3 class="font-weight-600">{{$hotelDetails[0]['HotelName']}}</h3>
                            <address class="text-muted mb-1">{{$hotelDetails[0]['Address']}}</address>
                            <div class="rating">
                                @if($hotelDetails[0]['StarRating']==1)
                                <i class="las la-star active"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i> 1.0
                                @elseif($hotelDetails[0]['StarRating']==2)
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i> 2.0
                                @elseif($hotelDetails[0]['StarRating']==3)
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star"></i>
                                <i class="las la-star"></i> 3.0
                                @elseif($hotelDetails[0]['StarRating']==4)
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star"></i> 4.0
                                @elseif($hotelDetails[0]['StarRating']==5)
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i> 5.0
                                @endif
                            </div>
                            <!-- <h5 class="mb-0"><small class="text-muted"><i class="las la-bed"></i> Executive Room</small></h5> -->
                            <span class="text-muted mt-3 d-block">Facilities</span>
                            <ul class="d-block mt-1 pl-3">
                                <?php $count=0?>
                                @foreach($hotelDetails[0]['Facilities']['Facility'] as $facility)
                                @if($facility['FacilityType'] =='Hotel Facilities')
                                    @if($count < 4 )
                                    <li>{{$facility['FacilityName']}}</li>
                                    @else
                                    @break;
                                    @endif
                                    <?php $count++; ?>
                                @endif
                                @endforeach
                                <div id="all-amenities-facility" class="collapse">
                                    <?php $count1=0?>
                                    @foreach($hotelDetails[0]['Facilities']['Facility'] as $facility)
                                    @if(is_array($facility))
                                        @if($facility['FacilityType'] =='Hotel Facilities')
                                            @if($count1 > 4 )
                                            <li>{{$facility['FacilityName']}}</li>
                                            @endif
                                            <?php $count1++; ?>
                                        @endif
                                    @endif
                                    @endforeach
                                </div>
                                <li><a href="javascript:void(0)" data-toggle="collapse" data-target="#all-amenities-facility">Expand/Collapse <i class="las la-angle-down"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <form class="passanger-details" method="post" action="{{route('hotelpayment')}}">
                        @csrf
                        @for($j=1; $j <=$searched->hotel_room; $j++)
                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2"> Room {{$j}}</h6>
                            <div class="row">
                                <!-- {{'room'.$j.'_hotel_adults'}} -->
                                <?php 
                                    $var_adult='room'.$j.'_hotel_adults';
                                    $var_child='room'.$j.'_hotel_child';
                                    $var_infant='room'.$j.'_hotel_infant';
                                ?>
                                @for($i=1; $i <=$searched->$var_adult; $i++ )
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Adult ({{$i}})- first name</label>
                                        <input type="text" required name="room{{$j}}_first_name{{$i}}" class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" required name="room{{$j}}_last_name{{$i}}" class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                               @endfor
                               @if($searched->$var_child > 0 )
                               <!-- {{"hii"}} -->
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Child (1)- first name</label>
                                        <input type="text" required name="room{{$j}}_child1_first_name" class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" required name="room{{$j}}_child1_last_name" class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                               @endif
                               @if($searched->$var_infant > 0 )
                               <!-- {{"hii"}} -->
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Child (2)- first name</label>
                                        <input type="text" required name="room{{$j}}_child2_first_name" class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" required name="room{{$j}}_child2_last_name" class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                               @endif
                            </div>

                            
                        </div>
                        @endfor

                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2"> Billing Details</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Post code</label>
                                        <input type="text" required name="post_code" class="form-control" placeholder="Enter post code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address Line 1</label>
                                        <input type="text" required name="add_1" class="form-control" placeholder="Enter Address Line 1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" required name="add_2" class="form-control" placeholder="Enter Address Line 2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" required name="city" class="form-control" placeholder="Enter your town/city name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>country</label>
                                        <select required name="state" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($country as $countries)
                                            <option value="{{$countries->name}}">{{$countries->name}}</option>
                                            @endforeach
                                        </select>
                                        <!-- <input type="text" required name="state" class="form-control" placeholder="Enter your state code"> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact No</label>
                                        <input type="number" required name="contact_no" class="form-control" placeholder="Enter your contact no" max="9999999999" oninvalid="this.setCustomValidity('Mobile no up to 10 digit')" oninput="this.setCustomValidity('')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email id</label>
                                        <input type="email" required name="email" class="form-control" placeholder="Enter your email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="text" name="hotel_id" value="{{$hotelDetails[0]['HotelId']}}" hidden>
                        <input type="text" name="option" value="{{json_encode($options)}}" hidden>
                        <input type="text" name="GST" value="{{$GST}}" hidden>
                        <input type="text" name="Convenience_Fees" value="{{$Convenience_Fees}}" hidden>
                        <input type="text" name="Taxes_and_Fees" value="{{$Taxes_and_Fees}}" hidden>
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
                        <button type="submit" class="btn btn-primary" onclick="showLoder();">Confirm Booking</button>
                        <!-- <a href="payment.php" class="btn btn-primary">Confirm Booking</a> -->
                    </form>
                </div>
                @endif

            </div>
            @if(count($hotelDetails) > 0)
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
                        {{  $searched->price }}</span>
                    </p>
                    <p class="text-dark">GST on Room Charges
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{number_format($GST,2)}}</span>
                    </p>
                    <p class="text-dark">Convenience Fees
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{number_format($Convenience_Fees,2)}}</span>
                    </p>
                    <p class="text-dark">Taxes & Fees
                    <span class="float-right h6 font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{number_format($Taxes_and_Fees,2)}}</span>
                    </p><hr>
                    <p class="mb-4 font-weight-600">Total<span class="text-danger float-right">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                            echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                            echo " ";
                        ?>
                        {{ number_format(( $searched->price+$GST+$Convenience_Fees+$Taxes_and_Fees),2) }}</span></p>
                </div>
            </div>
            @endif
        </div>
    </div>
    </section>
</div>

@endsection


@section('script')
<script>
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();
    });

    // function showLoder(){
    //     $('#loading').show();
    // }
</script>
@endsection


