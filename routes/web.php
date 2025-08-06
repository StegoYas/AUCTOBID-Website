<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/logout', function (Request $request) {
    Auth::guard('admin')->logout();
    Auth::guard('petugas')->logout();
    Auth::guard('masyarakat')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');



Route::post('/logout', function () {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('petugas')->check()) {
        Auth::guard('petugas')->logout();
    } elseif (Auth::guard('masyarakat')->check()) {
        Auth::guard('masyarakat')->logout();
    }
    return redirect('/');
})->name('logout');

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::view('/lelang/tanah', 'tanah');
Route::view('/lelang/rumah', 'rumah');
Route::view('/lelang/mobil', 'mobil');
Route::view('/lelang/motor', 'motor');
Route::view('/lelang/ruko', 'ruko');
