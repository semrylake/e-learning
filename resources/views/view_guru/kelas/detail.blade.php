@extends('templates.dashboard')
@section('content')

<a href="/kelas" class="btn btn-primary mb-2"><i class="menu-icon tf-icons bx bx-arrow-back"></i> Kembali</a>

@if (session('del_msg'))
<div class="alert alert-success alert-dismissible border border-success" role="alert">
    {{ session('del_msg') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- <div class="card">
    <h5 class="card-header border-bottom mb-2">Detail Kelas</h5>
    <div class="card-body">
        <p class="mb-0"><span class="fw-bold">Nama Kelas :</span> {{ $kelas->nama_kelas }}</p>
        <p class="mt-0 mb-0"><span class="fw-bold">Nama Guru :</span> {{ $kelas->user->nama }}</p>
        <p class="mt-0 mb-0"><span class="fw-bold">Kode Kelas :</span> {{ $kelas->slug }}</p>
        <p class="mt-0 mb-0"><span class="fw-bold">Jumlah Siswa :</span> 10 Orang</p>


    </div>

</div> --}}
<div class="col-xl-12 mt-4">
    <h4 class="text-dark">Detail Kelas</h4>
    <div class="nav-align-top mb-4">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                    <i class="tf-icons bx bx-home"></i> Detail
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                    aria-selected="false">
                    <i class="tf-icons bx bx-user"></i> Data Siswa
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                    aria-selected="false">
                    <i class="menu-icon tf-icons bx bx-copy-alt"></i> Materi
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tugas"
                    aria-controls="tugas" aria-selected="false">
                    <i class="menu-icon tf-icons bx bx-clipboard"></i> tugas
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                <h5><span class="fw-bold">Nama Kelas :</span> {{ $kelas->nama_kelas }}</h5>
                <h5><span class="fw-bold">Nama Guru :</span> {{ $kelas->user->nama }}</h5>
                <h5><span class="fw-bold">Kode Kelas :</span> {{ $kelas->slug }}</h5>
                <h5><span class="fw-bold">Jumlah Siswa :</span> {{ count($anggotaKelas) }} Orang</h5>
            </div>
            <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                <table class="table table-hover table-striped" id="tabel_guru">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggotaKelas as $a)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $a->user->nama }}</td>
                            <td>{{ $a->user->kode_user }}</td>
                            <td>
                                <form action="/delete-anggotaKelas/{{ $a->user->kode_user }}" method="post"
                                    class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" title="Hapus" class="btn btn-icon btn-danger"
                                        onclick="return confirm('Anda yakin ingin menghapus data ini??');">
                                        <span class="tf-icons bx bx-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="4">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                <a href="/tambah-materi/{{ $kelas->slug }}" class="btn btn-primary mb-3"><i
                        class="menu-icon tf-icons bx bx-plus"></i> Tambah Materi</a>
                @forelse ($materi as $a)
                <h3>{{ $a->judul }}</h3>
                <form action="/delete-materi/{{ $a->id }}" method="post" class="d-inline mt-0">
                    @method('delete')
                    @csrf
                    <button type="submit" title="Hapus" class="btn btn-sm btn-danger"
                        onclick="return confirm('Anda yakin ingin menghapus data ini??');">
                        Hapus
                    </button>
                </form><br>
                <small class="mt-1">Created at : {{ $a->created_at }}</small>
                <p class="mt-0 mb-0">
                    {{ $a->deskripsi }}
                </p>
                <a href="/download-materi/{{ $a->id }}" target="_blank" class="mt-0 mb-0">Download materi disini !</a>
                <hr>
                @empty
                <h1>Belum ada materi baru.</h1>
                @endforelse
            </div>
            <div class="tab-pane fade" id="tugas" role="tabpanel">
                <a href="/tambah-tugas/{{ $kelas->slug }}" class="btn btn-primary mb-3"><i
                        class="menu-icon tf-icons bx bx-plus"></i> Tambah Tugas Baru</a>
                @forelse ($tugas as $a)
                <h3>{{ $a->judul }}</h3>
                <div class="d-flex">
                    <form action="/delete-tugas/{{ $a->id }}" method="post" class="d-inline ">
                        @method('delete')
                        @csrf
                        <button type="submit" title="Hapus" class="btn  btn-danger"
                            onclick="return confirm('Anda yakin ingin menghapus data ini??');">
                            Hapus
                        </button>
                    </form>
                    <a href="/edit-tugas/{{ $a->id }}" class="btn  btn-warning ms-2">Edit</a>
                    <a href="/tugas-dikumpul/{{ $a->slug }}" target="_blank" class="btn  btn-success ms-2">Tugas
                        Siswa</a>
                </div>
                <br>
                <span class="fw-bold">Batas Pengiriman Tugas : {{ $a->batas_kumpul }}</span>
                <p class="mt-0 mb-0">
                    {{ $a->keterangan }}
                </p>
                <a href="/download-tugas/{{ $a->id }}" target="_blank" class="mt-0 mb-0 fw-bold">Download tugas disini
                    !</a>
                <hr>
                @empty
                <h1>Belum ada tugas baru.</h1>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
