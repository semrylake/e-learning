<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->Kelas = new Kelas();
    }
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Kelas::class, 'slug', $request->kodeKelas);
        return response()->json(['slug' => $slug]);
    }
    public function index()
    {
        $kelas = Kelas::where('user_id', Auth::user()->id)->get();
        $data = [
            'title' => ' Kelas',
            'kelas' => $kelas,
        ];
        return view('view_guru.kelas.index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => ' Kelas',
        ];
        return view('view_guru.kelas.tambah', $data);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'slug' => 'required|unique:kelas,slug',
            'nama_kelas' => 'required',
        ], [
            'slug.unique' => 'Kode Kelas Sudah Digunakan !!',
            'slug.required' => 'Kolom ini harus diisi !!',
            'nama_kelas.required' => 'Kolom ini harus diisi !!',
        ]);
        $validate['user_id'] = Auth::user()->id;
        Kelas::create($validate);
        return redirect()->back()->with('psn', 'Data berhasil disimpan.');
    }
    public function detail($slug)
    {
        $kelas = Kelas::where('slug', $slug)->where('user_id', Auth::user()->id)->first();
        if (!$kelas) {
            abort('404');
        }
        $materi = Materi::where('user_id', Auth::user()->id)->where('kelas_id', $kelas->id)->orderBy('id', 'desc')->get();
        $tugas = Tugas::where('user_id', Auth::user()->id)->where('kelas_id', $kelas->id)->orderBy('id', 'desc')->get();
        $anggotaKelas = AnggotaKelas::where('kelas_id', $kelas->id)->get();
        $data = [
            'title' => ' Kelas',
            'kelas' => $kelas,
            'anggotaKelas' => $anggotaKelas,
            'materi' => $materi,
            'tugas' => $tugas,
        ];
        return view('view_guru.kelas.detail', $data);
    }

    public function destroy($slug)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if (!$kelas) {
            return abort('404');
        }
        DB::table('anggota_kelas')->where('kelas_id', $kelas->id)->delete();
        DB::table('kelas')->where('id', $kelas->id)->delete();
        return redirect()->back()->with('del_msg', 'Data berhasil dihapus.');
    }
}
