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
            <h2>Promo {{$promotion->bundleid}}</h2>
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
            <form name="bundleform" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="{{ url('/promo/'.$promotion->bundleid.'/edit_promo')}}">
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="promoid">Promotion Code <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <label class="form-control" rows="3" id="promoid" name="promoid">{{$promotion->bundleid}}</label>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Promotion Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" class="form-control" id="promoname" name="promoname" value="{{$promotion->name}}" placeholder="Promotion Name" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="details">Details <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <textarea class="form-control" rows="3" id="details" name="details" placeholder="Enter Details">{{$promotion->details}}</textarea>
                </div>
              </div>
              <div class="item form-group">
                <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Price <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 ">
                  <input class="form-control" type="number" min="1" id="price" name="price" value="{{$promotion->price}}" placeholder="Enter Price" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Serving Size <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" class="form-control" id="servingsize" name="servingsize" value="{{$promotion->servingsize}}" min="1" placeholder="Enter Serving Size" required="required">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Upload Menu Image
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="file" id="image" name="image">
                  @if ($errors->has('image'))
                  <span class="text-danger">{{ $errors->first('image') }}</span>
                  @endif
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">
                  <h4>Inclusive Menus:</h4>
                </label>
                <div class=" col-md-6 col-sm-6 ">
                  <table class="table table-striped table-bordered">
                    <tr>
                      <th> Menu Name</th>
                      <th> Quantity</th>
                      <th> Actions</th>
                    </tr>
                    @foreach($promotionDetails as $promoDetails)
                    @foreach($allMenus as $menus)
                    @if($promoDetails->menuID==$menus->menuID)
                    <tr>
                      <td>
                        <li>{{$menus->name}}</li>
                      </td>
                      <td>
                        {{$promoDetails->qty}}
                      </td>
                      <td>
                        <a data-toggle="tooltip" data-placement="top" title="Edit Promotion Menu Quantity" href="{{ url('/promo/edit_quantity/'.$promoDetails->bundle_details_id)}}"><img src="{{ asset('/assets/svg/pencil.svg') }}" alt="" width="20px" height="20px"></a>&emsp;
                        <a data-toggle="tooltip" data-placement="top" title="Delete Promotion Menu" onclick="deletePromotionsMenu({{$promoDetails->bundle_details_id}},{{$promotion->bundleid}})"><img src="{{ asset('/assets/svg/trash.svg') }}" alt="" width="20px" height="20px"></a>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                    <tr>
                      <td style="text-align:center" colspan="3">
                        <a class="btn btn-success" href="{{url('/promo/add_promodetails/'.$promotion->bundleid)}}">Add Promo Menu</a>
                        <a class="btn btn-primary" href="{{url('/promo/edit_promodetails/'.$promotion->bundleid)}}">Edit Promo Menu</a>
                        <a style="color:white;" class="btn btn-danger" onclick="deleteAllMenu({{$promotion->bundleid}})">Delete All Promo Menu</a>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-4">
                  <button type="submit" class="btn btn-success" id="savepromo">Submit</button>
                  <button class="btn btn-primary" type="reset">Reset</button>
                  <a class="btn btn-danger" href="{{url('/promo/promolist')}}">Cancel</a>
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
  <script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('/vendor/sweetalert/sweetalert.all.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
  <script src="{{asset('/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    function deletePromotionsMenu(bundle_details_id, promoid) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete promotion menu!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: '/promo/delete_menu_promodetails/' + bundle_details_id,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            cache: false,
            type: 'GET',
            success: function(data) {
              swalWithBootstrapButtons.fire({
                title: 'Deleted!',
                text: 'Your promotion menu has been deleted.',
                icon: 'success',
                confirmButtonText: 'ok',
                //location.href="/promo/promolist" ;
              }).then((result) => {
                if (result.value) {
                  location.href = "/promo/edit_promo/" + promoid;
                }
              })

            },
            error: function(thrownError) {
              console.log(thrownError);
            }
          }).promise().then(function(data) {
            console.log(data);
          });

          // Stop the forms default action method
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Promotion Deletion Cancelled',
            'error'
          )
        }
      })
    }

    function deleteAllMenu(bundleid) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete promotion menu!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: '/promo/delete_promodetails/' + bundleid,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            cache: false,
            type: 'GET',
            success: function(data) {
              if (data['status'] == 200) {
                swalWithBootstrapButtons.fire({
                  title: 'Deleted!',
                  text: 'Your promotion menu has been deleted.',
                  icon: 'success',
                  confirmButtonText: 'ok',
                  //location.href="/promo/promolist" ;
                }).then((result) => {
                  if (result.value) {
                    location.href = '/promo/'+ bundleid+'/edit_promo';
                  }
                })
              } else {
                var stext = data['error'];
                swalWithBootstrapButtons.fire({
                  title: 'OOPPSS!',
                  text: stext,
                  icon: 'error',
                  confirmButtonText: 'OK',
                  //location.href="/promo/promolist" ;
                }).then((result) => {
                  if (result.value) {
                    location.href = "/promo/edit_promo/" + bundleid;
                  }
                })

              }

            },
            error: function(thrownError) {
              console.log(thrownError);
              swalWithBootstrapButtons.fire(
                'OPPSSS!',
                'There has been a problem editing your Promotion Menu.',
                'error'
              )
            }
          }).promise().then(function(data) {
            console.log(data);
          });

          // Stop the forms default action method
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Promotion Deletion Cancelled',
            'error'
          )
        }
      })
    }
  </script>
  @endsection