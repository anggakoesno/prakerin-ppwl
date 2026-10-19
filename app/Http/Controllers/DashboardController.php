<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kompetensi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'latestJurusan' => Jurusan::latest()->take(5)->get(),
            'latestKompetensi' => Kompetensi::with('jurusan')->latest()->take(5)->get(),
        ]);
    }
}
