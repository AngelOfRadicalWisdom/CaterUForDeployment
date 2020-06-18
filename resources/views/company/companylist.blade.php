@extends('layouts.mainlayout')

@section('content')

 <!-- page content -->
 <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              <h3>Company</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Company List</h2>
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
                            <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                        <th style="text-align:center">Logo</th>
                        <th style="text-align:center">Company Name</th>
                        <th style="text-align:center">Address</th>
					              <th style="text-align:center">Email</th>
                        <th style="text-align:center">TIN</th>
					              <th style="text-align:center">Action</th>
                        </tr>
                        </thead>  

                      <tbody>
                      @foreach($lists as $companyList)
            <tr>
            <td style="text-align:center"><img src="{{asset('/company/company_images/'.$companyList->logo)}}"  style="width:40px;height:40px;"
             ></td>
            <td style="text-align:center">{{ $companyList->companyname}}</td>
            <td style="text-align:center">{{ $companyList->address}}</td>
            <td style="text-align:center">{{$companyList->email}}</td>
            <td style="text-align:center">{{$companyList->tin}}</td>
            <td style="text-align:center">
                <a data-toggle="tooltip" data-placement="top" title="Edit Company" href="{{ url('/company/edit_company/'.$companyList->id)}}"><img src="{{ asset('/assets/svg/pencil.svg') }}" alt="" width="20px" height="20px"></a>&emsp;
                <a data-toggle="tooltip" data-placement="top" title="Delete Company" onclick="deleteCompany({{$companyList->id}})"><img src="{{ asset('/assets/svg/trash.svg') }}" alt="" width="20px" height="20px"></a>&emsp;
            </td>
        </tr>
        @endforeach
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
        @include('sweetalert::alert')
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
      function deleteCompany(companyid){
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
  confirmButtonText: 'Yes, delete company!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    $.ajax({
                url:'/company/delete_company/'+companyid,
               processData: false,
                contentType: false,
                dataType: 'JSON',
                cache: false,
                type: 'GET',
                success: function(data) {
                  swalWithBootstrapButtons.fire({
      title: 'Deleted!',
      text: 'Employee has been deleted.',
      icon: 'success',
      confirmButtonText: 'ok', 
       //location.href="/promo/promolist" ;
     } ).then((result) => {
  if (result.value) {
     location.href="/company/companylist" ;
  }
     })
   
        },
        error:  function(thrownError){
          console.log(thrownError);
          swalWithBootstrapButtons.fire(
      'OPPSSS!',
      'There has been a problem deleting emplyoee.',
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
      'Employee Deletion Cancelled',
      'error'
    )
  }
})

}
      </script>
@endsection


