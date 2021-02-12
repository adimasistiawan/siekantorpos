<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermintaanBarang;
use App\PermintaanBarangDetail;
use App\Barang;
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
        if(Auth::user()->level != "staff_kantor_cabang"){
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
        if(Auth::user()->level != "staff_kantor_cabang"){
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
        if(Auth::user()->level != "staff_kantor_cabang"){
            return redirect()->back();
        }
        $permintaan = PermintaanBarang::where('id',$id)->with('kantor')->with('diminta')->with('dipenuhi')->first();
        if(Auth::user()->kantor_id != $permintaan->kantor_id){
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
        if(Auth::user()->level != "staff_kantor_cabang"){
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
}
