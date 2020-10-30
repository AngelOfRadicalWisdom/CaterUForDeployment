@extends('layouts.mainlayout')
@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Employee</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add Employee</h2>
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
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ url('/employee/addemployee')}}" enctype="multipart/form-data">

              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="empfirstname">First Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" class="form-control" name="empfirstname" placeholder="Employee Firstname" value="{{ old('empfirstname')}}" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="emplastname">Last Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" class="form-control" name="emplastname" placeholder="Employee Lastname" value="{{ old('emplastname')}}" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align ">Select Position</label>
                <div class="col-md-6 col-sm-6 ">
                  <select name="position" class="form-control">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="cashier">Cashier</option>
                    <option value="receptionist">Receptionist</option>
                    <option value="kitchen staff">Kitchen Staff</option>
                    <option value="waiter">Waiter</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Username <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" class="form-control" name="username" placeholder=" Employee Username" value="{{ old('username')}}" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Password<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="password" class="form-control" name="password" placeholder="Password" value="{{ old('password')}}" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Upload User Image
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="file" id="image" name="image">
                  @if ($errors->has('image'))
                  <span class="text-danger">{{ $errors->first('image') }}</span>
                  @endif
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-4">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <button class="btn btn-primary" type="reset">Reset</button>
                  <a class="btn btn-danger" href="{{url('/dashboard')}}">Cancel</a>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('sweetalert::alert')
  <!-- /page content -->
  @section('onchange')

  <script type="text/javascript">
    $(document).ready(function() {

      $('#subcategory').parent().hide();
      $('#category').change(function(e) {
        var cat_id = e.target.value;
        $('#subcategory').empty();
        $.get("/menu/category?categoryid=" + cat_id, function(data) {
          $.each(data.subs, function(index, subcategory) {
            $('#subcategory').append('<option value="' + subcategory.subcatid + '">' + subcategory.subname + '</option>').parent().show();
          });
        });

      });
    });
  </script>

  @endsection
  @endsection