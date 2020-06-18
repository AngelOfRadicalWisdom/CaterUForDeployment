@extends('layouts.mainlayout')

@section('content')

 <!-- page content -->
 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              <h3>Promotions</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                  <h2>Edit Promotion Menu Quantity</h2>
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
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"action="{{ url('/promo/edit_quantity/'.$bundleDetails->bundle_details_id)}}" method="post" name="add_category" id="add_category" >
                    @foreach($allMenus as $menus)
                    @if($bundleDetails->menuID==$menus->menuID)
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity" >Menu Name
                        </label>
                        <div  class="col-md-6 ">
                        <label class="form-control" for="name" >{{$menus->name}}</label>
                        </div>
                      </div>
                      @endif
                      @endforeach
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity" >Previous Quantity
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <label class="form-control" for="name" >{{$bundleDetails->qty}}</label>
                        </div>
                      </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="quantity" > New Quantity<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="number" min="1" name="quantity" class="form-control" placeholder="Enter Quantity" value="{{ old('quantity')}}" required="required">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-4">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                          <a class="btn btn-danger" href="{{url('/promo/edit_promo/'.$bundleDetails->bundleid)}}">Cancel</a>
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


