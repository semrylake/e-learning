@extends('templates.dashboard')
@section('content')

<a href="/tugas-dikumpul/{{ $tugas->slug }}" class="btn btn-primary mb-2"><i
        class="menu-icon tf-icons bx bx-arrow-back"></i> Kembali</a>

<div class="row">
    <div class="col-md-4">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Data Siswa</h5>
                <ul class="list-group list-group-flush">
                    <p class="list-group-item">Nama Siswa : {{ $tugasSiswa->user->nama }}</p>
                    <p class="list-group-item">NIS : {{ $tugasSiswa->user->kode_user }}</p>
                    <p class="list-group-item">Tanggal dikumpulkan : {{ $tugasSiswa->tgl_kumpul }}</p>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="main-card mb-3 card">
            {{-- <div class="card-body">
                <object width="100%" height="440" data="{{ asset('/storage/'.$dataregis->bukti_regis) }}"
                    type="application/pdf"></object>
            </div> --}}
            <div class="ratio ratio-16x9">
                <iframe width="100%" height="480" type="application/pdf" allowfullscreen
                    src="{{ asset('/file-pdf-tugas-kumpul-siswa/'.$tugasSiswa->file_tugas_siswa) }}#toolbar=0"
                    frameborder=" 0"></iframe>
            </div>
        </div>
    </div>
</div>


@endsection
