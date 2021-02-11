@extends('template')
@section('title')
Lihat Barang Keluar | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Lihat Barang Keluar
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li >Barang Keluar</li>
        <li class="active">Lihat Barang Keluar</li>
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
                            <th style="width: 100px">Tujuan</th>
                            <td  style="width: 10px"> : </td>
                            <td>{{$barangkeluar->kantor->nama}}</td>
                        </tr>
                      
                        <tr>
                            <th>Kode</th>
                            <td> : </td>
                            <td>{{$barangkeluar->kode}}</td>
                        </tr>
                        <tr>
                          <th>Tanggal</th>
                          <td> : </td>
                          <td>{{date('d-m-Y', strtotime($barangkeluar->tanggal))}}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Oleh</th>
                            <td> : </td>
                            <td>{{$barangkeluar->user->nama}}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td> : </td>
                            <td>{{$barangkeluar->keterangan}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12" style="margin-top:50px;">
                  <table class="table table-bordered" style="width: 60%">
                    <thead>
                      <th width="50px">No</th>
                      <th width="300px">Barang</th>
                      <th width="200px">Satuan</th>
                      <th width="200px">Jumlah</th>
                    </thead>
                    <tbody id="tbody">
                      <?php $no = 1?>
                      @foreach($detail as $value)
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
                                  {{$value->jumlah}}
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