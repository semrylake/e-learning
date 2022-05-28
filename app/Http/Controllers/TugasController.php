<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TugasController extends Controller
{
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Tugas::class, 'slug', $request->kodeKelas);
        return response()->json(['slug' => $slug]);
    }
    public function tambah($slug)
    {
        $kelas = Kelas::where('slug', $slug)->where('user_id', Auth::user()->id)->first();
        if (!$kelas) {
            abort('404');
        }
        $tugas = Tugas::where('kelas_id', $kelas->id)->get();
        $data = [
            'title' => ' Kelas',
            'kelas' => $kelas,
            'tugas' => $tugas,
        ];
        return view('view_guru.tugas.tambah', $data);
    }

    public function store(Request $request, $id)
    {
        // dd($request->all());
        $val = $request->validate([
            'slug' => 'required|unique:tugas,slug',
            'judul' => 'required',
            'keterangan' => 'required',
            'batas_kumpul' => 'required',
            'file_tugas' => 'required|mimes:pdf',
        ], [
            'slug.required' => 'Kolom ini harus diisi !!',
            'judul.required' => 'Kolom ini harus diisi !!',
            'keterangan.required' => 'Kolom ini harus diisi !!',
            'batas_kumpul.required' => 'Kolom ini harus diisi !!',
        ]);
        $val['kelas_id'] = $id;
        $val['user_id'] = Auth::user()->id;
        if ($request->file('file_tugas')) {
            $file = Request()->file_tugas;
            $fileName = Str::random(20)  . '.' . $file->extension();
            $file->move(public_path('file-pdf-tugas'), $fileName);
            $val['file_tugas'] = $fileName;
            $val['status'] = 0;
        }
        Tugas::create($val);
        return redirect()->back()->with('psn', 'Materi berhasil diupload.');
    }

    public function edit($id)
    {
        $tugas = Tugas::where('id', $id)->first();
        if (!$tugas) {
            abort('404');
        }
        $kelas = Kelas::where('id', $tugas->kelas_id)->where('user_id', Auth::user()->id)->first();
        $data = [
            'title' => ' Kelas',
            'tugas' => $tugas,
            'kelas' => $kelas,
        ];
        return view('view_guru.tugas.edit', $data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required',
            'keterangan' => 'required',
            'batas_kumpul' => 'required',
        ], [
            'judul.required' => 'Kolom ini harus diisi !!',
            'keterangan.required' => 'Kolom ini harus diisi !!',
            'batas_kumpul.required' => 'Kolom ini harus diisi !!',
        ]);

        //validasi file
        if ($request->file('file_tugas')) {
            $request->validate([
                'file_tugas' => 'required|mimes:pdf',
            ]);
        }

        $tugas = Tugas::where('id', $id)->first();
        if (!$tugas) {
            abort('404');
        }
        //pindah file
        $namafile = '';
        if ($request->file('file_tugas')) {
            $file = Request()->file_tugas;
            $fileName = Str::random(20)  . '.' . $file->extension();
            $file->move(public_path('file-pdf-tugas'), $fileName);
            $namafile = $fileName;
            File::delete('file-pdf-tugas/' . $tugas->file_tugas);
        } else {
            $namafile = $tugas->file_tugas;
        }
        $data = [
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'batas_kumpul' => $request->batas_kumpul,
            'file_tugas' => $namafile,
        ];
        DB::table('tugas')->where('id', $tugas->id)->update($data);
        return redirect()->back()->with('psn', 'Tugas berhasil diubah.');
    }

    public function download($id)
    {
        $tugas = Tugas::where('id', $id)->first();
        // dd($tugas);
        $filePath = public_path('file-pdf-tugas/' . $tugas->file_tugas);
        $header = ['Content-Type: application/pdf'];
        $filename = $tugas->slug . '.pdf';
        return response()->download($filePath, $filename, $header);
    }

    public function destroy($id)
    {
        $tugas = Tugas::where('id', $id)->first();
        File::delete('file-pdf-tugas/' . $tugas->file_tugas);
        DB::table('tugas')->where('id', $id)->delete();
        // Storage::delete($resident->foto);
        return redirect()->back()->with('del_msg', 'Data berhasil dihapus.');
    }


    public function tugasDikumpul($id)
    {
        $tugas = Tugas::where('slug', $id)->first();
        if (!$tugas) {
            abort('404');
        }
        $tugasSiswa = TugasSiswa::where('tugas_id', $tugas->id)->orderBy('id', 'desc')->get();
        $kelas = Kelas::where('id', $tugas->kelas_id)->first();
        $data = [
            'title' => ' Kelas',
            'tugas' => $tugas,
            'tugasSiswa' => $tugasSiswa,
            'kelas' => $kelas,
        ];
        return view('view_guru.tugasSiswa.index', $data);
    }
    public function periksaTugas($id)
    {
        $tugasSiswa = TugasSiswa::where('id', $id)->first();
        if (!$tugasSiswa) {
            abort('404');
        }
        $tugas = Tugas::where('id', $tugasSiswa->tugas_id)->first();
        if ($tugasSiswa->status == '0') {
            $edit = [
                'status' => '1',
            ];
            DB::table('tugas_siswas')->where('id', $tugasSiswa->id)->update($edit);
        }
        $data = [
            'title' => ' Kelas',
            'tugas' => $tugas,
            'tugasSiswa' => $tugasSiswa,
        ];
        return view('view_guru.tugasSiswa.detailTugasSiswa', $data);
    }
}
