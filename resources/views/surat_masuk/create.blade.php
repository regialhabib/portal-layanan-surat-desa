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
                                <h4 class="mb-sm-0 font-size-18">Form Tambah Surat Masuk</h4>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('surat_masuk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="no_berkas" class="form-control" name="no_berkas" required
                                     value="-" />
                        <div class="row mb-3">
                            
                            <div class="col-6">
                                <label for="no_surat" class="form-label">Nomor Surat</label>
                                <input type="text" id="no_surat" class="form-control" name="no_surat" required
                                     />
                            </div>
                            <div class="col-6">
                                <label for="deskripsi-input" class="form-label">Perihal</label>
                                <textarea name="isi_surat" class="form-control" id="deskripsi-input" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="no_berkas" class="form-label">Tanggal Diterima</label>
                                <input type="date" id="no_berkas" class="form-control" name="tanggal_terima" required />
                            </div>
                            <div class="col-6">
                                <label for="deskripsi-input" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="deskripsi-input" cols="30" rows="2"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="no_berkas" class="form-label">Pengirim</label>
                                <input type="text" id="no_berkas" class="form-control" name="alamat_penerima" required
                                     />
                            </div>
                            <div class="col-6">
                                <label for="">Surat</label>
                                <input type="file" class="form-control" name="file_surat" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>

                            <a href="{{ route('surat_masuk.index') }}" class="btn btn-secondary">
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
