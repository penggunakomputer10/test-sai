@extends('layouts.adminlte')
@section('title','General Setting')
@section('style')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">

                   <form action="{{route('general.update')}}" method="put" id="form-page" title="General Setting">
                       @csrf
                       @method('put')
                       <div class="form-group">
                           <label for="app_name">App Name</label>
                           <input type="text" name="app_name" id="app_name" class="form-control" value="{{ $data['app_name'] }}">
                       </div>
                       <div class="form-group">
                           <label for="company_name">Company Name</label>
                           <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $data['company_name'] }}">
                       </div>
                       <div class="form-group">
                           <label for="copy_right">Copy Right</label>
                           <input type="text" name="copy_right" id="copy_right" class="form-control" value="{{ $data['copy_right'] }}">
                       </div>
                       <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="page-btn-save">Update</button>
                        </div>
                   </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
@endsection
@section('script')
<script>
    // Insert Action
$('body').on('keydown', '#form-page', function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        simpanByForm('#form-page');
        clearOK();
            


        return false;
    }
});


$('#page-btn-save').on('click', function (e) {
    e.preventDefault();
    simpanByForm('#form-page');
    clearOK();


    
})


function clearOK(){
    $('input').blur();
    $('#password').val('');
    $('#password_confirmation').val('');
    $('.custom-file-label').text('Choose file');
    $('#undo-btn').remove();
    $("#sidebar").load(window.location + " #sidebar");
}


</script>
@endsection