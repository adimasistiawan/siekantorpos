@extends('template')
@section('title')
    Dashboard | Kantor Pos Denpasar
@endsection

@section('css')
    
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            {{-- <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div> --}}
            <!-- /.box-header -->
            <div class="box-body">
              <h1>Selamat Datang</h1>
              
            </div>
            @csrf
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('js')
<script src="{{asset('plugins/chart.js/Chart.js')}}"></script>
@endsection