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

    <style>
        /* Modal */
        #detailModal .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(15, 23, 42, .12);
        }

        #detailModal .modal-header {
            background: #fff;
            border-bottom: 1px solid #eef2f7;
            padding: 1rem 1.5rem;
        }

        #detailModal .modal-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
        }

        #detailModal .modal-body {
            background: #f8fafc;
            padding: 1.5rem;
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Card */
        #detailModal .card {
            border: none !important;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
        }

        #detailModal .card-header {
            background: #fff;
            border-bottom: 1px solid #eef2f7;
            font-weight: 600;
            color: #334155;
            padding: .9rem 1.2rem;
        }

        #detailModal .card-body {
            background: #fff;
            padding: 1.2rem;
        }

        /* Table Detail */
        #detailModal .table-sm {
            margin-bottom: 0;
        }

        #detailModal .table-sm th {
            color: #64748b;
            font-weight: 600;
            border-color: #f1f5f9;
        }

        #detailModal .table-sm td {
            color: #0f172a;
            border-color: #f1f5f9;
        }

        #detailModal .table-sm tr:last-child td,
        #detailModal .table-sm tr:last-child th {
            border-bottom: none;
        }

        /* Table Lampiran */
        #detailModal .table-bordered {
            border-color: #e2e8f0;
        }

        #detailModal .table-bordered thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
        }

        #detailModal .table-bordered td,
        #detailModal .table-bordered th {
            border-color: #e2e8f0;
            vertical-align: middle;
        }

        /* Upload Area */
        #form-selesai .form-label {
            font-weight: 600;
            color: #475569;
            margin-bottom: .5rem;
        }

        #form-selesai .form-control {
            border-radius: 10px;
            border: 1px solid #dbe3ec;
            padding: .75rem;
            transition: .2s;
        }

        #form-selesai .form-control:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 .2rem rgba(34, 197, 94, .12);
        }

        /* Button Upload */
        #form-selesai .btn-success {
            border-radius: 10px;
            padding: .65rem 1.2rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(34, 197, 94, .18);
        }

        #form-selesai .btn-success:hover {
            transform: translateY(-1px);
        }

        /* Scrollbar */
        #detailModal .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        #detailModal .modal-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }

        #form-selesai {
            background: #f8fafc;
            border: 2px dashed #dbe3ec;
            border-radius: 12px;
            padding: 1.25rem;
        }
    </style>
@endpush
@section('main-content')
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
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">
                Surat Diproses
            </h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="datatable">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Nama Pemohon</th>
                            <th>NIK</th>
                            <th>Jenis Surat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($pengajuanSurat as $item)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $item->tanggal_pengajuan }}
                                </td>

                                <td>
                                    {{ $item->user->penduduk->nama }}
                                </td>

                                <td>
                                    {{ $item->user->penduduk->nik }}
                                </td>

                                <td>
                                    {{ $item->jenisSurat->nama_surat }}
                                </td>

                                <td>

                                    <button class="btn btn-info btn-sm btn-detail" data-id="{{ $item->id }}"
                                        data-url="{{ route('pengajuan-surat.show', $item->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#detailModal">

                                        <i class="bx bx-show"></i>
                                        Detail

                                    </button>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>



    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Surat Diproses
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="card border">
                                <div class="card-header">
                                    Data Pemohon
                                </div>

                                <div class="card-body">

                                    <table class="table table-sm">

                                        <tr>
                                            <th width="35%">Nama</th>
                                            <td id="nama"></td>
                                        </tr>

                                        <tr>
                                            <th>NIK</th>
                                            <td id="nik"></td>
                                        </tr>

                                        <tr>
                                            <th>No KK</th>
                                            <td id="no_kk"></td>
                                        </tr>

                                        <tr>
                                            <th>Alamat</th>
                                            <td id="alamat"></td>
                                        </tr>

                                    </table>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="card border">
                                <div class="card-header">
                                    Data Pengajuan
                                </div>

                                <div class="card-body">

                                    <table class="table table-sm">

                                        <tr>
                                            <th width="35%">Jenis Surat</th>
                                            <td id="jenis_surat"></td>
                                        </tr>

                                        <tr>
                                            <th>Tanggal</th>
                                            <td id="tanggal_pengajuan"></td>
                                        </tr>

                                        <tr>
                                            <th>Keperluan</th>
                                            <td id="keperluan"></td>
                                        </tr>

                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- LAMPIRAN --}}
                    <div class="card border mt-3">
                        <div class="card-header">
                            Lampiran Persyaratan
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Dokumen</th>
                                        <th width="20%">File</th>
                                    </tr>
                                </thead>

                                <tbody id="lampiran-container">

                                </tbody>
                            </table>

                        </div>
                    </div>


                    {{-- UPLOAD SURAT --}}
                    <div class="card border mt-3">

                        <div class="card-header">
                            Upload Hasil Surat
                        </div>

                        <div class="card-body">

                            <form id="form-selesai" method="POST" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">
                                        File Surat (PDF)
                                    </label>

                                    <input type="file" name="file_surat" class="form-control" accept=".pdf" required>
                                </div>

                                <button type="submit" class="btn btn-success">

                                    <i class="bx bx-upload"></i>
                                    Upload & Selesaikan

                                </button>

                            </form>

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
        document.addEventListener('click', async function(e) {

            const btn = e.target.closest('.btn-detail');

            if (!btn) return;

            try {

                const response = await fetch(btn.dataset.url);

                const data = await response.json();

                document.getElementById('nama').innerText =
                    data.user.penduduk.nama;

                document.getElementById('nik').innerText =
                    data.user.penduduk.nik;

                document.getElementById('no_kk').innerText =
                    data.user.penduduk.no_kk;

                document.getElementById('alamat').innerText =
                    data.user.penduduk.alamat;

                document.getElementById('jenis_surat').innerText =
                    data.jenis_surat.nama_surat;

                document.getElementById('tanggal_pengajuan').innerText =
                    data.tanggal_pengajuan;

                document.getElementById('keperluan').innerText =
                    data.keperluan;


                let lampiranHtml = '';

                data.persyaratan.forEach((item, index) => {

                    lampiranHtml += `
                <tr>
                    <td>${index + 1}</td>

                    <td>${item.jenis_dokumen}</td>

                    <td>

                        <a
                            href="/storage/${item.file_path}"
                            target="_blank"
                            class="btn btn-info btn-sm">

                            <i class="bx bx-show"></i>
                            Lihat

                        </a>

                    </td>
                </tr>
            `;

                });

                document.getElementById('lampiran-container').innerHTML =
                    lampiranHtml;


                document.getElementById('form-selesai').action =
                    `/pengajuan-surat/${data.id}/selesaikan`;

            } catch (error) {

                console.error(error);

            }

        });
    </script>
@endpush
