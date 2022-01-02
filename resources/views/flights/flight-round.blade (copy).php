@extends('common.master')
@section('content')

<div class="middle">
    <div class="search-results">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">From</small>
                    <h6 class="font-weight-600 mb-0">{{$searched->addFrom}}</h6>
                    <!-- <h6 class="font-weight-600 mb-0">Chandigarh Airport</h6> -->
                    <small class="exchange-arrow"><i class="las la-exchange-alt"></i></small>
                </div>
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">To</small>
                    <h6 class="font-weight-600 mb-0">{{$searched->addTo}}</h6>
                    <!-- <h6 class="font-weight-600 mb-0">Chhatrapati Shivaji Airport</h6> -->
                </div>
                <div class="col-md col-6 my-2 my-md-0">
                    <small class="text-muted d-block mb-1">Departure date</small>
                    <h6 class="font-weight-600 mb-0">{{ Carbon\Carbon::parse($searched->departure_date)->format('d/m/Y')}}</h6>
                    <!-- <h6 class="font-weight-600 mb-0">05/03/2021</h6> -->
                </div>
                <div class="col-md col-6 my-2 my-md-0">
                    <small class="text-muted d-block mb-1">Returning date</small>
                    <!-- <h6 class="font-weight-600 mb-0">{{ $searched->returning_date}}</h6> -->
                    <h6 class="font-weight-600 mb-0">{{ isset($searched->returning_date)?Carbon\Carbon::parse($searched->returning_date)->format('d/m/Y'):''}}</h6>
                </div>
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">Passangers & Class</small>
                    <h6 class="font-weight-600 mb-0">{{ isset($searched->adults)?$searched->adults.'Adult':''}} <?php if($searched->children > 0){echo ' ,'.$searched->children.'Child';} if($searched->infant > 0){echo ' ,'.$searched->infant.'Infant';} ?>, {{$searched->travel_class}}</h6>
                </div>
                <div class="col-md mt-md-0 col-6">
                    <a href="#" class="btn btn-yellow btn-sm" data-toggle="collapse" data-target="#search-container">Modify Search</a>
                </div>
            </div>
        </div>
    </div>
    <section id="search-container" class="bg-white collapse">
        <div class="container-fluid">
            <div class="cld__book__form search__modify">
            <form method="get" class="{{route('flights')}}">
                <input type="hidden" name="flexi" id="flexi" value="{{isset($searched->flexi)?$searched->flexi:''}}">
                <input type="hidden" name="direct_flight" id="direct_flight" value="{{isset($searched->direct_flight)?$searched->direct_flight:''}}">
                <div class="form-group">
                    <ul class="cld__selectors">
                        <li><a href="javascript:void(0)" class="active" id="one_way">One way</a></li>
                        <li><a href="javascript:void(0)" id="round_trip">Round trip</a></li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>From</label>
                            <input type="text" name="addFrom" id="addFrom" placeholder="(IXC) | Chandigarh Airport" class="form-control search_input" value="{{$searched->addFrom}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>To</label>
                            <input type="text" name="addTo" id="addTo" placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input" value="{{$searched->addTo}}">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label>Departure Date</label>
                            <div id="departure_date_datetimepicker" class="input-group departure_date_datetimepickerclass">
                                <input type="text" name="departure_date" id="departure_date" placeholder="dd-mm-yyyy" class="form-control border-right-0 departure_date_datetimepickerclass" data-format="dd-MM-yyyy" value={{ \Carbon\Carbon::parse($searched->departure_date)->format('d-m-Y') }}>
                                <div class="input-group-append add-on departure_date_datetimepickerclass">
                                <span class="input-group-text bg-white pl-0 departure_date_datetimepickerclass"><i class="lar la-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label>Returning Date</label>
                            <div id="returning_date_datetimepicker" class="input-group returning_date_datetimepickerclass">
                                <input type="text" name="returning_date" id="returning_date" placeholder="dd-mm-yyyy" class="form-control border-right-0 returning_date_datetimepickerclass" data-format="dd-MM-yyyy" value="{{ isset($searched->returning_date)? \Carbon\Carbon::parse($searched->returning_date)->format('d-m-Y'):'' }}">
                                <div class="input-group-append add-on returning_date_datetimepickerclass">
                                <span class="input-group-text bg-white pl-0 returning_date_datetimepickerclass"><i class="lar la-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Passangers & Class</label>
                            <input type="text" id="flight_travel_details" name="" placeholder="<?php if($searched->adults>0){echo $searched->adults." Adult";} if($searched->children>0){echo ", ".$searched->children." Child";} if($searched->infant>0){echo ", ".$searched->infant." Infant";} echo ", ".$searched->travel_class; ?>" class="form-control" onclick="traveller_selection();">
                        
                            <div id="traveller_selection" style="display:none;">
                                <div class="row m-0">
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Adults <small>(12+ yrs)</small></label>
                                            <select name="adults" id="adults" class="custom-select">
                                                <option value="1" <?php if($searched->adults==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->adults==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->adults==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->adults==4){echo "selected";}?>>4</option>
                                                <option value="5" <?php if($searched->adults==5){echo "selected";}?>>5</option>
                                                <option value="6" <?php if($searched->adults==6){echo "selected";}?>>6</option>
                                                <option value="7" <?php if($searched->adults==7){echo "selected";}?>>7</option>
                                                <option value="8" <?php if($searched->adults==8){echo "selected";}?>>8</option>
                                                <option value="9" <?php if($searched->adults==9){echo "selected";}?>>9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Children <small>(2-15 yrs)</small></label>
                                            <select name="children" id="children" class="custom-select">
                                                <option >0</option>
                                                <option value="1" <?php if($searched->children==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->children==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->children==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->children==4){echo "selected";}?>>4</option>
                                                <option value="5" <?php if($searched->children==5){echo "selected";}?>>5</option>
                                                <option value="6" <?php if($searched->children==6){echo "selected";}?>>6</option>
                                                <option value="7" <?php if($searched->children==7){echo "selected";}?>>7</option>
                                                <option value="8" <?php if($searched->children==8){echo "selected";}?>>8</option>
                                                <option value="9" <?php if($searched->children==9){echo "selected";}?>>9</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Infant <small>(0-23 mths)</small></label>
                                            <select name="infant" id="infant" class="custom-select">
                                                <option >0</option>
                                                <option value="1" <?php if($searched->infant==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->infant==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->infant==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->infant==4){echo "selected";}?>>4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Travel Class</label>
                                            <select name="travel_class" id="travel_class" class="custom-select">
                                                <option value="Economy" <?php if($searched->travel_class=='Economy'){echo "selected";}?>>Economy</option>
                                                <option value="Business" <?php if($searched->travel_class=='Business'){echo "selected";}?>>Business</option>
                                                <option value="First Class" <?php if($searched->travel_class=='First Class'){echo "selected";}?>>First Class</option>
                                                <option value="Premium Economy" <?php if($searched->travel_class=='Premium Economy'){echo "selected";}?>>Premium Economy</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="flight_submit" class="btn btn-primary" onclick="showLoder();">Search</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
</section>

