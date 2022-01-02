@extends('user.common.master')
@section('content')

@foreach($details as $data)
@endforeach
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{isset($data->profile_img)? asset('public/user-image').'/'.$data->profile_img : asset('public/admin/dist/img/user.png')}} "
                       alt="User profile picture">
                       <!-- user-image -->
                </div>

                <h3 class="profile-username text-center">{{$data->first_name}} {{$data->last_name}}</h3>

                <!-- <p class="text-muted text-center">Software Engineer</p> -->

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul> -->

                <!-- <a href="#settings" data-toggle="tab" class="btn btn-primary btn-block"><b>Edit</b></a> -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <!-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li> -->
                  <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#changePassword" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <!-- /.tab-pane -->
                  <div class="active tab-pane" id="timeline">
                    <!-- The timeline -->
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name  </label>
                        <div class="col-sm-10">
                            <label for="inputName" class=" col-form-label">{{$data->first_name}} {{$data->last_name}}</label>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <label for="inputName" class=" col-form-label">{{$data->user_id}}</label>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <label for="inputName" class=" col-form-label">{{$data->mobile}}</label>
                        </div>
                      </div>
                      
                      
                    </form>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" method="post" action="{{route('editprofile')}}" enctype="multipart/form-data">
                      @csrf
                      <input type="text" id="id" name="id" value="{{Session::get('user_details')[0]['id']}}" hidden />
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                          <input type="text" name="first_name" value="{{$data->first_name}}" required class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                          <input type="text" name="last_name" value="{{$data->last_name}}" required class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" name="email" value="{{$data->user_id}}" readonly required class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Mobile No</label>
                        <div class="col-sm-10">
                          <input type="number" name="mobile" value="{{$data->mobile}}" class="form-control" required id="inputName2" placeholder="Phone">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Profile Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="file" class="form-control" accept="image/png, image/gif, image/jpeg" />
                          <!-- <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea> -->
                        </div>
                      </div>
                      
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" id="profileSubmit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div class="tab-pane" id="changePassword">
                    <form class="form-horizontal" method="post" action="{{route('passwordChange')}}" enctype="multipart/form-data">
                      @csrf
                      <input type="text" id="id" name="id" value="{{Session::get('user_details')[0]['id']}}" hidden />
                      <!-- <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="text" name="old_password" value="" required class="form-control" id="inputName" placeholder="Old Password">
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="new_password" value="" required class="form-control" id="inputName" placeholder="New Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">New Confirm Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="new_con_password" value="" required class="form-control" id="inputName" placeholder="New Confirm Password">
                        </div>
                      </div>
                     
                      
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" id="changeSubmit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- /.content-wrapper -->


@endsection
@section('script')
<!-- <link href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/> -->

<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>


<!-- <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap.min.js"></script> -->

<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>
@endsection
