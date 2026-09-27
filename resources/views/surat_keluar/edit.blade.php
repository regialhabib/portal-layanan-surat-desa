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
                                <h4 class="mb-sm-0 font-size-18">Form Edit Surat Keluar</h4>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('surat_keluar.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $surat->id }}">
                        <input type="hidden" id="no_berkas" class="form-control" name="no_berkas" required
                                    placeholder="Nomor Berkas" value="{{ $surat->no_berkas }}" />
                        <div class="row mb-3">
                            
                            <div class="col-4">
                                <label for="no_surat" class="form-label">Nomor Surat</label>
                                <input type="text" id="no_surat" class="form-control" name="no_surat" required
                                    placeholder="Nomor Surat" value="{{ $surat->no_surat }}" />
                            </div>
                            <div class="col-4">
                                <label for="no_berkas" class="form-label">Nomor Berkas</label>
                                <input type="text" id="no_berkas" class="form-control" name="no_berkas" required
                                    placeholder="Nomor Berkas" value="{{ $surat->no_berkas }}" />
                            </div>
                            <div class="col-4">
                                <label for="deskripsi-input" class="form-label">Perihal</label>
                                <textarea name="isi_surat" class="form-control" id="deskripsi-input" cols="30" rows="2">{{ $surat->isi_surat }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Tanggal Kirim</label>
                                <input type="date" class="form-control" name="tanggal_terima"
                                    value="{{ $surat->tanggal_terima->format('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <label for="deskripsi-input" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="deskripsi-input" cols="30" rows="2">{{ $surat->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="no_berkas" class="form-label">Penerima</label>
                                <input type="text" id="no_berkas" class="form-control" name="alamat_penerima" required
                                    placeholder="Alamat Pnerima" value="{{ $surat->alamat_penerima }}" />
                            </div>
                            <div class="col-6">
                                <label>Surat</label>
                                <input type="file" class="form-control" name="file_surat">

                                @if ($surat->path_surat)
                                    <small class="text-muted">
                                        File saat ini:
                                        <a href="{{ asset('storage/' . $surat->path_surat) }}" target="_blank">
                                            Lihat File
                                        </a>
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>

                            <a href="{{ route('surat_keluar.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- end page title -->
@endsection
