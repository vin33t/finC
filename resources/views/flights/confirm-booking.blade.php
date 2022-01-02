@extends('common.master')
@section('content')
   

<section class="search-packages bg-light-gray py-4" id="">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <ul class="confirmation-step">
                    <li><a href="#" class="active"><span>1</span> Flight Details</a></li>
                    <li><a href="#" class="active"><span>2</span> Passenger Details</a></li>
                    <li><a href="#" class="active"><span>3</span> Payment</a></li>
                    <li><a href="#" class="active"><span>4</span> Confirm</a></li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="card align-items-center">
                    @if(isset($unidata))
                    @if(count($unidata)>0)
                    <img src="{{ asset('public/images/done.gif') }}" alt="done" style="width:120px;" class="img-fluid m-auto" />
                    <h1 class="font-weight-600 mt-4">Thank You</h1>
                    <h4>You successfully created your booking</h4>
                    @else
                    <img src="{{ asset('public/images/fail.png') }}" alt="failed" style="width:120px;" class="img-fluid m-auto" />
                    <h1 class="font-weight-600 mt-4">Booking Failed</h1>
                    <h4>Booking Failed</h4>
                    @endif
                    @elseif(isset($return_unidata))
                    @if(count($return_unidata)>0)
                    <img src="{{ asset('public/images/done.gif') }}" alt="done" style="width:120px;" class="img-fluid m-auto" />
                    <h1 class="font-weight-600 mt-4">Thank You</h1>
                    <h4>You successfully created your booking</h4>
                    @else
                    <img src="{{ asset('public/images/fail.png') }}" alt="failed" style="width:120px;" class="img-fluid m-auto" />
                    <h1 class="font-weight-600 mt-4">Booking Failed</h1>
                    <h4>Booking Failed</h4>
                    @endif
                    @endif
                    <section class="content" id="sectionDiv">
                        <div class="outer-div">
                            <div class="container outer-div-inner">
                                <div class="row"
                                    style="border-bottom:2px solid #797777;padding-bottom:10px;margin-bottom:10px;">

                        <div class="col-md-12">
                            <table width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <th scope="col"><img src="{{ asset('public/images/logo.png') }}" alt="logo" class="img-fluid img-responsive"></th>
                                        <th scope="col"><img src="{{ asset('public/images/logo.png') }}" alt="logo" class="img-fluid img-responsive" align="right">
                                        </th>
                                    </tr>
                       </tbody>
                                        </table>
                                    </div>

                                    <!-- <div class="col-md-12">
                       <img src="https://www.cloudtravels.co.uk/software/public/images/logo.png') }}" alt="logo" class="img-fluid img-responsive"/>
                         </div> -->
                                </div>
                                @if(isset($unidata))
                                @if(count($unidata)>0)
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
                                                <td><b>Invoice No &nbsp;&nbsp;&nbsp;: </b></td>
                                                <td class="text-left"> &nbsp;{{isset($invoice_no)?$invoice_no:''}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Client ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> </td>
                                                <td class="text-left">&nbsp;{{isset($unique_id)?$unique_id:''}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-8 col-6">
                                        <h3>To</h3>
                                        <!-- {{print_r($unidata[0])}} -->
                                        @foreach($unidata[0] as $data)
                                        <!-- {{print_r($data)}} -->
                                        <p>{{$data[0]['First']}} {{$data[0]['Last']}}<br>
                                        {{$data[0]['Address']}}<br>{{isset($data[0]['Street'])?$data[0]['Street']:''}} <br>{{$data[0]['City']}}<br>{{$data[0]['State']}}<br>{{$searched->Country}}<br>{{$data[0]['PostalCode']}}<br>
                                            <b>TEL:</b>{{$data[0]['Number']}}
                                        @endforeach
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
                                        <h2 class="p-3 bg-light-blue d-inline-block text-white">Flight</h2>

                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"><b>1. Passenger Details</b></h4>

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
                                                    
                                                    @foreach($unidata[0] as $data1)
                                                    <?php $count=1;?>
                                                    @foreach($data1 as $data)
                                                    <tr>
                                                        <td>{{$count++}}</td>
                                                        <td>{{$data['TravelerType']}}</td>
                                                        <td>{{$data['First']}}</td>
                                                        <td>{{$data['Last']}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <p>Note - * denotes the lead passenger</p><br>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <h4 class="mt-3"><b>FLIGHT DETAILS (ONE WAY)</b></h4>
                                        <p>
                                            <!-- AIRLINE REF: AI
                                            YSYH4 &nbsp;&nbsp;
                                            <span class="noprint">
                                                | &nbsp;
                                            </span>
                                            <span id="printOnly">
                                                | &nbsp;
                                            </span>

                                            | -->
                                            PNR : {{$unidata[3]['UniversalRecord']['LocatorCode']}} | &nbsp;&nbsp;UN PNR : {{$airreservation['UniversalRecord']}} &nbsp;&nbsp; | &nbsp;&nbsp;
                                            BOOKING DATE :{{date('d/m/Y')}}
                                        </p>



                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <thead class="table-primary">
                                                    <tr class="invoice-table">
                                                        <th>Airline</th>
                                                        <th>Departure</th>
                                                        <th>Arrival</th>

                                                        <th>Class</th>
                                                        <th>Baggage</th>
                                                        <th>Duration</th>
                                                        <th>Stops</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($unidata[1] as $datas1)
                                                    @foreach($datas1 as $datas)
                                                    <!-- {{print_r($datas)}} -->
                                                    <tr>
                                                        <td>{{$datas['Carrier']}}
                                                            <br>
                                                            FLIGHT NO :- {{$datas['Carrier'].$datas['FlightNumber']}}
                                                        </td>
                                                        <td>{{$datas['Origin']}}<br>
                                                            <!-- United Kingdom <br> -->

                                                            {{$datas['DepartureTime']}}<br>
                                                            TERMINAL :- {{isset($datas['OriginTerminal'])?$datas['OriginTerminal']:'*'}}
                                                        </td>
                                                        <td>{{$datas['Destination']}}<br>
                                                            <!-- india<br> -->
                                                            {{$datas['ArrivalTime']}}<br>
                                                            TERMINAL :- {{isset($datas['DestinationTerminal'])?$datas['DestinationTerminal']:'*'}}
                                                        </td>
                                                        <td>{{$datas['CabinClass']}}</td>
                                                        <td></td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <h4 class="mt-3"> <b class="float-right"><b>Total: </b>
                                        <span class="text-light-blue">£
                                            
                                            <?php 
                                            $var_tot=0;
                                            foreach($unidata[2] as $datas){
                                                $var_tot+=(str_replace('GBP','',$datas[0]['TotalPrice'])*$searched->adults);
                                                if(isset($datas[1])){
                                                $var_tot+=(str_replace('GBP','',$datas[1]['TotalPrice'])*$searched->children);
                                                }
                                                if(isset($datas[2])){
                                                $var_tot+=(str_replace('GBP','',$datas[2]['TotalPrice'])*$searched->infant);
                                                }
                                            }
                                            echo number_format($var_tot,2);
                                            ?>
                                                    </span></b></h4>
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

                                                <?php 
                                            $var_tot=0;
                                            foreach($unidata[2] as $datas){
                                                $var_tot+=(str_replace('GBP','',$datas[0]['TotalPrice'])*$searched->adults);
                                                if(isset($datas[1])){
                                                $var_tot+=(str_replace('GBP','',$datas[1]['TotalPrice'])*$searched->children);
                                                }
                                                if(isset($datas[2])){
                                                $var_tot+=(str_replace('GBP','',$datas[2]['TotalPrice'])*$searched->infant);
                                                }
                                            }
                                            echo number_format($var_tot,2);
                                            ?>
                                                </p>
                                            </div>

                                        </div>
                                        <!-- <div class="w-100">
                                            <div class="" style="display:inline-block;margin-right:30px;">
                                                <p class="mb-1"><b>Balance Due:</b></p>
                                            </div>
                                            <div class="" style="display:inline-block;">
                                                £ <?php 
                                            $var_tot=0;
                                            foreach($unidata[2] as $datas){
                                                $var_tot+=(str_replace('GBP','',$datas[0]['TotalPrice'])*$searched->adults);
                                                if(isset($datas[1])){
                                                $var_tot+=(str_replace('GBP','',$datas[1]['TotalPrice'])*$searched->children);
                                                }
                                                if(isset($datas[2])){
                                                $var_tot+=(str_replace('GBP','',$datas[2]['TotalPrice'])*$searched->infant);
                                                }
                                            }
                                            echo number_format($var_tot,2);
                                            ?> </div>
                                        </div> -->


                                    </div>

                                </div>
                                <hr>
                                @endif
                                @elseif(isset($return_unidata))
                                @if(count($return_unidata)>0)
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
                                                <td><b>Invoice No &nbsp;&nbsp;&nbsp;: </b></td>
                                                <td class="text-left"> &nbsp;{{isset($invoice_no)?$invoice_no:''}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Client ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b> </td>
                                                <td class="text-left">&nbsp;{{isset($unique_id)?$unique_id:''}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-8 col-6">
                                        <h3>To</h3>
                                        @foreach($return_unidata[0] as $data)
                                        <!-- {{print_r($data)}} -->
                                        <p>{{$data[0]['First']}} {{$data[0]['Last']}}<br>
                                        {{$data[0]['Address']}}<br>{{isset($data[0]['Street'])?$data[0]['Street']:''}} <br>{{$data[0]['City']}}<br>{{$data[0]['State']}}<br>{{$return_searched->Country}}<br>{{$data[0]['PostalCode']}}<br>
                                            <b>TEL:</b>{{$data[0]['Number']}}
                                        @endforeach
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
                                        <h2 class="p-3 bg-light-blue d-inline-block text-white">Flight</h2>

                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="mt-3"><b>1. Passenger Details</b></h4>

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
                                                    
                                                    @foreach($return_unidata[0] as $data11)
                                                    <?php $count=1;?>
                                                    @foreach($data11 as $data)
                                                    <tr>
                                                        <td>{{$count++}}</td>
                                                        <td>{{$data['TravelerType']}}</td>
                                                        <td>{{$data['First']}}</td>
                                                        <td>{{$data['Last']}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <p>Note - * denotes the lead passenger</p><br>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <h4 class="mt-3"><b>FLIGHT DETAILS (ROUND TRIP)</b></h4>
                                        <p>
                                            <!-- AIRLINE REF: AI
                                            YSYH4 &nbsp;&nbsp;
                                            <span class="noprint">
                                                | &nbsp;
                                            </span>
                                            <span id="printOnly">
                                                | &nbsp;
                                            </span>

                                            | -->
                                            PNR : {{$return_unidata[3]['UniversalRecord']['LocatorCode']}} | &nbsp;&nbsp;UN PNR : {{$return_airreservation['UniversalRecord']}} &nbsp;&nbsp; | &nbsp;&nbsp;
                                            BOOKING DATE :{{date('d/m/Y')}}
                                        </p>



                                    </div>
                                    <!-- <div class="col-md-12">
                                        <h3>Outbound Journey</h3>
                                    </div> -->
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <thead class="table-primary">
                                                    <tr class="invoice-table">
                                                        <th>Airline</th>
                                                        <th>Departure</th>
                                                        <th>Arrival</th>

                                                        <th>Class</th>
                                                        <th>Baggage</th>
                                                        <th>Duration</th>
                                                        <th>Stops</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($return_unidata[1] as $datas1)
                                                    @foreach($datas1 as $datas)
                                                    <!-- {{print_r($datas)}} -->
                                                    <tr>
                                                        <td>{{$datas['Carrier']}}
                                                            <br>
                                                            FLIGHT NO :- {{$datas['Carrier'].$datas['FlightNumber']}}
                                                        </td>
                                                        <td>{{$datas['Origin']}}<br>
                                                            <!-- United Kingdom <br> -->

                                                            {{$datas['DepartureTime']}}<br>
                                                            TERMINAL :- {{isset($datas['OriginTerminal'])?$datas['OriginTerminal']:'*'}}
                                                        </td>
                                                        <td>{{$datas['Destination']}}<br>
                                                            <!-- india<br> -->
                                                            {{$datas['ArrivalTime']}}<br>
                                                            TERMINAL :- {{isset($datas['DestinationTerminal'])?$datas['DestinationTerminal']:'*'}}
                                                        </td>
                                                        <td>{{$datas['CabinClass']}}</td>
                                                        <td></td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12">
                                        <h3>Inbound Journey</h3>
                                    </div> -->
                                   

                                    <div class="col-md-12">
                                        <h4 class="mt-3"> <b class="float-right"><b>Total: </b>
                                        <span class="text-light-blue">£
                                        <?php 
                                            $var_tot=0;
                                            foreach($return_unidata[2] as $datas){
                                                $var_tot+=(str_replace('GBP','',$datas[0]['TotalPrice'])*$return_searched->adults);
                                                if(isset($datas[1])){
                                                $var_tot+=(str_replace('GBP','',$datas[1]['TotalPrice'])*$return_searched->children);
                                                }
                                                if(isset($datas[2])){
                                                $var_tot+=(str_replace('GBP','',$datas[2]['TotalPrice'])*$return_searched->infant);
                                                }
                                            }
                                            echo number_format($var_tot,2);
                                            ?>
                                                    </span></b></h4>
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

                                                <?php 
                                            $var_tot=0;
                                            foreach($return_unidata[2] as $datas){
                                                $var_tot+=(str_replace('GBP','',$datas[0]['TotalPrice'])*$return_searched->adults);
                                                if(isset($datas[1])){
                                                $var_tot+=(str_replace('GBP','',$datas[1]['TotalPrice'])*$return_searched->children);
                                                }
                                                if(isset($datas[2])){
                                                $var_tot+=(str_replace('GBP','',$datas[2]['TotalPrice'])*$return_searched->infant);
                                                }
                                            }
                                            echo number_format($var_tot,2);
                                            ?>
                                                </p>
                                            </div>

                                        </div>
                                        <!-- <div class="w-100">
                                            <div class="" style="display:inline-block;margin-right:30px;">
                                                <p class="mb-1"><b>Balance Due:</b></p>
                                            </div>
                                            <div class="" style="display:inline-block;">
                                                £ <?php 
                                            $var_tot=0;
                                            foreach($return_unidata[2] as $datas){
                                                $var_tot+=(str_replace('GBP','',$datas[0]['TotalPrice'])*$return_searched->adults);
                                                if(isset($datas[1])){
                                                $var_tot+=(str_replace('GBP','',$datas[1]['TotalPrice'])*$return_searched->children);
                                                }
                                                if(isset($datas[2])){
                                                $var_tot+=(str_replace('GBP','',$datas[2]['TotalPrice'])*$return_searched->infant);
                                                }
                                            }
                                            echo number_format($var_tot,2);
                                            ?> </div>
                                        </div> -->


                                    </div>

                                </div>
                                <hr>
                                @endif
                                @endif
                                <br>
                                <div class="row">
                                    <div class="col-md-12">


                                    </div>

                                    <div class="col-md-12">


                                        <div class="col-md-12 pagebreak">
                                            <p>Terms and Conditions<br />
                                                <span class="style1"><strong>Notes:</strong></span>
                                            </p>
                                            <ul type="disc">
                                                <li class="style1"><strong>This sale is covered by ATOL number
                                                        11867.</strong>&nbsp;&nbsp; </li>
                                            </ul>
                                            <ul>
                                                <li>There is no liability if airline(s) above cease to trade, unless
                                                    Scheduled Airline Failure Insurance (SAFI) has been paid. </li>
                                                <li>Passengers travelling to/ or via USA/CANADA: will require an ESTA at
                                                    least 72 hours prior to travel, even for transit purposes.</li>
                                                <li>Children under 18 travelling to South Africa and Botswana: All
                                                    minors travelling will be required to carry certified copies Birth
                                                    Certificate, and if only one parent is travelling, certified written
                                                    consent from the other parent to allow the child to travel.</li>
                                                <li>If there are any long (or overnight transits), include multiple
                                                    transit points in route within a country, it is the
                                                    passenger&rsquo;s responsibility to make the necessary accommodation
                                                    and visa arrangements.</li>
                                                <li><strong><span class="style1">Foreign &amp; Commonwealth Office
                                                            Travel Advice:</span>&nbsp;</strong>The Foreign &amp;
                                                    Commonwealth Office (FCO) issues travel advice on destinations,
                                                    which include information on passports, visas, health, safety and
                                                    security and more. For more information refer to the link: <a
                                                        href="https://www.gov.uk/foreign-travel-advice">https://www.gov.uk/foreign-travel-advice</a>
                                                    New Security&nbsp;<span class="style1"><strong>Requirements For
                                                            Airlines:</strong></span>&nbsp;Phones, laptops and tablets
                                                    larger than 16.0cm x 9.3cm x 1.5cm not allowed in the cabin on
                                                    flights to the UK from Turkey, Lebanon, Egypt, Saudi Arabia, Jordan
                                                    and Tunisia. For more information please see <a
                                                        href="https://www.gov.uk/government/news/additional-hand-luggage-restrictions-on-some-flights-to-the-uk">https://www.gov.uk/government/news/additional-hand-luggage-restrictions-on-some-flights-to-the-uk</a>
                                                </li>
                                            </ul>
                                            <p><span class="style1"><strong>Notes:</strong></span><br />
 Reconfirmation of any onward / return journey is passengers&rsquo;responsibility.<br />
Valid travel documentation such as valid passport, visa, and health precautions are passengers&rsquo; responsibility.<br />
Timings are subject to change, please reconfirming with your airline operator before you fly.<br />
    Any reissue / revalidation / cancellation will incur a fee. Any
    passengers under 18 years on age travelling to South Africa will be
    denied boarding if not carrying their original birth certificate. Any
    passengers who hold an OCI who travel to INDIA without their original
    OCI card will be denied boarding.<br />
    <span class="style1"><strong>Your Financial
                                                        Protection</strong></span><br />
     When you buy an ATOL protected fight or flight inclusive holiday from us
    you will receive an ATOL Certificate. This lists what is financially
    protected, where you can get information on what this means for you and
    who to contact is things go wrong.<br>
    <strong>Travelling against the FCO&rsquo;s advice</strong>
    <p>Critically, you may invalidate your insurance cover, including healthcare
    protections, or be unable to obtain it, if you&rsquo;ve not yet bought
     any.<br /></p>
    So, call your insurer/check the wording of your insurance policy if
    you&rsquo;re planning to take this risk.
    If you get ill while you&rsquo;re travelling, you may not be able to get the
    treatment you need &ndash; or treatment may end up being very delayed and
                                            incredibly costly.<br />
                                            Expect disruption to your travel arrangements, both:</p>
                                            <ul type="disc">
                                                <li>while you&rsquo;re in-country (many countries are operating Covid-19
                                                    screening procedures as a condition of entry and, in some cases,
                                                    quarantine measures preventing you from any contact with local
                                                    resident at your destination)</li>
                                                <li>on your return, including the risk that you may not be able to get
                                                    back home if borders close and/or that you may face quarantine and
                                                    self-isolation obligations when you get back. This will mean being
                                                    away from your workplace, school/place of study and ensuring you
                                                    have no social interactions for that period of quarantine</li>
                                            </ul>
                                            <p><span class="style1"><strong>Passenger Notice:</strong></span><br />
                                                Carriage and other services provided by the carrier are subject to
                                                conditions of contract, which are hereby incorporated by reference.
                                                These conditions may be obtained from the issuing carrier. The
                                                itinerary/receipt constitutes the passenger ticket for the purposes of
                                                Article 3 of the Warsaw convention, except where the carrier delivers to
                                                the passenger another document complying with the requirements of
                                                Article 3. If the passenger's journey involves an ultimate destination
                                                or stop in a country other than the country of departure the Warsaw
                                                Convention may be applicable, and the convention governs, and in most
                                                cases limits, the liability of carriers for death or personal injury and
                                                in respect of loss of or damage to baggage. See also notices headed
                                                Advice to International Passengers on limitation of liability and notice
                                                of baggage liability limitations. Full conditions can be found at <a
                                                    href="www.iata.org">www.iata.org</a>
                                                If you are travelling to USA, all qualified Visa Waiver Program
                                                travellers will be required to obtain electronic travel authorization
                                                prior to boarding an air or sea carrier to the United States.<br />
                                                Electronic System for Travel Authorization (ESTA) to USA<br />
                                                Travellers who do not receive travel authorization prior to their
                                                departure may be denied boarding, experience delays or be denied
                                                admission into the United States. Applications may be submitted at any
                                                time prior to travel, but no less than 72 hours prior to
                                                departure.<br />
                                                Travel Authorization is obtained through an online registration system
                                                known as the Electronic System for&nbsp;<span
                                                    class="style1"><strong>Travel Authorization
                                                        (ESTA).</strong></span><br />
                                                If your registration is successful, it will be valid for multiple
                                                applications for two years or until the date on which your passport
                                                expires, whichever comes first.<br />
                                                Submit your ESTA Application at <a
                                                    href="www.iata.org">www.iata.org</a><br />
                                                <br />
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


                                            <!---------------------------------------------------------------------------------------------------------->
    <!--   <img src="https://www.cloudtravels.co.uk/software/public/images/atol_logo_final.png') }}" src="https://www.cloudtravels.co.uk/software/public/images/ico_final.png') }}" alt="logo" class="img-fluid img-responsive" align="right"/>
    <img src="https://www.cloudtravels.co.uk/software/public/images/footer.png') }}" alt="logo" class="img-fluid img-responsive" align="right"/>
            -->
             <!---------------------------------------------------------------------------------------------------------->
                                            </p>

                                            </li>
                                            </ul><hr>
                                            <div align="center">
                                        <span class="font-weight-bold text-primary">Book with Confidence</span>
                                            <img src="{{ asset('public/images/cards.png') }}" alt="" class="img-fluid"/><br>
                                            <span><span class="text-primary">Registered in England No.</span> 09677123</span>
                                            </div><br>
                                            <p align="center"> 
                                                <!-- <a href="javascript:void(0);" class="btn btn-success noprint" onclick="window.print()">Print Invoice</a> -->
                                                <a href="javascript:void(0);" class="btn btn-success noprint" onclick="printContent('sectionDiv');">Print Invoice</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>
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


@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();

        
    });
</script>
@endsection