@extends('layouts.mainlayout')
@section('content')
<div class="right_col" role="main">
   
            <div class="clearfix"></div>


            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Monthly Sales (Current Year)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="monthlysales"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Yearly Sales</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="yearlysales"></canvas>
                  </div>
                </div>
              </div>
              </div>
              <div class="row">
      <div class="clearfix"></div>
      <div class="col-sm-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Ratings</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content col-sm-9">
                  <h4>Overall Ratings: {{$AverageStr}} out of {{$maxRating}}</h4>
                    <canvas id="ratings"></canvas>
                  </div>
                </div>
              </div>
</div>

              @include('sweetalert::alert')
         

 <!-- jQuery -->
 <script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
         <!-- bootstrap-daterangepicker -->
       <script src="{{asset('/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{asset('/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
 <!-- Ion.RangeSlider -->
 <script src="{{asset('/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="{{asset('/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- jquery.inputmask -->
    <script src="{{asset('/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <!-- jQuery Knob -->
    <script src="{{asset('/vendors/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- Cropper -->
    <script src="{{asset('/vendors/cropper/dist/cropper.min.js')}}"></script>
    <script>
    $( document ).ready(function() {
    var monthlySales = document.getElementById("monthlysales");
			  var monthlySalesChart= new Chart(monthlySales, {
				type: 'bar',
				data: {
				  labels: [{!!$monthNameStr!!}],
				  datasets: [{
					label: 'Sales',
					backgroundColor: ["#e9b5a3","#8d7062","#3f0f11","#e9b5a3","#8d7062","#3f0f11","#e9b5a3","#8d7062","#3f0f11","#e9b5a3","#8d7062","#3f0f11"],
					data: [{{$MonthlySalesStr}}]
				  }
                  ]},

				options: {
				  scales: {
					yAxes: [{
					  ticks: {
						beginAtZero: true
					  }
					}]
				  }
				}
			  });
			  
var yearlySales = document.getElementById("yearlysales");
			  var yearlySalesChart= new Chart(yearlySales, {
				type: 'bar',
				data: {
				  labels: [{!!$yearNameStr!!}],
				  datasets: [{
					label: 'Sales',
					backgroundColor: "#3f0f11",
					data: [{{$yearlySalesStr}}]
				  }
                  ]},

				options: {
				  scales: {
					yAxes: [{
					  ticks: {
						beginAtZero: true
					  }
					}]
				  }
				}
			  });
        var ratings = document.getElementById("ratings");
			  var RatingsChart= new Chart(ratings, {
				type: 'horizontalBar',
				data: {
				  labels: ['5 stars','4 stars','3 stars','2 stars','1 star'],
				  datasets: [{
					label: 'Ratings',
					backgroundColor:"#8d7062",
					data: [{{$ratesStr}}]
				  }
                  ]},

				options: {
				  scales: {
					yAxes: [{
					  ticks: {
						beginAtZero: true
					  }
					}]
				  }
				}
			  });
    });
        </script>
@endsection
