<!DOCTYPE html>
<html lang="en">

<head>
	<title>CaterU</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/fonts/iconic/css/material-design-iconic-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/welcome/css/main.css')}}">
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-25">
				<span class="login100-form-title p-b-70">
					Welcome
				</span>
				<span class="login100-form-avatar">
					<img src="{{asset('/employee/employee_images/'.$userImage)}}">
				</span>

				<div class="wrap-input100 validate-input m-t-85 m-b-35" style="text-align:center;">
					<br>
					<label>
						<h2>{{$userFname}} {{$userLname}}</h2>
					</label>
				</div>
				@if (session('error'))

				<div class="alert alert-danger alert-dismissible " role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
					</button>
					<strong>{{ session('error') }}</strong>
				</div>
				@endif
				<a class="btn btn-success" href="{{url('/employee/timein')}}">Time In</a>
				<a class="btn btn-danger" href="{{url('/employee/timeout')}}">Time Out</a>
				<a class="btn btn-primary" href="{{url('/logout')}}">Logout</a>
			</div>

		</div>
	</div>
	</div>

	@include('sweetalert::alert')

	<script src="{{asset('/welcome/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('/welcome/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{asset('/welome/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('/welcome/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/welcome/vendor/select2/select2.min.js')}}"></script>
	<script src="{{asset('/welcome/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('/welcome/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{asset('/welcome/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{asset('/welcome/js/main.js')}}"></script>

</body>

</html>