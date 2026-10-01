@extends('format_surat.layout_surat')

@section('content')
    <div class="judul-surat">SURAT KETERANGAN KEMATIAN</div>
    <div class="nomor-surat">Nomor : 747/      /2006/{{ date('Y') }}</div>

    <p style="text-align: justify; text-indent: 30px;">
        Yang bertanda tangan dibawah ini Kepala Desa Lubuk Bernai Kecamatan Batang Asam Kabupaten Tanjung Jabung Barat, menerangkan :
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
            <td>{{ $pengajuanSurat->user->penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($pengajuanSurat->user->penduduk->tanggal_lahir)->isoFormat('DD-MM-Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->user->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Warganegara</td>
            <td>:</td>
            <td>Indonesia</td>
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
            <td>{{ $pengajuanSurat->user->penduduk->alamat }} RT {{ $pengajuanSurat->user->penduduk->rt }} Desa Lubuk Bernai Kec. Batang Asam Kab. Tanjung Jabung Barat Jambi</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Bahwa nama tersebut diatas sepengetahuan kami adalah benar warga Desa Lubuk Bernai Kecamatan Batang Asam Kabupaten Tanjung Jabung Barat yang meninggal dunia karena:
    </p>

    <table class="data-table">
        <tr>
            <td>Hari / Tanggal</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->data_tambahan['hari_tanggal_meninggal'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Disebabkan Karena</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->data_tambahan['penyebab_meninggal'] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempat Meninggal</td>
            <td>:</td>
            <td>{{ $pengajuanSurat->data_tambahan['tempat_meninggal'] ?? '-' }}</td>
        </tr>
    </table>

    <p style="text-align: justify; text-indent: 30px;">
        Demikianlah surat keterangan kematian ini kami buat dengan sebenar - benarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>
@endsection
