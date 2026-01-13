<?php

use App\Http\Controllers\AdminLogistik\MaterialController;
use App\Http\Controllers\Logistik\UserLogistikController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Hse\AdminHseController;
use App\Http\Controllers\Hse\UserHseController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->hasRole('admin logistik')) {
            return redirect()->route('logistik.adminlogistik.dashboard');
        } elseif ($user->hasRole('user logistik')) {
            return redirect()->route('logistik.userlogistik.dashboard');
        } elseif ($user->hasRole('admin hse')) {
            return redirect()->route('hse.admin_dashboard');
        } elseif ($user->hasRole('user hse')) {
            return redirect()->route('hse.dashboard');
        }

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.attempt');

Route::prefix('logistik')->name('logistik.')->group(function () {
    Route::middleware(['auth', 'role:admin logistik'])->group(function () {
        Route::get('/adminlogistik/dashboard', function() {
            return view('logistik.adminlogistik.admin_dashboard');
        })->name('adminlogistik.dashboard');

        Route::resource('/adminlogistik/material', MaterialController::class, [
            'as' => 'adminlogistik'
        ])->parameters([
            'material' => 'id'
        ])->except(['create', 'show']);

        Route::get('/adminlogistik/permintaan', [MaterialController::class, 'permintaan'])->name('adminlogistik.permintaan');
        Route::post('/adminlogistik/permintaan/{id}/approve', [MaterialController::class, 'approvePeminjaman'])->name('adminlogistik.permintaan.approve');
        Route::post('/adminlogistik/permintaan/{id}/reject', [MaterialController::class, 'rejectPeminjaman'])->name('adminlogistik.permintaan.reject');
    });

    // User Logistik Routes
    Route::middleware(['auth', 'role:user logistik'])->prefix('user')->name('userlogistik.')->group(function () {
        Route::get('/dashboard', [UserLogistikController::class, 'index'])->name('dashboard');
        Route::get('/peminjaman', [UserLogistikController::class, 'peminjaman'])->name('peminjaman');
        Route::post('/peminjaman', [UserLogistikController::class, 'storePeminjaman'])->name('peminjaman.store');
        Route::get('/pengembalian', [UserLogistikController::class, 'pengembalian'])->name('pengembalian');
        Route::post('/pengembalian', [UserLogistikController::class, 'storePengembalian'])->name('pengembalian.store'); // New route for storing returns
        Route::get('/riwayat', [UserLogistikController::class, 'riwayatPeminjaman'])->name('riwayat'); // New route for borrowing history
    });
});

Route::prefix('hse')->name('hse.')->middleware('auth')->group(function () {
    // Admin HSE Dashboard
    Route::middleware('role:admin hse')->group(function () {
        Route::get('/admin/dashboard', [AdminHseController::class, 'dashboard'])->name('admin_dashboard');
        Route::post('/admin/stats/update', [AdminHseController::class, 'updateStats'])->name('admin_stats_update');
        Route::post('/admin/stats/reset', [AdminHseController::class, 'resetStats'])->name('admin_stats_reset');
    });

    // User HSE Dashboard
    Route::middleware('role:user hse')->group(function () {
        Route::get('/dashboard', [UserHseController::class, 'dashboard'])->name('dashboard');
    });
});
