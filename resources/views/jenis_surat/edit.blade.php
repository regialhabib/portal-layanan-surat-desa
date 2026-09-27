@extends('layouts.main')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit Jenis Surat</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('jenis-surat.update', $jenisSurat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_surat" class="form-label">Nama Surat</label>
                        <input type="text" class="form-control" id="nama_surat" name="nama_surat" value="{{ old('nama_surat', $jenisSurat->nama_surat) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="aktif" name="aktif" value="1" {{ old('aktif', $jenisSurat->aktif) ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">Aktif</label>
                    </div>

                    <hr>
                    <h5>Persyaratan Surat</h5>
                    <div id="syarat-container">
                        @foreach($jenisSurat->syarat as $i => $sya)
                        <div class="row mb-2 syarat-row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="syarat[{{ $i }}][nama_syarat]" value="{{ $sya->nama_syarat }}" placeholder="Nama Syarat" required>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="syarat[{{ $i }}][format_file]" required>
                                    <option value="all" {{ $sya->format_file == 'all' ? 'selected' : '' }}>Semua (all)</option>
                                    <option value="image" {{ $sya->format_file == 'image' ? 'selected' : '' }}>Gambar (image)</option>
                                    <option value="pdf" {{ $sya->format_file == 'pdf' ? 'selected' : '' }}>PDF (pdf)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-syarat-btn">Hapus</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mb-3" id="add-syarat-btn">Tambah Syarat</button>

                    <div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('jenis-surat.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('syarat-container');
        const addBtn = document.getElementById('add-syarat-btn');
        let index = {{ count($jenisSurat->syarat) }};

        addBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'syarat-row');
            
            row.innerHTML = `
                <div class="col-md-6">
                    <input type="text" class="form-control" name="syarat[${index}][nama_syarat]" placeholder="Nama Syarat" required>
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="syarat[${index}][format_file]" required>
                        <option value="all">Semua (all)</option>
                        <option value="image">Gambar (image)</option>
                        <option value="pdf">PDF (pdf)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-syarat-btn">Hapus</button>
                </div>
            `;
            container.appendChild(row);
            index++;
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-syarat-btn')) {
                e.target.closest('.syarat-row').remove();
            }
        });
    });
</script>
@endpush
