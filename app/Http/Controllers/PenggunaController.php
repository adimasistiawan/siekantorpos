<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kantor;
use App\User;
class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('created_at','desc')->where('level','!=','manager')->with('kantor')->get();
        $cabang = Kantor::where('status','Aktif')->where('jenis','Kantor Cabang')->get();
        $agen = Kantor::where('status','Aktif')->where('jenis','Agen')->get();
        return view('pengguna.index',compact('data','cabang','agen'));
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
            User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'level' => $request->level,
                'kantor_id' => $request->kantor,
                'foto' => "user.png",
                'status' => "Aktif",
            ]);
            
        }else{
            if($request->password != null){
                User::find($request->id)->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'level' => $request->level,
                    'kantor_id' => $request->kantor,
                    'status' => $request->status,
                ]);
            }
            else{
                User::find($request->id)->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'level' => $request->level,
                    'kantor_id' => $request->kantor,
                    'status' => $request->status,
                ]);
            }
            
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
        
        $data = User::where("id",$id)->with('kantor')->first();
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
