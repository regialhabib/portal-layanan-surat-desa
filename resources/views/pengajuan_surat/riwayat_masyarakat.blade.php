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

                <table class="table table-bordered table-hover" id="datatable">

                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
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
                                    {{ $item->jenisSurat->nama_surat }}
                                </td>

                                <td>

                                    @if ($item->status == 'diajukan')
                                        <span class="badge bg-warning">
                                            Diajukan
                                        </span>
                                    @elseif($item->status == 'diproses')
                                        <span class="badge bg-info">
                                            Diproses
                                        </span>
                                    @elseif($item->status == 'selesai')
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
                                        data-url="{{ route('masyarakat.show', $item->id) }}" data-bs-toggle="modal"
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
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Pengajuan
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="35%">Jenis Surat</th>
                            <td id="jenis_surat"></td>
                        </tr>

                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td id="tanggal_pengajuan"></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td id="status"></td>
                        </tr>

                        <tr>
                            <th>Keperluan</th>
                            <td id="keperluan"></td>
                        </tr>

                    </table>

                    <div id="status-info"></div>

                    <div id="download-container" class="mt-3 d-none">

                        <a href="#" id="download-surat" target="_blank" class="btn btn-success">

                            <i class="bx bx-download"></i>
                            Download Surat

                        </a>

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

                document.getElementById('jenis_surat').innerText =
                    data.jenis_surat.nama_surat;

                document.getElementById('tanggal_pengajuan').innerText =
                    data.tanggal_pengajuan;

                document.getElementById('status').innerText =
                    data.status;

                document.getElementById('keperluan').innerText =
                    data.keperluan;


                let infoHtml = '';

                document
                    .getElementById('download-container')
                    .classList.add('d-none');


                if (data.status === 'diajukan') {

                    infoHtml = `
                <div class="alert alert-warning mb-0">
                    Pengajuan Anda sedang menunggu verifikasi petugas desa.
                </div>
            `;
                } else if (data.status === 'diproses') {

                    infoHtml = `
                <div class="alert alert-info mb-0">
                    Pengajuan Anda sedang diproses oleh petugas desa.
                </div>
            `;
                } else if (data.status === 'ditolak') {

                    infoHtml = `
                <div class="alert alert-danger mb-0">
                    <strong>Alasan Penolakan:</strong><br>
                    ${data.catatan_admin ?? '-'}
                </div>
            `;
                } else if (data.status === 'selesai') {

                    infoHtml = `
                <div class="alert alert-success mb-0">
                    Surat telah selesai diproses dan siap diunduh.
                </div>
            `;

                    document
                        .getElementById('download-container')
                        .classList.remove('d-none');

                    document
                        .getElementById('download-surat')
                        .href = `/storage/${data.file_surat}`;
                }

                document.getElementById('status-info').innerHTML =
                    infoHtml;

            } catch (error) {

                console.error(error);

                alert('Gagal mengambil data.');

            }

        });
    </script>
@endpush
