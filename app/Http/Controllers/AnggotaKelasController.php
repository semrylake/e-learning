<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;
use Illuminate\Support\Facades\File;

class AnggotaKelasController extends Controller
{
    public function anggotaSiswaKelas()
    {
        if (request('kode_kelas')) {
            $kelasGuru = Kelas::where('slug', request('kode_kelas'))->first();
            if (!$kelasGuru) {
                return redirect()->back()->with('sudahMasuk', 'Kode kelas tidak ditemukan.');
            }
            $kelas = AnggotaKelas::where('user_id', Auth::user()->id)->where('kelas_id', $kelasGuru->id)->get();
            $data = [
                'title' => ' Kelas',
                'kelas' => $kelas,
                'kelasGuru' => $kelasGuru,
            ];
            return view('view_siswa.anggotaKelas.index', $data);
        } else {
            $kelasGuru = Kelas::latest()->get();
            $kelas = AnggotaKelas::where('user_id', Auth::user()->id)->get();

            $data = [
                'title' => ' Kelas',
                'kelas' => $kelas,
                'kelasGuru' => 0,
            ];

            return view('view_siswa.anggotaKelas.index', $data);
        }
    }
    public function destroy($id)
    {
        $siswa = User::where('kode_user', $id)->first();
        if (!$siswa) {
            abort('404');
        }
        $anggotaKelas = AnggotaKelas::where('user_id', $siswa->id)->first();
        DB::table('anggota_kelas')->where('id', $anggotaKelas->id)->delete();
        return redirect()->back()->with('del_msg', 'Data berhasil dihapus.');
    }
    public function gabung($slug)
    {
        $kelasGuru = Kelas::where('slug', $slug)->first();
        if (!$kelasGuru) {
            abort('404');
        }
        $sudahMasuk = AnggotaKelas::where('user_id', Auth::user()->id)->where('kelas_id', $kelasGuru->id)->get();
        if (count($sudahMasuk) != 0) {
            return redirect()->back()->with('sudahMasuk', 'Anda sudah bergabung dalam kelas.');
        } else {
            AnggotaKelas::create([
                'user_id' => Auth::user()->id,
                'kelas_id' => $kelasGuru->id,
            ]);
            return redirect('/kelas-siswa')->with('suksesMasuk', 'Permintaan berhasil, Selamat bergabung di kelas.');
        }
    }
    public function materi($slug)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        $anggotaKelas = AnggotaKelas::where('user_id', Auth::user()->id)->first();
        if (!$kelas || !$anggotaKelas) {
            abort('404');
        }
        $materi = Materi::where('kelas_id', $kelas->id)->orderBy('id', 'desc')->get();
        $tugas = Tugas::where('kelas_id', $kelas->id)->orderBy('id', 'desc')->get();
        $data = [
            'title' => ' Kelas',
            'kelas' => $kelas,
            'materi' => $materi,
            'tugas' => $tugas,
            'tanggal_sekarang' => date('Y-m-d'),
        ];
        return view('view_siswa.materi.materi', $data);
    }

    public function kumpul($slug)
    {
        $tugas = Tugas::where('slug', $slug)->first();
        if (!$tugas) {
            abort('404');
        }
        $kelas = Kelas::where('id', $tugas->kelas_id)->first();
        $tugasSiswaKumpul = TugasSiswa::where('tugas_id', $tugas->id)->where('user_id', Auth::user()->id)->first();
        $data = [
            'title' => 'Kelas',
            'tugas' => $tugas,
            'kelas' => $kelas,
            'tugasSiswaKumpul' => $tugasSiswaKumpul,
        ];
        return view('view_siswa.tugas.kumpul', $data);
    }

    public function store(Request $request, $slug)
    {
        $validate = $request->validate([
            'file_tugas_siswa' => 'required|mimes:pdf',
        ]);
        $tugas = Tugas::where('slug', $slug)->first();
        if (!$tugas) {
            abort('404');
        }
        if ($request->file('file_tugas_siswa')) {
            $file = Request()->file_tugas_siswa;
            $fileName = Str::random(20)  . '.' . $file->extension();
            $file->move(public_path('file-pdf-tugas-kumpul-siswa'), $fileName);
            $validate['file_tugas_siswa'] = $fileName;
        }
        $validate['tugas_id'] = $tugas->id;
        $validate['status'] = 0;
        $validate['user_id'] = Auth::user()->id;
        $validate['tgl_kumpul'] = Carbon::now()->isoFormat('dddd, D MMMM Y');
        TugasSiswa::create($validate);
        return redirect()->back()->with('psn', 'Tugas berhasil dikirim.');
    }
    public function update(Request $request, $slug)
    {

        $tugas = Tugas::where('slug', $slug)->first();
        if (!$tugas) {
            abort('404');
        }
        $tugasSiswa = TugasSiswa::where('tugas_id', $tugas->id)->where('user_id', Auth::user()->id)->first();
        $filepdf = '';
        if ($request->file('file_tugas_siswa')) {
            $validate = $request->validate([
                'file_tugas_siswa' => 'required|mimes:pdf',
            ]);
            $file = Request()->file_tugas_siswa;
            $fileName = Str::random(20)  . '.' . $file->extension();
            $file->move(public_path('file-pdf-tugas-kumpul-siswa'), $fileName);
            $filepdf = $fileName;
            File::delete('file-pdf-tugas-kumpul-siswa/' . $tugasSiswa->file_tugas_siswa);
        } else {
            $filepdf = $tugasSiswa->file_tugas_siswa;
        }
        $data = [
            'tgl_kumpul' => Carbon::now()->isoFormat('dddd, D MMMM Y'),
            'file_tugas_siswa' => $filepdf,
        ];
        DB::table('tugas_siswas')->where('id', $tugasSiswa->id)->update($data);
        return redirect()->back()->with('psn', 'Tugas berhasil diubah.');
    }
}
