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
                        {{--                        {{ dd($countryPair->Visa) }}--}}
                    </header>


                    <div class="row">
                        <div class="col-md-3">
                            <!-- Tabs nav -->
                            <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                @foreach($countryPair->Visa as $visa)
                                    <a class="nav-link mb-3 p-3 shadow @if($visa->Category->categoryName == 'Tourist Visa')  active @endif"
                                       id="v-pills-{{ str_replace(' ','',$visa->Category->categoryName) }}-tab"
                                       data-toggle="pill"
                                       href="#v-pills-{{ str_replace(' ','',$visa->Category->categoryName) }}"
                                       role="tab"
                                       aria-controls="v-pills-{{ str_replace(' ','',$visa->Category->categoryName) }}"
                                       aria-selected="true">
                                        <i class="fa fa-user-circle-o mr-2"></i>
                                        <span
                                            class="font-weight-bold small text-uppercase">{{ $visa->Category->categoryName }}</span></a>
                                @endforeach
                            </div>
                        </div>


                        <div class="col-md-9">
                            <!-- Tabs content -->
                            <div class="tab-content" id="v-pills-tabContent">
                                @foreach($countryPair->Visa as $visa)

                                    <div
                                        class="tab-pane fade shadow rounded bg-white show p-5 @if($visa->Category->categoryName == 'Tourist Visa')  active @endif"
                                        id="v-pills-{{ str_replace(' ','',$visa->Category->categoryName) }}" role="tabpanel"
                                        aria-labelledby="v-pills-{{ str_replace(' ','',$visa->Category->categoryName) }}-tab">
                                        <h4 class="font-italic mb-4">{{ $visa->Category->categoryName }}</h4>
                                        <p class="font-italic text-muted mb-2">{!! $visa->visaDetails !!}</p>
                                        <hr>
                                        <p>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Type Of Visa</th>
                                                    <th>Validity</th>
                                                    <th>Processing</th>
                                                    <th>Embassy Fee</th>
                                                    <th>Service Fee</th>
                                                    <th>VAT</th>
                                                    <th>Total Cost</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($visa->singleEntry == 1)
                                                    <tr>
                                                        <td>{{ $visa->Category->categoryName}}(Single Entry)</td>
                                                        <td>{{ $visa->singleEntryValidity }}</td>
                                                        <td>{{ $visa->singleEntryProcessing }}</td>
                                                        <td>{{ $visa->singleEntryEmbassyFee }}</td>
                                                        <td>{{ $visa->singleEntryServiceFee }}</td>
                                                        <td>{{ $visa->singleEntryVat }}</td>
                                                        <td>{{ $visa->singleEntryVat + $visa->singleEntryServiceFee + $visa->singleEntryEmbassyFee }}</td>
                                                        <td>
                                                            <a href="{{ route('visa.apply',['id'=>$visa->id,'type'=>'single']) }}"><button class="btn btn-primary" type="submit">Apply for Single Entry Visa</button></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($visa->multipleEntry == 1)
                                                    <tr>
                                                        <td>{{ $visa->Category->categoryName}}(Multiple Entry)</td>
                                                        <td>{{ $visa->multipleEntryValidity }}</td>
                                                        <td>{{ $visa->multipleEntryProcessing }}</td>
                                                        <td>{{ $visa->multipleEntryEmbassyFee }}</td>
                                                        <td>{{ $visa->multipleEntryServiceFee }}</td>
                                                        <td>{{ $visa->multipleEntryVat }}</td>
                                                        <td>{{ $visa->multipleEntryVat + $visa->multipleEntryServiceFee + $visa->multipleEntryEmbassyFee }}</td>
                                                        <td>
                                                            <a href="{{ route('visa.apply',['id'=>$visa->id,'type'=>'multiple']) }}"><button class="btn btn-primary" type="submit">Apply for Multiple Entry Visa</button></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        <hr>
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-12 text-center">--}}
{{--                                                <a href="{{ route('visa.apply',['id'=>$visa->id]) }}"><button class="btn btn-primary">Get Started</button></a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
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
