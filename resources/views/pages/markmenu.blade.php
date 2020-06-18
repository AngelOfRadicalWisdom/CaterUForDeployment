@extends('mainlayout')

@section('js_code')
<script type="text/javascript">
$('#markMenuModal').modal({
    backdrop:'static',
    keyboard: true
});
$('#btn-delete').on('click', function (e) {
    e.preventDefault();
    window.location.assign("{{ url('/menu/'.$menuID.'/delete') }}");
});

</script>
@endsection

@section('content')

@include('pages.menulist')

<div class="modal fade" id="markMenuModal" tabindex="-1" role="dialog" aria-labelledby="markMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markMenuModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <span>Menu ID: </span><span>{{ $menuID }}</span><br>
                <span>Name: </span><span>{{ $menuName }}</span><br>
                <span>Detail: </span><span>{{ $details }}</span><br>
                <span>Price: </span><span>{{ $price}}</span><br>
                <span>Serving Size: </span><span>{{ $servingsize }}</span>
                <span>SubCategory: </span><span> {{ $subcatid}}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="btn-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
