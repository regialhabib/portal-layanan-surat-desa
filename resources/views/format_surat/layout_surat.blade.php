<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat PDF</title>
    <style>
        @page {
            margin: 1cm 1.5cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.25;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            position: relative;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat .text-container {
            text-align: center;
            padding-left: 90px;
            padding-right: 90px;
        }
        .kop-surat h1, .kop-surat h2, .kop-surat h3, .kop-surat p {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
        }
        .kop-surat h2 {
            font-size: 14pt;
            font-weight: normal;
        }
        .kop-surat h3 {
            font-size: 18pt;
            font-weight: bold;
        }
        .kop-surat p {
            font-size: 11pt;
            margin-top: 5px;
        }
        .logo {
            position: absolute;
            top: 0;
            left: 0;
        }
        .content {
            margin-top: 20px;
        }
        .judul-surat {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 0;
        }
        .nomor-surat {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .signature {
            float: right;
            text-align: left;
            margin-top: 40px;
            width: 250px;
        }
        .signature p {
            margin: 0;
        }
        .qr-code {
            margin-top: 15px;
            margin-bottom: 10px;
            text-align: left;
        }
        .signature .name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 0;
        }
        .clear {
            clear: both;
        }
        table.data-table {
            width: 100%;
            margin-left: 20px;
            margin-bottom: 15px;
        }
        table.data-table td {
            vertical-align: top;
            padding: 3px 0;
        }
        table.data-table td:nth-child(1) {
            width: 150px;
        }
        table.data-table td:nth-child(2) {
            width: 15px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        @php
            $imagePath = public_path('images/logo-desa.jpeg');
            $logo = '';
            if (file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $logo = 'data:image/jpeg;base64,' . $imageData;
            }
        @endphp
        @if($logo)
            <img src="{{ $logo }}" class="logo" width="80" height="89" alt="Logo">
        @endif
        <div class="text-container">
            <h2>PEMERINTAH KABUPATEN TANJUNG JABUNG BARAT</h2>
            <h2>KECAMATAN BATANG ASAM</h2>
            <h3>DESA LUBUK BERNAI</h3>
            <p>Jl.Mandaleko RT.006 Kode POS : 36552</p>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="signature">
        <p>Lubuk Bernai, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
        <p>KEPALA DESA LUBUK BERNAI</p>
        @php
            $qrText = "Ditandatangani secara digital oleh Kepala Desa Lubuk Bernai, F A U Z I pada " . \Carbon\Carbon::now()->isoFormat('D MMMM Y');
            $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(80)->generate($qrText));
        @endphp
        <div class="qr-code">
            <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" width="80" height="80">
        </div>
        <div class="name">F A U Z I</div>
    </div>

    <div class="clear"></div>

</body>
</html>
