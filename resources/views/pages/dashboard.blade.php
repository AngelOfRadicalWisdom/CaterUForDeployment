@extends('layouts.mainlayout')

@section('maincontent')
<div class="container-fluid">
    <h3>Dashboard</h3>
    <hr>
<div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="card">
             <div class="card-body" id="form-group">
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Menu ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Sales</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2001</td>
                            <td>Pork and Siomai</td>
                            <td>Main</td>
                            <td class="process">10%</td>
                        </tr>
                        <tr>
                            <td>2002</td>
                            <td>Pork and Siomai</td>
                            <td>Main</td>
                            <td class="process">.03%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
             </div>
        </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
</div>
@endsection
