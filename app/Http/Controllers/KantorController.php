<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kantor;
class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kantor::orderBy('created_at','desc')->get();
        return view('kantor.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            Kantor::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'jenis' => $request->jenis,
                'status' => "Aktif",
            ]);
            
        }else{
            Kantor::find($request->id)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
                'jenis' => $request->jenis,
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
        $data = Kantor::find($id);
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
