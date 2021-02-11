@extends('template')
@section('title')
Kartu Stok | Kantor Pos Denpasar
@endsection

@section('css')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kartu Stok
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"> Home</a></li>
        <li class="active">Kartu Stok</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        @csrf
                        <div class="form-group">
                            <label for="">Dari Tanggal</label>
                            <input type="date" class="form-control input-stok" id="from" name="from">
                        </div>
                        <div class="form-group">
                            <label for="">Sampai Tanggal</label>
                            <input type="date" class="form-control input-stok" id="to" name="to">
                        </div>
                        <div class="form-group">
                            <label for="">Barang</label>
                            <select class="form-control select2 input-stok" id="Barang" name="barang" required>
                                <option value=""></option>
                            @foreach ($barang as $item)
                                <option value="{{$item->id}}" >{{$item->nama}}</option>
                            @endforeach
                            </select>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary search">Cari</button>
                        </div>
                    </div>
                </div>
                
                
            </div>
          </div>
        </div>
        <div class="col-md-12 report" hidden>
          <div class="box">
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class=" container" >
                        <br>
                        <br>
                        <br>
                        <div class="pdf">
                        
                        </div>
                        <h2 class="text-center">Kartu Stok Barang</h2>
                        <br>
                        <br>
                        <b>Tanggal : <span class="from"></span> - <span class="to"></span></b><br>
                        <b>Nama Barang : <span class="barang"></span></b><br>
                        <b>Satuan : <span class="satuan"></span></b><br>
                        
                        <table class="table table-bordered" style="width: 90%;">
                            <thead>
                                <tr>
                                  <th class="text-center" style="width:120px">Tanggal</th>
                                  <th class="text-center" style="width:120px">Stok Awal</th>
                                  <th class="text-center" style="width:120px">Masuk</th>
                                  <th class="text-center" style="width:120px">Keluar</th>
                                  <th class="text-center" style="width:120px">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection

@section('js')
<script>
$(document).ready(function(){
    $('.search').click(function(){
        $('.pdf').empty();
        
        from = $('#from').val()
        to = $('#to').val()
        barang = $('#Barang').val()

        if(from=="" || to=="" || barang==""){
            $.alert('Mohon lengkapi parameter !');
            return;
        }
        if(from>to){
            $.alert('Tanggal "Dari" harus lebih kecil dari tanggal "Sampai" !');
            return;
        }
        $('.loading').removeAttr('hidden')
        var a=$.datepicker.formatDate( "dd/mm/yy", new Date(from));
        var b=$.datepicker.formatDate( "dd/mm/yy", new Date(to));
        $('.from').text(a)
        $('.to').text(b)
        var url = "{{route('kartu.pdf',['id' => ':id','dari' => ':from','sampai' => ':to'])}}";
        url = url.replace(':from', from);
        url = url.replace(':to', to);
        url = url.replace(':id', barang);
        $('.pdf').append(
            `<a href="`+url+`" target="blank" class="btn btn-success"> Cetak</a>`
          )

        $('.tbody').empty();
        $('.report').removeAttr('hidden')
        var urlsnya='{{route('kartu.search')}}';
        _token = $('input[name=_token]').val();
        form = $('.input-stok');
        var arr= {};
        $.each(form,function(k,value){
            arr[value.name] = value.value;
        });

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {_token:_token, arr:arr},
            url: urlsnya,
        })
        .done(function(response) {
          if(response['report'].length != 0){
            console.log(response)
            $('.barang').text(response['barang']['nama'])
            $('.satuan').text(response['barang']['satuan']['nama'])
            $.each(response['report'],function(k,value){
              
              
              $('.tbody').append(`
              <tr>
                  <td class="text-center">`+$.datepicker.formatDate( "dd/mm/yy", new Date(value['tanggal']))+`</td>
                  <td class="text-right">`+value['stok_awal']+`</td>
                  <td class="text-right">`+value['masuk']+`</td>
                  <td  class="text-right">`+value['keluar']+`</td>
                  <td  class="text-right">`+value['sisa']+`</td>
              </tr>
              `)

              $('.loading').attr('hidden',true)
            });
          }
          else{
            $('.barang').text(response['barang']['nama'])
            $('.satuan').text(response['barang']['satuan']['nama'])
            $('.tbody').append(`
              <tr>
                  <td colspan="5" class="text-center">Data Tidak Ada</td>
                  
              </tr>
              `)
              
          }
          $('.loading').attr('hidden',true)
        })
        
      })
})
</script>
@endsection