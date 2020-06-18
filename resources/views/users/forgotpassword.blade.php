@extends('layouts.mainlayout')

@section('content')

 <!-- page content -->
 <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                  <h2>Reset Password</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a class="dropdown-item" href="#">Settings 1</a>
                          </li>
                          <li><a class="dropdown-item" href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  @if (session('error'))
    
    <div class="alert alert-danger alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>{{ session('error') }}</strong> 
              </div>
      @endif
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"method="post" name="changepass" id="changepass" >
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="password " >New Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="password" id="password" name="password" required="required" class="form-control" value="{{ old('password')}}" placeholder="Enter New Password...">
                        </div>
                        <div >
                        <label><img src="{{ asset('/assets/svg/eye.svg') }}" alt="" width="20px" height="30px" onclick="passwordVisibility()"></label>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="confirmpass">Confirm Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="password" class="form-control" rows="3" id="confirmpass" name="confirmpass" placeholder="Please Re-Enter your password..." value="{{old('confirmpass')}}">
                        </div>
                        <div >
                        <label><img src="{{ asset('/assets/svg/eye.svg') }}" alt="" width="20px" height="30px" onclick="ConfirmpasswordVisibility()" id="image"></label>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-4">
                        <button type="submit" class="btn btn-success" id="submit">Submit</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                          <a class="btn btn-danger" href="{{url('/employee/employeelist')}}">Cancel</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /page content -->
        @include('sweetalert::alert')
        <script>
    var password = document.getElementById("password"),
    confirmpass = document.getElementById("confirmpass");

function validatePassword() {
  if (password.value != confirmpass.value) {
    confirmpass.setCustomValidity("Passwords Don't Match");
  } else {
    confirmpass.setCustomValidity("");
  }
}

password.onchange = validatePassword;
//confirmpass.onchange = validatePassword;
confirmpass.onkeyup = validatePassword;
function passwordVisibility() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
function ConfirmpasswordVisibility() {
  var y = document.getElementById("confirmpass");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}

</script>
@endsection


