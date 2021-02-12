@extends('template')
@section('title')
Lihat Data Permintaan | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Lihat Data Permintaan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li >Data Permintaan</li>
        <li class="active">Lihat Data Permintaan</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    @csrf
                    <table>
                      
                        <tr>
                            <th style="width: 160px">Kode</th>
                            <td style="width: 10px"> : </td>
                            <td>{{$permintaan->kode}}</td>
                        </tr>
                        <tr>
                          <th>Tanggal Diminta</th>
                          <td> : </td>
                          <td>{{date('d-m-Y', strtotime($permintaan->tanggal_diminta))}}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dipenuhi</th>
                            <td> : </td>
                            <td>{{$permintaan->tanggal_dipenuhi==null?"-":date('d-m-Y', strtotime($permintaan->tanggal_dipenuhi))}}</td>
                          </tr>
                        <tr>
                            <th>Tujuan</th>
                            <td> : </td>
                            <td>{{$permintaan->kantor->nama}}</td>
                        </tr>
                        <tr>
                            <th>Diminta Oleh</th>
                            <td> : </td>
                            <td>{{$permintaan->diminta->nama}}</td>
                        </tr>
                        <tr>
                            <th>Dipenuhi Oleh</th>
                            <td> : </td>
                            <td>{{$permintaan->dipenuhi==null?"-":$permintaan->dipenuhi->nama}}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td> : </td>
                            <td>
                                @if($permintaan->status == "Belum Dikonfirmasi")
                                <span class="badge bg-yellow">{{$permintaan->status}}</span>
                                @elseif($permintaan->status == "Dikirim")
                                <span class="badge bg-light-blue">{{$permintaan->status}}</span>
                                @elseif($permintaan->status == "Telah Diterima")
                                <span class="badge bg-green">{{$permintaan->status}}</span>
                                @else
                                <span class="badge bg-red">{{$permintaan->status}}</span>
                                @endif
                            </td>
                        </tr>
                        @if($permintaan->status == "Ditolak")
                        <tr>
                            <th>Alasan Ditolak</th>
                            <td> : </td>
                            <td>{{$permintaan->alasan_ditolak}}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12" style="margin-top:50px;">
                  <table class="table table-bordered" style="width: 60%">
                    <thead>
                      <th width="50px">No</th>
                      <th width="300px">Barang</th>
                      <th width="200px">Satuan</th>
                      <th width="200px">Jumlah Diminta</th>
                    </thead>
                    <tbody id="tbody">
                      <?php $no = 1?>
                      @foreach($permintaandetail as $value)
                          <tr class="tr">
                              <td>
                                  {{$no}}
                              </td>
                              <td>
                                  {{$value->barang->nama}}
                              </td>
                              <td>
                                  {{$value->barang->satuan->nama}}
                              </td>
                              <td class="text-right">
                                  {{$value->jumlah_diminta}}
                              </td>
                          </tr>
                          <?php $no++?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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
    
</script>
@endsection