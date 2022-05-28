<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->Siswa = new User();
    }
    public function dashboard()
    {
        $kelas = AnggotaKelas::where('user_id', Auth::user()->id)->get();
        $data = [
            'title' => ' Dashboard',
            'kelas' => $kelas,
        ];
        return view('view_siswa.dashboard', $data);
    }
    public function index()
    {
        $siswa = User::all()->where('role', 'siswa');
        $data = [
            'title' => ' Siswa',
            'siswa' => $siswa,
        ];
        return view('view_admin.siswa.index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => ' Siswa',
        ];
        return view('view_admin.siswa.tambah', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'kode_user' => 'required|unique:users,kode_user',
            'nama' => 'required',
        ], [
            'kode_user.unique' => 'NIS tidak dapat digunakan !!',
            'kode_user.required' => 'Kolom ini harus diisi !!',
            'nama.required' => 'Kolom ini harus diisi !!',
        ]);
        $validate['role'] = 'siswa';
        $validate['password'] = bcrypt($request->kode_user);
        User::create($validate);
        return redirect()->back()->with('psn', 'Data berhasil disimpan.');
    }
    public function edit($id)
    {
        $siswa = User::where('id', $id)->where('role', 'siswa')->first();
        if (!$siswa) {
            return abort('404');
        }
        $data = [
            'title' => ' Siswa',
            'siswa' => $siswa,
        ];
        return view('view_admin.siswa.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $siswa = User::where('id', $id)->where('role', 'siswa')->first();
        if (!$siswa) {
            return abort('404');
        }
        if ($siswa->kode_user != $request->kode_user) {
            $request->validate([
                'kode_user' => 'required|unique:users,kode_user',
            ], [
                'kode_user.unique' => 'NIS Tidak Dapat Digunakan !!',
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
        $this->Siswa->updateGuru($siswa->id, $data);
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
