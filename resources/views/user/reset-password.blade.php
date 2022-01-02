@extends('common.master')
@section('content')

<div class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 mt-4 mt-md-5">
                <div class="card">
                    <h1>Change Password</h1><br>
                    @if(Session::has('error'))
                    <div class="form-group">
                        <label style="color:red;">This Email id not register!</label>
                    </div>
                    @endif
                    @if(Session::has('success'))
                    <div class="form-group">
                        <label style="color:green;">Password change successfully.</label>
                    </div>
                    @endif
                    <form method="post" action="{{route('resetpassword')}}">
                        @csrf
                        <input hidden type="id" name="id" value="{{$id}}" required class="form-control" placeholder="Enter Password"/>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required class="form-control" placeholder="Enter Password"/>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="con_password" required class="form-control" placeholder="Enter Confirm Password"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>
    $( document ).ready(function() {
        // console.log( "ready!" );
        $('#submit').on('click',function(){
            // alert("hii");
            var pass=$('#password').val();
            var conpass=$('#con_password').val();
            if(pass != conpass){
                alert('Password and confirm password did`t match!');
                return false;
            }
        });
    }); 
</script>
@endsection
