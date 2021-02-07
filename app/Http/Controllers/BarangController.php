<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\Satuan;
class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::where('status','Aktif')->orderBy('created_at','desc')->with('satuan')->get();
        $satuan = Satuan::orderBy('created_at','desc')->get();
        return view('barang.index',compact('data','satuan'));
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
        if($request->id == null){
            Barang::create([
                'nama' => $request->nama,
                'satuan_id' => $request->satuan,
                'stok' => $request->stok,
                'status' => "Aktif",
            ]);
            
        }else{
            Barang::find($request->id)->update([
                'nama' => $request->nama,
                'satuan_id' => $request->satuan,
                'stok' => $request->stok,
                'status' => $request->status,
            ]);
        }
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Barang::find($id)->with('satuan')->first();
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
