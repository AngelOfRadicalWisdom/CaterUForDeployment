<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaterU</title>
  <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
  <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Satisfy|Bree+Serif|Candal|PT+Sans">
  <link rel="stylesheet" type="text/css" href="{{asset('/LandingPage/css/font-awesome.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/LandingPage/css/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/LandingPage/css/style.css')}}">
  <!-- =======================================================
    Theme Name: Delicious
    Theme URL: https://bootstrapmade.com/delicious-free-restaurant-bootstrap-theme/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>
<body>
  <!--banner-->
  <section id="banner">
    <div class="bg-color">
        <div style="height:20px"></div>
      <div class="container">
        <div class="row">
          <div class="inner text-center">
            <h1 class="logo-name">CaterU</h1>
            <h2>"We Celebrate Life With U"</h2>
            <br>
            <div class="col-md-12  text-center" id="menu-flters">
          <ul>
            <li><a class="filter" data-filter=".login" href="{{url('/login')}}">Log In</a></li>
            <li><a class="filter" data-filter=".signup"href="{{url('/createaccount')}}">Sign Up</a></li>
          </ul>
        </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / banner -->
   <!-- footer -->
   <footer class="footer text-center">
    <div>
      <div class="row">
        <div class="col-md-offset-3 col-md-6 text-center">
        <p class="copyright clear-float">
              ©2020 CaterU
            </p>
            <p class="copyright clear-float">
             Designed By: © Delicious Theme. All Rights Reserved
              <div class="credits">
                <!--
                  All the links in the footer should remain intact.
                  You can delete the links only if you purchased the pro version.
                  Licensing information: https://bootstrapmade.com/license/
                  Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Delicious
                -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- / footer -->
  <script src="{{asset('/LandingPage/js/jquery.min.js')}}"></script>
  <script src="{{asset('/LandingPage/js/jquery.easing.min.js')}}"></script>
  <script src="{{asset('/LandingPage/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('/LandingPage/js/custom.js')}}"></script>

</body>
  </html>
 