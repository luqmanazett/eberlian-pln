@extends('components.pln-layout')

@section('title', 'Edit User - SIPEL PLN')
@section('header-title', 'Edit User')

@section('content')
<div class="space-y-4 ">
    
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.user.index') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
    </div>
    
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            {{-- Nama Lengkap --}}
            <div>
                <label class="input-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Email --}}
            <div>
                <label class="input-label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Nomor Telepon --}}
            <div>
                <label class="input-label">Nomor Telepon</label>
                <input type="tel" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" class="input-field">
                @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Nomor KTP --}}
            <div>
                <label class="input-label">Nomor KTP (NIK)</label>
                <input type="text" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}" class="input-field" maxlength="16">
                @error('no_ktp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Role --}}
            <div>
                <label class="input-label">Role <span class="text-red-500">*</span></label>
                <select name="role" id="role" class="input-field" required onchange="toggleAdminLevel()">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User (Pelanggan)</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Petugas)</option>
                    <option value="management" {{ $user->role == 'management' ? 'selected' : '' }}>Management (Manajer)</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Admin Level --}}
            <div id="adminLevelField" style="display: {{ $user->role == 'admin' ? 'block' : 'none' }};">
                <label class="input-label">Level Admin</label>
                <select name="admin_level" class="input-field">
                    <option value="1" {{ $user->admin_level == 1 ? 'selected' : '' }}>Admin Utama (Akses Penuh)</option>
                    <option value="2" {{ $user->admin_level == 2 ? 'selected' : '' }}>Admin Verifikator (Hanya Verifikasi)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">
                    • Admin Utama: Bisa akses semua fitur (Log, Export, Manajemen User)<br>
                    • Admin Verifikator: Hanya bisa Approve/Reject permohonan
                </p>
            </div>
            
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
    
</div>

<script>
    function toggleAdminLevel() {
        const role = document.getElementById('role').value;
        const adminLevelField = document.getElementById('adminLevelField');
        
        if (role === 'admin') {
            adminLevelField.style.display = 'block';
        } else {
            adminLevelField.style.display = 'none';
        }
    }
</script>
@endsection
