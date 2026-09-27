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



                    <div class="d-flex justify-content-between align-items-end mb-4 gap-3 flex-wrap">

                        <h4 class="card-title mb-3">Data Penduduk</h4>
                        <!-- TOMBOL TAMBAH -->
                        <a href="{{ route('penduduk.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Data
                        </a>

                    </div>
                    <table id="datatable" class="table table-bordered table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Agama</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        @php
                            $no = 1;
                        @endphp

                        <tbody>
                            @foreach ($penduduks as $penduduk)
                                <tr>
                                    <td>
                                        {{ $no++ }}

                                    </td>

                                    <td>{{ $penduduk->nama }}</td>
                                    <td>{{ $penduduk->alamat }}</td>
                                    <td>{{ $penduduk->agama }}</td>
                                    <td>{{ $penduduk->jenis_kelamin }}</td>
                                    <td>
                                        <ul class="list-unstyled hstack gap-1 mb-0">
                                            <button type="button" class="btn btn-info btn-sm btn-detail"
                                                data-bs-toggle="modal" data-bs-target="#detailPendudukModal"
                                                data-nik="{{ $penduduk->nik }}" data-no-kk="{{ $penduduk->no_kk }}"
                                                data-nama="{{ $penduduk->nama }}"
                                                data-tempat-lahir="{{ $penduduk->tempat_lahir }}"
                                                data-tanggal-lahir="{{ $penduduk->tanggal_lahir }}"
                                                data-jenis-kelamin="{{ $penduduk->jenis_kelamin }}"
                                                data-agama="{{ $penduduk->agama }}" data-pekerjaan="{{ $penduduk->pekerjaan }}"
                                                data-status-perkawinan="{{ $penduduk->status_perkawinan }}"
                                                data-alamat="{{ $penduduk->alamat }}" data-rt="{{ $penduduk->rt }}"
                                                data-rw="{{ $penduduk->rw }}" data-dusun="{{ $penduduk->dusun }}">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <a class="btn btn-sm btn-primary btn-edit"
                                                href="{{ route('penduduk.edit', $penduduk->id) }}"><i
                                                    class="bx bx-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete"
                                                data-url="{{ route('penduduk.destroy', $penduduk->id) }}">
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
    <div class="modal fade" id="detailPendudukModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Data Penduduk
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">NIK</label>
                            <div id="detail_nik"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">No KK</label>
                            <div id="detail_no_kk"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Nama</label>
                            <div id="detail_nama"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tempat Lahir</label>
                            <div id="detail_tempat_lahir"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tanggal Lahir</label>
                            <div id="detail_tanggal_lahir"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Jenis Kelamin</label>
                            <div id="detail_jenis_kelamin"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Agama</label>
                            <div id="detail_agama"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Pekerjaan</label>
                            <div id="detail_pekerjaan"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Status Perkawinan</label>
                            <div id="detail_status_perkawinan"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Dusun</label>
                            <div id="detail_dusun"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">RT / RW</label>
                            <div id="detail_rt_rw"></div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="fw-bold">Alamat</label>
                            <div id="detail_alamat"></div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
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
    <script>
        document.addEventListener('click', function(e) {

            const button = e.target.closest('.btn-detail');

            if (!button) return;

            document.getElementById('detail_nik').textContent =
                button.dataset.nik;

            document.getElementById('detail_no_kk').textContent =
                button.dataset.noKk;

            document.getElementById('detail_nama').textContent =
                button.dataset.nama;

            document.getElementById('detail_tempat_lahir').textContent =
                button.dataset.tempatLahir;

            document.getElementById('detail_tanggal_lahir').textContent =
                button.dataset.tanggalLahir;

            document.getElementById('detail_jenis_kelamin').textContent =
                button.dataset.jenisKelamin;

            document.getElementById('detail_agama').textContent =
                button.dataset.agama;

            document.getElementById('detail_pekerjaan').textContent =
                button.dataset.pekerjaan;

            document.getElementById('detail_status_perkawinan').textContent =
                button.dataset.statusPerkawinan;

            document.getElementById('detail_dusun').textContent =
                button.dataset.dusun;

            document.getElementById('detail_rt_rw').textContent =
                button.dataset.rt + ' / ' + button.dataset.rw;

            document.getElementById('detail_alamat').textContent =
                button.dataset.alamat;

        });
    </script>
@endpush
