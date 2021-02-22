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
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Info Permintaan Barang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="datatable2" class="table table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th width="15px">No</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Tanggal Diminta</th>
                        @if(Auth::user()->level == "manager" || Auth::user()->level == "staff_kantor_pusat")
                        <th class="text-center">Tujuan</th>
                        @endif
                        <th class="text-center">Status</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($permintaan as $item)
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$item->kode}}</td>
                        <td class="text-center">{{date('d-m-Y', strtotime($item->tanggal_diminta))}}</td>
                        @if(Auth::user()->level == "manager" || Auth::user()->level == "staff_kantor_pusat")
                        <td>{{$item->kantor->nama}}</td>
                        @endif
                        
                        <td class="text-center">
                            @if($item->status == "Belum Dikonfirmasi")
                            <span class="badge bg-yellow">{{$item->status}}</span>
                            @elseif($item->status == "Telah Dikirim")
                            <span class="badge bg-light-blue">{{$item->status}}</span>
                            @elseif($item->status == "Telah Diterima")
                            <span class="badge bg-green">{{$item->status}}</span>
                            @else
                            <span class="badge bg-red">{{$item->status}}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            
                            <a class="btn btn-primary" href="{{route('permintaanbarang.show',$item->id)}}"><i class="fa fa-search"></i></a>
                            
                                
                        </td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                    @endforeach

                </tbody>
            </table>
              
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