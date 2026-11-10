<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\PoliController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(match (auth()->user()->role) {
            'admin' => 'admin.dashboard',
            'dokter' => 'dokter.dashboard',
            'pasien' => 'pasien.dashboard',
            default => 'dashboard',
        });
    })->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('polis', AdminPoliController::class)->except(['show']);
        Route::resource('dokter', DokterController::class)->except(['show']);
        Route::resource('pasien', PasienController::class)->except(['show']);
        Route::resource('obat', ObatController::class)->except(['show']);
    });

    Route::get('/dokter/dashboard', function () {
        abort_unless(auth()->user()->role === 'dokter', 403);
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::middleware('role:dokter')->prefix('dokter')->group(function () {
        Route::resource('jadwal-periksa', JadwalPeriksaController::class)->except(['show']);
        Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
        Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
        Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');
        Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
        Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
    });

    Route::get('/pasien/dashboard', function () {
        abort_unless(auth()->user()->role === 'pasien', 403);
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::middleware('role:pasien')->prefix('pasien')->group(function () {
        Route::get('/daftar', [PoliController::class, 'get'])->name('pasien.daftar');
        Route::post('/daftar', [PoliController::class, 'submit'])->name('pasien.daftar.submit');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
