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
                                @elseif($permintaan->status == "Telah Dikirim")
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
                      @if($permintaan->status == "Telah Dikirim")
                      <th width="200px">Jumlah Dikirim</th>
                      @endif
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
                              @if($permintaan->status == "Telah Dikirim")
                              <td class="text-right">
                                {{$value->jumlah_dipenuhi}}
                              </td>
                              @endif
                          </tr>
                          <?php $no++?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
            @if((Auth::user()->level == "staff_kantor_pusat" || Auth::user()->level == "manager") && $permintaan->status == "Belum Dikonfirmasi")
            <div class="box-footer">
              <a href="{{route('permintaanbarang.kirim',$permintaan->id)}}"class="btn btn-success btn-approve" >Kirim</a>
              <button class="btn btn-danger btn-reject" >Tolak</button>
              
            </div>
            @endif
            @if((Auth::user()->level == "staff_kantor_cabang" || Auth::user()->level == "agen") && $permintaan->status == "Ditolak")
            <div class="box-footer">
              <a href="{{route('permintaanbarang.edit',$permintaan->id)}}"class="btn btn-warning btn-approve" >Ubah</a>
              
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
    $(document).ready(function(){
      $('.btn-reject').click(function(){
            $.confirm({
              theme: 'material',
              title: 'Isi Alasan',
              content: '' +
                                            '<form action="" class="formName">' +
                                            '<div class="form-group">' +
                                            '<input class="form-control alasan" placeholder="Masukan Alasan" required>' +
                                            '</div>' +
                                            '</form>',
              buttons: {
                Yes: {
                  text:'Submit',
                  btnClass: 'btn-primary',
                  action: function(){
                  var checkrequired = $('input').filter('[required]:visible')
                  var isValid = true;
                  $(checkrequired).each( function() {
                          if ($(this).parsley().validate() !== true) isValid = false;
                  });
                  if(!isValid){
                    $.alert('Mohon masukan alasan');
                    return false;
                  }
                  else{
                    urlsnya = '{{route('permintaanbarang.tolak',$permintaan->id)}}';
                    var alasan = this.$content.find('.alasan').val();
                    _token = $('input[name=_token]').val();
                    $.ajax({
                      type: 'POST',
                      dataType: 'json',
                      data: {_token:_token, status:'Ditolak',alasan:alasan},
                      url: urlsnya,
                    })
                    .done(function(response) {
                      if(response == 1){
                        toastr.success("Success")
                        url = "{{ route('permintaanbarang.index')}}";
                        window.location.replace(url);
                      }
                      
                    })
                    .fail(function(){
                      $.alert("error");
                      return;
                    })
                    .always(function() {
                        console.log("complete");
                    });
                   }
                  }
                  
                },
                
                No: function () {
                  return;
                }
              }
            })
            
          })
    })
</script>
@endsection