@extends('layouts.mainlayout')
@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Table</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add New Table</h2>
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
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{url('/table/addtable')}}">
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="tablenum">Table Number <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" name="tablenum" required="required" class="form-control " value="{{$ctableno+1}}" min="1" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="capacity">Capacity<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" name="capacity"  class="form-control " value="{{old('capacity')}}" min="1" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align ">Select Status</label><span class="required">*</span>
                <div class="col-md-6 col-sm-6 ">
                  <select name="status" id="status" class="form-control" required="required">
                    <option value="">Select...</option>
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                    <option value="Reserved">Reserved</option>
                  </select>
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
  @endsection