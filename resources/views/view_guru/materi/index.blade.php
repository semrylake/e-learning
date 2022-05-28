@extends('templates.dashboard')
@section('content')

<a href="/detail-kelas/{{ $kelas->slug }}" class="btn btn-primary mb-2"><i
        class="menu-icon tf-icons bx bx-arrow-back"></i> Kembali</a>

@if (session('psn'))
<div class="alert alert-success alert-dismissible border border-success" role="alert">
    {{ session('psn') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Form Tambah Materi</h5>
            </div>
            <div class="card-body">
                <form action="/tambahMateri/{{ $kelas->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="judul">Judul</label>
                        <div class="col-sm-10">
                            <input autofocus value="{{ old('judul') }}" type="text"
                                class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul"
                                required />
                            <input type="hidden" class="form-control @error('judul') is-invalid @enderror" name="slug"
                                id="slug">
                            <div class=" invalid-feedback text-danger">
                                @error('judul')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                        <div class="col-sm-10">
                            <input autofocus value="{{ old('deskripsi') }}" type="text"
                                class="form-control @error('deskripsi') is-invalid @enderror" name=" deskripsi"
                                id="deskripsi" required />
                            <div class="invalid-feedback text-danger">
                                @error('deskripsi')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="file_materi" class="col-sm-2 col-form-label">File</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="file_materi" name="file_materi" required />
                            <small>File dalam bentuk pdf</small>
                            <div class="invalid-feedback text-danger">
                                @error('file_materi')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- create slug kelas start --}}
<script>
    const kodeKelas = document.querySelector('#judul');
    const slug = document.querySelector('#slug');
    kodeKelas.addEventListener('change', function(){
        fetch('/createSlugmateri?kodeKelas='+kodeKelas.value)
        .then(response=>response.json())
        .then(data=>slug.value = data.slug)
    });
</script>

@endsection
