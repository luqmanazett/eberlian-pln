<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PermohonanExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $jenis;
    
    public function __construct($startDate = null, $endDate = null, $status = null, $jenis = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
        $this->jenis = $jenis;
    }
    
    public function query()
    {
        $query = Permohonan::query()->with('user');
        
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal_upload', [$this->startDate, $this->endDate]);
        }
        
        if ($this->status && $this->status != '') {
            $query->where('status', $this->status);
        }
        
        if ($this->jenis && $this->jenis != '') {
            $query->where('jenis_permohonan', $this->jenis);
        }
        
        return $query->orderBy('tanggal_upload', 'desc');
    }
    
    public function headings(): array
    {
        return [
            'No',
            'ID Register',
            'Tanggal Upload',
            'Jenis Permohonan',
            'IDPEL',
            'No KTP',
            'Nama Pelanggan',
            'ULP',
            'Alamat Gardu',
            'Nama Gardu',
            'No Telepon',
            'Status',
            'Jumlah Perbaikan',
            'Tanggal Approve',
            'Tanggal Reject',
            'Catatan Admin',
            'User (Email)',
            // BA Lingkungan (Penilaian Dampak) - stored in ba_lahan_data
            'Tipe BA Lingkungan',
            'Unit PLN (BA Lingkungan)',
            'Nama Pekerjaan (BA Lingkungan)',
            'Desa/Kelurahan (BA Lingkungan)',
            'Kecamatan (BA Lingkungan)',
            'Kabupaten/Kota (BA Lingkungan)',
            'Nama Pemilik (BA Lingkungan)',
            'No Telepon Pemilik (BA Lingkungan)',
            'Alamat Pemilik (BA Lingkungan)',
            'Status Pemilik (BA Lingkungan)',
            'Dampak >= 200 org (BA Lingkungan)',
            'Dampak Pendapatan >10% (BA Lingkungan)',
            'Lahan Masyarakat Adat (BA Lingkungan)',
            'Dampak Negatif Masy Adat (BA Lingkungan)',
            // BA Lahan (Serah Terima Gardu) - stored in ba_lingkungan_data
            'Tipe BA Lahan',
            'Nomor BA Lahan',
            'Nama Pihak Kesatu',
            'Jabatan Pihak Kesatu',
            'Nama Pihak Kedua (PLN)',
            'Luas Tanah (BA Lahan)',
            'Lokasi (BA Lahan)',
            'Nomor Sertifikat (BA Lahan)',
            'Batas Utara',
            'Batas Timur',
            'Batas Selatan',
            'Batas Barat',
        ];
    }
    
    public function map($permohonan): array
    {
        static $no = 1;
        
        $row = [
            $no++,
            $permohonan->id_register ?? ('PMH-' . $permohonan->id),
            $permohonan->tanggal_upload ? $permohonan->tanggal_upload->format('d/m/Y H:i') : '-',
            ucwords(str_replace('_', ' ', $permohonan->jenis_permohonan)),
            $permohonan->idpel ?? '-',
            $permohonan->no_ktp,
            $permohonan->nama_pelanggan,
            $permohonan->ulp,
            $permohonan->alamat_gardu,
            $permohonan->nama_gardu,
            $permohonan->no_telepon,
            ucfirst($permohonan->status),
            $permohonan->jumlah_perbaikan,
            $permohonan->approved_at ? $permohonan->approved_at->format('d/m/Y H:i') : '-',
            $permohonan->rejected_at ? $permohonan->rejected_at->format('d/m/Y H:i') : '-',
            $permohonan->catatan_admin ?? '-',
            $permohonan->user->email ?? '-',
        ];
        
        // BA Lahan
        $baLahanType = $permohonan->ba_lahan_type == 'form' ? 'Form Isian' : ($permohonan->ba_lahan_type == 'upload' ? 'Upload File' : '-');
        $baLahanData = $permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data ? json_decode($permohonan->ba_lahan_data, true) : [];
        
        $row[] = $baLahanType;
        $row[] = $baLahanData['unit_pln'] ?? '-';
        $row[] = $baLahanData['nama_pekerjaan'] ?? '-';
        $row[] = $baLahanData['desa_kelurahan'] ?? '-';
        $row[] = $baLahanData['kecamatan'] ?? '-';
        $row[] = $baLahanData['kabupaten_kota'] ?? '-';
        $row[] = $baLahanData['nama_pemilik'] ?? '-';
        $row[] = $baLahanData['no_telepon_pemilik'] ?? '-';
        $row[] = $baLahanData['alamat_pemilik'] ?? '-';
        $row[] = $baLahanData['status_pemilik'] ?? '-';
        $row[] = !empty($baLahanData['pernyataan_1']) ? 'Ya' : 'Tidak';
        $row[] = !empty($baLahanData['pernyataan_2']) ? 'Ya' : 'Tidak';
        $row[] = !empty($baLahanData['pernyataan_3']) ? 'Ya' : 'Tidak';
        $row[] = !empty($baLahanData['pernyataan_4']) ? 'Ya' : 'Tidak';
        
        // BA Lingkungan
        $baLingType = $permohonan->ba_lingkungan_type == 'form' ? 'Form Isian' : ($permohonan->ba_lingkungan_type == 'upload' ? 'Upload File' : '-');
        $baLingData = $permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data ? json_decode($permohonan->ba_lingkungan_data, true) : [];
        
        $row[] = $baLingType;
        $row[] = $baLingData['nomor_ba'] ?? '-';
        $row[] = $baLingData['nama_pihak_kesatu'] ?? '-';
        $row[] = $baLingData['jabatan_pihak_kesatu'] ?? '-';
        $row[] = $baLingData['nama_pihak_kedua'] ?? '-';
        $row[] = $baLingData['luas_tanah'] ?? '-';
        $row[] = $baLingData['lokasi'] ?? '-';
        $row[] = $baLingData['nomor_sertifikat'] ?? '-';
        $row[] = $baLingData['batas_utara'] ?? '-';
        $row[] = $baLingData['batas_timur'] ?? '-';
        $row[] = $baLingData['batas_selatan'] ?? '-';
        $row[] = $baLingData['batas_barat'] ?? '-';
        
        return $row;
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}