<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('jurusan', JurusanController::class)->except('show');
Route::resource('kompetensi', KompetensiController::class)->except('show');
Route::get('/pencarian', [SearchController::class, 'index'])->name('search.index');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
