@extends('layouts.adminlte')
@section('title','Report')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
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
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="province" class="label-control" style="width:100%">Province</label>
                        <select class="form-control select2" name="province" id="province" style="width: 100%;">
                            <option value="">-Select Province-</option>
                            
                        </select>
                    </div>  
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="city" class="label-control" style="width:100%">City</label>
                        <select class="form-control select2" name="city" id="city" style="width: 100%;">
                            
                        </select>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <p class="m-0">Report</p>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Province</th>
                                    <th>City</th>
                                    <th>Vaccines</th>

                                </tr>
                            </thead>
                            <tbody>
            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    @include('partials.small_modal')
</section>
@endsection
@section('script')
<!-- DataTables -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<!-- config datatable -->
<script>
var datatable = $('#table').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax":{
                "url": "{{ env('APP_URL').'/api/report' }}",
                "dataType": "json",
                "type": "get",
                "data":function (data) {
                    data.province = $('#province').val()
                    data.city = $('#city').val()

                }
              
    },
    
    "columns": [

        { "data": "name" },
        { "data": "type" },
        { "data": "province" },
        { "data": "city" },
        { "data": "vaccines" },


    ],
});
</script>
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>

<script>
    $('#province').select2({
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

$('#province').on('change',function(){
    datatable.draw();

    let province_id = $('#province').val();
    console.log(province_id);
    $("#city").val('').trigger('change');

    $('#city').select2({
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

$('#city').on('change',function(){
    datatable.draw();
});
</script>
@endsection