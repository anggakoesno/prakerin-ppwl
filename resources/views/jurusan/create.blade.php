@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')
    <h1>Tambah Jurusan</h1>

    <div class="card" style="max-width: 480px;">
        <form method="POST" action="{{ route('jurusan.store') }}">
            @csrf
            <div style="margin-bottom: 0.75rem;">
                <label for="kode" style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Kode</label>
                <input type="text" name="kode" id="kode" value="{{ old('kode') }}" maxlength="10"
                    style="width: 100%; padding: 0.45rem 0.6rem; border: 1px solid #ccc; border-radius: 4px;">
                @error('kode')
                    <div style="color: #c00; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div style="margin-bottom: 0.75rem;">
                <label for="nama" style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    style="width: 100%; padding: 0.45rem 0.6rem; border: 1px solid #ccc; border-radius: 4px;">
                @error('nama')
                    <div style="color: #c00; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" style="padding: 0.45rem 1rem; background: #1b1b18; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Simpan</button>
                <a href="{{ route('jurusan.index') }}" style="padding: 0.45rem 1rem; color: #444; border: 1px solid #ccc; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">Batal</a>
            </div>
        </form>
    </div>
@endsection
