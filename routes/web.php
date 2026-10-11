<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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

    Route::get('/admin/dashboard', function () {
        abort_unless(auth()->user()->role === 'admin', 403);
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/dokter/dashboard', function () {
        abort_unless(auth()->user()->role === 'dokter', 403);
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::get('/pasien/dashboard', function () {
        abort_unless(auth()->user()->role === 'pasien', 403);
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
