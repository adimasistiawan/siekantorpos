@extends('template')
@section('title')
Pengguna | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pengguna
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Pengguna</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pengguna</h3>
              <button class="btn btn-primary tambah pull-right"  data-toggle="modal" data-target="#modal-default" >
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
                            <th class="text-center">Username</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Kantor</th>
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
                            <td>{{$item->username}}</td>
                            <td>
                                @if($item->level == "staff_kantor_pusat")
                                Staff Kantor Pusat
                                @elseif($item->level == "staff_kantor_cabang")
                                Staff Kantor Cabang
                                @else
                                Agen
                                @endif
                            </td>
                            <td>{{$item->kantor_id==null?"Kantor Pusat":$item->kantor->nama}}</td>
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
            <h4 class="modal-title">Tambah Pengguna</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('pengguna.store')}}">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" placeholder="Nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select  name="level" class="form-control level" required>
                        <option value="staff_kantor_pusat">Staff Kantor Pusat</option>
                        <option value="staff_kantor_cabang">Staff Kantor Cabang</option>
                        <option value="agen">Agen</option>
                    </select>
                </div>
                <div class="formtambahan">
                    
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
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
            <h4 class="modal-title">Ubah Pengguna</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('pengguna.store')}}">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select id="level"  name="level" class="form-control level" required>
                        <option value="staff_kantor_pusat">Staff Kantor Pusat</option>
                        <option value="staff_kantor_cabang">Staff Kantor Cabang</option>
                        <option value="agen">Agen</option>
                    </select>
                </div>
                <div class="formtambahan">
                    
                </div>
                
                
                <div class="form-group">
                    <label>Status</label>
                    <select  id="status" name="status" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>

                <a id="" href="#" class="text-blue change_password" style="width:100%">Ubah Password</a>
                <a id="" class="text-red batal" href="#" style="width:100%" hidden>Batal Ubah Password</a>
                <div class="formpassword">
            
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
    $('.level').change(function(){
        if($(this).val() == "staff_kantor_cabang"){
            $('.formtambahan').empty()
            $('.formtambahan').append(`
                <div class="form-group">
                    <label>Kantor</label>
                    <select  name="kantor" class="form-control" required>
                        @foreach($cabang as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
            `)
        }
        if($(this).val() == "agen"){
            $('.formtambahan').empty()
            $('.formtambahan').append(`
                <div class="form-group">
                    <label>Kantor</label>
                    <select  name="kantor" class="form-control" required>
                        @foreach($agen as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
            `)
        }
        if($(this).val() == "staff_kantor_pusat"){
            $('.formtambahan').empty()
        }
            
    })

    $('.change_password').click(function(){
            $('.formpassword').append(`
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" class="form-control Password2" id="" placeholder="Password" name="password" required>
                  </div>
                
            `)
            $('.batal').removeAttr('hidden');
            $(this).attr('hidden',true);
            
    })
    $('.batal').click(function(){
        $('.formpassword').empty();
        $('.change_password').removeAttr('hidden');
        $(this).attr('hidden',true);
    })

    $('.tambah').click(function(){
        $('.formtambahan').empty()
    })
    $('.edit').click(function(){
        $('.change_password').removeAttr('hidden');
        $('.batal').attr('hidden',true);
        $('.formtambahan').empty()
        $('.formpassword').empty()
        $('.loading').removeAttr('hidden')
        var id = $(this).attr('data-id');
        url = '{{route('pengguna.edit',":id")}}';
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
            $('#username').val(response.username)
            $('#level').val(response.level)
            if(response.level == "staff_kantor_cabang"){
                $('.formtambahan').empty()
                $('.formtambahan').append(`
                    <div class="form-group">
                        <label>Kantor</label>
                        <select  name="kantor" class="form-control kantor" required>
                            @foreach($cabang as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                `)
                $('.kantor').val(response.kantor.id)
            }
            if(response.level == "agen"){
                $('.formtambahan').empty()
                $('.formtambahan').append(`
                    <div class="form-group">
                        <label>Kantor</label>
                        <select  name="kantor" class="form-control kantor" required>
                            @foreach($agen as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                `)
                $('.kantor').val(response.kantor.id)
            }
            if(response.level == "staff_kantor_pusat"){
                $('.formtambahan').empty()
            }
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