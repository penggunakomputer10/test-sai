@extends('layouts.adminlte')
@section('title','User')
@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        <p class="m-0">List User</p>
                    </div>
                    <div class="float-right">
                        <a href="{{route('users.create')}}" title="Add New User" class="btn btn-sm btn-primary large-modal-show">Add New User</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th width="2">No</th>
                                    <th width="100">Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>User Group</th>
                                    <th>Created At</th>
                                    <th width="150">Action</th>
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
    @include('partials.large_model')
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
    "order": [[ 5, "DESC" ]],
    "ajax":{
                "url": "{{ route('users.table') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
    "columns": [
        { "data": "angka" },
        { "data": "image" },

        { "data": "name" },
        { "data": "email" },
        { "data": "user_group" },
        { "data": "created_at" },
        { "data": "action" }
    ],
    "columnDefs": [ {
        "targets": [0,1,4,6],
        "orderable": false
    }]

});
</script>
@endsection