@extends('format_surat.layout_surat')

@section('content')
    <div class="judul-surat">SURAT KETERANGAN USAHA (SKU)</div>
    <div class="nomor-surat">Nomor : 503/      /2006/{{ date('Y') }}</div>

    <p style="text-align: justify; text-indent: 30px;">
        Yang bertanda tangan dibawah ini Kepala Desa Lubuk Bernai Kecamatan Batang Asam Kabupaten Tanjung Jabung Barat, menerangkan dengan sesungguhnya bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->nama }}</td>
        </tr>
        <tr>
            <td>No. KTP/NIK</td>
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
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->pekerjaan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->alamat }} RT {{ $pengajuanSurat->user->penduduk->rt }} RW {{ $pengajuanSurat->user->penduduk->rw }} Desa Lubuk Bernai</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Adalah benar nama tersebut di atas penduduk Desa Lubuk Bernai yang berdomisili di alamat tersebut dan memiliki usaha:
    </p>

    <div style="text-align: center; font-weight: bold; font-size: 14pt; margin: 20px 0;">
        "{{ $pengajuanSurat->data_tambahan['nama_usaha'] ?? '-' }}"
    </div>

    <p style="text-align: justify; text-indent: 30px;">
        Demikian Surat Keterangan Usaha (SKU) ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh yang berkepentingan.
    </p>
@endsection
