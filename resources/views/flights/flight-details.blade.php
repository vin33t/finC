@extends('common.master')
@section('content')


<?php 
    $country_code=$per_flight_details->country_code;
    if($country_code==''){
        $country_code='GB'; 
    }
    $currency_code=DB::table('countries')->where('country_code',$country_code)->value('currency_code');
    $currency_symbal=DB::table('countries')->where('country_code',$country_code)->value('currency_symbal');
?>
<div class="middle">
    <section class="search-packages py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="confirmation-step">
                        <li><a href="#" class="active"><span>1</span> Flight Details</a></li>
                        <li><a href="#"><span>2</span> Passenger Details</a></li>
                        <li><a href="#"><span>3</span> Payment</a></li>
                        <li><a href="#"><span>4</span> Confirm</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <h4 class="font-weight-500">Ticket Details</h4><hr>
                        @if(isset($data))
                        @if(count($data)>0)
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$per_flight_details->addFrom}} - {{$per_flight_details->addTo}} <?php foreach($data[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                        <!-- <h6 class="mb-0"><i class="fas fa-plane"></i> Chandigarh - Bangalore Friday, 29 Nov 2019 -->
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a>
                        </h6>
                        @else
                        <h6 class="mb-0"><i class="fas fa-plane"></i> No flight Found 
                        @endif
                        <hr>
                        @if(count($data)>0)
                        @foreach($data[0] as $datas)
                        @for ($i=0; $i < count($datas); $i++)
                        @if($i>0)
                        <hr>
                            <div class="col-md-12 text-center my-2">
                            <span class="badge badge-pill badge-warning"><i class="far fa-clock"></i> {{$datas[$i]['Origin']}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['ArrivalTime']))->format('%Hh %Im')}} Layover</span><br>
                            <small> Re-Checkin your baggage</small>
                            </div>
                        <hr>
                        @endif
                        <!-- {{$datas[$i]['key']}} -->
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir{{$datas[$i]['Carrier']}}.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{$datas[$i]['Carrier']}}<br><small class="text-muted">{{$datas[$i]['Carrier']}}-{{$datas[$i]['FlightNumber']}}</small></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-departure h6"></i> {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->format('d M Y')}}</small>
                                <h6 class="font-weight-bold mb-0">{{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->format('H:i')}}</h6>
                                <span class="text-muted">{{$datas[$i]['Origin']}}</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="exchange-arrow exchange-relative m-auto"><i class="las la-long-arrow-alt-right"></i></span>
                                <h5 class="font-weight-600 mb-0 mt-2">{{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[$i]['ArrivalTime']))->format('%Hh %Im')}}</h5>
                                <!-- <small class="text-muted">Non stop</small> -->
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-arrival h6"></i> {{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('d M Y')}}</small>
                                <h6 class="font-weight-bold mb-0">{{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('H:i')}}</h6>
                                <span class="text-muted">{{$datas[$i]['Destination']}}</span>
                            </div>
                            <div class="col-md-3 text-center">
                            <!-- @if(count($datas)==1)<h3 class="font-weight-bold"><i class="las la-pound-sign"></i>{{str_replace('GBP','',$data[2]['price']['TotalPrice'])}}</h3>@endif -->
                            </div>
                        </div>
                        <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:''}} Check-In, {{ isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'' }} Cabin</p>
                        <!-- <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{str_replace('K','',isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:'')}} Check-In, {{str_replace('K','', isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'' )}} Cabin</p> -->
                        @endfor
                        @endforeach
                        
                        @endif
                        @endif

                      <!-- start return flights all details -->
                       
                        @if(isset($return_data))
                        <!-- <hr> -->
                        @if(count($return_data)>0)
                        @foreach($return_data[0] as $datas)
                        @for ($i=0; $i < count($datas); $i++)
                        @if($i>0 && $datas[$i]['Origin']!=str_replace(')','',explode('(',$per_flight_details->addTo)[1]))
                        <!-- {{$i}} -->
                        <!-- <hr> -->
                            <div class="col-md-12 text-center my-2">
                            <span class="badge badge-pill badge-warning"><i class="far fa-clock"></i> {{$datas[$i]['Origin']}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['ArrivalTime']))->format('%Hh %Im')}} Layover</span><br>
                            <small> Re-Checkin your baggage</small>
                            </div>
                        <hr>
                        @endif
                        @if($i==0)
                        <!-- <hr> -->
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$per_flight_details->addFrom}} - {{$per_flight_details->addTo}} <?php foreach($return_data[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                        <!-- <h6 class="mb-0"><i class="fas fa-plane"></i> Chandigarh - Bangalore Friday, 29 Nov 2019 -->
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a>
                        </h6>
                        <hr>
                        @endif
                        <!-- {{$datas[$i]['key']}} -->
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir{{$datas[$i]['Carrier']}}.gif" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">{{$datas[$i]['Carrier']}}<br><small class="text-muted">{{$datas[$i]['Carrier']}}-{{$datas[$i]['FlightNumber']}}</small></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-departure h6"></i> {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->format('d M Y')}}</small>
                                <h6 class="font-weight-bold mb-0">{{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->format('H:i')}}</h6>
                                <span class="text-muted">{{$datas[$i]['Origin']}}</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="exchange-arrow exchange-relative m-auto">
                                  @if($i==0)
                                  <i class="las la-long-arrow-alt-right"></i>
                                  @else
                                  @if($datas[$i]['Destination']==str_replace(')','',explode('(',$per_flight_details->addTo)[1]))
                                  <!-- {{$i}} -->
                                  <i class="las la-long-arrow-alt-right"></i>
                                  @else
                                  <i class="las la-long-arrow-alt-left"></i>
                                  @endif
                                  @endif
                                </span>
                                <h5 class="font-weight-600 mb-0 mt-2">{{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[$i]['ArrivalTime']))->format('%Hh %Im')}}</h5>
                                <!-- <small class="text-muted">Non stop</small> -->
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-arrival h6"></i> {{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('d M Y')}}</small>
                                <h6 class="font-weight-bold mb-0">{{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('H:i')}}</h6>
                                <span class="text-muted">{{$datas[$i]['Destination']}}</span>
                            </div>
                            <div class="col-md-3 text-center">
                            @if(count($datas)==1)<h3 class="font-weight-bold">{{$currency_symbal}}{{str_replace($currency_code,'',$return_data[2]['price']['TotalPrice'])}}</h3>@endif
                            </div>
                        </div>
                        <!-- <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{str_replace('K','', isset($return_data[1]['details']['baggageallowanceinfo'])?$return_data[1]['details']['baggageallowanceinfo']:'' )}} Check-In, {{str_replace('K','', isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'' )}} Cabin</p> -->
                        <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{isset($return_data[1]['details']['baggageallowanceinfo'])?$return_data[1]['details']['baggageallowanceinfo']:''}} Check-In, {{ isset($return_data[1]['details']['carryonallowanceinfo'])?$return_data[1]['details']['carryonallowanceinfo']:'' }} Cabin</p>
                        <hr>
                        @if($datas[$i]['Destination']==str_replace(')','',explode('(',$per_flight_details->addTo)[1]))
                        <!-- <hr> -->
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$per_flight_details->addTo}} - {{$per_flight_details->addFrom}} {{\Carbon\Carbon::parse($datas[$i+1]['DepartureTime'])->format('d M Y')}} <?php //foreach($return_data[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                        <!-- <h6 class="mb-0"><i class="fas fa-plane"></i> Chandigarh - Bangalore Friday, 29 Nov 2019 -->
                        <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a> -->
                        </h6>
                        <hr>
                        @endif
                        @endfor
                        @endforeach
                        @else
                        <h6 class="mb-0"><i class="fas fa-plane"></i> No flight Found 
                        @endif
                        @endif

                        <!-- <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="media">
                                    <div class="media-left"><img src="assets/images/6E.png" alt="6E.png" style="width:40px;height:40px;" class="mr-2"/></div>
                                    <div class="media-body align-self-center">
                                        <h6 class="m-0">IndiGo<br><small class="text-muted">6E-491</small></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-departure h6"></i> 07 March 2021</small>
                                <h6 class="font-weight-bold mb-0">10:45</h6>
                                <span class="text-muted">Chandigarh</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="exchange-arrow exchange-relative m-auto"><i class="las la-exchange-alt"></i></span>
                                <h5 class="font-weight-600 mb-0 mt-2">02 h 55 m</h5>
                                <small class="text-muted">Non stop</small>
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-arrival h6"></i> 07 March 2021</small>
                                <h6 class="font-weight-bold mb-0">13:40</h6>
                                <span class="text-muted">Mumbai</span>
                            </div>
                            <div class="col-md-3 text-center">
                                <h3 class="font-weight-bold"><i class="las la-pound-sign"></i>85.00</h3>
                            </div>
                        </div>
                        <p class="mt-3"><i class="las la-suitcase-rolling"></i> 15 Kgs Check-In, 7 Kgs Cabin</p> -->
                    </div>
                </div>
                @if(isset($return_data))
                @if(count($return_data)>0)
                <div class="col-md-3">
                  <div class="card">
                    <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                    <span class="text-muted">Travelers {{$per_flight_details->adults}} Adult</span>
                    <table class="table table-small mt-2">
                      @foreach($return_data[3] as $price)
                        @for($i=0;$i< count($price);$i++)
                        @if($i==0)
                        <!-- {{$price[$i]['ApproximateBasePrice']}} -->
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Adult</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->adults}} adult(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        @elseif($i==1)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Child</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->children}} child(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        @elseif($i==2)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Infant</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->infant}} infant(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->infant),2)}}</td>
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
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$return_data[2]['price']['TotalPrice'])),2)}}</td>
                        </tr>
                    </table>
                    <form action="{{ route('passengerDetails') }}" method="POST">
                                @csrf
                                @if(isset($data))
                                <input type="text" name="flight" value="{{$per_flight_details->flights}}" hidden>
                                <input type="text" name="flights" value="{{$data}}" hidden>
                                @endif
                                @if(isset($return_data))
                                <input type="text" name="flights_outbound" value="{{$per_flight_details->flights_outbound}}" hidden>
                                <input type="text" name="flights_inbound" value="{{$per_flight_details->flights_inbound}}" hidden>
                                <input type="text" name="return_flights" value="{{$return_data}}" hidden>
                                @endif
                                <input type="text" name="addFrom" value="{{ $per_flight_details->addFrom }}" hidden>
                                <input type="text" name="addTo" value="{{ $per_flight_details->addTo }}" hidden>
                                <input type="text" name="adults" value="{{ $per_flight_details->adults }}" hidden>
                                <input type="text" name="children" value="{{ $per_flight_details->children }}" hidden>
                                <input type="text" name="infant" value="{{ $per_flight_details->infant }}" hidden>
                                <input type="text" name="country_code" value="{{ $per_flight_details->country_code }}" hidden>
                      <button type="submit" class="btn btn-primary" onclick="showLoder();">Book Now</button>
                    </form>
                    <!-- <a href="{{route('passengerDetails')}}" class="btn btn-primary w-100">Book Now</a> -->
                  </div>
                </div>
                @endif
                @else
                @if(count($data)>0)
                <div class="col-md-3">
                  <div class="card">
                    <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                    <!-- <span class="text-muted">Travelers {{$per_flight_details->adults}} Adult</span> -->
                    <table class="table table-small mt-2">
                      @foreach($data[3] as $price)
                        @for($i=0;$i< count($price);$i++)
                        @if($i==0)
                        <!-- {{$price[$i]['ApproximateBasePrice']}} -->
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Adult</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->adults}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->adults}} adult(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->adults),2)}}</td>
                        </tr>
                        @elseif($i==1)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Child</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->children}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->children}} child(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->children),2)}}</td>
                        </tr>
                        @elseif($i==2)
                        <tr class="font-weight-bold bg-light">
                          <td>Passenger Type</td>
                          <td class="text-right">Infant</td>
                        </tr>
                        <tr>
                            <td>Base Fare x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['ApproximateBasePrice'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr>
                            <td>Taxes x {{$per_flight_details->infant}}</td>
                            <td class="text-right">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['Taxes'])*$per_flight_details->infant),2)}}</td>
                        </tr>
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Price {{$per_flight_details->infant}} infant(s)</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$price[$i]['TotalPrice'])*$per_flight_details->infant),2)}}</td>
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
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$data[2]['price']['TotalPrice'])),2)}}</td>
                        </tr>
                    </table>
                    <form action="{{ route('passengerDetails') }}" method="POST">
                                @csrf
                                <input type="text" name="flight" value="{{$per_flight_details->flights}}" hidden>
                                <input type="text" name="flights" value="{{$data}}" hidden>
                                <input type="text" name="addFrom" value="{{ $per_flight_details->addFrom }}" hidden>
                                <input type="text" name="addTo" value="{{ $per_flight_details->addTo }}" hidden>
                                <input type="text" name="adults" value="{{ $per_flight_details->adults }}" hidden>
                                <input type="text" name="children" value="{{ $per_flight_details->children }}" hidden>
                                <input type="text" name="infant" value="{{ $per_flight_details->infant }}" hidden>
                                <input type="text" name="country_code" value="{{ $per_flight_details->country_code }}" hidden>
                      <button type="submit" class="btn btn-primary" onclick="showLoder();">Book Now</button>
                    </form>
                    <!-- <a href="{{route('passengerDetails')}}" class="btn btn-primary w-100">Book Now</a> -->
                  </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </section>
