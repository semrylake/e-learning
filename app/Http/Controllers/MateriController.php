<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Materi::class, 'slug', $request->kodeKelas);
        return response()->json(['slug' => $slug]);
    }
    public function index($slug)
    {
        $kelas = Kelas::where('slug', $slug)->first();
        if (!$kelas) {
            abort('404');
        }
        $data = [
            'title' => ' Kelas',
            'kelas' => $kelas,
        ];
        return view('view_guru.materi.index', $data);
        // $materi = Materi::where('user_id', Auth::user()->id)->where('kelas_id', $kelas->id)->get();
    }
    public function store(Request $request, $id)
    {
        // dd($request->all());
        $val = $request->validate([
            'slug' => 'required|unique:materis,slug',
            'judul' => 'required',
            'deskripsi' => 'required',
            'file_materi' => 'required|mimes:pdf',
        ], [
            'slug.required' => 'Kolom ini harus diisi !!',
            'judul.required' => 'Kolom ini harus diisi !!',
        ]);
        $val['kelas_id'] = $id;
        $val['user_id'] = Auth::user()->id;
        if ($request->file('file_materi')) {
            $file = Request()->file_materi;
            $fileName = Str::random(20)  . '.' . $file->extension();
            $file->move(public_path('file-pdf-materi'), $fileName);
            $val['file_materi'] = $fileName;
        }
        Materi::create($val);
        return redirect()->back()->with('psn', 'Materi berhasil diupload.');
    }
    public function download($id)
    {
        $materi = Materi::where('id', $id)->first();
        // dd($materi);
        $filePath = public_path('file-pdf-materi/' . $materi->file_materi);
        $header = ['Content-Type: application/pdf'];
        $filename = $materi->slug . '.pdf';
        return response()->download($filePath, $filename, $header);
    }
    public function destroy($id)
    {
        $materi = Materi::where('id', $id)->first();
        File::delete('file-pdf-materi/' . $materi->file_materi);
        DB::table('materis')->where('id', $id)->delete();
        // Storage::delete($resident->foto);
        return redirect()->back()->with('del_msg', 'Data berhasil dihapus.');
    }
}
