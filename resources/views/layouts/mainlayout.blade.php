<!DOCTYPE html>
@include('layouts.header')
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{url('/dashboard')}}"class="site_title"><i class="fa fa-paw"></i> <span>Cater U</span></a>
            </div>
            @include('quickprofile')
            @include('layouts.sidebar')
            @include('footer')
            @include('topnavigation')
            @yield('content')
            </div>

             <!-- footer content -->
        <footer>
          <div class="pull-right">
          ©2020 CaterU
          ©Designed By:Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    @include('scripts')
       </body>
  </html>

