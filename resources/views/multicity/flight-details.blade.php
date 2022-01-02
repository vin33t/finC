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
                        <h4 class="font-weight-500">Ticket Details</h4>
                        <!-- <hr> -->
                        
                        
                        


                        @if(isset($flights1))
                        <!-- <hr> -->
                        @if(count($flights1)>0)
                        @foreach($flights1[0] as $datas)
                        @for ($i=0; $i < count($datas); $i++)
                        @if(isset($searched->from3) && isset($searched->to3))
                          @if($i>0 && $datas[$i]['Origin']!=str_replace(')','',explode('(',$searched->from2)[1]) && $datas[$i]['Origin']!=str_replace(')','',explode('(',$searched->from3)[1]))
                          <div class="col-md-12 text-center my-2">
                              <span class="badge badge-pill badge-warning"><i class="far fa-clock"></i> {{$datas[$i]['Origin']}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['ArrivalTime']))->format('%Hh %Im')}} Layover</span><br>
                              <small> Re-Checkin your baggage</small>
                              </div>
                          <hr>
                          @endif
                        @else
                          @if($i>0 && $datas[$i]['Origin']!=str_replace(')','',explode('(',$searched->from2)[1]))
                          <!-- <hr> -->
                              <div class="col-md-12 text-center my-2">
                              <span class="badge badge-pill badge-warning"><i class="far fa-clock"></i> {{$datas[$i]['Origin']}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['ArrivalTime']))->format('%Hh %Im')}} Layover</span><br>
                              <small> Re-Checkin your baggage</small>
                              </div>
                          <hr>
                          @endif
                        @endif
                        @if($i==0)
                        <hr>
                        <h4 class="font-weight-500">FLIGHT 1</h4>
                        <hr>
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$searched->from1}} - {{$searched->to1}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->format('d M Y')}} <?php //foreach($flights1[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare1" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a>
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
                            @if(count($datas)==1)<h3 class="font-weight-bold">{{$currency_symbal}}{{str_replace($currency_code,'',$flights1[2]['price']['TotalPrice'])}}</h3>@endif
                            </div>
                        </div>
                        <!-- <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{str_replace('K','', isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' )}} Kgs Check-In, {{str_replace('K','', isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'' )}} Kgs Cabin</p> -->
                        <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{ isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' }} Check-In, {{ isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'' }} Cabin</p>
                        <hr>
                        @if(isset($searched->from2) && isset($searched->to2))
                        @if($datas[$i]['Destination']==str_replace(')','',explode('(',$searched->from2)[1]))
                        <h4 class="font-weight-500">FLIGHT 2</h4>
                        <hr>
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$searched->from2}} - {{$searched->to2}} {{\Carbon\Carbon::parse($datas[($i+1)]['DepartureTime'])->format('d M Y')}} <?php //foreach($flights1[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare2" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a>
                        </h6>
                        <hr>
                        @endif
                        @elseif(isset($searched->from3) && isset($searched->to3))
                        @if($datas[$i]['Destination']==str_replace(')','',explode('(',$searched->from3)[1]))
                        <h4 class="font-weight-500">FLIGHT 3</h4>
                        <hr>
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$searched->from3}} - {{$searched->to3}} {{\Carbon\Carbon::parse($datas[($i+1)]['DepartureTime'])->format('d M Y')}} <?php //foreach($flights1[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare3" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a>
                        </h6>
                        <hr>
                        @endif
                        @endif
                        @endfor
                        @endforeach
                        @else
                        <hr>
                        <h4 class="font-weight-500">No Flights Found</h4>
                        @endif
                        @endif

                    </div>
                </div>

                @if(count($flights1)>0)
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
                            <td class="text-right">{{$currency_symbal}}0.0</td>
                        </tr> -->
                        <tr class="font-weight-bold bg-light">
                            <td class="text-danger">Total Price</td>
                            <td class="text-right text-danger">{{$currency_symbal}}{{number_format((str_replace($currency_code,'',$flights1[2]['price']['TotalPrice'])),2)}}</td>
                        </tr>
                    </table>
                    <form action="{{ route('multicitypassengerDetails') }}" method="POST">
                        @csrf
                        <input type="text" name="flights1" value="{{json_encode($flights1)}}" hidden>
                        <input type="text" name="flights" value="{{json_encode($searched->flights1)}}" hidden>
                        <input type="text" name="flights2" value="{{json_encode($searched->flights2)}}" hidden>
                        <input type="text" name="flights3" value="{{json_encode($searched->flights3)}}" hidden>
                        <input type="text" name="adults" value="{{ $searched->adults }}" hidden>
                        <input type="text" name="children" value="{{ $searched->children }}" hidden>
                        <input type="text" name="infant" value="{{ $searched->infant }}" hidden>
                        <input type="text" name="country_code" value="{{ $searched->country_code }}" hidden>
                        <button type="submit" class="btn btn-primary" onclick="showLoder();">Book Now</button>
                    </form>
                    <!-- <a href="{{route('passengerDetails')}}" class="btn btn-primary w-100">Book Now</a> -->
                  </div>
                </div>
                @endif
                <!--                
                <div class="col-md-3">
                    <div class="card">
                        <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                        <span class="text-muted">Travelers {{$searched->adults}} Adult</span>
                        <h5>something Wrong<h5>
                    </div>
                </div> -->
               
                
            </div>
        </div>
    </section>
