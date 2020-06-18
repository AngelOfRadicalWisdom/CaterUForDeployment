$(function(){
    $('#markMenuModal').modal({
        backdrop:'static',
        keyboard:true
    });
    $('#btn-delete').on('click', function (e) {
        e.preventDefault();
        window.location.assign("{{ url('/menu/'.$menuRecord->menuID.'/delete') }}");
    });

});