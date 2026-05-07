<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara - SIPEL PLN</title>
    <style>
        @page {
            margin: 2.5cm;
        }
        body { 
            font-family: "Times New Roman", Times, serif; 
            font-size: 11pt; 
            line-height: 1.5;
            color: #000;
            text-align: justify;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .pasal-title {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .page-break { page-break-after: always; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }
        
        .signature-table {
            width: 100%;
            margin-top: 30px;
            text-align: center;
        }
        .signature-table td {
            width: 50%;
            padding: 10px;
        }
        .signature-img {
            height: 80px;
            object-fit: contain;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        .indent { padding-left: 20px; }
        
        ul.no-bullets {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        ul.no-bullets li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>

@php
    $baLingkungan = [];
    if($permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data) {
        $baLingkungan = json_decode($permohonan->ba_lingkungan_data, true);
    }
    
    // Fallback variables
    $nomor_ba = $baLingkungan['nomor_ba'] ?? '...........................';
    $nama_pihak_kesatu = $baLingkungan['nama_pihak_kesatu'] ?? '...........................';
    $jabatan_pihak_kesatu = $baLingkungan['jabatan_pihak_kesatu'] ?? '...........................';
    $nama_pihak_kedua = $baLingkungan['nama_pihak_kedua'] ?? 'LEANDRA AGUNG TRI RADI PUTRA'; // Default PLN Manager
    $luas_tanah = $baLingkungan['luas_tanah'] ?? '...........................';
    $lokasi = $baLingkungan['lokasi'] ?? '...........................';
    $nomor_sertifikat = $baLingkungan['nomor_sertifikat'] ?? '...........................';
    
    // Carbon for dates
    $tanggal_sekarang = \Carbon\Carbon::now()->locale('id');
    $hari = $tanggal_sekarang->translatedFormat('l');
    $tgl_angka = $tanggal_sekarang->format('d');
    $bulan = $tanggal_sekarang->translatedFormat('F');
    $tahun_angka = $tanggal_sekarang->format('Y');
    
    // Helper function for spelled out numbers (simplified for date)
    $terbilang = function($angka) {
        $angka = (int)$angka;
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        if ($angka < 12) return $huruf[$angka];
        elseif ($angka < 20) return $huruf[$angka - 10] . " belas";
        elseif ($angka < 100) return $huruf[floor($angka / 10)] . " puluh " . $huruf[$angka % 10];
        elseif ($angka == 2024) return "dua ribu dua puluh empat"; // Hardcoded for simplicity
        elseif ($angka == 2025) return "dua ribu dua puluh lima";
        elseif ($angka == 2026) return "dua ribu dua puluh enam";
        return (string)$angka;
    };
    
    $tgl_terbilang = ucwords($terbilang($tgl_angka));
    $tahun_terbilang = ucwords($terbilang($tahun_angka));
@endphp

<!-- PAGE 1: BERITA ACARA -->
<div class="title">
    BERITA ACARA<br>
    SERAH TERIMA IJIN PENGGUNAAN SEBIDANG TANAH BESERTA<br>
    BANGUNAN GARDU TEMBOK DI ATASNYA<br>
    NO: {{ $nomor_ba }}
</div>

<p>
    Pada hari ini <strong>{{ $hari }}</strong> Tanggal <strong>{{ strtolower($tgl_terbilang) }}</strong> bulan <strong>{{ $bulan }}</strong> tahun <strong>{{ strtolower($tahun_terbilang) }}</strong>, kami yang bertandatangan dibawah ini:
</p>

<table>
    <tr>
        <td style="width: 20px;">1.</td>
        <td style="width: 100px;">Nama</td>
        <td style="width: 15px;">:</td>
        <td class="font-bold">{{ strtoupper($nama_pihak_kesatu) }}</td>
    </tr>
    <tr>
        <td></td>
        <td>Jabatan</td>
        <td>:</td>
        <td class="font-bold">{{ $jabatan_pihak_kesatu }}</td>
    </tr>
</table>

<p style="padding-left: 20px; margin-top: 10px;">
    Dalam hal ini bertindak untuk dan atas nama: <strong>{{ strtoupper($nama_pihak_kesatu) }}</strong><br>
    Selanjutnya disebut <strong>PIHAK KESATU</strong>
</p>

<table style="margin-top: 15px;">
    <tr>
        <td style="width: 20px;">2.</td>
        <td style="width: 100px;">Nama</td>
        <td style="width: 15px;">:</td>
        <td class="font-bold">{{ strtoupper($nama_pihak_kedua) }}</td>
    </tr>
</table>

<p style="padding-left: 20px; margin-top: 10px;">
    Berdasarkan surat kuasa Manager PT PLN (Persero) Distribusi Jawa Barat bertindak untuk dan atas nama PT.PLN (Persero) Distribusi Jawa Barat UP3 Bandung, yang berkedudukan di Jl. Soekarno Hatta No. 436 Bandung. Selanjutnya disebut <strong>PIHAK KEDUA</strong>
</p>

<p style="margin-top: 20px;">
    Kedua belah pihak bersepakat melakukan serah terima ijin penggunaan sebidang tanah beserta bangunan gardu tembok type ST16 yang telah dibangun oleh pihak pelanggan, dengan ketentuan sebagai berikut:
</p>

<div class="pasal-title">Pasal 1</div>
<p>
    <strong>PIHAK KESATU</strong> menyerahkan kepada <strong>PIHAK KEDUA</strong> dan <strong>PIHAK KEDUA</strong> menerima dari <strong>PIHAK KESATU</strong> sebidang tanah untuk lahan gardu beserta bangunan gardu tembok type ST16 di atasnya:
</p>
<table style="margin-left: 20px;">
    <tr>
        <td style="width: 100px;">Luas Tanah</td>
        <td style="width: 15px;">:</td>
        <td class="font-bold">{{ $luas_tanah }}</td>
    </tr>
    <tr>
        <td>Lokasi</td>
        <td>:</td>
        <td class="font-bold">{{ $lokasi }}</td>
    </tr>
</table>

<div class="pasal-title">Pasal 2</div>
<p>
    Sebidang tanah tersebut dalam pasal 1 diatas merupakan bagian dari hak milik/guna bangunan <strong>PIHAK KESATU</strong> sesuai dengan sertifikat:
</p>
<table style="margin-left: 20px;">
    <tr>
        <td style="width: 100px;">Nomor</td>
        <td style="width: 15px;">:</td>
        <td class="font-bold">{{ $nomor_sertifikat }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td>...................................</td>
    </tr>
    <tr>
        <td>Atas Nama</td>
        <td>:</td>
        <td class="font-bold">{{ strtoupper($nama_pihak_kesatu) }}</td>
    </tr>
</table>

<div class="pasal-title">Pasal 3</div>
<ol>
    <li style="margin-bottom: 10px;">Penggunaan sebidang tanah beserta bangunan gardu tembok type ST16 dari <strong>PIHAK KESATU</strong> kepada <strong>PIHAK KEDUA</strong> tersebut diatas adalah cuma-cuma, tanpa imbalan dalam bentuk apapun dan berlaku selama <strong>PIHAK KEDUA</strong> memerlukan.</li>
    <li><strong>PIHAK KEDUA</strong> berhak menggunakan sebidang tanah dan bangunan gardu tembok type ST16 tersebut untuk keperluan penyambungan baru listrik {{ $lokasi }}.</li>
</ol>


<div class="page-break"></div>
<!-- PAGE 2: BERITA ACARA LANJUTAN -->

<div class="pasal-title">Pasal 4</div>
<p>
    <strong>PIHAK KESATU</strong> menjamin <strong>PIHAK KEDUA</strong> terhadap gugatan yang akan datang dari pihak manapun selama <strong>PIHAK KEDUA</strong> menggunakan sebidang tanah dan bangunan gardu tembok tersebut.
</p>

<div class="pasal-title">Pasal 5</div>
<p>
    Jika di kemudian hari <strong>PIHAK KESATU</strong> menginginkan pemindahan/penggeseran/pembongkaran Gardu Listrik sebagaimana dimaksud Pasal 3 perjanjian ini, maka segala biaya yang timbul akibat pemindahan/penggeseran/pembongkaran Gardu Listrik tersebut sepenuhnya menjadi tanggung jawab <strong>PIHAK KESATU</strong>.
</p>

<p style="margin-top: 30px;">
    Demikian, Berita Acara Serah Terima Sebidang tanah beserta bangunan gardu tembok type ST16 di atasnya ini dibuat dan ditandatangani di Bandung pada hari, tanggal, bulan dan tahun seperti tersebut diatas dalam keadaan sadar, sehat dan tanpa paksaan dari pihak manapun, dibuat dalam rangkap 2 (dua) dan dibubuhi materai secukupnya.
</p>

<table class="signature-table">
    <tr>
        <td>
            <strong>PIHAK KEDUA</strong><br>
            Yang menerima,
            <br><br>
            @if($permohonan->ttd_ba_lingkungan)
                {{-- Gunakan TTD yang sama jika pihak kedua juga ttd di form lain, atau kosong --}}
                <br><br><br>
            @else
                <br><br><br><br>
            @endif
            <br>
            <strong><u>{{ strtoupper($nama_pihak_kedua) }}</u></strong>
        </td>
        <td>
            <strong>PIHAK KESATU</strong><br>
            Yang menyerahkan,
            <br>
            @if($permohonan->ttd_ba_lingkungan)
                <img src="{{ $permohonan->ttd_ba_lingkungan }}" class="signature-img">
            @else
                <br><br><br><br>
            @endif
            <br>
            <strong><u>{{ strtoupper($nama_pihak_kesatu) }}</u></strong>
        </td>
    </tr>
</table>


<!-- PAGE 3: GAMBAR SITUASI -->
<div class="page-break"></div>

<p style="font-size: 10pt;">
    Lampiran Berita Acara,<br>
    <span style="display:inline-block; width: 250px;"></span>PIHAK KEDUA : {{ $nomor_ba }}<br>
    <span style="display:inline-block; width: 250px;"></span>Tanggal : ...........................
</p>

<div class="title" style="margin-top: 40px; margin-bottom: 60px;">
    GAMBAR SITUASI LAHAN GARDU
</div>

<div style="height: 300px; border: 1px dashed #ccc; text-align: center; line-height: 300px; color: #999; margin-bottom: 40px;">
    (Area Gambar Denah Lokasi Lahan Gardu)
</div>

<table style="width: 100%;">
    <tr>
        <td style="width: 120px;">Sebidang Tanah</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Luas tanah</td>
        <td>:</td>
        <td class="font-bold">{{ $luas_tanah }}</td>
    </tr>
    <tr>
        <td>Lokasi</td>
        <td>:</td>
        <td class="font-bold">{{ $lokasi }}</td>
    </tr>
</table>

<p style="margin-top: 20px;">Dengan batas - batas sebagai berikut:</p>
<table style="width: 100%;">
    <tr>
        <td style="width: 150px;">1. Utara</td>
        <td style="width: 15px;">:</td>
        <td>{{ $baLingkungan['batas_utara'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>2. Timur</td>
        <td>:</td>
        <td>{{ $baLingkungan['batas_timur'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>3. Selatan</td>
        <td>:</td>
        <td>{{ $baLingkungan['batas_selatan'] ?? '-' }}</td>
    </tr>
    <tr>
        <td>4. Barat</td>
        <td>:</td>
        <td>{{ $baLingkungan['batas_barat'] ?? '-' }}</td>
    </tr>
</table>

<table class="signature-table" style="margin-top: 50px;">
    <tr>
        <td>
            <strong>PIHAK KEDUA</strong><br>
            YANG MENERIMA
            <br><br>
            @if($permohonan->ttd_ba_lingkungan)
                <br><br><br>
            @else
                <br><br><br><br>
            @endif
            <br>
            <strong><u>{{ strtoupper($nama_pihak_kedua) }}</u></strong>
        </td>
        <td>
            <strong>PIHAK KESATU</strong><br>
            YANG MENYERAHKAN
            <br>
            @if($permohonan->ttd_ba_lingkungan)
                <img src="{{ $permohonan->ttd_ba_lingkungan }}" class="signature-img">
            @else
                <br><br><br><br>
            @endif
            <br>
            <strong><u>{{ strtoupper($nama_pihak_kesatu) }}</u></strong>
        </td>
    </tr>
</table>

</body>
</html>
