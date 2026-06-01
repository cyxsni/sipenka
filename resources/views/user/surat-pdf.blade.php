<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat {{ $surat->nomor_surat ?? '' }}</title>
    <style>
        @page {
            size: A5;
            margin: 1.2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header-right {
            text-align: right;
            font-weight: bold;
            margin-bottom: 25px;
        }
        .perihal {
            font-weight: bold;
            margin-bottom: 12px;
        }
        .row {
            width: 100%;
            overflow: hidden; /* clearfix */
            margin-bottom: 8px;
        }
        .kiri {
            float: left;
            width: 45%;
        }
        .kanan {
            float: right;
            width: 45%;
            text-align: right;
        }
        .keterangan {
            clear: both;
            margin-top: 4px;
        }
        .footer {
            margin-top: 40px;
            font-size: 9pt;
            color: #888;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Nomor Surat di kanan atas -->
    <div class="header-right">
        {{ $surat->kode_petunjuk }} / {{ $surat->nomor_surat ?? '...' }}
    </div>

    <!-- Perihal -->
    <div class="perihal">
        Perihal: {{ $surat->perihal }}
    </div>

    <!-- Tujuan (kiri) dan Tanggal Surat (kanan) sejajar -->
    <div class="row">
        <div class="kiri">Tujuan: {{ $surat->tujuan }}</div>
        <div class="kanan">Tanggal Surat: {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</div>
    </div>

    <!-- Keterangan -->
    <div class="row">
        <div class="kiri keterangan">Keterangan: {{ $surat->keterangan }}</div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak dari SIPENKA – Dinas Pendidikan Kabupaten Banyumas pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>
</body>
</html>