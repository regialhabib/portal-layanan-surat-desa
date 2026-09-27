@extends('layouts.main')
@push('style')
    <!-- Sweet Alert-->
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
        <h4 class="mb-3 mb-md-0 font-size-18 text-dark"><i class="bx bx-history text-primary me-2"></i> Riwayat Pengajuan Surat</h4>
        
        <ul class="nav nav-pills bg-light rounded-pill p-1 mb-0 custom-nav-scroll overflow-auto flex-nowrap" style="white-space: nowrap;">
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 px-md-4 fw-medium {{ request('filter') == '' ? 'active shadow-sm' : 'text-muted' }}" href="{{ route('masyarakat.riwayat-pengajuan') }}">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 px-md-4 fw-medium {{ request('filter') == 'diproses' ? 'active shadow-sm' : 'text-muted' }}" href="{{ route('masyarakat.riwayat-pengajuan', ['filter' => 'diproses']) }}">Diproses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 px-md-4 fw-medium {{ request('filter') == 'selesai' ? 'active shadow-sm' : 'text-muted' }}" href="{{ route('masyarakat.riwayat-pengajuan', ['filter' => 'selesai']) }}">Selesai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-3 px-md-4 fw-medium {{ request('filter') == 'ditolak' ? 'active shadow-sm' : 'text-muted' }}" href="{{ route('masyarakat.riwayat-pengajuan', ['filter' => 'ditolak']) }}">Ditolak</a>
            </li>
        </ul>
    </div>

    @if($pengajuanSurat->isEmpty())
        <div class="card shadow-sm border-0 rounded-4 text-center py-5">
            <div class="card-body">
                <i class="bx bx-folder-open display-1 text-muted mb-3 opacity-25"></i>
                <h5 class="text-dark fw-bold">Tidak Ada Data Pengajuan</h5>
                <p class="text-muted">Belum ada catatan pengajuan surat untuk kategori ini.</p>
                <a href="{{ route('pengajuan-surat.create') }}" class="btn btn-primary mt-2 px-4 rounded-pill shadow-sm"><i class="bx bx-edit-alt me-1"></i> Buat Pengajuan Baru</a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach ($pengajuanSurat as $item)
                <div class="col-md-4 col-xl-3 mb-4">
                    <div class="card shadow-sm border-0 h-100 rounded-3">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-soft-primary text-primary px-2 py-1 rounded-pill">{{ $item->jenisSurat->nama_surat }}</span>
                                <small class="text-muted"><i class="bx bx-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M') }}</small>
                            </div>
                            <h5 class="text-dark fw-bold mb-3 text-truncate">{{ $item->jenisSurat->nama_surat }}</h5>
                            <p class="text-muted font-size-12 mb-1 text-truncate">
                                {{ $item->keperluan }}
                            </p>
                            
                            <div class="mt-auto pt-3">
                                @if ($item->status == 'diajukan' || $item->status == 'diproses')
                                    <div class="badge badge-soft-warning font-size-12 mb-2 w-100 text-center py-2 fw-semibold text-warning" style="color: #f1b44c !important;"><i class="bx bx-hourglass me-1"></i> Sedang Diproses</div>
                                @elseif($item->status == 'selesai')
                                    <div class="badge badge-soft-success font-size-12 mb-2 w-100 text-center py-2 fw-semibold"><i class="bx bx-check-circle me-1"></i> Selesai Diterbitkan</div>
                                @else
                                    <div class="badge badge-soft-danger font-size-12 mb-2 w-100 text-center py-2 fw-semibold"><i class="bx bx-x-circle me-1"></i> Pengajuan Ditolak</div>
                                @endif
                                
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 waves-effect waves-light btn-detail rounded-3 fw-medium"
                                    data-url="{{ route('masyarakat.show', $item->id) }}" data-bs-toggle="modal"
                                    data-bs-target="#detailModal">
                                    <i class="bx bx-show align-middle me-1"></i> Cek Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-3">
                            <span class="avatar-title bg-soft-primary text-primary rounded-3 font-size-24">
                                <i class="bx bx-file"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-1">Detail Pengajuan</h5>
                            <p class="text-muted mb-0 font-size-12" id="tanggal_pengajuan"></p>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body bg-light px-4 py-4 mt-3 rounded-bottom-4" style="border-radius: 1rem 1rem 1rem 1rem;">
                    
                    <div class="card shadow-sm border-0 mb-3 rounded-3">
                        <div class="card-body px-4 py-3">
                            <table class="table table-borderless table-sm mb-0 font-size-13">
                                <tbody>
                                    <tr><td class="text-muted" style="width: 35%; padding: 6px 0;">Jenis Surat</td><td id="jenis_surat" class="fw-semibold text-dark" style="padding: 6px 0;"></td></tr>
                                    <tr><td class="text-muted" style="padding: 6px 0; vertical-align: top;">Keperluan</td><td id="keperluan" class="fw-semibold text-dark text-wrap" style="padding: 6px 0;"></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="status-info"></div>

                    <div id="download-container" class="card shadow-none border border-success mt-3 d-none rounded-3">
                        <div class="card-body text-center py-4 bg-soft-success">
                            <h6 class="font-weight-bold text-success mb-3"><i class="bx bx-check-shield align-middle me-1"></i> Surat Telah Terbit</h6>
                            <a href="#" id="download-surat" target="_blank" class="btn btn-success waves-effect waves-light px-4 rounded-pill shadow-sm w-100">
                                <i class="bx bx-download align-middle me-1"></i> Download Surat Resmi
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.addEventListener('click', async function(e) {
            const btn = e.target.closest('.btn-detail');
            if (!btn) return;

            try {
                const response = await fetch(btn.dataset.url);
                const data = await response.json();

                document.getElementById('jenis_surat').innerText = data.jenis_surat.nama_surat;
                
                const tgl = new Date(data.tanggal_pengajuan);
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('tanggal_pengajuan').innerText = "Diajukan: " + tgl.toLocaleDateString('id-ID', options);
                
                document.getElementById('keperluan').innerText = data.keperluan;

                let infoHtml = '';
                document.getElementById('download-container').classList.add('d-none');

                if (data.status === 'diajukan' || data.status === 'diproses') {
                    infoHtml = `
                        <div class="alert alert-warning border-0 shadow-sm rounded-3 mb-0 d-flex align-items-center">
                            <i class="bx bx-hourglass font-size-24 me-3"></i>
                            <div>
                                <h6 class="alert-heading font-size-14 mb-1">Menunggu Verifikasi</h6>
                                <p class="mb-0 font-size-12">Pengajuan Anda sedang mengantre untuk diperiksa oleh petugas desa.</p>
                            </div>
                        </div>
                    `;
                } else if (data.status === 'ditolak') {
                    infoHtml = `
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-0 d-flex align-items-start">
                            <i class="bx bx-message-alt-error font-size-24 me-3 mt-1"></i>
                            <div>
                                <h6 class="alert-heading font-size-14 mb-1">Pengajuan Ditolak</h6>
                                <p class="mb-0 font-size-12 fw-bold">Alasan Penolakan:</p>
                                <p class="mb-0 font-size-12">${data.catatan_admin ?? 'Tidak ada keterangan tambahan.'}</p>
                            </div>
                        </div>
                    `;
                } else if (data.status === 'selesai') {
                    infoHtml = `
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-0 d-flex align-items-center">
                            <i class="bx bx-check-circle font-size-24 me-3"></i>
                            <div>
                                <h6 class="alert-heading font-size-14 mb-1">Selesai Diproses</h6>
                                <p class="mb-0 font-size-12">Surat telah ditandatangani dan siap diunduh.</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('download-container').classList.remove('d-none');
                    document.getElementById('download-surat').href = `{{ Storage::url('') }}${data.file_surat}`;
                }

                document.getElementById('status-info').innerHTML = infoHtml;

            } catch (error) {
                console.error(error);
                alert('Gagal mengambil data.');
            }
        });
    </script>
@endpush
