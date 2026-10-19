<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kompetensi;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        return view('search.index', [
            'q' => $q,
            'jurusans' => $q === ''
                ? collect()
                : Jurusan::where('nama', 'LIKE', "%{$q}%")
                    ->orWhere('kode', 'LIKE', "%{$q}%")
                    ->orderBy('nama')
                    ->get(),
            'kompetensis' => $q === ''
                ? collect()
                : Kompetensi::with('jurusan')
                    ->where('nama', 'LIKE', "%{$q}%")
                    ->orderBy('nama')
                    ->get(),
        ]);
    }
}
