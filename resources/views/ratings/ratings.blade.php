@extends('layouts.mainlayout')
@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Ratings</h3>
              </div>
              </div>
            </div>
                @if (session('error'))
    
    <div class="alert alert-danger alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>{{ session('error') }}</strong> 
              </div>
      @endif
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>OverAll Ratings </h2>
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
                  <!-- @for($i=0;$i<$AverageStr;$i++)
    <span class="fa-stack" style="width:5em">
        <i class="fa fa-star fa-stack-1x"></i>
        @if($AverageStr > 0)
            @if($AverageStr > 0.5)
                <i class="fa fa-star fa-stack-1x"></i>
            @else
                <i class="fa fa-star-half fa-stack-1x"></i>
            @endif
        @endif
        
    </span>
@endfor -->
@for($i=0;$i< round($maxRating-$AverageStr) ;$i++)
<span class="fa-stack" style="width:5em">
<i class="fa fa-star-o fa-stack-1x"></i>
</span>
@endfor
<h7>{{$AverageStr}} out of {{$maxRating}}</h7>
<br>
<h3 style="text-align:center">Ratings Breakdown</h3>
<br>
<div class="x_content">
                  <canvas id="ratings"></canvas>
                  </div>
                  </div>
                </div>
              </div>
             

            <!--FOOTER-->
            </div>
            </div>
          </div>
</div>
        </div>

 <!-- jQuery -->
 <script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
         <!-- bootstrap-daterangepicker -->
       <script src="{{asset('/vendors/moment/min/moment.min.js')}}"></script>
       <script src="{{asset('/vendor/sweetalert/sweetalert.all.js')}}"></script>
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
</script>
<script type="text/javascript">
$( document ).ready(function() {
    var ratings = document.getElementById("ratings");
			  var RatingsChart= new Chart(ratings, {
				type: 'horizontalBar',
				data: {
				  labels: ['5 stars','4 stars','3 stars','2 stars','1 star'],
				  datasets: [{
					label: 'Ratings',
					backgroundColor: "#8d7062",
					data: [{{$rate5}},{{$rate4}},{{$rate3}},{{$rate2}},{{$rate1}}]
				  }
                  ]},

				options: {
				  scales: {
					yAxis: [{
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
