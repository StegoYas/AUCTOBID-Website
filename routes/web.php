<?php

use Illuminate\Support\Facades\Route;

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
