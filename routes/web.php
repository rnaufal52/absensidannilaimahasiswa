<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/mahasiswa', function () {
        return view('mahasiswa');
    })->name('mahasiswa');
    Route::get('/mata-kuliah', function () {
        return view('mata-kuliah');
    })->name('mata-kuliah');
    Route::get('/pertemuan', function () {
        return view('pertemuan');
    })->name('pertemuan');
    Route::get('/nilai', function () {
        return view('nilai');
    })->name('nilai');
    Route::get('/absen', function () {
        return view('absen');
    })->name('absen');
});
