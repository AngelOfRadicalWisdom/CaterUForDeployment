@extends('layouts.mainlayout')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Order List</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>List of all the Order</h2>
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
            <form name="datatable-fixed-header" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ url('/orderList')}}" >
            <div class='col-sm-4'>
                    From
                    <div class="form-group">
                        <div class='input-group date' id='from'>
                            <input type='text' class="form-control" name="from" required="required"/>
                            <span class="input-group-addon">
                               <span class="fa fa-calendar-check-o"  aria-hidden="true"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-sm-4'>
                    To
                    <div class="form-group">
                        <div class='input-group date' id='to'>
                            <input type='text' class="form-control" name="to" required="required"/>
                            <span class="input-group-addon">
                               <span class="fa fa-calendar-check-o" aria-hidden="true"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                      <div class="item form-group">
                        <div>
                          <button type="submit" class="btn btn-success" id="savepromo">Submit</button>
                          <a href="{{url('/dashboard')}}" class="btn btn-primary">Back to Order List</a>
                        </div>
                      </div>
                
            </form>
          </div>
                      <table id="menu" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                          <tr>
                          <th style="text-align:center">Order Id</th>
                            <th style="text-align:center">Orders</th>
                            <th style="text-align:center">Date Ordered</th>
                            <th style="text-align:center">Total</th>
                          
                          </tr>
                        </thead>
                       <tbody>
                        @for($i=0;$i< count($menudetails);$i++)
                          <tr>
                            <td style="text-align:center">
                            @foreach($Oids[$i] as $ids )
                            {{$ids}}
                            @endforeach
                          </td>
                            <td style="text-align:center"> 
                            @foreach($menudetails[$i] as $menus )
                             <div class="form-group row">
                            <div class="checkbox">
                              <li id="iMenus" name="iMenus"> {{$menus}}</li>
                            </div>
                          </div>
                            @endforeach
                          
                            </td>
                            <td  style="text-align:center">
                            @foreach($orderDate[$i] as $date)
                            {{$date}}
                            @endforeach
                            </td>
                            <td  style="text-align:center">
                            @foreach($bill[$i] as $total )
                            Php {{$total}}.00
                            @endforeach
                            </td>
                          </tr>
                          @endfor
                      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('sweetalert::alert')
<!-- /page content -->
<!-- jQuery -->
<script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
         <!-- bootstrap-daterangepicker -->
       <script src="{{asset('/vendors/moment/min/moment.min.js')}}"></script>
       <script src="{{asset('/vendor/sweetalert/sweetalert.all.js')}}"></script>
    <script src="{{asset('/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="{{asset('/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
 <!-- Ion.RangeSlider -->
 <script src="{{asset('/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>
    <!-- Bootstrap Colorpicker -->
    <script src="{{asset('/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- jquery.inputmask -->
    <script src="{{asset('/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <!-- jQuery Knob -->
    <script src="{{asset('/vendors/jquery-knob/dist/jquery.knob.min.js')}}"></script>
    <!-- Cropper -->
    <script src="{{asset('/vendors/cropper/dist/cropper.min.js')}}"></script>
    <script src="{{asset('/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/vendor/sweetalert/sweetalert.all.js')}}"></script>
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
<script>
    $(document).ready(function() {
      var sTable;
      sTable = $('#menu').DataTable({
        autoWidth: true,
        "processing": true,
        "serverSide": false,
        "deferRender": true,
        "paging": true,
        "columnDefs": [{
          "targets": [2],
          "searchable": true
        }]
      });
      $('#itemfilter').change(function() {
        sTable.order([2,this.value]).draw();

      });
    });
	</script>
 <!-- Initialize datetimepicker -->
 <script  type="text/javascript">
   $(function () {
                $('#myDatepicker').datetimepicker();
            });
    
    $('#from').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('#to').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    
    $('#myDatepicker3').datetimepicker({
        format: 'hh:mm A'
    });
    
    $('#myDatepicker4').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $('#datetimepicker6').datetimepicker();
    
    $('#datetimepicker7').datetimepicker({
        useCurrent: false
    });
    
    $("#datetimepicker6").on("dp.change", function(e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker7").on("dp.change", function(e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });
</script>

@endsection