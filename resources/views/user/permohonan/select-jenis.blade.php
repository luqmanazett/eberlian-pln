@extends('components.pln-layout')

@section('title', 'Pilih Jenis Permohonan - E-Berlian')
@section('header-title', 'Permohonan')

@push('styles')
<style>
    /* Premium Aesthetic Styles */
    .premium-page-wrapper {
        position: relative;
        z-index: 1;
    }
    
    .premium-page-wrapper::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(36,190,172,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: -1;
    }

    .premium-page-wrapper::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        z-index: -1;
    }

    .title-gradient {
        background: linear-gradient(135deg, #111827 0%, #374151 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.5px;
    }

    .service-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 1);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--card-color);
        border-radius: 20px 0 0 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.02);
        border-color: rgba(255,255,255,0.5);
    }
    
    .service-card:hover::before {
        opacity: 1;
    }

    .icon-box {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        background: linear-gradient(135deg, var(--color-start), var(--color-end));
        color: white;
        box-shadow: 0 8px 20px var(--shadow-color);
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }

    .service-card:hover .icon-box {
        transform: rotate(-5deg) scale(1.05);
    }

    .card-content {
        flex: 1;
    }

    .card-title {
        font-weight: 700;
        font-size: 17px;
        color: #1F2937;
        margin-bottom: 4px;
        transition: color 0.3s ease;
    }

    .service-card:hover .card-title {
        color: var(--card-text-color);
    }

    .card-desc {
        font-size: 13px;
        color: #6B7280;
        line-height: 1.4;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #F3F4F6;
        color: #9CA3AF;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .service-card:hover .action-btn {
        background: var(--card-color);
        color: white;
        box-shadow: 0 4px 12px var(--shadow-color);
        transform: translateX(4px);
    }
</style>
@endpush

@section('content')
<div class="flex-1 flex flex-col justify-start max-w-lg mx-auto w-full px-4 pt-6 pb-12 premium-page-wrapper">
    
    {{-- Header Section --}}
    <div class="text-center mb-16">
        <div class="inline-block p-3 bg-teal-50 rounded-2xl text-teal-600 mb-4 shadow-sm border border-teal-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <h2 class="text-3xl font-extrabold title-gradient">Pilih Layanan</h2>
        <p class="text-gray-500 text-sm mt-3 px-4 leading-relaxed">Pilih jenis permohonan yang sesuai dengan kebutuhan instalasi listrik Anda saat ini.</p>
    </div>

    {{-- Services List --}}
    <div class="space-y-4">
        
        {{-- Pasang Baru --}}
        <a href="{{ route('user.permohonan.create', ['jenis' => 'pasang_baru']) }}" class="service-card" style="--card-color: #3B82F6; --card-text-color: #2563EB; --color-start: #60A5FA; --color-end: #2563EB; --shadow-color: rgba(59, 130, 246, 0.3);">
            <div class="icon-box">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div class="card-content">
                <h4 class="card-title">Pasang Baru</h4>
                <p class="card-desc">Instalasi listrik baru untuk bangunan atau rumah yang belum berlistrik.</p>
            </div>
            <div class="action-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12m-6-6h12"></path></svg>
            </div>
        </a>
        
        {{-- Tambah Daya --}}
        <a href="{{ route('user.permohonan.create', ['jenis' => 'tambah_daya']) }}" class="service-card" style="--card-color: #F59E0B; --card-text-color: #D97706; --color-start: #FBBF24; --color-end: #D97706; --shadow-color: rgba(245, 158, 11, 0.3);">
            <div class="icon-box">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div class="card-content">
                <h4 class="card-title">Tambah Daya</h4>
                <p class="card-desc">Upgrade kapasitas listrik untuk memenuhi kebutuhan alat elektronik Anda.</p>
            </div>
            <div class="action-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12m-6-6h12"></path></svg>
            </div>
        </a>
        
        {{-- Peningkatan Keandalan --}}
        <a href="{{ route('user.permohonan.create', ['jenis' => 'peningkatan_keandalan']) }}" class="service-card" style="--card-color: #10B981; --card-text-color: #059669; --color-start: #34D399; --color-end: #059669; --shadow-color: rgba(16, 185, 129, 0.3);">
            <div class="icon-box">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div class="card-content">
                <h4 class="card-title">Keandalan Sistem</h4>
                <p class="card-desc">Perbaikan jaringan dan peningkatan mutu keandalan pasokan listrik.</p>
            </div>
            <div class="action-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12m-6-6h12"></path></svg>
            </div>
        </a>
        
    </div>
</div>
@endsection
