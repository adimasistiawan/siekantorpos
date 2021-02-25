<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PenyesuaianStok;
use App\KartuStok;
use App\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class PenyesuaianStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::orderBy('created_at','desc')->where('status','Aktif')->get();
        $data = PenyesuaianStok::orderBy('created_at','desc')->with('barang')->with('user')->get();
        return view('penyesuaianstok.index',compact('data','barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        PenyesuaianStok::create([
            'barang_id' => $request->barang_id,
            'stok_sistem' => $request->stok_sistem,
            'stok_aktual' => $request->stok_aktual,
            'selisih' => $request->selisih,
            'user_id' => Auth::user()->id,
        ]);
        $barang = Barang::find($request->barang_id);
        $kartu = KartuStok::where('barang_id',$request->barang_id)->whereDate('tanggal',Carbon::now())->get();
        if(count($kartu) == 0){
            KartuStok::create([
                'tanggal' => Carbon::now(),
                'barang_id' => $request->barang_id,
                'stok_awal' => $barang->stok,
                'masuk' => 0,
                'keluar' => 0,
                'penyesuaian' => $request->selisih,
                'sisa' => $request->stok_aktual
            ]);
        }else{
            $keluar = KartuStok::where('barang_id',$request->barang_id)->whereDate('tanggal',Carbon::now())->first();
            KartuStok::where('barang_id',$request->barang_id)->whereDate('tanggal',Carbon::now())->update([
                'penyesuaian' => $keluar->penyesuaian + $request->selisih,
                'sisa' => $request->stok_aktual
            ]);
        }
        $barang->update([
            'stok' => $request->stok_aktual
        ]);
        return redirect()->back()->with('success', 'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PenyesuaianStok::where("id",$id)->with('barang')->first();
        return $data;
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
