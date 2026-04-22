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
            'ID Permohonan',
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
        ];
    }
    
    public function map($permohonan): array
    {
        static $no = 1;
        
        return [
            $no++,
            '#' . str_pad($permohonan->id, 11, '0', STR_PAD_LEFT),
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
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}