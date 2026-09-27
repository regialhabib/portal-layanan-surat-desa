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
            <div class="modal-content border-0 shadow rounded-4">
                
                <!-- HEADER -->
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded-3 font-size-24">
                                <i class="bx bx-file"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="modal-title fw-bold text-dark mb-1" id="detailModalLabel">Detail Pengajuan Surat - <span id="modal_title_nama"></span></h4>
                            <p class="text-muted mb-0 font-size-13" id="modal_title_waktu"></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                        <span id="modal_title_status" class="badge bg-soft-warning text-warning font-size-12 px-3 py-2 me-4 rounded-pill fw-semibold"><i class="bx bx-hourglass me-1"></i> Menunggu Verifikasi</span>
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <!-- BODY -->
                <div class="modal-body bg-light px-4 py-4 mt-3" style="border-radius: 1rem 1rem 0 0;">
                    <div class="row">
                        <!-- DATA PEMOHON -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0 h-100 rounded-3">
                                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                                    <h6 class="m-0 font-weight-bold text-dark font-size-15"><i class="bx bx-user text-primary me-2 font-size-18 align-middle"></i> Data Pemohon</h6>
                                </div>
                                <div class="card-body px-4 pb-4 pt-2">
                                    <table class="table table-borderless table-sm mb-0 font-size-13">
                                        <tbody>
                                            <tr><td class="text-muted" style="width: 40%; padding: 8px 0;">Nama Lengkap</td><td id="detail_nama" class="fw-semibold text-dark" style="padding: 8px 0;"></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0;">Nomor Induk (NIK)</td><td id="detail_nik" class="fw-semibold text-dark" style="padding: 8px 0;"></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0;">Nomor Kartu Keluarga</td><td id="detail_no_kk" class="fw-semibold text-dark" style="padding: 8px 0;"></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0; vertical-align: top;">Alamat Domisili</td><td id="detail_alamat" class="fw-semibold text-dark text-wrap" style="padding: 8px 0;"></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0;">Pekerjaan</td><td id="detail_pekerjaan" class="fw-semibold text-dark" style="padding: 8px 0;">-</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- DATA SURAT PERMOHONAN -->
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0 h-100 rounded-3">
                                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                                    <h6 class="m-0 font-weight-bold text-dark font-size-15"><i class="bx bx-list-ul text-primary me-2 font-size-18 align-middle"></i> Data Surat Permohonan</h6>
                                </div>
                                <div class="card-body px-4 pb-4 pt-2">
                                    <table class="table table-borderless table-sm mb-0 font-size-13">
                                        <tbody>
                                            <tr><td class="text-muted" style="width: 30%; padding: 8px 0;">Jenis Surat</td><td style="padding: 8px 0;"><span id="detail_jenis_surat" class="badge bg-soft-primary text-primary px-2 py-1 rounded-pill"></span></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0; vertical-align: top;">Keperluan</td><td id="detail_keperluan" class="fw-semibold text-dark text-wrap" style="padding: 8px 0;"></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0;">Tanggal Masuk</td><td id="detail_tanggal_masuk" class="fw-semibold text-dark" style="padding: 8px 0;"></td></tr>
                                            <tr><td class="text-muted" style="padding: 8px 0;">Status Saat Ini</td><td style="padding: 8px 0;"><span id="detail_status_saat_ini" class="badge bg-soft-warning text-warning px-2 py-1 rounded-pill"><i class="bx bx-hourglass me-1"></i> Menunggu Verifikasi</span></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="rejection-reason-container" class="alert alert-danger shadow-sm border-0 d-none mb-3 rounded-3">
                        <div class="d-flex align-items-center mb-1">
                            <i class="bx bx-message-alt-error font-size-18 me-2"></i> 
                            <strong class="font-size-14">Alasan Penolakan:</strong>
                        </div>
                        <p id="detail_catatan_admin" class="mb-0 ms-4 text-dark"></p>
                    </div>

                    <!-- ROW 2: LAMPIRAN & ACTIONS -->
                    <div class="row">
                        <!-- LAMPIRAN -->
                        <div class="col-lg-7 mb-3">
                            <div class="card shadow-sm border-0 mb-0 h-100 rounded-3">
                                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-dark font-size-15"><i class="bx bx-paperclip text-primary me-2 font-size-18 align-middle"></i> Lampiran Persyaratan Warga</h6>
                                    <span class="badge bg-light text-muted border px-2 py-1" id="jumlah_lampiran"></span>
                                </div>
                                <div class="card-body px-4 pb-4 pt-0">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover align-middle mb-0 font-size-13">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th scope="col" style="width: 5%; border-radius: 8px 0 0 8px;" class="text-dark">No</th>
                                                    <th scope="col" class="text-dark">Jenis Dokumen</th>
                                                    <th scope="col" style="width: 15%" class="text-center text-dark">Format File</th>
                                                    <th scope="col" style="width: 20%; border-radius: 0 8px 8px 0;" class="text-end text-dark pe-4">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lampiran-container"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TINDAKAN / UPLOAD -->
                        <div class="col-lg-5 mb-3">
                            <div class="card shadow-sm border-0 mb-0 h-100 rounded-3">
                                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                                    <h6 class="m-0 font-weight-bold text-dark font-size-15"><i class="bx bx-cog text-primary me-2 font-size-18 align-middle"></i> Tindakan / Aksi</h6>
                                </div>
                                <div class="card-body px-4 pb-4 pt-2 d-flex flex-column justify-content-center">
                                    
                                    <!-- FORM UPLOAD -->
                                    <div id="modal-footer-baru" class="d-none w-100">
                                        <form id="form-selesai" method="POST" enctype="multipart/form-data" class="w-100">
                                            @csrf @method('PUT')
                                            
                                            <div class="mb-4">
                                                <label class="fw-bold text-dark mb-2 font-size-14"><i class="bx bx-upload me-1 text-primary"></i> Upload Surat (PDF)*</label>
                                                <input type="file" name="file_surat" class="form-control form-control-sm border border-light bg-light" accept="application/pdf" required>
                                                <small class="text-muted mt-2 d-block font-size-11">File akan otomatis dikirimkan ke pemohon.</small>
                                            </div>
                                            
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-success waves-effect waves-light shadow-sm fw-medium" style="background-color: #2ab57d; border-color: #2ab57d;">
                                                    <i class="bx bx-check-double align-middle me-1"></i> Selesaikan & Terbitkan
                                                </button>
                                                <button type="button" class="btn btn-outline-danger waves-effect waves-light fw-medium" id="btn-tolak" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#tolakModal">
                                                    <i class="bx bx-x align-middle me-1"></i> Tolak Pengajuan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                    <!-- FILE SURAT CONTAINER -->
                                    <div id="file-surat-container" class="text-center py-3 d-none w-100">
                                        <div class="mb-3">
                                            <i class="bx bx-check-shield text-success display-4"></i>
                                        </div>
                                        <h6 class="font-weight-bold text-success mb-4">Dokumen Surat Resmi Tersedia</h6>
                                        <a id="btn-download-surat" href="#" target="_blank" class="btn btn-success waves-effect waves-light px-4 rounded-pill shadow-sm w-100">
                                            <i class="bx bx-download align-middle me-1"></i> Unduh Dokumen
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

                const tgl = new Date(data.tanggal_pengajuan);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                const formattedDate = tgl.toLocaleDateString('id-ID', options) + ' - ' + tgl.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}).replace('.', ':') + ' WIB';

                document.getElementById('modal_title_nama').innerText = data.user.penduduk.nama;
                document.getElementById('modal_title_waktu').innerText = "Diajukan: " + formattedDate;

                document.getElementById('detail_nama').innerText = data.user.penduduk.nama;
                document.getElementById('detail_nik').innerText = data.user.penduduk.nik;
                document.getElementById('detail_no_kk').innerText = data.user.penduduk.no_kk;
                document.getElementById('detail_alamat').innerText = data.user.penduduk.alamat;
                document.getElementById('detail_pekerjaan').innerText = data.user.penduduk.pekerjaan || '-';
                
                document.getElementById('detail_jenis_surat').innerText = data.jenis_surat.nama_surat;
                document.getElementById('detail_tanggal_masuk').innerText = formattedDate;
                document.getElementById('detail_keperluan').innerText = data.keperluan;
                document.getElementById('jumlah_lampiran').innerText = data.persyaratan.length + " Dokumen Terlampir";

                // Update Header Status Badge
                const headerStatus = document.getElementById('modal_title_status');
                const cardStatus = document.getElementById('detail_status_saat_ini');
                if (status === 'diajukan') {
                    headerStatus.className = 'badge bg-soft-warning text-warning font-size-12 px-3 py-2 me-3 rounded-pill fw-semibold';
                    headerStatus.innerHTML = '<i class="bx bx-hourglass me-1"></i> Menunggu Verifikasi';
                    cardStatus.className = 'badge bg-soft-warning text-warning px-2 py-1 rounded-pill';
                    cardStatus.innerHTML = '<i class="bx bx-hourglass me-1"></i> Menunggu Verifikasi';
                } else if (status === 'selesai') {
                    headerStatus.className = 'badge bg-soft-success text-success font-size-12 px-3 py-2 me-3 rounded-pill fw-semibold';
                    headerStatus.innerHTML = '<i class="bx bx-check-circle me-1"></i> Selesai Diterbitkan';
                    cardStatus.className = 'badge bg-soft-success text-success px-2 py-1 rounded-pill';
                    cardStatus.innerHTML = '<i class="bx bx-check-circle me-1"></i> Selesai Diterbitkan';
                } else if (status === 'ditolak') {
                    headerStatus.className = 'badge bg-soft-danger text-danger font-size-12 px-3 py-2 me-3 rounded-pill fw-semibold';
                    headerStatus.innerHTML = '<i class="bx bx-x-circle me-1"></i> Pengajuan Ditolak';
                    cardStatus.className = 'badge bg-soft-danger text-danger px-2 py-1 rounded-pill';
                    cardStatus.innerHTML = '<i class="bx bx-x-circle me-1"></i> Pengajuan Ditolak';
                }

                let lampiranHtml = '';
                if(data.persyaratan && data.persyaratan.length > 0) {
                    data.persyaratan.forEach((item, index) => {
                        let fileUrl = `{{ Storage::url('') }}${item.file_path}`;
                        const fileName = item.file_path.split('/').pop();
                        const isPdf = fileName.toLowerCase().endsWith('.pdf');
                        const formatBadge = isPdf ? '<span class="badge bg-light text-muted border px-2">PDF</span>' : '<span class="badge bg-light text-muted border px-2">PDF / JPG</span>';
                        
                        lampiranHtml += `
                            <tr>
                                <td class="text-dark fw-medium ps-3">${index + 1}</td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">${item.jenis_dokumen}</div>
                                    <div class="text-muted font-size-11">${fileName}</div>
                                </td>
                                <td class="text-center">${formatBadge}</td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="${fileUrl}" target="_blank" class="btn btn-info btn-sm text-white border-0 px-3" style="background-color: #0dcaf0;"><i class="bx bx-show align-middle me-1"></i> Lihat</a>
                                        <a href="${fileUrl}" download class="btn btn-primary btn-sm border-0 px-3"><i class="bx bx-download align-middle me-1"></i> Unduh</a>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    lampiranHtml = '<tr><td colspan="4" class="text-center text-muted py-4"><i class="bx bx-folder-open display-4 mb-2 opacity-25"></i><br>Tidak ada lampiran</td></tr>';
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
