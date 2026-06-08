@extends('components.pln-layout')

@section('title', 'Detail Permohonan - SIPEL PLN')
@section('header-title', 'Detail Permohonan')

@section('content')
<div class="space-y-4 ">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ url()->previous() }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Detail Permohonan</h2>
    </div>
    
    {{-- VISUAL TRACKER (STATUS PERJALANAN DOKUMEN) --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-4 overflow-hidden">
        <h3 class="font-bold text-gray-800 mb-6 text-center text-sm uppercase tracking-wider">Perjalanan Dokumen</h3>
        
        <div class="relative max-w-md mx-auto isolate">
            {{-- Background Line --}}
            <div class="absolute left-[16%] right-[16%] top-5 h-1.5 bg-gray-200 -z-10 transform -translate-y-1/2 rounded-full"></div>
            
            {{-- Active Line --}}
            @php
                $lineWidth = '0%';
                $lineColor = '#14b8a6'; /* teal-500 */
                if ($permohonan->status == 'pending') $lineWidth = '34%';
                elseif ($permohonan->status == 'approved') { $lineWidth = '68%'; $lineColor = '#14b8a6'; }
                elseif ($permohonan->status == 'rejected' || $permohonan->status == 'cancelled') { $lineWidth = '68%'; $lineColor = '#ef4444'; }
            @endphp
            <div class="absolute left-[16%] top-5 h-1.5 transition-all duration-1000 ease-out -z-10 transform -translate-y-1/2 rounded-full" style="width: {{ $lineWidth }}; background-color: {{ $lineColor }};"></div>
            
            <div class="flex justify-between items-start relative z-10">
                
                {{-- Node 1: Diajukan --}}
                <div class="flex flex-col items-center w-1/3">
                    <div class="w-10 h-10 rounded-full text-white flex items-center justify-center border-[3px] border-white shadow-md z-10" style="background-color: #14b8a6;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-[11px] font-bold text-gray-800 mt-2">Diajukan</span>
                    <span class="text-[9px] text-gray-500 mt-0.5 text-center">{{ $permohonan->created_at->format('d M y') }}</span>
                </div>
                
                {{-- Node 2: Proses --}}
                <div class="flex flex-col items-center w-1/3">
                    @if($permohonan->status == 'pending')
                        <div class="relative">
                            <div class="absolute inset-0 rounded-full animate-ping opacity-75" style="background-color: #facc15;"></div>
                            <div class="relative w-10 h-10 rounded-full text-white flex items-center justify-center border-[3px] border-white shadow-md z-10" style="background-color: #facc15;">
                                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold mt-2" style="color: #ca8a04;">Diproses</span>
                    @elseif($permohonan->status == 'approved' || $permohonan->status == 'rejected' || $permohonan->status == 'cancelled')
                        <div class="w-10 h-10 rounded-full text-white flex items-center justify-center border-[3px] border-white shadow-md z-10" style="background-color: #14b8a6;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[11px] font-bold text-gray-800 mt-2">Diproses</span>
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center border-[3px] border-white shadow-md z-10">
                            <span class="text-xl -mt-1">⋯</span>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400 mt-2">Diproses</span>
                    @endif
                </div>
                
                {{-- Node 3: Selesai --}}
                <div class="flex flex-col items-center w-1/3">
                    @if($permohonan->status == 'approved')
                        <div class="relative">
                            <div class="absolute inset-0 rounded-full animate-ping opacity-25" style="background-color: #14b8a6;"></div>
                            <div class="relative w-10 h-10 rounded-full text-white flex items-center justify-center border-[3px] border-white shadow-md z-10" style="background-color: #14b8a6;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold mt-2" style="color: #0d9488;">Disetujui</span>
                        <span class="text-[9px] text-gray-500 mt-0.5 text-center">{{ $permohonan->updated_at->format('d M y') }}</span>
                    @elseif($permohonan->status == 'rejected' || $permohonan->status == 'cancelled')
                        <div class="w-10 h-10 rounded-full text-white flex items-center justify-center border-[3px] border-white shadow-md z-10" style="background-color: #ef4444;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                        <span class="text-[11px] font-bold mt-2" style="color: #dc2626;">{{ $permohonan->status == 'cancelled' ? 'Dibatalkan' : 'Ditolak' }}</span>
                        <span class="text-[9px] text-gray-500 mt-0.5 text-center">{{ $permohonan->updated_at->format('d M y') }}</span>
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center border-[3px] border-white shadow-md z-10">
                        </div>
                        <span class="text-[11px] font-bold text-gray-400 mt-2">Selesai</span>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
    
    {{-- Status Card --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800">
                ID Register: {{ $permohonan->id_register ?? ('PMH-' . $permohonan->id) }}
            </h3>
            @if($permohonan->status == 'pending')
                @if($permohonan->locked_by && $permohonan->locked_at && $permohonan->locked_at->diffInMinutes(now()) < 3)
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full border border-orange-200 whitespace-nowrap flex-shrink-0">Sedang Diverifikasi</span>
                @else
                    <span class="badge badge-pending">Menunggu</span>
                @endif
            @elseif($permohonan->status == 'approved')
            <span class="badge badge-approved">Disetujui</span>
            @elseif($permohonan->status == 'cancelled')
            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full border border-gray-200">Dibatalkan</span>
            @else
            <span class="badge badge-rejected">Ditolak</span>
            @endif
        </div>
        
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Jenis Permohonan</span>
                <span class="font-medium">
                    @if($permohonan->jenis_permohonan == 'pasang_baru') Pasang Baru
                    @elseif($permohonan->jenis_permohonan == 'tambah_daya') Tambah Daya
                    @else Peningkatan Keandalan @endif
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Nama Pelanggan</span>
                <span class="font-medium">{{ $permohonan->nama_pelanggan }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">No KTP</span>
                <span class="font-medium">{{ $permohonan->no_ktp }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">ID Register</span>
                <span class="font-medium">{{ $permohonan->id_register ?? ('PMH-' . $permohonan->id) }}</span>
            </div>
            @if($permohonan->idpel)
            <div class="flex justify-between">
                <span class="text-gray-500">IDPEL</span>
                <span class="font-medium">{{ $permohonan->idpel }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span class="text-gray-500">ULP</span>
                <span class="font-medium">{{ $permohonan->ulp }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Pengajuan</span>
                <span class="font-medium">{{ $permohonan->created_at->format('d M Y - H:i') }}</span>
            </div>
        </div>
    </div>
    

    
   {{-- Alasan Penolakan (Jika ditolak) --}}
@if($permohonan->status == 'rejected')
<div class="bg-red-50 rounded-xl p-4 border border-red-200">
    <h4 class="font-bold text-red-800 mb-2">📋 Catatan Penolakan</h4>
    
    @if($permohonan->catatan_reject_global)
    <p class="text-sm text-red-700 font-medium">{{ $permohonan->catatan_reject_global }}</p>
    @else
    <p class="text-sm text-red-700 font-medium italic">Silakan perbaiki dokumen yang ditolak di bawah ini.</p>
    @endif
    
    {{-- Detail dokumen yang ditolak --}}
    @if($permohonan->detailPenolakan->where('ditolak', true)->count() > 0)
    <div class="mt-3 pt-3 border-t border-red-200">
        <p class="font-medium text-red-800 mb-2">Dokumen yang perlu diperbaiki:</p>
        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach($permohonan->detailPenolakan->where('ditolak', true) as $detail)
            <li>
                <span class="font-medium">{{ \App\Models\DetailPenolakan::getDokumenLabels()[$detail->dokumen_type] ?? $detail->dokumen_type }}</span>
                @if($detail->alasan_penolakan)
                <br><span class="text-xs text-red-600 ml-5">Alasan: {{ $detail->alasan_penolakan }}</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endif

    {{-- Dokumen Permohonan --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">Dokumen yang Diunggah</h3>
        <div class="space-y-3">
            @foreach([
                'ba_lahan' => 'BA Lingkungan (Penilaian Dampak)',
                'ba_lingkungan' => 'BA Lahan (Serah Terima Gardu)',
                'return_agrimen' => 'Written Agreement',
                'imb' => 'IMB',
                'sertifikat_lahan' => 'Sertifikat Lahan'
            ] as $key => $label)
                @php 
                    $hasFile = !empty($permohonan->{'dokumen_' . $key});
                    $isForm = ($permohonan->{$key . '_type'} == 'form' && !empty($permohonan->{$key . '_data'}));
                @endphp
                
                @if($hasFile || $isForm)
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                        @if($isForm)
                            <span class="text-[10px] text-gray-400 mt-0.5">Disubmit melalui Form Isian</span>
                        @else
                            <span class="text-[10px] text-gray-400 mt-0.5">File Upload</span>
                        @endif
                    </div>
                    
                    @if($isForm)
                        <button type="button" onclick="showFormDetail('{{ $key }}')" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-blue-500 hover:text-white hover:border-blue-500 transition group flex-shrink-0" title="Lihat Data">
                            <svg class="w-4 h-4 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    @else
                        <button type="button" onclick="openLightbox('{{ asset('storage/' . $permohonan->{'dokumen_' . $key}) }}')" class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-teal-500 hover:text-white hover:border-teal-500 transition group flex-shrink-0" title="Lihat File">
                            <svg class="w-4 h-4 text-teal-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    @endif
                </div>
                
                {{-- Form Detail Container (Hidden by default) --}}
                @if($isForm)
                <div id="formDetail_{{ $key }}" style="display: none;" class="mt-2 p-4 bg-gray-50 rounded-xl text-sm space-y-2 border border-gray-100 shadow-inner">
                    @php $data = json_decode($permohonan->{$key . '_data'}, true); @endphp
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($data as $field => $val)
                            @if(is_string($val) && $field != 'ttd_data')
                            <div>
                                <span class="text-[10px] text-gray-400 uppercase tracking-wide">{{ str_replace('_', ' ', $field) }}</span>
                                <p class="font-medium text-gray-800 text-sm mt-0.5">{{ $val ?: '-' }}</p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
                
                @endif
            @endforeach
            
            @if(!$permohonan->dokumen_ba_lahan && !$permohonan->dokumen_ba_lingkungan && !$permohonan->dokumen_return_agrimen && !$permohonan->dokumen_imb && !$permohonan->dokumen_sertifikat_lahan && $permohonan->ba_lahan_type != 'form' && $permohonan->ba_lingkungan_type != 'form')
            <div class="text-center py-4">
                <p class="text-sm text-gray-400">Tidak ada file atau form yang diisi.</p>
            </div>
            @endif
        </div>
    </div>
    
    {{-- Tombol Upload Ulang (Jika ditolak dan masih bisa) --}}
    @if($permohonan->status == 'rejected' && $permohonan->canUploadUlang())
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <a href="{{ route('user.upload-ulang', $permohonan->id) }}" class="btn btn-primary">
            📤 Upload Ulang Dokumen
        </a>
        <p class="text-xs text-gray-500 mt-2 text-center">
            Batas waktu: {{ $permohonan->tanggal_reject->addHours(24)->format('d M Y H:i') }}
            (Sisa {{ $permohonan->tanggal_reject->addHours(24)->diffForHumans() }})
        </p>
    </div>
    @endif
    
    {{-- Tombol Batalkan (Jika status masih pending) --}}
    @if($permohonan->status == 'pending')
        <form id="cancelForm" action="{{ route('user.permohonan.cancel', $permohonan->id) }}" method="POST">
            @csrf
            <button type="button" onclick="openCancelModal()" class="w-full bg-white text-red-600 font-semibold py-3 rounded-xl border border-red-200 hover:bg-red-50 transition-colors shadow-sm flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Batalkan Permohonan
            </button>
        </form>
    @endif

    {{-- Info jika sudah tidak bisa upload ulang --}}
    @if($permohonan->status == 'rejected' && !$permohonan->canUploadUlang())
    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
        <p class="text-yellow-800 text-sm">
            @if($permohonan->jumlah_perbaikan >= 3)
            ⚠️ Anda sudah mencapai batas maksimal 3 kali upload ulang. Silakan hubungi petugas PLN.
            @else
            ⚠️ Batas waktu 24 jam untuk upload ulang sudah habis. Silakan hubungi petugas PLN.
            @endif
        </p>
    </div>
    @endif
    
    {{-- Catatan Admin (Jika disetujui) --}}
    @if($permohonan->status == 'approved' && $permohonan->catatan_admin)
    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
        <h4 class="font-semibold text-green-800 mb-2">Catatan Admin</h4>
        <p class="text-sm text-green-700">{{ $permohonan->catatan_admin }}</p>
    </div>
    @endif
    
    {{-- Tombol Kembali --}}
    <div class="pt-4">
        <a href="{{ route('user.permohonan.history') }}" class="btn btn-outline">
            ← Kembali ke Riwayat
        </a>
    </div>
    
</div>

{{-- MODAL KONFIRMASI BATAL --}}
<div id="cancelModal" class="fixed inset-0 z-[9999] hidden items-center justify-center px-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeCancelModal()"></div>
    
    <!-- Modal Panel -->
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full z-10 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="cancelModalPanel">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Batalkan Permohonan?</h3>
            <p class="text-gray-500 text-sm mb-6">Apakah Anda yakin ingin membatalkan permohonan ini? Tindakan ini tidak dapat diurungkan.</p>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeCancelModal()" class="flex-1 py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl transition-colors">
                    Kembali
                </button>
                <button type="button" onclick="submitCancelForm()" class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-colors shadow-md shadow-red-500/30">
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openCancelModal() {
        const modal = document.getElementById('cancelModal');
        const panel = document.getElementById('cancelModalPanel');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger animation
        setTimeout(() => {
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');
        const panel = document.getElementById('cancelModalPanel');
        
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
    
    function submitCancelForm() {
        document.getElementById('cancelForm').submit();
    }
    
    // Close modal if clicked outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'cancelModal') {
            closeCancelModal();
        }
        if (e.target.id === 'lightboxModal') {
            closeLightbox();
        }
    });
    
    // FORM DETAIL TOGGLE
    function showFormDetail(key) {
        const el = document.getElementById('formDetail_' + key);
        if (el) {
            if (el.style.display === 'none') {
                el.style.display = 'block';
                el.animate([
                    { opacity: 0, transform: 'translateY(-10px)' },
                    { opacity: 1, transform: 'translateY(0)' }
                ], { duration: 200, easing: 'ease-out' });
            } else {
                el.style.display = 'none';
            }
        }
    }
    
    // LIGHTBOX LOGIC
    function openLightbox(url) {
        // Cek apakah ini PDF
        const isPdf = url.toLowerCase().includes('.pdf');
                      
        if (isPdf) {
            // Browser HP (Safari/Chrome) tidak bisa render PDF di dalam iframe.
            // Jadi untuk PDF, kita langsung buka di tab baru seperti biasa.
            window.open(url, '_blank');
            return;
        }

        const modal = document.getElementById('lightboxModal');
        const img = document.getElementById('lightboxImage');
        const loader = document.getElementById('lightboxLoader');
        const downloadBtn = document.getElementById('lightboxDownloadBtn');
        
        modal.style.display = 'flex';
        
        img.style.display = 'none';
        loader.style.display = 'flex';
        
        downloadBtn.href = url;
        
        img.src = url;
        img.onload = () => {
            loader.style.display = 'none';
            img.style.display = 'block';
        };
        img.onerror = () => {
            loader.style.display = 'none';
            img.style.display = 'block';
        };
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        modal.style.display = 'none';
        document.getElementById('lightboxImage').src = '';
    }
</script>

{{-- LIGHTBOX MODAL --}}
<div id="lightboxModal" class="hidden" style="position: fixed; inset: 0; background-color: rgba(0,0,0,0.9); z-index: 9999; display: none; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
    {{-- Tombol Tutup & Download --}}
    <div style="position: absolute; top: 1rem; right: 1rem; display: flex; gap: 0.75rem; z-index: 10000;">
        <a id="lightboxDownloadBtn" href="#" target="_blank" download style="width: 2.5rem; height: 2.5rem; background-color: rgba(255,255,255,0.2); border-radius: 9999px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none;" title="Download File">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        </a>
        <button onclick="closeLightbox()" style="width: 2.5rem; height: 2.5rem; background-color: #EF4444; border: none; border-radius: 9999px; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" title="Tutup Preview">
            <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    
    <div style="width: 100%; max-width: 64rem; height: 100%; max-height: 85vh; display: flex; align-items: center; justify-content: center; position: relative; margin-top: 2rem;">
        {{-- Loader --}}
        <div id="lightboxLoader" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; color: white;">
            <svg style="animation: spin 1s linear infinite; height: 2.5rem; width: 2.5rem; color: white;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle style="opacity: 0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path style="opacity: 0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <style>@keyframes spin { 100% { transform: rotate(360deg); } }</style>
        </div>
        
        {{-- Image Content --}}
        <img id="lightboxImage" src="" style="max-width: 100%; max-height: 100%; object-fit: contain; display: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);" alt="Preview Dokumen">
    </div>
</div>

@endsection
