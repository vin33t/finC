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
                            <strong>{{ $visa->Category->categoryName }}</strong> ( @if($type == 'single')Single
                            Entry @else Multiple Entry @endif ) </h1>
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
                                @if(Auth::user())
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-lg btn-primary">Apply Now</button>
                                        </div>
                                    </div>
                                @endif
                            </form>
                            @if(!Auth::user())
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-lg btn-primary">Sign In</button>
                                        <button class="btn btn-lg btn-primary" data-toggle="modal" data-target="#registerNewCustomer">Register Now</button>
                                    </div>
                                </div>


                                <div class="modal fade" tabindex="-1" role="dialog" id="registerNewCustomer" aria-labelledby="registerNewCustomerLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Register Now</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <form action="{{route('store.client')}}" method="post" enctype="multipart/form-data" name="myForm">
                                                    @csrf
                                                    <div class="box box-primary" id="action">
                                                        <div class="box-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="first_name">First Name</label>
                                                                        <input type="text" name='first_name' value="{{old('first_name')}}" required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="last_name">Last Name</label>
                                                                        <input type="text" name='last_name' value="{{old('last_name')}}" required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="form-group">
                                                                            <center><div id="postcode_lookup" style="border:2px solid green;"></div></center>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="address">Street</label>
                                                                        <input type="hidden" id="line2">
                                                                        <input type="hidden" id="line3">
                                                                        <input type="text" id="line1" name='address' required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="city">City</label>
                                                                        <input id="town" type="text" name='city'  required class="form-control">
                                                                    </div>
                                                                </div>



                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="county">County</label>
                                                                        <input id="county" type="text" name='county' value="{{old('county')}}" required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="postal_code">Postal Code</label>
                                                                        <input id="postal_code" type="text" name='postal_code'  required class="form-control">

                                                                    <!--	<input id="postal_code" type="text" name='postal_code' value="{{old('postal_code')}}" required class="form-control" onkeyup="fun()"> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="country">Country</label>
                                                                        <input id="country" type="text" name='country' value="{{old('country') ? old('country') : 'United Kingdom' }}" required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="phone">Phone</label>
                                                                        <input type="text" name='phone' value="{{old('phone')}}" required class="form-control" maxlength="12">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="email">Email</label>
                                                                        <input type="email" name='email' value="{{old('email')}}" required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="DOB">DOB</label>
                                                                        <input type="date" name='DOB' required class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="client_type">Client Type:</label>
                                                                        <select name="client_type" class="form-control">
                                                                            <option value="">--Select--</option>
                                                                            <option value="Corporate">Corporate</option>
                                                                            <option value="Individual">Individual</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="family-member"></div>
                                                            <div class="text-center" style="margin-top: 5px">
                                                                <button class="btn btn-sm btn-primary" type="button" id="add">Add Member</button>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="passport">Do you have passport</label>
                                                                        <input type="radio" name='passport' required id="yespassport" value=1>Yes
                                                                        <input type="radio" name='passport' required id="nopassport" checked value=0>No
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="passport"></div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="passport">Do you want to make this client permanent?</label>
                                                                        <input type="radio" name='permanent' required id="yespermanent" value=1>Yes
                                                                        <input type="radio" name='permanent' required id="nopermanent" checked value=0>No
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="permanent"></div>
                                                                </div>
                                                            </div>



                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="text-center">
                                                            @can('Create Client')
                                                                <button class="btn btn-success" type="submit">Add client</button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </form>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>










