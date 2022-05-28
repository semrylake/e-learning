<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaKelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('frontView.index', [
        'title' => 'Login',
    ]);
})->name('login')->middleware('guest');

Route::get('/home', function () {
    return redirect('/dashboard');
})->name('home')->middleware('auth');


Route::controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard_view')->middleware('auth');
    Route::get('/admin-dashboard', 'adminDashboard')->name('adminDashboard')->middleware('auth');
});
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'login')->name('login_view')->middleware('guest');
    Route::post('/loginprocess', 'loginprocess')->name('loginprocess')->middleware('guest');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

//Route Guru
Route::controller(GuruController::class)->group(function () {
    Route::get('/guru-dashboard', 'dashboard')->name('dashboardGuru')->middleware('auth');
    Route::get('/guru', 'index')->name('indexGuru')->middleware('auth');
    Route::get('/tambah-guru', 'tambah')->name('tambahGuru')->middleware('auth');
    Route::post('/tambahGuru', 'store')->name('storeGuru')->middleware('auth');
    Route::get('/edit-guru/{id}', 'edit')->name('editGuru')->middleware('auth');
    Route::put('/updateGuru/{id}', 'update')->name('updateGuru')->middleware('auth');
    Route::delete('/delete-guru/{id}', 'destroy')->name('destroy')->middleware('auth');
});

//Route Siswa
Route::controller(SiswaController::class)->group(function () {
    Route::get('/siswa-dashboard', 'dashboard')->name('dashboardSiswa')->middleware('auth');
    Route::get('/siswa', 'index')->name('indexSiswa')->middleware('auth');
    Route::get('/tambah-siswa', 'tambah')->name('tambahsiswa')->middleware('auth');
    Route::post('/tambahSiswa', 'store')->name('storeSiswa')->middleware('auth');
    Route::get('/edit-siswa/{id}', 'edit')->name('editSiswa')->middleware('auth');
    Route::put('/updateSiswa/{id}', 'update')->name('updateSiswa')->middleware('auth');
    Route::delete('/delete-siswa/{id}', 'destroy')->name('destroy')->middleware('auth');
});

//Route Kelas
Route::controller(KelasController::class)->group(function () {
    Route::get('/kelas', 'index')->name('indexKelas')->middleware('auth');
    Route::get('/tambah-kelas', 'tambah')->name('tambahKelas')->middleware('auth');
    Route::get('/createSlugKelas', 'checkSlug')->name('checkSlugKelas')->middleware('auth');
    Route::post('/tambahKelas', 'store')->name('storeKelas')->middleware('auth');
    Route::get('/detail-kelas/{slug}', 'detail')->name('detailKelas')->middleware('auth');
    // Route::get('/edit-Kelas/{id}', 'edit')->name('editKelas')->middleware('auth');
    // Route::put('/updateKelas/{id}', 'update')->name('updateKelas')->middleware('auth');
    Route::delete('/delete-kelas/{id}', 'destroy')->name('destroyKelas')->middleware('auth');
});


Route::controller(AnggotaKelasController::class)->group(function () {
    Route::get('/kelas-siswa', 'anggotaSiswaKelas')->name('anggotaSiswaKelas')->middleware('auth');
    Route::delete('/gabung-kelas/{id}', 'gabung')->name('gabungKelas')->middleware('auth');
    Route::get('/materi-siswa/{slug}', 'materi')->name('materiKelasSiswa')->middleware('auth');
    // Route::get('/tugas-siswa', 'tugas')->name('tugasKelasSiswa')->middleware('auth');
    Route::delete('/delete-anggotaKelas/{id}', 'destroy')->name('destroyanggotaSiswaKelas')->middleware('auth');
    Route::get('/kumpul-tugas/{id}', 'kumpul')->name('kumpultugas')->middleware('auth');
    Route::post('/kumpulTugas/{id}', 'store')->name('storetugas')->middleware('auth');
    Route::put('/updatekumpulTugas/{id}', 'update')->name('updatetugas')->middleware('auth');
});
Route::controller(MateriController::class)->group(function () {
    Route::get('/tambah-materi/{slug}', 'index')->name('indexmateri')->middleware('auth');
    Route::get('/createSlugmateri', 'checkSlug')->name('checkSlugMateri')->middleware('auth');
    Route::post('/tambahMateri/{id}', 'store')->name('storeMateri')->middleware('auth');
    Route::get('/download-materi/{id}', 'download')->name('downloadMateri')->middleware('auth');
    Route::delete('/delete-materi/{id}', 'destroy')->name('destroyMateri')->middleware('auth');
});
Route::controller(TugasController::class)->group(function () {
    Route::get('/tambah-tugas/{slug}', 'tambah')->name('tambahtugas')->middleware('auth');
    Route::get('/createSlugTugas', 'checkSlug')->name('checkSlugTugas')->middleware('auth');
    Route::post('/tambahTugas/{id}', 'store')->name('storetugas')->middleware('auth');
    Route::get('/edit-tugas/{id}', 'edit')->name('edittugas')->middleware('auth');
    Route::put('/updateTugas/{id}', 'update')->name('updatetugas')->middleware('auth');
    Route::get('/download-tugas/{id}', 'download')->name('downloadtugas')->middleware('auth');
    Route::delete('/delete-tugas/{id}', 'destroy')->name('destroytugas')->middleware('auth');
    Route::get('/tugas-dikumpul/{id}', 'tugasDikumpul')->name('tugasDikumpulSiswa')->middleware('auth');
    Route::get('/periksa-tugas/{id}', 'periksaTugas')->name('periksaTugasSiswa')->middleware('auth');
});
