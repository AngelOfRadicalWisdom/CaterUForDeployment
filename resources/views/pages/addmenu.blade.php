@extends('layouts.mainlayout')
@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              <h3>Menu</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                  <h2>Add Menu</h2>
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
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ url('/menu/addmenu')}}" enctype="multipart/form-data">

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Menu Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="text" name="name" required="required" class="form-control "value="{{ old('name')}}" placeholder="Enter Menu Name" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="details">Details  
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <textarea class="form-control" rows="3"  name="details" placeholder="Enter Details">{{old('details')}}</textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Price <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                          <input class="form-control" type="number" min="0" name="price" value="{{old('price') }}" placeholder="Enter Price" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Serving Size <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                        <input type="number" class="form-control"  name="servingsize" value="{{old('servingsize')}}" min="1" placeholder="Enter Serving Size" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align ">Select Category  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                        <select name="categoryid" id="category" class="form-control" required="required">
                        <option value=" ">Select...</option>
                            @foreach ($allCategories as $category)
                            <option value="{{ $category->categoryid}}">{{ $category->categoryname}}</option>
                        @endforeach
                        </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align ">Select Sub Category <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                        <select name="subcategory" id="subcategory" class="form-control" >
                        <option value="">Select...</option>
                        @foreach ($allSubCategories as $subcategory)
                            <option value="{{ $subcategory->subcatid}}">{{ $subcategory->subname}}</option>
                        @endforeach
                            </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Upload Menu Image
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                          <input type="file" id="image" name="image" accept="image/*">
                          @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align ">Select Status  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                        <select name="status" id="status" class="form-control" required="required">
                        <option value=" ">Select...</option>
                            <option value="AVAILABLE">Available</option>
                            <option value="SOLDOUT">Sold Out</option>

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
@section('onchange')
<script src="{{asset('/vendor/sweetalert/sweetalert.all.js')}}"></script>
<script type="text/javascript">

$(document).ready(function(){

  $('#subcategory').parent().hide();
  $('#category').change(function(e){
    var cat_id = e.target.value;
    $('#subcategory').empty();
  $.get("/menu/category?categoryid="+cat_id, function(data){
      $.each(data.subs, function(index, subcategory) {
        $('#subcategory').append('<option value="'+subcategory.subcatid+'">'+subcategory.subname+'</option>').parent().show();
      });
  });

  });
});

</script>
  
@endsection
@endsection
