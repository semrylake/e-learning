@extends('templates.dashboard')
@section('content')

<a href="/tambah-kelas" class="btn btn-primary mb-2">Tambah Mata Pelajaran</a>

@if (session('del_msg'))
<div class="alert alert-success alert-dismissible border border-success" role="alert">
    {{ session('del_msg') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <h5 class="card-header border-bottom mb-2">Daftar Kelas/Mata Pelajaran.</h5>
    <div class="table-responsive text-nowrap card-body">
        <table class="table table-hover table-striped" id="tabel_guru">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Kelas/Mata Pelajaran</th>
                    <th>Kode Kelas</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelas as $a)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $a->nama_kelas }}</td>
                    <td>{{ $a->slug }}</td>
                    <td>
                        <a href="/detail-kelas/{{ $a->slug }}" title="Detail" class="btn btn-icon btn-success">
                            <span class="tf-icons bx bx-info-circle"></span>
                        </a>
                        <form action="/delete-kelas/{{ $a->slug }}" method="post" class="d-inline">
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
</div>

@endsection
