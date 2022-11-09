@extends('layouts.adminlte')
@section('title')
@if($data == null)
{{"Add Faskes"}}
@else
{{'Edit :'. $data->name}}
@endif
@endsection
@section('style')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
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
@endsection
@section('content')
<section class="content">
    <form action="{{($data==null)? route('faskes.store') : route('faskes.update',$data->id)}}" method="post" id="form-page">
        @csrf
        @if($data != null)
            @method('put')
        @endif
        <div class="row">
            <div class="col-md-8">
                <!-- Default box -->
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ ($data==null) ? '' : $data->name }}">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ ($data==null) ? '' : $data->telephone }}">
                        </div>
    
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" cols="30" rows="3" class="form-control">{{ ($data==null) ? '' : $data->address }}</textarea>
                        </div>  
                        
                                      
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                @foreach($type as $o)
                                    <option value="{{$o}}" @if($data !== null) {{ ($data->type == $o) ? 'selected' : '' }} @endif>{{ ucwords($o) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="province_id" class="label-control" style="width:100%">Province</label>
                            <select class="form-control select2" name="province_id" id="province_id" style="width: 100%;">
                                <option value="">-Select Province-</option>
                                @if($data != null)
                                    @php
                                        $selected = \App\Models\Province::find($data->province_id);
                                    @endphp
                                    <option value="{{$selected->id}}" selected>{{$selected->name}}</option>
                                @endif
                            </select>
                        </div>   


                        <div class="form-group">
                            <label for="city_id" class="label-control" style="width:100%">City</label>
                            <select class="form-control select2" name="city_id" id="city_id" style="width: 100%;">
                                <option value="">-Select City-</option>
                                @if($data != null)
                                    @php
                                        $selected = \App\Models\City::find($data->city_id);
                                    @endphp
                                    <option value="{{$selected->id}}" selected>{{$selected->name}}</option>
                                @endif
                            </select>
                        </div>   

    
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Vaccine</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th width="150">Quota</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data !== null)
                                    @include('administrator.faskes.row_db')
                                @endif
                            </tbody>
                        </table>
                        <button class="btn btn-info mt-2" type="button" id="add_more">Add Row</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <a href="{{route('faskes.index')}}" class="btn btn-warning" type="button"><i class="fas fa-arrow-left"></i> Back</a>
                        <button class="btn btn-success" id="page-btn-save"><i class="fas fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
@section('script')

<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>

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

$('#province_id').on('change',function(){
    let province_id = $('#province_id').val();
    $("#city_id").val('').trigger('change');

    $('#city_id').select2({
        placeholder: "Choose City...",
        // minimumInputLength: 2,
        // dropdownParent: $('#modal1'),
        ajax: {
            url: "{{route('city.select2')}}",
            dataType: 'json',
            data: function (params) {
                return {
                    search: $.trim(params.term),
                    province_id : province_id
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

})
    // Insert Action
$('body').on('keydown', '#form-page', function (e) {
    if (e.keyCode == 13 && ($(event.target)[0] != $("textarea")[0])){
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

<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>


<script>
    $('#add_more').on('click',function(){
        showLoader();
        addForm();
        hideLoader();
    });

    $('body').on('click','#delete',function(e){
        $(this).closest("tr")
         .remove();
    });

    function addForm(){
        let url = "{{ route('faskes.row') }}";
        $.ajax({
            url: url,
            dataType: 'html',
            success: function (response) {
                // console.log(response);
                $('#table').find('tbody').append(response);

            }
        });
    }


</script>
@if($data !== null)

@foreach($data->vaccines as $p)
<!-- setup select2 -->
<script>
$("{{ '#'.$p->id }}").select2({
    placeholder: "Choose Vaccine...",
    allowClear: true,
    // theme:"classic",
    ajax: {
        url: "{{route('vaccine.select2')}}",
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
@endforeach 


<script>
    $('#city_id').select2({
        placeholder: "Choose City...",
        // minimumInputLength: 2,
        // dropdownParent: $('#modal1'),
        ajax: {
            url: "{{route('city.select2')}}",
            dataType: 'json',
            data: function (params) {
                return {
                    search: $.trim(params.term),
                    province_id : "{{$data->province_id}}"
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

@endif
@endsection