</div>

<!-- The Modal -->
@if(isset($data))
@if(count($data)>0)
<div class="modal fade" id="baggageAndFare">
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
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$data[2]['price']['ApproximateBasePrice'])}}</td>
              </tr>
              <tr>
                <td>Taxes and Fees (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$data[2]['price']['Taxes'])}}</td>
              </tr>
              <tr>
                <td>Total Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$data[2]['price']['TotalPrice'])}}</td>
              </tr>
            </table>
          </div>
          <div id="baggage_rules" class="container tab-pane fade">
            <div class="media mb-3">
              <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php foreach($data[0] as $datas){echo $datas[0]['Carrier'];}?>.gif" alt="6E.png" style="width:50px;height:50px;" class="mr-2"/></div>
              <div class="media-body align-self-center">
                <h6 class="m-0"><?php foreach($data[0] as $datas){echo $datas[0]['Origin']."-".$datas[count($datas)-1]['Destination'];}?> <small class="text-muted"><?php foreach($data[0] as $datas){echo $datas[0]['Carrier']."-".$datas[0]['FlightNumber'];}?></small></h6>
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
                <!-- <td>{{str_replace('K','', isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:'' )}} </td>
                <td>{{str_replace('K','', isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'')}} </td> -->
                <td>{{ isset($data[1]['details']['baggageallowanceinfo'])?$data[1]['details']['baggageallowanceinfo']:'' }} </td>
                <td>{{isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:''}} </td>
              </tr>
            </table>
            <small>The baggage information is just for reference. Please Check with airline before check-in. For more information, visit IndiGo Airlines Website.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endif

