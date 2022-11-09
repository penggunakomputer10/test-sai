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
<form action="{{($data==null)? route('city.store') : route('city.update',$data->id)}}" id="form-modal" title="City" method="POST">
    
    @csrf
    @if($data != null)
        @method('put')
    @endif

    <div class="form-group">
        <label for="province_id" class="label-control" style="width:100%">Province</label>
        <select class="form-control select2" name="province_id" id="province_id" style="width: 100%;">
            @if($data != null)
                @php
                    $selected = \App\Models\Province::find($data->province_id);
                @endphp
                <option value="{{$selected->id}}">{{$selected->name}}</option>
            @endif
        </select>

    </div>   

    <div class="form-group">
        <label for="name" @if($data !== null) class="label-control" @endif>Name</label>
        <input type="text" name="name" id="name" class="form-control"  autocomplete="off" autofocus value="{{ ($data == null) ? '' : $data->name }}">
    </div>
     
</form>

<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- setup select2 -->
<script>
$('#province_id').select2({
    placeholder: "Choose Province...",
    // minimumInputLength: 2,
    // dropdownParent: $('#modal1'),
    ajax: {
        url: "{{route('province.select2')}}",
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

</script>