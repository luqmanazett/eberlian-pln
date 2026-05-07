<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Penilaian Dampak - SIPEL PLN</title>
    <style>
        @page {
            margin: 2.5cm;
        }
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11pt; 
            line-height: 1.5;
            color: #000;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .title {
            font-size: 12pt;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            color: #006699;
            margin-bottom: 25px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px;}
        td { vertical-align: top; padding: 2px 0;}
        .col-label { width: 150px; }
        .col-colon { width: 15px; }
        .col-value { border-bottom: 1px solid #000; display: inline-block; width: 100%; }
        
        .signature-table {
            width: 100%;
            margin-top: 40px;
        }
        .signature-table td {
            width: 50%;
            vertical-align: bottom;
        }
        .signature-img {
            height: 80px;
            object-fit: contain;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .strike { text-decoration: line-through; }
        ol { margin-top: 5px; padding-left: 20px; }
        ol li { margin-bottom: 8px; text-align: justify; }
        .small-italic { font-size: 9pt; font-style: italic; }
    </style>
</head>
<body>

@php
    $data = [];
    if($permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data) {
        $data = json_decode($permohonan->ba_lahan_data, true);
    }
    
    // Carbon for dates
    $tanggal_sekarang = \Carbon\Carbon::now()->locale('id');
    $hari = $tanggal_sekarang->translatedFormat('l');
    $tgl_angka = $tanggal_sekarang->format('d');
    $bulan = $tanggal_sekarang->translatedFormat('F');
    $tahun_angka = $tanggal_sekarang->format('Y');
    
    $tanggal_lengkap = "$tgl_angka $bulan $tahun_angka";
@endphp

<div class="title">
    Template Berita Acara Penilaian Dampak Terhadap Pekerjaan Jaringan Distribusi<br>
    (Perluasan/Rehabilitasi)
</div>

<p style="text-align: justify;">
    Bahwa pada tanggal <strong>{{ $tanggal_lengkap }}</strong> telah dilakukan konsultasi dan penilaian dari pekerjaan distribusi dengan <em>pemilik lahan/masyarakat terdampak/perwakilan pemilik lahan/pemerintah desa/kelurahan*</em>.<br>
    Dengan penjelasan sebagai berikut:
</p>

<table>
    <tr>
        <td class="col-label">Unit PLN</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ strtoupper($data['unit_pln'] ?? '........................................') }}</span></td>
    </tr>
    <tr>
        <td class="col-label">Nama Pekerjaan</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ strtoupper($data['nama_pekerjaan'] ?? '........................................') }}</span></td>
    </tr>
    <tr>
        <td class="col-label">Tanggal Rilis BASTP</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">........................................</span></td>
    </tr>
    <tr>
        <td class="col-label">Desa/Kelurahan</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ ucwords($data['desa_kelurahan'] ?? '........................................') }}</span></td>
    </tr>
    <tr>
        <td class="col-label">Kecamatan</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ ucwords($data['kecamatan'] ?? '........................................') }}</span></td>
    </tr>
    <tr>
        <td class="col-label">Kabupaten/Kota</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ ucwords($data['kabupaten_kota'] ?? '........................................') }}</span></td>
    </tr>
</table>

<p style="text-align: justify; margin-top: 15px;">
    Sehubungan dengan Pekerjaan Distribusi oleh PT PLN (persero), maka dengan surat ini:
</p>

<table>
    <tr>
        <td class="col-label">Nama</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ strtoupper($data['nama_pemilik'] ?? '........................................') }}</span></td>
    </tr>
    <tr>
        <td class="col-label">No Telepon</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ $data['no_telepon_pemilik'] ?? '........................................' }}</span></td>
    </tr>
    <tr>
        <td class="col-label">Alamat</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ ucwords($data['alamat_pemilik'] ?? '........................................') }}</span></td>
    </tr>
    <tr>
        <td class="col-label">Status</td>
        <td class="col-colon">:</td>
        <td><span class="font-bold">{{ ucwords($data['status_pemilik'] ?? '........................................') }}</span></td>
    </tr>
</table>

<p style="text-align: justify; margin-top: 15px;">
    Menyatakan bahwa Pekerjaan Distribusi yang dibangun di lahan tersebut (<span class="small-italic">*dicoret yang tidak sesuai</span>):
</p>

@php
    $p1_yes = !empty($data['pernyataan_1']);
    $p2_yes = !empty($data['pernyataan_2']);
    $p3_yes = !empty($data['pernyataan_3']);
    $p4_yes = !empty($data['pernyataan_4']);
@endphp

<ol>
    <li>
        <span class="{{ !$p1_yes ? 'strike' : '' }}">Berdampak terhadap 200 orang atau lebih</span> / 
        <span class="{{ $p1_yes ? 'strike' : '' }}">Tidak berdampak terhadap 200 orang atau lebih.</span>
    </li>
    <li>
        <span class="{{ !$p2_yes ? 'strike' : '' }}">Berdampak terhadap berkurangnya pendapatan lebih dari 10%</span> / 
        <span class="{{ $p2_yes ? 'strike' : '' }}">Tidak berdampak terhadap berkurangnya pendapatan lebih dari 10%.</span>
    </li>
    <li>
        <span class="{{ !$p3_yes ? 'strike' : '' }}">Berlokasi di lahan/wilayah masyarakat adat</span> / 
        <span class="{{ $p3_yes ? 'strike' : '' }}">Tidak berlokasi di lahan/wilayah masyarakat adat.</span>
    </li>
    <li>
        <span class="{{ !$p4_yes ? 'strike' : '' }}">Berdampak negatif terhadap masyarakat adat</span> / 
        <span class="{{ $p4_yes ? 'strike' : '' }}">Tidak Berdampak negatif terhadap masyarakat adat.</span>
    </li>
</ol>

<p style="text-align: justify; margin-top: 15px;">
    Demikian pernyataan ini dibuat untuk dipergunakan sebaik-baiknya.
</p>

<div style="margin-top: 15px;">
    Tempat: <strong>{{ ucwords($data['kabupaten_kota'] ?? '....................') }}</strong> ; Tanggal: <strong>{{ $tanggal_lengkap }}</strong>
</div>

<table class="signature-table">
    <tr>
        <td style="width: 50%;">
            Unit PLN <strong>{{ strtoupper($data['unit_pln'] ?? '..................') }}</strong>
            <br><br><br><br><br>
            Nama: ........................................<br>
            NIP: ........................................
        </td>
        <td style="width: 50%; padding-left: 20px;">
            <span class="small-italic">
            Pemilik lahan/<br>
            Masyarakat terdampak/<br>
            Perwakilan pemilik lahan/<br>
            Pemerintah desa/kelurahan
            </span>
            <br>
            @if($permohonan->ttd_ba_lahan)
                <img src="{{ $permohonan->ttd_ba_lahan }}" class="signature-img">
            @else
                <br><br><br><br>
            @endif
            <br>
            Nama: <strong>{{ strtoupper($data['nama_pemilik'] ?? '........................................') }}</strong>
        </td>
    </tr>
</table>

<div style="margin-top: 30px; border-top: 1px solid #ccc; padding-top: 5px;" class="small-italic">
    * Dicoret yang tidak sesuai
</div>

</body>
</html>
