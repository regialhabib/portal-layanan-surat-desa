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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif


                    <h4 class="card-title mb-3">Surat Masuk</h4>

                    <div class="d-flex align-items-end mb-4 gap-3 flex-wrap">

                        <!-- FORM FILTER (BIAR LEBAR) -->
                        <form method="GET" action="{{ route('surat_masuk.index') }}"
                            class="d-flex flex-wrap gap-2 flex-grow-1">

                            <div>
                                <label>Dari Tanggal</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                            <div>
                                <label>Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>

                            <div class="d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    Filter
                                </button>

                                <a href="{{ route('surat_masuk.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>
                        </form>

                        <!-- TOMBOL -->
                        <a href="{{ route('surat_masuk.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah Surat Masuk
                        </a>

                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead class="table-primary">
                            <tr class="">
                                <th>No Urut </th>
                                <th>No Surat</th>

                                <th>Tanggal Diterima</th>
                                <th>Pengirim</th>
                                <th>Perihal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        @php
                            $no = 1;
                        @endphp

                        <tbody>
                            @foreach ($surats as $surat)
                                <tr>
                                    <td class='text-center'>
                                        {{ $no++ }}

                                    </td>

                                    <td >{{ $surat->no_surat }}</td>


                                    <td>{{ $surat->tanggal_terima->format('d-m-Y') }}</td>
                                    <td>{{ $surat->alamat_penerima }}</td>
                                    <td >{{ $surat->isi_surat }}</td>
                                    <td >{{ $surat->keterangan }}</td>

                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <a href="{{ route('surat_masuk.download', $surat->id) }}"
                                                class="btn btn-sm btn-success ">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a class="btn btn-sm btn-primary btn-edit"
                                                href="{{ route('surat_masuk.edit', $surat->id) }}"><i
                                                    class="bx bx-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete"
                                                data-url="{{ route('surat_masuk.destroy', $surat->id) }}">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
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
