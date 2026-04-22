@extends('components.pln-layout')

@section('title', 'Manajemen User - SIPEL PLN')
@section('header-title', 'Manajemen User')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600">
                <span class="text-2xl">←</span>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Manajemen User</h2>
        </div>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary" style="width: auto; padding: 10px 16px;">
            + Tambah User
        </a>
    </div>
    
    {{-- Statistik --}}
    <div class="grid grid-cols-4 gap-2">
        <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
            <p class="text-xl font-bold text-gray-800">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500">Total</p>
        </div>
        <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
            <p class="text-xl font-bold text-blue-600">{{ $stats['user'] }}</p>
            <p class="text-xs text-gray-500">User</p>
        </div>
        <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
            <p class="text-xl font-bold text-purple-600">{{ $stats['admin'] }}</p>
            <p class="text-xs text-gray-500">Admin</p>
        </div>
        <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
            <p class="text-xl font-bold text-green-600">{{ $stats['management'] }}</p>
            <p class="text-xs text-gray-500">Management</p>
        </div>
    </div>
    
    {{-- Filter --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <form method="GET" class="space-y-3">
            <div class="grid grid-cols-2 gap-2">
                <select name="role" class="input-field">
                    <option value="">Semua Role</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="management" {{ request('role') == 'management' ? 'selected' : '' }}>Management</option>
                </select>
                <input type="text" name="search" value="{{ request('search') }}" class="input-field" placeholder="🔍 Cari nama, email, telepon...">
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary flex-1">Filter</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline flex-1 text-center">Reset</a>
            </div>
        </form>
    </div>
    
    {{-- List User --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Nama</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Email</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Role</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">No. Telepon</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 text-sm text-gray-800">{{ $user->name }}</td>
                        <td class="px-3 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-3 py-3">
                            <span class="text-xs px-2 py-1 rounded-full 
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $user->role == 'user' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $user->role == 'management' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-sm text-gray-600">{{ $user->no_telepon ?? '-' }}</td>
                        <td class="px-3 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="text-pln-blue text-xs">Edit</a>
                                <button onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')" class="text-yellow-600 text-xs">Reset PW</button>
                                @if($user->id != Auth::id())
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-xs">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-3 py-8 text-center text-gray-500">
                            Belum ada user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->appends(request()->query())->links() }}
    </div>
    
</div>

{{-- Modal Reset Password --}}
<div id="resetModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Reset Password</h3>
        <p class="text-sm text-gray-500 mb-4">Reset password untuk: <span id="resetUserName"></span></p>
        
        <form id="resetForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Password Baru</label>
                <input type="password" name="password" class="input-field" required minlength="8">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="input-field" required>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeResetModal()" class="btn btn-outline flex-1">Batal</button>
                <button type="submit" class="btn btn-primary flex-1">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResetModal(id, name) {
        document.getElementById('resetUserName').textContent = name;
        document.getElementById('resetForm').action = '/admin/user/' + id + '/reset-password';
        document.getElementById('resetModal').classList.remove('hidden');
        document.getElementById('resetModal').classList.add('flex');
    }
    function closeResetModal() {
        document.getElementById('resetModal').classList.add('hidden');
        document.getElementById('resetModal').classList.remove('flex');
    }
</script>
@endsection