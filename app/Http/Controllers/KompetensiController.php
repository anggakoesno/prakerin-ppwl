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
        $tanggal = $request->filled('tanggal') ? $request->date('tanggal')->toDateString() : null;

        return view('kompetensi.index', [
            'kompetensi' => Kompetensi::with('jurusan')
                ->when($jurusanId, fn ($query) => $query->where('jurusan_id', $jurusanId))
                ->when($tanggal, fn ($query) => $query->whereDate('created_at', $tanggal))
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'jurusans' => Jurusan::orderBy('nama')->get(),
            'selectedJurusan' => $jurusanId,
            'selectedTanggal' => $tanggal,
        ]);
    }

    public function create()
    {
        return view('kompetensi.create', [
            'jurusans' => Jurusan::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'kode' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
        ]);

        Kompetensi::create($validated);

        return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil ditambahkan.');
    }

    public function edit(Kompetensi $kompetensi)
    {
        return view('kompetensi.edit', [
            'kompetensi' => $kompetensi,
            'jurusans' => Jurusan::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Kompetensi $kompetensi)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'kode' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
        ]);

        $kompetensi->update($validated);

        return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil diperbarui.');
    }

    public function destroy(Kompetensi $kompetensi)
    {
        $kompetensi->delete();

        return redirect()->route('kompetensi.index')->with('success', 'Kompetensi berhasil dihapus.');
    }
}
