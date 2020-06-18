@extends('layouts.mainlayout')

@section('content')

 <!-- page content -->
 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              <h3>Apriori</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                  <h2>Frequently Bought Menus</h2>
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
                    <div class="col-md-12 col-sm-12 ">
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                            <div class="card-box table-responsive">
                            <div class="col-md-12 col-sm-12 ">
                      <div class="item form-group">
                        <label class="col-form-label">Show: </label>
                        <div class="col-md-3 col-sm-3 ">
                        <select name="itemfilter" id="itemfilter" class="form-control" >
                        <option value="">All Item Sets...</option>
                        @foreach($ItemSets as $items)
                            <option value="{{$items->count}}">{{$items->count}} Item Sets</option>
                        @endforeach
                            </select>
                        </div>
                        <a href="{{url('/genapr')}}"class="btn btn-success">Generate Recommendation</a>
                      </div>
                    <table id="apriori" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                        <th style="text-align:center">Group No.</th>
                        <th style="text-align:center">Menu</th>
                        <th style="text-align:center">Menu Count</th>
                        <th style="text-align:center">Order Count</th>
                      
                        </tr>
                        </thead>  
                        <tbody>
                      @for($i=0;$i< count($sMenus);$i++)
                  
            <tr>
                <td style="text-align:center">
                <div class="form-group row">
                          <div class="checkbox">
                            <label>
                             {{$i+1}}
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
                              <li id="iMenus" name="iMenus" > {{$menuName->name}}</li>
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
                {{$frequentCount[$i]}}
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
        <!-- /page content -->
        <script src="{{asset('/vendors/jquery/dist/jquery.min.js')}}"></script>
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

$( document ).ready(function() {
      var sTable;
        sTable = $('#apriori').DataTable({
            autoWidth: true,
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "paging":true,
            "columnDefs": [ { "targets": [ 2 ], "visible": false, "searchable": true }]
        });
        $('#itemfilter').change(function(){
          //$('#suggestedmenu').DataTable().clear().draw();
          sTable.columns(2).search(this.value).draw();
  
      });
});
    </script>
@endsection