@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#add").click(function(){
                var append = '<div class="hatao"> <div class="row">  <div class="col-md-4"><div><label for="passport_issue_date[]">Passport Issue Date</label> <input type="date" name="passport_issue_date[]" required class="form-control"></div></div><div class="col-md-4"><div> <label for="passport_expiry_date[]">Passport Expire Date</label> <input type="date" name="passport_expiry_date[]" required class="form-control"></div></div></div>   <div class="row">	<div class="col-md-4">		<div class="form-group"> <label for="member_name[]">Member Name</label> <input type="text" name="member_name[]" required class="form-control">		</div>	</div> 	<div class="col-md-4"> <div class="form-group"> <label for="member_DOB[]">Member DOB</label> <input type="date" name="member_DOB[]" value="{{$date}}" required class="form-control">		</div>	</div>	<div class="col-md-4"> <div class="form-group"> <label for="member_passport_no[]">Member Passport NO.</label> <input type="text" name="member_passport_no[]" required class="form-control" maxlength="10"> </div>	</div></div><div class="row"><div class="col-md-4"><div class="form-group"><label for="member_passport_place">Place of Issue</label><input type="text" name="member_passport_place[]" required class="form-control"></div></div><div class="col-md-4"><div class="form-group"><label for="member_passport_front">Passport Front Page:</label><input type="file" name="member_passport_front[]" class="form-control"></div></div><div class="col-md-4"><div class="form-group"><label for="member_passport_back">Passport Back Page:</label><input type="file" name="member_passport_back[]" class="form-control"></div></div></div><div align="right">						<input type="button" class="btn btn-danger btn-xs" value="Remove" onclick="SomeDeleteRowFunction(this);">	</div></div>';
                $("#family-member").append(append);
            });
        });
        function SomeDeleteRowFunction(btndel) {
            if (typeof(btndel) == "object") {
                $(btndel).closest('.hatao').remove();
            } else {
                return false;
            }}


        $(document).ready(function(){
            $("#yespassport").click(function(){
                var data = '<hr><div class="text-center"><h3>Passport Details</h3></div><hr><div class="row"><div class="col-md-6"><div class="form-group"><label for="passport_no">Passport Number</label><input type="text" name="passport_no" required class="form-control" maxlength="10"></div></div><div class="col-md-6"><div class="form-group"><label for="passport_expiry_date">Passport Expire date</label><input type="date" name="passport_expiry_date" required class="form-control"></div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label for="passport_place">Place of Issue</label><input type="text" name="passport_place" required class="form-control"></div></div><div class="col-md-6"><div class="form-group"><label for="passport_issue_date">Date Of Issue</label><input type="date" name="passport_issue_date" required class="form-control"></div></div></div><div class="row"><div class="col-md-4"><div class="form-group"><label for="passport_front">Passport Front:</label><input type="file" name="passport_front" class="form-control"></div></div><div class="col-md-4"><div class="form-group"><label for="passport_back">Passport Back:</label><input type="file" name="passport_back" class="form-control"></div></div><div class="col-md-4"><div class="form-group"><label for="passport_front">Premission Letter:</label><input type="file" name="letter" class="form-control"></div></div></div><hr>';
                $("#passport").html(data);
            });
        });
        $(document).ready(function(){
            $("#nopassport").click(function(){
                var data = '';
                $("#passport").html(data);
            });
        });

        $(document).ready(function(){
            $("#yespermanent").click(function(){
                var data = '<div class="row"><div class="col-md-6"><div class="form-group"><label for="currency">Currency</label><select name="currency" class="form-control" id="currency"><option value="$">$</option><option value="&#163;" selected>&#163;</option></select></div></div><div class="col-md-6"><div class="form-group"><label for="credit_limit">Credit Limit</label><input type="text" name="credit_limit" required class="form-control"></div></div></div>';
                $("#permanent").html(data);
            });
        });
        $(document).ready(function(){
            $("#nopermanent").click(function(){
                var data = '';
                $("#permanent").html(data);
            });
        });
        function fun() {
            var x = document.forms["myForm"]["postal_code"].value;

            var Url = "https://api.postcodes.io/postcodes?q=" + x;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', Url, true);
            xhr.send();
            xhr.onreadystatechange = processRequest;
            function processRequest(e) {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // alert(xhr.responseText);
                    var response1 = JSON.parse(xhr.responseText);
                    console.log(response1);

                    document.getElementById("city").value = response1.result[0].admin_ward;
                    document.getElementById("country").value = response1.result[0].country;
                    document.getElementById("county").value = response1.result[0].admin_county;
                }
            }
        }
    </script>
@endsection
