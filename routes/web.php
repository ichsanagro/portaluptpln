<?php

use App\Http\Controllers\AdminLogistik\MaterialController;
use App\Http\Controllers\Logistik\UserLogistikController;
use Illuminate\Support\Facades\Route;

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

    // Dummy authentication logic
    if ($credentials['email'] === 'adminlogistik@pln.co.id' && $credentials['password'] === 'password123') {
        session([
            'user' => [
                'name' => 'Admin Logistik',
                'role' => 'adminlogistik'
            ]
        ]);
        return redirect()->route('logistik.adminlogistik.dashboard');
    } elseif ($credentials['email'] === 'userlogistik@pln.co.id' && $credentials['password'] === 'password123') {
        session([
            'user' => [
                'name' => 'User Logistik',
                'role' => 'userlogistik'
            ]
        ]);
        return redirect()->route('logistik.userlogistik.dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');

})->name('login.attempt');

Route::prefix('logistik')->name('logistik.')->group(function () {
    Route::get('/adminlogistik/dashboard', function() {
        return view('logistik.adminlogistik.admin_dashboard');
    })->name('adminlogistik.dashboard');

    Route::resource('/adminlogistik/material', MaterialController::class, [
        'as' => 'adminlogistik'
    ])->parameters([
        'material' => 'id'
    ]);

    Route::get('/adminlogistik/permintaan', function() {
        return view('logistik.adminlogistik.permintaan');
    })->name('adminlogistik.permintaan');

    // User Logistik Routes
    Route::prefix('user')->name('userlogistik.')->group(function () {
        Route::get('/dashboard', [UserLogistikController::class, 'index'])->name('dashboard');
        Route::get('/peminjaman', [UserLogistikController::class, 'peminjaman'])->name('peminjaman');
        Route::post('/peminjaman', [UserLogistikController::class, 'storePeminjaman'])->name('peminjaman.store');
        Route::get('/pengembalian', [UserLogistikController::class, 'pengembalian'])->name('pengembalian');
    });
});

