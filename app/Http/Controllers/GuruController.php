<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->Guru = new User();
    }
    public function dashboard()
    {
        $kelas = count(Kelas::where('user_id', Auth::user()->id)->get());
        $data = [
            'title' => ' Dashboard',
            'kelas' => $kelas,
        ];
        return view('view_guru.dashboard', $data);
    }
    public function index()
    {
        $guru = User::all()->where('role', 'guru');
        $data = [
            'title' => ' Guru',
            'guru' => $guru,
        ];
        return view('view_admin.guru.index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => ' Guru',
        ];
        return view('view_admin.guru.tambah', $data);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'kode_user' => 'required|unique:users,kode_user',
            'nama' => 'required',
        ], [
            'kode_user.unique' => 'NIP Tidak Dapat Digunakan !!',
            'kode_user.required' => 'Kolom ini harus diis !!',
            'nama.required' => 'Kolom ini harus diisi !!',
        ]);
        $validate['role'] = 'guru';
        $validate['password'] = bcrypt($request->kode_user);
        User::create($validate);
        return redirect()->back()->with('psn', 'Data berhasil disimpan.');
    }
    public function edit($id)
    {
        $guru = User::where('id', $id)->where('role', 'guru')->first();
        if (!$guru) {
            return abort('404');
        }
        $data = [
            'title' => ' Guru',
            'guru' => $guru,
        ];
        return view('view_admin.guru.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $guru = User::where('id', $id)->where('role', 'guru')->first();
        if (!$guru) {
            return abort('404');
        }
        if ($guru->kode_user != $request->kode_user) {
            $request->validate([
                'kode_user' => 'required|unique:users,kode_user',
            ], [
                'kode_user.unique' => 'NIP Tidak Dapat Digunakan !!',
            ]);
        }
        $request->validate([
            'kode_user' => 'required',
            'nama' => 'required',
        ], [
            'kode_user.required' => 'Kolom ini harus diis !!',
            'nama.required' => 'Kolom ini harus diisi !!',
        ]);
        $data = [
            'kode_user' => $request->kode_user,
            'nama' => $request->nama,
        ];
        $this->Guru->updateGuru($guru->id, $data);
        return redirect()->back()->with('psn', 'Data berhasil diupdate.');
    }
    public function destroy($id)
    {
        $guru = User::where('id', $id)->first();
        if (!$guru) {
            return abort('404');
        }
        DB::table('users')->where('id', $guru->id)->delete();
        return redirect()->back()->with('del_msg', 'Data berhasil dihapus.');
    }
}
