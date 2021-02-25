@extends('template')
@section('title')
Penyesuaian Stok | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Penyesuaian Stok
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Penyesuaian Stok</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Penyesuaian Stok</h3>
              <button class="btn btn-primary pull-right"  data-toggle="modal" data-target="#modal-default" >
                Buat Penyesuaian
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="datatable" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="15px">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Barang</th>
                            <th class="text-center">Stok Sistem</th>
                            <th class="text-center">Stok Aktual</th>
                            <th class="text-center">Selisih</th>
                            <th class="text-center">Disesuaikan Oleh</th>
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
                            <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                            <td>{{$item->barang->nama}}</td>
                            <td class="text-right">{{$item->stok_sistem}}</td>
                            <td class="text-right">{{$item->stok_aktual}}</td>
                            <td class="text-right">{{$item->selisih}}</td>
                            <td>{{$item->user->nama}}</td>
                            <td class="text-center">
                                    <div class="btn btn-primary edit" data-id="{{$item->id}}"  data-toggle="modal">Lihat</div>
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


  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Buat Penyesuaian</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('penyesuaianstok.store')}}">
                @csrf
                
                <div class="form-group">
                    <label>Barang</label>
                    <select class="form-control select2 barang" name="barang_id" style="width: 100%"  required>
                        <br>
                        <option value=""></option>
                        @foreach ($barang as $item)
                            <option value="{{$item->id}}" >{{$item->nama}} ({{$item->satuan->nama}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok Sistem</label>
                    <input type="text" onkeypress="return isNumberKey(event);" class="form-control stok_sistem"  name="stok_sistem" readonly>
                </div>
                <div class="form-group">
                    <label>Stok Aktual</label>
                    <input type="text" onkeypress="return isNumberKey(event);" class="form-control stok_aktual"  name="stok_aktual" readonly>
                    <span class="text-red wrong" hidden>Stok Aktual harus berbeda dengan Stok Sistem</span>
                </div>
                <div class="form-group">
                    <label>Selisih</label>
                    <input type="text" onkeypress="return isNumberKey(event);" class="form-control selisih"  name="selisih" readonly>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary simpan">Simpan</button>
              </div>
            </form>
        </div>  
      </div>
      <!-- /.modal-content -->
    </div>
  </div>

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Lihat Data</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Barang</label>
                <select class="form-control " id="barang_id" name="barang_id" style="width: 100%"  readonly>
                    <br>
                    <option value=""></option>
                    @foreach ($barang as $item)
                        <option value="{{$item->id}}" >{{$item->nama}} ({{$item->satuan->nama}})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Stok Sistem</label>
                <input type="text" onkeypress="return isNumberKey(event);" id="stok_sistem" class="form-control "  name="stok_sistem" readonly>
            </div>
            <div class="form-group">
                <label>Stok Aktual</label>
                <input type="text" onkeypress="return isNumberKey(event);" id="stok_aktual" class="form-control "  name="stok_aktual" readonly>
            </div>
            <div class="form-group">
                <label>Selisih</label>
                <input type="text" onkeypress="return isNumberKey(event);" id="selisih" class="form-control "  name="selisih" readonly>
            </div>
        </div>  
      </div>
      <!-- /.modal-content -->
    </div>
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
    
    @if(session()->has('success'))
         toastr.success("{{session('success')}}")
   
         
    @endif

    @if(session()->has('error'))
    $.alert("{{session('error')}}")
    @endif
    $(document).on('change', '.barang', function() {
            
        $('.loading').removeAttr('hidden')
        var id = $(this).val();
        url = '{{route('barang.edit',":id")}}';
        url = url.replace(':id', id);
        _token = $('input[name=_token]').val();
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
        })
        .done(function(response) {
            console.log(response)
            $(".stok_sistem").val(response.stok)
            $('.stok_aktual').val('')
            $('.stok_aktual').prop('readonly', false);
            $('.selisih').val(0)
            $('.wrong').attr('hidden',true);
        })
        .fail(function(){
            $.alert("error");
            return;
        })
        .always(function() {
            $('.loading').attr('hidden',true)
            console.log("complete");
        });
    })
    $('.stok_aktual').keyup(function(){
        if($(this).val() == $('.stok_sistem').val()){
            $('.wrong').removeAttr('hidden');
            $('.simpan').prop('disabled', true);
        }else{
            $('.wrong').attr('hidden',true);
            $('.simpan').prop('disabled', false);
        }
        if($(this).val() == ""){
            $('.selisih').val(0)
        }else{
            var selisih = parseInt($(this).val()) - parseInt($('.stok_sistem').val())
            $('.selisih').val(selisih)
        }
        
    })
    $('.edit').click(function(){
        $('.loading').removeAttr('hidden')
        var id = $(this).attr('data-id');
        url = '{{route('penyesuaianstok.edit',":id")}}';
        url = url.replace(':id', id);
        _token = $('input[name=_token]').val();
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
        })
        .done(function(response) {
            console.log(response)
            $('#barang_id').val(response.barang_id)
            $('#stok_sistem').val(response.stok_sistem)
            $('#stok_aktual').val(response.stok_aktual)
            $('#selisih').val(response.selisih)

            $('#modal-default2').modal('show');
            
        })
        .fail(function(){
            $.alert("error");
            return;
        })
        .always(function() {
            $('.loading').attr('hidden',true)
            console.log("complete");
        });
    })
    
 })
</script>
@endsection