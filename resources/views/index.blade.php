@extends('common.master')
@section('content')
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">   -->

<div class="banner position-relative">
    <div id="demo" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('public/images/book-holiday.jpg') }}" alt="flight discount" class="img-fluid">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('public/images/flight-discount2.jpg') }}" alt="flight discount" class="img-fluid">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('public/images/flight-discount1.jpg') }}" alt="flight discount" class="img-fluid">
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
    </a>
    </div>

<div class="container r-container">
    <div class="cld__book__form booking-form">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#flight"><i class="las la-plane"></i> Flight</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#hotel"><i class="las la-hotel"></i> Hotel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#fligh-and-hotel"><i class="las la-umbrella-beach"></i> Flights & Hotels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#visa"><i class="las la-file-contract"></i> Visa</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="flight" class="tab-pane active">
                <form name="myform" method="post" action="{{route('flights')}}">
                    @csrf
                    <input type="text" hidden id="country_code" name="country_code" value="" />
                    <div class="form-group">
                        <ul class="cld__selectors">
                            <li><a href="javascript:void(0)" class="active" id="one_way">One way</a></li>
                            <li><a href="javascript:void(0)" id="round_trip">Round trip</a></li>
                            <li><a href="{{route('multicityindex')}}">Multi city</a></li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="direct_flight" name="direct_flight"  value="DF">
                            <label class="custom-control-label text-dark" for="direct_flight">Direct flights only</label>
                          </div>
                        <div class="custom-control custom-checkbox custom-control-inline" id="flexiDiv">
                            <input type="checkbox" class="custom-control-input" id="flexi" name="flexi"  value="F">
                            <label class="custom-control-label text-dark" for="flexi">
                                Flexi (+/- 3 days)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="addFrom" id="addFrom"  placeholder="(IXC) | Chandigarh Airport" class="form-control search_input" required oninvalid="this.setCustomValidity('Please Enter From')" oninput="setCustomValidity('')">
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="addTo" id="addTo"  placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input" required oninvalid="this.setCustomValidity('Please Enter To')" oninput="setCustomValidity('')">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Departure Date</label>
                                <div id="departure_date_datetimepicker" class="input-group departure_date_datetimepickerclass">
                                    <input type="text" name="departure_date" id="departure_date" value="<?php echo date('d-m-Y')?>" placeholder="dd-mm-yyyy" class="form-control border-right-0 departure_date_datetimepickerclass" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on departure_date_datetimepickerclass">
                                      <span class="input-group-text bg-white pl-0 departure_date_datetimepickerclass"><i class="lar la-calendar-alt departure_date_datetimepickerclass"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6" id="returnDateDiv" returnDateDiv-data="0">
                            <div class="form-group">
                                <label>Returning Date</label>
                                <div id="returning_date_datetimepicker" class="input-group returning_date_datetimepickerclass">
                                    <input type="text" name="returning_date" id="returning_date" placeholder="dd-mm-yyyy" class="form-control border-right-0 returning_date_datetimepickerclass" data-format="dd-MM-yyyy" oninput="setCustomValidity('')">
                                    <div class="input-group-append add-on returning_date_datetimepickerclass">
                                      <span class="input-group-text bg-white pl-0 returning_date_datetimepickerclass"><i class="lar la-calendar-alt returning_date_datetimepickerclass"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Passengers & Class</label>
                        <input type="text" name="" id="flight_travel_details" placeholder="1 Adult,  Economy" class="form-control" onclick="traveller_selection();">
                    
                        <div id="traveller_selection" style="display:none;">
                            <div class="row m-0">
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Adults <small>(18+ yrs)</small></label>
                                        <select name="adults" id="adults" class="custom-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Children <small>(2-17 yrs)</small></label>
                                        <select name="children" id="children" class="custom-select">
                                            <option selected>0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Infant <small>(0-23 mths)</small></label>
                                        <select id="infant" name="infant" class="custom-select">
                                            <option selected>0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 px-2">
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
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <input type="button" name="" id="buttonApply" class="btn btn-primary" onclick="traveller_selection();" value="Apply">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="flight_submit" name="" class="btn btn-primary">Search Flight</button>
                    <!-- <a href="flights.php" class="btn btn-primary">Search Flight</a> -->
                </form>
            </div>
            <div id="hotel" class="tab-pane fade mt-3">
                <form name="hotelform" id="hotelform" method="post" action="{{route('hotels')}}">
                    @csrf
                    <div class="form-group">
                        <label>Destination</label>
                        <input type="text" name="city_name" id="city_name" required placeholder="New Delhi" class="form-control search_hotel">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Check In</label>
                                <div id="check_in_datetimepicker" class="input-group check_in_datetimepickerclass">
                                    <input type="text" name="check_in" required id="check_in" placeholder="dd/mm/yyyy" class="form-control border-right-0 check_in_datetimepickerclass" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on check_in_datetimepickerclass">
                                      <span class="input-group-text bg-white pl-0 check_in_datetimepickerclass"><i class="lar la-calendar-alt check_in_datetimepickerclass"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Check Out</label>
                                <div id="check_out_datetimepicker" class="input-group check_out_datetimepickerclass">
                                    <input type="text" name="check_out" required id="check_out" placeholder="dd/mm/yyyy" class="form-control border-right-0 check_out_datetimepickerclass" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on check_out_datetimepickerclass">
                                      <span class="input-group-text bg-white pl-0 check_out_datetimepickerclass"><i class="lar la-calendar-alt check_out_datetimepickerclass"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Room & Guests</label>
                        <input type="text" name="hotel_travel_details" id="hotel_travel_details" placeholder="1 Room, 1 Adult" class="form-control" onclick="hotel_traveller_selection();">
                    
                        <div id="hotel_traveller_selection" style="display:none;">
                            <div class="row m-0">
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Room</label>
                                        <select name="hotel_room" id="hotel_room" class="custom-select">
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Adults <small>(18+ yrs)</small></label>
                                        <select name="room1_hotel_adults" id="room1_hotel_adults" class="custom-select">
                                            <option selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Child Age -1<small></small></label>
                                        <select name="room1_hotel_child" id="room1_hotel_child" class="custom-select">
                                            <option >0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="16">17</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 px-2">
                                    <div class="form-group">
                                        <label>Child Age -2 <small></small></label>
                                        <select name="room1_hotel_infant" id="room1_hotel_infant" class="custom-select">
                                            <option >0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="16">17</option>
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
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 px-2" id="room2ChildDiv">
                                        <div class="form-group">
                                            <label>Child Age -1<small></small></label>
                                            <select name="room2_hotel_child" id="room2_hotel_child" class="custom-select">
                                                <option >0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="16">17</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 px-2" id="room2InfantDiv">
                                        <div class="form-group">
                                            <label>Child Age -2 <small></small></label>
                                            <select name="room2_hotel_infant" id="room2_hotel_infant" class="custom-select">
                                                <option >0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="16">17</option>
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
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 px-2" id="room3ChildDiv">
                                        <div class="form-group">
                                            <label>Child Age -1<small></small></label>
                                            <select name="room3_hotel_child" id="room3_hotel_child" class="custom-select">
                                                <option >0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="16">17</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 px-2" id="room3InfantDiv">
                                        <div class="form-group">
                                            <label>Child Age -2 <small></small></label>
                                            <select name="room3_hotel_infant" id="room3_hotel_infant" class="custom-select">
                                                <option >0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="16">17</option>
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
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 px-2" id="room4ChildDiv">
                                        <div class="form-group">
                                            <label>Child Age -1<small></small></label>
                                            <select name="room4_hotel_child" id="room4_hotel_child" class="custom-select">
                                                <option >0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="16">17</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 px-2" id="room4InfantDiv">
                                        <div class="form-group">
                                            <label>Child Age -2 <small></small></label>
                                            <select name="room4_hotel_infant" id="room4_hotel_infant" class="custom-select">
                                                <option >0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="16">17</option>
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
                    <div class="form-group">
                        <label>Currency</label>
                        <select name="currency" id="currency" class="form-control">
                            @foreach($hotel_currency as $hotel_currencies)
                            <option value="{{$hotel_currencies->currency}}">{{$hotel_currencies->currency}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" name="hotel_submit" id="hotel_submit" class="btn btn-primary">Search Hotels</button>
                    <!-- <a href="hotels.php" class="btn btn-primary">Search Hotels</a> -->
                </form>
            </div>
            <div id="fligh-and-hotel" class="tab-pane fade mt-3">
                <form method="post" action="">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="" placeholder="(IXC) | Chandigarh Airport" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="" placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Departure Date</label>
                                <div id="datetimepicker" class="input-group">
                                    <input type="text" name="date_of_birth" placeholder="dd/mm/yyyy" class="form-control border-right-0" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on">
                                      <span class="input-group-text bg-white pl-0"><i class="lar la-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Returning Date</label>
                                <div id="datetimepicker" class="input-group">
                                    <input type="text" name="date_of_birth" placeholder="dd/mm/yyyy" class="form-control border-right-0" data-format="dd-MM-yyyy">
                                    <div class="input-group-append add-on">
                                      <span class="input-group-text bg-white pl-0"><i class="lar la-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Rooms</label>
                        <select name="adults" class="custom-select">
                            <option selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <div class="repeat__row">
                            <div class="row">
                                <div class="col-2 pl-3 pr-0">
                                    <small>Room 1</small>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Adults <small>(18+ yrs)</small></label>
                                        <select name="adults" class="custom-select">
                                            <option selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Children <small>(0-17 yrs)</small></label>
                                        <select name="adults" class="custom-select">
                                            <option selected>0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <button type="submit" class="btn btn-primary">Search Flight & Hotel</button> -->
                    <a href="flight-hotel.php" class="btn btn-primary">Search Flight & Hotel</a>
                </form>
            </div>
            <div id="visa" class="tab-pane fade mt-3">
                <form method="post" action="">
                    <div class="form-group">
                        <label>For Citizens of</label>
                        <input type="text" name="" placeholder="Ex. United kingdom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Traveling To</label>
                        <input type="text" name="" placeholder="Which country?" class="form-control">
                    </div>
                    <a href="visa-requirements.php" class="btn btn-primary">Check Requirements</a>
                    <!-- <button type="submit" class="btn btn-primary">Check Requirements</button> -->
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<div class="middle bg-white">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center mt-5">
                <h1 class="font-weight-light h1 mb-1">Top <span class="font-weight-bold">holiday destination</span></h1>
                <p>Find our lowest price to destinations worldwide guaranteed.</p>
            </div>
            <div class="col-md-12 mt-2">
                <div id="cld__holiday__destination__banner" class="owl-carousel owl-theme owl__control__top">
                    <div class="item">
                        <a href="#">
                            <div class="destination__wrapper" style="background:url('traveltest/../public/images/QrOnUx.jpg') no-repeat;background-size:cover;">
                                <figcaption>
                                    <h3>Cuba</h3>
                                    <span>Special offers from <span class="text-warning"><i class="las la-rupee-sign"></i>620</span></span>
                                </figcaption>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <div class="destination__wrapper" style="background:url('traveltest/../public/images/SaintLucia.jpg') no-repeat;background-size:cover;">
                                <figcaption>
                                    <h3>Saint Lucia</h3>
                                    <span>Special offers from <span class="text-warning"><i class="las la-rupee-sign"></i>710</span></span>
                                </figcaption>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <div class="destination__wrapper" style="background:url('traveltest/../public/images/aerial-view-of-fairmont.jpg') no-repeat;background-size:cover;">
                                <figcaption>
                                    <h3>Maldives</h3>
                                    <span>Special offers from <span class="text-warning"><i class="las la-rupee-sign"></i>948</span></span>
                                </figcaption>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <div class="destination__wrapper" style="background:url('traveltest/../public/images/parcarou1_720x500.jpg') no-repeat;background-size:cover;">
                                <figcaption>
                                    <h3>Paris</h3>
                                    <span>Special offers from <span class="text-warning"><i class="las la-rupee-sign"></i>1020</span></span>
                                </figcaption>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#">
                            <div class="destination__wrapper" style="background:url('traveltest/../public/images/australia-sydney-opera-house.jpg') no-repeat;background-size:cover;">
                                <figcaption>
                                    <h3>Australia</h3>
                                    <span>Special offers from <span class="text-warning"><i class="las la-rupee-sign"></i>620</span></span>
                                </figcaption>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-primary py-4 my-5">
        <div class="container">
            <div class="row cld__bes__wrap">
                <div class="col-md-12 text-center">
                    <h2 class="font-weight-light h1 mb-4 text-white">Why choose <span class="font-weight-bold">Cloud Travels</span></h2>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="media align-items-center">
                            <div class="media-left mr-3"><img src="{{ asset('public/images/best-price.png') }}" alt="best price" class="img-fluid"/></div>
                            <div class="media-body">
                                <h5>Best price guarantee</h5>
                                <p>Find our lowest price to destinations worldwide guaranteed.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="media align-items-center">
                            <div class="media-left mr-3"><img src="{{ asset('public/images/easy-booking.png') }}" alt="easy booking"/></div>
                            <div class="media-body">
                                <h5>Easy booking</h5>
                                <p>Search, select and save - the fastest way to book your trip.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="media align-items-center">
                            <div class="media-left mr-3"><img src="{{ asset('public/images/support.png') }}" alt="support"/></div>
                            <div class="media-body">
                                <h5>24/7 Customer support</h5>
                                <p>Receive free support from our friendly and reliable team.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    
    <div class="container mb-4">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="font-weight-light h1 mb-1">Holidays to <span class="font-weight-bold">inspire you…</span></h2>
                    <p>Discover a different world…</p>
                </div>
                <div class="col-md-8 mb-3">
                    <div class="destination__wrapper short rounded-0" style="background:url('traveltest/../public/images/family2-1.jpg') no-repeat;background-size:cover;">
                    <figcaption>
        <h4 class="text-uppercase font-weight-600">Family Holidays</h4>
    <span class="d-block mb-2">Theme parks, water sports and kids clubs…keeping the whole family happy</span>
        <a href="#" class="font-weight-bold">More details <i class="las la-long-arrow-alt-right"></i></a>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-4 mb-3 pl-md-0">
                    <div class="destination__wrapper short small_box rounded-0" style="background:url('traveltest/../public/images/c1aa5740.jpg') no-repeat;background-size:cover;">
                        <figcaption>
                            <h4 class="text-uppercase font-weight-600">Luxury Holidays</h4>
                            <span class="d-block mb-2">From the richest city in the world to holiday destinations</span>
                            <a href="#" class="font-weight-bold">More details <i class="las la-long-arrow-alt-right"></i></a>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0 pr-md-0">
                    <div class="destination__wrapper short small_box rounded-0" style="background:url('traveltest/../public/images/Hero-Cruise-ship.jpg') no-repeat;background-size:cover;">
                        <figcaption>
                            <h4 class="text-uppercase font-weight-600">Cruises</h4>
                            <span class="d-block mb-2">Incredible Cruise Deals</span>
                            <a href="#" class="font-weight-bold">More details <i class="las la-long-arrow-alt-right"></i></a>
                        </figcaption>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="destination__wrapper short rounded-0" style="background:url('traveltest/../public/images/Honeymoon-destination.jpg') no-repeat;background-size:cover;">
                        <figcaption>
                            <h4 class="text-uppercase font-weight-600">Honeymoon Holidays</h4>
                            <span class="d-block mb-2">Beach escapes, luxury resorts and unforgettable island paradises</span>
                            <a href="#" class="font-weight-bold">More details <i class="las la-long-arrow-alt-right"></i></a>
                        </figcaption>
                    </div>
                </div>
            </div>
    </div>

    <div class="bg-primary py-4 my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="font-weight-light h1 mb-1 text-white">Best <span class="font-weight-bold">offers for you!</span></h3>
                    <p class="text-white">Discover a different world…</p>
                </div>
                <div class="col-md-12 mt-2">
                    <div id="cld__home__discount__banner" class="owl-carousel owl-theme cld__home__discount__banner owl__control__top">
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount1.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount2.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount3.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount4.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount1.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount2.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount3.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount4.jpg') }}" alt="discount1" class="img-fluid"/></a></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <a href="#"><img src="{{ asset('public/images/Landing-page-banner-mobile.jpg') }}" alt="" class="img-fluid"/></a>
            </div>
            <div class="col-md-6">
                <a href="#"><img src="{{ asset('public/images/SME_Desktop-Landingpage-mobile-banner.jpg') }}" alt="" class="img-fluid"/></a>
            </div>
        </div>
    </div>

</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" />
@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script> </head> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
<script type="text/javascript">
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();
        $('#flexiDiv').hide();
        $('#returnDateDiv').hide();
        
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

        // departure_date_datetimepickerclass
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
            // $('#returnDateDiv').attr('returnDateDiv-data','1'); 
        
        });

        $('.returning_date_datetimepickerclass').on('click',function(){
            // alert("return hii")
            // $("#returning_date_datetimepicker").datetimepicker("destroy");
            // returning_date
            var dep_val=$('#departure_date').val();
            $('#returning_date').val('');
            $('#returning_date').val(dep_val);
            
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

        
        $('.returning_date_datetimepickerclass').click(function(){
            // alert("hii");
            $('#one_way').removeAttr('class');
            $('#round_trip').attr('class','active');
            $('#flexiDiv').show();

        });

        // $(".returning_date_datetimepickerclass").blur(function(){
        //     // alert("This input field has lost its focus.");
        //     // alert($('#returning_date').val());
        //     if($('#returning_date').val()==''){
        //         $('#round_trip').removeAttr('class');
        //         $('#one_way').attr('class','active');
        //     }
            
        // });
        
        $('#one_way').click(function(){
            // returning_date
            $('#returning_date').val('');
            $('#round_trip').removeAttr('class');
            $('#one_way').attr('class','active');
            $('#flexiDiv').hide();
            $('#returnDateDiv').hide(); 
            // $('#returnDateDiv').removeAttr('returnDateDiv-data'); 
            $('#returnDateDiv').attr('returnDateDiv-data','0'); 
            $('#returning_date').removeAttr('required');

        });
        $('#round_trip').click(function(){
            // alert("hii");
            $('#flexiDiv').show();
            $('#one_way').removeAttr('class');
            $('#round_trip').attr('class','active');
            $('#returnDateDiv').show(); 
            $('#returnDateDiv').attr('returnDateDiv-data','1'); 
            $('#returning_date').attr('required','required'); 
            
            // $("#returning_date_datetimepicker").datetimepicker("show"); 
            var dep_val=$('#departure_date').val();
            var newdate = dep_val.split("-").reverse().join("/");
            var datePeriode= new Date(newdate);
            var adddate=datePeriode.setDate(datePeriode.getDate() + 1)
            // // alert("hii")
            $('#returning_date_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(adddate),
                todayHighlight: false,
            });
            $("#returning_date_datetimepicker").datetimepicker("show"); 


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
            var returning_date=$('#returning_date').val();
            // alert(returning_date);
            var returnDateDivval=$("#returnDateDiv").attr("returnDateDiv-data");
            // alert(returnDateDivval);
            if(returnDateDivval==1){
                // if(addFrom==""){
                //     // alert('Please enter From');
                //     var blankval="Please enter From";
                //     blankCheck(blankval);
                //     return false;
                //     // $('#addFrom').focus();
                // }else if(addTo==""){
                //     // alert('Please enter To');
                //     var blankval="Please enter To";
                //     blankCheck(blankval);
                //     return false;
                // }else 
                // if(returning_date==""){
                //     // alert('Please enter To');
                //     // var blankval="Please enter Return Date";
                //     // document.getElementById ('returning_date').setCustomValidity('');
                //     returning_date.setCustomValidity( "Please enter Retuen Date." );
                //     // document.getElementById ('returning_date').setCustomValidity( "Please enter Retuen Date." );
                //     document.myform.returning_date.focus ( );
                //     // returning_date.setCustomValidity ('');
                //     // document.getElementById('returning_date').setCustomValidity('');
                //     // $("#returning_date_datetimepicker").datetimepicker("show"); 

                //     // blankCheck(blankval);
                //     return false;
                // }else{
                    // document.getElementById ( 'returning_date' ).setCustomValidity ( " " );
                if(addFrom!="" && addTo!="" && returning_date!=""){
                    $('#loading').show();
                    return true;
                }

            }else if(returnDateDivval==0){
                if(addFrom!="" && addTo!=""){
                //     // alert('Please enter From');
                //     var blankval="Please enter From";
                //     blankCheck(blankval,'addFrom');
                //     return false;
                //     // $('#addFrom').focus();

                // }else if(addTo==""){
                //     // alert('Please enter To');
                //     var blankval="Please enter To";
                //     blankCheck(blankval);
                //     return false;
                // }else{

                    $('#loading').show();
                }
                // return true;
            }
            // var returnDateDivval=$("#returnDateDiv").attr("returnDateDiv-data");
            // alert(returning_date);
            // if(returnDateDivval==1){
            //     if(addFrom!='' && addTo!='' && returning_date!=''){
            //         $('#loading').show();
            //     }
            // }else if(returnDateDivval==0){
            //     if(addFrom!='' && addTo!=''){
            //         $('#loading').show();
            //     }
            // }
            // alert(addFrom);
            // path='<?php echo route('flights');?>';
            // var url=("{{route('flights')}}")
            // window.location.href(path);
            // window.location.assign(url);
        })

    });
    function blankCheck(blankval,adval){
        $.confirm ( {
            title: false,
            content: blankval,
            animation: 'scale',
            type: 'blue',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Ok',
                    btnClass: 'btn-blue',
                    // action: function ( ) {
                    //     // alert("hii");
                    //     $('#'+adval).focus();
                    //     // $('#'+adval).focus();
                    //     // return false;
                    // }
                }
            }
        });
        // return false;
    }
