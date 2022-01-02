@extends('common.master')
@section('content')

<div class="middle">
    <div class="search-results">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">From</small>
                    <h6 class="font-weight-600 mb-0">{{$searched->from1}}</h6>
                    <small class="exchange-arrow"><i class="las la-exchange-alt"></i></small>
                </div>
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">To</small>
                    <h6 class="font-weight-600 mb-0">{{isset($searched->to3)?$searched->to3:$searched->to2}}</h6>
                </div>
                <!-- <div class="col-md col-6 my-2 my-md-0">
                    <small class="text-muted d-block mb-1">Departure date</small>
                    <h6 class="font-weight-600 mb-0">05/03/2021</h6>
                </div>
                <div class="col-md col-6 my-2 my-md-0">
                    <small class="text-muted d-block mb-1">Returning date</small>
                    <h6 class="font-weight-600 mb-0">08/03/2021</h6>
                </div> -->
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
                <form name="multicity" id="multicity" method="GET" action="{{route('multicityflight')}}" class="w-100">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="font-weight-600 mb-3">Multi City / Stop Over <i class="las la-plane"></i></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h6 class="text-uppercase text-muted">Flight 1</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From</label>
                                <input type="text" name="from1" id="from1" required value="{{$searched->from1}}" required placeholder="(IXC) | Chandigarh Airport" class="form-control search_input">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To</label>
                                <input type="text" name="to1" id="to1" required value="{{$searched->to1}}" required placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Date</label>
                                <div id="flight0_date_datetimepicker" class="input-group flight0_date_datetimepicker_class">
                                    <input type="text" name="flight0_date" id="flight0_date" required value="{{ isset($searched->flight0_date)? \Carbon\Carbon::parse($searched->flight0_date)->format('d-m-Y'):'' }}" placeholder="dd-mm-yyyy" class="form-control border-right-0 flight0_date_datetimepicker_class" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on flight0_date_datetimepicker_class">
                                    <span class="input-group-text bg-white pl-0 flight0_date_datetimepicker_class"><i class="lar la-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <h6 class="text-uppercase text-muted">Flight 2</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From</label>
                                <input type="text" name="from2" id="from2" required value="{{$searched->from2}}" required placeholder="(IXC) | Chandigarh Airport" class="form-control search_input">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To</label>
                                <input type="text" name="to2" id="to2" required value="{{$searched->to2}}" required placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Date</label>
                                <div id="flight1_date_datetimepicker" class="input-group flight1_date_datetimepicker_class">
                                    <input type="text" name="flight1_date" required id="flight1_date" value="{{ isset($searched->flight1_date)? \Carbon\Carbon::parse($searched->flight1_date)->format('d-m-Y'):'' }}" placeholder="dd-mm-yyyy" class="form-control border-right-0 flight1_date_datetimepicker_class" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on flight1_date_datetimepicker_class">
                                    <span class="input-group-text bg-white pl-0 flight1_date_datetimepicker_class"><i class="lar la-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="3rdFlight" data-show-value="0">
                        <div class="col-md-2">
                            <h6 class="text-uppercase text-muted">Flight 3</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>From</label>
                                <input type="text" name="from3" id="from3" value="{{$searched->from3}}" placeholder="(IXC) | Chandigarh Airport" class="form-control search_input">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To</label>
                                <input type="text" name="to3" id="to3" value="{{$searched->to3}}" placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Date</label>
                                <div id="flight2_date_datetimepicker" class="input-group flight2_date_datetimepicker_class">
                                    <input type="text" name="flight2_date" id="flight2_date" value="{{ isset($searched->flight2_date)? \Carbon\Carbon::parse($searched->flight2_date)->format('d-m-Y'):'' }}" placeholder="dd-mm-yyyy" class="form-control border-right-0 flight2_date_datetimepicker_class" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on flight2_date_datetimepicker_class">
                                    <span class="input-group-text bg-white pl-0 flight2_date_datetimepicker_class"><i class="lar la-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <span class="input-group-text" id="crossIcon_flight3" style="cursor: pointer;"><i class="las la-times"></i></span>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <a href="javascript:void(0)" id="addFlight"><i class="las la-plus-circle"></i> Add Another Flight (Add upto 3 cities)</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md col-6">
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
                        <div class="col-md col-6">
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
                        <div class="col-md col-6">
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
                        <div class="col-md col-6">
                            <div class="form-group">
                                <label>Travel Class</label>
                                <select name="travel_class" id="travel_class" class="custom-select">
                                    <option value="Economy" selected>Economy</option>
                                    <option value="Business">Business</option>
                                    <option value="First Class">First Class</option>
                                    <option value="Premium Economy">Premium Economy</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md col-12">
                            <input type="submit" id="submit" value="Search Flight" class="btn btn-primary">
                            <!-- <a href="flights.php" class="btn btn-primary">Search Flight</a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
