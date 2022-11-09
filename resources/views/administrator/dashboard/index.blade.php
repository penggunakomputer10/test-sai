@extends('layouts.adminlte')
@section('title','Dashboard')
@section('style')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
        @foreach($faskes['data'] as $f)
                @php
                    if($f['faskes_name'] == 'rumah sakit'){
                        $bg = 'info';
                    }else if($f['faskes_name'] == 'puskesmas'){
                        $bg = 'success';
                    }else if($f['faskes_name'] == 'klinik'){
                        $bg = 'warning';
                    }else{
                        $bg = 'info';
                    }
                @endphp
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-{{ $bg }}">
                    <div class="inner">
                        <h3>{{$f['total']}}</h3>

                        <p>{{ ucwords($f['faskes_name']) }}</p>
                    </div>
                    <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    
                    </div>
                </div>
            @endforeach
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$faskes['total']}}</h3>

                    <p>{{ 'Total Faskes' }}</p>
                </div>
                <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                </div>  
                
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="table-responsive-sm">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th width="2">No</th>
                                <th>Vaccine Name</th>
                                <th>Count</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
        
                        </tbody>
                    </table>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    "order": [[ 3, "DESC" ]],
    "ajax":{
                "url": "{{ route('vaccine.table') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
    "columns": [
        { "data": "angka" },

        { "data": "name" },
        { "data": "count" },

        { "data": "created_at" },

    ],
    "columnDefs": [ {
        "targets": [0,2],
        "orderable": false
    }]

});
</script>
@endsection