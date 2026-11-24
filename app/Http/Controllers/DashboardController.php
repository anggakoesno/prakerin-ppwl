<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kompetensi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $notifikasi = $user->notifications()->latest()->take(10)->get();

        return view('dashboard', [
            'latestJurusan' => Jurusan::latest()->take(5)->get(),
            'latestKompetensi' => Kompetensi::with('jurusan')->latest()->take(5)->get(),
            'totalJurusan' => Jurusan::count(),
            'totalKompetensi' => Kompetensi::count(),
            'kompetensiPerJurusan' => Jurusan::withCount('kompetensi')->orderBy('nama')->get(),
            'user' => $user,
            'notifikasi' => $notifikasi,
        ]);
    }

    public function bacaSemua(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
