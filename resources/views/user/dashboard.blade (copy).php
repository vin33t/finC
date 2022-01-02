@extends('common.master')
@section('content')


<div class="middle">
    <section class="search-packages mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <table id="table_id" class="display">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Booking Reference</th>
                                    <th>Check In Date</th>
                                    <th>Check Out Date</th>
                                    <th>Booking Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Row 1 Data 1</td>
                                    <td>Row 1 Data 2</td>
                                    <td>Row 1 Data 3</td>
                                    <td>Row 1 Data 4</td>
                                    <td>Row 1 Data 5</td>
                                    <td>Row 1 Data 5</td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
    
    </section>
</div>


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
