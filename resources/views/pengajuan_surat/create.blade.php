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
                    <form action="{{ route('pengajuan-surat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Surat</label>
                                <select class="form-select" name="jenis_surat_id" id="jenis_surat_id" required>
                                    <option value="">-- Pilih Jenis Surat --</option>

                                    @foreach ($jenisSurat as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama_surat }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keperluan</label>
                                <textarea name="keperluan" rows="3" class="form-control" required></textarea>
                            </div>

                        </div>

                        <hr>

                        <h5>Persyaratan</h5>

                        <div id="persyaratan-container">

                            <div class="alert alert-info">
                                Pilih jenis surat terlebih dahulu.
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-send"></i>
                                Ajukan Surat
                            </button>

                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- end page title -->
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSurat = document.getElementById('jenis_surat_id');
            const container = document.getElementById('persyaratan-container');

            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^\w\_]+/g, '');
            }

            jenisSurat.addEventListener('change', function() {
                const id = this.value;
                if (!id) {
                    container.innerHTML = '<div class="alert alert-info">Pilih jenis surat terlebih dahulu.</div>';
                    return;
                }

                container.innerHTML = '<p>Loading...</p>';

                fetch(`/jenis-surat/${id}/syarat`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            container.innerHTML = '<div class="alert alert-warning">Tidak ada persyaratan untuk jenis surat ini.</div>';
                            return;
                        }

                        let html = '<div class="row">';
                        data.forEach(syarat => {
                            let accept = '';
                            if (syarat.format_file === 'image') accept = 'accept="image/*"';
                            else if (syarat.format_file === 'pdf') accept = 'accept="application/pdf"';
                            else accept = 'accept="image/*,application/pdf"';

                            const inputName = slugify(syarat.nama_syarat);

                            html += `
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">${syarat.nama_syarat}</label>
                                    <input type="file" name="${inputName}" class="form-control" ${accept} required>
                                </div>
                            `;
                        });
                        html += '</div>';
                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching syarat:', error);
                        container.innerHTML = '<div class="alert alert-danger">Gagal mengambil data persyaratan.</div>';
                    });
            });
        });
    </script>
@endpush
