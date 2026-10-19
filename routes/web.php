<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('jurusan', JurusanController::class)->except('show');
Route::resource('kompetensi', KompetensiController::class)->except('show');
Route::get('/pencarian', [SearchController::class, 'index'])->name('search.index');
