@extends('templates.dashboard')
@section('content')

<a href="/guru" class="btn btn-primary mb-2">Kembali</a>

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
                <h5 class="mb-0">Form Tambah Data Guru</h5>
            </div>
            <div class="card-body">
                <form action="/tambahGuru" method="post">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="nama">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input autofocus value="{{ old('nama') }}" type="text"
                                class="form-control @error('nama') is-invalid @enderror" name=" nama" id="nama"
                                placeholder="Nama Lengkap" required />
                            <div class="invalid-feedback text-danger">
                                @error('nama')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="kode_user">NIP</label>
                        <div class="col-sm-10">
                            <input autofocus value="{{ old('kode_user') }}" type="text"
                                class="form-control @error('kode_user') is-invalid @enderror" name=" kode_user"
                                id="kode_user" placeholder="NIP" required />
                            <div class="invalid-feedback text-danger">
                                @error('kode_user')
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

@endsection
