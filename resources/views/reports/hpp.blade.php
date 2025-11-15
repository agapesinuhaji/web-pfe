<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pemeriksaan Psikologis</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #222;
        }

        /* HEADER (Kop Surat) - TIDAK BERUBAH DARI SOLUSI TERAKHIR (SUDAH RAPI) */
        .header {
            background-color: #f2f6fc;
            padding: 20px 40px;
            display: table; 
            width: 100%; 
            border-bottom: 2px solid #c5d1eb;
            box-sizing: border-box; 
        }

        .header-left {
            display: table-cell; 
            vertical-align: middle; 
            width: 50%; 
        }
        
        .header-left img {
            width: 70px;
            height: auto;
            display: block;
            margin: 0; 
        }

        .header-right {
            display: table-cell; 
            vertical-align: middle; 
            width: 50%; 
            text-align: right;
            line-height: 1.5;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #1a2a52;
            margin-bottom: 3px;
        }

        .company-info {
            font-size: 11px;
            color: #555;
        }

        .title {
            text-align: center;
            margin: 20px 0 10px 0; /* Mengurangi margin bawah */
            font-size: 18px;
            font-weight: bold;
            color: #1a2a52;
        }

        /* BODY & CONTENT */
        .content {
            /* 🔥 Perbaikan: Menyesuaikan padding horizontal (40px) agar sama dengan header */
            padding: 0 40px 35px 40px; 
        }
        
        /* Gaya untuk nama psikolog */
        .psychologist-name {
            text-align: center;
            margin-bottom: 25px;
            display: block;
            font-size: 13px; /* Sedikit lebih besar dari konten */
            font-weight: 500;
            color: #444;
        }

        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px; /* Jarak yang lebih baik */
            background-color: #f9f9f9; /* Memberikan warna latar belakang agar menonjol */
            border-radius: 5px;
        }

        .table-info td {
            padding: 8px 10px; /* Padding sel yang lebih besar */
            vertical-align: top;
        }
        
        .table-info tr:last-child {
            border-bottom: none;
        }

        .label { 
            font-weight: bold; 
            width: 150px; 
            color: #1a2a52; /* Warna label yang lebih tegas */
        }

        .tag {
            background-color: #e0e6f3;
            border-radius: 6px;
            padding: 3px 6px;
            font-size: 11px;
            font-weight: bold;
            color: #1a2a52;
        }

        h3 {
            margin-top: 25px; /* Jarak atas yang lebih lega */
            margin-bottom: 10px;
            color: #1a2a52;
            padding-bottom: 3px;
            border-bottom: 1px solid #c5d1eb; /* Garis pemisah yang elegan */
            font-size: 14px;
        }
        
        p {
            line-height: 1.6; /* Jarak baris yang lebih nyaman dibaca */
            margin-bottom: 15px;
            text-align: justify;
        }

        ol { 
            padding-left: 25px; /* Sedikit geser ke kanan */
            margin-bottom: 20px;
        }
        
        ol li {
            margin-bottom: 5px;
            line-height: 1.5;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            color: #777;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee; /* Garis pemisah halus */
        }

        .page-break { page-break-after: always; }

        /* TANDA TANGAN (Halaman 2) */
        .signature-area {
            /* Menggunakan padding yang sama dengan .content */
            padding: 40px; 
            text-align: right;
        }
        
        .signature {
            margin-top: 50px;
            text-align: right;
            line-height: 1.6;
        }
        
        .signature p {
            text-align: right;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <?php
            $imagePath = public_path('logo.png');
            $imageData = base64_encode(file_get_contents($imagePath));
            $imgSrc = 'data:image/png;base64,' . $imageData;
            
            ?>
            <img src="<?= $imgSrc; ?>" alt="Logo Psychologist For Everyone">
        </div>
        <div class="header-right">
            <div class="company-name">Psychologist For Everyone</div>
            <div class="company-info">
                Telp: +62 882 0086 7768 2<br>
                Website: www.pfemily.id
            </div>
        </div>
    </div>


    <div class="title">Hasil Pemeriksaan Psikologis</div>
    <span class="psychologist-name">{{ $order->conselor->profile->name }} , Psikolog</span>
    
    <div class="content">
        <table class="table-info">
            <tr><td class="label">Nama</td><td>{{ $order->user->profile->name }}</td></tr>
            <tr><td class="label">Jenis Kelamin</td><td><span class="tag">{{ $order->user->profile->gender == 'P' ? 'Perempuan' : 'Laki - Laki' }}
</span></td></tr>
            <tr><td class="label">Usia</td><td>{{ \Carbon\Carbon::parse($order->user->profile->date_of_birth)->age }} Tahun
</td></tr>
            <tr><td class="label">Tanggal Konseling</td><td>{{ \Carbon\Carbon::parse($order->schedule->date)->translatedFormat('d F Y') }}
</td></tr>
            <tr><td class="label">Konseling Via</td><td><span class="tag">{{ $order->method->name }}</span></td></tr>
        </table>

        <h3>Catatan Hasil Konseling</h3>
        {!! $result->note !!}

        <h3>Diagnosa</h3>
        {!! $result->suspicion !!}

        <h3>Rekomendasi</h3>
        {!! $result->recommendation !!}

        <p class="footer">
            Hasil pemeriksaan psikologis ini berdasarkan konseling yang dilakukan kepada klien. <br>
            Dapat dijadikan acuan untuk pemeriksaan lebih lanjut dengan Psikiater atau Psikolog lain.
        </p>
    </div>

    <div class="signature-area">
        <div class="signature">
            <p>{{ $order->conselor->profile->name }}, Psikolog<br>
            SIPP: {{ $order->conselor->profile->sipp }}</p>
        </div>
    </div>
    
</body>
</html>