<?php

use App\Http\Controllers\AdminLogistik\MaterialController;
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
        // In a real application, you would use Auth::attempt($credentials)
        // and log the user in.
        // For now, we simulate success and redirect to the dashboard.
        return redirect()->route('logistik.adminlogistik.dashboard');
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
});
