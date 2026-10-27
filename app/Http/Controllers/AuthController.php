<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman pendaftaran.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->arahkanSetelahLogin();
        }

        return view('auth.register');
    }

    /**
     * Memproses pendaftaran akun baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:pengguna,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Login otomatis setelah berhasil mendaftar.
        Auth::login($pengguna);
        $request->session()->regenerate();

        // Pengguna wajib mengisi kuesioner sebelum Dashboard.
        return redirect()->route('kuesioner.create')
            ->with('success', 'Akun berhasil dibuat. Silakan isi kuesioner profil.');
    }

    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->arahkanSetelahLogin();
        }

        return view('auth.login');
    }

    /**
     * Memproses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang kamu masukkan salah.',
            ]);
        }

        $request->session()->regenerate();

        return $this->arahkanSetelahLogin();
    }

    /**
     * Memeriksa apakah pengguna sudah mengisi kuesioner.
     */
    private function arahkanSetelahLogin()
    {
        $pengguna = Auth::user();

        $sudahMengisi = Schema::hasTable('profil_pengguna')
            && DB::table('profil_pengguna')
                ->where('id_pengguna', $pengguna->id_pengguna)
                ->exists();

        if (!$sudahMengisi) {
            return redirect()->route('kuesioner.create');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Kamu berhasil keluar dari akun.');
    }
}
