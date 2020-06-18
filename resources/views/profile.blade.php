@extends('layouts.mainlayout')
@section('content')
<div class="right_col" role="main">
<div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Edit Profile</h4>
                </div>
                @if (session('error'))
    
        <div class="alert alert-danger alert-dismissible " role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ session('error') }}</strong> 
                  </div>
          @endif
                <div class="card-body">
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ url('/admin/profile/'.$user->empid)}}" enctype="multipart/form-data">

<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="empfirstname">First Name <span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
    <input type="text" class="form-control" name="empfirstname" placeholder="Employee Firstname" value="{{ $user->empfirstname}}" required="required">
    </div>
  </div>
  <div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="emplastname">Last Name<span class="required">*</span>
    </label>
    <div class="col-md-6 col-sm-6 ">
    <input type="text" class="form-control" name="emplastname" placeholder="Employee Lastname" value="{{ $user->emplastname}}" required="required">
    </div>
  </div>
  <div class="item form-group">
    <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Username <span class="required">*</span></label>
    <div class="col-md-6 col-sm-6 ">
    <input type="text" class="form-control" name="username" placeholder=" Employee Username" value="{{$user->username}}" required="required">
    </div>
  </div>
  <div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Upload User Image
    </label>
    <div class="col-md-6 col-sm-6 ">
      <input type="file" id="image" name="image">
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
            <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="javascript:;">
                    <img class="img" src="{{asset('/employee/employee_images/'.$user->image)}}" />
                  </a>
                </div>
                <div class="card-body"> 
                  <h4 class="card-title">{{$user->empfirstname}} {{$user->emplastname}}</h4>
                  <p class="card-description">
                   {{$user->position}}
                  </p>
                  <a href="{{url('/employee/resetpass_employee/'.$user->empid)}}" class="btn btn-primary btn-round">Reset Password</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@include('sweetalert::alert')
@endsection