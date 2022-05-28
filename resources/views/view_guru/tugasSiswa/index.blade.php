@extends('templates.dashboard')
@section('content')

{{-- <a href="/detail-kelas/{{ $kelas->slug }}" class="btn btn-primary mb-2"><i
        class="menu-icon tf-icons bx bx-arrow-back"></i> Kembali</a> --}}

<div class="card mb-4">
    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Data siswa yang telah mengumpulkan tugas</h5>
    </div>
    <div class="card-body mt-2">
        <table class="table table-hover table-striped" id="tabel_guru">
            <thead>
                <tr class="text-nowrap">
                    <th>#</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Tanggal Kumpul</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugasSiswa as $a)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $a->user->nama }}</td>
                    <td>{{ $a->user->kode_user }}</td>
                    <td>{{ $a->tgl_kumpul }}</td>
                    <td>
                        @if ($a->status == '0')
                        <h5 class="text-danger">Belum diperiksa</h5>
                        @else
                        <h5 class="text-success">Sudah diperiksa</h5>
                        @endif
                    </td>

                    <td>
                        @if ($a->status == '0')
                        <a href="/periksa-tugas/{{ $a->id }}" class="btn btn-danger">Periksa</a>
                        @else
                        <a href="/periksa-tugas/{{ $a->id }}" class="btn btn-success">Lihat</a>
                        @endif
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
