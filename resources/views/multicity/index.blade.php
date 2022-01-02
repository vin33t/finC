@extends('common.master')
@section('content')

<div class="container my-3 py-3 border-top border-bottom">
    <div class="row">
        <div class="col-md-12">
            <h3 class="font-weight-600 mb-3">Multi City / Stop Over <i class="las la-plane"></i></h3>
        </div>
    </div>
   <div class="cld__book__form search__modify">
        <form name="multicity" id="multicity" method="POST" action="{{route('multicityflight')}}" class="w-100">
            @csrf
            <input type="text" hidden id="country_code" name="country_code" value="{{isset($searched->country_code)?$searched->country_code:''}}" />
            <div class="row">
                <div class="col-md-2">
                    <h6 class="text-uppercase text-muted">Flight 1</h6>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from1" id="from1" required placeholder="(IXC) | Chandigarh Airport" class="form-control search_input">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="to1" id="to1" required placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date</label>
                        <div id="flight0_date_datetimepicker" class="input-group flight0_date_datetimepicker_class">
                            <input type="text" name="flight0_date" id="flight0_date" required value="{{date('d-m-Y')}}" placeholder="dd-mm-yyyy" class="form-control border-right-0 flight0_date_datetimepicker_class" data-format="dd-MM-yyyy">
                            <div class="input-group-append add-on flight0_date_datetimepicker_class">
                            <span class="input-group-text bg-white pl-0 flight0_date_datetimepicker_class"><i class="lar la-calendar-alt flight0_date_datetimepicker_class"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="2rdFlight" data-show-value="0">
                <div class="col-md-2">
                    <h6 class="text-uppercase text-muted">Flight 2</h6>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from2" id="from2"  placeholder="(IXC) | Chandigarh Airport" class="form-control search_input">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="to2" id="to2" value=""  placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date</label>
                        <div id="flight1_date_datetimepicker" class="input-group flight1_date_datetimepicker_class">
                            <!-- <input type="text" name="flight1_date" required id="flight1_date" value="{{ date('d-m-Y', strtotime(date('d-m-Y'). ' + 1 days'))}}" placeholder="dd-mm-yyyy" class="form-control border-right-0 flight1_date_datetimepicker_class" data-format="dd-MM-yyyy"> -->
                            <input type="text" name="flight1_date"  id="flight1_date" value="" placeholder="dd-mm-yyyy" class="form-control border-right-0 flight1_date_datetimepicker_class" data-format="dd-MM-yyyy">
                            <div class="input-group-append add-on flight1_date_datetimepicker_class">
                            <span class="input-group-text bg-white pl-0 flight1_date_datetimepicker_class"><i class="lar la-calendar-alt flight1_date_datetimepicker_class"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <span class="input-group-text" id="crossIcon_flight2" style="cursor: pointer;"><i class="las la-times"></i></span>
                </div>
            </div>
            <div class="row" id="3rdFlight" data-show-value="0">
                <div class="col-md-2">
                    <h6 class="text-uppercase text-muted">Flight 3</h6>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>From</label>
                        <input type="text" name="from3" id="from3" placeholder="(IXC) | Chandigarh Airport" class="form-control search_input">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>To</label>
                        <input type="text" name="to3" id="to3"  placeholder="(BOM) | Chhatrapati Shivaji Int'l Airport" class="form-control search_input">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date</label>
                        <div id="flight2_date_datetimepicker" class="input-group flight2_date_datetimepicker_class">
                            <input type="text" name="flight2_date" id="flight2_date" value=""  placeholder="dd-mm-yyyy" class="form-control border-right-0 flight2_date_datetimepicker_class" data-format="dd-MM-yyyy">
                            <div class="input-group-append add-on flight2_date_datetimepicker_class">
                            <span class="input-group-text bg-white pl-0 flight2_date_datetimepicker_class"><i class="lar la-calendar-alt flight2_date_datetimepicker_class"></i></span>
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
                <div class="col-md col-6">
                    <div class="form-group">
                        <label>Children <small>(2-15 yrs)</small></label>
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
                <div class="col-md col-6">
                    <div class="form-group">
                        <label>Infant <small>(0-23 mths)</small></label>
                        <select name="infant" id="infant" class="custom-select">
                            <option selected>0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
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