<!-- return flight rules -->
@if(isset($return_data))
@if(count($return_data)>0)
<div class="modal fade" id="baggageAndFare">
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
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$return_data[2]['price']['ApproximateBasePrice'])}}</td>
              </tr>
              <tr>
                <td>Taxes and Fees (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$return_data[2]['price']['Taxes'])}}</td>
              </tr>
              <tr>
                <td>Total Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$return_data[2]['price']['TotalPrice'])}}</td>
              </tr>
            </table>
          </div>
          <div id="baggage_rules" class="container tab-pane fade">
            <!-- <div class="media mb-3">
              <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php foreach($return_data[0] as $datas){echo $datas[0]['Carrier'];}?>.gif" alt="6E.png" style="width:50px;height:50px;" class="mr-2"/></div>
              <div class="media-body align-self-center">
                <h6 class="m-0"><?php foreach($return_data[0] as $datas){echo $datas[0]['Origin']."-".$datas[count($datas)-1]['Destination'];}?> <small class="text-muted"><?php foreach($return_data[0] as $datas){echo $datas[0]['Carrier']."-".$datas[0]['FlightNumber'];}?></small></h6>
              </div>
            </div> -->
            <table class="table table-bordered small">
              <tr>
                <td>Baggage Type</td>
                <td>Check-In</td>
                <td>Cabin</td>
              </tr>
              <tr>
                <td>Adult</td>
                <!-- <td>{{str_replace('K','', isset($return_data[1]['details']['baggageallowanceinfo'])?$return_data[1]['details']['baggageallowanceinfo']:'' )}} </td>
                <td>{{str_replace('K','', isset($return_data[1]['details']['carryonallowanceinfo'])?$return_data[1]['details']['carryonallowanceinfo']:'')}} </td> -->
                <td>{{ isset($return_data[1]['details']['baggageallowanceinfo'])?$return_data[1]['details']['baggageallowanceinfo']:'' }} </td>
                <td>{{isset($return_data[1]['details']['carryonallowanceinfo'])?$return_data[1]['details']['carryonallowanceinfo']:''}} </td>
              </tr>
            </table>
            <small>The baggage information is just for reference. Please Check with airline before check-in. For more information, visit IndiGo Airlines Website.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endif

@endsection

@section('script')
<script>
    $( document ).ready(function() {
        $('#loading').hide();
        $('#loading_small').hide();
    });
</script>
@endsection
