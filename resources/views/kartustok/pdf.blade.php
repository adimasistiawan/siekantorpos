<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
  
  <!-- Select2 -->
  {{-- <script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script> --}}
    <style>
     @font-face {
      font-family: 'CustomFont';
      src: url('{{asset("Calibri Regular.ttf")}}')  format('truetype')
    }
    @font-face {
      font-family: 'CustomFontBold';
      src: url('{{asset("Calibri Bold.ttf")}}')  format('truetype')
    }

    *{
      font-size:13px;
      font-family: 'CustomFont';
    }
    .select2-container--default .select2-selection--single {
            width: 244.167px;
        }

        .tr-lokasi{
            background-
            color:white;
            font-size: 15px;
            text-align: center;
        }
        .tr-kategori{
            background-color: #fdcb6e;
            color:black;
            font-size: 15px;
            text-align: center;
        }

        .thead-dark{
            background-color: #b2bec3;
            color: black;
        }
        .table {
        border-collapse: collapse;
        }

        .table, .th, .td {
        border: 1px solid black;
        }
        .tr{
          border:1px solid #000000;
        }
    </style>
</head>
<body>
    
      <div style="text-align: center;">
        
        <span style=" font-family: 'CustomFontBold';">KANTOR POST DENPASAR</span><br>
        <span style="">Jl. Raya Renon</span><br>
        <span style="">Telp : 0361-8497838</span><br>
        <span style="">Email : blabla@hero.co.id</span><br>
        <hr style="border: 2px solid #000;"><br>

        <u><span style="font-size:19px; font-family: 'CustomFontBold';">Kartu Stok Barang</span></u><br>
        
      </div>
      <br>
      <br>
      <table>
        
        <tr>
          <td>Tanggal </td>
          <td>: {{date('d/m/Y', strtotime($from))}} - {{date('d/m/Y', strtotime($to))}}</td>
        </tr>
        <tr>
          <td>Nama Barang</td>
          <td>: {{$barang->nama}}</td>
        </tr>
        <tr>
          <td>Satuan</td>
          <td>: {{$barang->satuan->nama}}</td>
        </tr>
        
        
      </table>
      <table  class="table"style="width: 80%; border:1px solid #000000;">
        <tr class="tr">
          <td class="th" width="50px" style="text-align: center; font-family: 'CustomFontBold';">No</td>
          <td class="th" width="200px" style="text-align: center; font-family: 'CustomFontBold';">Tanggal</td>
          <td class="th" width="100px" style="text-align: center; font-family: 'CustomFontBold';">Stok Awal</td>
          <td class="th" width="100px" style="text-align: center; font-family: 'CustomFontBold';">Masuk</td>
          <td class="th" width="100px" style="text-align: center; font-family: 'CustomFontBold';">Keluar</td>
          <td class="th" style="text-align: center; font-family: 'CustomFontBold';" width="100px">Sisa Stok</td>
        </tr>
          <?php $no = 1?>
          
          @foreach($report as $value)
              <tr class="tr" style=border:1px solid #000000;">
                  <td class="td" style="text-align: center;">
                      {{$no}}
                  </td>
                  <td class="td" style="text-align: center;">
                    {{date('d-m-Y', strtotime($value->tanggal))}}
                  </td>
                  <td class="td" style="text-align: right;">
                    {{$value->stok_awal}}
                  </td>
                  <td class="td" style="text-align: right;">
                      {{$value->masuk}}
                  </td>
                  <td class="td" style="text-align: right;">
                      {{$value->keluar}}
                  </td>
                  <td class="td" style="text-align: right;">
                      {{$value->sisa}}
                  </td>
              </tr>
              <?php $no++?>
          @endforeach
          
        
       
      </table>
      <br>
      <br>
      <br>
      <br>
      <br>
      
      {{-- <table width="100%" >
        <tr>
          <td width="200px">
            &nbsp;
          </td>
          <td width="200px">
            &nbsp;
          </td>
          <td width="300px" style="text-align: center;">
            <p>Sanur, {{date('d/m/Y',strtotime($pemesanan->date))}}</p>
            <br>
            <br>
            <br>
            <br>
            <p>(Johanna Cindy Hartono, S. Farm., Apt)</p>
            <p>284/SIPA.030.12.20/2018</p>
          </td>
        </tr>
      </table>   --}}
      
        
      


{{-- <script src="{{asset('dashboard/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('dashboard/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('dashboard/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>

<!-- FLOT CHARTS -->
<script src="{{asset('dashboard/plugins/flot/jquery.flot.js')}}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{asset('dashboard/plugins/flot/plugins/jquery.flot.resize.js')}}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{asset('dashboard/plugins/flot/plugins/jquery.flot.pie.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
    

    var donutData = [
      {
        label: 'Series2',
        data : 30,
        color: '#3c8dbc'
      },
      
    ]
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    })
    /*
     * END DONUT CHART
     */
     function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + series.percent + '</div>'
  }
});
    
</script> --}}
</body>
</html>