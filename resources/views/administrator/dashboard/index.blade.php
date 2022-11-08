@extends('layouts.adminlte')
@section('title','Dashboard')
@section('content')
<section class="content">
    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            Hallo <strong>{{ucwords(Auth::user()->name)}}</strong>, Start creating your amazing application!
        </div>

    </div>
    <!-- /.card -->

</section>
@endsection