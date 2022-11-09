<!-- Select2 -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
<!-- <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> -->
<style>
        .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 37px;
    user-select: none;
    -webkit-user-select: none;

}
</style>
<form action="{{($data==null)? route('users.store') : route('users.update',$data->id)}}" id="form-modal" title="User" method="POST" enctype="multipart/form-data">
    
    @csrf
    @if($data != null)
        @method('put')
    @endif

    <div class="form-group">
        <label for="name" @if($data !== null) class="label-control" @endif>Name</label>
        <input type="text" name="name" id="name" class="form-control" autofocus value="{{ ($data == null) ? '' : $data->name }}">
    </div>   
    <div class="form-group">
        <label for="email" @if($data !== null) class="label-control" @endif>Email</label>
        <input type="text" name="email" id="email" class="form-control"  value="{{ ($data == null) ? '' : $data->email }}">
    </div>
    <div class="form-group">
        <label for="user_group" class="label-control" style="width:100%">User Group</label>
        <select class="form-control select2" name="user_group" id="user_group" style="width: 100%;">
            @if($data != null)
                @php
                    $selected = \Spatie\Permission\Models\Role::find($data->role_id);
                @endphp
                <option value="{{$selected->id}}">{{$selected->name}}</option>
            @endif
        </select>

    </div>   
    <div class="form-group">
        <label for="password" @if($data !== null) class="label-control" @endif>Password</label>
        <input type="password" name="password" id="password" class="form-control"  value="">
        @if($data !== null) <small style="color:red">leave blank if you don't want to change the password </small> @endif
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="image" name="image">
            <label class="custom-file-label" for="image">Choose file</label>
        </div>
        <div id="showImagePreview">
            @if($data !== null)
            <div id="imageview">
                <br>
                <img src="{{ ($data->image == 'default.png') ? asset('images/users/'.$data->image) : asset('images/users/'.$data->id.'/original/'.$data->image) }}" alt=""  class="img-fluid" width="30%">
                <br>
            </div>
            <input type="hidden" name="old_image" value="{{$data->image}}">
            @endif
        </div>
    </div>
</form>

<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- setup select2 -->
<script>
$('#user_group').select2({
    placeholder: "Choose User Group...",
    // minimumInputLength: 2,
    // dropdownParent: $('#modal1'),
    ajax: {
        url: "{{route('user_group.select2')}}",
        dataType: 'json',
        data: function (params) {
            return {
                search: $.trim(params.term)
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var url =  e.target.result;
            var image = '<div id="imageview"><br><img src="'+url+'" alt=""  class="img-fluid" width="30%"><br><button id="removePreview" type="button" class="badge badge-sm badge-danger">Delete</button></div>';  
            $('#showImagePreview').append(image);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
        
    }
}

$("#image").change(function() {
  $('#imageview').remove();
  previewImage(this);
});

$(function () {
  bsCustomFileInput.init();
});

</script>