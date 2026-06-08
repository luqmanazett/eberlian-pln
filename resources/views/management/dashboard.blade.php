@extends('components.pln-layout')

@section('title', 'Management Dashboard - E-Berlian')

@section('content')
<div class="max-w-lg mx-auto">
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Management</h2>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}</p>
    </div>
    
    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-3 mb-6">
        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['total_approved'] }}</p>
            <p class="text-sm text-gray-500">Total Disetujui</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
            <p class="text-3xl font-bold text-pln-blue">{{ $stats['total_bulan_ini'] }}</p>
            <p class="text-sm text-gray-500">Bulan Ini</p>
        </div>
    </div>
    
    {{-- Export Menu --}}
    <div class="space-y-3">
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <h3 class="font-semibold mb-3">Export Data</h3>
            
            <form action="{{ route('management.export.excel') }}" method="POST" class="mb-3">
                @csrf
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <input type="date" name="start_date" class="border rounded p-2" required>
                    <input type="date" name="end_date" class="border rounded p-2" required>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2 hover:bg-green-700">
                    📥 Download Excel
                </button>
            </form>
            
            <form action="{{ route('management.export.zip') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <input type="date" name="start_date" class="border rounded p-2" required>
                    <input type="date" name="end_date" class="border rounded p-2" required>
                </div>
                <button type="submit" class="w-full bg-pln-blue text-white rounded-lg py-2 hover:bg-blue-700">
                    📦 Download ZIP (Semua Dokumen)
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
