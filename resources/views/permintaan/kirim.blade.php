@extends('template')
@section('title')
Kirim Barang | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kirim Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li >Data Permintaan</li>
        <li class="active">Kirim Barang</li>
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
                  <table class="table table-bordered" style="width: 80%">
                    <thead>
                      <th width="50px">No</th>
                      <th width="250px">Barang</th>
                      <th width="100px">Satuan</th>
                      <th width="130px">Jumlah Diminta</th>
                      <th width="100px">Stok Tersedia</th>
                      <th width="200px">Jumlah Dikirim</th>
                    </thead>
                    <tbody id="tbody">
                        <form action="{{route('permintaanbarang.dikirim',$permintaan->id)}}" method="post">
                            @csrf
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
                              <td class="text-right">
                                {{$value->barang->stok}}
                                <input type="hidden" class="stok" value="{{$value->barang->stok}}">
                              </td>
                              <td>
                                
                                <input type="hidden" class="id input-value" name="id[]" value="{{$value->id}}">
                                <input type="text" onkeypress="return isNumberKey(event);" class="jmldikirim form-control input-mini input-value" name="jumlah_dipenuhi[]" required>
                                <span class="text-red wrong" hidden>Jumlah Dikirim tidak boleh melebihi Stok Tersedia</span>
                              </td>
                          </tr>
                          <?php $no++?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            @if(Auth::user()->level != "staff_kantor_cabang")
            <div class="box-footer">
              
              <button class="btn btn-primary simpan" onclick="this.form.target='_self';return confirm('Apakah kamu yakin ingin mengirim barang ini?')" type="submit" >Kirim</button>
              </form>
            </div>
            @endif
          </div>
          
        </div>
      </div>
    </section>
  </div>


  
  <!-- /.modal -->  

@endsection

@section('js')
<script>
     function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
    $(document).ready(function(){
        

        $(document).on('keyup', '.jmldikirim', function() {
            var row = $(this).closest('.tr');
            stok = $(row).find('.stok');
            wrong = $(row).find('.wrong');
            if($(this).val() > parseInt($(stok).val())){
              $(wrong).removeAttr('hidden');
              $('.simpan').prop('disabled', true);
            }
            else{
              $(wrong).attr('hidden',true);
              $('.simpan').prop('disabled', false);
            }
            var hidden = $('#tbody').find('.wrong')
            $(hidden).each( function() {
                    if ($(this).is(":visible")){
                      $('.simpan').prop('disabled', true);
                      return false;
                    }
            });
          })
    })
</script>
@endsection