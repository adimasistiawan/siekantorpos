@extends('template')
@section('title')
Barang Keluar | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Barang Keluar
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Barang Keluar</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Barang Keluar</h3>
              <a href="{{route('barangkeluar.create')}}" class="btn btn-primary pull-right" >
                Tambah Data
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="datatable" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="15px">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Tujuan</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Dibuat Oleh</th>
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
                            <td>{{$item->kantor->nama}}</td>
                            <td>{{date('d-m-Y', strtotime($item->tanggal))}}</td>
                            <td>{{$item->user->nama}}</td>
                            
                            <td class="text-center">
                                    <a class="btn btn-primary edit" href="{{route('barangkeluar.show',$item->id)}}">Lihat</a>
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