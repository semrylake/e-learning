@extends('templates.dashboard')
@section('content')

<div class="col-lg-12 order-1">
    <div class="row">
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">Jumlah Guru</span>
                    <h3 class="card-title mb-2 text-primary">{{ $guru }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <span class="fw-semibold d-block mb-1">Jumlah Siswa</span>
                    <h3 class="card-title mb-2 text-primary">{{ $siswa }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
