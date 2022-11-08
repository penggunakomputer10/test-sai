<form action="{{($data==null)? route('vaccine.store') : route('vaccine.update',$data->id)}}" id="form-modal" title="Vaccine" method="POST">
    
    @csrf
    @if($data != null)
        @method('put')
    @endif

    <div class="form-group">
        <label for="name" @if($data !== null) class="label-control" @endif>Name</label>
        <input type="text" name="name" id="name" class="form-control"  autocomplete="off" autofocus value="{{ ($data == null) ? '' : $data->name }}">
    </div>    
</form>