
@extends('user.common.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking History</h1>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">All Booking History</h3>
              </div> -->
             
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Booking Reference No.</th>
                                    <th>Booking Date</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Booking Status</th>
                                    <th>Print</th>
                                </tr>
                            </thead>
                  <tbody>
                                <?php $count=1; ?>
                                @foreach($details as $detail)
                                <tr>
                                    <td>{{$count++}}</td>
                                    <td>{{$detail->booking_reference}}</td>
                                    <td>{{Carbon\Carbon::parse($detail->booking_time)->format('d M Y H:i:s')}}</td>
                                    <td>{{Carbon\Carbon::parse($detail->check_in_date)->format('d M Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($detail->check_out_date)->format('d M Y')}}</td>
                                    <td>{{$detail->booking_status}}</td>
                                    <td><a href="{{route('generateinvoicehotel')}}?booking_reference={{$detail->booking_reference}}"><i class="fa fa-print" aria-hidden="true"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('script')
<!-- <link href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/> -->

<!-- <link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script> -->


<!-- <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.bootstrap.min.js"></script> -->

<script>
    $(document).ready( function () {
        $('#loading').hide();
        $('#loading_small').hide();
        $('#example2').DataTable();
    } );
</script>
@endsection
