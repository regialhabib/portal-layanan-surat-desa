<!DOCTYPE html>
<html>

<head>
    <title>Laporan</title>
    <meta charset="utf-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop-container {
            display: flex;
            align-items: center;
            justify-content: center;
            /* center keseluruhan */
            position: relative;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 15px;

        }

        .kop-logo {
            position: absolute;
            left: 0;
            top: 0;

            /* logo tetap di kiri */
        }

        .kop-logo img {
            width: 60px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h2 {
            margin: 0;
        }

        .kop-text p {
            margin: 2px 0;
        }

        h3 {
            text-align: center;
            margin: 10px 0 5px 0;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data,
        table.data th,
        table.data td {
            border: 1px solid black;
        }

        table.data th {
            background: #f2f2f2;
        }

        table.data th,
        table.data td {
            padding: 6px;
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            border: none;
            text-align: left;
        }
    </style>

</head>

<body>

    <!-- KOP SURAT -->
    <div class="kop-container">
        <div class="kop-logo">
            <img src="{{ public_path('images/sekolah.png') }}" alt="Logo">
        </div>

        <div class="kop-text">
            <h2>SMK NEGERI 1 TUNGKAL JAYA</h2>
            <p>Jalan Palembang-Jambi km. 173 Sinar Tungkal 30756</p>
            <p>NPSN : 10648848 || website https://smkn1tungkaljaya.sch.id || email : smktkl@gmail.com</p>
        </div>
    </div>

    <h3>{{ $judul }}</h3>
    <div class="periode">
        Periode :
        {{ \Carbon\Carbon::parse($awal)->format('d-m-Y') }}
        s/d
        {{ \Carbon\Carbon::parse($akhir)->format('d-m-Y') }}
    </div>


    <!-- TABEL DATA -->
    <table class="data" style="margin-top: 20px">

        <thead>
            <tr>
                <th>No Urut</th>
                <th>No Surat</th>
                <th>
    Tanggal {{ $judul == "Data Surat Masuk" ? "diterima" : "-" }}
</th>
                <th>Alamat</th>
                <th>Perihal</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_surat }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d-m-Y') }}</td>
                    <td>{{ $item->alamat_penerima }}</td>
                    <td>{{ $item->isi_surat }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

    <!-- TANDA TANGAN -->
    <table class="ttd">
        <tr>
            <td width="100%"></td> <!-- kosongin kiri -->
            <td width="50%" style="text-align: center;">
                <p>Jambi, {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                <p>Kepala Sekolah</p>
                <br><br><br>
                <p><u>Budi Susesno, S.Pd., M.M</u></p>
                <p>NIP. 197702162007011008</p>
            </td>
        </tr>
    </table>

</body>

</html>
