@extends('layouts.adminlte')
@section('title','Dashboard')
@section('style')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
    </div>
</section>
@endsection