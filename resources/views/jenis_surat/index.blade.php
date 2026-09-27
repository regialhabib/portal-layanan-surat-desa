@extends('layouts.main')

@section('main-content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Data Jenis Surat</h4>
                <a href="{{ route('jenis-surat.create') }}" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus"></i> Tambah Jenis Surat
                </a>
            </div>
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <table class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Surat</th>
                            <th>Deskripsi</th>
                            <th>Persyaratan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jenisSurat as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_surat }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                @if($item->syarat->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($item->syarat as $syarat)
                                            <li>
                                                <i class="bx bx-check-circle text-success me-1"></i>
                                                {{ $syarat->nama_syarat }} 
                                                <span class="badge bg-soft-primary text-primary">{{ strtoupper($syarat->format_file) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada syarat</span>
                                @endif
                            </td>
                            <td>
                                @if($item->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('jenis-surat.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('jenis-surat.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
