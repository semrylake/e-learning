@extends('templates.dashboard')
@section('content')

<a href="/kelas-siswa" class="btn btn-primary mb-2"><i class="menu-icon tf-icons bx bx-arrow-back"></i> Kembali</a>

<div class="col-xl-12">
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active fw-bold" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                    Materi
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link fw-bold" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                    Tugas
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                @forelse ($materi as $a)
                <h3>{{ $a->judul }}</h3>

                <small class="mt-1 fw-bold text-dark">Created at : {{ $a->created_at }}</small>
                <p class="mt-0 mb-0">
                    {{ $a->deskripsi }}
                </p>
                <a href="/download-materi/{{ $a->id }}" target="_blank" class="mt-0 mb-0 fw-bold">Download
                    materi disini !</a>
                <hr>
                @empty
                <h1>Belum ada materi baru.</h1>
                @endforelse
            </div>
            <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                @forelse ($tugas as $a)
                <h3>{{ $a->judul }}</h3>
                @php
                $tglSek = new DateTime($tanggal_sekarang);
                $tglkmpl = new DateTime($a->batas_kumpul);
                @endphp
                @if ($tglSek > $tglkmpl)
                <h4 class="mt-1 fw-bold text-danger">Batas pengumpulan tugas sudah lewat.</h4>
                @else
                <a href="/kumpul-tugas/{{ $a->slug }}" class="btn btn-sm btn-success">Kumpul Tugas</a><br>
                @endif
                <small class="fw-bold text-dark">Batas pengumpulan tugas : {{ $a->batas_kumpul }}</small>
                <p class="mt-0 mb-0">
                    {{ $a->keterangan }}
                </p>
                <a href="/download-tugas/{{ $a->id }}" target="_blank" class="mt-0 mb-0 fw-bold">Download
                    tugas disini !</a>
                <hr>
                @empty
                <h1>Belum ada tugas baru.</h1>
                @endforelse
            </div>
        </div>
    </div>
</div>


@endsection
