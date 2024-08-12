<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function TampilLogin(){
        return view('halaman-login.login');
    }
    public function postLogin(Request $request) {
        if (Auth::attempt(
            [
                
                'email' => $request->email,
                'password' => $request->password,
            ]
        )) {
            return redirect('/');
        }
        return redirect('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
