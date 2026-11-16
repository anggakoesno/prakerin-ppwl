<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    // Construct
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jurusan.index', [
            'jurusans' => Jurusan::withCount('kompetensi')->orderBy('nama')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jurusan,kode',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('jurusan_foto', $fileName, 'public');
            $validated['foto'] = $filePath;
        }

        $validated['jurusan_seo'] = \Illuminate\Support\Str::slug($validated['nama']);
        // hindari duplikat slug
        if (\App\Models\Jurusan::where('jurusan_seo', $validated['jurusan_seo'])->exists()) {
            $validated['jurusan_seo'] .= '-' . time();
        }

        Jurusan::create($validated);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', [
            'jurusan' => $jurusan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jurusan,kode,' . $jurusan->id,
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($jurusan->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($jurusan->foto);
            }
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $filePath = $request->file('foto')->storeAs('jurusan_foto', $fileName, 'public');
            $validated['foto'] = $filePath;
        }

        $validated['jurusan_seo'] = \Illuminate\Support\Str::slug($validated['nama']);
        if (\App\Models\Jurusan::where('jurusan_seo', $validated['jurusan_seo'])->where('id', '!=', $jurusan->id)->exists()) {
            $validated['jurusan_seo'] .= '-' . $jurusan->id;
        }

        $jurusan->update($validated);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        if ($jurusan->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($jurusan->foto);
        }

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }

    public function listJurusan()
    {
        $jurusans = Jurusan::whereNotNull('foto')->orderBy('nama')->paginate(12);

        return view('jurusan.list', compact('jurusans'));
    }

    public function detailJurusan(String $title)
    {
        $jurusan = Jurusan::where('jurusan_seo', $title)->firstOrFail();
        $kompetensis = $jurusan->photos()->orderBy('id', 'desc')->paginate(6);

        return view('jurusan.detail', compact('jurusan', 'kompetensis'));
    }
}
