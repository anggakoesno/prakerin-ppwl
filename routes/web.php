<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KompetensiController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('jurusan', JurusanController::class)->except('show');
Route::get('/list-jurusan', [JurusanController::class, 'listJurusan'])->name('jurusan.list');
Route::get('/detail-jurusan/{title}', [JurusanController::class, 'detailJurusan'])->name('jurusan.detail');

Route::resource('kompetensi', KompetensiController::class)->except('show');

Route::get('/pencarian', [SearchController::class, 'index'])->name('search.index');

Route::resource('users', UserController::class)->except('show');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('jobs', JobController::class)->middleware(['auth', 'isAdmin']);

Route::resource('gallery', GalleryController::class)->parameters(['gallery' => 'post'])->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

