@extends('templates.dashboard')
@section('content')

<a href="/kelas" class="btn btn-primary mb-2">Kembali</a>

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
                <h5 class="mb-0">Form Tambah Kelas atau Mata Pelajaran</h5>
            </div>
            <div class="card-body">
                <form action="/tambahKelas" method="post">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="kode_kelas">Kode Kelas</label>
                        <div class="col-sm-10">
                            <input autofocus value="{{ old('kode_kelas') }}" type="text"
                                class="form-control @error('kode_kelas') is-invalid @enderror" name=" kode_kelas"
                                id="kode_kelas" placeholder="Kode Kelas" required />
                            <div class="invalid-feedback text-danger">
                                @error('kode_kelas')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="slug"></label>
                        <div class="col-sm-10">
                            <input readonly autofocus value="{{ old('slug') }}" type="text"
                                class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug"
                                placeholder="Hasil Generate Kode Kelas" required />
                            <div class="invalid-feedback text-danger">
                                @error('slug')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama_kelas">Mata Pelajaran & Kelas</label>
                        <div class="col-sm-10">
                            <input autofocus value="{{ old('nama_kelas') }}" type="text"
                                class="form-control @error('nama_kelas') is-invalid @enderror" name=" nama_kelas"
                                id="nama_kelas" placeholder="TIK - Kelas 10" required />
                            <div class="invalid-feedback text-danger">
                                @error('nama_kelas')
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
