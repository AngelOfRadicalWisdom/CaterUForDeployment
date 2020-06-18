@extends('mainlayout')
@section('content')
<div class="dots-separator">&nbsp;</div>
<div class="row">
<div class="col-12">
    <div class="box">
        <div class="card">
            <div class="card-body">
                <span>From</span>
                    <input type="date" name="from"/>
                    <span>To</span>
                    <input type="date" name="to"/>
                <button id="okBtn">OK</button>
                    <input type="text" id="order-search" name="search" placeholder="Search...">
            </div>
        </div>
<div class="card">
    <div class="card-body box2">
<div class="box-body no-padding">
    <div class="table-responsive">
        <table class="table table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Date</th>
            <th>Menu ID</th>
            <th>Menu Name</th>
            <th>Menu Prices</th>
            <th>Menu Sales</th>
            <th>Sales</th>
        </tr>
    </thead>
            @foreach($menus as $menu)
                @foreach($details as $detail)
                    <tr>
                        <td>{{ $detail->date_ordered}}</td>
                        <td>{{ $menu->menuID}}</td>
                        <td>{{ $menu->name}}</td>
                        <td>{{$menu->getSumQty($menu->menuID)}}</td>
                        <td>{{ $menu->getTotal($menu->menuID)}}</td>
                    </tr>
                @endforeach
            @endforeach
    </table>
    </div>
</div>
</div>
</div>

<div class="dots-separator">&nbsp;</div>
<div class="footer">
    <div class="card">
        <div class="card-body">
            footer
        </div>
    </div>

</div>
@endsection
@section('onchange')
<script type="text/javascript">
$(document).ready( function() {
    let now = new Date();

    let day = ("0" + now.getDate()).slice(-2);
    let month = ("0" + (now.getMonth() + 1)).slice(-2);

    let today = (day)+"-"+(month)+"-"+ now.getFullYear();


   $('#from').val(today);
   $('#to').val(today);

    $('#okBtn').click(function(){

        testClicked();

    });
});
function testClicked()
{
  $('.getDate').html($('#datePicker').val());
}

</script>
@endsection
