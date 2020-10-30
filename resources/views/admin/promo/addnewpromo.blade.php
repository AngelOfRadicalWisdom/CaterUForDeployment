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
            <h2>Add Promo</h2>
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
            <form name="bundleform" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">

              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="code">Promotion Code <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" id="promoid" name="promoid" required="required" class="form-control " value="{{ old('promocode')}}" placeholder="Enter Promotion Code" min="1">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Promotion Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" id="promoname" name="promoname" required="required" class="form-control " value="{{ old('menuName')}}" placeholder="Enter Promotion Name">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="details">Details <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <textarea class="form-control" rows="3" id="details" name="details" placeholder="Enter Details">{{old('details')}}</textarea>
                </div>
              </div>
              <div class="item form-group">
                <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Price <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 ">
                  <input class="form-control" type="number" min="1" id="price" name="price" value="{{old('price') }}" placeholder="Enter Price">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Serving Size <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" class="form-control" id="servingsize" name="servingsize" value="{{old('servingsize')}}" min="1" placeholder="Enter Serving Size">
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
                <label class="col-md-6 col-sm-6 ">
                  <h4>Suggested Menus:</h4>
                </label>
                <div class="col-md-6 col-sm-6 ">
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <div class="item form-group">
                    <label class="col-form-label">Show: </label>
                    <div class="col-md-3 col-sm-3 ">
                      <select name="itemfilter" id="itemfilter" class="form-control">
                        <option value="">All Item Sets...</option>
                        @foreach($ItemSets as $items)
                        <option value="{{$items->count}}">{{$items->count}} Item Sets</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <table id="suggestedmenu" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th style="text-align:center">Group No</th>
                        <th style="text-align:center">Menus</th>
                        <th>No. of Menus</th>
                        <th style="text-align:center">Quantity</th>
                      </tr>
                    </thead>

                    <tbody>
                      @for($i=0;$i< count($sMenus);$i++) <tr>
                        <td style="text-align:center">
                          <div class="form-group row">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="icheckbox_flat-green" name="bundledmenu" value="{{$i+1}}"> {{$i+1}}
                              </label>
                            </div>
                          </div>
                        </td>
                        <td style="text-align:center">
                          @foreach($sMenus[$i] as $menus )
                          @foreach($allMenus as $menuName)
                          @if($menuName->menuID==$menus)
                          <div class="form-group row">
                            <div class="checkbox">
                              <li id="iMenus" name="iMenus"> {{$menuName->name}}</li>
                            </div>
                          </div>
                          @endif
                          @endforeach
                          @endforeach
                        </td>
                        <td>
                          {{count($sMenus[$i])}}
                        </td>
                        <td>
                          @foreach($sMenus[$i] as $menus )
                          @foreach($allMenus as $menuName)
                          @if($menuName->menuID==$menus)
                          <div class="form-group row" id="divSqty" name="divSqty">
                            <input class="form-control" type="number" min="1" id="sqty" name="{{$i+1}}" value="{{old('qty') }}" placeholder="Enter Quantity">
                          </div>
                          @endif
                          @endforeach
                          @endforeach
                        </td>
                        </tr>
                        @endfor
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="item form-group">
                <label class="col-md-6 col-sm-6 ">
                  <h4>Additional Menus:</h4>
                </label>
                <div class="col-md-6 col-sm-6 ">
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <table id="additionalmenu" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>Menu Name</th>
                        <th>Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($additionalMenus as $amenus)
                      <tr>
                        <td>
                          <div class="form-group row">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="icheckbox_flat-green" name="amenu" value="{{$amenus->menuID}}"> {{$amenus->name}}
                              </label>
                            </div>
                          </div>
                        <td>
                          <input class="form-control" type="number" min="1" id="{{$amenus->menuID}}" name="aqty" value="{{old('qty') }}" placeholder="Enter Quantity">
                        </td>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-4">
                  <button type="submit" class="btn btn-success" id="savepromo">Submit</button>
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
  <script type="text/javascript">
    var smenus = [];
    var amenus = [];
    var sqty = [];
    var aqty = [];
    var suggestedMenus = [];
    var bundleQuantity = [];
    var additionalQuantity = [];
    var additionalMenus = [];
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })
    $(document).ready(function() {
      $("input[id='sqty']").hide();
      $("input[name='aqty']").hide();
      console.log("ready!");
      var sTable, aTable;
      sTable = $('#suggestedmenu').DataTable({
        "processing": true,
        "serverSide": false,
        "deferRender": true,
        "paging": true,
        "columnDefs": [{
          "targets": [2],
          "visible": false,
          "searchable": true
        }]
      });
      aTable = $('#additionalmenu').DataTable({
        "processing": true,
        "serverSide": false,
        "deferRender": true,
        "paging": true,
      });

      $('#itemfilter').change(function() {
        sTable.columns(2).search(this.value).draw();

      });



      sTable.rows().nodes().to$().find("input[name='bundledmenu']").click(function() {
        var name = $(this).val();
        var sQty = document.getElementsByName(name);
        if (this.checked) {
          $(sQty).show();
          $(sQty).attr("required", "true");
        } else {
          $(sQty).hide();
          $(sQty).removeAttr("required");
          $(sQty).val('');
        }
      });

      aTable.rows().nodes().to$().find("input[name='amenu']").click(function() {
        var id = $(this).val();
        var aQty = document.getElementById(id);
        if (this.checked) {
          $(aQty).show();
          $(aQty).attr("required", "true");
        } else {
          $(aQty).hide();
          $(aQty).removeAttr("required");
          $(aQty).val('');
        }

      });
      $("form[name=bundleform]").submit(function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        // Iterate over all checkboxes in the table
        sTable.rows().nodes().to$().find("input[name='bundledmenu']:checked").each(function() {
          // If checkbox doesn't exist in DOM
          if (this.checked) {
            // If checkbox is checked
            smenus.push($(this).val());

            //  allMenus.push(smenus);
          }
        });
        sTable.rows().nodes().to$().find("input[id='sqty']").each(function() {
          if ($(this).val() != 0) {
            sqty.push($(this).val());
          }

        });
        if (smenus.length != 0) {
          if (sqty.length != 0) {
            suggestedMenus.push(smenus);
            bundleQuantity.push(sqty);
            formData.append('suggestedmenus', suggestedMenus);
            formData.append('squantity', bundleQuantity);
          }
        }

        aTable.rows().nodes().to$().find("input[name='amenu']:checked").each(function() {
          // If checkbox doesn't exist in DOM
          // if(!$.contains(document, this)){
          // If checkbox is checked
          if (this.checked) {
            amenus.push($(this).val());
          }


        });
        aTable.rows().nodes().to$().find("input[name='aqty']").each(function() {
          if ($(this).val() != 0) {
            aqty.push($(this).val());
          }
        });
        if (amenus.length != 0) {
          additionalMenus.push(amenus);
          formData.append('additionalmenus', additionalMenus);
          formData.append('aquantity', aqty);
        }
        console.log(aqty);
        var promoid = document.getElementById("promoid").value;
        var details = document.getElementById("details").value;
        var price = document.getElementById("price").value;
        var servingsize = document.getElementById("servingsize").value;

        var image = $('#image').prop('files')[0];
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),

          }
        });
        $.ajax({
          url: '/savepromo',

          processData: false,
          contentType: false,
          dataType: 'JSON',
          cache: false,
          data: formData,
          type: 'POST',
          success: function(data) {

            if (data['status'] == 500) {
              var stext = data['error'];
              swalWithBootstrapButtons.fire({
                title: 'OOPPSS!',
                text: stext,
                icon: 'error',
                confirmButtonText: 'ok',
              }).then((result)=>{
              if(result.value){
                location.href = "/promo/addpromo";

              }
              }
              )
            } else {

              swalWithBootstrapButtons.fire({
                title: 'Added!',
                text: 'Successfully Added New Promotion.',
                icon: 'success',
                confirmButtonText: 'ok',

              }).then((result) => {
                if (result.value) {
                  location.href = "/promo/promolist";
                }
              })

            }

          },
          error: function(thrownError) {
            console.log(thrownError);
            swalWithBootstrapButtons.fire(
              'OPPSSS!',
              'There has been a problem adding your Promotion Menu.',
              'error'
            ).then((result)=>{
              if(result.value){
                location.href = "/promo/addpromo";
              }

              })
          }
        }).promise().then(function(data) {
          console.log(data);
        });

        // Stop the forms default action method


      });


    });
  </script>
  @endsection