</script>

    <!-- start google location api -->
    
<script src="https://maps.google.com/maps/api/js?key=<?php echo app('App\Http\Controllers\GoogleAPIController')->GoogleAPIKey();?>"></script>
<script>
    $( document ).ready(function() {
        getLocation();
    });

    var x = document.getElementById("googleerrorcode");
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        // alert("lat : "+lat);
        // alert("long : "+long);
        var point = new google.maps.LatLng(lat, long);
        new google.maps.Geocoder().geocode( {'latLng': point}, 
        function (results, status) { 
            // alert(results)
            // var obj=JSON.parse(results);
            var obj=JSON.stringify(results);
            
            // alert(obj)
            // console.log(obj)
            for(i=0; i < results.length; i++){
                for(var j=0;j < results[i].address_components.length; j++){
                    for(var k=0; k < results[i].address_components[j].types.length; k++){
                        if(results[i].address_components[j].types[k] == "country"){
                            country_name = results[i].address_components[j].short_name;
                            // country_name = results[i].address_components[j].long_name;
                            // $("#country_name").val('');
                            // $("#country_name").val(country_name);
                        }
                    }
                }
            }
            // alert(country_name);
            $("#country_code").val('');
            $("#country_code").val(country_name);
        });
    }
    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
            case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
            case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
            case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
        }
    }
