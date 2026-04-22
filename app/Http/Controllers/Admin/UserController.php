<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');
        
        // Filter role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%")
                  ->orWhere('no_ktp', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(15);
        
        $stats = [
            'total' => User::count(),
            'user' => User::where('role', 'user')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'management' => User::where('role', 'management')->count(),
        ];
        
        return view('admin.user.index', compact('users', 'stats'));
    }
    
    public function create()
    {
        return view('admin.user.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin,management',
            'admin_level' => 'nullable|integer|in:1,2',
            'no_telepon' => 'nullable|string|max:15',
            'no_ktp' => 'nullable|string|digits:16|unique:users',
        ], [
            'no_ktp.digits' => 'Nomor KTP harus 16 digit.',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar.',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'admin_level' => $request->role === 'admin' ? ($request->admin_level ?? 2) : null,
            'no_telepon' => $request->no_telepon,
            'no_ktp' => $request->no_ktp,
            'email_verified_at' => now(),
        ]);
        
        // Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'create_user',
            'description' => "Admin membuat user baru: {$user->name} ({$user->email}) dengan role {$user->role}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:user,admin,management',
            'admin_level' => 'nullable|integer|in:1,2',
            'no_telepon' => 'nullable|string|max:15',
            'no_ktp' => ['nullable', 'string', 'digits:16', Rule::unique('users')->ignore($user->id)],
        ], [
            'no_ktp.digits' => 'Nomor KTP harus 16 digit.',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar.',
        ]);
        
        $oldData = $user->only(['name', 'email', 'role', 'admin_level', 'no_telepon', 'no_ktp']);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'admin_level' => $request->role === 'admin' ? ($request->admin_level ?? 2) : null,
            'no_telepon' => $request->no_telepon,
            'no_ktp' => $request->no_ktp,
        ]);
        
        // Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'update_user',
            'description' => "Admin mengupdate user: {$user->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($user->only(['name', 'email', 'role', 'admin_level', 'no_telepon', 'no_ktp'])),
        ]);
        
        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate.');
    }
    
    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        // Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'reset_password',
            'description' => "Admin mereset password user: {$user->name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return redirect()->route('admin.user.index')->with('success', 'Password user berhasil direset.');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Jangan hapus diri sendiri
        if ($user->id == Auth::id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        
        $userName = $user->name;
        $user->delete();
        
        // Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'delete_user',
            'description' => "Admin menghapus user: {$userName}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}