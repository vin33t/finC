@extends('common.master')
@section('content')


<?php 
    $country_code=$searched->country_code;
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
                    <li><a href="#"><span>3</span> Payment</a></li>
                    <li><a href="#"><span>4</span> Confirm</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <h4 class="font-weight-500">Passanger Details</h4><hr>
                    <div>
                        <span class="badge badge-pill badge-warning">Note:</span> Please make sure you enter the Name as per your govt. photo id.
                    </div><hr>
                    <div class="passanger-details">
                    <form name="pass_details" method="POST" action="{{route('multicityshowpayment')}}">
                    @csrf
                        @for ($i=1; $i <= $searched->adults; $i++)
                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2"><i class="las la-user-circle"></i> Adult {{$i}}</h6>
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <select class="form-control custom-select" name="title{{$i}}" id="title{{$i}}" required>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Mstr">Mstr</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="first_name{{$i}}" id="first_name{{$i}}" required class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name{{$i}}" id="last_name{{$i}}" required class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control custom-select" name="gender{{$i}}" id="gender{{$i}}" required>
                                            <option value="Male">Male</option>
                                            <option value="Male">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label>Date of birth</label>
                                    <div id="datetimepicker" class="input-group">
                                        <input type="text" name="date_of_birth{{$i}}" id="date_of_birth{{$i}}" required placeholder="dd/mm/yyyy" class="form-control border-right-0" data-format="dd-MM-yyyy">
                                        <div class="input-group-append add-on">
                                        <span class="input-group-text bg-white pl-0"><i class="lar la-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Seating</label>
                                        <select class="form-control custom-select" name="seating{{$i}}" id="seating{{$i}}" required>
                                            <option value="No preference">No preference</option>  
                                            <option value="Aisle seat">Aisle seat</option>
                                            <option value="Bulkhead seat">Bulkhead seat</option>
                                            <option value="Cradle/Baby Basket seat">Cradle/Baby Basket seat</option>
                                            <option value="Exit seat">Exit seat</option>
                                            <option value="Non smoking window seat">Non smoking window seat</option>
                                            <option value="Suitable for disable seat">Suitable for disable seat</option>
                                            <option value="Suitable for disable seat">Suitable for disable seat</option>
                                            <option value="Legspace">Legspace</option>
                                            <option value="Non smoking seat">Non smoking seat</option>
                                            <option value="Overwing seat">Overwing seat</option>
                                            <option value="Smoking seat">Smoking seat</option>
                                            <option value="Window seat">Window seat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Assistance</label>
                                        <select class="form-control custom-select" name="assistance{{$i}}" id="assistance{{$i}}" required>
                                            <option selected="selected" value="No preference">No preference</option>
                                            <option value="Overwing seat">Deaf</option>
                                            <option value="Smoking seat">Blind</option>
                                            <option value="Window seat">Wheelchair</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Meal</label>
                                        <select class="form-control custom-select" name="meal{{$i}}" id="meal{{$i}}">
                                            <option value="No preference">No preference</option>
                                            <option value="BBML">Baby Meal</option>
                                            <option value="BLML">Bland Meal</option>
                                            <option value="CHML">Child Meal Meal</option>
                                            <option value="DBML">Diabetic Meal</option>
                                            <option value="FPML">Fruit Platter Meal</option>
                                            <option value="GFML">Gluten Intolerant Meal</option>
                                            <option value="HNML">Hindu Meal</option>
                                            <option value="KSML">Kosher Meal</option>
                                            <option value="LCML">Low Calorie Meal</option>
                                            <option value="LFML">Low Fat Meal</option>
                                            <option value="NLML">Low Lactose Meal</option>
                                            <option value="LSML">Low Salt Meal</option>
                                            <option value="MOML">Muslim Meal</option>
                                            <option value="RVML">Raw Vegetarian Meal</option>
                                            <option value="SFML">Seafood Meal</option>
                                            <option value="SPML">Special Meal</option>
                                            <option value="AVML">Vegetarian Hindu Meal</option>
                                            <option value="VJML">Vegetarian Jain Meal</option>
                                            <option value="VLML">Vegetarian Lacto-Ovo</option>
                                            <option value="VGML">Vegetarian Meal</option>
                                            <option value="VOML">Vegetarian Oriental Meal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        @endfor
                        @for ($i=1; $i <= $searched->children; $i++)
                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2"><i class="las la-user-circle"></i> Children {{$i}}</h6>
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <select class="form-control custom-select" name="children_title{{$i}}" id="children_title{{$i}}" required>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Mstr">Mstr</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="children_first_name{{$i}}" id="children_first_name{{$i}}" required class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="children_last_name{{$i}}" id="children_last_name{{$i}}" required class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control custom-select" name="children_gender{{$i}}" id="children_gender{{$i}}" required>
                                            <option value="Male">Male</option>
                                            <option value="Male">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label>Date of birth</label>
                                    <div id="datetimepicker" class="input-group">
                                        <input type="text" name="children_date_of_birth{{$i}}" id="children_date_of_birth{{$i}}" required placeholder="dd/mm/yyyy" class="form-control border-right-0" data-format="dd-MM-yyyy">
                                        <div class="input-group-append add-on">
                                        <span class="input-group-text bg-white pl-0"><i class="lar la-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Seating</label>
                                        <select class="form-control custom-select" name="children_seating{{$i}}" id="children_seating{{$i}}" required>
                                            <option value="No preference">No preference</option>
                                            <option value="Aisle seat">Aisle seat</option>
                                            <option value="Bulkhead seat">Bulkhead seat</option>
                                            <option value="Cradle/Baby Basket seat">Cradle/Baby Basket seat</option>
                                            <option value="Exit seat">Exit seat</option>
                                            <option value="Non smoking window seat">Non smoking window seat</option>
                                            <option value="Suitable for disable seat">Suitable for disable seat</option>
                                            <option value="Suitable for disable seat">Suitable for disable seat</option>
                                            <option value="Legspace">Legspace</option>
                                            <option value="Non smoking seat">Non smoking seat</option>
                                            <option value="Overwing seat">Overwing seat</option>
                                            <option value="Smoking seat">Smoking seat</option>
                                            <option value="Window seat">Window seat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Assistance</label>
                                        <select class="form-control custom-select" name="children_assistance{{$i}}" id="children_assistance{{$i}}" required>
                                            <option value="No preference">No preference</option>
                                            <option value="Overwing seat">Deaf</option>
                                            <option value="Smoking seat">Blind</option>
                                            <option value="Window seat">Wheelchair</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Meal</label>
                                        <select class="form-control custom-select" name="children_meal{{$i}}" id="children_meal{{$i}}">
                                            <option value="No preference">No preference</option>
                                            <option value="BBML">Baby Meal</option>
                                            <option value="BLML">Bland Meal</option>
                                            <option value="CHML">Child Meal Meal</option>
                                            <option value="DBML">Diabetic Meal</option>
                                            <option value="FPML">Fruit Platter Meal</option>
                                            <option value="GFML">Gluten Intolerant Meal</option>
                                            <option value="HNML">Hindu Meal</option>
                                            <option value="KSML">Kosher Meal</option>
                                            <option value="LCML">Low Calorie Meal</option>
                                            <option value="LFML">Low Fat Meal</option>
                                            <option value="NLML">Low Lactose Meal</option>
                                            <option value="LSML">Low Salt Meal</option>
                                            <option value="MOML">Muslim Meal</option>
                                            <option value="RVML">Raw Vegetarian Meal</option>
                                            <option value="SFML">Seafood Meal</option>
                                            <option value="SPML">Special Meal</option>
                                            <option value="AVML">Vegetarian Hindu Meal</option>
                                            <option value="VJML">Vegetarian Jain Meal</option>
                                            <option value="VLML">Vegetarian Lacto-Ovo</option>
                                            <option value="VGML">Vegetarian Meal</option>
                                            <option value="VOML">Vegetarian Oriental Meal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                        @for ($i=1; $i <= $searched->infant; $i++)
                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2"><i class="las la-user-circle"></i> Infant {{$i}}</h6>
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <select class="form-control custom-select" name="infant_title{{$i}}" id="infant_title{{$i}}" required>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Mstr">Mstr</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="infant_first_name{{$i}}" id="infant_first_name{{$i}}" required class="form-control" placeholder="Enter first name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="infant_last_name{{$i}}" id="infant_last_name{{$i}}" required class="form-control" placeholder="Enter last name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control custom-select" name="infant_gender{{$i}}" id="infant_gender{{$i}}" required>
                                            <option value="Male">Male</option>
                                            <option value="Male">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label>Date of birth</label>
                                    <div id="datetimepicker" class="input-group">
                                        <input type="text" name="infant_date_of_birth{{$i}}" id="infant_date_of_birth{{$i}}" required placeholder="dd/mm/yyyy" class="form-control border-right-0" data-format="dd-MM-yyyy">
                                        <div class="input-group-append add-on">
                                        <span class="input-group-text bg-white pl-0"><i class="lar la-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Seating</label>
                                        <select class="form-control custom-select" name="infant_seating{{$i}}" id="infant_seating{{$i}}" required>
                                            <option value="No preference">No preference</option>
                                            <option value="Aisle seat">Aisle seat</option>
                                            <option value="Bulkhead seat">Bulkhead seat</option>
                                            <option value="Cradle/Baby Basket seat">Cradle/Baby Basket seat</option>
                                            <option value="Exit seat">Exit seat</option>
                                            <option value="Non smoking window seat">Non smoking window seat</option>
                                            <option value="Suitable for disable seat">Suitable for disable seat</option>
                                            <option value="Suitable for disable seat">Suitable for disable seat</option>
                                            <option value="Legspace">Legspace</option>
                                            <option value="Non smoking seat">Non smoking seat</option>
                                            <option value="Overwing seat">Overwing seat</option>
                                            <option value="Smoking seat">Smoking seat</option>
                                            <option value="Window seat">Window seat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Assistance</label>
                                        <select class="form-control custom-select" name="infant_assistance{{$i}}" id="infant_assistance{{$i}}" required>
                                            <option value="No preference">No preference</option>
                                            <option value="Overwing seat">Deaf</option>
                                            <option value="Smoking seat">Blind</option>
                                            <option value="Window seat">Wheelchair</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Meal</label>
                                        <select class="form-control custom-select" name="infant_meal{{$i}}" id="infant_meal{{$i}}">
                                            <option value="No preference">No preference</option>
                                            <option value="BBML">Baby Meal</option>
                                            <option value="BLML">Bland Meal</option>
                                            <option value="CHML">Child Meal Meal</option>
                                            <option value="DBML">Diabetic Meal</option>
                                            <option value="FPML">Fruit Platter Meal</option>
                                            <option value="GFML">Gluten Intolerant Meal</option>
                                            <option value="HNML">Hindu Meal</option>
                                            <option value="KSML">Kosher Meal</option>
                                            <option value="LCML">Low Calorie Meal</option>
                                            <option value="LFML">Low Fat Meal</option>
                                            <option value="NLML">Low Lactose Meal</option>
                                            <option value="LSML">Low Salt Meal</option>
                                            <option value="MOML">Muslim Meal</option>
                                            <option value="RVML">Raw Vegetarian Meal</option>
                                            <option value="SFML">Seafood Meal</option>
                                            <option value="SPML">Special Meal</option>
                                            <option value="AVML">Vegetarian Hindu Meal</option>
                                            <option value="VJML">Vegetarian Jain Meal</option>
                                            <option value="VLML">Vegetarian Lacto-Ovo</option>
                                            <option value="VGML">Vegetarian Meal</option>
                                            <option value="VOML">Vegetarian Oriental Meal</option>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        @endfor
                       

                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2">Passenger Address</h6>
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Post code</label>
                                        <input type="text" name="postcode" id="postcode" required class="form-control" placeholder="Enter post code">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Address Line 1</label>
                                        <input type="text" name="add_1" id="add_1" required class="form-control" placeholder="Enter Address Line 1">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="add_2" id="add_2" required class="form-control" placeholder="Enter Address Line 2">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" id="city" required class="form-control" placeholder="Enter your town/city name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label>State code</label>
                                        <input type="text" name="state_code" id="state_code" required class="form-control" placeholder="Enter your state code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border rounded set mb-3">
                            <h6 class="font-weight-500 mb-3 bg-primary-light p-2">Contact Details</h6>
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="form-group">
                                        <label>Email id</label>
                                        <input type="email" name="email" id="email" required placeholder="Enter email id" class="form-control mb-2"/>
                                        <small class="text-muted">Your ticket will be sent to this email address</small>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="number" name="mob_no" id="mob_no" required placeholder="Enter" class="form-control" max="9999999999" oninvalid="this.setCustomValidity('Mobile no up to 10 digit')" oninput="this.setCustomValidity('')"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="flights1" id="flights1" value="{{json_encode($flights1)}}">
                        <input type="text" name="flights" value="{{$flights}}" hidden>
                        <input type="hidden" name="flights2" id="flights2" value="{{$flights2}}">
                        <input type="hidden" name="flights3" id="flights3" value="{{$flights3}}">
                        <input type="hidden" name="adults" id="adults" value="{{$searched->adults}}">
                        <input type="hidden" name="children" id="children" value="{{$searched->children}}">
                        <input type="hidden" name="infant" id="infant" value="{{$searched->infant}}">
                        <input type="text" name="country_code" value="{{ $searched->country_code }}" hidden>
                        <button type="submit" class="btn btn-primary" onclick="showLoder();">Proceed to payment</button>
                        <!-- <a href="payment.php" class="btn btn-primary">Proceed to payment</a> -->
                    </form>
                    </div>
                </div>
            </div>
            
           
            <div class="col-md-3">
                <div class="card">
                        <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                        <span class="text-muted">Travelers {{$searched->adults}} Adult</span>
                        <table class="table table-small mt-2">
                        @foreach($flights1[3] as $price)
                            @for($i=0;$i< count($price);$i++)
                            @if($i==0)
                            <!-- {{$price[$i]['ApproximateBasePrice']}} -->
                            <tr class="font-weight-bold bg-light">
                                <td>Passenger Type</td>
                                <td class="text-right">Adult</td>
                            </tr>
                            <tr>
                                <td>Base Fare x {{$searched->adults}}</td>
                                <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$searched->adults),2)}}</td>
                            </tr>
                            <tr>
                                <td>Taxes x {{$searched->adults}}</td>
                                <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$searched->adults),2)}}</td>
                            </tr>
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Price {{$searched->adults}} adult(s)</td>
                                <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$searched->adults),2)}}</td>
                            </tr>
                            @elseif($i==1)
                            <tr class="font-weight-bold bg-light">
                            <td>Passenger Type</td>
                            <td class="text-right">Child</td>
                            </tr>
                            <tr>
                                <td>Base Fare x {{$searched->children}}</td>
                                <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$searched->children),2)}}</td>
                            </tr>
                            <tr>
                                <td>Taxes x {{$searched->children}}</td>
                                <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$searched->children),2)}}</td>
                            </tr>
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Price {{$searched->children}} child(s)</td>
                                <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$searched->children),2)}}</td>
                            </tr>
                            @elseif($i==2)
                            <tr class="font-weight-bold bg-light">
                            <td>Passenger Type</td>
                            <td class="text-right">Infant</td>
                            </tr>
                            <tr>
                                <td>Base Fare x {{$searched->infant}}</td>
                                <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$searched->infant),2)}}</td>
                            </tr>
                            <tr>
                                <td>Taxes x {{$searched->infant}}</td>
                                <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$searched->infant),2)}}</td>
                            </tr>
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Price {{$searched->infant}} infant(s)</td>
                                <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$searched->infant),2)}}</td>
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
                                <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$flights1[2]['price']['TotalPrice'])),2)}}</td>
                            </tr>
                        </table>
                       
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