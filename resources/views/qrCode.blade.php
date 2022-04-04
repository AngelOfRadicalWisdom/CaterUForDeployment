@extends('layouts.mainlayout')

@section('content')
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
            <h2>Generate QR</h2>
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
              @foreach($emp_info as $emp)
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="confidence">Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <label class="form-control" for="confidence">{{$emp->empfirstname}} {{$emp->emplastname}}</label>
                </div>
              </div>
              @endforeach
              <div id="qrcode">
                @foreach($emp_info as $emp)
                {!! QrCode::size(250)->generate($qrID);!!}

                @endforeach
              </div>
              <div class="ln_solid"></div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-4">
                  <a class="btn btn-primary" href="{{url('/employee/employeelist')}}">Back To Employee List</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('sweetalert::alert')
  @endsection
  @section('onchange')
  <script type="text/javascript">
  </script>
  @endsection