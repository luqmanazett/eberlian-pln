@extends('components.pln-layout')

@section('title', 'Log Aktivitas - SIPEL PLN')
@section('header-title', 'Log Aktivitas')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Log Aktivitas</h2>
    </div>
    
    {{-- Statistik --}}
    <div class="grid grid-cols-2 gap-2">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-2xl font-bold text-pln-blue">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500">Total Log</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <p class="text-2xl font-bold text-green-600">{{ $stats['today'] }}</p>
            <p class="text-xs text-gray-500">Hari Ini</p>
        </div>
    </div>
    
    {{-- Filter --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <form method="GET" class="space-y-3">
            <div class="grid grid-cols-2 gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="input-field" placeholder="Tanggal Mulai">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="input-field" placeholder="Tanggal Akhir">
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <select name="role" class="input-field">
                    <option value="">Semua Role</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="management" {{ request('role') == 'management' ? 'selected' : '' }}>Management</option>
                </select>
                <input type="text" name="action" value="{{ request('action') }}" class="input-field" placeholder="Aksi (contoh: submit, approve)">
            </div>
            
            <input type="text" name="search" value="{{ request('search') }}" class="input-field" placeholder="🔍 Cari aksi, deskripsi, atau IP...">
            
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">Filter</button>
                <a href="{{ route('admin.log.index') }}" class="btn btn-outline flex-1 text-center">Reset</a>
                <a href="{{ route('admin.log.export', request()->query()) }}" class="btn flex-1 text-center" style="background: #10B981; color: white;">📥 Export CSV</a>
            </div>
        </form>
    </div>
    
    {{-- List Log --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Waktu</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">User</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Role</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Deskripsi</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 text-xs text-gray-600 whitespace-nowrap">
    @if($log->created_at)
        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}
    @else
        -
    @endif
</td>
                        <td class="px-3 py-3 text-xs text-gray-800">
                            {{ $log->user->name ?? '-' }}
                        </td>
                        <td class="px-3 py-3">
                            <span class="text-xs px-2 py-1 rounded-full 
                                {{ $log->role == 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $log->role == 'user' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $log->role == 'management' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($log->role) }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-xs text-gray-800">
                            {{ $log->action }}
                        </td>
                        <td class="px-3 py-3 text-xs text-gray-600">
                            {{ Str::limit($log->description, 50) }}
                        </td>
                        <td class="px-3 py-3 text-xs text-gray-500">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-3 py-8 text-center text-gray-500">
                            Belum ada log aktivitas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $logs->appends(request()->query())->links() }}
    </div>
    
</div>
@endsection