</section>

<section class="search-packages mt-4">
    <div class="container-fluid">
        @if(count($multiflights)>0)
        <div class="row">
            <div class="col-lg-3 filters_wrapper">
                <div class="card">
                    <h4 class="font-weight-600 m-0">Filter Result <span class="d-inline-block d-lg-none  filter-open float-right"><i class="las la-times"></i></span></h4>
                    <div class="filter-set">
                        <h6 class="font-weight-600">Stops </h6>
                        @foreach($stops as $stop)
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
                        foreach($multiflights[0] as $datas){
                            
                            $var_total_price=0;
                            foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                            if(isset($datas[2])){
                            foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                            }
                            if(isset($datas[3])){
                                foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                            }
                        }
                        echo number_format($var_total_price,2,'.','');
                        echo ' - <i class="las la-pound-sign"></i>';
                        foreach($multiflights[(count($multiflights)-1)] as $datas){
                            
                            $var_total_price1=0;
                            foreach($datas[1] as $prices){ $var_total_price1+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                            if(isset($datas[2])){
                            foreach($datas[2] as $prices){ $var_total_price1+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                            }
                            if(isset($datas[3])){
                                foreach($datas[3] as $prices){ $var_total_price1+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                            }
                        }
                        echo number_format($var_total_price1,2,'.','');
                            // foreach($multiflights[0] as $flight){
                            //     foreach($flight[1] as $prices){ 
                            //         echo str_replace('GBP','',$prices['Total Price']);
                            //     }
                            // }
                            // echo ' - <i class="las la-pound-sign"></i>';
                            // foreach($multiflights[(count($multiflights)-1)] as $flight){
                            //     foreach($flight[1] as $prices){ 
                            //         echo str_replace('GBP','',$prices['Total Price']);
                            //     }
                            // }
                        ?></label>
                        <input type="range" class="custom-range" id="onwwayRange" name="onwwayRange" 
                        min="<?php foreach($multiflights[0] as $datas){
                            
                            $var_total_price=0;
                            foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                            if(isset($datas[2])){
                            foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                            }
                            if(isset($datas[3])){
                                foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                            }
                        }
                        echo (number_format($var_total_price,2,'.','')*100); ?>" 
                        max="<?php foreach($multiflights[(count($multiflights)-1)] as $datas){
                            
                            $var_total_price=0;
                            foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                            if(isset($datas[2])){
                            foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                            }
                            if(isset($datas[3])){
                                foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                            }
                        }
                        echo (number_format($var_total_price,2,'.','')*100); ?>" 
                        value="<?php foreach($multiflights[(count($multiflights)-1)] as $datas){
                            
                            $var_total_price=0;
                            foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                            if(isset($datas[2])){
                            foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                            }
                            if(isset($datas[3])){
                                foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                            }
                        }
                        echo (number_format($var_total_price,2,'.','')*100);?>">
                        <input type="hidden" class="custom-range" id="onwwayRange_minprice" name="onwwayRange_minprice" value="<?php 
                            foreach($multiflights[0] as $datas){
                            
                                $var_total_price=0;
                                foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                if(isset($datas[2])){
                                foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                }
                                if(isset($datas[3])){
                                    foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                }
                            }
                            echo (number_format($var_total_price,2,'.','')*100);
                        ?>">
                        <input type="hidden" class="custom-range" id="onwwayRange_maxprice" name="onwwayRange_maxprice" value="<?php 
                            foreach($multiflights[(count($multiflights)-1)] as $datas){
                            
                                $var_total_price=0;
                                foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                if(isset($datas[2])){
                                foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                }
                                if(isset($datas[3])){
                                    foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                }
                            }
                            echo (number_format($var_total_price,2,'.','')*100);
                        ?>">
                        <input type="hidden" class="custom-range" id="onwwayRange_rangeprice" name="onwwayRange_rangeprice" value="<?php 
                            foreach($multiflights[(count($multiflights)-1)] as $datas){
                            
                                $var_total_price=0;
                                foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                if(isset($datas[2])){
                                foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                }
                                if(isset($datas[3])){
                                    foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                }
                            }
                            echo (number_format($var_total_price,2,'.','')*100);
                        ?>"/>
                        
                    </div>
                    <div class="filter-set">
                        <h6 class="font-weight-600">Airlines </h6>
                        @foreach($airlines as $airline)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="Airline{{$airline}}" name="Airline" value="Airline{{$airline}}" onclick="filter()" >
                            <label class="custom-control-label" for="Airline{{$airline}}">{{ $airline }} <img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir{{$airline}}.gif" alt="6E.png" style="width:20px;height:20px;" class="mr-2"/></label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-9 flight-section">
                <div class="card">
                    <div class="row row-heading d-none d-md-flex">
                        <div class="col-md-3">Airlines</div>
                        <div class="col-md-2">Departure</div>
                        <div class="col-md-2 text-center">Duration</div>
                        <div class="col-md-2">Arrival</div>
                        <div class="col-md-3 text-center" id="price_order" style="cursor: pointer;">Price <i class="las la-long-arrow-alt-up"></i><i class="las la-long-arrow-alt-down"></i></div>
                    </div>
                    @if(count($multiflights)>0)
                    <?php $count=1; $DepartureTime="";$DepartureSlot="";?>
                    @foreach($multiflights as $data)
                    <?php 
                    foreach($data as $datas){
                        foreach($datas[0] as $datas1){
                            foreach($datas1[0] as $journey){
                                // print_r($journey);
                                $DepartureTime =\Carbon\Carbon::parse($journey[0]['Depart'])->format('H:i'); 
                                // echo $journey[0]['Airline'];                             
                            }
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
                    <div id="SortDeparture{{$count}}" class="flight-devider GlobalDiv {{$DepartureSlot}} 
                    Airline<?php foreach($data as $datas){
                            foreach($datas[0] as $datas1){
                            // foreach($datas1 as $datas2){
                            foreach($datas1[0] as $journey){
                                echo $journey[0]['Airline']; 
                            // }
                            
                            }}} ?> Stops<?php  foreach($data as $datas){
                                foreach($datas[0] as $datas1){
                                foreach($datas1[0] as $journey){
                                    $var1= (count($journey)-1); 
                                }
                                foreach($datas1[1] as $journey1){
                                    $var2= (count($journey1)-1); 
                                }
                                if(isset($datas1[2])){
                                    foreach($datas1[2] as $journey1){
                                        $var3= (count($journey1)-1); 
                                    } 
                                }
                                }} if(isset($var3)){if($var1==$var2 && $var1==$var3 && $var2==$var3){echo $var1;}else{echo "other";}}else{ if($var1==$var2){echo $var1;}else{echo "other";}} ?>
                                priceRange<?php 
                                foreach($data as $datas){
                                    
                                    $var_total_price=0;
                                    foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                    if(isset($datas[2])){
                                    foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                    }
                                    if(isset($datas[3])){
                                        foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                    }
                                }
                                echo (number_format($var_total_price,2,'.','')*100);
                                ?>
                                " data-totalpricediv="<?php 
                                foreach($data as $datas){
                                    
                                    $var_total_price=0;
                                    foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                    if(isset($datas[2])){
                                    foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                    }
                                    if(isset($datas[3])){
                                        foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                    }
                                }
                                echo (number_format($var_total_price,2,'.','')*100);
                                ?>">
                        <div class="row align-items-center">
                        @foreach($data as $datas)
                        <?php $priceShowcount=1; $total_price=0;?>
                        @foreach($datas[0] as $datas1)
                        <?php $priceShowcount1=1;?>
                            @foreach($datas1 as $datas2)
                            <div class="col-md-3 mb-2 mb-md-0">
                                <div class="media">
                                    <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php foreach($datas2 as $journey){ echo $journey[0]['Airline']; } ?>.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0"><?php foreach($datas2 as $journey){ echo $journey[0]['Airline']; } ?><br><small class="text-muted"><?php foreach($datas2 as $journey){ echo $journey[0]['Airline']; } ?>-<?php foreach($datas2 as $journey){ echo $journey[0]['Flight']; } ?></small></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-4">
                                <small><i class="las la-plane-departure h6"></i> <?php foreach($datas2 as $journey){ echo \Carbon\Carbon::parse($journey[0]['Depart'])->format('d M Y'); } ?></small>
                                <h6 class="font-weight-bold mb-0"><?php foreach($datas2 as $journey){ echo \Carbon\Carbon::parse($journey[0]['Depart'])->format('H:i'); } ?></h6>
                                <span class="text-muted"><?php foreach($datas2 as $journey){ echo $journey[0]['From']; }?></span>
                            </div>
                            <div class="col-md-2 text-center col-4">
                                <span class="exchange-arrow exchange-relative m-auto"><i class="las la-exchange-alt"></i></span>
                                <h5 class="font-weight-600 mb-0 mt-2"><?php foreach($datas2 as $journey){ echo \Carbon\Carbon::parse($journey[0]['Depart'])->diff(\Carbon\Carbon::parse($journey[count($journey)-1]['Arrive']))->format('%Hh %Im');} ?></h5>
                                <small class="text-muted"><?php 
                            foreach($datas2 as $journey){ if(count($journey)==1){ echo "Non stop"; }else{echo ucwords(app('App\Http\Controllers\UtilityController')->convert_number_to_words((count($journey)-1)))." stop";}}
                            ?></small>
                            </div>
                            <div class="col-md-2 col-4">
                                <small><i class="las la-plane-arrival h6"></i> <?php foreach($datas2 as $journey){ echo \Carbon\Carbon::parse($journey[count($journey)-1]['Arrive'])->format('d M Y'); } ?></small>
                                <h6 class="font-weight-bold mb-0"><?php foreach($datas2 as $journey){ echo \Carbon\Carbon::parse($journey[count($journey)-1]['Arrive'])->format('H:i'); } ?></h6>
                                <span class="text-muted"><?php foreach($datas2 as $journey){  echo $journey[count($journey)-1]['To'];}?></span>
                            </div>
                            <div class="col-md-3 mt-2 mt-md-0 text-center">
                                
                                <?php //foreach($datas2[1] as $prices){ $total_price=$total_price+str_replace('GBP','',$prices['Total Price']);} ?>
                                @if($priceShowcount1==count($datas1))
                                <h3 class="font-weight-bold"><i class="las la-pound-sign"><?php 
                                $var_total_price=0;
                                foreach($datas[1] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                if(isset($datas[2])){
                                foreach($datas[2] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                }
                                if(isset($datas[3])){
                                    foreach($datas[3] as $prices){ $var_total_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                }
                                echo number_format($var_total_price,2);
                                ?></i></h3>
                                <!-- <a href="flight-details.php" class="btn btn-primary">Book Now</a><br> -->
                                <form name="flightdetails" method="POST" action="{{route('multicityflightdetails')}}">
                                    @csrf
                                    @foreach($datas[0] as $datas0)
                                    <?php $formcount=1;?>
                                    @foreach($datas0 as $datas1)
                                    @foreach($datas1 as $datas2)
                                    <input type="hidden" name="flights{{$formcount}}" id="flights{{$formcount}}" value="{{json_encode($datas2)}}">
                                    @endforeach
                                    <?php $formcount++; ?>
                                    @endforeach
                                    @endforeach
                                    <input type="hidden" name="price" id="price" value="{{json_encode($datas[1])}}">
                                    <input type="hidden" name="price1" id="price1" value="{{isset($datas[2])?json_encode($datas[1]):''}}">
                                    <input type="hidden" name="price2" id="price2" value="{{isset($datas[3])?json_encode($datas[3]):''}}">
                                    <!-- {{count($datas)}} -->
                                    <input type="hidden" name="trip" id="trip" value="@foreach($datas[0] as $datas0){{count($datas0)}}@endforeach">
                                    <input type="hidden" name="adults" id="adults" value="{{$searched->adults}}">
                                    <input type="hidden" name="children" id="children" value="{{$searched->children}}">
                                    <input type="hidden" name="infant" id="infant" value="{{$searched->infant}}">
                                    <!-- all search datas -->
                                    <input type="hidden" name="from1" id="from1" value="{{$searched->from1}}">
                                    <input type="hidden" name="from2" id="from2" value="{{$searched->from2}}">
                                    <input type="hidden" name="from3" id="from3" value="{{$searched->from3}}">
                                    <input type="hidden" name="to1" id="to1" value="{{$searched->to1}}">
                                    <input type="hidden" name="to2" id="to2" value="{{$searched->to2}}">
                                    <input type="hidden" name="to3" id="to3" value="{{$searched->to3}}">

                                    <!-- <input type="hidden" name="flights" id="flights" value="{{json_encode($datas)}}"> -->
                                    <input type="submit" id="submit" value="Book Now" class="btn btn-primary"> <br>
                                </form>
                                <a href="#" class="mt-1 d-inline-block h5" data-toggle="collapse" data-target="#flight-details{{$count}}">View flight details</a>
                                @endif
                            </div>
                            <?php $priceShowcount1++;?>
                            <!-- </form> -->
                            @endforeach 
                            <!-- </form> -->
                            <?php $priceShowcount++; ?>
                        @endforeach   
                        @endforeach   
                        </div>
                        <div id="flight-details{{$count}}" class="card p-3 collapse mt-3">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#flight_details{{ $count }}">Flight Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#fare_details{{$count}}">Fare Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#baggage_rules{{$count}}" onclick="BaggageCancelRule({{ $count }},@foreach($data as $datas) @foreach($datas[0] as $datas1){{json_encode($datas1[0])}} @endforeach @endforeach);">Baggage Rules</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#cancellation_rules{{$count}}" onclick="BaggageCancelRule({{ $count }},@foreach($data as $datas) @foreach($datas[0] as $datas1){{json_encode($datas1[0])}} @endforeach @endforeach);">Cancellation Rules</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content row mt-3">
                                <div id="flight_details{{ $count }}" class="container tab-pane active">
                                    @foreach($data as $datas0)
                                    @foreach($datas0[0] as $datas1)
                                    @foreach($datas1 as $flight_data)
                                    @foreach($flight_data as $datas)
                                    @for($i=0; $i < count($datas); $i++) 
                                    <!-- {{$datas[0]['Airline']}} -->
                                    @if($i==0)
                                    <div>{{$datas[0]['From']}} - {{$datas[count($datas)-1]['To']}} | {{\Carbon\Carbon::parse($datas[$i]['Depart'])->format('d M Y')}}</div>
                                    @endif
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
                                    @endforeach
                                    @endforeach
                                </div>
                                <div id="fare_details{{$count}}" class="container tab-pane fade">
                                    <table class="table">
                                        @foreach($data as $datas)
                                        <tr>
                                            <td>Base Fare</td>
                                            <td><i class="las la-pound-sign"></i> <?php 
                                            $var_app_price=0;
                                            foreach($datas[1] as $prices){ $var_app_price+= (str_replace('GBP','',$prices['Approx Base Price'])*$searched->adults);} 
                                            if(isset($datas[2])){
                                            foreach($datas[2] as $prices){ $var_app_price+= (str_replace('GBP','',$prices['Approx Base Price'])*$searched->children);} 
                                            }
                                            if(isset($datas[3])){
                                                foreach($datas[3] as $prices){ $var_app_price+= (str_replace('GBP','',$prices['Approx Base Price'])*$searched->infant);} 
                                            }
                                            echo number_format($var_app_price,2);
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <td>Taxes and Fees</td>
                                            <td><i class="las la-pound-sign"></i> <?php 
                                            $var_tax_price=0;
                                            foreach($datas[1] as $prices){ $var_tax_price+= (str_replace('GBP','',$prices['Taxes'])*$searched->adults);} 
                                            if(isset($datas[2])){
                                            foreach($datas[2] as $prices){ $var_tax_price+= (str_replace('GBP','',$prices['Taxes'])*$searched->children);} 
                                            }
                                            if(isset($datas[3])){
                                                foreach($datas[3] as $prices){ $var_tax_price+= (str_replace('GBP','',$prices['Taxes'])*$searched->infant);} 
                                            }
                                            echo number_format($var_tax_price,2);
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <td>Total Fare </td>
                                            <td><i class="las la-pound-sign"></i> <?php 
                                            $var_tot_price=0;
                                            foreach($datas[1] as $prices){ $var_tot_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->adults);} 
                                            if(isset($datas[2])){
                                            foreach($datas[2] as $prices){ $var_tot_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->children);} 
                                            }
                                            if(isset($datas[3])){
                                                foreach($datas[3] as $prices){ $var_tot_price+= (str_replace('GBP','',$prices['Total Price'])*$searched->infant);} 
                                            }
                                            echo number_format($var_tot_price,2);
                                            ?></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div id="baggage_rules{{$count}}" class="container tab-pane fade">
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
                                <div id="cancellation_rules{{$count}}" class="container tab-pane fade"><br>
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
                                                    <td id="cancellation{{$count}}"><i class="fas fa-rupee-sign"></i> 3,500</td>
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
                    @endif
               
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-9 flight-section">
                <h3>No flights found</h3>
                <a href="{{route('index')}}" class="btn btn-primary">GO BACK</a>
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

        var from3=$('#from3').val();
        var to3=$('#to3').val();
        var flight2_date=$('#flight2_date').val();

        // var from4=$('#from4').val();
        // var to4=$('#to4').val();
        // var flight3_date=$('#flight3_date').val();

        // var from5=$('#from5').val();
        // var to5=$('#to5').val();
        // var flight4_date=$('#flight4_date').val();

        // var from6=$('#from6').val();
        // var to6=$('#to6').val();
        // var flight5_date=$('#flight5_date').val();
        
        // alert(from3);
        if(from3=='' || to3=='' || flight2_date==''){
            $('#3rdFlight').hide();
        }else{
            $("#3rdFlight").attr("data-show-value", "1");
        }
        // if(from4=='' && to4=='' && flight3_date==''){
        //     $('#4rdFlight').hide();
        // }else{
        //     $("#4rdFlight").attr("data-show-value", "1");
        // }
        // if(from5=='' && to5=='' && flight4_date==''){
        //     $('#5rdFlight').hide();
        // }else{
        //     $("#5rdFlight").attr("data-show-value", "1");
        // }
        // if(from6=='' && to6=='' && flight5_date==''){
        //     $('#6rdFlight').hide();
        // }else{
        //     $("#6rdFlight").attr("data-show-value", "1");
        // }

        $('.flight0_date_datetimepicker_class').on('click',function(){
            $("#flight1_date").val("");
            $("#flight2_date").val("");
            $("#flight3_date").val("");
            $("#flight4_date").val("");
            $("#flight5_date").val("");
            $("#flight1_date_datetimepicker").datetimepicker("destroy");
            jQuery('#flight0_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(),
                todayHighlight: true,
                autoclose: true,
            });
            $("#flight0_date_datetimepicker").datetimepicker("show").on('changeDate', function(){
                $('#flight0_date_datetimepicker').datetimepicker("hide")
            });
        });
        $('.flight1_date_datetimepicker_class').on('click',function(){
            $("#flight2_date").val("");
            $("#flight3_date").val("");
            $("#flight4_date").val("");
            $("#flight5_date").val("");
            $("#flight2_date_datetimepicker").datetimepicker("destroy");
            var dep_val=$('#flight0_date').val();
            // alert(dep_val);
            // flight1_date
            $('#flight1_date').val('');
            $('#flight1_date').val(dep_val);
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            jQuery('#flight1_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(adddate),
                todayHighlight: true,
                autoclose: true,
            });
            $("#flight1_date_datetimepicker").datetimepicker("show").on('changeDate', function(){
                $('#flight1_date_datetimepicker').datetimepicker("hide")
            });
        });
        $('.flight2_date_datetimepicker_class').on('click',function(){
            $("#flight3_date").val("");
            $("#flight4_date").val("");
            $("#flight5_date").val("");
            $("#flight3_date_datetimepicker").datetimepicker("destroy");
            var dep_val=$('#flight1_date').val();
            // alert(dep_val);
            $('#flight2_date').val('');
            $('#flight2_date').val(dep_val);
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            jQuery('#flight2_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(adddate),
                todayHighlight: true,
                autoclose: true,
            });
            $("#flight2_date_datetimepicker").datetimepicker("show").on('changeDate', function(){
                $('#flight2_date_datetimepicker').datetimepicker("hide")
            });
        });
        $('.flight3_date_datetimepicker_class').on('click',function(){
            $("#flight4_date").val("");
            $("#flight5_date").val("");
            $("#flight4_date_datetimepicker").datetimepicker("destroy");
            var dep_val=$('#flight2_date').val();
            // alert(dep_val);
            $('#flight3_date').val('');
            $('#flight3_date').val(dep_val);
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            jQuery('#flight3_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(adddate),
                todayHighlight: true,
                autoclose: true,
            });
            $("#flight3_date_datetimepicker").datetimepicker("show").on('changeDate', function(){
                $('#flight3_date_datetimepicker').datetimepicker("hide")
            });
        });
        $('.flight4_date_datetimepicker_class').on('click',function(){
            $("#flight5_date").val("");
            $("#flight5_date_datetimepicker").datetimepicker("destroy");
            var dep_val=$('#flight3_date').val();
            // alert(dep_val);
            $('#flight4_date').val('');
            $('#flight4_date').val(dep_val);
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            jQuery('#flight4_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(adddate),
                todayHighlight: true,
                autoclose: true,
            });
            $("#flight4_date_datetimepicker").datetimepicker("show").on('changeDate', function(){
                $('#flight4_date_datetimepicker').datetimepicker("hide")
            });
        });
        $('.flight5_date_datetimepicker_class').on('click',function(){
            // $("#flight5_date").val("");
            $("#flight5_date_datetimepicker").datetimepicker("destroy");
            var dep_val=$('#flight4_date').val();
            // alert(dep_val);
            $('#flight5_date').val('');
            $('#flight5_date').val(dep_val);
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            jQuery('#flight5_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(adddate),
                todayHighlight: true,
                autoclose: true,
            });
            $("#flight5_date_datetimepicker").datetimepicker("show").on('changeDate', function(){
                $('#flight5_date_datetimepicker').datetimepicker("hide")
            });
        });

        //  click on add anathor flight
        $('#addFlight').click(function(){
            // alert("hii");
            // var attr_4rdFlight=$("#4rdFlight").attr("data-show-value");
            // var attr_5rdFlight=$("#5rdFlight").attr("data-show-value");
            // var attr_6rdFlight=$("#6rdFlight").attr("data-show-value");
            // alert(attr_4rdFlight)
            // if(attr_4rdFlight==0)
            $('#3rdFlight').show();
            $("#3rdFlight").attr("data-show-value", "1");
            // to3
            var to3_val=$('#to2').val();
            if(to3_val!=''){
                // from4
                $('#from3').val('');
                $('#from3').val(to3_val);
            }
                // $('#4rdFlight').show();
                // $("#4rdFlight").attr("data-show-value", "1");
                // // to3
                // var to3_val=$('#to3').val();
                // if(to3_val!=''){
                //     // from4
                //     $('#from4').val('');
                //     $('#from4').val(to3_val);
                // }
            // }
            // if(attr_4rdFlight==1){
            //     $('#5rdFlight').show();
            //     $("#5rdFlight").attr("data-show-value", "1");
            //     // crossIcon_flight3
            //     $('#crossIcon_flight3').hide();
            //     var to4_val=$('#to4').val();
            //     if(to4_val!=''){
            //         // from4
            //         $('#from5').val('');
            //         $('#from5').val(to4_val);
            //     }
            // }
            // if(attr_5rdFlight==1){
            //     $('#6rdFlight').show();
            //     $("#6rdFlight").attr("data-show-value", "1");
            //     $('#crossIcon_flight4').hide();
            //     var to5_val=$('#to5').val();
            //     if(to5_val!=''){
            //         // from4
            //         $('#from6').val('');
            //         $('#from6').val(to5_val);
            //     }
            // }
            // data-show-value
        });

        // $('#crossIcon_flight5').click(function(){
        //     // alert('hii');
        //     $('#6rdFlight').hide();
        //     $("#6rdFlight").attr("data-show-value", "0");
        //     $('#from6').val('');
        //     $('#to6').val('');
        //     $('#flight5_date').val('');
        //     $('#crossIcon_flight4').show();
        // });
        // $('#crossIcon_flight4').click(function(){
        //     // alert('hii');
        //     $('#5rdFlight').hide();
        //     $("#5rdFlight").attr("data-show-value", "0");
        //     $('#from5').val('');
        //     $('#to5').val('');
        //     $('#flight4_date').val('');
        //     $('#crossIcon_flight3').show();
        // });
        $('#crossIcon_flight3').click(function(){
            // alert('hii');
            $('#3rdFlight').hide();
            $("#3rdFlight").attr("data-show-value", "0");
            $('#from3').val('');
            $('#to3').val('');
            $('#flight2_date').val('');
        });

        $("#to1").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            source: engine.ttAdapter(),
            name: 'airportList',
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
        }).on('typeahead:selected', function(e){
            var to1_val=$('#to1').val();
            $("#from2").typeahead('val', '')
            $("#from2").typeahead('val',to1_val);
        });
        
        $('#from2').on('click',function(){
            // alert("hii");
            var to1_val=$('#to1').val();
            var from2_val=$('#from2').val();
            if(from2_val==''){
            $("#from2").typeahead('val', '')
            // $("#from2").focus().typeahead('val',to1_val).focus();
            $("#from2").typeahead('val',to1_val);
            }
        });

        $("#to2").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            source: engine.ttAdapter(),
            name: 'airportList',
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
        }).on('typeahead:selected', function(e){
            var val_to2=$('#to2').val();
            var from3_val=$('#from3').val();
            if(from3_val==''){
                $('#from3').val();
                $('#from3').val(val_to2);
            }
        });
        
        $('#from3').on('click',function(){
            // alert("hii");
            var to1_val=$('#to2').val();
            $("#from3").typeahead('val', '')
            $("#from3").focus().typeahead('val',to1_val).focus();
            
        });

        $("#to3").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            source: engine.ttAdapter(),
            name: 'airportList',
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
        }).on('typeahead:selected', function(e){
            var attr_4rdFlight=$("#4rdFlight").attr("data-show-value");
            // alert(attr_4rdFlight)
            if(attr_4rdFlight==1){
                var val_to2=$('#to3').val();
                var from4_val=$('#from4').val();
                if(from4_val==''){
                    $('#from4').val();
                    $('#from4').val(val_to2);
                }
            }
        });

        $('#from4').on('click',function(){
            // alert("hii");
            var to1_val=$('#to3').val();
            $("#from4").typeahead('val', '')
            $("#from4").focus().typeahead('val',to1_val).focus();
            
        });

        $("#to4").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            source: engine.ttAdapter(),
            name: 'airportList',
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
        }).on('typeahead:selected', function(e){
            var attr_4rdFlight=$("#5rdFlight").attr("data-show-value");
            // alert(attr_4rdFlight)
            if(attr_4rdFlight==1){
                var val_to2=$('#to4').val();
                var from4_val=$('#from5').val();
                if(from4_val==''){
                    $('#from5').val();
                    $('#from5').val(val_to2);
                }
            }
        });

        $('#from5').on('click',function(){
            // alert("hii");
            var to1_val=$('#to4').val();
            $("#from5").typeahead('val', '')
            $("#from5").focus().typeahead('val',to1_val).focus();
            
        });

        $("#to5").typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            source: engine.ttAdapter(),
            name: 'airportList',
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
        }).on('typeahead:selected', function(e){
            var attr_4rdFlight=$("#6rdFlight").attr("data-show-value");
            // alert(attr_4rdFlight)
            if(attr_4rdFlight==1){
                var val_to2=$('#to5').val();
                var from4_val=$('#from6').val();
                if(from4_val==''){
                    $('#from6').val();
                    $('#from6').val(val_to2);
                }
            }
        });

        $('#from6').on('click',function(){
            // alert("hii");
            var to1_val=$('#to5').val();
            $("#from6").typeahead('val', '')
            $("#from6").focus().typeahead('val',to1_val).focus();
            
        });





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
        // returning_date
        // $(".returning_date_datetimepickerclass").on('click', function(event){
        //     alert("hii");
            
        // });

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
            }else{
                $('#loading').show();
            }
            // alert(addFrom);
            // path='<?php echo route('flights');?>';
            // var url=("{{route('flights')}}")
            // window.location.href(path);
            // window.location.assign(url);
        })


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

    $(document).on('change', '#onwwayRange', function() {
        // alert($(this).val());
        var var_val=$(this).val();
        $('#loading_small').attr('data-loading-small-val','1');
        // var loading_small_val=$("#loading_small").attr("data-loading-small-val")
        // showloders(var_val);
        // $('#loading_small').attr('data-loading-small-val','1');
        // var loading_small_val=$("#loading_small").attr("data-loading-small-val")

        var var_val=$(this).val();
        var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;" />';
        // alert(loading)
        $('#loading_small').append(loading);
        $('#loading_small').show();
        var min_val=$('#onwwayRange_minprice').val();
        var mix_val=$('#onwwayRange_maxprice').val();
        var cal_min_val=min_val/100;
        // alert(cal_min_val)
        // alert(this.value);
        var range_val=var_val/100;
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
        for (let index1 = parseInt(min_val); index1 <= parseInt(var_val); index1++) {
            // const element = array[index];
            $(".priceRange"+index1).attr("data-GlobalDiv", "1")
            $('.priceRange'+index1).show();
            
        }
        // setTimeout(loderHide, 3000);
        // setInterval(loderHide, 900);
        setTimeout(loderHide, 900);
    });
    function loderHide(){
        $('#loading_small').hide();
        $('#loading_small').empty();
    }
    
    // baggage and canclelation rules details
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
</script>
@endsection