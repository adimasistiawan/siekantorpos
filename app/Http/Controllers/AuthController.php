<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->back()->with('message','Username atau Password salah');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
