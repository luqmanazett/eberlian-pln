<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'digits:16', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'no_telepon' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'no_ktp.required' => 'Nomor KTP wajib diisi.',
            'no_ktp.digits' => 'Nomor KTP harus 16 digit.',
            'no_ktp.unique' => 'Nomor KTP sudah terdaftar.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_ktp' => $request->no_ktp,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => 'user', // 👈 Role otomatis USER
        ]);

        event(new Registered($user));

        // Log Aktivitas
        ActivityLog::create([
            'user_id' => $user->id,
            'role' => 'user',
            'action' => 'register',
            'description' => "User baru mendaftar: {$user->name} ({$user->email})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Tidak auto-login, redirect ke login
        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}