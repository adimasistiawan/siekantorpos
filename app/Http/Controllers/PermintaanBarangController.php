<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermintaanBarang;
use App\PermintaanBarangDetail;
use App\Barang;
use App\BarangKeluar;
use App\BarangKeluarDetail;
use App\Kantor;
use App\KartuStok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class PermintaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->level != "staff_kantor_cabang" && Auth::user()->level != "agen"){
            $data = PermintaanBarang::orderBy('updated_at','desc')->with('kantor')->with('diminta')->with('dipenuhi')->get();
        }else{
            $data = PermintaanBarang::orderBy('updated_at','desc')->where('kantor_id',Auth::user()->kantor_id)->with('kantor')->with('diminta')->with('dipenuhi')->get();
        }
        
        return view('permintaan.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level != "staff_kantor_cabang" && Auth::user()->level != "agen"){
            return redirect()->back();
        }
        $barang = Barang::orderBy('created_at','desc')->where('status','Aktif')->get();
        return view('permintaan.create',compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode = strtoupper(Str::random(5)).Carbon::now()->format('dmY');
        $permintaan = PermintaanBarang::create([
            'kantor_id' => Auth::user()->kantor_id,
            'tanggal_diminta' => $request->tanggal_diminta,
            'diminta_oleh' => Auth::user()->id,
            'kode' => $kode,
            'status'=>"Belum Dikonfirmasi"
        ]);
        foreach ($request->barang_id as $key => $value) {
            
            PermintaanBarangDetail::create([
                'permintaan_id' => $permintaan->id,
                'barang_id' => $value,
                'jumlah_diminta' => $request->jumlah[$key]
            ]);
        }
        return redirect()->route('permintaanbarang.index')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $permintaan = PermintaanBarang::where('id',$id)->with('kantor')->with('diminta')->with('dipenuhi')->first();
        if(Auth::user()->kantor_id != $permintaan->kantor_id && (Auth::user()->level == "staff_kantor_cabang" && Auth::user()->level == "agen")){
            return redirect()->back();
        }
        $permintaandetail = PermintaanBarangDetail::where('permintaan_id',$id)->with('barang')->get();
        return view('permintaan.show',compact('permintaan','permintaandetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->level != "staff_kantor_cabang" && Auth::user()->level != "agen"){
            return redirect()->back();
        }
        $barang = Barang::orderBy('created_at','desc')->where('status','Aktif')->get();
        $permintaan = PermintaanBarang::find($id);
        if(Auth::user()->kantor_id != $permintaan->kantor_id){
            return redirect()->back();
        }
        $permintaandetail = PermintaanBarangDetail::where('permintaan_id',$id)->get();
        return view('permintaan.edit',compact('barang','permintaan','permintaandetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        PermintaanBarang::find($id)->update([
            'tanggal_diminta' => $request->tanggal_diminta,
            'diminta_oleh' => Auth::user()->id,
            'status'=>'Belum Dikonfirmasi',
            'alasan_ditolak' => null
        ]);
        PermintaanBarangDetail::where('permintaan_id',$id)->delete();
        foreach ($request->barang_id as $key => $value) {
            
            PermintaanBarangDetail::create([
                'permintaan_id' => $id,
                'barang_id' => $value,
                'jumlah_diminta' => $request->jumlah[$key]
            ]);
        }
        return redirect()->route('permintaanbarang.index')->with('success', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function tolak(Request $request, $id){
        PermintaanBarang::find($id)->update([
            'status' => "Ditolak",
            'alasan_ditolak' => $request->alasan
        ]);
        return 1;
    }
    public function kirim($id){
        if(Auth::user()->level == "staff_kantor_cabang" && Auth::user()->level == "agen"){
            return redirect()->back();
        }
        $permintaan = PermintaanBarang::where('id',$id)->with('kantor')->with('diminta')->with('dipenuhi')->first();
        $permintaandetail = PermintaanBarangDetail::where('permintaan_id',$id)->with('barang')->get();
        return view('permintaan.kirim',compact('permintaan','permintaandetail'));
    }

    public function dikirim(Request $request, $id){
        $permintaan = PermintaanBarang::find($id)->update([
            'status' => "Telah Dikirim",
            'tanggal_dipenuhi' => Carbon::now(),
            'dipenuhi_oleh' => Auth::user()->id
        ]);
        $p = PermintaanBarang::find($id);
        $kode = strtoupper(Str::random(5)).Carbon::now()->format('dmY');
        $barangkeluar = BarangKeluar::create([
            'kantor_id' => $p->kantor_id,
            'keterangan' => "-",
            'tanggal' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'kode' => $kode
        ]);
        foreach ($request->id as $key => $value) {
            $detail = PermintaanBarangDetail::find($value);
            $barang = Barang::find($detail->barang_id);
            $kartu = KartuStok::where('barang_id',$barang->id)->whereDate('tanggal',Carbon::now())->get();
            if(count($kartu) == 0){
                KartuStok::create([
                    'tanggal' => Carbon::now(),
                    'barang_id' => $barang->id,
                    'stok_awal' => $barang->stok,
                    'masuk' => 0,
                    'keluar' => $request->jumlah_dipenuhi[$key],
                    'sisa' => $barang->stok - $request->jumlah_dipenuhi[$key]
                ]);
            }else{
                $keluar = KartuStok::where('barang_id',$barang->id)->whereDate('tanggal',Carbon::now())->first();
                KartuStok::where('barang_id',$barang->id)->whereDate('tanggal',Carbon::now())->update([
                    'keluar' => $keluar->keluar + $request->jumlah_dipenuhi[$key],
                    'sisa' => $barang->stok - $request->jumlah_dipenuhi[$key]
                ]);
            }
            $detail->update([
                'jumlah_dipenuhi' => $request->jumlah_dipenuhi[$key]
            ]);
            $barang->update([
                'stok' => $barang->stok - $request->jumlah_dipenuhi[$key]
            ]);
            BarangKeluarDetail::create([
                'barangkeluar_id' => $barangkeluar->id,
                'barang_id' => $barang->id,
                'jumlah' => $request->jumlah_dipenuhi[$key]
            ]);
        }
        return redirect()->route('permintaanbarang.index')->with('success', 'Success');
    }

}
