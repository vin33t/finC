@extends('common.master')
@section('content')

<div class="middle">
    <div class="search-results">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">Hotel In</small>
                    <h6 class="font-weight-600 mb-0"><?php 
                    // use DB;
                    $city_name =  str_replace(')','',explode('(',$searched->city_name)[0]);
                    $country_code =  str_replace(')','',explode('(',$searched->city_name)[1]);
                    $countey_name=DB::table('hotel_countries')->where('country_code',$country_code)->value('country_name');
                    echo $city_name.", ".$countey_name;
                    ?></h6>
                    <!-- searched -->
                    <!-- <h6 class="font-weight-600 mb-0">Mumbai, India</h6> -->
                </div>
                <div class="col-md col-6 my-2 my-md-0">
                    <small class="text-muted d-block mb-1">Check In</small>
                    <h6 class="font-weight-600 mb-0">{{ date("d/m/Y", strtotime($searched->check_in))}}</h6>
                </div>
                <div class="col-md col-6 my-2 my-md-0">
                    <small class="text-muted d-block mb-1">Check Out</small>
                    <h6 class="font-weight-600 mb-0">{{ date("d/m/Y", strtotime($searched->check_out))}}</h6>
                </div>
                <div class="col-md col-6">
                    <small class="text-muted d-block mb-1">Room and Guests</small>
                    <h6 class="font-weight-600 mb-0">{{$searched->hotel_room}} Room, <?php echo $searched->room1_hotel_adults." Adult"; if($searched->room1_hotel_child>0){echo ", ".$searched->room1_hotel_child." Yrs Child 1";} if($searched->room1_hotel_infant>0){echo ", ".$searched->room1_hotel_infant." Yrs Child 2";} ?></h6>
                </div>
                <div class="col-md mt-md-0 col-6">
                    <a href="#" class="btn btn-yellow btn-sm" data-toggle="collapse" data-target="#search-container">Modify Search</a>
                </div>
            </div>
        </div>
    </div>
    <section id="search-container" class="bg-white collapse">
        <div class="container-fluid">
            <div class="cld__book__form search__modify pt-4">
            <form method="post" class="" id="hotelForm" action="{{route('hotels')}}">
                @csrf
                <input type="hidden" name="slider_order" id="slider_order" value="{{isset($searched->slider_order)?$searched->slider_order:''}}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Destination</label>
                            <input type="text" name="city_name" id="city_name" value="{{$searched->city_name}}" required placeholder="New Delhi" class="form-control search_hotel">
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label>Check In</label>
                            <div id="check_in_datetimepicker" class="input-group check_in_datetimepickerclass">
                                <input type="text" name="check_in" required id="check_in" value="{{$searched->check_in}}" placeholder="dd/mm/yyyy" class="form-control border-right-0 check_in_datetimepickerclass" data-format="dd-MM-yyyy">
                                <div class="input-group-append add-on check_in_datetimepickerclass">
                                  <span class="input-group-text bg-white pl-0 check_in_datetimepickerclass"><i class="lar la-calendar-alt check_in_datetimepickerclass"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <label>Check Out</label>
                            <div id="check_out_datetimepicker" class="input-group check_out_datetimepickerclass">
                                <input type="text" name="check_out" required id="check_out" value="{{$searched->check_out}}" placeholder="dd/mm/yyyy" class="form-control border-right-0 check_out_datetimepickerclass" data-format="dd-MM-yyyy">
                                <div class="input-group-append add-on check_out_datetimepickerclass">
                                  <span class="input-group-text bg-white pl-0 check_out_datetimepickerclass"><i class="lar la-calendar-alt check_out_datetimepickerclass"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Room & Guests</label>
                            <input type="text" name="hotel_travel_details" id="hotel_travel_details" placeholder="{{$searched->hotel_room}} Room, <?php echo $searched->room1_hotel_adults." Adult"; if($searched->room1_hotel_child>0){echo ", ".$searched->room1_hotel_child." Yrs Child 1";} if($searched->room1_hotel_infant>0){echo ", ".$searched->room1_hotel_infant." Yrs Child 2";} ?>" class="form-control" onclick="hotel_traveller_selection();">
                        
                            <div id="hotel_traveller_selection" style="display:none;">
                                <div class="row m-0">
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Room</label>
                                            <select name="hotel_room" id="hotel_room" class="custom-select">
                                                <option value="1" <?php if($searched->hotel_room==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->hotel_room==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->hotel_room==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->hotel_room==4){echo "selected";}?>>4</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Adults <small>(18+ yrs)</small></label>
                                            <select name="room1_hotel_adults" id="room1_hotel_adults" class="custom-select">
                                                <option value="1" <?php if($searched->room1_hotel_adults==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->room1_hotel_adults==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->room1_hotel_adults==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->room1_hotel_adults==4){echo "selected";}?>>4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Child Age -1<small></small></label>
                                            <select name="room1_hotel_child" id="room1_hotel_child" class="custom-select">
                                                <option value="0">0</option>
                                                <option value="1" <?php if($searched->room1_hotel_child==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->room1_hotel_child==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->room1_hotel_child==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->room1_hotel_child==4){echo "selected";}?>>4</option>
                                                <option value="5" <?php if($searched->room1_hotel_child==5){echo "selected";}?>>5</option>
                                                <option value="6" <?php if($searched->room1_hotel_child==6){echo "selected";}?>>6</option>
                                                <option value="7" <?php if($searched->room1_hotel_child==7){echo "selected";}?>>7</option>
                                                <option value="8" <?php if($searched->room1_hotel_child==8){echo "selected";}?>>8</option>
                                                <option value="9" <?php if($searched->room1_hotel_child==9){echo "selected";}?>>9</option>
                                                <option value="10" <?php if($searched->room1_hotel_child==10){echo "selected";}?>>10</option>
                                                <option value="11" <?php if($searched->room1_hotel_child==11){echo "selected";}?>>11</option>
                                                <option value="12" <?php if($searched->room1_hotel_child==12){echo "selected";}?>>12</option>
                                                <option value="13" <?php if($searched->room1_hotel_child==13){echo "selected";}?>>13</option>
                                                <option value="14" <?php if($searched->room1_hotel_child==14){echo "selected";}?>>14</option>
                                                <option value="15" <?php if($searched->room1_hotel_child==15){echo "selected";}?>>15</option>
                                                <option value="16" <?php if($searched->room1_hotel_child==16){echo "selected";}?>>16</option>
                                                <option value="16" <?php if($searched->room1_hotel_child==17){echo "selected";}?>>17</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 px-2">
                                        <div class="form-group">
                                            <label>Child Age -2 <small></small></label>
                                            <select name="room1_hotel_infant" id="room1_hotel_infant" class="custom-select">
                                                <option value="0">0</option>
                                                <option value="1" <?php if($searched->room1_hotel_infant==1){echo "selected";}?>>1</option>
                                                <option value="2" <?php if($searched->room1_hotel_infant==2){echo "selected";}?>>2</option>
                                                <option value="3" <?php if($searched->room1_hotel_infant==3){echo "selected";}?>>3</option>
                                                <option value="4" <?php if($searched->room1_hotel_infant==4){echo "selected";}?>>4</option>
                                                <option value="5" <?php if($searched->room1_hotel_infant==5){echo "selected";}?>>5</option>
                                                <option value="6" <?php if($searched->room1_hotel_infant==6){echo "selected";}?>>6</option>
                                                <option value="7" <?php if($searched->room1_hotel_infant==7){echo "selected";}?>>7</option>
                                                <option value="8" <?php if($searched->room1_hotel_infant==8){echo "selected";}?>>8</option>
                                                <option value="9" <?php if($searched->room1_hotel_infant==9){echo "selected";}?>>9</option>
                                                <option value="10" <?php if($searched->room1_hotel_infant==10){echo "selected";}?>>10</option>
                                                <option value="11" <?php if($searched->room1_hotel_infant==11){echo "selected";}?>>11</option>
                                                <option value="12" <?php if($searched->room1_hotel_infant==12){echo "selected";}?>>12</option>
                                                <option value="13" <?php if($searched->room1_hotel_infant==13){echo "selected";}?>>13</option>
                                                <option value="14" <?php if($searched->room1_hotel_infant==14){echo "selected";}?>>14</option>
                                                <option value="15" <?php if($searched->room1_hotel_infant==15){echo "selected";}?>>15</option>
                                                <option value="16" <?php if($searched->room1_hotel_infant==16){echo "selected";}?>>16</option>
                                                <option value="16" <?php if($searched->room1_hotel_infant==17){echo "selected";}?>>17</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <hr> -->
                                    <div class="col-12 px-2" id="room2HeadingDiv">
                                        <div class="form-group">
                                            Room 2 Details
                                        </div>
                                    </div>
                                    <div class="col-6 px-2" id="room2AdultDiv" data-room2-div="0">
                                            <div class="form-group">
                                                <label>Adults <small>(18+ yrs)</small></label>
                                                <select name="room2_hotel_adults" id="room2_hotel_adults" class="custom-select">
                                                    <option value="0">Adults</option>
                                                    <option value="1" <?php if($searched->room2_hotel_adults==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room2_hotel_adults==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room2_hotel_adults==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room2_hotel_adults==4){echo "selected";}?>>4</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-6 px-2" id="room2ChildDiv">
                                            <div class="form-group">
                                                <label>Child Age -1<small></small></label>
                                                <select name="room2_hotel_child" id="room2_hotel_child" class="custom-select">
                                                    <option value="0">0</option>
                                                    <option value="1" <?php if($searched->room2_hotel_child==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room2_hotel_child==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room2_hotel_child==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room2_hotel_child==4){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($searched->room2_hotel_child==5){echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($searched->room2_hotel_child==6){echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($searched->room2_hotel_child==7){echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($searched->room2_hotel_child==8){echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($searched->room2_hotel_child==9){echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($searched->room2_hotel_child==10){echo "selected";}?>>10</option>
                                                    <option value="11" <?php if($searched->room2_hotel_child==11){echo "selected";}?>>11</option>
                                                    <option value="12" <?php if($searched->room2_hotel_child==12){echo "selected";}?>>12</option>
                                                    <option value="13" <?php if($searched->room2_hotel_child==13){echo "selected";}?>>13</option>
                                                    <option value="14" <?php if($searched->room2_hotel_child==14){echo "selected";}?>>14</option>
                                                    <option value="15" <?php if($searched->room2_hotel_child==15){echo "selected";}?>>15</option>
                                                    <option value="16" <?php if($searched->room2_hotel_child==16){echo "selected";}?>>16</option>
                                                    <option value="16" <?php if($searched->room2_hotel_child==17){echo "selected";}?>>17</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-6 px-2" id="room2InfantDiv">
                                            <div class="form-group">
                                                <label>Child Age -2 <small></small></label>
                                                <select name="room2_hotel_infant" id="room2_hotel_infant" class="custom-select">
                                                    <option value="0">0</option>
                                                    <option value="1" <?php if($searched->room2_hotel_infant==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room2_hotel_infant==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room2_hotel_infant==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room2_hotel_infant==4){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($searched->room2_hotel_infant==5){echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($searched->room2_hotel_infant==6){echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($searched->room2_hotel_infant==7){echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($searched->room2_hotel_infant==8){echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($searched->room2_hotel_infant==9){echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($searched->room2_hotel_infant==10){echo "selected";}?>>10</option>
                                                    <option value="11" <?php if($searched->room2_hotel_infant==11){echo "selected";}?>>11</option>
                                                    <option value="12" <?php if($searched->room2_hotel_infant==12){echo "selected";}?>>12</option>
                                                    <option value="13" <?php if($searched->room2_hotel_infant==13){echo "selected";}?>>13</option>
                                                    <option value="14" <?php if($searched->room2_hotel_infant==14){echo "selected";}?>>14</option>
                                                    <option value="15" <?php if($searched->room2_hotel_infant==15){echo "selected";}?>>15</option>
                                                    <option value="16" <?php if($searched->room2_hotel_infant==16){echo "selected";}?>>16</option>
                                                    <option value="16" <?php if($searched->room2_hotel_infant==17){echo "selected";}?>>17</option>
                                                </select>
                                            </div>
                                    </div>
                                    <!-- <br> -->
                                    <div class="col-12 px-2" id="room3HeadingDiv">
                                        <div class="form-group">
                                            Room 3 Details
                                        </div>
                                    </div>
                                    <div class="col-6 px-2" id="room3AdultDiv" data-room3-div="0">
                                            <div class="form-group">
                                                <label>Adults <small>(18+ yrs)</small></label>
                                                <select name="room3_hotel_adults" id="room3_hotel_adults" class="custom-select">
                                                    <option value="0">Adults</option>
                                                    <option value="1" <?php if($searched->room3_hotel_adults==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room3_hotel_adults==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room3_hotel_adults==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room3_hotel_adults==4){echo "selected";}?>>4</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-6 px-2" id="room3ChildDiv">
                                            <div class="form-group">
                                                <label>Child Age -1<small></small></label>
                                                <select name="room3_hotel_child" id="room3_hotel_child" class="custom-select">
                                                    <option value="0">0</option>
                                                    <option value="1" <?php if($searched->room3_hotel_child==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room3_hotel_child==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room3_hotel_child==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room3_hotel_child==4){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($searched->room3_hotel_child==5){echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($searched->room3_hotel_child==6){echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($searched->room3_hotel_child==7){echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($searched->room3_hotel_child==8){echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($searched->room3_hotel_child==9){echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($searched->room3_hotel_child==10){echo "selected";}?>>10</option>
                                                    <option value="11" <?php if($searched->room3_hotel_child==11){echo "selected";}?>>11</option>
                                                    <option value="12" <?php if($searched->room3_hotel_child==12){echo "selected";}?>>12</option>
                                                    <option value="13" <?php if($searched->room3_hotel_child==13){echo "selected";}?>>13</option>
                                                    <option value="14" <?php if($searched->room3_hotel_child==14){echo "selected";}?>>14</option>
                                                    <option value="15" <?php if($searched->room3_hotel_child==15){echo "selected";}?>>15</option>
                                                    <option value="16" <?php if($searched->room3_hotel_child==16){echo "selected";}?>>16</option>
                                                    <option value="16" <?php if($searched->room3_hotel_child==17){echo "selected";}?>>17</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-6 px-2" id="room3InfantDiv">
                                            <div class="form-group">
                                                <label>Child Age -2 <small></small></label>
                                                <select name="room3_hotel_infant" id="room3_hotel_infant" class="custom-select">
                                                    <option value="0">0</option>
                                                    <option value="1" <?php if($searched->room3_hotel_infant==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room3_hotel_infant==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room3_hotel_infant==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room3_hotel_infant==4){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($searched->room3_hotel_infant==5){echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($searched->room3_hotel_infant==6){echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($searched->room3_hotel_infant==7){echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($searched->room3_hotel_infant==8){echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($searched->room3_hotel_infant==9){echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($searched->room3_hotel_infant==10){echo "selected";}?>>10</option>
                                                    <option value="11" <?php if($searched->room3_hotel_infant==11){echo "selected";}?>>11</option>
                                                    <option value="12" <?php if($searched->room3_hotel_infant==12){echo "selected";}?>>12</option>
                                                    <option value="13" <?php if($searched->room3_hotel_infant==13){echo "selected";}?>>13</option>
                                                    <option value="14" <?php if($searched->room3_hotel_infant==14){echo "selected";}?>>14</option>
                                                    <option value="15" <?php if($searched->room3_hotel_infant==15){echo "selected";}?>>15</option>
                                                    <option value="16" <?php if($searched->room3_hotel_infant==16){echo "selected";}?>>16</option>
                                                    <option value="16" <?php if($searched->room3_hotel_infant==17){echo "selected";}?>>17</option>
                                                </select>
                                            </div>
                                    </div>
                                    <!-- <br> -->
                                    <div class="col-12 px-2" id="room4HeadingDiv">
                                        <div class="form-group">
                                            Room 4 Details
                                        </div>
                                    </div>
                                    <div class="col-6 px-2" id="room4AdultDiv" data-room4-div="0">
                                            <div class="form-group">
                                                <label>Adults <small>(18+ yrs)</small></label>
                                                <select name="room4_hotel_adults" id="room4_hotel_adults" class="custom-select">
                                                    <option value="0">Adults</option>
                                                    <option value="1" <?php if($searched->room4_hotel_adults==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room4_hotel_adults==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room4_hotel_adults==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room4_hotel_adults==4){echo "selected";}?>>4</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-6 px-2" id="room4ChildDiv">
                                            <div class="form-group">
                                                <label>Child Age -1<small></small></label>
                                                <select name="room4_hotel_child" id="room4_hotel_child" class="custom-select">
                                                    <option value="0">0</option>
                                                    <option value="1" <?php if($searched->room4_hotel_child==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room4_hotel_child==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room4_hotel_child==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room4_hotel_child==4){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($searched->room4_hotel_child==5){echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($searched->room4_hotel_child==6){echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($searched->room4_hotel_child==7){echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($searched->room4_hotel_child==8){echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($searched->room4_hotel_child==9){echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($searched->room4_hotel_child==10){echo "selected";}?>>10</option>
                                                    <option value="11" <?php if($searched->room4_hotel_child==11){echo "selected";}?>>11</option>
                                                    <option value="12" <?php if($searched->room4_hotel_child==12){echo "selected";}?>>12</option>
                                                    <option value="13" <?php if($searched->room4_hotel_child==13){echo "selected";}?>>13</option>
                                                    <option value="14" <?php if($searched->room4_hotel_child==14){echo "selected";}?>>14</option>
                                                    <option value="15" <?php if($searched->room4_hotel_child==15){echo "selected";}?>>15</option>
                                                    <option value="16" <?php if($searched->room4_hotel_child==16){echo "selected";}?>>16</option>
                                                    <option value="16" <?php if($searched->room4_hotel_child==17){echo "selected";}?>>17</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-6 px-2" id="room4InfantDiv">
                                            <div class="form-group">
                                                <label>Child Age -2 <small></small></label>
                                                <select name="room4_hotel_infant" id="room4_hotel_infant" class="custom-select">
                                                    <option value="0">0</option>
                                                    <option value="1" <?php if($searched->room4_hotel_infant==1){echo "selected";}?>>1</option>
                                                    <option value="2" <?php if($searched->room4_hotel_infant==2){echo "selected";}?>>2</option>
                                                    <option value="3" <?php if($searched->room4_hotel_infant==3){echo "selected";}?>>3</option>
                                                    <option value="4" <?php if($searched->room4_hotel_infant==4){echo "selected";}?>>4</option>
                                                    <option value="5" <?php if($searched->room4_hotel_infant==5){echo "selected";}?>>5</option>
                                                    <option value="6" <?php if($searched->room4_hotel_infant==6){echo "selected";}?>>6</option>
                                                    <option value="7" <?php if($searched->room4_hotel_infant==7){echo "selected";}?>>7</option>
                                                    <option value="8" <?php if($searched->room4_hotel_infant==8){echo "selected";}?>>8</option>
                                                    <option value="9" <?php if($searched->room4_hotel_infant==9){echo "selected";}?>>9</option>
                                                    <option value="10" <?php if($searched->room4_hotel_infant==10){echo "selected";}?>>10</option>
                                                    <option value="11" <?php if($searched->room4_hotel_infant==11){echo "selected";}?>>11</option>
                                                    <option value="12" <?php if($searched->room4_hotel_infant==12){echo "selected";}?>>12</option>
                                                    <option value="13" <?php if($searched->room4_hotel_infant==13){echo "selected";}?>>13</option>
                                                    <option value="14" <?php if($searched->room4_hotel_infant==14){echo "selected";}?>>14</option>
                                                    <option value="15" <?php if($searched->room4_hotel_infant==15){echo "selected";}?>>15</option>
                                                    <option value="16" <?php if($searched->room4_hotel_infant==16){echo "selected";}?>>16</option>
                                                    <option value="16" <?php if($searched->room4_hotel_infant==17){echo "selected";}?>>17</option>
                                                </select>
                                            </div>
                                    </div>
                                    <!-- <br> -->

                                    <div class="col-12 px-2">
                                        <div class="form-group">
                                            <input type="button" name="" id="hotel_buttonApply" class="btn btn-primary" onclick="hotel_traveller_selection();" value="Apply">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="hotel_submit" name="hotel_submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>


    <section class="search-packages mt-4">
        <div class="container-fluid">
            <div class="row">
                @if(count($hotels) > 0)

                <div class="col-lg-3 filters_wrapper">
                    <div class="card">
                        <h4 class="font-weight-600 m-0">Filter Result <span class="d-inline-block d-lg-none  filter-open float-right"><i class="las la-times"></i></span></h4>
                        <div class="filter-set">
                            <h6 class="font-weight-600">Hotel Name </h6>
                            <select id="hotelNameFilter" class="form-control">
                                <option value="">Recommended</option>
                                @foreach($hotels[0] as $hotel)
                                @for ($i=0; $i < count($hotel); $i++)
                                <option value="<?php echo str_replace("'","",str_replace(',','',str_replace(' ','',$hotel[$i]['HotelName'])));?>">{{$hotel[$i]['HotelName']}}</option>
                                @endfor
                                @endforeach
                            <!-- <input type="text" class="form-control" placeholder="Search by hotel name" name=""/> -->
                            </select>
                        </div>
                        <div class="filter-set">
                            <h6 class="font-weight-600">Hotel Rating </h6>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Rating5" name="Rating" value="Rating5" onclick="filter()">
                                <label class="custom-control-label" for="Rating5"><img src="{{ asset('public/images/5-star.png')}}" alt="5 star"/></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Rating4" name="Rating" value="Rating4" onclick="filter()">
                                <label class="custom-control-label" for="Rating4"><img src="{{ asset('public/images/4-star.png')}}" alt="5 star"/></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Rating3" name="Rating" value="Rating3" onclick="filter()">
                                <label class="custom-control-label" for="Rating3"><img src="{{ asset('public/images/3-star.png')}}" alt="5 star"/></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Rating2" name="Rating" value="Rating2" onclick="filter()">
                                <label class="custom-control-label" for="Rating2"><img src="{{ asset('public/images/2-star.png')}}" alt="5 star"/></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="Rating1" name="Rating" value="Rating1" onclick="filter()">
                                <label class="custom-control-label" for="Rating1"><img src="{{ asset('public/images/1-star.png')}}" alt="5 star"/></label>
                            </div>
                        </div>
                        <div class="filter-set">
                            <h6 class="font-weight-600">Price Range</h6>
                            <!-- <label for="customRange"><i class="fas fa-rupee-sign"></i> 26,000/-</label>
                            <input type="range" class="custom-range" id="customRange" name="points1"> -->
                            <label for="onwwayRange" id="amount"><i class="las la-pound-sign"></i>
                            <?php  
                                // echo $pricearr[0];
                                // echo $pricearr[count($pricearr)-1];
                                echo number_format($pricearr[0],2,'.','');
                                echo ' - <i class="las la-pound-sign"></i>';
                                if(isset($searched->slider_order)){ 
                                    echo number_format(($searched->slider_order/100),2,'.','') ;
                                }else{ 
                                    echo number_format($pricearr[count($pricearr)-1],2,'.','');
                                }
                            ?></label>
                            <input type="range" class="custom-range" id="onwwayRange" name="onwwayRange" 
                            min="<?php 
                                // echo number_format($pricearr[0],2,'.','');
                                echo ($pricearr[0] * 100);
                            ?>" 
                            max="<?php 
                                // echo number_format($pricearr[count($pricearr)-1],2,'.','');  
                                                            
                                echo ($pricearr[count($pricearr)-1] * 100);      
                            ?>" 
                            value="<?php 
                            // echo number_format($pricearr[count($pricearr)-1],2,'.','');
                                if(isset($searched->slider_order)){
                                    echo $searched->slider_order;
                                }else{  
                                    echo ($pricearr[count($pricearr)-1] * 100);
                                }
                            ?>">
                            <input type="hidden" class="custom-range" id="onwwayRange_minprice" name="onwwayRange_minprice" value="<?php 
                                echo ($pricearr[0] * 100);
                            ?>">
                            <input type="hidden" class="custom-range" id="onwwayRange_maxprice" name="onwwayRange_maxprice" value="<?php 
                                if(isset($searched->slider_order)){
                                    echo $searched->slider_order;
                                }else{
                                    echo ($pricearr[count($pricearr)-1] * 100); 
                                }                               
                            ?>">
                            
                        </div>
                        <!-- <div class="filter-set">
                            <h6 class="font-weight-600">Hotel types </h6>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Hotel</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Homestay</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Guest House</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Resort</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Vila</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">Hostel</label>
                            </div>
                        </div> -->
                        <div class="filter-set">
                            <h6 class="font-weight-600">Facilities </h6>
                            @foreach($allfacilities as $allfacility)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input Facility" id="Facility<?php echo str_replace("'",'',str_replace(')','',str_replace('(','',str_replace(' ','',str_replace('/','',$allfacility))))); ?>" name="Facility" value="Facility<?php echo str_replace("'",'',str_replace(')','',str_replace('(','',str_replace(' ','',str_replace('/','',$allfacility))))); ?>" onclick="filter1('<?php echo str_replace("'",'',str_replace(')','',str_replace('(','',str_replace(' ','',str_replace('/','',$allfacility))))); ?>')">
                                <label class="custom-control-label" for="Facility<?php echo str_replace("'",'',str_replace(')','',str_replace('(','',str_replace(' ','',str_replace('/','',$allfacility))))); ?>">{{$allfacility}}</label>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="row row-heading align-items-center d-flex d-lg-none">
                            <div class="col-6">
                                76 hotels found
                            </div>
                            <div class="col-6 text-right">
                                <a href="#" class="btn btn-default filter-open border">Filters <i class="las la-filter"></i></a>
                            </div>
                        </div>
                        <div class="package-devider">
                            <div class="media">
                                <b>Sort by : </b>&nbsp;&nbsp;
                                <select id="sort_by" name="sort_by" class="form-control col-lg-4">
                                    <option value="">Recommended</option>
                                    <option value="Price_Low_to_High">Price Low to High</option>
                                    <option value="Price_High_to_Low">Price High to Low</option>
                                    <option value="Rating_Low_to_High">Rating Low to High</option>
                                    <option value="Rating_High_to_Low">Rating High to Low</option>
                                    <option value="Hotel_Name_A_to_Z">Hotel Name A to Z</option>
                                    <option value="Hotel_Name_Z_to_A">Hotel Name Z to A</option>
                                </select>
                            </div>
                        </div>
                        </br>

                        <div class="MainDiv">
                        <?php $count=1; $pricearray=[]; $datarating=[]; $datahotelname=[]; ?>
                        @foreach($hotels[0] as $hotel)
                        @for ($i=0; $i < count($hotel); $i++)
                        <?php
                            $price=isset($hotel[$i]['Options']['Option'][0]['TotalPrice'])?json_decode($hotel[$i]['Options']['Option'][0]['TotalPrice']):json_decode($hotel[$i]['Options']['Option']['TotalPrice']);
                            array_push($pricearray,$price);
                            $format_tot_price=($price*100);
                            // echo $format_tot_price=$price;
                            // echo "  ";
                            // echo $searched->slider_order;
                            // echo "--";
                            $rating=is_array($hotel[$i]['StarRating'])?'':json_decode($hotel[$i]['StarRating']);
                            array_push($datarating,$rating);

                            $hotelname=substr($hotel[$i]['HotelName'],0,2);
                            array_push($datahotelname,$hotelname);
                        ?>
                        @if(isset($searched->slider_order))
                            @if($searched->slider_order==$format_tot_price)
                            @else
                            @if($format_tot_price >  $searched->slider_order)
                                @continue
                            @endif
                            @endif
                        @endif
                        <!-- {{$hotel[$i]['HotelId']}} -->
                        <div class="package-devider GlobalDiv Rating{{ is_array($hotel[$i]['StarRating'])?'':json_decode($hotel[$i]['StarRating'])}} hotelName_<?php echo str_replace("'","",str_replace(',','',str_replace(' ','',$hotel[$i]['HotelName'])));?> 
                            <?php 
                            if(isset($hotelDetails[$i]['Facilities']['Facility'])){
                            foreach($hotelDetails[$i]['Facilities']['Facility'] as $facility){
                                if(is_array($facility)){
                                    if($facility['FacilityType'] =='Hotel Facilities'){
                                        echo 'Facility'.str_replace("'",'',str_replace(')','',str_replace('(','',str_replace(' ','',str_replace('/','',$facility['FacilityName'])))))." ";
                                    }
                                }else{
                                    $cateory=$hotelDetails[$i]['Facilities']['Facility']['FacilityName'];
                                    echo 'Facility'.str_replace("'",'',str_replace(')','',str_replace('(','',str_replace(' ','',str_replace('/','',$cateory)))))." ";                                   
                                }
                            }
                            }
                            ?>
                            
                            SortPrice{{($i+1)}} SortRating{{($i+1)}} SortName{{($i+1)}}" 
                            data-GlobalDiv="1" data-price-div="{{isset($hotel[$i]['Options']['Option'][0]['TotalPrice'])?json_decode($hotel[$i]['Options']['Option'][0]['TotalPrice']):json_decode($hotel[$i]['Options']['Option']['TotalPrice'])}}"
                            data-rating-div="{{ is_array($hotel[$i]['StarRating'])?'':json_decode($hotel[$i]['StarRating'])}}"
                            data-hotelname-div="{{substr($hotel[$i]['HotelName'],0,2)}}">
                            <div class="media">
                                <div class="hotels-image-media mr-3" style="background:url('{{isset($hotelDetails[$i]['Images']['Image'][0])?$hotelDetails[$i]['Images']['Image'][0]:''}}') no-repeat center center;background-size:cover;"></div>
                                <div class="media-body">
                                    <h2 class="font-weight-600">{{$hotel[$i]['HotelName']}}</h2>
                                    <address class="text-muted mb-0">{{$hotelDetails[$i]['Address']}}</address>
                                    <div class="rating">
                                        @if($hotel[$i]['StarRating']==1)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i> 1.0
                                        @elseif($hotel[$i]['StarRating']==1.5)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i> 1.5
                                        @elseif($hotel[$i]['StarRating']==2)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i> 2.0
                                        @elseif($hotel[$i]['StarRating']==2.5)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i> 2.5
                                        @elseif($hotel[$i]['StarRating']==3)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star"></i>
                                        <i class="las la-star"></i> 3.0
                                        @elseif($hotel[$i]['StarRating']==4)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star"></i> 4.0
                                        @elseif($hotel[$i]['StarRating']==5)
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i>
                                        <i class="las la-star active"></i> 5.0
                                        @endif
                                    </div>
                                    <div class="row d-none d-md-flex">
                                        <div class="col-6">
                                            <span class="text-muted mt-3 d-block">Facilities</span>
                                            <ul class="d-block mt-1">
                                                <?php $count=0?>
                                                @if(isset($hotelDetails[$i]['Facilities']['Facility']))
                                                @foreach($hotelDetails[$i]['Facilities']['Facility'] as $facility)
                                                <!-- {{print_r($facility)}} -->
                                                @if(is_array($facility))
                                                    @if($facility['FacilityType'] =='Hotel Facilities')
                                                        @if($count < 5 )
                                                        <li>{{$facility['FacilityName']}}</li>
                                                        @else
                                                        @break;
                                                        @endif
                                                        <?php $count++; ?>
                                                    @endif
                                                
                                                @endif
                                                @endforeach
                                                @endif
                                                <div id="all-amenities-facility{{$hotel[$i]['HotelId']}}" class="collapse">
                                                    <?php $count1=0?>
                                                    @if(isset($hotelDetails[$i]['Facilities']['Facility']))
                                                    @foreach($hotelDetails[$i]['Facilities']['Facility'] as $facility)
                                                    @if(is_array($facility))
                                                        @if($facility['FacilityType'] =='Hotel Facilities')
                                                            @if($count1 > 5 )
                                                            <li>{{$facility['FacilityName']}}</li>
                                                            @endif
                                                            <?php $count1++; ?>
                                                        @endif
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </div>
                                                <li><a href="javascript:void(0)" data-toggle="collapse" data-target="#all-amenities-facility{{$hotel[$i]['HotelId']}}">Expand/Collapse <i class="las la-angle-down"></i></a></li>

                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted mt-3 d-block">Description</span>
                                            <!-- <p class="small text-dark d-block mt-1"> -->
                                            <div class="small text-dark d-block mt-1" >

                                                @if(isset($hotelDetails[$i]['Description']))
                                                <!-- {{print_r($hotelDetails[$i]['Description'])}} -->
                                                <?php  if($hotelDetails[$i]['Description']!=null){echo htmlspecialchars_decode(substr($hotelDetails[$i]['Description'],0,150),ENT_QUOTES)."-";}?>
                                                <div id="all-amenities-description{{$hotel[$i]['HotelId']}}" class="collapse">
                                                <?php if($hotelDetails[$i]['Description']!=null){ $length=strlen($hotelDetails[$i]['Description']); echo htmlspecialchars_decode(substr($hotelDetails[$i]['Description'],150,$length),ENT_QUOTES); } ?>
                                                </div>
                                                @endif
                                                <!-- onclick="myFunction({{$hotel[$i]['HotelId']}})"  -->
                                                <a href="javascript:void(0)" class="d-block" onclick="MoreDetails({{$hotel[$i]['HotelId']}});">More Details <i class="las la-angle-down"></i></a>
                                                <form id="moreDetails{{$hotel[$i]['HotelId']}}" action="{{route('hoteldetails')}}" method="POST">
                                                    @csrf
                                                    <input type="text" name="hotel_id" value="{{$hotel[$i]['HotelId']}}" hidden>
                                                    <input type="text" name="Options" value="{{json_encode($hotel[$i]['Options']['Option'])}}" hidden>
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
                                                    <button type="submit" hidden class="btn btn-primary" onclick="showLoder();">Book Now</button>
                                                </form>
                                                <!-- <a href="javascript:void(0)" class="d-block" data-toggle="collapse" data-target="#all-amenities-description{{$hotel[$i]['HotelId']}}">More Details <i class="las la-angle-down"></i></a> -->
                                            </div>
                                            
                                            <!-- </p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="border-left col-md-3 mt-3 mt-md-0 text-center text-md-left">
                                    <!-- <del class="text-muted"><i class="las la-pound-sign"></i>32.00</del><br> -->
                                    <!-- {{print_r($hotel[$i]['Options']['Option'])}} -->
                                    <h4 class="mb-0 h3 font-weight-600"><span class="text-danger"><i class="las la-pound-sign"></i>{{isset($hotel[$i]['Options']['Option'][0]['TotalPrice'])?$hotel[$i]['Options']['Option'][0]['TotalPrice']:$hotel[$i]['Options']['Option']['TotalPrice']}}</span></h4>
                                    <!-- <small>Per Room / Per Night</small> -->
                                    <br>
                                    <!-- <a href="hotel-details.php" class="btn btn-primary mt-2">Book Now</a> -->
                                    <form action="{{route('hoteldetails')}}" method="POST">
                                        @csrf
                                        <input type="text" name="hotel_id" value="{{$hotel[$i]['HotelId']}}" hidden>
                                        <input type="text" name="Options" value="{{json_encode($hotel[$i]['Options']['Option'])}}" hidden>
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
                                        <button type="submit" class="btn btn-primary" onclick="showLoder();">Book Now</button>
                                    </form>
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        @endfor
                        @endforeach
                        </div>

                        <!-- <div class="package-devider">
                            <div class="media">
                                <div class=" hotels-image-media mr-3" style="background:url('assets/images/hotel.jpg') no-repeat center center;background-size:cover;"></div>
                                <div class="media-body">
                                    <h2 class="font-weight-600">Hotel Sunview Jain</h2>
                                <address class="text-muted mb-0">Sector 35, Chandigarh</address>
                                <div class="rating">
                                    <i class="las la-star active"></i>
                                    <i class="las la-star active"></i>
                                    <i class="las la-star active"></i>
                                    <i class="las la-star active"></i>
                                    <i class="las la-star"></i> 4.0
                                </div>
                                <div class="row d-none d-md-flex">
                                    <div class="col-6">
                                        <span class="text-muted mt-3 d-block">Facilities</span>
                                        <ul class="d-block mt-1">
                                            <li>24-hour reception</li>
                                            <li>24-hour security</li>
                                            <li>Air conditioning in public areas</li>
                                            <li>Car park</li>
                                            <li><a href="#">More <i class="las la-angle-down"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted mt-3 d-block">Description</span>
                                        <p class="small text-dark d-block mt-1">Strategically situated close to Santacruzs domestic airport and 15 minutes from Sahar International Airport The Orchid.
                                        <a href="#" class="d-block">More <i class="las la-angle-down"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="border-left col-md-3 mt-3 mt-md-0 text-center text-md-left">
                                <del class="text-muted"><i class="las la-pound-sign"></i>32.00</del><br>
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger"><i class="las la-pound-sign"></i>29.64</span></h4>
                                <small>Per Room / Per Night</small><br>
                                <a href="hotel-details.php" class="btn btn-primary mt-2">Book Now</a>
                            </div>
                        </div> -->
                    </div>


                    <!-- <div class="package-devider">
                            <div class="media">
                                <div class=" hotels-image-media mr-3" style="background:url('assets/images/orbit.jpg') no-repeat center center;background-size:cover;"></div>
                                <div class="media-body">
                                    <h2 class="font-weight-600">Ramada by Wyndham Navi Mumbai</h2>
                                <address class="text-muted mb-0">Bldg 156 millennium business parkmidc sector-2,mumbai, </address>
                                <div class="rating">
                                    <i class="las la-star active"></i>
                                    <i class="las la-star active"></i>
                                    <i class="las la-star active"></i>
                                    <i class="las la-star active"></i>
                                    <i class="las la-star"></i> 4.0
                                </div>
                                <div class="row d-none d-md-flex">
                                    <div class="col-6">
                                        <span class="text-muted mt-3 d-block">Facilities</span>
                                        <ul class="d-block mt-1">
                                            <li>24-hour reception</li>
                                            <li>24-hour security</li>
                                            <li>Air conditioning in public areas</li>
                                            <li>Car park</li>
                                            <li><a href="#">More <i class="las la-angle-down"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted mt-3 d-block">Description</span>
                                        <p class="small text-dark d-block mt-1">Strategically situated close to Santacruzs domestic airport and 15 minutes from Sahar International Airport The Orchid.
                                        <a href="#" class="d-block">More <i class="las la-angle-down"></i></a></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-left col-md-3 mt-3 mt-md-0 text-center text-md-left">
                                <del class="text-muted"><i class="las la-pound-sign"></i>25.30</del><br>
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger"><i class="las la-pound-sign"></i>30.73</span></h4>
                                <small>Per Room / Per Night</small><br>
                                <a href="hotel-details.php" class="btn btn-primary mt-2">Book Now</a>
                            </div>
                        </div>
                    </div><hr>
                    <div class="package-devider">
                            <div class="media">
                                <div class=" hotels-image-media mr-3" style="background:url('assets/images/altius.jpg') no-repeat center center;background-size:cover;"></div>
                            <div class="media-body">
                                <h2 class="font-weight-600">The Altius Boutique Hotel (Kings Cross Sports Bar & Lounge)</h2>
                            <address class="text-muted mb-0">Industrial Area Phase II</address>
                            <div class="rating">
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star active"></i>
                                <i class="las la-star"></i> 4.0
                            </div>
                            <div class="row d-none d-md-flex">
                                <div class="col-6">
                                    <span class="text-muted mt-3 d-block">Facilities</span>
                                    <ul class="d-block mt-1">
                                        <li>24-hour reception</li>
                                        <li>24-hour security</li>
                                        <li>Air conditioning in public areas</li>
                                        <li>Car park</li>
                                        <li><a href="#">More <i class="las la-angle-down"></i></a></li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted mt-3 d-block">Description</span>
                                    <p class="small text-dark d-block mt-1">Strategically situated close to Santacruzs domestic airport and 15 minutes from Sahar International Airport The Orchid.
                                    <a href="#" class="d-block">More <i class="las la-angle-down"></i></a></p>
                                </div>
                            </div>
                        </div>
                            
                            <div class="border-left col-md-3 mt-3 mt-md-0 text-center text-md-left">
                                <del class="text-muted"><i class="las la-pound-sign"></i>34.00</del><br>
                                <h4 class="mb-0 h3 font-weight-600"><span class="text-danger"><i class="las la-pound-sign"></i>32.84</span></h4>
                                <small>Per Room / Per Night</small><br>
                                <a href="hotel-details.php" class="btn btn-primary mt-2">Book Now</a>
                            </div>
                        </div>
                    </div> -->
                </div>
                @else
                    <h3>No hotel found!</h3>
                    <a href="{{route('index')}}" class="btn btn-primary">GO BACK</a>
                @endif
            </div>
        </div>
    </section>
</div>



@endsection


@section('script')
<script>
    $('#loading').hide();
    $('#loading_small').hide();
    var hotelRoom=<?php echo $searched->hotel_room; ?>;
    // alert(hotelRoom)
    for (let index = hotelRoom; index < 4; index++) {
        // alert(index);
        var room2HeadingDiv ='room'+(index + 1)+'HeadingDiv';
        // alert(room2HeadingDiv)
        var room2AdultDiv='room'+(index + 1)+'AdultDiv';
        var room2ChildDiv='room'+(index + 1)+'ChildDiv';
        var room2InfantDiv='room'+(index + 1)+'InfantDiv';
        $('#'+room2HeadingDiv).hide();
        $('#'+room2AdultDiv).hide();
        $('#'+room2ChildDiv).hide();
        $('#'+room2InfantDiv).hide();
        
    }
</script>
<script>
    $( document ).ready(function() {
        // alert("hotel");
        // hotel_submit
        var path = "{{ route('searchhotel') }}";
        // searchhotel
        // searchairport
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


        $(".search_hotel").typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                source: engine.ttAdapter(),
                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'hotelList',
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

        $('.check_in_datetimepickerclass').click(function(){
            $('#check_out').val('');
            $("#check_out_datetimepicker").datetimepicker("destroy");
            $('#check_in_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(),
                todayHighlight: true,
                // minDate: new Date(),
                // defaultDate: new Date(),
            });
            $('#check_in_datetimepicker').datetimepicker("show").on('changeDate', function(){
                // $('#departure_date_datetimepicker').hide();
                $('#check_in_datetimepicker').datetimepicker("hide");
            });
            // $('#returnDateDiv').attr('returnDateDiv-data','1'); 
        
        });

        $('.check_out_datetimepickerclass').on('click',function(){
            // alert("return hii")
            // $("#returning_date_datetimepicker").datetimepicker("destroy");
            // returning_date
            var dep_val=$('#check_in').val();
            var dep_val1 = dep_val.split("-").reverse().join("-");

            // alert(dep_val1)
            var someDate = new Date(dep_val1);
            someDate.setDate(someDate.getDate() + 1); //number  of days to add, e.x. 15 days
            var dateFormated = someDate.toISOString().substr(0,10);
            // console.log(dateFormated);
            // alert(dateFormated)
            var dateFormated1 = dateFormated.split("-").reverse().join("-");
            $('#check_out').val('');
            $('#check_out').val(dateFormated1);
            
            var newdate = dateFormated1.split("-").reverse().join("/");
            // alert(newdate);
            var datePeriode= new Date(newdate);
            // var adddate=datePeriode.setDate(datePeriode.getDate() + 1);
            // alert(datePeriode);
            // alert(new Date(adddate))
            // $('#check_out').val('');
            // $('#check_out').val(new Date(adddate));
            // $('#check_out_datetimepicker').datetimepicker('setStartDate', '2020-09-10');
            // alert(adddate);
            // alert(new Date(adddate))
            $('#check_out_datetimepicker').datetimepicker({
                pickTime: false,
                startDate: new Date(datePeriode),
                autoclose: true,
                todayHighlight: true
            });

            // $('#returning_date_datetimepicker').datetimepicker("show");
            $('#check_out_datetimepicker').datetimepicker("show").on('changeDate', function(){
                $('#check_out_datetimepicker').datetimepicker("hide");
            });
        });

        $("#hotel_room").on('change',function(){
            // alert("hii");
            var hotel_room=$('#hotel_room').val();
            var adults=$('#room1_hotel_adults').val();
            var children=$('#room1_hotel_child').val();
            var infant=$('#room1_hotel_infant').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=hotel_room+' Room, '+ adults+' Adults, '+children+' Yrs Child 1, '+infant+' Yrs Child 2';
            }else if(infant>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+infant+' Yrs Child 2';
            }else if(children>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+children+' Yrs Child 1';
            }else{
                var val=hotel_room+' Room, '+adults+' Adults';
            }
            $('#hotel_travel_details').removeAttr('placeholder');
            $('#hotel_travel_details').attr('placeholder',val);


            // div show hide function
            if (hotel_room==1) {
                //    alert(hotel_room) 
                
                // room2_hotel_adults
                // room2_hotel_child
                // room2_hotel_infant
                $('#room2_hotel_adults').val('0');
                $('#room2_hotel_child').val('0');
                $('#room2_hotel_infant').val('0');
                $('#room2AdultDiv').attr('data-room2-div','0');
                $('#room2HeadingDiv').hide();
                $('#room2AdultDiv').hide();
                $('#room2ChildDiv').hide();
                $('#room2InfantDiv').hide();

                $('#room3_hotel_adults').val('0');
                $('#room3_hotel_child').val('0');
                $('#room3_hotel_infant').val('0');
                $('#room3AdultDiv').attr('data-room3-div','0');
                $('#room3HeadingDiv').hide();
                $('#room3AdultDiv').hide();
                $('#room3ChildDiv').hide();
                $('#room3InfantDiv').hide();

                $('#room4_hotel_adults').val('0');
                $('#room4_hotel_child').val('0');
                $('#room4_hotel_infant').val('0');
                $('#room4AdultDiv').attr('data-room4-div','0');
                $('#room4HeadingDiv').hide();
                $('#room4AdultDiv').hide();
                $('#room4ChildDiv').hide();
                $('#room4InfantDiv').hide();
            }
            if (hotel_room==2) {
                //    alert(hotel_room) 
                

                $('#room2_hotel_adults').val('1');
                $('#room2AdultDiv').attr('data-room2-div','1');
                $('#room2HeadingDiv').show();
                $('#room2AdultDiv').show();
                $('#room2ChildDiv').show();
                $('#room2InfantDiv').show();

                $('#room3_hotel_adults').val('0');
                $('#room3_hotel_child').val('0');
                $('#room3_hotel_infant').val('0');
                $('#room3AdultDiv').attr('data-room3-div','0');
                $('#room3HeadingDiv').hide();
                $('#room3AdultDiv').hide();
                $('#room3ChildDiv').hide();
                $('#room3InfantDiv').hide();

                $('#room4_hotel_adults').val('0');
                $('#room4_hotel_child').val('0');
                $('#room4_hotel_infant').val('0');
                $('#room4AdultDiv').attr('data-room4-div','0');
                $('#room4HeadingDiv').hide();
                $('#room4AdultDiv').hide();
                $('#room4ChildDiv').hide();
                $('#room4InfantDiv').hide();
            }
            if (hotel_room==3) {
                //    alert(hotel_room) 
                $('#room2_hotel_adults').val('1');
                $('#room2AdultDiv').attr('data-room2-div','1');
                $('#room2HeadingDiv').show();
                $('#room2AdultDiv').show();
                $('#room2ChildDiv').show();
                $('#room2InfantDiv').show();

                $('#room4_hotel_adults').val('1');
                $('#room3AdultDiv').attr('data-room3-div','1');
                $('#room3HeadingDiv').show();
                $('#room3AdultDiv').show();
                $('#room3ChildDiv').show();
                $('#room3InfantDiv').show();

                $('#room4_hotel_adults').val('0');
                $('#room4_hotel_child').val('0');
                $('#room4_hotel_infant').val('0');
                $('#room4AdultDiv').attr('data-room4-div','0');
                $('#room4HeadingDiv').hide();
                $('#room4AdultDiv').hide();
                $('#room4ChildDiv').hide();
                $('#room4InfantDiv').hide();
            }
            if (hotel_room==4) {
                //    alert(hotel_room) 
                $('#room2_hotel_adults').val('1');
                $('#room2AdultDiv').attr('data-room2-div','1');
                $('#room2HeadingDiv').show();
                $('#room2AdultDiv').show();
                $('#room2ChildDiv').show();
                $('#room2InfantDiv').show();
                
                $('#room3_hotel_adults').val('1');
                $('#room3AdultDiv').attr('data-room3-div','1');
                $('#room3HeadingDiv').show();
                $('#room3AdultDiv').show();
                $('#room3ChildDiv').show();
                $('#room3InfantDiv').show();

                $('#room4_hotel_adults').val('1');
                $('#room4AdultDiv').attr('data-room4-div','1');
                $('#room4HeadingDiv').show();
                $('#room4AdultDiv').show();
                $('#room4ChildDiv').show();
                $('#room4InfantDiv').show();
            }

            
        });

        $("#room1_hotel_adults").change(function(){
            // alert("hii");
            var hotel_room=$('#hotel_room').val();
            var adults=$('#room1_hotel_adults').val();
            var children=$('#room1_hotel_child').val();
            var infant=$('#room1_hotel_infant').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=hotel_room+' Room, '+ adults+' Adults, '+children+' Yrs Child 1, '+infant+' Yrs Child 2';
            }else if(infant>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+infant+' Yrs Child 2';
            }else if(children>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+children+' Yrs Child 1';
            }else{
                var val=hotel_room+' Room, '+adults+' Adults';
            }
            $('#hotel_travel_details').removeAttr('placeholder');
            $('#hotel_travel_details').attr('placeholder',val);
            
        });

        $("#room1_hotel_child").change(function(){
            // alert("hii");
            var hotel_room=$('#hotel_room').val();
            var adults=$('#room1_hotel_adults').val();
            var children=$('#room1_hotel_child').val();
            var infant=$('#room1_hotel_infant').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+children+' Yrs Child 1, '+infant+' Yrs Child 2';
            }else if(infant>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+infant+' Yrs Child 2';
            }else if(children>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+children+' Yrs Child 1';
            }else{
                var val=hotel_room+' Room, '+adults+' Adults';
            }
            $('#hotel_travel_details').removeAttr('placeholder');
            $('#hotel_travel_details').attr('placeholder',val);
            
        });
        $("#room1_hotel_infant").change(function(){
            // alert("hii");
            var hotel_room=$('#hotel_room').val();
            var adults=$('#room1_hotel_adults').val();
            var children=$('#room1_hotel_child').val();
            var infant=$('#room1_hotel_infant').val();
            // alert(adults);
            if(infant>0 && children>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+children+' Yrs Child 1, '+infant+' Yrs Child 2';
            }else if(infant>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+infant+' Yrs Child 2';
            }else if(children>0){
                var val=hotel_room+' Room, '+adults+' Adults, '+children+' Yrs Child 1';
            }else{
                var val=hotel_room+' Room, '+adults+' Adults';
            }
            $('#hotel_travel_details').removeAttr('placeholder');
            $('#hotel_travel_details').attr('placeholder',val);
            
        });
        

        $('#hotel_submit').click(function(){
            // alert("hotel_submit");
            // return false;
            var city_name=$('#city_name').val();
            var check_in=$('#check_in').val();
            var check_out=$('#check_out').val();
            var room2_adult=$('#room2AdultDiv').attr('data-room2-div');
            var room3_adult=$('#room3AdultDiv').attr('data-room3-div');
            var room4_adult=$('#room4AdultDiv').attr('data-room4-div');
            // alert(room2_adult);
            if (room2_adult==1) {
                var room2_hotel_adults=$('#room2_hotel_adults').val();
                // alert(room2_hotel_adults)
                if(room2_hotel_adults==0){
                    alert("Please select at least 1 adult in room 2");
                    return false;
                }
            }
            if (room3_adult==1) {
                var room3_hotel_adults=$('#room3_hotel_adults').val();
                // alert(room2_hotel_adults)
                if(room3_hotel_adults==0){
                    alert("Please select at least 1 adult in room 3");
                    return false;
                }
            }
            if (room4_adult==1) {
                var room4_hotel_adults=$('#room4_hotel_adults').val();
                // alert(room2_hotel_adults)
                if(room4_hotel_adults==0){
                    alert("Please select at least 1 adult in room 4");
                    return false;
                }
            }
            if (check_in==check_out) {
                alert("Check in date and check out date can not be same");
                return false;
            }else if(city_name!='' && check_in!='' && check_out!='' ){
                $('#loading').show();
            }
        });



        $('#hotelNameFilter').on('change',function(){
            // alert("hii");
            var val=$('#hotelNameFilter').val();
            // alert(val);
            if(val!=''){
            $(".GlobalDiv").attr("data-GlobalDiv", "0");
            $(".GlobalDiv").hide();
            $('.hotelName_'+val).show();
            $('.hotelName_'+val).attr("data-GlobalDiv", "1");
            }else{
                $(".GlobalDiv").attr("data-GlobalDiv", "1");
                $(".GlobalDiv").show();  
            }
        });

        // sort_by
        $('#sort_by').on('change',function(){
            var sort_by_val=$('#sort_by').val();
            // alert(sort_by_val);
            if(sort_by_val=='Price_Low_to_High'){
                // alert(sort_by_val);
                var pricearray=[];
                var pricearray=<?php 
                $aaa=[];
                $pricearray=array_unique(isset($pricearray)?$pricearray:[]);
                foreach($pricearray as $val1){
                    array_push($aaa,$val1);
                }
                echo json_encode($aaa);
                ?>;
                pricearray.sort(function(a, b){return b-a});
                pricearray.reverse();
                // alert(pricearray);
                // SortPrice1
                for (let index = 0; index < pricearray.length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                        var dataArrivaltime=$(".SortPrice"+Divindex).attr("data-price-div");
                        if (dataArrivaltime==pricearray[index]) {
                            $(".MainDiv").append($(".SortPrice"+Divindex));
                        }
                    }
                }
            }else if(sort_by_val=='Price_High_to_Low'){
                // alert(sort_by_val);
                var pricearray=[];
                var pricearray=<?php 
                $aaa=[];
                $pricearray=array_unique(isset($pricearray)?$pricearray:[]);
                foreach($pricearray as $val1){
                    array_push($aaa,$val1);
                }
                echo json_encode($aaa);
                ?>;
                pricearray.sort(function(a, b){return b-a});
                // pricearray.reverse();
                // alert(pricearray);
                // SortPrice1
                for (let index = 0; index < pricearray.length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                        var dataArrivaltime=$(".SortPrice"+Divindex).attr("data-price-div");
                        if (dataArrivaltime==pricearray[index]) {
                            $(".MainDiv").append($(".SortPrice"+Divindex));
                        }
                    }
                }
            }else if(sort_by_val=='Rating_Low_to_High'){
                // alert(sort_by_val);
                var datarating=[];
                var datarating=<?php 
                $aaa=[];
                $datarating=array_unique(isset($datarating)?$datarating:[]);
                foreach($datarating as $val1){
                    array_push($aaa,$val1);
                }
                echo json_encode($aaa);
                ?>;
                datarating.sort(function(a, b){return b-a});
                datarating.reverse();
                // alert(datarating);
                // SortPrice1
                for (let index = 0; index < datarating.length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                        var dataArrivaltime=$(".SortRating"+Divindex).attr("data-rating-div");
                        if (dataArrivaltime==datarating[index]) {
                            $(".MainDiv").append($(".SortRating"+Divindex));
                        }
                    }
                }
            }else if(sort_by_val=='Rating_High_to_Low'){
                // alert(sort_by_val);
                var datarating=[];
                var datarating=<?php 
                $aaa=[];
                $datarating=array_unique(isset($datarating)?$datarating:[]);
                foreach($datarating as $val1){
                    array_push($aaa,$val1);
                }
                echo json_encode($aaa);
                ?>;
                datarating.sort(function(a, b){return b-a});
                // datarating.reverse();
                // alert(datarating);
                // SortPrice1
                for (let index = 0; index < datarating.length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                        var dataArrivaltime=$(".SortRating"+Divindex).attr("data-rating-div");
                        if (dataArrivaltime==datarating[index]) {
                            $(".MainDiv").append($(".SortRating"+Divindex));
                        }
                    }
                }
            }else if(sort_by_val=='Hotel_Name_A_to_Z'){
                // alert(sort_by_val);
                var datahotelname=[];
                var datahotelname=<?php 
                $aaa=[];
                $datahotelname=array_unique(isset($datahotelname)?$datahotelname:[]);
                foreach($datahotelname as $val1){
                    array_push($aaa,$val1);
                }
                echo json_encode($aaa);
                ?>;
                datahotelname.sort();
                // datahotelname.sort(function(a, b){return b-a});
                // datahotelname.reverse();
                // alert(datahotelname);
                // SortPrice1
                for (let index = 0; index < datahotelname.length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                        var dataArrivaltime=$(".SortName"+Divindex).attr("data-hotelname-div");
                        if (dataArrivaltime==datahotelname[index]) {
                            $(".MainDiv").append($(".SortName"+Divindex));
                        }
                    }
                }
            }else if(sort_by_val=='Hotel_Name_Z_to_A'){
                // alert(sort_by_val);
                var datahotelname=[];
                var datahotelname=<?php 
                $aaa=[];
                $datahotelname=array_unique(isset($datahotelname)?$datahotelname:[]);
                foreach($datahotelname as $val1){
                    array_push($aaa,$val1);
                }
                echo json_encode($aaa);
                ?>;
                datahotelname.sort();
                // datahotelname.sort(function(a, b){return b-a});
                datahotelname.reverse();
                // alert(datahotelname);
                // SortPrice1
                for (let index = 0; index < datahotelname.length; index++) {
                    for (let Divindex = 1; Divindex <=$('.GlobalDiv').length; Divindex++) {
                        var dataArrivaltime=$(".SortName"+Divindex).attr("data-hotelname-div");
                        if (dataArrivaltime==datahotelname[index]) {
                            $(".MainDiv").append($(".SortName"+Divindex));
                        }
                    }
                }
            }
            
        });


        
    });
    function filter1(val){
        var checked_val=$("input[name='Facility']").val();
        // alert(checked_val);
            // alert(val);
        // $('input[name="Facility"]:checked').each(function() {
        //     // alert('Facility');
        //     // var checked_val=$("input[name='Facility']").val();
        //     // alert(checked_val);

        //     // $(".GlobalDiv").attr("data-GlobalDiv", "0")
        //     // $(".GlobalDiv").hide();
        //     // $("."+checked_val).show(); 
        //     // $("."+checked_val).attr("data-GlobalDiv", "1") ; 
        //     if($(this).prop("checked") == true){
        //         console.log("Checkbox is checked.");
        //     }
        //     else if($(this).prop("checked") == false){
        //         console.log("Checkbox is unchecked.");
        //     }
        // });
        // $('input[name="Facility"]:not(:checked)').each(function() {
        //     alert('not')
        //     // $("."+this.value).attr("data-GlobalDiv", "0")
        //     // $("."+this.value).hide();

                
        // });
        // alert('hii');
        var SearchCount=0;
        var count=0;
     
        $(".GlobalDiv").attr("data-GlobalDiv", "0");
        $(".GlobalDiv").hide();
       
        var arr=[];

        var Facility=0;
        $('input[name="Facility"]:checked').each(function() {
            Facility+=1;
            if(Facility==1){
                $(".Facility"+val).show();
                $(".Facility"+val).attr("data-GlobalDiv", "1");
            }
        });
        // if (Facility==1) {
        //     arr.push("Facility");
        // }
        // alert(arr);
       

        if(Facility==0)
        {
          $(".GlobalDiv").show();
          $(".GlobalDiv").attr("data-GlobalDiv", "1");
        }
    }
    function filter()
    {
        // if ($("."+this.value).attr("data-GlobalDiv")==1) 
        // $(".GlobalDiv").attr("data-GlobalDiv", "0")
        var SearchCount=0;
        var count=0;
     
        $(".GlobalDiv").attr("data-GlobalDiv", "0");
        $(".GlobalDiv").hide();
       
        var arr=[];
        // var Departure=0;
        // $('input[name="Departure"]:checked').each(function() {
        //   Departure=1
        // });
        // if (Departure==1) {
        //     arr.push("Departure");
        // }

        // var Facility=0;
        // $('input[name="Facility"]:checked').each(function() {
        //     Facility=1
        // });
        // if (Facility==1) {
        //     arr.push("Facility");
        // }

        var Rating=0;
        $('input[name="Rating"]:checked').each(function() {
            Rating=1;
        });
        if (Rating==1) {
            arr.push("Rating");
        }
          
        $.each(arr, function( index, d ) {
            SearchCount=1;
            count+=1;
            
            $('input[name="'+d+'"]:checked').each(function() {
                // alert(this.value);
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
            $(".GlobalDiv").attr("data-GlobalDiv", "1");
          }
    }

    // function hotelNameFilter(name){
    //     alert(name);
    // }
        

    // price slider
    var slider = document.getElementById("onwwayRange");
    slider.oninput = function() {
        // output.innerHTML = this.value;
        // alert(this.value)
        var range_val=this.value;
        var min_val=$('#onwwayRange_minprice').val();
        var mix_val=$('#onwwayRange_maxprice').val();
        var cal_min_val=min_val/100;
        // var cal_min_val=min_val;
        var amount='<i class="las la-pound-sign"></i>'+parseFloat(cal_min_val).toFixed(2)+' - <i class="las la-pound-sign"></i>'+parseFloat(range_val/100).toFixed(2);
        $('#amount').empty();
        $('#amount').append(amount);
        // $('#hotelForm').submit();
    }

    $(document).on('change', '#onwwayRange', function() {
        // alert($(this).val());
        var var_val=$(this).val();
        // alert(var_val)
        var loading ='<img id="loading-image-small" src="{{ asset('public/loder-small.gif') }}" alt="Loading..." style=" position: absolute;top: 100px;left: 431px;z-index: 100;" />';
        // alert(loading)
        $('#loading_small').append(loading);
        $('#loading_small').show();
        var url= window.location.href;
        var slider_order='{{isset($searched->slider_order)?$searched->slider_order:''}}';
        if(slider_order==""){
            $('#slider_order').val('');
            $('#slider_order').val(var_val);
            // var newurl=url+'&slider_order='+var_val;
        }else{
            $('#slider_order').val('');
            $('#slider_order').val(var_val);
            // var newurl=url.split('&slider_order='+slider_order)[0];
            // var newurl=newurl+'&slider_order='+var_val;
        }

        
        // window.location.assign(newurl);
        $('#hotelForm').submit();

    });

    function MoreDetails(id){
        // alert(id);
        // moreDetails
        $('#loading').show();
        $('#moreDetails'+id).submit();
    }

</script>
@endsection