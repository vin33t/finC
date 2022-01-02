<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Cloud Travels</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content=""/>
        <meta name="keywords" content=""/>
        <!--css start-->
        
        <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css"/>
        <!-- <link href="{{ asset('public/css/bootstrap-datepicker.css') }}" rel="stylesheet" type="text/css"/> -->
        @if(Route::currentRouteName()=='bookinghotels')
        @else
        <link href="{{ asset('public/css/light-carousel.css') }}" rel="stylesheet" type="text/css">
        @endif
        <link rel="shortcut icon" type="image/png" href="{{ asset('public/favicon.png') }}"/>
        <!-- font awsome -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <!-- css close-->

<!-- start adding development time -->
      <style>
        #loading {
          position: fixed;
          display: block;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
          text-align: center;
          opacity: 0.7;
          background-color: #fff;
          z-index: 99;
        }
        #loading_small {
          position: fixed;
          display: block;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
          text-align: center;
          opacity: 0.7;
          background-color: #fff;
          z-index: 99;
        }

        #loading-image {
          position: absolute;
          top: 100px;
          left: 549px;
          z-index: 100;
        }
      </style>
      <script src="https://code.jquery.com/jquery-3.3.0.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> 
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script> -->
  
        <script type="text/javascript">
            $.ajaxSetup ( {
                headers: {
                    'X-CSRF-TOKEN': $ ( 'meta[name="csrf-token"]' ).attr ( 'content' )
                }
            } );
        </script>
<!-- end adding development time -->

    </head>
    <body data-spy="scroll" data-target=".hotel-details-navbar" data-offset="130">
      <div id="loading">
      <img id="loading-image" src="{{ asset('public/loder.gif') }}" alt="Loading..." />
      </div>
      <div id="loading_small">
      </div>
        <section>
            @include('common.header')
            

            @yield('content')
            
            @include('common.footer')
<!-- The Modal -->
<div class="modal fade" id="baggage-and-fare">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Baggage and Fare Rules</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <!-- Modal body -->
    <div class="modal-body">
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="pill" href="#fare_details">Fare Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="pill" href="#baggage_rules">Baggage Rules</a>
        </li>
      </ul>
      <div class="tab-content row mt-3">
        <div id="fare_details" class="container tab-pane active">
          <table class="table table-bordered small">
            <tr>
              <td>Base Fare (1 Adult)</td>
              <td><i class="fas fa-rupee-sign"></i> 6,745</td>
            </tr>
            <tr>
              <td>Taxes and Fees (1 Adult)</td>
              <td><i class="fas fa-rupee-sign"></i> 1,806</td>
            </tr>
            <tr>
              <td>Total Fare (1 Adult)</td>
              <td><i class="fas fa-rupee-sign"></i> 8,551</td>
            </tr>
          </table>
        </div>
        <div id="baggage_rules" class="container tab-pane fade">
          <div class="media mb-3">
            <div class="media-left"><img src="{{ asset('public/images/6E.png') }}" alt="6E.png" style="width:50px;height:50px;" class="mr-2"/></div>
            <div class="media-body align-self-center">
              <h6 class="m-0">IXC-BLR <small class="text-muted">6E-491</small></h6>
            </div>
          </div>
          <table class="table table-bordered small">
            <tr>
              <td>Baggage Type</td>
              <td>Check-In</td>
              <td>Cabin</td>
            </tr>
            <tr>
              <td>Adult</td>
              <td>15 Kgs</td>
              <td>7 Kgs</td>
            </tr>
          </table>
          <small>The baggage information is just for reference. Please Check with airline before check-in. For more information, visit IndiGo Airlines Website.</small>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('public/js/popper.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('public/js/owl.carousel.min.js') }}"></script>
<!-- <script src="js/bootstrap-datepicker.js"></script> -->


<!-- <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script> -->
<script src="{{ asset('public/js/jquery.light-carousel.js') }}"></script>



<script>
$('.sample1').lightCarousel();
</script>
<script>
function traveller_selection() {
var x = document.getElementById("traveller_selection");
if (x.style.display === "none") {
x.style.display = "block";
} else {
x.style.display = "none";
}
}
function hotel_traveller_selection() {
var x = document.getElementById("hotel_traveller_selection");
if (x.style.display === "none") {
x.style.display = "block";
} else {
x.style.display = "none";
}
}
</script>
<script>
// Bootstrap tooltip enable 
$(document).ready(function(){
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
});

// Datepicker js
jQuery(function () {
      jQuery('#datetimepicker, #datetimepicker1').datetimepicker({
            pickTime: false,
            autoclose: true, 
            todayHighlight: true,
      });
});

// owl carousel js
$("#cld__home__discount__banner, #cld__travel__blog").each(function(){
    $(this).owlCarousel({
    loop:false,
    margin:20,
    nav:true,
    dots:false,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
});
});

$("#cld__holiday__destination__banner").each(function(){
    $(this).owlCarousel({
    loop:false,
    margin:20,
    nav:true,
    dots:false,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
});
});

$(document).ready(function(){
  $(".filter-open").click(function(){
    $(".filters_wrapper").toggleClass("active");
  });
  $(window).on('load', function () {
    $('#loading').hide();
    $('#loading_small').hide();
  });
});
</script>

<!-- start add some javascript -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<!-- <script src="{{ asset('public/js/typeahead.bundle.min.js') }}"></script> -->
<!-- end add some javascript -->
@yield('script')

</body>
</html>