@extends('layouts.auth')

@push('style')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    body {
        background-color: #F8FAFC;
        font-family: 'Inter', sans-serif;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 32px rgba(30, 58, 138, 0.08);
        overflow: hidden;
        border: 1px solid #E2E8F0;
    }

    .login-header {
        background: linear-gradient(
            135deg,
            #DBEAFE 0%,
            #EFF6FF 100%
        );
        padding: 24px;
        text-align: center;
        border-bottom: 1px solid #E2E8F0;
    }

    .login-header img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    .login-header h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1E3A8A;
    }

    .login-header p {
        margin-top: 4px;
        font-size: 13px;
        color: #475569;
    }

    .form-label {
        color: #1E293B;
        font-weight: 500;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #CBD5E1;
    }

    .form-control:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .2);
    }

    .input-group .btn {
        border-color: #CBD5E1;
    }

    .btn-primary {
        background: #1E3A8A;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 10px;
        transition: .2s;
    }

    .btn-primary:hover {
        background: #1e40af;
        transform: translateY(-1px);
    }

    .btn-primary:focus {
        box-shadow: 0 0 0 .2rem rgba(30, 58, 138, .25);
    }

    .card-body {
        background: #fff;
    }
</style>
@endpush

@section('main-content')
<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <img src="{{ asset('images/sekolah.png') }}" alt="Logo Desa">
            <h5>Pendaftaran Akun</h5>
            <h5>Desa Lubuk Bernai</h5>
            <p>Verifikasi identitas warga Anda</p>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text"
                        class="form-control @error('nik') is-invalid @enderror"
                        name="nik"
                        value="{{ old('nik') }}"
                        placeholder="Masukkan 16 Digit NIK"
                        maxlength="16">

                    @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan Email">

                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="Buat password">

                        <button class="btn btn-light" type="button">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>

                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary">Daftar Akun</button>
                </div>

                <div class="mt-4 text-center">
                    <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none">Login di sini</a></p>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