</div>

@if(count($flights1)>0)

<div class="modal fade" id="baggageAndFare1">
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
              @foreach($flights1[4] as $price)
              <tr>
                <td>Base Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$price[0]['Amount'])}}</td>
              </tr>
              <tr>
                <td>Taxes and Fees (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$price[0]['TaxAmount'])}}</td>
              </tr>
              <tr>
                <td>Total Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[0]['Amount'])+str_replace($currency_code,'',$price[0]['TaxAmount'])),2)}}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div id="baggage_rules" class="container tab-pane fade">
            <!-- <div class="media mb-3">
              <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php ?>.gif" alt="6E.png" style="width:50px;height:50px;" class="mr-2"/></div>
              <div class="media-body align-self-center">
                <h6 class="m-0"><?php ?></small></h6>
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
                <!-- <td>{{str_replace('K','', isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' )}} Kgs</td>
                <td>{{str_replace('K','', isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:'')}} Kgs</td> -->
                <td>{{ isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' }} </td>
                <td>{{ isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:''}} </td>
              </tr>
            </table>
            <small>The baggage information is just for reference. Please Check with airline before check-in. For more information, visit IndiGo Airlines Website.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(isset($searched->from2) && isset($searched->to2))
<div class="modal fade" id="baggageAndFare2">
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
            <a class="nav-link active" data-toggle="pill" href="#fare_details2">Fare Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#baggage_rules2">Baggage Rules</a>
          </li>
        </ul>
        <div class="tab-content row mt-3">
          <div id="fare_details2" class="container tab-pane active">
            <table class="table table-bordered small">
            @foreach($flights1[4] as $price)
            <tr>
                <td>Base Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$price[1]['Amount'])}}</td>
              </tr>
              <tr>
                <td>Taxes and Fees (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$price[1]['TaxAmount'])}}</td>
              </tr>
              <tr>
                <td>Total Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[1]['Amount'])+str_replace($currency_code,'',$price[1]['TaxAmount'])),2)}}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div id="baggage_rules2" class="container tab-pane fade">
            <!-- <div class="media mb-3">
              <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php ?>.gif" alt="6E.png" style="width:50px;height:50px;" class="mr-2"/></div>
              <div class="media-body align-self-center">
                <h6 class="m-0"><?php ?></small></h6>
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
                <!-- <td>{{str_replace('K','', isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' )}} Kgs</td>
                <td>{{str_replace('K','', isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:'')}} Kgs</td> -->
                <td>{{isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' }} </td>
                <td>{{ isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:''}} </td>
             
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
@if(isset($searched->from3) && isset($searched->to3))
<div class="modal fade" id="baggageAndFare3">
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
            <a class="nav-link active" data-toggle="pill" href="#fare_details3">Fare Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#baggage_rules3">Baggage Rules</a>
          </li>
        </ul>
        <div class="tab-content row mt-3">
          <div id="fare_details3" class="container tab-pane active">
            <table class="table table-bordered small">
            @foreach($flights1[4] as $price)
            <tr>
                <td>Base Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$price[2]['Amount'])}}</td>
              </tr>
              <tr>
                <td>Taxes and Fees (1 Adult)</td>
                <td>{{$currency_symbal}} {{str_replace($currency_code,'',$price[2]['TaxAmount'])}}</td>
              </tr>
              <tr>
                <td>Total Fare (1 Adult)</td>
                <td>{{$currency_symbal}} {{number_format((str_replace($currency_code,'',$price[2]['Amount'])+str_replace($currency_code,'',$price[2]['TaxAmount'])),2)}}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div id="baggage_rules3" class="container tab-pane fade">
            <!-- <div class="media mb-3">
              <div class="media-left"><img src="https://goprivate.wspan.com/sharedservices/images/airlineimages/logoAir<?php ?>.gif" alt="6E.png" style="width:50px;height:50px;" class="mr-2"/></div>
              <div class="media-body align-self-center">
                <h6 class="m-0"><?php ?></small></h6>
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
                <!-- <td>{{str_replace('K','', isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' )}} Kgs</td>
                <td>{{str_replace('K','', isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:'')}} Kgs</td> -->
                <td>{{ isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' }} </td>
                <td>{{ isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:''}} </td>
              
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