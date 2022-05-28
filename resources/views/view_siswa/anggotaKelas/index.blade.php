@extends('templates.dashboard')
@section('content')



<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
    <i class="menu-icon tf-icons bx bx-plus"></i> Cari Kelas
</button>
<hr>
@if (session('gagalSubmitKode'))
<div class="alert alert-danger" role="alert">{{ session('gagalSubmitKode') }}</div>
@endif

@if (session('sudahMasuk'))
<div class="alert alert-danger" role="alert">{{ session('sudahMasuk') }}</div>
@endif
@if (session('suksesMasuk'))
<div class="alert alert-success" role="alert">{{ session('suksesMasuk') }}</div>
@endif


@if (request('kode_kelas'))
@if ($kelasGuru)
@if ($kelasGuru->slug == request('kode_kelas'))
<div class="col-md-3 mb-4 mt-3">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-2">{{ $kelasGuru->nama_kelas }}</h3>
            <span class="fw-semibold d-block mb-1">Guru : {{ $kelasGuru->user->nama }}</span>
            <p class="text-success fw-semibold">{{count($kelas)}} Siswa telah
                bergabung</p>
            @if (count($kelas) == 0)
            <form action="/gabung-kelas/{{ $kelasGuru->slug }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">
                    Gabung Sekarang
                </button>
            </form>
            @else
            <a href="#" class="btn btn-primary">Sudah terdaftar</a>
            @endif
        </div>
    </div>
</div>
@else
<div class="alert alert-danger mt-3" role="alert">Kode yang Anda masukan salah.</div>
@endif
@else
<div class="alert alert-danger mt-3" role="alert">Kode yang Anda masukan salah.</div>
@endif

@endif

@if (count($kelas) == 0)
{{-- <div class="alert alert-danger" role="alert">Kamu belum masuk kelas manapun.</div> --}}
@else
<h4 class="mt-3">Kelas Anda</h4>

<div class="row">
    @foreach ($kelas as $a)
    <a href="/materi-siswa/{{ $a->kelas->slug }}" class="col-lg-4 col-6 mb-4">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title mb-2">{{ $a->kelas->nama_kelas }}</h4>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endif


<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Form Masuk Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/kelas-siswa">
                    @csrf
                    <div class="row">
                        <div class="col mb-3">
                            <label for="kode_kelas" class="form-label">Masukan Kode Kelas</label>
                            <input value="{{request('kode_kelas')}}" type="text" id="kode_kelas" name="kode_kelas"
                                class="form-control" />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
