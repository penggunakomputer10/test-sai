@extends('layouts.adminlte')
@section('title','My Profile')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        @php
                            $userImage = (auth()->user()->image == 'default.png') ? asset('images/users/'.auth()->user()->image) : asset('images/users/'.auth()->user()->id.'/original/'.auth()->user()->image);
                        @endphp
                        <img src="{{$userImage}}" class="img-fluid" id="img-profile" alt="User Image">
                    </div>
                    <button class="btn btn-flat btn-info btn-block mt-3" id="btn-info-name">{{ ucwords(auth()->user()->name) }}</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Default box -->
            <div class="card">
                <div class="card-body">
                    <form action="{{route('users.update_profile')}}" method="put" id="form-page" title="Profile {{$data->name}}">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Full Name</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name"  id="name" value="{{ $data->name }}">
                            <input type="hidden" class="form-control" id="old_image" name="old_image" value="{{ $data->image }}">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                                <div id="wadah_tombol">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">Password Confirmation</label>
                            <div class="col-sm-9">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                            </div>
                        </div>
                        
                       
                        
                        <div class="form-group row">
                            <div class="col-md-10 offset-md-3">
                            <button type="submit" class="btn btn-primary" id="page-btn-save">Update</button>
                            </div>
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
    function previewImage(input) {
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var url =  e.target.result;
            // console.log(url);
            $('#img-profile').attr("src",url);
            $('#wadah_tombol').append('<button class="btn btn-sm mt-2 btn-flat btn-default" type="button" id="undo-btn"><i class="fas fa-undo"></i></button>');
            
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
        
    }
}

$("#image").change(function() {
  $('#undo-btn').remove();
  previewImage(this);
});

$('body').on('click','#undo-btn',function(e){
    $('#img-profile').attr("src","{{$userImage}}");
    $('.custom-file-label').text('Choose file');
    $('#undo-btn').remove();
    
    
})


$('#name').on('keyup',function(){
    var string = $('#name').val();
    string = string.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
});
    $("#btn-info-name").html(string);
});



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