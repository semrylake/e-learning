@extends('templates.dashboard')
@section('content')

<a href="/tambah-siswa" class="btn btn-primary mb-2">Tambah Siswa</a>

@if (session('del_msg'))
<div class="alert alert-success alert-dismissible border border-success" role="alert">
    {{ session('del_msg') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <h5 class="card-header border-bottom mb-2">Data Siswa</h5>
    <div class="table-responsive text-nowrap card-body">
        <table class="table table-hover table-striped" id="tabel_guru">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>NIS</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $a)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $a->nama }}</td>
                    <td>{{ $a->kode_user }}</td>
                    <td>
                        <a href="/edit-siswa/{{ $a->id }}" title="Edit" class="btn btn-icon btn-warning">
                            <span class="tf-icons bx bx-pencil"></span>
                        </a>
                        <form action="/delete-siswa/{{ $a->id }}" method="post" class="d-inline">
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
