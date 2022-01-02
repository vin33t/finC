@extends('common.master')
@section('content')

<div class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 mt-4 mt-md-5">
                <div class="card">
                    <h1>Login</h1><br>
                    @if(Session::has('error'))
                    <label style="color:red;">Email id or password did`t match</label>
                    @endif
                    <form method="post" action="{{route('login')}}">
                        @csrf
                        <div class="form-group">
                            <label>Email id</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email id"/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password"/>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                        <label class="custom-control-label" for="customCheck">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{route('forgotpassword')}}" class="font-weight-600">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                        <div class="form-group text-center">
                            <span>Don't have any account? <a href="{{route('register')}}">Sign Up</a></span>
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
