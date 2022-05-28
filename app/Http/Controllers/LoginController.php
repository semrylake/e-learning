<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('frontView.index', $data);
    }

    public function loginprocess(Request $request)
    {
        $validate = $request->validate([
            'kode_user' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('pesan', 'Selamat datang kembali');
        }
        return redirect()->back()->with('pesan', 'Proses Login Gagal.');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