<div class="middle bg-white">
    <div class="container my-4">
        <div class="row cld__bes__wrap">
            <div class="col-md-4">
                <div class="card">
                    <div class="media align-items-center">
                        <div class="media-left mr-3"><img src="{{ asset('public/images/best-price.png')}}" alt="best price" class="img-fluid"/></div>
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
                        <div class="media-left mr-3"><img src="{{ asset('public/images/easy-booking.png')}}" alt="easy booking"/></div>
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
                        <div class="media-left mr-3"><img src="{{ asset('public/images/support.png')}}" alt="support"/></div>
                        <div class="media-body">
                            <h5>24/7 Customer support</h5>
                            <p>Receive free support from our friendly and reliable team.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 


    <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt-5">
                    <h3 class="font-weight-light h1 mb-1">Best <span class="font-weight-bold">offers for you!</span></h3>
                    <p>Discover a different world…</p>
                </div>
                <div class="col-md-12 mt-2">
                    <div id="cld__home__discount__banner" class="owl-carousel owl-theme cld__home__discount__banner owl__control__top">
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount1.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount2.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount3.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount4.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount1.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount2.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount3.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                        <div class="item"><a href="#"><img src="{{ asset('public/images/discount4.jpg')}}" alt="discount1" class="img-fluid"/></a></div>
                    </div>
                </div>
            </div>
    </div>

    
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6">
                <a href="#"><img src="{{ asset('public/images/Landing-page-banner-mobile.jpg')}}" alt="" class="img-fluid"/></a>
            </div>
            <div class="col-md-6">
                <a href="#"><img src="{{ asset('public/images/SME_Desktop-Landingpage-mobile-banner.jpg')}}" alt="" class="img-fluid"/></a>
            </div>
        </div>
    </div>

   
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css" />
@endsection
@section('script')

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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> -->
<script type="text/javascript">
    $( document ).ready(function() {
        // start show anather flights
        $('#2rdFlight').hide();
        $('#3rdFlight').hide();
        // $('#4rdFlight').hide();
        // $('#5rdFlight').hide();
        // $('#6rdFlight').hide();
        // end show anather flights

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

        // jQuery('#flight0_date_datetimepicker').datetimepicker({
        //     pickTime: false,
        //     autoclose: true, 
        //     startDate: new Date(),
        //     todayHighlight: true,
        //     autoclose: true,
        // });
        // flight0_date_datetimepicker_class
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
        
        //  click on add anathor flight
        $('#addFlight').click(function(){
            // alert("hii");
            var attr_2rdFlight=$("#2rdFlight").attr("data-show-value");
            // var attr_5rdFlight=$("#5rdFlight").attr("data-show-value");
            // var attr_6rdFlight=$("#6rdFlight").attr("data-show-value");
            // alert(attr_4rdFlight)
            // if(attr_4rdFlight==0)
                $('#2rdFlight').show();
                $("#2rdFlight").attr("data-show-value", "1");
                // to3
                var to3_val=$('#to1').val();
                if(to3_val!=''){
                    // from4
                    $('#from2').val('');
                    $('#from2').val(to3_val);
                }
            // }
            if(attr_2rdFlight==1){
                $('#3rdFlight').show();
                $("#3rdFlight").attr("data-show-value", "1");
                // crossIcon_flight3
                $('#crossIcon_flight2').hide();
                var to4_val=$('#to4').val();
                if(to4_val!=''){
                    // from4
                    $('#from5').val('');
                    $('#from5').val(to4_val);
                }
                $('#addFlight').hide();
                
            }
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

        $('#crossIcon_flight2').click(function(){
            // alert('hii');
            $('#2rdFlight').hide();
            $("#2rdFlight").attr("data-show-value", "0");
            $('#from2').val('');
            $('#to2').val('');
            $('#flight1_date').val('');
            // $('#crossIcon_flight2').show();
        });

        $('#crossIcon_flight3').click(function(){
            // alert('hii');
            $('#3rdFlight').hide();
            $("#3rdFlight").attr("data-show-value", "0");
            $('#from3').val('');
            $('#to3').val('');
            $('#flight2_date').val('');
            $('#crossIcon_flight2').show();
            $('#addFlight').show();
        });
        // $('#crossIcon_flight4').click(function(){
        //     // alert('hii');
        //     $('#5rdFlight').hide();
        //     $("#5rdFlight").attr("data-show-value", "0");
        //     $('#from5').val('');
        //     $('#to5').val('');
        //     $('#flight4_date').val('');
        //     $('#crossIcon_flight3').show();
        // });
        // $('#crossIcon_flight3').click(function(){
        //     // alert('hii');
        //     $('#4rdFlight').hide();
        //     $("#4rdFlight").attr("data-show-value", "0");
        //     $('#from4').val('');
        //     $('#to4').val('');
        //     $('#flight3_date').val('');
        //     $('#crossIcon_flight2').show();
        // });
        

        // select flight to add value automatic select from value 
        // $('#to1').on('change',function(){
        //     // alert("hii");
        //     var to1_val=$('#to1').val();
        //     // alert(to1_val);
        //     // $('#from2').val('');
        //     // $('#from2').val(to1_val);
        //     $("#from2").typeahead('val', '')
        //     $("#from2").typeahead('val',to1_val);
        // });
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
        // $('#to2').change(function(){
        //     // alert("hii");
        //     var val=$('#to2').val();
        //     // alert(val);
        //     var from2_val=$('#from2').val();
        //     if(from2_val==''){
        //     $('#from3').val();
        //     $('#from3').val(val);
        //     // $("#from3").typeahead('val', '')
        //     // $("#from3").focus().typeahead('val',from2_val).focus();
        //     }
        //     // $("#from3").removeAttr('value');
        //     // $("#from3").attr('value',val);
        // });
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


        // add another flights
        // $('#addFlight').click(function(){
        //     alert("hii");
        //     // var val='';
        //     $("#3rdFlight").insertAfter();
        // });


    });


    function blankCheck(blankval){
        $.confirm ( {
            title: false,
            content: blankval,
            animation: 'scale',
            type: 'blue',
            opacity: 0.5,
            buttons: {
                'confirm': {
                    text: 'Ok',
                    btnClass: 'btn-orange',
                }
            }
        });
    }
    
</script>
@endsection