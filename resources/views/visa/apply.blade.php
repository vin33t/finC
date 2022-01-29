@extends('common.master')
@section('content')
    <style>
        select[readonly] {
            background: #eee; /*Simular campo inativo - Sugestão @GabrielRodrigues*/
            pointer-events: none;
            touch-action: none;
        }
    </style>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">   -->

    <div class="banner position-relative">

        <div class="container r-container">
            <section class="py-5 header">
                <div class="container py-4">
                    <header class="mb-5 pb-5">
                        <h1 class="display-4">{{ $visa->Pair->visaTo->countryName }}
                            <strong>{{ $visa->Category->categoryName }}</strong> ( @if($type == 'single')Single Entry @else Multiple Entry @endif ) </h1>
                        <h3 class="display-9">Travelling from <strong>{{ $visa->Pair->visaFrom->countryName }}</strong>
                            to <strong>{{ $visa->Pair->visaTo->countryName }}</strong></h3>
                        <p class="font-italic mb-1">Having to get a visa to India takes all the fun out of traveling.
                            We are here to get it back. Just apply online below and let us do the rest</p>
                        {{--                        {{ dd($countryPair->Visa) }}--}}
                    </header>


                    <div class="card">
                        <div class="card-header">
                            Applicant Details
                        </div>
                        <div class="card-body">
                            <form action="{{ route('visa.apply.now',['id'=>$visa->id]) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="visaApplicantName">Applicant Name</label>
                                        <input type="text" name="visaApplicantName" id="visaApplicantName"
                                               class="form-control"
                                               placeholder="Applicant Name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="passportOrigin">Passport Origin</label>
                                        <input type="text" name="passportOrigin" id="passportOrigin"
                                               class="form-control"
                                               placeholder="Passport Origin" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="passwordNumber">Passport Number</label>
                                        <input type="text" name="passwordNumber" id="passwordNumber"
                                               class="form-control"
                                               placeholder="Passport Number" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="visaCountry">Visa Country</label>
                                        <select name="visaCountry" id="visaCountry" class="form-control" required
                                                readonly="readonly">
                                            @foreach(\App\Models\Visa\VisaCountries::all() as $country)
                                                <option value="{{ $country->id }}"
                                                        @if($visa->Pair->visaTo->id == $country->id) selected @endif>{{ $country->countryName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="visaCategory">Visa Category</label>
                                        <select name="visaCategory" id="visaCategory" class="form-control" required
                                                readonly="readonly">
                                            @foreach(\App\Models\Visa\VisaCategories::all() as $category)
                                                <option value="{{ $category->id }}"
                                                        @if($visa->Category->id == $category->id) selected @endif>{{ $category->categoryName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="visaApplicantPhone">Applicant Phone</label>
                                        <input type="text" name="visaApplicantPhone" id="visaApplicantPhone"
                                               class="form-control"
                                               placeholder="Applicant Phone" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="visaApplicantEmail">Applicant Email</label>
                                        <input type="text" name="visaApplicantEmail" id="visaApplicantEmail"
                                               class="form-control"
                                               placeholder="Applicant Email" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
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
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if($visa->singleEntry == 1 && $type == 'single')
                                                <tr>
                                                    <td>{{ $visa->Category->categoryName}}(Single Entry)</td>
                                                    <td>{{ $visa->singleEntryValidity }}</td>
                                                    <td>{{ $visa->singleEntryProcessing }}</td>
                                                    <td>{{ $visa->singleEntryEmbassyFee }}</td>
                                                    <td>{{ $visa->singleEntryServiceFee }}</td>
                                                    <td>{{ $visa->singleEntryVat }}</td>
                                                    <td>{{ $visa->singleEntryVat + $visa->singleEntryServiceFee + $visa->singleEntryEmbassyFee }}</td>

                                                </tr>
                                            @endif
                                            @if($visa->multipleEntry == 1 && $type == 'multiple')
                                                <tr>
                                                    <td>{{ $visa->Category->categoryName}}(Multiple Entry)</td>
                                                    <td>{{ $visa->multipleEntryValidity }}</td>
                                                    <td>{{ $visa->multipleEntryProcessing }}</td>
                                                    <td>{{ $visa->multipleEntryEmbassyFee }}</td>
                                                    <td>{{ $visa->multipleEntryServiceFee }}</td>
                                                    <td>{{ $visa->multipleEntryVat }}</td>
                                                    <td>{{ $visa->multipleEntryVat + $visa->multipleEntryServiceFee + $visa->multipleEntryEmbassyFee }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-lg btn-primary">Apply Now</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>










@endsection
@section('script')

@endsection
