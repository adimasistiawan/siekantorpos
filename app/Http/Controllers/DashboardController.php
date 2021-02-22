<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermintaanBarang;
use Auth;
class DashboardController extends Controller
{
    public function index(){
        if(Auth::user()->level == "manager" || Auth::user()->level == "staff_kantor_pusat"){
            $permintaan = PermintaanBarang::where('status','Belum Dikonfirmasi')->get();
        }else{
            $permintaan = PermintaanBarang::where('status','!=','Belum Dikonfirmasi')->where('kantor_id',Auth::user()->kantor_id)->get();
        }
        
        return view('dashboard',compact('permintaan'));
    }
}
