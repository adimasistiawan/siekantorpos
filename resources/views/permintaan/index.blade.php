@extends('template')
@section('title')
Permintaan Barang | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Permintaan Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Permintaan Barang</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Permintaan Barang</h3>
              @if(Auth::user()->level == "staff_kantor_cabang" || Auth::user()->level == "agen")
              <a href="{{route('permintaanbarang.create')}}" class="btn btn-primary pull-right" >
                Buat Permintaan
              </a>
              @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="datatable" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="15px">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Tanggal Diminta</th>
                            <th class="text-center">Tanggal Dipenuhi</th>
                            <th class="text-center">Tujuan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$item->kode}}</td>
                            <td class="text-center">{{date('d-m-Y', strtotime($item->tanggal_diminta))}}</td>
                            <td class="text-center">{{$item->tanggal_dipenuhi==null?"-":date('d-m-Y', strtotime($item->tanggal_dipenuhi))}}</td>
                            <td>{{$item->kantor->nama}}</td>
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
                                @if(Auth::user()->level == "staff_kantor_cabang" || Auth::user()->level == "agen")
                                
                                    @if($item->status == "Belum Dikonfirmasi" || $item->status == "Ditolak")
                                    <a class="btn btn-warning" href="{{route('permintaanbarang.edit',$item->id)}}">Ubah</a>
                                    <a class="btn btn-primary" href="{{route('permintaanbarang.show',$item->id)}}">Lihat</a>
                                    @else
                                    <a class="btn btn-primary" href="{{route('permintaanbarang.show',$item->id)}}">Lihat</a>
                                    @endif
                                @else
                                <a class="btn btn-primary" href="{{route('permintaanbarang.show',$item->id)}}">Lihat</a>
                                @endif
                                    
                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                        @endforeach

                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


  
  <!-- /.modal -->  

@endsection

@section('js')
<script>
$(document).ready(function(){
    @if(session()->has('success'))
         toastr.success("{{session('success')}}")
   
         
    @endif

    @if(session()->has('error'))
    $.alert("{{session('error')}}")
    @endif

    
    
 })
</script>
@endsection