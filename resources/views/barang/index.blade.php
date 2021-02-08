@extends('template')
@section('title')
Barang | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Barang</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Barang</h3>
              <button class="btn btn-primary pull-right"  data-toggle="modal" data-target="#modal-default" >
                Tambah Data
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="datatable" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="15px">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-center">Stok</th>
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
                            <td>{{$item->nama}}</td>
                            <td>{{$item->satuan->nama}}</td>
                            <td class="text-right">{{$item->stok}}</td>
                            <td class="text-center">
                                @if ($item->status == "Aktif")
                                    <span class="badge bg-light-blue">Aktif</span>
                                @else
                                <span class="badge bg-red">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                    <div class="btn btn-warning edit" data-id="{{$item->id}}"  data-toggle="modal">Ubah</div>
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
            <h4 class="modal-title">Tambah Barang</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('barang.store')}}">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" placeholder="Nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <select  id="" name="satuan" class="form-control" required>
                        <option value="">--Pilih Satuan-</option>
                        @foreach ($satuan as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" min="1" class="form-control" placeholder="Stok" name="stok" required>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
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
            <h4 class="modal-title">Ubah Barang</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('barang.store')}}">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Satuan</label>
                    <select  id="satuan" name="satuan" class="form-control" required>
                        @foreach ($satuan as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" min="1"  id="stok" class="form-control" placeholder="Stok" name="stok" disabled>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select  id="status" name="status" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
        </div>  
      </div>
      <!-- /.modal-content -->
    </div>
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

    $('.edit').click(function(){
        $('.loading').removeAttr('hidden')
        var id = $(this).attr('data-id');
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
            $('#id').val(response.id)
            $('#nama').val(response.nama)
            $('#satuan').val(response.satuan.id)
            $('#stok').val(response.stok)
            $('#status').val(response.status)

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