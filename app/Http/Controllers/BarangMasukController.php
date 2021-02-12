<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BarangMasuk;
use App\BarangMasukDetail;
use App\Barang;
use App\Supplier;
use App\KartuStok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BarangMasuk::orderBy('created_at','desc')->with('supplier')->with('user')->get();
        return view('barangmasuk.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::orderBy('created_at','desc')->where('status','Aktif')->get();
        $supplier = Supplier::orderBy('created_at','desc')->where('status','Aktif')->get();
        return view('barangmasuk.create',compact('barang','supplier'));
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
        $barangmasuk = BarangMasuk::create([
            'supplier_id' => $request->supplier_id,
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
                    'masuk' => $request->jumlah[$key],
                    'keluar' => 0,
                    'sisa' => $barang->stok + $request->jumlah[$key]
                ]);
            }else{
                $keluar = KartuStok::where('barang_id',$value)->whereDate('tanggal',Carbon::now())->first();
                KartuStok::where('barang_id',$value)->whereDate('tanggal',Carbon::now())->update([
                    'masuk' => $keluar->masuk + $request->jumlah[$key],
                    'sisa' => $barang->stok + $request->jumlah[$key]
                ]);
            }
            BarangMasukDetail::create([
                'barangmasuk_id' => $barangmasuk->id,
                'barang_id' => $value,
                'jumlah' => $request->jumlah[$key]
            ]);

            $barang->update([
                'stok' => $barang->stok + $request->jumlah[$key]
            ]);
        }
        return redirect()->route('barangmasuk.index')->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barangmasuk = BarangMasuk::where('id',$id)->with('supplier')->with('user')->first();
        $detail = BarangMasukDetail::where('barangmasuk_id',$id)->with('barang')->get();
        return view('barangmasuk.show',compact('barangmasuk','detail'));
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
