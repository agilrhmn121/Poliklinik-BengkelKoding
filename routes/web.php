<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
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
    });

    Route::get('/pasien/dashboard', function () {
        abort_unless(auth()->user()->role === 'pasien', 403);
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
