@extends('common.master')
@section('content')

<div class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 mt-4 mt-md-5">
                <div class="card">
                    <h1>Forgot Password</h1><br>
                    @if(Session::has('error'))
                    <div class="form-group">
                        <label style="color:red;">This Email id not register!</label>
                    </div>
                    @endif
                    @if(Session::has('success'))
                    <div class="form-group">
                        <label style="color:green;">Password reset link send your email.</label>
                    </div>
                    @endif
                    <form method="post" action="{{route('forgotpassword')}}">
                        @csrf
                        <div class="form-group">
                            <label>Email id</label>
                            <input type="email" name="email" required class="form-control" placeholder="Enter email id"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

@endsection
