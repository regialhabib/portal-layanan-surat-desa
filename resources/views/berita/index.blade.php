@extends('layouts.main')

@push('style')
    <!-- DataTables -->
    <link href="{{ URL::asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush

@section('main-content')
    <div class="card">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-block-helper me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-all me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                    <i class="mdi mdi-block-helper me-2"></i>
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="card-title mb-0">
                Data Berita Desa
            </h4>

            <a href="{{ route('news.create') }}" class="btn btn-primary btn-sm">

                <i class="bx bx-plus"></i>
                Tambah Berita

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle" id="datatable">

                    <thead class="table-primary">

                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Thumbnail</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th width="15%">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($berita as $item)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>

                                    @if ($item->thumbnail)
                                        <img src="{{ $item->thumbnail_url }}" class="img-fluid rounded"
                                            style="max-height:80px;">
                                    @else
                                        <span class="text-muted">
                                            Tidak ada gambar
                                        </span>
                                    @endif

                                </td>

                                <td>
                                    {{ $item->judul }}
                                </td>

                                <td>
                                    {{ $item->user->role }}
                                </td>

                                <td>
                                    {{ $item->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td>

                                    <div class="d-flex gap-1">

                                        <a href="{{ route('berita.show', $item->id) }}" class="btn btn-info btn-sm ">

                                            <i class="bx bx-show"></i>

                                        </a>

                                        <a href="{{ route('berita.edit', $item->id) }}" class="btn btn-warning btn-sm">

                                            <i class="bx bx-edit"></i>

                                        </a>

                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete"
                                            data-url="{{ route('berita.destroy', $item->id) }}">
                                            <i class="bx bx-trash"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    <!--  Form Delete -->
    <form id="form-delete" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection
@push('script')
    <script src="{{ URL::asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('js/pages/datatables.init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            const form = document.getElementById('form-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.action = url;
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
