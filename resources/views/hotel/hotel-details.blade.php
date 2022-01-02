@extends('common.master')
@section('content')

<div class="middle">
<section class="search-packages py-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="confirmation-step">
                    <li><a href="#" class="active"><span>1</span> Hotel Details</a></li>
                    <li><a href="#"><span>2</span> Guest Details</a></li>
                    <li><a href="#"><span>3</span> Payment</a></li>
                    <li><a href="#"><span>4</span> Confirm</a></li>
                </ul>
            </div>
            @if(count($hotelDetails)>0)
            <div class="col-md-8">
                <div class="card">
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
                    <div class="share mt-2">
                        share:  
                        <ul>
                            <li><a href="https://www.facebook.com/" target="_blank"><img src="{{ asset('public/images/facebook.jpg')}}" alt="facebook"/></a></li>
                            <li><a href="https://twitter.com/" target="_blank"><img src="{{ asset('public/images/twitter.jpg')}}" alt="facebook"/></a></li>
                            <li><a href="mailto:info@cloudtravels.co.uk"><img src="{{ asset('public/images/mail.png')}}" alt="facebook"/></a></li>
                        </ul>
                    </div>
                    <!-- {{print_r($hotelDetails[0]['Images'])}} -->

                    <div class="hotel-banner sample1 my-4">
                        <div class="carousel">
                            <ul>
                                @foreach($hotelDetails[0]['Images']['Image'] as $image)
                                <li> <img src="{{$image}}" alt=""> </li>
                                @endforeach
                                <!-- <li> <img src="https://unsplash.it/500/300?image=655" alt=""> </li>
                                <li> <img src="https://unsplash.it/500/300?image=659" alt=""> </li>
                                <li> <img src="https://unsplash.it/500/300?image=653" alt=""> </li>
                                <li> <img src="https://unsplash.it/500/300?image=654" alt=""> </li> -->
                            </ul>
                            <div class="controls">
                                <div class="next"><i class="las la-angle-right"></i></div>
                                <div class="prev"><i class="las la-angle-left"></i></div>
                            </div>
                        </div>
                        <div class="thumbnails">
                            <ul>
                                @foreach($hotelDetails[0]['Images']['Image'] as $image)
                                <li> <img src="{{$image}}" alt=""> </li>
                                @endforeach
                                <!-- <li> <img src="https://unsplash.it/200/200?image=655" alt=""> </li>
                                <li> <img src="https://unsplash.it/200/200?image=659" alt=""> </li>
                                <li> <img src="https://unsplash.it/200/200?image=653" alt=""> </li>
                                <li> <img src="https://unsplash.it/200/200?image=654" alt=""> </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <!-- <del class="text-muted"><i class="las la-pound-sign"></i>34.50/-</del> -->
                    
                    <h4 class="mb-0 h3 font-weight-600">
                        <span class="text-danger">
                            <!-- <i class="las la-pound-sign"></i> -->
                            <?php 
                                echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                echo " ";
                            ?>
                        {{ isset($options[0]['TotalPrice'])?$options[0]['TotalPrice']:$options['TotalPrice']}}
                        </span>
                    </h4>
                    <!-- <small>Per Room / Per Night</small> -->
                    <h5 class="mb-0"><small class="text-muted"><i class="las la-bed"></i> 
                    <?php 
                        if(isset($options[0]['Rooms']['Room']['RoomName'])){
                          echo $options[0]['Rooms']['Room']['RoomName'];  
                        }else if(isset($options['Rooms']['Room']['RoomName'])){
                            echo $options['Rooms']['Room']['RoomName'];
                        }else if(isset($options[0]['Rooms']['Room'][0]['RoomName'])){
                           echo $options[0]['Rooms']['Room'][0]['RoomName']; 
                        }else{
                            echo $options['Rooms']['Room'][0]['RoomName']; 
                        }
                    ?>
                    </small></h5>
                    <!-- <h5 class="mb-0"><small class="text-muted"><i class="las la-bed"></i> Executive Room</small></h5> -->
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-6 border-right"><p class="m-0 text-dark">Check In <br><span class="font-weight-600">{{ Carbon\Carbon::parse($searched->check_in)->format('d/m/Y')}}</span></p></div>
                        <div class="col-6"><p class="m-0 text-dark">Check Out <br><span class="font-weight-600">{{ Carbon\Carbon::parse($searched->check_out)->format('d/m/Y')}}</span></p></div>
                    </div><hr>

                    <p class="text-dark">{{($searched->room1_hotel_adults+$searched->room2_hotel_adults+$searched->room3_hotel_adults+$searched->room4_hotel_adults)}} Adults 
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
                    </p>
                    
                      <!-- {{ \Carbon\Carbon::parse($searched->check_in)->diff(\Carbon\Carbon::parse($searched->check_out))->format('%d') }} -->
                    <p class="text-dark">{{$searched->hotel_room}} Room x {{ \Carbon\Carbon::parse($searched->check_in)->diff(\Carbon\Carbon::parse($searched->check_out))->format('%d') }} Nights <span class="float-right font-weight-600">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                                echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                echo " ";
                            ?>
                        {{ isset($options[0]['TotalPrice'])?$options[0]['TotalPrice']:$options['TotalPrice']}}</span></p><hr>
                    <h4 class="mb-3 font-weight-600">Total
                    <span class="text-danger float-right">
                        <!-- <i class="las la-pound-sign"></i> -->
                        <?php 
                                echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                echo " ";
                            ?>
                        {{isset($options[0]['TotalPrice'])?$options[0]['TotalPrice']:$options['TotalPrice']}}</span></span>
                    </h4>
                    <!-- <a href="guest-details.php" class="btn btn-primary w-100">Book Now</a> -->
                    <form action="{{route('guestdetails')}}" method="POST">
                        @csrf
                        <input type="text" name="hotel_id" value="{{$hotelDetails[0]['HotelId']}}" hidden>
                        <!-- <input type="text" name="currency" value="GBP" hidden> -->
                        <input type="text" name="option" value="{{json_encode(isset($options[0])?$options[0]:$options)}}" hidden>
                        <input type="text" name="price" value="{{isset($options[0]['TotalPrice'])?$options[0]['TotalPrice']:$options['TotalPrice']}}" hidden>
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
                                     
                        <button type="submit" class="btn btn-primary w-100" onclick="showLoder();">Book Now</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @if(count($hotelDetails)>0)
        <div class="row my-3">
            <div class="col-md-12">
                <div class="card">
                    <ul class="hotel-amenities">
                        @foreach($hotelDetails[0]['Facilities']['Facility'] as $facility)
                        <!-- {{print_r($facility)}} -->
                        @if($facility['FacilityName']=='Swimming pool')
                        <!-- {{$facility['FacilityName']}} -->
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="Swimming Pool"><i class="las la-swimmer"></i></a></li>
                        @endif
                        @if($facility['FacilityName']=='Free WiFi')
                        <!-- {{$facility['FacilityName']}} -->
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="Free Wifi"><i class="las la-wifi"></i></a></li>
                        @endif
                        @endforeach
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="Room Service"><i class="las la-hotel"></i></a></li>
                        <!-- <li><a href="javascript:void(0)" data-toggle="tooltip" title="Gym/Spa"><i class="las la-dumbbell"></i></a></li>
                        <li><a href="javascript:void(0)" data-toggle="tooltip" title="Beark Fast"><i class="las la-utensils"></i></a></li> -->

                        <li><a href="javascript:void(0)" class="text-dark" data-toggle="collapse" data-target="#all-amenities"><small>+ View all Amenities and services</small></a></li>
                    </ul>
                    <div id="all-amenities" class="collapse"><hr>
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="amenities-ul">
                                    <?php $count1=0; ?>
                                    @foreach($hotelDetails[0]['Facilities']['Facility'] as $facility)
                                    @if($facility['FacilityType'] =='Hotel Facilities')
                                        @if($count1 < 8 )
                                        <li>{{$facility['FacilityName']}}</li>
                                        @else
                                        @break;
                                        @endif
                                        <?php $count1++; ?>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="amenities-ul">
                                    <?php $count2=0; ?>
                                    @foreach($hotelDetails[0]['Facilities']['Facility'] as $facility)
                                    @if($facility['FacilityType'] =='Hotel Facilities')
                                        @if($count2 >= 8 && $count2 < 16)
                                        <li>{{$facility['FacilityName']}}</li>
                                        @endif
                                        <?php $count2++; ?>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="amenities-ul">
                                <?php $count3=0; ?>
                                    @foreach($hotelDetails[0]['Facilities']['Facility'] as $facility)
                                    @if($facility['FacilityType'] =='Hotel Facilities')
                                        @if($count3 >= 16 && $count3 < 24)
                                        <li>{{$facility['FacilityName']}}</li>
                                        @endif
                                        <?php $count3++; ?>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="hotel-details-navbar navbar-expand-sm navbar-default sticky-top">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#rooms-rates">Room & Rates</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#location">Location</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#guest-review">Guest Reviews</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="#hotel-policies">Description</a>
                        </li>
                    </ul>
                </div>
                <div id="rooms-rates" class="mb-5">
                    @if(isset($options['Rooms']['Room']['RoomName']))
                    <div class="card card-body">
                        <div class="row">
                            <!-- {{json_encode($options)}} -->
                            <div class="col-md-8">
                                <h4>{{$options['Rooms']['Room']['RoomName']}}</h4>
                                <span class="badge badge-warning">Partially Cancellable</span>
                                
                                <ul class="amenities-ul">
                                    <li>{{isset($options['BoardType'])? $options['BoardType']:'' }}</li>
                                    <li>After {{date('d-m-Y')}} 23:59, Cancellation charge of GBP {{$options['TotalPrice']}} will be applied.</li>
                                    
                                    <!-- <li>After 03/09/2021 17:59, Cancellation charge of GBP 40.14 will be applied.</li> -->
                                    <!-- <li>Unlimited usage of internet <a href="#">+ 7 More</a></li> -->
                                </ul>
                                <!-- <ul class="amenities-ul">
                                    <li>Accommodation only</li>
                                    <li>Unlimited usage of internet <a href="#">+ 7 More</a></li>
                                </ul> -->
                            </div>
                            <div class="col-md-4 border-left">
                                <!-- <del class="text-muted"><i class="las la-pound-sign"></i>30.00/night</del><br> -->
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger">
                                    <!-- <i class="las la-pound-sign"></i> -->
                                    <?php 
                                        echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                        echo " ";
                                    ?>
                                    {{$options['TotalPrice']}}</span></h4>
                                <!-- <small>Per Room / Per Night</small><br> -->
                                <!-- <a href="guest-details.php" class="btn btn-primary mt-2">Book Now</a> -->
                                <form action="{{route('guestdetails')}}" method="POST">
                                    @csrf
                                    <input type="text" name="hotel_id" value="{{$hotelDetails[0]['HotelId']}}" hidden>
                                    <!-- <input type="text" name="currency" value="GBP" hidden> -->
                                    <input type="text" name="option" value="{{json_encode($options)}}" hidden>
                                    <input type="text" name="price" value="{{$options['TotalPrice']}}" hidden>
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
                                        
                                    <button type="submit" class="btn btn-primary mt-2" onclick="showLoder();">Book Now</button>
                                </form>
                            </div>

                        </div>
                    </div>
                    @elseif(isset($options['Rooms']['Room'][0]['RoomName']))
                    <div class="card card-body">
                        <div class="row">
                            <!-- {{json_encode($options)}} -->
                            <div class="col-md-8">
                                <h4>{{$options['Rooms']['Room'][0]['RoomName']}}</h4>
                                <span class="badge badge-warning">Partially Cancellable</span>
                                
                                <ul class="amenities-ul">
                                    <li>{{isset($options['BoardType'])? $options['BoardType']:'' }}</li>
                                    <li>After {{date('d-m-Y')}} 23:59, Cancellation charge of GBP {{$options['TotalPrice']}} will be applied.</li>
                                    
                                    <!-- <li>After 03/09/2021 17:59, Cancellation charge of GBP 40.14 will be applied.</li> -->
                                    <!-- <li>Unlimited usage of internet <a href="#">+ 7 More</a></li> -->
                                </ul>
                                <!-- <ul class="amenities-ul">
                                    <li>Accommodation only</li>
                                    <li>Unlimited usage of internet <a href="#">+ 7 More</a></li>
                                </ul> -->
                            </div>
                            <div class="col-md-4 border-left">
                                <!-- <del class="text-muted"><i class="las la-pound-sign"></i>30.00/night</del><br> -->
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger">
                                    <!-- <i class="las la-pound-sign"></i> -->
                                    <?php 
                                        echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                        echo " ";
                                    ?>
                                    {{$options['TotalPrice']}}</span></h4>
                                <!-- <small>Per Room / Per Night</small><br> -->
                                <!-- <a href="guest-details.php" class="btn btn-primary mt-2">Book Now</a> -->
                                <form action="{{route('guestdetails')}}" method="POST">
                                    @csrf
                                    <input type="text" name="hotel_id" value="{{$hotelDetails[0]['HotelId']}}" hidden>
                                    <!-- <input type="text" name="currency" value="GBP" hidden> -->
                                    <input type="text" name="option" value="{{json_encode($options)}}" hidden>
                                    <input type="text" name="price" value="{{$options['TotalPrice']}}" hidden>
                                    <input type="text" name="check_in" value="{{$searched->check_in}}" hidden>
                                    <input type="text" name="check_out" value="{{$searched->check_out}}" hidden>
                                    <input type="text" name="city_name" value="{{$searched->city_name}}" hidden>
                                    <input type="text" name="hotel_room" value="{{$searched->hotel_room}}" hidden>

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
                                        
                                    <button type="submit" class="btn btn-primary mt-2" onclick="showLoder();">Book Now</button>
                                </form>
                            </div>

                        </div>
                    </div>
                    @else
                    @foreach($options as $option)
                    <div class="card card-body">
                        <div class="row">
                            <!-- {{json_encode($option)}} -->
                            <div class="col-md-8">
                                <h4>{{isset($option['Rooms']['Room']['RoomName'])? $option['Rooms']['Room']['RoomName']: $option['Rooms']['Room'][0]['RoomName']}}</h4>
                                <span class="badge badge-warning">Partially Cancellable</span>
                                
                                <ul class="amenities-ul">
                                    <li>{{isset($option['BoardType'])? $option['BoardType']:'' }}</li>
                                    <li>After {{date('d-m-Y')}} 23:59, Cancellation charge of GBP {{$option['TotalPrice']}} will be applied.</li>
                                    <!-- <li>Unlimited usage of internet <a href="#">+ 7 More</a></li> -->
                                </ul>
                                <!-- <ul class="amenities-ul">
                                    <li>Accommodation only</li>
                                    <li>Unlimited usage of internet <a href="#">+ 7 More</a></li>
                                </ul> -->
                            </div>
                            <div class="col-md-4 border-left">
                                <!-- <del class="text-muted"><i class="las la-pound-sign"></i>30.00/night</del><br> -->
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger">
                                    <!-- <i class="las la-pound-sign"></i> -->
                                    <?php 
                                        echo $val=DB::table('hotel_currency')->where('currency',$searched->currency)->value('icon');
                                        echo " ";
                                    ?>
                                    {{$option['TotalPrice']}}</span></h4>
                                <!-- <small>Per Room / Per Night</small><br> -->
                                <!-- <a href="guest-details.php" class="btn btn-primary mt-2">Book Now</a> -->
                                <form action="{{route('guestdetails')}}" method="POST">
                                    @csrf
                                    <input type="text" name="hotel_id" value="{{$hotelDetails[0]['HotelId']}}" hidden>
                                    <!-- <input type="text" name="currency" value="GBP" hidden> -->
                                    <input type="text" name="option" value="{{json_encode($option)}}" hidden>
                                    <input type="text" name="price" value="{{$option['TotalPrice']}}" hidden>
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
                                        
                                    <button type="submit" class="btn btn-primary mt-2" onclick="showLoder();">Book Now</button>
                                </form>
                            </div>
                            <!-- <div class="col-md-8">
                                <h4>Executive Room</h4>
                                <span class="badge badge-warning">Partially Cancellable</span>
                                <ul class="amenities-ul">
                                    <li>Accommodation only</li>
                                    <li>Unlimited usage of internet <a href="#">+ 7 More</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 border-left">
                                <del class="text-muted"><i class="las la-pound-sign"></i>30.00/night</del><br>
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger"><i class="las la-pound-sign"></i>29.20/-</span></h4>
                                <small>Per Room / Per Night</small><br>
                                <a href="guest-details.php" class="btn btn-primary mt-2">Book Now</a>
                            </div> -->


                        </div>
                    </div>
                    @endforeach
                    @endif

                    <!-- <div class="card card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>Executive Room with Breakfast</h4>
                                <span class="badge badge-warning">Partially Cancellable</span>
                                <ul class="amenities-ul">
                                    <li>FREE Breakfast</li>
                                    <li>Electronic safe deposits locker in each room <a href="#">+ 14 More</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 border-left">
                                <del class="text-muted"><i class="las la-pound-sign"></i>40.12/night</del><br>
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger"><i class="las la-pound-sign"></i>36.12/-</span></h4>
                                <small>Per Room / Per Night</small><br>
                                <a href="guest-details.php" class="btn btn-primary mt-2">Book Now</a>
                            </div>
                        </div>
                    </div> -->
                </div
                ><hr>
                <div id="location" class="my-5">
                    <h4>Location</h4>
                    <div class="embed-responsive embed-responsive-21by9">
                        <iframe class="emned-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2425.234470969165!2d76.76294025494819!3d30.72403706951365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fedb15f8fff8d%3A0xf6f229c172d97116!2sHotel%20Sun%20View!5e0!3m2!1sen!2sin!4v1575718860175!5m2!1sen!2sin" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
                <hr>
                <!-- <div id="guest-review" class="my-5">
                    <h4>Ratings & Reviews</h4>
                    <img src="{{ asset('public/images/rating.jpg')}}" alt="rating" class="img-fluid"/>
                </div> -->
                <!-- <hr> -->
                <div id="hotel-policies" class="mt-5">
                    <h4 class="font-weight-bold">Description</h4>
                        <!-- {{json_encode($policies)}} -->
                    @if(isset($policies['Alerts']['Alert']))
                    <ul>
                        <!-- <li>The standard check-in time is 02:00 PM and the standard check-out time is 12:00 PM.Early check-in or late check-out is strictly subjected to availability and may be chargeable by the hotel.Any early check-in or late check-out request must be directed and reconfirmed with hotel and may be chargeable by the hotel directly.</li> -->
                        @if(is_array($policies['Alerts']['Alert']))
                        @foreach($policies['Alerts']['Alert'] as $policy)
                            <li>{{$policy}}</li>
                        @endforeach
                        @else
                        <li>{{$policies['Alerts']['Alert']}}</li>
                        @endif
                       
                    </ul>
                    @else
                    <ul>
                        <li></li>
                        
                    </ul>
                    @endif
                </div>
                </div>
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
</script>
@endsection