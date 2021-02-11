@extends('template')
@section('title')
Tambah Barang Keluar | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tambah Barang Keluar
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li >Barang Keluar</li>
        <li class="active">Tambah Barang Keluar</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Form Tambah Barang Keluar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="{{route('barangkeluar.store')}}" method="post">
                <div class="col-md-4">
                    @csrf
                    <div class="form-group">
                        <label>Tujuan</label>
                        <select class="form-control select2 input" name="kantor_id" required>
                            <br>
                            <option value=""></option>
                            @foreach ($tujuan as $item)
                                <option value="{{$item->id}}" >{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="form-group">
                      <label>Keterangan</label>
                      <input type="text" class="input form-control"  name="keterangan">
                    </div> 
                     
                </div>
                <div class="col-md-12" style="margin-top:50px;">
                  
                  <table class="table" style="width: 60%">
                    <thead>
                      
                      <th width="200px">Barang</th>
                      <th width="200px">Stok</th>
                      <th width="200px">Jumlah</th>
                      <th width="50px"></th>
                    </thead>
                    <tbody id="tbody">
                      
                        <tr class="tr">
                          
                          <td>
                            <select class="form-control select2 input-table barang" name="barang_id[]" style="width: 100%"  required>
                              <br>
                              <option value=""></option>
                              @foreach ($barang as $item)
                                  <option value="{{$item->id}}" >{{$item->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            <input type="text" class="form-control input-table stok" disabled>
                          </td>
                          <td>
                            <input type="text" onkeypress="return isNumberKey(event);" name="jumlah[]" maxlength="10" class="form-control input-table jumlah" required>
                            <span class="text-red wrong" hidden>Jumlah tidak boleh melebihi Stok</span>
                          </td>
                          <td>

                          </td>
                        </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td>
                          <div class="btn btn-success tambah-item"><i class="fa fa-plus"></i></div>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" onclick="this.form.target='_self';return confirm('Apakah kamu yakin ingin menyimpan data ini?')" class="btn btn-primary simpan">Simpan</button>
            </form>
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
    
          $('.tambah-item').click(function(){
            $('#tbody').append(`
                  <tr class="tr">
                      
                      <td>
                        <select class="form-control select2 barang input-table" name="barang_id[]"  style="width: 100%"  required>
                            <br>
                            <option value=""></option>
                            @foreach ($barang as $item)
                                <option value="{{$item->id}}" >{{$item->nama}}</option>
                            @endforeach
                        </select>
                        
                        </td>
                        <td>
                            <input type="text" class="form-control input-table stok" disabled>
                        </td>
                        <td>
                        <input type="text"  onkeypress="return isNumberKey(event);" maxlength="10" min="1" name="jumlah[]" class="form-control input-table jumlah" required>
                        <span class="text-red wrong" hidden>Jumlah tidak boleh melebihi Stok</span>
                        </td>
                        <td>
                        <div class="btn btn-danger hapus"><i class="fa fa-trash delete"></i></div>
                      </td>
                    </tr>
            `)
            $('.select2').select2({
              placeholder: "Pilih"
            })
          })

          $(document).on('click', '.hapus', function() {
            $(this).closest('.tr').remove();
          })

          $(document).on('change', '.barang', function() {
            
            var row = $(this).closest('.tr');
            stok = $(row).find('.stok');
            
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
                $(stok).val(response.stok)
                
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
          

          $(document).on('keyup', '.jumlah', function() {
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
          })
    
 })
</script>
@endsection