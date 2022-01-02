@if(isset(Session::get('user_details')[0]['user_type']))
<header>
                <div class="container navigation">
                    <nav class="navbar navbar-expand-lg navbar-light p-0 custom-navbar">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="las la-bars"></i>
                          </button>
                        <a class="navbar-brand logo" href="{{route('index')}}"><img src="{{ asset('public/images/logo.png') }}" alt="logo" class="img-fluid"/></a>

                        <div class="d-block d-md-none ml-auto">
                            <a href="{{route('contactus')}}" class="btn btn-sm btn-default"><i class="las la-headset"></i> Support</a>
                            <a href="{{route('logout')}}" class="btn btn-sm btn-primary">Sign Out</a>
                        </div>
                        
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav  nav-pills" >
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{route('index')}}#flight">Flights</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('index')}}#hotel">Hotels</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Flights & Hotels</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Offers <span class="slug-update">Big Deal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Visa</a>
                                </li>
                            </ul>
                        </div>
                        <div class="m-auto ml-md-auto d-flex align-items-center">
                            <div class="call">
                                <a href="tel:0203 500 0000" class="nav-link text-center">
                                    <h2 class="mb-0 font-weight-bold text-danger h1">0203 500 0000</h2>
                                    <small class="text-muted">24 hours a day / 7 days a week</small>
                                </a>
                            </div>
                            <div class="d-none d-md-block">
                                <a href="{{route('contactus')}}" class="btn btn-sm btn-default"><i class="las la-headset"></i> Support</a>
                                <!-- <a class="">{{isset(Session::get('user_details')[0]['first_name'])?Session::get('user_details')[0]['first_name']:''}}</a> -->
                                <a href="{{route('dashboard')}}"  class="btn btn-sm btn-primary"><i class="las la-user" style="font-size:16px;"></i>Hi {{isset(Session::get('user_details')[0]['first_name'])? ucfirst(substr(Session::get('user_details')[0]['first_name'],0,12)):''}}</a>
                                <!-- <i class="las la-user" style="font-size:24px;"></i><a href="" class="btn btn-sm btn-primary">Sign Out</a> -->
                            </div>
                        </div>
                    </nav>
                </div>
            </header>

@else
<header>
                <div class="container navigation">
                    <nav class="navbar navbar-expand-lg navbar-light p-0 custom-navbar">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="las la-bars"></i>
                          </button>
                        <a class="navbar-brand logo" href="{{route('index')}}"><img src="{{ asset('public/images/logo.png') }}" alt="logo" class="img-fluid"/></a>

                        <div class="d-block d-md-none ml-auto">
                            <a href="{{route('contactus')}}" class="btn btn-sm btn-default"><i class="las la-headset"></i> Support</a>
                            <a href="{{route('login')}}" class="btn btn-sm btn-primary">Sign In</a>
                        </div>
                        
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav  nav-pills" >
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{route('index')}}#flight">Flights</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('index')}}#hotel">Hotels</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Flights & Hotels</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Offers <span class="slug-update">Big Deal</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Visa</a>
                                </li>
                            </ul>
                        </div>
                        <div class="m-auto ml-md-auto d-flex align-items-center">
                            <div class="call">
                                <a href="tel:0203 500 0000" class="nav-link text-center">
                                    <h2 class="mb-0 font-weight-bold text-danger h1">0203 500 0000</h2>
                                    <small class="text-muted">24 hours a day / 7 days a week</small>
                                </a>
                            </div>
                            <div class="d-none d-md-block">
                                <a href="{{route('contactus')}}" class="btn btn-sm btn-default"><i class="las la-headset"></i> Support</a>
                                <a href="https://www.cloud-travel.co.uk/software/public/login" class="btn btn-sm btn-primary">Sign In</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>

@endif