@extends('templates.login')

@section('content')

<div class="card">
    <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center">
            <a href="#" class="app-brand-link">

                <span class="demo text-body fw-bolder">E-Learning | SMA Santo Paulus Weliman</span>
            </a>
        </div>
        @if (session('pesan'))
        <div class="alert alert-danger" role="alert">{{ session('pesan') }}</div>
        @endif
        <!-- /Logo -->
        <h4 class="mb-2">Selamat Datang! 👋</h4>
        <p class="mb-4">Silahkan masukan nomor identitas dan password untuk memulai</p>

        <form id="formAuthentication" class="mb-3" action="/loginprocess" method="POST">
            @csrf
            <div class="mb-3">
                <label for="text" class="form-label">NIS / NIP</label>
                <input type="text" class="form-control" id="kode_user" name="kode_user"
                    placeholder="Masukan nomor identitas Anda" autofocus />
            </div>
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
            </div>
            {{-- <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
            </div> --}}
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
            </div>
        </form>
    </div>
</div>

@endsection
