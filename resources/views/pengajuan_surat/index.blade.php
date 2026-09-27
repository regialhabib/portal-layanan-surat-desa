@extends('layouts.main')
@push('style')
    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('main-content')
    <div class="row">
        <div class="col-12">
            <h4 class="mb-sm-4 fw-bold text-dark">Manajemen Pengajuan Surat</h4>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-all me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- TABS & GRID -->
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-tabs-custom border-bottom-0 ps-3 pt-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'baru' ? 'active' : '' }} pt-3 pb-3 px-4 d-flex align-items-center justify-content-center" href="{{ route('pengajuan-surat.index', ['tab' => 'baru']) }}">
                                <span class="d-none d-sm-inline-block fw-semibold font-size-14 {{ $tab == 'baru' ? 'text-primary' : 'text-muted' }} me-1">Menunggu Verifikasi</span>
                                <span class="badge rounded-pill bg-danger">{{ $countBaru }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == 'riwayat' ? 'active' : '' }} pt-3 pb-3 px-4 d-flex align-items-center justify-content-center" href="{{ route('pengajuan-surat.index', ['tab' => 'riwayat']) }}">
                                <span class="d-none d-sm-inline-block fw-semibold font-size-14 {{ $tab == 'riwayat' ? 'text-primary' : 'text-muted' }} me-1">Riwayat Pengajuan</span>
                                <span class="badge rounded-pill bg-secondary">{{ $countSelesai + $countDitolak }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            @if($tab == 'riwayat')
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 px-1">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <span class="text-muted me-3 font-size-13">Filter Status:</span>
                    <a href="{{ route('pengajuan-surat.index', ['tab' => 'riwayat', 'filter' => 'semua']) }}" class="btn btn-sm rounded-pill px-3 me-2 {{ $filter == 'semua' ? 'btn-secondary' : 'btn-outline-secondary' }}">Semua</a>
                    <a href="{{ route('pengajuan-surat.index', ['tab' => 'riwayat', 'filter' => 'selesai']) }}" class="btn btn-sm rounded-pill px-3 me-2 {{ $filter == 'selesai' ? 'btn-success' : 'btn-outline-success' }}">Selesai</a>
                    <a href="{{ route('pengajuan-surat.index', ['tab' => 'riwayat', 'filter' => 'ditolak']) }}" class="btn btn-sm rounded-pill px-3 {{ $filter == 'ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">Ditolak</a>
                </div>
                <div class="text-muted font-size-13">
                    Arsip permohonan yang telah selesai diterbitkan maupun yang ditolak.
                </div>
            </div>
            @endif

            <div class="row">
                @forelse ($pengajuanSurat as $item)
                    <div class="col-md-4 col-xl-3 mb-4">
                        <div class="card h-100 shadow-sm border-0 rounded-3">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge badge-soft-primary font-size-11 px-2 py-1 text-truncate" style="max-width: 60%;">
                                        {{ $item->jenisSurat->nama_surat }}
                                    </span>
                                    <small class="text-muted font-size-11">
                                        <i class="bx bx-calendar align-middle me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}
                                    </small>
                                </div>
                                
                                <h5 class="card-title text-truncate mb-1 font-size-15 text-dark fw-bold">{{ $item->user->penduduk->nama }}</h5>
                                <p class="text-muted font-size-12 mb-2">
                                    <i class="bx bx-id-card align-middle me-1"></i> {{ $item->user->penduduk->nik }}
                                </p>
                                <p class="text-muted font-size-12 mb-1 text-truncate">
                                    {{ $item->keperluan }}
                                </p>
                                
                                <div class="mt-auto">
                                    @if($item->status == 'selesai')
                                        <div class="badge badge-soft-success font-size-12 mb-2 w-100 text-center py-2 fw-semibold"><i class="bx bx-check-circle me-1"></i> Selesai Diterbitkan</div>
                                    @elseif($item->status == 'ditolak')
                                        <div class="badge badge-soft-danger font-size-12 mb-2 w-100 text-center py-2 fw-semibold"><i class="bx bx-x-circle me-1"></i> Pengajuan Ditolak</div>
                                    @else
                                        <div class="badge badge-soft-warning font-size-12 mb-2 w-100 text-center py-2 fw-semibold text-warning" style="color: #f1b44c !important;"><i class="bx bx-hourglass me-1"></i> Menunggu Verifikasi</div>
                                    @endif
                                    
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100 waves-effect waves-light btn-detail rounded-3 fw-medium"
                                        data-id="{{ $item->id }}"
                                        data-url="{{ route('pengajuan-surat.show', $item->id) }}"
                                        data-status="{{ $item->status }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal">
                                        <i class="bx bx-show align-middle me-1"></i> Cek Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted mb-4 mt-5">
                            <i class="bx bx-folder-open display-4 text-primary opacity-50 mb-3"></i>
                            <h5 class="font-size-18">Tidak ada data</h5>
                            <p class="text-muted">Belum ada pengajuan surat di kategori ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-soft-primary border-bottom-0 pb-3">
                    <h5 class="modal-title text-primary" id="detailModalLabel"><i class="bx bx-file align-middle me-2"></i>Detail Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light pt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-none border mb-4">
                                <div class="card-header bg-transparent border-bottom">
                                    <h6 class="m-0 font-weight-bold text-dark"><i class="bx bx-user align-middle me-1"></i> Data Pemohon</h6>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-nowrap table-sm mb-0">
                                        <tbody>
                                            <tr><th scope="row" class="ps-3" style="width: 35%;">Nama</th><td id="detail_nama" class="pe-3"></td></tr>
                                            <tr><th scope="row" class="ps-3">NIK</th><td id="detail_nik" class="pe-3"></td></tr>
                                            <tr><th scope="row" class="ps-3">No KK</th><td id="detail_no_kk" class="pe-3"></td></tr>
                                            <tr><th scope="row" class="ps-3 border-bottom-0">Alamat</th><td id="detail_alamat" class="text-wrap pe-3 border-bottom-0"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-none border mb-4">
                                <div class="card-header bg-transparent border-bottom">
                                    <h6 class="m-0 font-weight-bold text-dark"><i class="bx bx-envelope align-middle me-1"></i> Data Pengajuan</h6>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-nowrap table-sm mb-0">
                                        <tbody>
                                            <tr><th scope="row" class="ps-3" style="width: 35%;">Jenis Surat</th><td id="detail_jenis_surat" class="pe-3"></td></tr>
                                            <tr><th scope="row" class="ps-3">Tanggal Pengajuan</th><td id="detail_tanggal_pengajuan" class="pe-3"></td></tr>
                                            <tr><th scope="row" class="ps-3 border-bottom-0">Keperluan</th><td id="detail_keperluan" class="text-wrap pe-3 border-bottom-0"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="rejection-reason-container" class="alert alert-danger shadow-sm d-none mb-4">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-message-alt-error font-size-18 me-2"></i> 
                            <strong class="font-size-14">Alasan Penolakan:</strong>
                        </div>
                        <p id="detail_catatan_admin" class="mb-0 ms-4"></p>
                    </div>

                    <div class="card shadow-none border mb-0">
                        <div class="card-header bg-transparent border-bottom">
                            <h6 class="m-0 font-weight-bold text-dark"><i class="bx bx-paperclip align-middle me-1"></i> Lampiran Persyaratan</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 5%" class="ps-3">No</th>
                                            <th scope="col">Jenis Dokumen</th>
                                            <th scope="col" style="width: 20%" class="pe-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lampiran-container"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div id="file-surat-container" class="card shadow-none border border-success mt-4 d-none">
                        <div class="card-header bg-soft-success border-success text-success">
                            <h6 class="m-0 font-weight-bold text-success"><i class="bx bx-check-shield align-middle me-1"></i> Dokumen Surat Resmi</h6>
                        </div>
                        <div class="card-body text-center py-4">
                            <a id="btn-download-surat" href="#" target="_blank" class="btn btn-success waves-effect waves-light px-4 rounded-pill shadow-sm">
                                <i class="bx bx-download align-middle me-1"></i> Unduh Dokumen Surat
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 bg-white d-none pt-3 pb-4 px-4" id="modal-footer-baru">
                    <form id="form-selesai" method="POST" enctype="multipart/form-data" class="w-100">
                        @csrf @method('PUT')
                        <div class="row align-items-center">
                            <div class="col-md-7 text-start">
                                <label class="fw-medium text-dark mb-2">Upload Surat yang Diterbitkan (PDF):</label>
                                <input type="file" name="file_surat" class="form-control form-control-sm" accept="application/pdf" required>
                            </div>
                            <div class="col-md-5 text-end mt-3 mt-md-0">
                                <button type="button" class="btn btn-outline-danger waves-effect waves-light me-2 mt-4" id="btn-tolak" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#tolakModal">
                                    <i class="bx bx-x align-middle me-1"></i> Tolak
                                </button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mt-4 shadow-sm">
                                    <i class="bx bx-upload align-middle me-1"></i> Selesaikan Pengajuan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TOLAK --}}
    <div class="modal fade" id="tolakModal" tabindex="-1" aria-labelledby="tolakModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="form-tolak" method="POST" class="w-100">
                @csrf @method('PUT')
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-soft-danger border-bottom-0">
                        <h5 class="modal-title text-danger" id="tolakModalLabel"><i class="bx bx-error-circle align-middle me-2"></i>Alasan Penolakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-medium">Catatan / Alasan</label>
                            <textarea name="catatan_admin" class="form-control" rows="4" required placeholder="Masukkan alasan kenapa surat ditolak..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-white">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light shadow-sm">Simpan Penolakan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.btn-detail');
            if (!btn) return;

            const url = btn.dataset.url;
            const status = btn.dataset.status;
            const id = btn.dataset.id;

            try {
                const response = await fetch(url);
                const data = await response.json();

                document.getElementById('detail_nama').innerText = data.user.penduduk.nama;
                document.getElementById('detail_nik').innerText = data.user.penduduk.nik;
                document.getElementById('detail_no_kk').innerText = data.user.penduduk.no_kk;
                document.getElementById('detail_alamat').innerText = data.user.penduduk.alamat;
                document.getElementById('detail_jenis_surat').innerText = data.jenis_surat.nama_surat;
                document.getElementById('detail_tanggal_pengajuan').innerText = new Date(data.tanggal_pengajuan).toLocaleDateString('id-ID');
                document.getElementById('detail_keperluan').innerText = data.keperluan;

                let lampiranHtml = '';
                if(data.persyaratan && data.persyaratan.length > 0) {
                    data.persyaratan.forEach((item, index) => {
                        let fileUrl = `{{ Storage::url('') }}${item.file_path}`;
                        lampiranHtml += `
                            <tr>
                                <td class="ps-3">${index + 1}</td>
                                <td>${item.jenis_dokumen}</td>
                                <td class="pe-3 text-center">
                                    <div class="btn-group" role="group">
                                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-info waves-effect waves-light" title="Lihat"><i class="bx bx-show"></i></a>
                                        <a href="${fileUrl}" download class="btn btn-sm btn-outline-primary waves-effect waves-light" title="Unduh"><i class="bx bx-download"></i></a>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    lampiranHtml = '<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada lampiran</td></tr>';
                }
                document.getElementById('lampiran-container').innerHTML = lampiranHtml;

                const footerBaru = document.getElementById('modal-footer-baru');
                const fileContainer = document.getElementById('file-surat-container');
                const rejectionContainer = document.getElementById('rejection-reason-container');
                
                footerBaru.classList.add('d-none');
                fileContainer.classList.add('d-none');
                rejectionContainer.classList.add('d-none');

                if (status === 'diajukan') {
                    footerBaru.classList.remove('d-none');
                    document.getElementById('form-selesai').action = `/pengajuan-surat/${id}/selesaikan`;
                    document.getElementById('form-tolak').action = `/pengajuan-surat/${id}/tolak`;
                } else if (status === 'selesai' && data.file_surat) {
                    fileContainer.classList.remove('d-none');
                    document.getElementById('btn-download-surat').href = `{{ Storage::url('') }}${data.file_surat}`;
                } else if (status === 'ditolak' && data.catatan_admin) {
                    rejectionContainer.classList.remove('d-none');
                    document.getElementById('detail_catatan_admin').innerText = data.catatan_admin;
                }

            } catch (error) {
                console.error("Failed to load details", error);
                alert("Gagal memuat detail surat.");
            }
        });
    </script>
@endpush
