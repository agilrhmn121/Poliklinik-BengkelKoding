<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register', ['polis' => Poli::orderBy('nama_poli')->get()]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route(match (Auth::user()->role) {
                'admin' => 'admin.dashboard',
                'dokter' => 'dokter.dashboard',
                'pasien' => 'pasien.dashboard',
                default => 'dashboard',
            });
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak sesuai.'])
            ->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'numeric', 'unique:users,no_ktp'],
            'no_hp' => ['required', 'string', 'max:255'],
            'id_poli' => ['required', 'integer', 'exists:poli,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $lastPasien = User::where('role', 'pasien')->orderByDesc('id')->first();
        $lastId = $lastPasien ? $lastPasien->id + 1 : 1;
        $noRm = now()->format('Ym') . '-' . str_pad($lastId, 3, '0', STR_PAD_LEFT);

        $user = User::create([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_ktp' => $validated['no_ktp'],
            'no_hp' => $validated['no_hp'],
            'no_rm' => $noRm,
            'role' => 'pasien',
            'id_poli' => $validated['id_poli'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('login')->with('success', "Registrasi berhasil. Nomor rekam medis Anda: {$noRm}");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
