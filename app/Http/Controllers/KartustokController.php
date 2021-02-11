<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Auth;
use App\Barang;
class KartustokController extends Controller
{
    public function index(){
        $barang = Barang::where('status','Aktif')->get();
        return view('kartustok.index',compact('barang'));
    }

    public function search(Request $request){
        $report = DB::table('kartu_stok')->join('barang','kartu_stok.barang_id','barang.id')
                                        ->select('kartu_stok.*','barang.nama')
                                        ->where('kartu_stok.barang_id',$request->arr['barang'])
                                        ->whereDate('kartu_stok.tanggal','>=',$request->arr['from'])
                                        ->whereDate('kartu_stok.tanggal','<=',$request->arr['to'])->get();
        
        $barang = Barang::where('id',$request->arr['barang'])->with('satuan')->first();
        return ['report' => $report, 'barang' => $barang];
    }

    public function pdf($id,$from,$to){
        $report = DB::table('kartu_stok')->join('barang','kartu_stok.barang_id','barang.id')
                                        ->select('kartu_stok.*','barang.nama')
                                        ->where('kartu_stok.barang_id',$id)
                                        ->whereDate('kartu_stok.tanggal','>=',$from)
                                        ->whereDate('kartu_stok.tanggal','<=',$to)->get();
        
        $barang = Barang::where('id',$id)->with('satuan')->first();

      
        $pdf =  PDF::loadView('kartustok.pdf',compact('report','barang','from','to'));
        return $pdf->stream();
    }
}