</script>
    <!-- end google location api -->

        <!-- start hotel section -->
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
            var someDate = new Date();
            someDate.setDate(someDate.getDate() + 1); //number  of days to add, e.x. 15 days
            var dateFormated = someDate.toISOString().substr(0,10);
            // alert(dateFormated)
            var dateFormated1 = dateFormated.split("-").reverse().join("-");
            $('#check_in').val('');
            $('#check_in').val(dateFormated1);
            var newdate = dateFormated1.split("-").reverse().join("/");
            $("#check_in_datetimepicker").datetimepicker("destroy");
            $('#check_in_datetimepicker').datetimepicker({
                pickTime: false,
                autoclose: true, 
                startDate: new Date(newdate),
                todayHighlight: true,
                // minDate: new Date('2021/09/10'),
                // defaultDate: new Date(),
            });
            $('#check_in_datetimepicker').datetimepicker("show").on('changeDate', function(){
                // $('#departure_date_datetimepicker').hide();
                $('#check_in_datetimepicker').datetimepicker("hide")
            });
            // $('#returnDateDiv').attr('returnDateDiv-data','1'); 
        
        });

        $('.check_out_datetimepickerclass').on('click',function(){
            // alert("return hii")
            // $("#check_out_datetimepicker").datetimepicker("destroy");
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

            $('#check_out_datetimepicker').datetimepicker({
                pickTime: false,
                startDate: new Date(newdate),
                // setStartDate: new Date(newdate),
                // minDate:new Date(newdate),
                // autoclose: true,
                // todayHighlight: true,
            });

            // $('#returning_date_datetimepicker').datetimepicker("show");
            $('#check_out_datetimepicker').datetimepicker("show").on('changeDate', function(){
                $('#check_out_datetimepicker').datetimepicker("hide")
            });
        });

        // room4HeadingDiv
        // room2AdultDiv
        // room2ChildDiv
        // room2InfantDiv
        $('#room2HeadingDiv').hide();
        $('#room2AdultDiv').hide();
        $('#room2ChildDiv').hide();
        $('#room2InfantDiv').hide();

        $('#room3HeadingDiv').hide();
        $('#room3AdultDiv').hide();
        $('#room3ChildDiv').hide();
        $('#room3InfantDiv').hide();

        $('#room4HeadingDiv').hide();
        $('#room4AdultDiv').hide();
        $('#room4ChildDiv').hide();
        $('#room4InfantDiv').hide();
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
            // alert(check_in+" - "+check_out)
            if(check_in!='' && check_out!=''){
                if (check_in==check_out) {
                    alert("Check in date and check out date can not be same");
                    return false;
                }else if(city_name!='' && check_in!='' && check_out!=''){
                    $('#loading').show();
                }
            }
        });
    });
</script>
        <!-- end hotel section -->
@endsection