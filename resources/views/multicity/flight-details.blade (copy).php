@extends('common.master')
@section('content')

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
                        @if(count($flights1)>0)
                        <hr>
                        <h4 class="font-weight-500">FLIGHT 1</h4>
                        <hr>
                        <h6 class="mb-0"><i class="fas fa-plane"></i>@foreach($flights1[0] as $datas) {{$datas[0]['Origin']." - ".$datas[(count($datas)-1)]['Destination']." ".\Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y')}} @endforeach 
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#baggageAndFare1" class="float-right badge badge-success font-weight-400">Baggage and Fare Rules</a>
                        </h6>
                        <hr>
                        @foreach($flights1[0] as $datas)
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
                                <span class="exchange-arrow exchange-relative m-auto"><i class="las la-exchange-alt"></i></span>
                                <h5 class="font-weight-600 mb-0 mt-2">{{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[$i]['ArrivalTime']))->format('%Hh %Im')}}</h5>
                                <!-- <small class="text-muted">Non stop</small> -->
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-arrival h6"></i> {{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('d M Y')}}</small>
                                <h6 class="font-weight-bold mb-0">{{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('H:i')}}</h6>
                                <span class="text-muted">{{$datas[$i]['Destination']}}</span>
                            </div>
                            <div class="col-md-3 text-center">
                            </div>
                        </div>
                        <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{str_replace('K','',isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'')}} Kgs Check-In, {{str_replace('K','', isset($flights1[1]['details']['carryonallowanceinfo'])?$flights1[1]['details']['carryonallowanceinfo']:'' )}} Kgs Cabin</p>
                        @endfor
                        @endforeach
                        @else
                        <hr>
                        <h4 class="font-weight-500">FLIGHT 1</h4>
                        <hr>
                        <h4 class="font-weight-500">No flight Found</h4>
                        @endif

                        
                        


                        @if(isset($flights1))
                        <!-- <hr> -->
                        @if(count($flights1)>0)
                        @foreach($flights1[0] as $datas)
                        @for ($i=0; $i < count($datas); $i++)
                        @if($i>0)
                        <!-- <hr>
                            <div class="col-md-12 text-center my-2">
                            <span class="badge badge-pill badge-warning"><i class="far fa-clock"></i> {{$datas[$i]['Origin']}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[($i-1)]['ArrivalTime']))->format('%Hh %Im')}} Layover</span><br>
                            <small> Re-Checkin your baggage</small>
                            </div>
                        <hr> -->
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
                                <span class="exchange-arrow exchange-relative m-auto"><i class="las la-exchange-alt"></i></span>
                                <h5 class="font-weight-600 mb-0 mt-2">{{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->diff(\Carbon\Carbon::parse($datas[$i]['ArrivalTime']))->format('%Hh %Im')}}</h5>
                                <!-- <small class="text-muted">Non stop</small> -->
                            </div>
                            <div class="col-md-2">
                                <small><i class="las la-plane-arrival h6"></i> {{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('d M Y')}}</small>
                                <h6 class="font-weight-bold mb-0">{{\Carbon\Carbon::parse($datas[$i]['ArrivalTime'])->format('H:i')}}</h6>
                                <span class="text-muted">{{$datas[$i]['Destination']}}</span>
                            </div>
                            <div class="col-md-3 text-center">
                            @if(count($datas)==1)<h3 class="font-weight-bold"><i class="las la-pound-sign"></i>{{str_replace('GBP','',$flights1[2]['price']['TotalPrice'])}}</h3>@endif
                            </div>
                        </div>
                        <p class="mt-3"><i class="las la-suitcase-rolling"></i> {{str_replace('K','', isset($flights1[1]['details']['baggageallowanceinfo'])?$flights1[1]['details']['baggageallowanceinfo']:'' )}} Kgs Check-In, {{str_replace('K','', isset($data[1]['details']['carryonallowanceinfo'])?$data[1]['details']['carryonallowanceinfo']:'' )}} Kgs Cabin</p>
                        <hr>
                        @if($datas[$i]['Destination']==str_replace(')','',explode('(',$per_flight_details->addTo)[1]))
                        <!-- <hr> -->
                        <h6 class="mb-0"><i class="fas fa-plane"></i> {{$per_flight_details->addTo}} - {{$per_flight_details->addFrom}} {{\Carbon\Carbon::parse($datas[$i]['DepartureTime'])->format('d M Y')}} <?php //foreach($flights1[0] as $datas){ echo \Carbon\Carbon::parse($datas[0]['DepartureTime'])->format('d M Y'); } ?>
                        </h6>
                        <hr>
                        @endif
                        @endfor
                        @endforeach
                        @endif
                        @endif

                    </div>
                </div>

               
                <!-- {{print_r($price)}} -->
                <div class="col-md-3">
                    <div class="card">
                        <h4 class="font-weight-500 mb-0">Fare Summary</h4>
                        <!-- <span class="text-muted">Travelers {{$searched->adults}} Adult</span> -->
                        <table class="table table-small mt-2">
                            <tr class="font-weight-bold bg-light">
                                <td>Passenger Type</td>
                                <td class="text-right">Adult</td>
                            </tr>
                            <tr>
                                <td>Base Fare x {{$searched->adults}}</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>@foreach($price as $prices){{ number_format((str_replace('GBP','',$prices['Approx Base Price'][0])*$searched->adults),2, '.', '')}}@endforeach</td>
                                <!-- <td class="text-right"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['ApproximateBasePrice'])? $flights1[2]['price']['ApproximateBasePrice']:0)*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['ApproximateBasePrice'])?$flights2[2]['price']['ApproximateBasePrice']:0)*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['ApproximateBasePrice'])?$flights3[2]['price']['ApproximateBasePrice']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                            <tr>
                                <td>Taxes x {{$searched->adults}}</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>@foreach($price as $prices){{ number_format((str_replace('GBP','',$prices['Taxes'][0])*$searched->adults),2, '.', '')}}@endforeach</td>
                                <!-- <td class="text-right"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['Taxes'])?$flights1[2]['price']['Taxes']:0)*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['Taxes'])?$flights2[2]['price']['Taxes']:0)*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['Taxes'])?$flights3[2]['price']['Taxes']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Price {{$searched->adults}} adult(s)</td>
                                <td class="text-right text-danger"><i class="las la-pound-sign"></i>@foreach($price as $prices){{ number_format((str_replace('GBP','',$prices['Total Price'][0])*$searched->adults),2, '.', '')}}@endforeach</td>
                            </tr>
                            @if(isset($price1))
                            <tr class="font-weight-bold bg-light">
                                <td>Passenger Type</td>
                                <td class="text-right">Child</td>
                            </tr>
                            <tr>
                                <td>Base Fare x {{$searched->children}}</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>@foreach($price1 as $prices){{ number_format((str_replace('GBP','',$prices['Approx Base Price'][0])*$searched->children),2, '.', '')}}@endforeach</td>
                                <!-- <td class="text-right"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['ApproximateBasePrice'])? $flights1[2]['price']['ApproximateBasePrice']:0)*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['ApproximateBasePrice'])?$flights2[2]['price']['ApproximateBasePrice']:0)*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['ApproximateBasePrice'])?$flights3[2]['price']['ApproximateBasePrice']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                            <tr>
                                <td>Taxes x {{$searched->children}}</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>@foreach($price1 as $prices){{ number_format((str_replace('GBP','',$prices['Taxes'][0])*$searched->children),2, '.', '')}}@endforeach</td>
                                <!-- <td class="text-right"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['Taxes'])?$flights1[2]['price']['Taxes']:0)*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['Taxes'])?$flights2[2]['price']['Taxes']:0)*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['Taxes'])?$flights3[2]['price']['Taxes']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Price {{$searched->children}} child(s)</td>
                                <td class="text-right text-danger"><i class="las la-pound-sign"></i>@foreach($price1 as $prices){{ number_format((str_replace('GBP','',$prices['Total Price'][0])*$searched->children),2, '.', '')}}@endforeach</td>
                            </tr>
                            @endif
                            @if(isset($price2))
                            <tr class="font-weight-bold bg-light">
                                <td>Passenger Type</td>
                                <td class="text-right">Infant</td>
                            </tr>
                            <tr>
                                <td>Base Fare x {{$searched->infant}}</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>@foreach($price2 as $prices){{ number_format((str_replace('GBP','',$prices['Approx Base Price'][0])*$searched->infant),2, '.', '')}}@endforeach</td>
                                <!-- <td class="text-right"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['ApproximateBasePrice'])? $flights1[2]['price']['ApproximateBasePrice']:0)*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['ApproximateBasePrice'])?$flights2[2]['price']['ApproximateBasePrice']:0)*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['ApproximateBasePrice'])?$flights3[2]['price']['ApproximateBasePrice']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                            <tr>
                                <td>Taxes x {{$searched->infant}}</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>@foreach($price2 as $prices){{ number_format((str_replace('GBP','',$prices['Taxes'][0])*$searched->infant),2, '.', '')}}@endforeach</td>
                                <!-- <td class="text-right"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['Taxes'])?$flights1[2]['price']['Taxes']:0)*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['Taxes'])?$flights2[2]['price']['Taxes']:0)*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['Taxes'])?$flights3[2]['price']['Taxes']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Price {{$searched->infant}} infant(s)</td>
                                <td class="text-right text-danger"><i class="las la-pound-sign"></i>@foreach($price2 as $prices){{ number_format((str_replace('GBP','',$prices['Total Price'][0])*$searched->infant),2, '.', '')}}@endforeach</td>
                            </tr>
                            @endif
                            <!-- <tr>
                                <td>Other taxes</td>
                                <td class="text-right"><i class="las la-pound-sign"></i>0.0</td>
                            </tr> -->
                            <tr class="font-weight-bold bg-light">
                                <td class="text-danger">Total Price</td>
                                <td class="text-right text-danger"><i class="las la-pound-sign"><?php 
                                $var_tot_price=0;
                                foreach($price as $prices){ $var_tot_price+= number_format((str_replace('GBP','',$prices['Total Price'][0])*$searched->adults),2, '.', '');}
                                
                                if(isset($price1)){
                                    foreach($price1 as $prices){ $var_tot_price+= number_format((str_replace('GBP','',$prices['Total Price'][0])*$searched->children),2, '.', '');}
                                }
                                if(isset($price2)){
                                    foreach($price2 as $prices){ $var_tot_price+= number_format((str_replace('GBP','',$prices['Total Price'][0])*$searched->infant),2, '.', '');}
                                }
                                echo number_format($var_tot_price,2);
                                ?></i></td>
                                <!-- <td class="text-right text-danger"><i class="las la-pound-sign"></i>{{number_format((str_replace('GBP','', isset($flights1[2]['price']['ApproximateBasePrice'])? $flights1[2]['price']['ApproximateBasePrice']:0 )*$searched->adults)+(str_replace('GBP','', isset($flights2[2]['price']['ApproximateBasePrice'])? $flights2[2]['price']['ApproximateBasePrice']:0 )*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['ApproximateBasePrice'])? $flights3[2]['price']['Taxes']:0 )*$searched->adults)+(str_replace('GBP','', isset($flights1[2]['price']['Taxes'])? $flights1[2]['price']['Taxes']:0 )*$searched->adults)+(str_replace('GBP','',isset($flights2[2]['price']['Taxes'])?$flights2[2]['price']['Taxes']:0 )*$searched->adults)+(str_replace('GBP','', isset($flights3[2]['price']['Taxes'])? $flights3[2]['price']['Taxes']:0 )*$searched->adults),2)}}</td> -->
                            </tr>
                        </table>
                        <form action="{{ route('multicitypassengerDetails') }}" method="POST">
                            @csrf
                            <input type="text" name="flights1" value="{{json_encode($searched->flights1)}}" hidden>
                            <input type="text" name="flights2" value="{{json_encode($searched->flights2)}}" hidden>
                            <input type="text" name="flights3" value="{{json_encode($searched->flights3)}}" hidden>
                            <input type="text" name="flights4" value="{{json_encode($searched->flights4)}}" hidden>
                            <input type="text" name="flights5" value="{{json_encode($searched->flights5)}}" hidden>
                            <input type="text" name="flights6" value="{{json_encode($searched->flights6)}}" hidden>
                            <input type="text" name="price" value="{{json_encode($price)}}" hidden>
                            <input type="text" name="price1" value="{{isset($price1)?json_encode($price1):''}}" hidden>
                            <input type="text" name="price2" value="{{isset($price2)?json_encode($price2):''}}" hidden>
                            <input type="text" name="adults" value="{{ $searched->adults }}" hidden>
                            <input type="text" name="children" value="{{ $searched->children }}" hidden>
                            <input type="text" name="infant" value="{{ $searched->infant }}" hidden>
                            <button type="submit" class="btn btn-primary" onclick="showLoder();">Book Now</button>
                        </form>
                        <!-- <a href="#" class="btn btn-primary w-100">Book Now</a> -->
                    </div>
                </div>

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


@endsection