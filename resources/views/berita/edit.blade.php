@extends('layouts.main')


@push('style')
    <style>
        .ck-editor__editable {
            min-height: 500px;
        }
    </style>
@endpush

@section('main-content')

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">
                Edit Berita Desa
            </h4>
        </div>

        <div class="card-body">

            <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Judul --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Judul Berita
                        </label>

                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul', $berita->judul) }}" required>

                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Thumbnail Lama --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Thumbnail Saat Ini
                        </label>

                        <div>

                            @if ($berita->thumbnail)
                                <img src="{{ $berita->thumbnail_url }}" class="img-thumbnail" style="max-height: 200px;">
                            @else
                                <div class="text-muted">
                                    Tidak ada thumbnail
                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- Thumbnail Baru --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Ganti Thumbnail
                        </label>

                        <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                            accept="image/*">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti thumbnail.
                        </small>

                        @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Konten --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Konten Berita
                        </label>

                        <textarea name="konten" id="editor" class="form-control @error('konten') is-invalid @enderror">{{ old('konten', $berita->konten) }}</textarea>

                        @error('konten')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">

                        <i class="bx bx-save"></i>
                        Update

                    </button>

                    <a href="{{ route('berita.index') }}" class="btn btn-secondary">

                        <i class="bx bx-arrow-back"></i>
                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('script')

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

@endpush
