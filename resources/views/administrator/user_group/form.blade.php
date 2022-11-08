<form action="{{($data==null)? route('user_group.store') : route('user_group.update',$data->id)}}" id="form-modal" title="User Group" method="POST">
    
    @csrf
    @if($data != null)
        @method('put')
    @endif

    <div class="form-group">
        <label for="name" @if($data !== null) class="label-control" @endif>User Group Name</label>
        <input type="text" name="name" id="name" class="form-control"  autocomplete="off" autofocus value="{{ ($data == null) ? '' : $data->name }}">
    </div>    
</form>