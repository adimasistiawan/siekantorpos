@extends('template')
@section('title')
Kantor | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kantor
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Kantor</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Kantor</h3>
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
                            <th class="text-center">Alamat</th>
                            <th class="text-center">No Telepon</th>
                            <th class="text-center">Jenis</th>
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
                            <td>{{$item->alamat}}</td>
                            <td>{{$item->no_telepon}}</td>
                            <td>{{$item->jenis}}</td>
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
            <h4 class="modal-title">Tambah Kantor</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('kantor.store')}}">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" placeholder="Nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control" placeholder="Alamat" name="alamat" >
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" class="form-control" placeholder="No Telepon" name="no_telepon" >
                </div>
                <div class="form-group">
                    <label>Jenis</label>
                    <select name="jenis" class="form-control" required>
                        <option value="Kantor Cabang">Kantor Cabang</option>
                        <option value="Agen">Agen</option>
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

<div class="modal fade" id="modal-default2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Ubah Kantor</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('kantor.store')}}">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" id="alamat" class="form-control" placeholder="Alamat" name="alamat" >
                </div>
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" id="no_telepon" class="form-control" placeholder="No Telepon" name="no_telepon" >
                </div>
                <div class="form-group">
                    <label>Jenis</label>
                    <select id="jenis" name="jenis" class="form-control" required>
                        <option value="Kantor Cabang">Kantor Cabang</option>
                        <option value="Agen">Agen</option>
                    </select>
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
        url = '{{route('kantor.edit',":id")}}';
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
            $('#alamat').val(response.alamat)
            $('#no_telepon').val(response.no_telepon)
            $('#jenis').val(response.jenis)
            $('#status').val(response.status)

            $('#modal-default2').modal('show');
            $('.loading').attr('hidden',true)
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