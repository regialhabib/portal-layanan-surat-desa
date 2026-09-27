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
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        #detailModal .modal-header {
            border-bottom: 1px solid #eef2f7;
            padding: 1rem 1.5rem;
            background: #fafbfc;
        }

        #detailModal .modal-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #1f2937;
        }

        #detailModal .modal-body {
            padding: 1.5rem;
            background: #f8fafc;
        }

        /* Card */
        #detailModal .card {
            border: none !important;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
        }

        #detailModal .card-header {
            background: #ffffff;
            border-bottom: 1px solid #eef2f7;
            font-weight: 600;
            color: #374151;
            padding: 0.9rem 1.2rem;
        }

        #detailModal .card-body {
            background: #fff;
            padding: 1.2rem;
        }

        /* Table data */
        #detailModal table {
            margin-bottom: 0;
        }

        #detailModal .table-sm tr:last-child td,
        #detailModal .table-sm tr:last-child th {
            border-bottom: none;
        }

        #detailModal .table-sm th {
            color: #6b7280;
            font-weight: 600;
            border-color: #f1f5f9;
        }

        #detailModal .table-sm td {
            color: #111827;
            border-color: #f1f5f9;
        }

        /* Table lampiran */
        #detailModal .table-bordered {
            border-color: #eef2f7;
        }

        #detailModal .table-bordered thead th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        #detailModal .table-bordered td,
        #detailModal .table-bordered th {
            border-color: #eef2f7;
            vertical-align: middle;
        }

        /* Button download */
        #download-surat {
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }

        /* Alert penolakan */
        #surat-ditolak-card .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem;
            line-height: 1.7;
        }

        /* Scroll jika konten panjang */
        #detailModal .modal-body {
            max-height: 75vh;
            overflow-y: auto;
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
                Riwayat Pengajuan Surat
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
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($pengajuanSurat as $item)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}
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

                                    @if ($item->status == 'selesai')
                                        <span class="badge bg-success">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Ditolak
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <button class="btn btn-info btn-sm btn-detail"
                                        data-url="{{ route('pengajuan-surat.show', $item->id) }}" data-bs-toggle="modal"
                                        data-bs-target="#detailModal">

                                        <i class="bx bx-show"></i>

                                    </button>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Riwayat Pengajuan
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
                                            <th>Status</th>
                                            <td id="status"></td>
                                        </tr>

                                        <tr>
                                            <th>Tanggal Pengajuan</th>
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


                    {{-- Lampiran --}}
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


                    {{-- Surat Jadi --}}
                    <div class="card border mt-3 d-none" id="surat-selesai-card">

                        <div class="card-header">
                            Surat Selesai
                        </div>

                        <div class="card-body">

                            <a href="#" id="download-surat" target="_blank" class="btn btn-success">

                                <i class="bx bx-download"></i>
                                Download Surat

                            </a>

                        </div>

                    </div>


                    {{-- Penolakan --}}
                    <div class="card border mt-3 d-none" id="surat-ditolak-card">

                        <div class="card-header">
                            Alasan Penolakan
                        </div>

                        <div class="card-body">

                            <div class="alert alert-danger mb-0" id="catatan-admin">
                            </div>

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

                document.getElementById('status').innerText =
                    data.status;



                document.getElementById('tanggal_pengajuan').innerText =
                    data.tanggal_pengajuan;

                document.getElementById('keperluan').innerText =
                    data.keperluan;


                let html = '';

                if (data.persyaratan.length > 0) {

                    data.persyaratan.forEach((item, index) => {

                        html += `
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

                } else {

                    html = `
                <tr>
                    <td colspan="3" class="text-center">
                        Tidak ada lampiran
                    </td>
                </tr>
            `;
                }

                document.getElementById('lampiran-container')
                    .innerHTML = html;


                document.getElementById('surat-selesai-card')
                    .classList.add('d-none');

                document.getElementById('surat-ditolak-card')
                    .classList.add('d-none');


                if (data.status === 'selesai') {

                    document.getElementById('surat-selesai-card')
                        .classList.remove('d-none');

                    document.getElementById('download-surat')
                        .href = `/storage/${data.file_surat}`;

                }


                if (data.status === 'ditolak') {

                    document.getElementById('surat-ditolak-card')
                        .classList.remove('d-none');

                    document.getElementById('catatan-admin')
                        .innerText = data.catatan_admin ?? '-';

                }

            } catch (error) {

                console.error(error);

            }

        });
    </script>
@endpush
