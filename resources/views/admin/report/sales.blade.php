@extends('layouts.mainlayout')
@section('content')
<div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Sales Report</h3>
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
            <form name="salesDate" data-parsley-validate class="form-horizontal form-label-left" method="post" >
            <div class='col-sm-4'>
                    From
                    <div class="form-group">
                        <div class='input-group date' id='from'>
                            <input type='text' class="form-control" name="from" required="required"/>
                            <span class="input-group-addon">
                               <span class="fa fa-calendar-check-o"  aria-hidden="true"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-sm-4'>
                    To
                    <div class="form-group">
                        <div class='input-group date' id='to'>
                            <input type='text' class="form-control" name="to" required="required"/>
                            <span class="input-group-addon">
                               <span class="fa fa-calendar-check-o" aria-hidden="true"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div>
                          <button type="submit" class="btn btn-success" id="savepromo">Submit</button>
                        </div>
                      </div>
                
            </form>

            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Defined Sales (Per Month)</h2>
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
                    <canvas id="userDefinedSales"></canvas>
                  </div>
                </div>
              </div>
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
                    <h2>Yealry Sales</h2>
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

	
    <script type="text/javascript">
$( document ).ready(function() {
  const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})
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
              $("form[name=salesDate]").submit(function(event){
        event.preventDefault();
        var formData = new FormData($(this)[0]);
       $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      //  'Content-type': 'text/html;charset=ISO-8859-1'
    }
});
$.ajax({
                url: '/salesUserDefined',
              //  enctype: 'multipart/form-data',
               processData: false,
                contentType: false,
                dataType: 'JSON',
                cache: false,
        //         data:{
        //          // "_token": "{{ csrf_token() }}",
        //         'promoid': promoid,
        //         'details': details,
        //         'price': price,
        //         'servingsize': servingsize,
        //         'image': image,
        //         'menus': allMenus,
        // },
                data:formData,
                type: 'POST',
                success: function(Rdata) {
                    // var yearMonth=Rdata["year"];
                    // var sales=Rdata["sales"];
                //   console.log(sales);
                if(Rdata['status']==500){
                    swalWithBootstrapButtons.fire({
      title: 'OOPPSS!',
      text: 'I cannot find sales within the specified date range',
      icon:'error' ,
      confirmButtonText: 'ok', 
     } )      }
     else{
                    var userDefineSales = document.getElementById("userDefinedSales");
			  var userDefineSalesChart= new Chart(userDefineSales, {
				type: 'bar',
				data: {
				  labels: Rdata["year"],
				  datasets: [{
					label: 'Sales',
					backgroundColor: "#8d7062",
					data: Rdata["totalRev"]
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
     }
        },
        error:  function(thrownError){
          console.log(thrownError);
          swalWithBootstrapButtons.fire({
      title: 'OOPPSS!',
      text: 'Something went wrong',
      icon:'error',
      confirmButtonText: 'ok', 
     } )  
        }
            }).promise().then(function(data) {
               console.log(data);
            });
            
            // Stop the forms default action method

            
        });



           });
           
</script>
	   <!-- Initialize datetimepicker -->
<script  type="text/javascript">
   $(function () {
                $('#myDatepicker').datetimepicker();
            });
    
    $('#from').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#to').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    $('#myDatepicker3').datetimepicker({
        format: 'hh:mm A'
    });
    
    $('#myDatepicker4').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $('#datetimepicker6').datetimepicker();
    
    $('#datetimepicker7').datetimepicker({
        useCurrent: false
    });
    
    $("#datetimepicker6").on("dp.change", function(e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker7").on("dp.change", function(e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });
</script>
@endsection
