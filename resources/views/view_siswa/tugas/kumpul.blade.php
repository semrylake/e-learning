@extends('templates.dashboard')
@section('content')

<a href="/materi-siswa/{{ $kelas->slug }}" class="btn btn-primary mb-2">Kembali</a>

@if (session('psn'))
<div class="alert alert-success alert-dismissible border border-success" role="alert">
    {{ session('psn') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    @if (!$tugasSiswaKumpul)
    <h3 class="text-danger">Kamu belum memasukan tugas</h3>
    @else
    <h3 class="text-success">Kamu sudah memasukan tugas</h3>
    @endif
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Form Pengumpulan Tugas</h5>

            </div>
            <div class="card-body">

                @if (!$tugasSiswaKumpul)
                <form action="/kumpulTugas/{{ $tugas->slug }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('nama', Auth::user()->nama) }}" type="text"
                                class="form-control @error('nama') is-invalid @enderror" name=" nama" id="nama"
                                placeholder="Kode Kelas" required />
                            <div class="invalid-feedback text-danger">
                                @error('nama')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nis">NIS</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('nis', Auth::user()->kode_user) }}" type="text"
                                class="form-control @error('nis') is-invalid @enderror" name="nis" id="nis"
                                placeholder="Hasil Generate Kode Kelas" required />
                            <div class="invalid-feedback text-danger">
                                @error('nis')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mapel">Mata Pelajaran</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('mapel', $kelas->nama_kelas) }}" type="text"
                                class="form-control @error('mapel') is-invalid @enderror" name="mapel" id="mapel"
                                required />
                            <div class="invalid-feedback text-danger">
                                @error('mapel')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama_tugas">Nama Tugas</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('nama_tugas', $tugas->judul) }}" type="text"
                                class="form-control @error('nama_tugas') is-invalid @enderror" name="nama_tugas"
                                id="nama_tugas" required />
                            <div class="invalid-feedback text-danger">
                                @error('nama_tugas')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="file_tugas_siswa" class="col-sm-2 col-form-label">File Tugas</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="file_tugas_siswa" name="file_tugas_siswa"
                                required />
                            <small>File dalam bentuk pdf</small>
                            <div class="invalid-feedback text-danger">
                                @error('file_tugas_siswa')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Kirim</button>
                        </div>
                    </div>
                </form>
                @else
                <form action="/updatekumpulTugas/{{ $tugas->slug }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('nama', Auth::user()->nama) }}" type="text"
                                class="form-control @error('nama') is-invalid @enderror" name=" nama" id="nama"
                                placeholder="Kode Kelas" required />
                            <div class="invalid-feedback text-danger">
                                @error('nama')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nis">NIS</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('nis', Auth::user()->kode_user) }}" type="text"
                                class="form-control @error('nis') is-invalid @enderror" name="nis" id="nis"
                                placeholder="Hasil Generate Kode Kelas" required />
                            <div class="invalid-feedback text-danger">
                                @error('nis')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="mapel">Mata Pelajaran</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('mapel', $kelas->nama_kelas) }}" type="text"
                                class="form-control @error('mapel') is-invalid @enderror" name="mapel" id="mapel"
                                required />
                            <div class="invalid-feedback text-danger">
                                @error('mapel')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama_tugas">Nama Tugas</label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('nama_tugas', $tugas->judul) }}" type="text"
                                class="form-control @error('nama_tugas') is-invalid @enderror" name="nama_tugas"
                                id="nama_tugas" required />
                            <div class="invalid-feedback text-danger">
                                @error('nama_tugas')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="file_tugas_siswa" class="col-sm-2 col-form-label">File Tugas</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="file_tugas_siswa" name="file_tugas_siswa"
                                required />
                            <small>File dalam bentuk pdf</small>
                            <div class="invalid-feedback text-danger">
                                @error('file_tugas_siswa')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- create slug kelas start --}}
<script>
    const kodeKelas = document.querySelector('#kode_kelas');
    const slug = document.querySelector('#slug');
    kodeKelas.addEventListener('change', function(){
        fetch('/createSlugKelas?kodeKelas='+kodeKelas.value)
        .then(response=>response.json())
        .then(data=>slug.value = data.slug)
    });
</script>
{{-- create slug kelas end --}}

@endsection
