@extends('format_surat.layout_surat')

@section('content')
    <div class="judul-surat">SURAT KETERANGAN TIDAK MAMPU (SKTM)</div>
    <div class="nomor-surat">Nomor : 401/      /2006/{{ date('Y') }}</div>

    <p style="text-align: justify; text-indent: 30px;">
        Yang bertanda tangan dibawah ini Kepala Desa Lubuk Bernai Kecamatan Batang Asam Kabupaten Tanjung Jabung Barat, menerangkan dengan sebenarnya bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->nama }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->nik }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
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
            <td>{{ $pengajuanSurat->user->penduduk->alamat }} RT {{ $pengajuanSurat->user->penduduk->rt }} Desa Lubuk Bernai</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Berdasarkan keterangan RT/RW setempat dan pengamatan kami, bahwa nama tersebut di atas benar-benar keluarga yang tergolong <b>Keluarga Tidak Mampu / Pra-Sejahtera</b>.
    </p>
    
    <p style="text-align: justify; text-indent: 30px;">
        Surat Keterangan ini dibuat dan diberikan untuk keperluan:
    </p>
    
    <div style="text-align: center; font-weight: bold; margin: 15px 0;">
        "{{ $pengajuanSurat->keperluan }}"
    </div>

    <p style="text-align: justify; text-indent: 30px;">
        Demikian Surat Keterangan Tidak Mampu (SKTM) ini kami buat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya oleh pihak yang berkepentingan.
    </p>
@endsection
