@extends('layouts.main')

@section('main-content')

{{-- Statistik --}}
<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="card border h-100" style="border: 0.5px solid var(--bs-border-color) !important; border-radius: 12px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1" style="font-size:12px; font-weight:500; text-transform:uppercase; letter-spacing:.04em;">Penduduk</p>
                        <h3 class="mb-0 fw-500">{{ number_format($jumlahPenduduk) }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#E6F1FB;color:#185FA5;font-size:20px;">
                        <i class="bx bx-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border h-100" style="border: 0.5px solid var(--bs-border-color) !important; border-radius: 12px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1" style="font-size:12px; font-weight:500; text-transform:uppercase; letter-spacing:.04em;">Pengajuan</p>
                        <h3 class="mb-0">{{ number_format($jumlahPengajuan) }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#EAF3DE;color:#3B6D11;font-size:20px;">
                        <i class="bx bx-file"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border h-100" style="border: 0.5px solid var(--bs-border-color) !important; border-radius: 12px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1" style="font-size:12px; font-weight:500; text-transform:uppercase; letter-spacing:.04em;">Diproses</p>
                        <h3 class="mb-0">{{ number_format($jumlahDiproses) }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#FAEEDA;color:#854F0B;font-size:20px;">
                        <i class="bx bx-loader-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border h-100" style="border: 0.5px solid var(--bs-border-color) !important; border-radius: 12px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1" style="font-size:12px; font-weight:500; text-transform:uppercase; letter-spacing:.04em;">Selesai</p>
                        <h3 class="mb-0">{{ number_format($jumlahSelesai) }}</h3>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#E1F5EE;color:#0F6E56;font-size:20px;">
                        <i class="bx bx-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Tabel + Doughnut --}}
<div class="row g-3 mb-4">

    <div class="col-lg-8">
        <div class="card h-100" style="border: 0.5px solid var(--bs-border-color); border-radius: 12px;">
            <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3 px-4" style="border-bottom: 0.5px solid var(--bs-border-color);">
                <h6 class="mb-0 fw-500">Pengajuan surat terbaru</h6>
                <span class="text-muted" style="font-size:12px;">5 data terbaru</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size:13px;">
                        <thead>
                            <tr style="border-bottom: 0.5px solid var(--bs-border-color);">
                                <th class="px-4 py-3 text-muted fw-500" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Tanggal</th>
                                <th class="px-4 py-3 text-muted fw-500" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Nama pemohon</th>
                                <th class="px-4 py-3 text-muted fw-500" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Jenis surat</th>
                                <th class="px-4 py-3 text-muted fw-500" style="font-size:11px;text-transform:uppercase;letter-spacing:.04em;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanTerbaru as $item)
                                <tr style="border-bottom: 0.5px solid var(--bs-border-color);">
                                    <td class="px-4 py-3">{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td class="px-4 py-3">{{ $item->user->penduduk->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $item->jenisSurat->nama_surat ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($item->status == 'diajukan')
                                            <span class="badge rounded-pill px-3 py-1" style="background:#FAEEDA;color:#854F0B;font-size:11px;">Menunggu</span>
                                        @elseif ($item->status == 'diproses')
                                            <span class="badge rounded-pill px-3 py-1" style="background:#E6F1FB;color:#185FA5;font-size:11px;">Diproses</span>
                                        @elseif ($item->status == 'selesai')
                                            <span class="badge rounded-pill px-3 py-1" style="background:#EAF3DE;color:#3B6D11;font-size:11px;">Selesai</span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-1" style="background:#FCEBEB;color:#A32D2D;font-size:11px;">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data pengajuan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100" style="border: 0.5px solid var(--bs-border-color); border-radius: 12px;">
            <div class="card-header bg-transparent py-3 px-4" style="border-bottom: 0.5px solid var(--bs-border-color);">
                <h6 class="mb-0 fw-500">Status pengajuan</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 mb-3" style="font-size:12px;">
                    <span class="d-flex align-items-center gap-1"><span style="width:10px;height:10px;border-radius:2px;background:#EF9F27;display:inline-block;"></span> Menunggu {{ $jumlahMenunggu }}</span>
                    <span class="d-flex align-items-center gap-1"><span style="width:10px;height:10px;border-radius:2px;background:#378ADD;display:inline-block;"></span> Diproses {{ $jumlahDiproses }}</span>
                    <span class="d-flex align-items-center gap-1"><span style="width:10px;height:10px;border-radius:2px;background:#1D9E75;display:inline-block;"></span> Selesai {{ $jumlahSelesai }}</span>
                    <span class="d-flex align-items-center gap-1"><span style="width:10px;height:10px;border-radius:2px;background:#E24B4A;display:inline-block;"></span> Ditolak {{ $jumlahDitolak }}</span>
                </div>
                <div style="position:relative; height:280px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Grafik Bulanan --}}
<div class="row g-3 mb-4">
    <div class="col-lg-12">
        <div class="card" style="border: 0.5px solid var(--bs-border-color); border-radius: 12px;">
            <div class="card-header bg-transparent py-3 px-4" style="border-bottom: 0.5px solid var(--bs-border-color);">
                <h6 class="mb-0 fw-500">Grafik pengajuan surat tahun {{ date('Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 mb-3" style="font-size:12px;">
                    <span class="d-flex align-items-center gap-1"><span style="width:10px;height:10px;border-radius:2px;background:#378ADD;display:inline-block;"></span> Jumlah pengajuan</span>
                </div>
                <div style="position:relative; height:380px;">
                    <canvas id="pengajuanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const gridColor = 'rgba(0,0,0,0.06)';
    const tickColor = '#999';

    /*
    |--------------------------------------------------------------------------
    | Grafik Pengajuan Bulanan
    |--------------------------------------------------------------------------
    */
    new Chart(document.getElementById('pengajuanChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: @json($grafikPengajuan),
                backgroundColor: '#378ADD',
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: { color: tickColor, font: { size: 12 } },
                    grid: { display: false },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: tickColor, font: { size: 12 } },
                    grid: { color: gridColor },
                    border: { display: false }
                }
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Status Surat
    |--------------------------------------------------------------------------
    */
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu','Diproses','Selesai','Ditolak'],
            datasets: [{
                data: [
                    {{ $jumlahMenunggu }},
                    {{ $jumlahDiproses }},
                    {{ $jumlahSelesai }},
                    {{ $jumlahDitolak }}
                ],
                backgroundColor: ['#EF9F27','#378ADD','#1D9E75','#E24B4A'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false }
            }
        }
    });

});
</script>
@endpush