<section class="search-packages mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 filters_wrapper">
                @if(count($return_flights)>0)
                <div class="card">
                    <h4 class="font-weight-600 m-0">Filter <span class="d-inline-block d-lg-none  filter-open float-right"><i class="las la-times"></i></span></h4>
                    <div class="filter-set">
                        <h6 class="font-weight-600">Stops </h6>
                        @foreach($return_stops as $stop)
                        <!-- {{$stop}} -->
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Stops{{$stop}}" name="Stops" value="Stops{{$stop}}" onclick="filter()">
                            <label class="custom-control-label" for="Stops{{$stop}}">
                            <?php 
                            if($stop==0){ echo "Non Stop";}else{echo ($stop)." Stop";}
                            ?>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="filter-set">
                        <h6 class="font-weight-600">Departure </h6>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Departure16" name="Departure" value="Departure16" onclick="filter()">
                            <label class="custom-control-label" for="Departure16">Before 6AM</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Departure612" name="Departure" value="Departure612" onclick="filter()">
                            <label class="custom-control-label" for="Departure612">6AM-12 Noon</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Departure126" name="Departure" value="Departure126" onclick="filter()">
                            <label class="custom-control-label" for="Departure126">12 Noon-6PM</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Departure6" name="Departure" value="Departure6" onclick="filter()">
                            <label class="custom-control-label" for="Departure6">After 6PM</label>
                        </div>
                    </div>
                    <div class="filter-set">
                        <h6 class="font-weight-600">Price Range</h6>
                        <label for="onwwayRange" id="amount"><i class="las la-pound-sign"></i>
                        <?php  
                            foreach($return_flights[0] as $flight){
                                foreach($flight[1] as $prices){ 
                                    echo str_replace('GBP','',$prices['Total Price']);
                                }
                            }
                            echo ' - <i class="las la-pound-sign"></i>';
                            foreach($return_flights[(count($return_flights)-1)] as $flight){
                                foreach($flight[1] as $prices){ 
                                    echo str_replace('GBP','',$prices['Total Price']);
                                }
                            }
                        ?></label>
                        <input type="range" class="custom-range" id="onwwayRange" name="onwwayRange" 
                        min="<?php foreach($return_flights[0] as $flight){foreach($flight[1] as $prices){echo (str_replace('GBP','',$prices['Total Price'])*100);}} ?>" 
                        max="<?php foreach($return_flights[(count($return_flights)-1)] as $flight){foreach($flight[1] as $prices){echo (str_replace('GBP','',$prices['Total Price'])*100);}} ?>" 
                        value="<?php foreach($return_flights[(count($return_flights)-1)] as $flight){foreach($flight[1] as $prices){echo (str_replace('GBP','',$prices['Total Price'])*100);}} ?>">
                        <input type="hidden" class="custom-range" id="onwwayRange_minprice" name="onwwayRange_minprice" value="<?php 
                            foreach($return_flights[0] as $flight){
                                foreach($flight[1] as $prices){ 
                                    echo (str_replace('GBP','',$prices['Total Price'])*100);
                                }
                            }
                        ?>">
                        <input type="hidden" class="custom-range" id="onwwayRange_maxprice" name="onwwayRange_maxprice" value="<?php 
                            foreach($return_flights[(count($return_flights)-1)] as $flight){
                                foreach($flight[1] as $prices){ 
                                    echo (str_replace('GBP','',$prices['Total Price'])*100);
                                }
                            }
                        ?>">
                        <input type="hidden" class="custom-range" id="onwwayRange_rangeprice" name="onwwayRange_rangeprice" value="<?php 
                            foreach($return_flights[(count($return_flights)-1)] as $flight){
                                foreach($flight[1] as $prices){ 
                                    echo (str_replace('GBP','',$prices['Total Price'])*100);
                                }
                            }
                        ?>"/>
                        
                    </div>
                    <div class="filter-set">
                        <h6 class="font-weight-600">Airlines </h6>
                        @foreach($return_airlines as $airline)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Airline{{$airline}}" name="Airline" value="Airline{{$airline}}" onclick="filter()" >
                            <label class="custom-control-label" for="Airline{{$airline}}">{{ $airline }} <img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir{{$airline}}.gif" alt="6E.png" style="width:20px;height:20px;" class="mr-2"/></label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @if(count($return_flights)>0)
            <div class="col-lg-9 flight-section">
                <div class="card">
                    <!-- <h4>Onward Journey</h4>
                    <br/> -->
                    <div class="row row-heading d-none d-md-flex">
                        <div class="col-md-3">Airlines</div>
                        <div class="col-md-2" >Departure</div>
                        <div class="col-md-2 text-center" >Duration</div>
                        <div class="col-md-2" >Arrival</div>
                        <!-- <div class="col-md-2" data-departureordervalue="ASC" id="departure_order" style="cursor: pointer;">Departure<i class="las la-long-arrow-alt-up"></i><i class="las la-long-arrow-alt-down"></i></div>
                        <div class="col-md-2 text-center" data-durationordervalue="ASC" id="duration_order" style="cursor: pointer;">Duration<i class="las la-long-arrow-alt-up"></i><i class="las la-long-arrow-alt-down"></i></div>
                        <div class="col-md-2" data-arrivalordervalue="ASC" id="arrival_order" style="cursor: pointer;">Arrival<i class="las la-long-arrow-alt-up"></i><i class="las la-long-arrow-alt-down"></i></div> -->
                        <div class="col-md-3 text-center" id="price_order" style="cursor: pointer;">Price <i class="las la-long-arrow-alt-up"></i><i class="las la-long-arrow-alt-down"></i></div>
                    </div>
                    <div class="MainDiv">
                    <?php $count=1; $flightCount=0;$DepartureTime="";$DepartureSlot="";$DepartureTimeOrder =[];$ArrivalTimeOrder =[];$DurationTimeOrder =[];?>
                    @foreach($return_flights as $flight)
                    @foreach($flight as $flight_data)
                    @foreach($flight_data[0] as $datas)
                    @foreach($datas[0] as $datas1)
                    <?php 
                    $rrr=count($datas1);
                    // echo $rrr;
                    ?>
                    @endforeach
                    @foreach($datas[1] as $datas1)
                    <?php 
                    $sss=count($datas1);
                    // echo $sss;
                    ?>
                    @endforeach
                    @endforeach
                    
                    @if($searched->direct_flight == 'DF' && $rrr>1 && $searched->flexi=="" || $sss>1)
                    @continue
                    @elseif($searched->direct_flight == 'DF' && $rrr>1 && $searched->flexi=="F" || $sss>1)
                    @continue
                    @endif
                    
                    <?php 
                    foreach($flight_data[0] as $datas){
                        foreach($datas[0] as $datas1){
                            $DepartureTime =\Carbon\Carbon::parse($datas1[0]['Depart'])->format('H:i'); 
                        } 
                    } 
                    ?>
                    <?php
                        if ($DepartureTime>=date("00:00") &&$DepartureTime<date("06:00")) {
                        $DepartureSlot="Departure16";
                        }
                        elseif ($DepartureTime>=date("06:00") &&$DepartureTime<=date("12:00")) {
                        $DepartureSlot="Departure612";
                        }
                        elseif ($DepartureTime>=date("12:00") &&$DepartureTime<=date("18:00")) {
                        $DepartureSlot="Departure126";
                        }
                        elseif ($DepartureTime>=date("18:00") &&$DepartureTime<=date("24:00")) {
                        $DepartureSlot="Departure6";
                        }
                    ?>
                    
                        <div id="SortDeparture{{$count}}" class="flight-devider GlobalDiv {{$DepartureSlot}} Airline<?php foreach($flight_data[0] as $datas){ foreach($datas[0] as $datas1){ echo $datas1[0]['Airline']; }} ?> Stops<?php  foreach($flight_data[0] as $datas){ foreach($datas[0] as $datas1){ $var1=count($datas1)-1; } foreach($datas[1] as $datas1){ $var2=count($datas1)-1; } if($var1==$var2){ echo $var1;}else{echo "Others";} } ?> priceRange<?php foreach($flight_data[1] as $prices){ echo (str_replace('GBP','',$prices['Total Price'] )*100); } ?> SortArrival{{$count}} SortDuration{{$count}}" data-GlobalDiv="1" data-TotalpriceDiv="<?php foreach($flight_data[1] as $prices){ echo (str_replace('GBP','',$prices['Total Price'] )*100); } ?>" data-Deprature-time="<?php foreach($flight_data[0] as $datas){foreach($datas[0] as $datas1){echo \Carbon\Carbon::parse($datas1[0]['Depart'])->format('H:i'); }} ?>" data-Arrival-time="<?php foreach($flight_data[0] as $datas){foreach($datas[0] as $datas1){ echo \Carbon\Carbon::parse($datas1[count($datas1)-1]['Arrive'])->format('H:i'); }} ?>" data-Duration-time="<?php foreach($flight_data[0] as $datas){foreach($datas[0] as $datas1){ echo \Carbon\Carbon::parse($datas1[0]['Depart'])->diff(\Carbon\Carbon::parse($datas1[count($datas1)-1]['Arrive']))->format('%d%H%I');}} ?>">
                            <div class="row align-items-center">
                                <!-- outbound flight details -->
                                @foreach($flight_data[0] as $datas1)
                                <!-- {{count($datas1[0])}}{{count($datas1[1])}} -->
                                @foreach($datas1[0] as $datas)
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <div class="media">
                                        <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir{{$datas[0]['Airline']}}.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                        <div class="media-body align-self-center">
                                            <h6 class="m-0">{{$datas[0]['Airline']}}<br><small class="text-muted">{{$datas[0]['Airline']}}-{{$datas[0]['Flight']}}</small></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-4">
                                    <small><i class="las la-plane-departure h6"></i> {{\Carbon\Carbon::parse($datas[0]['Depart'])->format('d M Y')}}</small>
                                    <h6 class="font-weight-bold mb-0"> {{\Carbon\Carbon::parse($datas[0]['Depart'])->format('H:i')}}</h6>
                                    <span class="text-muted">{{$datas[0]['From']}}</span>
                                </div>
                                <div class="col-md-2 text-center col-4">
                                    <span class="exchange-arrow exchange-relative m-auto" title="hello"><i class="las la-exchange-alt"></i></span>
                                    <h5 class="font-weight-600 mb-0 mt-2">  {{\Carbon\Carbon::parse($datas[0]['Depart'])->diff(\Carbon\Carbon::parse($datas[count($datas)-1]['Arrive']))->format('%dD %Hh %Im')}}</h5>
                                    <small class="text-muted">
                                    <?php 
                                     if(count($datas)==1){ echo "Non stop"; }else{echo ucwords(app('App\Http\Controllers\UtilityController')->convert_number_to_words((count($datas)-1)))." stop";}
                                    ?>
                                    </small>
                                </div>
                                <div class="col-md-2 col-4">
                                    <small><i class="las la-plane-arrival h6"></i> {{\Carbon\Carbon::parse($datas[count($datas)-1]['Arrive'])->format('d M Y')}}</small>
                                    <h6 class="font-weight-bold mb-0"> {{\Carbon\Carbon::parse($datas[count($datas)-1]['Arrive'])->format('H:i')}}</h6>
                                    <span class="text-muted">{{$datas[count($datas)-1]['To']}}</span>
                                </div>
                                <div class="col-md-3 mt-2 mt-md-0 text-center">
                                   
                                </div>
                                @endforeach
                                <!-- inbound flight details -->
                                @foreach($datas1[1] as $datas)
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <div class="media">
                                        <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir{{$datas[0]['Airline']}}.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                        <div class="media-body align-self-center">
                                            <h6 class="m-0">{{$datas[0]['Airline']}}<br><small class="text-muted">{{$datas[0]['Airline']}}-{{$datas[0]['Flight']}}</small></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-4">
                                    <small><i class="las la-plane-departure h6"></i> {{\Carbon\Carbon::parse($datas[0]['Depart'])->format('d M Y')}}</small>
                                    <h6 class="font-weight-bold mb-0"> {{\Carbon\Carbon::parse($datas[0]['Depart'])->format('H:i')}}</h6>
                                    <span class="text-muted">{{$datas[0]['From']}}</span>
                                </div>
                                <div class="col-md-2 text-center col-4">
                                    <span class="exchange-arrow exchange-relative m-auto" title="hello"><i class="las la-exchange-alt"></i></span>
                                    <h5 class="font-weight-600 mb-0 mt-2">  {{\Carbon\Carbon::parse($datas[0]['Depart'])->diff(\Carbon\Carbon::parse($datas[count($datas)-1]['Arrive']))->format('%dD %Hh %Im')}}</h5>
                                    <small class="text-muted">
                                    <?php 
                                     if(count($datas)==1){ echo "Non stop"; }else{echo ucwords(app('App\Http\Controllers\UtilityController')->convert_number_to_words((count($datas)-1)))." stop";}
                                    ?>
                                    </small>
                                </div>
                                <div class="col-md-2 col-4">
                                    <small><i class="las la-plane-arrival h6"></i> {{\Carbon\Carbon::parse($datas[count($datas)-1]['Arrive'])->format('d M Y')}}</small>
                                    <h6 class="font-weight-bold mb-0"> {{\Carbon\Carbon::parse($datas[count($datas)-1]['Arrive'])->format('H:i')}}</h6>
                                    <span class="text-muted">{{$datas[count($datas)-1]['To']}}</span>
                                </div>
                                <div class="col-md-3 mt-2 mt-md-0 text-center">
                                    <h3 class="font-weight-bold"><i class="las la-pound-sign"></i><?php 
                                    $var_total_price=0;
                                    foreach($flight_data[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                    if(isset($flight_data[2])){
                                        foreach($flight_data[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                    }
                                    if(isset($flight_data[3])){
                                        foreach($flight_data[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                    }
                                    echo number_format($var_total_price,2);
                                    ?></h3>
                                    <!-- <a href="flight-details.php" class="btn btn-primary">Book Now</a> -->
                                    <form action="{{ route('roundflightDetails') }}" method="POST">
                                        @csrf
                                        <input type="text" name="flights_outbound" value="{{json_encode($datas1[0])}}" hidden>
                                        <input type="text" name="flights_inbound" value="{{json_encode($datas1[1])}}" hidden>
                                        <input type="text" name="flights_price" value="{{json_encode($flight_data[1])}}" hidden>
                                        <input type="text" name="addFrom" value="{{ $searched->addFrom }}" hidden>
                                        <input type="text" name="addTo" value="{{ $searched->addTo }}" hidden>
                                        <input type="text" name="adults" value="{{ $searched->adults }}" hidden>
                                        <input type="text" name="children" value="{{ $searched->children }}" hidden>
                                        <input type="text" name="infant" value="{{ $searched->infant }}" hidden>
                                        <button type="submit" class="btn btn-primary" onclick="showLoder();">Book Now</button>
                                    </form>
                                    <br>
                                    <a href="#" class="mt-1 d-inline-block h5" data-toggle="collapse" data-target="#flight-details{{ $count }}">View flight details</a>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                            <div id="flight-details{{ $count }}" class="card p-3 collapse mt-3">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#flight_details{{ $count }}">Flight Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#fare_details{{ $count }}">Fare Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#baggage_rules{{ $count }}" onclick="BaggageCancelRule({{ $count }},@foreach($flight_data[0] as $flight_datas){{json_encode($flight_datas[0])}}@endforeach);">Baggage Rules</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#cancellation_rules{{ $count }}" onclick="BaggageCancelRule({{ $count }},{{json_encode($flight_data[0])}});">Cancellation Rules</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content row mt-3">
                                    <div id="flight_details{{ $count }}" class="container tab-pane active">
                                        @foreach($flight_data[0] as $datas1)
                                        @foreach($datas1[0] as $datas)
                                        <h4>Outbound Journey | {{$datas[0]['From']}} - {{$datas[count($datas)-1]['To']}}</h4>
                                        @for($i=0; $i < count($datas); $i++) 
                                        @if($i>0)
                                        <div class="row align-items-center">
                                            <!-- {{$datas[$i]['Depart'] }} ---{{$datas[0]['Arrive']}} ---{{($i-1)}} -->
                                            <div>Change of Planes | {{\Carbon\Carbon::parse($datas[$i]['Depart'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['Arrive']))->format('%Hh %Im')}} layover in ({{$datas[$i]['From']}})</div>
                                        </div>
                                        @endif
                                        <div class="row align-items-center">
                                            <div class="col-md-3 mb-2 mb-md-0">
                                                <div class="media">
                                                    <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php echo $datas[$i]['Airline']; ?>.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                                    <div class="media-body align-self-center">
                                                        <h6 class="m-0"><?php  echo $datas[$i]['Airline']; ?><br><small class="text-muted"><?php echo $datas[$i]['Airline']; ?>-<?php  echo $datas[$i]['Flight']; ?></small></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <small><i class="las la-plane-departure h6"></i> <?php  echo \Carbon\Carbon::parse($datas[$i]['Depart'])->format('d M Y');  ?></small>
                                                <h6 class="font-weight-bold mb-0"> <?php echo \Carbon\Carbon::parse($datas[$i]['Depart'])->format('h:i');  ?></h6>
                                                <span class="text-muted"><?php echo $datas[$i]['From']; ?></span>
                                            </div>
                                            <div class="col-md-2 text-center col-4">
                                                <span class="exchange-arrow exchange-relative m-auto" title="hello"><i class="las la-exchange-alt"></i></span>
                                                <h5 class="font-weight-600 mb-0 mt-2">  <?php  echo \Carbon\Carbon::parse($datas[$i]['Depart'])->diff(\Carbon\Carbon::parse($datas[$i]['Arrive']))->format('%Hh %Im'); ?></h5>
                                                <!-- <small class="text-muted">
                                                <?php 
                                                if(count($datas)==1){ echo "Non stop"; }else{echo ucwords(app('App\Http\Controllers\UtilityController')->convert_number_to_words((count($datas)-1)))." stop" ;}
                                                ?>
                                                </small> -->
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <small><i class="las la-plane-arrival h6"></i> <?php  echo \Carbon\Carbon::parse($datas[$i]['Arrive'])->format('d M Y'); ?></small>
                                                <h6 class="font-weight-bold mb-0"> <?php echo \Carbon\Carbon::parse($datas[$i]['Arrive'])->format('h:i');  ?></h6>
                                                <span class="text-muted"><?php  echo $datas[$i]['To'];?></span>
                                            </div>
                                        </div>
                                        @endfor
                                        @endforeach
                                        @foreach($datas1[1] as $datas)
                                        <h4>Inbound Journey | {{$datas[0]['From']}} - {{$datas[count($datas)-1]['To']}}</h4>
                                        @for($i=0; $i < count($datas); $i++) 
                                        @if($i>0)
                                        <div class="row align-items-center">
                                            <!-- {{$datas[$i]['Depart'] }} ---{{$datas[0]['Arrive']}} ---{{($i-1)}} -->
                                            <div>Change of Planes | {{\Carbon\Carbon::parse($datas[$i]['Depart'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['Arrive']))->format('%Hh %Im')}} layover in ({{$datas[$i]['From']}})</div>
                                        </div>
                                        @endif
                                        <div class="row align-items-center">
                                            <div class="col-md-3 mb-2 mb-md-0">
                                                <div class="media">
                                                    <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php echo $datas[$i]['Airline']; ?>.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                                    <div class="media-body align-self-center">
                                                        <h6 class="m-0"><?php  echo $datas[$i]['Airline']; ?><br><small class="text-muted"><?php echo $datas[$i]['Airline']; ?>-<?php  echo $datas[$i]['Flight']; ?></small></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <small><i class="las la-plane-departure h6"></i> <?php  echo \Carbon\Carbon::parse($datas[$i]['Depart'])->format('d M Y');  ?></small>
                                                <h6 class="font-weight-bold mb-0"> <?php echo \Carbon\Carbon::parse($datas[$i]['Depart'])->format('h:i');  ?></h6>
                                                <span class="text-muted"><?php echo $datas[$i]['From']; ?></span>
                                            </div>
                                            <div class="col-md-2 text-center col-4">
                                                <span class="exchange-arrow exchange-relative m-auto" title="hello"><i class="las la-exchange-alt"></i></span>
                                                <h5 class="font-weight-600 mb-0 mt-2">  <?php  echo \Carbon\Carbon::parse($datas[$i]['Depart'])->diff(\Carbon\Carbon::parse($datas[$i]['Arrive']))->format('%Hh %Im'); ?></h5>
                                                <!-- <small class="text-muted">
                                                <?php 
                                                if(count($datas)==1){ echo "Non stop"; }else{echo ucwords(app('App\Http\Controllers\UtilityController')->convert_number_to_words((count($datas)-1)))." stop" ;}
                                                ?>
                                                </small> -->
                                            </div>
                                            <div class="col-md-2 col-4">
                                                <small><i class="las la-plane-arrival h6"></i> <?php  echo \Carbon\Carbon::parse($datas[$i]['Arrive'])->format('d M Y'); ?></small>
                                                <h6 class="font-weight-bold mb-0"> <?php echo \Carbon\Carbon::parse($datas[$i]['Arrive'])->format('h:i');  ?></h6>
                                                <span class="text-muted"><?php  echo $datas[$i]['To'];?></span>
                                            </div>
                                        </div>
                                        @endfor
                                        @endforeach
                                        @endforeach
                                    </div>
                                    <div id="fare_details{{ $count }}" class="container tab-pane">
                                        <table class="table">
                                            <tr>
                                                <td>Base Fare </td>
                                                <td><i class="las la-pound-sign"></i> <?php 
                                                $var_app_price=0;
                                        foreach($flight_data[1] as $prices){ $var_app_price+= (str_replace('GBP','',$prices['Approx Base Price'])*$searched->adults);} 
                                        if(isset($flight_data[2])){
                                        foreach($flight_data[2] as $prices){ $var_app_price+= (str_replace('GBP','',$prices['Approx Base Price'])*$searched->children);} 
                                        }
                                        if(isset($flight_data[3])){
                                            foreach($flight_data[3] as $prices){ $var_app_price+= (str_replace('GBP','',$prices['Approx Base Price'])*$searched->infant);} 
                                        }
                                        echo number_format($var_app_price,2);
                                                // foreach($flight_data[1] as $prices){ echo str_replace('GBP','',$prices['Approx Base Price'] );} 
                                                ?></td>
                                            </tr>
                                            <tr>
                                                <td>Taxes and Fees </td>
                                                <td><i class="las la-pound-sign"></i> <?php 
                                                $var_tax_price=0;
                                                foreach($flight_data[1] as $prices){ $var_tax_price+= (str_replace('GBP','',$prices['Taxes'])*$searched->adults);} 
                                                if(isset($flight_data[2])){
                                                foreach($flight_data[2] as $prices){ $var_tax_price+= (str_replace('GBP','',$prices['Taxes'])*$searched->children);} 
                                                }
                                                if(isset($flight_data[3])){
                                                    foreach($flight_data[3] as $prices){ $var_tax_price+= (str_replace('GBP','',$prices['Taxes'])*$searched->infant);} 
                                                }
                                                echo number_format($var_tax_price,2);
                                                // foreach($flight_data[1] as $prices){ echo str_replace('GBP','',$prices['Taxes'] );} 
                                                ?></td>
                                            </tr>
                                            <tr>
                                                <td>Total Fare </td>
                                                <td><i class="las la-pound-sign"></i> <?php 
                                                $var_tot_price=0;
                                                foreach($flight_data[1] as $prices){ $var_tot_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                                if(isset($flight_data[2])){
                                                foreach($flight_data[2] as $prices){ $var_tot_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                                }
                                                if(isset($flight_data[3])){
                                                    foreach($flight_data[3] as $prices){ $var_tot_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                                }
                                                echo number_format($var_tot_price,2);
                                                // foreach($flight_data[1] as $prices){ echo str_replace('GBP','',$prices['Total Price'] );} 
                                                ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="baggage_rules{{ $count }}" class="container tab-pane fade">
                                        <table class="table">
                                            <tr>
                                                <td>Baggage Type</td>
                                                <td>Check-In</td>
                                                <td>Cabin</td>
                                            </tr>
                                            <tr>
                                                <td>Adult</td>
                                                <td id="checkIn{{ $count }}">15 Kgs</td>
                                                <td id="cabin{{ $count }}">7 Kgs</td>
                                            </tr>
                                        </table>
                                        <small>The baggage information is just for reference. Please Check with airline before check-in. For more information, visit IndiGo Airlines Website.</small>
                                    </div>
                                    <div id="cancellation_rules{{ $count }}" class="container tab-pane fade"><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Cancellation Charges</h6>
                                                <table class="table">
                                                    <tr>
                                                        <td>0-2 hours</td>
                                                        <td>Non Refundable</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2-72 hours</td>
                                                        <td id="cancellation{{$count}}"><i class="las la-pound-sign"></i> 3,500</td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td>>72 hours</td>
                                                        <td><i class="fas fa-rupee-sign"></i> 3,000</td>
                                                    </tr> -->
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Reschedule Charges</h6>
                                                <table class="table">
                                                    <tr>
                                                        <td>0-2 hours</td>
                                                        <td>Non Refundable</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2-72 hours</td>
                                                        <td id="reschedule{{$count}}"><i class="fas fa-rupee-sign"></i> 3,000</td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <td>>72 hours</td>
                                                        <td><i class="fas fa-rupee-sign"></i> 2,500</td>
                                                    </tr> -->
                                                </table>
                                            </div>
                                        </div>
                                        <h5 class="small">Terms & Conditions</h5>
                                        <ul class="small">
                                            <li>The charges are per passenger per sector and applicable only on refundable type tickets.</li>
                                            <li>Rescheduling Charges = Rescheduling/Change Penalty + Fare Difference (if applicable)</li>
                                            <li>Partial cancellation is not allowed on tickets booked under special discounted fares.</li>
                                            <li>In case of no-show or ticket not cancelled within the stipulated time, only statutory taxes are refundable subject to Goibibo Service Fee.</li>
                                            <li>No Baggage Allowance for Infants</li>
                                            <li>In case of restricted cases , no amendments /cancellation allowed.</li>
                                            <li>Airline penalty needs to be reconfirmed prior to any amendments or cancellation.</li>
                                            <li>Disclaimer: Airline Penalty changes are indicative and can change without prior notice.</li>
                                            <li>NA means Not Available. Please check with airline for penalty information.</li>
                                            <li>If taxes are more than default cancellation penalty then all taxes will be refundable.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $count++; ?>
                    
                    @endforeach
                    @endforeach
                    </div> 
                </div>
            </div>
            @else
            <div class="col-lg-9 flight-section">
                <h3>No flights found</h3>
                <a href="{{route('index')}}" class="btn btn-primary">GO BACK</a>
            </div>
            @endif
        </div>
    </div>
    </div>
</section>


<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->

@endsection

@section('script')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>   -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>   -->
		
<script type="text/javascript">
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();
        var path = "{{ route('searchairport') }}";

         // Set the Options for "Bloodhound" suggestion engine
         var engine = new Bloodhound({
                    remote: {
                        // url: '/find?q=%QUERY%',
                        url: path+'?q=%QUERY%',
                        wildcard: '%QUERY%'
                    },
                    datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });


        $(".search_input").typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                }, {
                    source: engine.ttAdapter(),

                    // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                    name: 'airportList',

                    // the key from the array we want to display (name,id,email,etc...)
                    templates: {
                        empty: [
                            '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                        ],
                        header: [
                            '<div class="list-group search-results-dropdown">'
                        ],
                        suggestion: function (data) {
                            return '<span class="list-group-item">' + data + '</span>'
                        }
                    }
        });

        
        var returning_date ='<?php echo $searched->returning_date;?>';
        if (returning_date!='') {
            $('#one_way').removeAttr('class');
            $('#round_trip').attr('class','active');  
        }

        
        $('.returning_date_datetimepickerclass').click(function(){
            // alert("hii");
            $('#one_way').removeAttr('class');
            $('#round_trip').attr('class','active');
        });
        $(".returning_date_datetimepickerclass").blur(function(){
            // alert("This input field has lost its focus.");
            // alert($('#returning_date').val());
            if($('#returning_date').val()==''){
                $('#round_trip').removeAttr('class');
                $('#one_way').attr('class','active');
            }
            
        });
        $('#one_way').click(function(){
            // alert("hii")
            // returning_date
            $('#returning_date').removeAttr('value');
            $('#returning_date').attr('value');
            $('#returning_date').val('');
            $('#round_trip').removeAttr('class');
            $('#one_way').attr('class','active');
        });

        $('#round_trip').click(function(){
            // alert("hii");
            $("#returning_date_datetimepicker").datetimepicker("destroy");
            $('#one_way').removeAttr('class');
            $('#round_trip').attr('class','active');
            // $("#returning_date_datetimepicker").datetimepicker("show"); 
            var dep_val=$('#departure_date').val();
            var return_val=$('#returning_date').val();
            // alert(return_val)
            if(return_val==''){
                $('#returning_date').val('');
                $('#returning_date').val(dep_val);
            }
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            // alert(adddate);
            // alert(new Date(adddate))
            $('#returning_date_datetimepicker').datetimepicker({
                pickTime: false,
                startDate: new Date(adddate),
                autoclose: true,
                todayHighlight: true,
            });

            // $('#returning_date_datetimepicker').datetimepicker("show");
            $('#returning_date_datetimepicker').datetimepicker("show").on('changeDate', function(){
                $('#returning_date_datetimepicker').datetimepicker("hide")
            });
            
            
        });

        $('.departure_date_datetimepickerclass').click(function(){
            $('#returning_date').val('');
            $("#returning_date_datetimepicker").datetimepicker("destroy");
            $('#departure_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(),
                todayHighlight: true,
                // minDate: new Date(),
                // defaultDate: new Date(),
            });
            $('#departure_date_datetimepicker').datetimepicker("show").on('changeDate', function(){
                // $('#departure_date_datetimepicker').hide();
                $('#departure_date_datetimepicker').datetimepicker("hide")
            });
        
        });

        $('.returning_date_datetimepickerclass').on('click',function(){
            // alert("return hii")
            // $("#returning_date_datetimepicker").datetimepicker("destroy");
            // returning_date
            var dep_val=$('#departure_date').val();
            var return_val=$('#returning_date').val();
            // alert(return_val)
            if(return_val==''){
                $('#returning_date').val('');
                $('#returning_date').val(dep_val);
            }
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            // alert(adddate);
            // alert(new Date(adddate))
            $('#returning_date_datetimepicker').datetimepicker({
                pickTime: false,
                startDate: new Date(adddate),
                autoclose: true,
                todayHighlight: true,
            });

            // $('#returning_date_datetimepicker').datetimepicker("show");
            $('#returning_date_datetimepicker').datetimepicker("show").on('changeDate', function(){
                $('#returning_date_datetimepicker').datetimepicker("hide")
            });
        });



        $("#adults").change(function(){
            // alert("hii");
            var adults=$('#adults').val();
            var children=$('#children').val();
            var infant=$('#infant').val();
            var travel_class=$('#travel_class').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=adults+' Adults, '+children+' Child, '+infant+' Infant, '+travel_class;
            }else if(infant>0){
                var val=adults+' Adults, '+infant+' Infant, '+travel_class;
            }else if(children>0){
                var val=adults+' Adults, '+children+' Child, '+travel_class;
            }else{
                var val=adults+' Adults, '+travel_class;
            }
            $('#flight_travel_details').removeAttr('placeholder');
            $('#flight_travel_details').attr('placeholder',val);
            
        });

        $("#children").change(function(){
            // alert("hii");
            var adults=$('#adults').val();
            var children=$('#children').val();
            var infant=$('#infant').val();
            var travel_class=$('#travel_class').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=adults+' Adults, '+children+' Child, '+infant+' Infant, '+travel_class;
            }else if(infant>0){
                var val=adults+' Adults, '+infant+' Infant, '+travel_class;
            }else if(children>0){
                var val=adults+' Adults, '+children+' Child, '+travel_class;
            }else{
                var val=adults+' Adults, '+travel_class;
            }
            $('#flight_travel_details').removeAttr('placeholder');
            $('#flight_travel_details').attr('placeholder',val);
            
        });
        $("#infant").change(function(){
            // alert("hii");
            var adults=$('#adults').val();
            var children=$('#children').val();
            var infant=$('#infant').val();
            var travel_class=$('#travel_class').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=adults+' Adults, '+children+' Child, '+infant+' Infant, '+travel_class;
            }else if(infant>0){
                var val=adults+' Adults, '+infant+' Infant, '+travel_class;
            }else if(children>0){
                var val=adults+' Adults, '+children+' Child, '+travel_class;
            }else{
                var val=adults+' Adults, '+travel_class;
            }
            $('#flight_travel_details').removeAttr('placeholder');
            $('#flight_travel_details').attr('placeholder',val);
            
        });
        $("#travel_class").change(function(){
            // alert("hii");
            var adults=$('#adults').val();
            var children=$('#children').val();
            var infant=$('#infant').val();
            var travel_class=$('#travel_class').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=adults+' Adults, '+children+' Child, '+infant+' Infant, '+travel_class;
            }else if(infant>0){
                var val=adults+' Adults, '+infant+' Infant, '+travel_class;
            }else if(children>0){
                var val=adults+' Adults, '+children+' Child, '+travel_class;
            }else{
                var val=adults+' Adults, '+travel_class;
            }
            $('#flight_travel_details').removeAttr('placeholder');
            $('#flight_travel_details').attr('placeholder',val);
            
        });

        $('#flight_submit').click(function(){
            // alert("hii");
            var addFrom=$('#addFrom').val();
            var addTo=$('#addTo').val();
            if(addFrom===""){
                alert('Please enter From');
                return false;
            }else if(addTo===""){
                alert('Please enter To');
                return false;
            }
            // alert(addFrom);
            // path='<?php echo route('flights');?>';
            // var url=("{{route('flights')}}")
            // window.location.href(path);
            // window.location.assign(url);
        });

    });
    
    function filter()
    {
        // if ($("."+this.value).attr("data-GlobalDiv")==1) 
        // $(".GlobalDiv").attr("data-GlobalDiv", "0")
        var SearchCount=0;
        var count=0;
     
        $(".GlobalDiv").attr("data-GlobalDiv", "0")
        $(".GlobalDiv").hide();
       
        var arr=[];
        var Departure=0;
        $('input[name="Departure"]:checked').each(function() {
          Departure=1
        });
        if (Departure==1) {
            arr.push("Departure");
        }
        var Stops=0;
        $('input[name="Stops"]:checked').each(function() {
           Stops=1
        });
        if (Stops==1) {
            arr.push("Stops");
        }
        var Airline=0;
        $('input[name="Airline"]:checked').each(function() {
            Airline=1
        });
        if (Airline==1) {
            arr.push("Airline");
        }
          
        $.each(arr, function( index, d ) {
            SearchCount=1;
            count+=1;
            
            $('input[name="'+d+'"]:checked').each(function() {
                if (SearchCount==count) {
                    $("."+this.value).show(); 
                    $("."+this.value).attr("data-GlobalDiv", "1") ; 
                }
                else if(count>SearchCount) 
                {
                    if ($("."+this.value).attr("data-GlobalDiv")=="1") 
                    {
                        $("."+this.value).show();     
                    }  
                }
            });
            $('input[name="'+d+'"]:not(:checked)').each(function() {
            
                $("."+this.value).attr("data-GlobalDiv", "0")
                $("."+this.value).hide();

                    
            });
          
        });
        

          if(SearchCount==0)
          {
            $(".GlobalDiv").show();
            $(".GlobalDiv").attr("data-GlobalDiv", "1")
          }
    }

    function return_filter()
    {
        // if ($("."+this.value).attr("data-GlobalDiv")==1) 
        // $(".GlobalDiv").attr("data-GlobalDiv", "0")
        var SearchCount=0;
        var count=0;
     
        $(".ReturnGlobalDiv").attr("return-data-GlobalDiv", "0")
        $(".ReturnGlobalDiv").hide();
       
        var arr=[];
        var Departure=0;
        $('input[name="ReturnDeparture"]:checked').each(function() {
          Departure=1
        });
        if (Departure==1) {
            arr.push("ReturnDeparture");
        }
        var Stops=0;
        $('input[name="return_Stops"]:checked').each(function() {
           Stops=1
        });
        if (Stops==1) {
            arr.push("return_Stops");
        }
        var Airline=0;
        $('input[name="return_Airline"]:checked').each(function() {
            Airline=1
        });
        if (Airline==1) {
            arr.push("return_Airline");
        }
          
        $.each(arr, function( index, d ) {
            SearchCount=1;
            count+=1;
            
            $('input[name="'+d+'"]:checked').each(function() {
                if (SearchCount==count) {
                    $("."+this.value).show(); 
                    $("."+this.value).attr("return-data-GlobalDiv", "1") ; 
                }
                else if(count>SearchCount) 
                {
                    if ($("."+this.value).attr("return-data-GlobalDiv")=="1") 
                    {
                        $("."+this.value).show();     
                    }  
                }
            });
            $('input[name="'+d+'"]:not(:checked)').each(function() {
            
                $("."+this.value).attr("return-data-GlobalDiv", "0")
                $("."+this.value).hide();

                    
            });
          
        });
        

          if(SearchCount==0)
          {
            $(".ReturnGlobalDiv").show();
            $(".ReturnGlobalDiv").attr("return-data-GlobalDiv", "1")
          }
    }
        
        

    //sorting 
    $('#price_order').click(function(){
        // alert("hii");
        var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;"/>';
        $('#loading_small').append(loading);
        $('#loading_small').show();
        var url= window.location.href;
        var price_order='{{isset($searched->price_order)?$searched->price_order:''}}';
        if(price_order==""){
            var newurl=url+'&price_order=price_order';
        }else{
            var newurl=url.split('&price_order=price_order')[0];
            // alert(newurl);
        }
        // alert(url); 
        window.location.assign(newurl);

    });

    $('#departure_order').click(function(){
            // alert("hii");
            var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;"/>';
            $('#loading_small').append(loading);
            $('#loading_small').show();
            var order_val=$("#departure_order").attr("data-departureordervalue");
            // alert(order_val);
            var DepartureTimeOrder=[];
            var DepartureTimeOrder=<?php 
            $ddd=[];
            $DepartureTimeOrder=array_unique(isset($DepartureTimeOrder)?$DepartureTimeOrder:[]);
            foreach($DepartureTimeOrder as $val){
                array_push($ddd,$val);
            }
            echo json_encode($ddd);
            ?>;
         
            if(order_val=="ASC"){
                for (let index = 0; index < DepartureTimeOrder.sort().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataDepraturetime=$("#SortDeparture"+Divindex).attr("data-Deprature-time")
                    if (dataDepraturetime==DepartureTimeOrder[index]) {
                    $(".MainDiv").append($("#SortDeparture"+Divindex));
                    }
                
                    
                  }
                }
                $("#departure_order").attr("data-departureordervalue", "DESC");
            } 
            else{
               for (let index = 0; index < DepartureTimeOrder.sort().reverse().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataDepraturetime=$("#SortDeparture"+Divindex).attr("data-Deprature-time")
                    if (dataDepraturetime==DepartureTimeOrder[index]) {
                    $(".MainDiv").append($("#SortDeparture"+Divindex));
                    }
                
                    
                 }
               }
                $("#departure_order").attr("data-departureordervalue", "ASC"); 
            }
            $('#loading_small').empty();
            $('#loading_small').hide();
    });

    $('#arrival_order').click(function(){
            // alert("hii");
            var order_val=$("#arrival_order").attr("data-arrivalordervalue");
            // alert(order_val);
            var ArrivalTimeOrder=[];
            var ArrivalTimeOrder=<?php 
            $aaa=[];
            $ArrivalTimeOrder=array_unique(isset($ArrivalTimeOrder)?$ArrivalTimeOrder:[]);
            foreach($ArrivalTimeOrder as $val1){
                array_push($aaa,$val1);
            }
            echo json_encode($aaa);
            ?>;
         
            if(order_val=="ASC"){
                for (let index = 0; index < ArrivalTimeOrder.sort().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataArrivaltime=$(".SortArrival"+Divindex).attr("data-Arrival-time")
                    if (dataArrivaltime==ArrivalTimeOrder[index]) {
                    $(".MainDiv").append($(".SortArrival"+Divindex));
                    }
                
                    
                  }
                }
                $("#arrival_order").attr("data-arrivalordervalue", "DESC");
            } 
            else{
               for (let index = 0; index < ArrivalTimeOrder.sort().reverse().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataArrivaltime=$(".SortArrival"+Divindex).attr("data-Arrival-time")
                    if (dataArrivaltime==ArrivalTimeOrder[index]) {
                    $(".MainDiv").append($(".SortArrival"+Divindex));
                    }
                
                    
                 }
               }
                $("#arrival_order").attr("data-arrivalordervalue", "ASC"); 
            }

    });

    $('#duration_order').click(function(){
            // alert("hii");
            var order_val=$("#duration_order").attr("data-durationordervalue");
            // alert(order_val);
            var DurationTimeOrder=[];
            var DurationTimeOrder=<?php 
            $du=[];
            $DurationTimeOrder=array_unique(isset($DurationTimeOrder)?$DurationTimeOrder:[]);
            foreach($DurationTimeOrder as $val2){
                array_push($du,$val2);
            }
            echo json_encode($du);
            ?>;
            // alert(DurationTimeOrder);
            if(order_val=="ASC"){
                for (let index = 0; index < DurationTimeOrder.sort().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataDurationtime=$(".SortDuration"+Divindex).attr("data-Duration-time")
                    if (dataDurationtime==DurationTimeOrder[index]) {
                    $(".MainDiv").append($(".SortDuration"+Divindex));
                    }
                
                    
                  }
                }
                $("#duration_order").attr("data-durationordervalue", "DESC");
            } 
            else{
               for (let index = 0; index < DurationTimeOrder.sort().reverse().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataDurationtime=$(".SortDuration"+Divindex).attr("data-Duration-time")
                    if (dataDurationtime==DurationTimeOrder[index]) {
                    $(".MainDiv").append($(".SortDuration"+Divindex));
                    }
                
                    
                 }
               }
                $("#duration_order").attr("data-durationordervalue", "ASC"); 
            }

    });


    $('#return_departure_order').click(function(){
            // alert("hii");
            var order_val=$("#return_departure_order").attr("data-departureordervalue");
            // alert(order_val);
            var ReturnDepartureTimeOrder=[];
            var ReturnDepartureTimeOrder=<?php 
            $ddd=[];
            $ReturnDepartureTimeOrder=array_unique(isset($ReturnDepartureTimeOrder)?$ReturnDepartureTimeOrder:[]);
            foreach($ReturnDepartureTimeOrder as $val){
                array_push($ddd,$val);
            }
            echo json_encode($ddd);
            ?>;
         
            if(order_val=="ASC"){
                for (let index = 0; index < ReturnDepartureTimeOrder.sort().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.ReturnGlobalDiv').length; Divindex++) {
                    var dataDepraturetime=$("#ReturnSortDeparture"+Divindex).attr("data-Deprature-time")
                    if (dataDepraturetime==ReturnDepartureTimeOrder[index]) {
                    $(".ReturnMainDiv").append($("#ReturnSortDeparture"+Divindex));
                    }
                
                    
                  }
                }
                $("#return_departure_order").attr("data-departureordervalue", "DESC");
            } 
            else{
               for (let index = 0; index < ReturnDepartureTimeOrder.sort().reverse().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.ReturnGlobalDiv').length; Divindex++) {
                    var dataDepraturetime=$("#ReturnSortDeparture"+Divindex).attr("data-Deprature-time")
                    if (dataDepraturetime==ReturnDepartureTimeOrder[index]) {
                    $(".ReturnMainDiv").append($("#ReturnSortDeparture"+Divindex));
                    }
                
                    
                 }
               }
                $("#return_departure_order").attr("data-departureordervalue", "ASC"); 
            }

    });

    $('#return_arrival_order').click(function(){
            // alert("hii");
            var order_val=$("#return_arrival_order").attr("data-arrivalordervalue");
            // alert(order_val);
            var ArrivalTimeOrder=[];
            var ArrivalTimeOrder=<?php 
            $aaa=[];
            $ArrivalTimeOrder=array_unique(isset($ReturnArrivalTimeOrder)?$ReturnArrivalTimeOrder:[]);
            foreach($ArrivalTimeOrder as $val1){
                array_push($aaa,$val1);
            }
            echo json_encode($aaa);
            ?>;
         
            if(order_val=="ASC"){
                for (let index = 0; index < ArrivalTimeOrder.sort().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.ReturnGlobalDiv').length; Divindex++) {
                    var dataArrivaltime=$(".return_SortArrival"+Divindex).attr("return-data-Arrival-time")
                    if (dataArrivaltime==ArrivalTimeOrder[index]) {
                    $(".ReturnMainDiv").append($(".return_SortArrival"+Divindex));
                    }
                
                    
                  }
                }
                $("#return_arrival_order").attr("data-arrivalordervalue", "DESC");
            } 
            else{
               for (let index = 0; index < ArrivalTimeOrder.sort().reverse().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.ReturnGlobalDiv').length; Divindex++) {
                    var dataArrivaltime=$(".return_SortArrival"+Divindex).attr("return-data-Arrival-time")
                    if (dataArrivaltime==ArrivalTimeOrder[index]) {
                    $(".ReturnMainDiv").append($(".return_SortArrival"+Divindex));
                    }
                
                    
                 }
               }
                $("#return_arrival_order").attr("data-arrivalordervalue", "ASC"); 
            }

    });

    $('#return_duration_order').click(function(){
            // alert("hii");
            var order_val=$("#return_duration_order").attr("data-durationordervalue");
            // alert(order_val);
            var DurationTimeOrder=[];
            var DurationTimeOrder=<?php 
            $du=[];
            $DurationTimeOrder=array_unique(isset($ReturnDurationTimeOrder)?$ReturnDurationTimeOrder:[]);
            foreach($DurationTimeOrder as $val2){
                array_push($du,$val2);
            }
            echo json_encode($du);
            ?>;
            // alert(DurationTimeOrder);
            if(order_val=="ASC"){
                for (let index = 0; index < DurationTimeOrder.sort().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataDurationtime=$(".return_SortDuration"+Divindex).attr("return-data-Duration-time")
                    if (dataDurationtime==DurationTimeOrder[index]) {
                    $(".ReturnMainDiv").append($(".return_SortDuration"+Divindex));
                    }
                
                    
                  }
                }
                $("#return_duration_order").attr("data-durationordervalue", "DESC");
            } 
            else{
               for (let index = 0; index < DurationTimeOrder.sort().reverse().length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                    var dataDurationtime=$(".return_SortDuration"+Divindex).attr("return-data-Duration-time")
                    if (dataDurationtime==DurationTimeOrder[index]) {
                    $(".ReturnMainDiv").append($(".return_SortDuration"+Divindex));
                    }
                
                    
                 }
               }
                $("#return_duration_order").attr("data-durationordervalue", "ASC"); 
            }

    });

    // baggage_rules
    function BaggageCancelRule(count,flights){
        // alert(flights);    
        var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;"/>';
        $('#loading_small').append(loading);
        $('#loading_small').show();

        $("#cancellation"+count).empty();
        $("#reschedule"+count).empty();
        $("#checkIn"+count).empty();
        $("#cabin"+count).empty();
        var count=count;
        var flights=flights;
        
        $.ajax({
            type: "POST",
            url: "{{ route('roundBaggageCancelRuleReturnajax') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                count:count,
                flights:flights
            },
            success: function(data){
                // alert(data);
                var obj = JSON.parse ( data );
                // alert(obj.baggageallowanceinfo);
                $('#loading_small').hide();
                $('#loading_small').empty();
                if(obj.changepenalty!=''){
                    var changepenalty='<i class="las la-pound-sign"></i>'+obj.changepenalty.replace('GBP','');
                }else{
                    var changepenalty='';
                }
                if(obj.cancelpenalty!=''){
                    var cancelpenalty='<i class="las la-pound-sign"></i>'+obj.cancelpenalty.replace('GBP','');
                }else{
                    var cancelpenalty='';
                }
                if(obj.baggageallowanceinfo!=''){
                    var baggageallowanceinfo=obj.baggageallowanceinfo+"gs";
                }else{
                    var baggageallowanceinfo='';
                }
                if(obj.carryonallowanceinfo!=''){
                    var carryonallowanceinfo=obj.carryonallowanceinfo+"gs";
                }else{
                    var carryonallowanceinfo='';
                }
                $("#cancellation"+count).append(cancelpenalty);
                $("#reschedule"+count).append(changepenalty);
                $("#checkIn"+count).append(baggageallowanceinfo);
                $("#cabin"+count).append(carryonallowanceinfo);

            }
        });

    }

    function return_BaggageCancelRule(count,flights){
        // alert(flights);    
        var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;"/>';
        $('#loading_small').append(loading);
        $('#loading_small').show();

        $("#return_cancellation"+count).empty();
        $("#return_reschedule"+count).empty();
        $("#return_checkIn"+count).empty();
        $("#return_cabin"+count).empty();
        var count=count;
        var flights=flights;
        
        $.ajax({
            type: "POST",
            url: "{{ route('BaggageCancelRuleajax') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                count:count,
                flights:flights
            },
            success: function(data){
                // alert(data);
                var obj = JSON.parse ( data );
                // alert(obj.baggageallowanceinfo);
                $('#loading_small').hide();
                $('#loading_small').empty();
                if(obj.changepenalty!=''){
                    var changepenalty='<i class="las la-pound-sign"></i>'+obj.changepenalty.replace('GBP','');
                }else{
                    var changepenalty='';
                }
                if(obj.cancelpenalty!=''){
                    var cancelpenalty='<i class="las la-pound-sign"></i>'+obj.cancelpenalty.replace('GBP','');
                }else{
                    var cancelpenalty='';
                }
                if(obj.baggageallowanceinfo!=''){
                    var baggageallowanceinfo=obj.baggageallowanceinfo+"gs";
                }else{
                    var baggageallowanceinfo='';
                }
                if(obj.carryonallowanceinfo!=''){
                    var carryonallowanceinfo=obj.carryonallowanceinfo+"gs";
                }else{
                    var carryonallowanceinfo='';
                }
                $("#return_cancellation"+count).append(cancelpenalty);
                $("#return_reschedule"+count).append(changepenalty);
                $("#return_checkIn"+count).append(baggageallowanceinfo);
                $("#return_cabin"+count).append(carryonallowanceinfo);

            }
        });

    }
    function showLoder(){
        $('#loading').show();
    }

    function OnwardFlightDetails(count,flight_data,addFrom,addTo,adults,children,infant){
        var count=count;
        var journeydata=flight_data[0];
        var pricedata=flight_data[1];
       
        for (x in journeydata) {
            // var deptime=journeydata[x].length;
            var airline=journeydata[x][0]['Airline'][0];
            var deptime=journeydata[x][0]['Depart'][0];
            var arrive=journeydata[x][(journeydata[x].length)-1]['Arrive'][0];
        }
        // alert(airline+"  "+deptime+"  "+arrive);
        var time_Onward=DateFormat(deptime)+" → "+DateFormat(arrive);
        // alert(DateFormat(deptime));
        $('#time_Onward').empty();
        $("#time_Onward").append(time_Onward);

        for (x in pricedata) {
            var price= pricedata[x]['Total Price'][0].replace('GBP','');
        }
        // alert(price);
        var price_Onward="£ "+price;
        var return_total_price=$("#return_total_price").val();
        // alert(inputvalreturnflight);
        var total_price="£ "+(parseFloat(price)+parseFloat(return_total_price)).toFixed(2);
        // alert(total_price);
        // var totalPriceDiv=""+total_price
        $('#totalPriceDiv').empty();
        $("#totalPriceDiv").append(total_price);

        var src_val="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir"+airline+".gif"
        $('#img_Onward').removeAttr('src');
        $("#img_Onward").attr('src',src_val);
        
        $('#price_Onward').empty();
        $("#price_Onward").append(price_Onward);

        $('#total_price').removeAttr('value');
        $("#total_price").attr('value',price);

        var onwordflights=$("input[name='radioFlight']:checked").val();
        $("#flights").removeAttr('value');
        $("#flights").attr('value',onwordflights);
        // var returnflights=$("input[name='radioReturnFlight']:checked").val();
        
    }
    function ReturnFlightDetails(count,flight_data,addFrom,addTo,adults,children,infant){
        // alert("hii");
        var count=count;
        var journeydata=flight_data[0];
        var pricedata=flight_data[1];
       
        for (x in journeydata) {
            // var deptime=journeydata[x].length;
            var airline=journeydata[x][0]['Airline'][0];
            var deptime=journeydata[x][0]['Depart'][0];
            var arrive=journeydata[x][(journeydata[x].length)-1]['Arrive'][0];
        }
        // alert(airline+"  "+deptime+"  "+arrive);
        var time_Return=DateFormat(deptime)+" → "+DateFormat(arrive);
        // alert(DateFormat(deptime));
        $('#time_Return').empty();
        $("#time_Return").append(time_Return);

        for (x in pricedata) {
            var price= pricedata[x]['Total Price'][0].replace('GBP','');
        }
        // alert(price);
        var price_Onward="£ "+price;
        var return_total_price=$("#total_price").val();
        // alert(inputvalreturnflight);
        var total_price="£ "+(parseFloat(price)+parseFloat(return_total_price)).toFixed(2);
        // alert(total_price);
        // var totalPriceDiv=""+total_price
        $('#totalPriceDiv').empty();
        $("#totalPriceDiv").append(total_price);
        
        var src_val="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir"+airline+".gif"
        $('#img_Return').removeAttr('src');
        $("#img_Return").attr('src',src_val);
        
        $('#price_Return').empty();
        $("#price_Return").append(price_Onward);

        $('#return_total_price').removeAttr('value');
        $("#return_total_price").attr('value',price);

        var onwordflights=$("input[name='radioReturnFlight']:checked").val();
        $("#return_flights_data").removeAttr('value');
        $("#return_flights_data").attr('value',onwordflights);
    }

    function DateFormat_old(stringDate){
        var date = new Date(stringDate);
        var seconds = date.getSeconds();
        var minutes = date.getMinutes();
        var hour = date.getHours();
        var HoursMinutes = hour + ":" + minutes;
        // alert(HoursMinutes);
        return HoursMinutes;
    }

    function DateFormat(stringDate){
        var data=stringDate.split("T");
        // alert(data);
        var data1=data[1].split(":");
        var date=data1[0]+":"+data1[1];
        // alert(date);
        return date;
    }

     // onword price slider function
     var slider = document.getElementById("onwwayRange");
    // var output = document.getElementById("amount");
    // output.innerHTML = slider.value;
    slider.oninput = function() {
        // alert("hii");
        var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;"/>';
        // alert(loading)
        $('#loading_small').append(loading);
        $('#loading_small').show();
        var min_val=$('#onwwayRange_minprice').val();
        var mix_val=$('#onwwayRange_maxprice').val();
        var cal_min_val=min_val/100;
        // alert(cal_min_val)
        // alert(this.value);
        var range_val=this.value/100;
        var amount='<i class="las la-pound-sign"></i>'+parseFloat(cal_min_val).toFixed(2)+' - <i class="las la-pound-sign"></i>'+parseFloat(range_val).toFixed(2);
        $('#amount').empty();
        $('#amount').append(amount);
        // alert("hii");
        // alert(min_val);
        for (var index = parseInt(min_val); index <= parseInt(mix_val); index++) {
            // alert(index);
            $(".priceRange"+index).attr("data-GlobalDiv", "0")
            $('.priceRange'+index).hide();
        }
        for (let index1 = parseInt(min_val); index1 <= parseInt(this.value); index1++) {
            // const element = array[index];
            $(".priceRange"+index1).attr("data-GlobalDiv", "1")
            $('.priceRange'+index1).show();
            
        }
        $('#loading_small').hide();
        $('#loading_small').empty();
        // output.innerHTML = this.value;
    }
</script>
@endsection