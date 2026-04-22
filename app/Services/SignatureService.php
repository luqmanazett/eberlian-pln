<?php

namespace App\Services;

use setasign\Fpdi\Tcpdf\Fpdi;

class SignatureService
{
    /**
     * Merge tanda tangan ke PDF
     */
    public function mergeSignatureToPdf($originalPdfPath, $signatureDataUrl, $outputPath)
    {
        // Simpan gambar tanda tangan dari base64
        $signatureImage = $this->saveSignatureImage($signatureDataUrl);
        
        if (!$signatureImage) {
            throw new \Exception('Gagal menyimpan gambar tanda tangan');
        }
        
        try {
            $pdf = new Fpdi();
            
            // Load PDF asli
            $pageCount = $pdf->setSourceFile($originalPdfPath);
            
            // Proses setiap halaman
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $template = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($template);
                
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($template);
                
                // Tambahkan tanda tangan di halaman TERAKHIR saja
                if ($pageNo == $pageCount) {
                    // Posisi: Kanan bawah
                    $signatureWidth = 60;   // mm
                    $signatureHeight = 25;  // mm
                    
                    // Koordinat X: dari kanan
                    $x = $size['width'] - $signatureWidth - 15;
                    // Koordinat Y: dari bawah
                    $y = $size['height'] - $signatureHeight - 20;
                    
                    $pdf->Image($signatureImage, $x, $y, $signatureWidth, $signatureHeight);
                }
            }
            
            // Pastikan folder output ada
            $outputDir = dirname($outputPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }
            
            // Simpan PDF hasil merge
            $pdf->Output($outputPath, 'F');
            
            // Hapus file temporary
            @unlink($signatureImage);
            
            return true;
            
        } catch (\Exception $e) {
            @unlink($signatureImage);
            throw $e;
        }
    }
    
    /**
     * Simpan gambar dari base64 data URL
     */
    private function saveSignatureImage($dataUrl)
    {
        // Validasi format data URL
        if (!preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $matches)) {
            return false;
        }
        
        $imageType = $matches[1];
        $base64Data = substr($dataUrl, strpos($dataUrl, ',') + 1);
        $imageData = base64_decode($base64Data);
        
        if (!$imageData) {
            return false;
        }
        
        // Buat folder temp jika belum ada
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        $tempPath = $tempDir . '/signature_' . uniqid() . '.' . $imageType;
        file_put_contents($tempPath, $imageData);
        
        return $tempPath;
    }
    
    /**
     * Cek apakah file adalah PDF
     */
    public function isPdf($filePath)
    {
        $mime = mime_content_type($filePath);
        return $mime === 'application/pdf';
    }
}