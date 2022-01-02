
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('dashboard')}}" class="brand-link">
    <img src="{{ asset('public/admin/dist/img/user.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{isset(Session::get('user_details')[0]['first_name'])? ucfirst(substr(Session::get('user_details')[0]['first_name'],0,12)):''}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('public/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div> -->
   

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{route('dashboard')}}" class="nav-link {{Route::currentRouteName()=='dashboard'?'active':''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p> Profile</p>
          </a>
        </li>
        
        
        <!-- <li class="nav-item">
          <a href="{{route('bookinghotels')}}" class="nav-link {{Route::currentRouteName()=='bookinghotels' || Route::currentRouteName()=='generateinvoicehotel'?'active':''}}">
            <i class="nav-icon fas fa-table"></i>
            <p> Hotels</p>
          </a>
        </li> -->
        <li class="nav-item {{Route::currentRouteName()=='bookinghotels' ?'menu-open':''}}">
            <a href="#" class="nav-link {{Route::currentRouteName()=='bookinghotels' ?'active':''}}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                My Booking
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('bookinghotels')}}" class="nav-link {{Route::currentRouteName()=='bookinghotels' ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hotels</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flights</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{route('bookinghotels')}}" class="nav-link {{Route::currentRouteName()=='bookinghotels' ?'active':''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flights</p>
                </a>
              </li> -->
             
            </ul>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

