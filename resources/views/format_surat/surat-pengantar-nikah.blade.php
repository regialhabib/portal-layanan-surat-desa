@extends('format_surat.layout_surat')

@section('content')
    <div class="judul-surat">SURAT PENGANTAR NIKAH</div>
    <div class="nomor-surat">Nomor : 474.2/      /2006/{{ date('Y') }}</div>

    <p style="text-align: justify; text-indent: 30px;">
        Yang bertanda tangan dibawah ini Kepala Desa Lubuk Bernai Kecamatan Batang Asam Kabupaten Tanjung Jabung Barat, menerangkan dengan sesungguhnya bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->nama }}</td>
        </tr>
        <tr>
            <td>Nomor Induk Kependudukan (NIK)</td>
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
            <td>Status Perkawinan</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->status_perkawinan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->alamat }} RT {{ $pengajuanSurat->user->penduduk->rt }} Desa Lubuk Bernai</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Adalah benar nama tersebut di atas penduduk Desa Lubuk Bernai dan bermaksud untuk melangsungkan pernikahan dengan:
    </p>

    <table class="data-table">
        <tr>
            <td>Nama Calon Pasangan</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->data_tambahan['nama_calon_pasangan'] ?? '-' }}</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Demikian Surat Pengantar Nikah ini kami buat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya.
    </p>
@endsection
