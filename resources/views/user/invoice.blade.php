@extends('common.master')
@section('content')

<section class="search-packages bg-light-gray py-4">
    <div class="container-fluid">
        <div class="row">
            @if(count($invoice_data)>0)
            @foreach($invoice_data as $data)
            <div class="col-lg-12">
                <div class="card align-items-center">
                    
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
                                                <td class="text-left"> &nbsp;{{$data->booking_reference}}</td>
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
                                        <p>{{$data->leader_name}}<br>
                                        {{$data->add_1}} {{$data->add_2}}<br>{{$data->guest_city}}<br>{{$data->post_code}}<br>
                                            {{$data->country}}
                                            <br>
                                            <b>TEL:</b>{{$data->mobile}}
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <h3>Issued By</h3>
                                        <p>62 KING STREET,<br> SOUTHALL, <br>MIDDLESEX,<br> UB2 4DB<br>
                                            <b>TEL:</b> 02035000000<br>
                                            <b>E-MAIL</b> info@cloudtravels.co.uk
                                        </p>
                                    </div>
                                </div>
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
                                                        <!-- <th>Room No</th> -->
                                                        <th>First Name / Title</th>
                                                        <th>Last Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        // print_r($p);
                                                        $count=1;
                                                    ?>
                                                    @foreach($guest_details as $guest)
                                                    <tr>
                                                        <td>{{$count++}}</td>
                                                        <td>{{$guest->pax_type}}</td>
                                                        <!-- <td>{{"Room ".$guest->room_no}}</td> -->
                                                        <td>{{$guest->first_name}}</td>
                                                        <td>{{$guest->last_name}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <p>Note - * denotes the lead passenger</p><br>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"><b>HOTEL DETAILS </b></h4>
                                        <p>
                                            Booking Reference: {{$data->booking_reference}}
                                            <!-- <span class="noprint">
                                                | &nbsp;
                                            </span>
                                            <span id="printOnly">
                                                | &nbsp;
                                            </span>

                                            | PNR : 6C4ZKY | &nbsp;&nbsp;UN PNR :IBE10363947 &nbsp;&nbsp;  -->
                                            | &nbsp;&nbsp;
                                            BOOKING DATE : {{ \Carbon\Carbon::parse($data->booking_time)->format('d-m-Y H:i:s')}}
                                            &nbsp;&nbsp;
                                            | &nbsp;&nbsp; Booking Status : {{$data->booking_status}}
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
                                                        <th>No of Rooms</th>
                                                        <th>Number Adults</th>
                                                        <th>Number Children</th>

                                                        <!-- <th>Class</th>
                                                        <th>Baggage</th>
                                                        <th>Duration</th>
                                                        <th>Stops</th> -->

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$data->hotel_name}} 
                                                            <br>
                                                            City :- {{$data->city}}
                                                            <br>
                                                            HOTEL ID :- {{$data->hotel_id}}
                                                        </td>
                                                        <td>{{$data->room_name}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($data->check_in_date)->format('d-m-Y')}}<br>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($data->check_out_date)->format('d-m-Y')}}<br>
                                                        </td>
                                                        <td>{{$data->room_no}}</td>
                                                        <td>{{$data->num_adults}}</td>
                                                        <td>{{$data->num_children}}</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <h4 class="mt-3"> 
                                            <b class="float-right">
                                                <b>Room Charges (GST Extra): </b>
                                                <span class="text-light-blue"><?php 
                                                    echo $val=DB::table('hotel_currency')->where('currency',$data->currency)->value('icon');
                                                    echo " ";
                                                ?>{{ number_format($data->room_charges ,2) }}</span>
                                            </b>
                                        </h4>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"> 
                                            <b class="float-right">
                                                <b>GST on Room Charges: </b>
                                                <span class="text-light-blue"><?php 
                                                    echo $val=DB::table('hotel_currency')->where('currency',$data->currency)->value('icon');
                                                    echo " ";
                                                ?>{{ number_format($data->gst ,2) }}</span>
                                            </b>
                                        </h4>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"> 
                                            <b class="float-right">
                                                <b>Convenience Fees: </b>
                                                <span class="text-light-blue"><?php 
                                                    echo $val=DB::table('hotel_currency')->where('currency',$data->currency)->value('icon');
                                                    echo " ";
                                                ?>{{ number_format($data->convenience_fees ,2) }}</span>
                                            </b>
                                        </h4>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"> 
                                            <b class="float-right">
                                                <b>Taxes & Fees: </b>
                                                <span class="text-light-blue"><?php 
                                                    echo $val=DB::table('hotel_currency')->where('currency',$data->currency)->value('icon');
                                                    echo " ";
                                                ?>{{ number_format($data->taxes_and_fees,2) }}</span>
                                            </b>
                                        </h4>
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
                                                <p class="mb-1"> <?php 
                                                    echo $val=DB::table('hotel_currency')->where('currency',$data->currency)->value('icon');
                                                    echo " ";
                                                ?>

                                                {{number_format(($data->room_charges + $data->gst + $data->convenience_fees + $data->taxes_and_fees),2)}}
                                                </p>
                                            </div>

                                        </div>
                                        <div class="w-100">
                                            <div class="" style="display:inline-block;margin-right:30px;">
                                                <p class="mb-1"><b>Balance Due:</b></p>
                                            </div>
                                            <div class="" style="display:inline-block;">
                                            <?php 
                                                echo $val=DB::table('hotel_currency')->where('currency',$data->currency)->value('icon');
                                                echo " ";
                                            ?> {{number_format(($data->room_charges + $data->gst + $data->convenience_fees + $data->taxes_and_fees),2)}} </div>
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
                                            
                                           
                                            <p>
                                                <?php ?>

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
                   
                </div>
            </div>
            @endforeach
            @else
            <div class="col-lg-12">
                <div class="card align-items-center">
                    <b>Not found</b>
                </div>
            </div>
            @endif
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

@section('script')
<script>
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();
    });
</script>
@endsection