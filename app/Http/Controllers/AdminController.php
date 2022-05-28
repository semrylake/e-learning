<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role == "admin") {
            return redirect('/admin-dashboard');
        } elseif (Auth::user()->role == "guru") {
            return redirect('/guru-dashboard');
        } elseif (Auth::user()->role == "siswa") {
            return redirect('/siswa-dashboard');
        }
    }
    public function adminDashboard()
    {
        $jumlahGuru = count(User::where('role', 'guru')->get());
        $jumlahSiswa = count(User::where('role', 'siswa')->get());
        $data = [
            'title' => ' Dashboard',
            'guru' => $jumlahGuru,
            'siswa' => $jumlahSiswa,
        ];
        return view('view_admin.dashboard', $data);
    }
}
