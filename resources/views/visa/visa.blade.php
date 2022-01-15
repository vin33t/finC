@extends('common.master')
@section('content')
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">   -->

    <div class="banner position-relative">

        <div class="container r-container">
            <section class="py-5 header">
                <div class="container py-4">
                    <header class="mb-5 pb-5">
                        <h1 class="display-4"><strong>{{ $visaTo->countryName }}</strong> Visa</h1>
                        <h3 class="display-9">Travelling from <strong>{{ $visaFrom->countryName }}</strong></h3>
                        <p class="font-italic mb-1">Having to get a visa to India takes all the fun out of traveling.
                            We are here to get it back. Just apply online below and let us do the rest</p>

                    </header>


                    <div class="row">
                        <div class="col-md-3">
                            <!-- Tabs nav -->
                            <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                               @foreach(\App\Models\VisaCategories::all() as $category)
                                <a class="nav-link mb-3 p-3 shadow @if($category->categoryName == 'Tourist Visa')  active @endif" id="v-pills-{{ str_replace(' ','',$category->categoryName) }}-tab" data-toggle="pill" href="#v-pills-{{ str_replace(' ','',$category->categoryName) }}" role="tab" aria-controls="v-pills-{{ str_replace(' ','',$category->categoryName) }}" aria-selected="true">
                                    <i class="fa fa-user-circle-o mr-2"></i>
                                    <span class="font-weight-bold small text-uppercase">{{ $category->categoryName }}</span></a>
                                @endforeach
                            </div>
                        </div>


                        <div class="col-md-9">
                            <!-- Tabs content -->
                            <div class="tab-content" id="v-pills-tabContent">
                                @foreach(\App\Models\VisaCategories::all() as $category)
                                <div class="tab-pane fade shadow rounded bg-white show p-5 @if($category->categoryName == 'Tourist Visa')  active @endif" id="v-pills-{{ str_replace(' ','',$category->categoryName) }}" role="tabpanel" aria-labelledby="v-pills-{{ str_replace(' ','',$category->categoryName) }}-tab">
                                    <h4 class="font-italic mb-4">{{ $category->categoryName }}</h4>
                                    <p class="font-italic text-muted mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>










@endsection
@section('script')

@endsection
