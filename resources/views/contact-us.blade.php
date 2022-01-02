@extends('common.master')
@section('content')

<div class="middle pt-5">
    <div class="container">
        <div class="row justify-content-between">
        <div class="col-sm-6">
            <h1><b>Contact Us</b></h1>
            <p>Talk to us !! It becomes a lot more amazing when we get together.</p><hr>
            <form method="post" action="sendmail.php">
                <div class="form-group">
                    <label>Name*</label>
                    <input type="text" name="name" placeholder="Enter Name" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Email id*</label>
                    <input type="email" name="email" placeholder="Enter Email" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Phone*</label>
                    <input type="number" name="phone" placeholder="Enter Number" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" name="message" placeholder="Enter Message" style="height:120px;"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="contact_submit">Submit</button>
                </div>
            </form>
        </div>
        
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 class="mt-1"><b>Get in Touch</b></h3><hr>
                    <address><i class="fas fa-map-marker-alt"></i> <b>ADDRESS</b><br>
                    62 King Street Southall Middlesex UB2 4db UK
                    </address>
                    <address><i class="fas fa-phone"></i> <b>PHONE</b><br>
                    0203 500 0000
                    </address>
                    <address><i class="fas fa-envelope"></i> <b>EMAIL ID</b><br>
                    info@cloudtravels.co.uk
                    </address>
                </div>
            </div>
            <div class="embed-responsive embed-responsive-4by3">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.7168348709565!2d-0.38547098469193536!3d51.500063619061315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487672b16f7f4a29%3A0x99e248a24e5a22b9!2s62+King+St%2C+Southall+UB2+4DB%2C+UK!5e0!3m2!1sen!2sin!4v1566131008642!5m2!1sen!2sin" frameborder="0" style="border:0" allowfullscreen class="embed-responsive-item"></iframe>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
@section('script')


@endsection
