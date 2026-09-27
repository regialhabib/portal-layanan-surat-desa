@extends('layouts.main')
@section('main-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-block-helper me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                                        <i class="mdi mdi-block-helper me-2"></i>
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Form Tambah Surat Keluar</h4>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('penduduk.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control" required
                                    value="{{ old('nik') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nomor KK</label>
                                <input type="text" name="no_kk" class="form-control" required
                                    value="{{ old('no_kk') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required
                                    value="{{ old('nama') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required
                                    value="{{ old('tempat_lahir') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" required
                                    value="{{ old('tanggal_lahir') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Agama</label>
                                <select name="agama" class="form-select">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-select">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">RT</label>
                                <input type="text" name="rt" class="form-control" value="{{ old('rt') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">RW</label>
                                <input type="text" name="rw" class="form-control" value="{{ old('rw') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Dusun</label>
                                <input type="text" name="dusun" class="form-control" value="{{ old('dusun') }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Simpan
                            </button>

                            <a href="{{ route('penduduk.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- end page title -->
@endsection
