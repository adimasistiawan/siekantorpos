<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BarangKeluar;
use App\BarangKeluarDetail;
use App\Barang;
use App\Kantor;
use App\KartuStok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BarangKeluar::orderBy('created_at','desc')->with('kantor')->with('user')->get();
        return view('barangkeluar.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::orderBy('created_at','desc')->where('status','Aktif')->get();
        $tujuan = Kantor::orderBy('created_at','desc')->where('status','Aktif')->get();
        return view('barangkeluar.create',compact('barang','tujuan'));
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
        $barangkeluar = BarangKeluar::create([
            'kantor_id' => $request->kantor_id,
            'keterangan' => $request->keterangan,
            'tanggal' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'kode' => $kode
        ]);
        foreach ($request->barang_id as $key => $value) {
            $barang = Barang::find($value);
            $kartu = KartuStok::where('barang_id',$value)->whereDate('tanggal',Carbon::now())->get();
            if(count($kartu) == 0){
                KartuStok::create([
                    'tanggal' => Carbon::now(),
                    'barang_id' => $value,
                    'stok_awal' => $barang->stok,
                    'masuk' => 0,
                    'keluar' => $request->jumlah[$key],
                    'sisa' => $barang->stok - $request->jumlah[$key]
                ]);
            }else{
                $keluar = KartuStok::where('barang_id',$value)->whereDate('tanggal',Carbon::now())->first();
                KartuStok::where('barang_id',$value)->whereDate('tanggal',Carbon::now())->update([
                    'keluar' => $keluar->keluar + $request->jumlah[$key],
                    'sisa' => $barang->stok - $request->jumlah[$key]
                ]);
            }
            BarangKeluarDetail::create([
                'barangkeluar_id' => $barangkeluar->id,
                'barang_id' => $value,
                'jumlah' => $request->jumlah[$key]
            ]);

            $barang->update([
                'stok' => $barang->stok - $request->jumlah[$key]
            ]);
        }
        return redirect()->route('barangkeluar.index')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barangkeluar = BarangKeluar::where('id',$id)->with('kantor')->with('user')->first();
        $detail = BarangKeluarDetail::where('id',$barangkeluar->id)->with('barang')->get();
        return view('barangkeluar.show',compact('barangkeluar','detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
