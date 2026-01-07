<?php

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
        return redirect()->route('logistik.dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');

})->name('login.attempt');

Route::get('/logistik/dashboard', function() {
    return view('logistik.admin_dashboard');
})->name('logistik.dashboard');

Route::get('/logistik/material', function() {
    return view('logistik.material');
})->name('logistik.material');

Route::get('/logistik/permintaan', function() {
    return view('logistik.permintaan');
})->name('logistik.permintaan');
