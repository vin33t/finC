@extends('common.master')
@section('content')


<section class="search-packages bg-light-gray py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="confirmation-step">
                    <li><a href="#" class="active"><span>1</span>  Hotel Details</a></li>
                    <li><a href="#" class="active"><span>2</span>  Guest Details</a></li>
                    <li><a href="#" class="active"><span>3</span> Payment</a></li>
                    <li><a href="#" class="active"><span>4</span> Confirm</a></li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="card align-items-center">
                    @if(count($bookdetails)>0)
                    <img src="{{ asset('public/images/done.gif')}}" alt="done" style="width:120px;" class="img-fluid m-auto" />
                    <h1 class="font-weight-600 mt-4">Thank You</h1>
                    <h4>You successfully created your booking</h4>
                    
                    <section class="content" id="sectionDiv">
                        <div class="outer-div">
                            <div class="container outer-div-inner">
                                <div class="row"
                                    style="border-bottom:2px solid #797777;padding-bottom:10px;margin-bottom:10px;">

                                    <div class="col-md-12">
                                        <table width="100%" border="0">
                                            <tbody>
                                                <tr>
                                                    <th scope="col"><img
                                                            src="{{ asset('public/images/logo.png') }}"
                                                            alt="logo" class="img-fluid img-responsive"></th>
                                                    <th scope="col"><img
                                                            src="{{ asset('public/images/logo.png') }}"
                                                            alt="logo" class="img-fluid img-responsive" align="right">
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                
                                </div>
                                <div class="row">
                                    <div class="col-md-4 responsive-center">

                                    </div>
                                    <div class="col-md-4 text-center responsive-center">
                                        <h1>Invoice</h1>
                                    </div>
                                    <div class="col-md-4 text-right responsive-center">
                                        <table class="m-0" align="right">
                                            <tr>
                                                <td><b>Invoice Date :</b> </td>
                                                <td class="text-left"> &nbsp;{{date('d M Y')}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Booking Reference &nbsp;&nbsp;&nbsp;: </b></td>
                                                <td class="text-left"> &nbsp;{{$bookdetails[0]['BookingReference']}}</td>
                                            </tr>
                                            <!-- <tr>
                                                <td><b>Client ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> </td>
                                                <td class="text-left">&nbsp;CLDC000169</td>
                                            </tr> -->
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-8 col-6">
                                        <h3>To</h3>
                                        <p>{{$bookdetails[0]['LeaderName']}}<br>
                                            {{$searched->add_1}} {{$searched->add_2}}<br>{{$searched->city}}<br>{{$searched->state}}<br>
                                            {{$searched->post_code}}<br><b>TEL:</b>{{$searched->contact_no}} 
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <h3>Issued By</h3>
                                        <p>62 KING STREET,<br> SOUTHALL, <br>MIDDLESEX,<br> UB2 4DB<br>
                                            <b>TEL:</b> 02035000000<br>
                                            <b>E-MAIL</b> info@cloudtravels.co.uk
                                        </p>
                                    </div>
                                </div>
                                <!-- {{$bookdetails[0]['LeaderName']}} -->
                                <div class="row hide_div1">
                                    <div class="col-md-12">
                                        <h2 class="p-3 bg-light-blue d-inline-block">Hotel</h2>

                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"><b> Guest Details</b></h4>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="table-primary">
                                                    <tr class="invoice-table">
                                                        <th>S#</th>
                                                        <th>Pax Type</th>
                                                        <th>First Name / Title</th>
                                                        <th>Last Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $p=explode(" ",$bookdetails[0]['LeaderName']);
                                                        // print_r($p);
                                                    ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>ADULT</td>
                                                        <td>{{$p[0]}}</td>
                                                        <td>{{$p[1]}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <p>Note - * denotes the lead passenger</p><br>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"><b>HOTEL DETAILS </b></h4>
                                        <p>
                                            Booking Reference: {{$bookdetails[0]['BookingReference']}}
                                            <!-- <span class="noprint">
                                                | &nbsp;
                                            </span>
                                            <span id="printOnly">
                                                | &nbsp;
                                            </span>

                                            | PNR : 6C4ZKY | &nbsp;&nbsp;UN PNR :IBE10363947 &nbsp;&nbsp;  -->
                                            | &nbsp;&nbsp;
                                            BOOKING DATE : {{ \Carbon\Carbon::parse($bookdetails[0]['BookingTime'])->format('d-m-Y H:i:s')}}
                                            &nbsp;&nbsp;
                                            | &nbsp;&nbsp; Booking Status : {{$bookdetails[0]['BookingStatus']}}
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <thead class="table-primary">
                                                    <tr class="invoice-table">
                                                        <th>Hotel</th>
                                                        <th>Room Name</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>

                                                        <!-- <th>Class</th>
                                                        <th>Baggage</th>
                                                        <th>Duration</th>
                                                        <th>Stops</th> -->

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$bookdetails[0]['HotelName']}} 
                                                            <br>
                                                            City :- {{$bookdetails[0]['City']}}
                                                            <br>
                                                            HOTEL ID :- {{$bookdetails[0]['HotelId']}}
                                                        </td>
                                                        <td>{{$bookdetails[0]['Rooms']['Room']['RoomName']}}</td>
                                                        <td>{{$bookdetails[0]['CheckInDate']}}<br>
                                                        </td>
                                                        <td>{{$bookdetails[0]['CheckOutDate']}}<br>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <h4 class="mt-3"> <b class="float-right"><b>Total: </b><span
                                                    class="text-light-blue">£{{$bookdetails[0]['TotalPrice']}}</span></b></h4>
                                    </div>
                                </div>

                                <br><br>
                                <div class="row">
                                    <div class="col-md-4">

                                    </div>
                                    <div class="col-md-8 text-right">
                                        <hr>
                                        <div class="w-100">
                                            <div class="" style="display:inline-block;margin-right:30px;">
                                                <p class="mb-1"><b>Total Amount:</b></p>
                                            </div>
                                            <div class="" style="display:inline-block;">
                                                <p class="mb-1"> £

                                                {{$bookdetails[0]['TotalPrice']}}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="w-100">
                                            <div class="" style="display:inline-block;margin-right:30px;">
                                                <p class="mb-1"><b>Balance Due:</b></p>
                                            </div>
                                            <div class="" style="display:inline-block;">
                                                £ {{$bookdetails[0]['TotalPrice']}} </div>
                                        </div>


                                    </div>

                                </div>
                                <hr><br>
                                <div class="row">
                                    <div class="col-md-12">


                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-12 pagebreak">
                                            <p>Terms and Conditions<br />
                                                <span class="style1"><strong>Notes:</strong></span>
                                            </p>
                                            <ul type="disc">
                                                <li class="style1"><strong>Cancellation Deadline: {{$bookdetails[0]['CancellationDeadline']}}</strong>&nbsp;&nbsp; </li>
                                            </ul>
                                            
                                           
                                            <p>
                                                <?php //echo $bookdetails[0]['Alerts']['Alert'];?>

                                                </br> </br> </br>
                                                <span class="style1"><strong>Note/Disclaimer: It is the sole
                                                        responsibility of the passenger to ensure his/her eligibility to
                                                        enter the destination country. Cloud Travel accepts no liability
                                                        in this regard. </strong><br />
                                                    <strong>
                                                        In case of Visa, Flight suspensions, cancellation or not
                                                        operating in that case we will apply for a full refund from
                                                        airline and we will only Deduct our Service charge and all other
                                                        ATOL/IATA protections, cash handling fee, administration charges
                                                        will be applied</strong></span>
                                            </p>
                                            <p align="right"><br />
                                                <br />
                                                <span class="style2">Yours Sincerely</span>
                                            </p>


                                           </p>

                                            </li>
                                            </ul><hr>
                                            <div align="center">
                                                <span class="font-weight-bold text-primary">Book with Confidence</span>
                                                <img src="{{ asset('public/images/cards.png')}}" alt="" class="img-fluid"/><br>
                                                <span><span class="text-primary">Registered in England No.</span> 09677123</span>
                                            </div><br>
                                            <p align="center"> 
                                                <!-- <a href="javascript:void(0);"
                                                    class="btn btn-success noprint" onclick="window.print()">Print
                                                    Invoice</a>  -->
                                                <a href="javascript:void(0);" class="btn btn-success noprint" onclick="printContent('sectionDiv');">Print Invoice</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>
                    @else
                    <img src="{{ asset('public/images/fail.png') }}" alt="failed" style="width:120px;" class="img-fluid m-auto" />
                    <h1 class="font-weight-600 mt-4">Booking Failed</h1>
                    <h4>Booking Failed</h4>
                    @endif
                    <!-- <small class="text-muted">Booking Ref id: 0CPNd09876fff</small><br>
                    <a href="index.php" class="btn btn-primary mt-4">Home</a> -->
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    function printContent(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endsection