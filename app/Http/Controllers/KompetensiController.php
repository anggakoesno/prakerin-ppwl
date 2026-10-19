<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kompetensi;
use Illuminate\Http\Request;

class KompetensiController extends Controller
{
    public function index(Request $request)
    {
        $jurusanId = $request->integer('jurusan_id');

        return view('kompetensi.index', [
            'kompetensi' => Kompetensi::with('jurusan')
                ->when($jurusanId, fn ($query) => $query->where('jurusan_id', $jurusanId))
                ->latest()
                ->get(),
            'jurusans' => Jurusan::orderBy('nama')->get(),
            'selectedJurusan' => $jurusanId,
        ]);
    }
}
