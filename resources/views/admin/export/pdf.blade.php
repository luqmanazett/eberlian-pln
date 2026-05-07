<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Permohonan SIPEL PLN</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .page-break { page-break-after: always; }
        .header { text-align: center; border-bottom: 2px solid #008080; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { color: #008080; margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 12px; }
        
        .section-title { font-size: 14px; font-weight: bold; background-color: #f0fdfa; color: #008080; padding: 6px 10px; border-left: 4px solid #008080; margin: 15px 0 10px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px 10px; text-align: left; vertical-align: top; }
        th { background-color: #f9fafb; width: 35%; font-weight: bold; color: #4b5563; }
        td { width: 65%; }
        
        .status-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-approved { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        
        .info-header { text-align: right; font-size: 10px; color: #9ca3af; margin-bottom: -15px; }
        
        .ttd-box { border: 1px solid #e5e7eb; padding: 10px; text-align: center; width: 200px; display: inline-block; margin-right: 20px; }
        .ttd-box img { max-width: 150px; max-height: 80px; }
        .ttd-box p { margin: 5px 0 0 0; font-size: 10px; font-weight: bold; }
    </style>
</head>
<body>
    @if(count($permohonans) == 0)
        <div class="header">
            <h2>DATA PERMOHONAN SIPEL PLN</h2>
            <p>Tidak ada data permohonan pada filter ini.</p>
        </div>
    @endif

    @foreach($permohonans as $index => $p)
        <div class="info-header">Dicetak: {{ now()->format('d/m/Y H:i') }} | Hal. {{ $index + 1 }}/{{ count($permohonans) }}</div>
        
        <div class="header">
            <h2>DETAIL PERMOHONAN SIPEL PLN</h2>
            <p>ID Register: <strong>{{ $p->id_register ?? ('PMH-' . $p->id) }}</strong> | Tanggal: {{ $p->tanggal_upload ? $p->tanggal_upload->format('d M Y H:i') : '-' }}</p>
        </div>

        <div class="section-title">Informasi Pelanggan</div>
        <table>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $p->nama_pelanggan }}</td>
            </tr>
            <tr>
                <th>No KTP</th>
                <td>{{ $p->no_ktp }}</td>
            </tr>
            <tr>
                <th>Jenis Permohonan</th>
                <td>{{ ucwords(str_replace('_', ' ', $p->jenis_permohonan)) }}</td>
            </tr>
            <tr>
                <th>IDPEL</th>
                <td>{{ $p->idpel ?? '-' }}</td>
            </tr>
            <tr>
                <th>No Telepon</th>
                <td>{{ $p->no_telepon }}</td>
            </tr>
            <tr>
                <th>ULP / Unit PLN</th>
                <td>{{ $p->ulp }}</td>
            </tr>
            <tr>
                <th>Nama Gardu</th>
                <td>{{ $p->nama_gardu }}</td>
            </tr>
            <tr>
                <th>Alamat Gardu</th>
                <td>{{ $p->alamat_gardu }}</td>
            </tr>
            <tr>
                <th>Status Verifikasi</th>
                <td>
                    <span class="status-badge status-{{ $p->status }}">
                        {{ $p->status == 'pending' ? 'Menunggu' : ($p->status == 'approved' ? 'Disetujui' : 'Ditolak') }}
                    </span>
                    @if($p->catatan_admin)
                        <br><small style="color: #666; margin-top: 4px; display: block;">Catatan Admin: {{ $p->catatan_admin }}</small>
                    @endif
                </td>
            </tr>
        </table>

        {{-- BA Lahan --}}
        <div class="section-title">Berita Acara Lahan</div>
        @if($p->ba_lahan_type == 'form' && $p->ba_lahan_data)
            @php $baLahan = json_decode($p->ba_lahan_data, true); @endphp
            <table>
                <tr><th>Unit PLN</th><td>{{ $baLahan['unit_pln'] ?? '-' }}</td></tr>
                <tr><th>Nama Pekerjaan</th><td>{{ $baLahan['nama_pekerjaan'] ?? '-' }}</td></tr>
                <tr><th>Desa/Kelurahan</th><td>{{ $baLahan['desa_kelurahan'] ?? '-' }}</td></tr>
                <tr><th>Kecamatan</th><td>{{ $baLahan['kecamatan'] ?? '-' }}</td></tr>
                <tr><th>Kabupaten/Kota</th><td>{{ $baLahan['kabupaten_kota'] ?? '-' }}</td></tr>
                <tr><th>Nama Pemilik Lahan</th><td>{{ $baLahan['nama_pemilik'] ?? '-' }}</td></tr>
                <tr><th>No Telepon Pemilik</th><td>{{ $baLahan['no_telepon_pemilik'] ?? '-' }}</td></tr>
                <tr><th>Alamat Pemilik</th><td>{{ $baLahan['alamat_pemilik'] ?? '-' }}</td></tr>
                <tr><th>Status Kepemilikan</th><td>{{ $baLahan['status_pemilik'] ?? '-' }}</td></tr>
                <tr>
                    <th>Pernyataan Kesesuaian Sosial</th>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            <li>Berdampak >= 200 orang: <strong>{{ !empty($baLahan['pernyataan_1']) ? 'Ya' : 'Tidak' }}</strong></li>
                            <li>Dampak Penurunan Pendapatan >10%: <strong>{{ !empty($baLahan['pernyataan_2']) ? 'Ya' : 'Tidak' }}</strong></li>
                            <li>Lokasi di Lahan Masyarakat Adat: <strong>{{ !empty($baLahan['pernyataan_3']) ? 'Ya' : 'Tidak' }}</strong></li>
                            <li>Dampak Negatif ke Masyarakat Adat: <strong>{{ !empty($baLahan['pernyataan_4']) ? 'Ya' : 'Tidak' }}</strong></li>
                        </ul>
                    </td>
                </tr>
            </table>
        @elseif($p->ba_lahan_type == 'upload')
            <table>
                <tr>
                    <td colspan="2" style="text-align: center; color: #666;">
                        <em>Dokumen BA Lahan diunggah dalam bentuk lampiran terpisah (Upload File).</em>
                    </td>
                </tr>
            </table>
        @else
            <table>
                <tr><td colspan="2" style="text-align: center; color: #666;"><em>Data BA Lahan tidak tersedia.</em></td></tr>
            </table>
        @endif

        {{-- BA Lingkungan --}}
        <div class="section-title">Berita Acara Lingkungan</div>
        @if($p->ba_lingkungan_type == 'form' && $p->ba_lingkungan_data)
            @php $baLingkungan = json_decode($p->ba_lingkungan_data, true); @endphp
            <table>
                <tr><th>Nomor BA</th><td>{{ $baLingkungan['nomor_ba'] ?? '-' }}</td></tr>
                <tr><th>Pihak Kesatu (Nama)</th><td>{{ $baLingkungan['nama_pihak_kesatu'] ?? '-' }}</td></tr>
                <tr><th>Pihak Kesatu (Jabatan)</th><td>{{ $baLingkungan['jabatan_pihak_kesatu'] ?? '-' }}</td></tr>
                <tr><th>Pihak Kedua (PLN)</th><td>{{ $baLingkungan['nama_pihak_kedua'] ?? '-' }}</td></tr>
                <tr><th>Luas Tanah</th><td>{{ $baLingkungan['luas_tanah'] ?? '-' }}</td></tr>
                <tr><th>Lokasi</th><td>{{ $baLingkungan['lokasi'] ?? '-' }}</td></tr>
                <tr><th>Nomor Sertifikat</th><td>{{ $baLingkungan['nomor_sertifikat'] ?? '-' }}</td></tr>
                <tr>
                    <th>Batas Lahan</th>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            <li>Utara: {{ $baLingkungan['batas_utara'] ?? '-' }}</li>
                            <li>Timur: {{ $baLingkungan['batas_timur'] ?? '-' }}</li>
                            <li>Selatan: {{ $baLingkungan['batas_selatan'] ?? '-' }}</li>
                            <li>Barat: {{ $baLingkungan['batas_barat'] ?? '-' }}</li>
                        </ul>
                    </td>
                </tr>
            </table>
        @elseif($p->ba_lingkungan_type == 'upload')
            <table>
                <tr>
                    <td colspan="2" style="text-align: center; color: #666;">
                        <em>Dokumen BA Lingkungan diunggah dalam bentuk lampiran terpisah (Upload File).</em>
                    </td>
                </tr>
            </table>
        @else
            <table>
                <tr><td colspan="2" style="text-align: center; color: #666;"><em>Data BA Lingkungan tidak tersedia.</em></td></tr>
            </table>
        @endif

        {{-- Tanda Tangan Elektronik --}}
        @if($p->ba_lahan_type == 'form' || $p->ba_lingkungan_type == 'form')
        <div style="margin-top: 20px;">
            @if($p->ba_lahan_type == 'form' && $p->ttd_ba_lahan)
            <div class="ttd-box">
                <img src="{{ $p->ttd_ba_lahan }}" alt="TTD BA Lahan">
                <p>Tanda Tangan BA Lahan</p>
            </div>
            @endif
            
            @if($p->ba_lingkungan_type == 'form' && $p->ttd_ba_lingkungan)
            <div class="ttd-box">
                <img src="{{ $p->ttd_ba_lingkungan }}" alt="TTD BA Lingkungan">
                <p>Tanda Tangan BA Lingkungan</p>
            </div>
            @endif
        </div>
        @endif

        {{-- Page Break jika bukan halaman terakhir --}}
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
        
    @endforeach
</body>
</html>
