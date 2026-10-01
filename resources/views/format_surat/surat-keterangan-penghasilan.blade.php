@extends('format_surat.layout_surat')

@section('content')
    <div class="judul-surat">SURAT KETERANGAN PENGHASILAN</div>
    <div class="nomor-surat">Nomor : 145/      /2006/{{ date('Y') }}</div>

    <p style="text-align: justify; text-indent: 30px;">
        Yang bertanda tangan dibawah ini Kepala Desa Lubuk Bernai Kecamatan Batang Asam Kabupaten Tanjung Jabung Barat, dengan ini menerangkan bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->nama }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->nik }}</td>
        </tr>
        <tr>
            <td>Tempat/Tgl. Lahir</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuanSurat->user->penduduk->tanggal_lahir)->isoFormat('DD MMMM Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->agama }}</td>
        </tr>
        <tr>
            <td>Pekerjaan / Profesi</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->pekerjaan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->alamat }} RT {{ $pengajuanSurat->user->penduduk->rt }} Desa Lubuk Bernai</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Berdasarkan pengakuan yang bersangkutan, bahwa nama tersebut di atas benar-benar memiliki penghasilan rata-rata per bulan sebesar:
    </p>
    
    <div style="text-align: center; font-weight: bold; margin: 15px 0;">
        "{{ $pengajuanSurat->data_tambahan['rata_rata_penghasilan_per_bulan'] ?? '-' }}"
    </div>

    <p style="text-align: justify; text-indent: 30px;">
        Demikian Surat Keterangan Penghasilan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh pihak-pihak terkait.
    </p>
@endsection
