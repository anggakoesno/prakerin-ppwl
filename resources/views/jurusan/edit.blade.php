@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
    <h1 class="mb-3">Edit Jurusan</h1>

    <div class="card shadow-sm" style="max-width: 480px;">
        <div class="card-body">
            <form method="POST" action="{{ route('jurusan.update', $jurusan) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" name="kode" id="kode" value="{{ old('kode', $jurusan->kode) }}"
                        maxlength="10" class="form-control @error('kode') is-invalid @enderror">
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $jurusan->nama) }}"
                        class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                    <a href="{{ route('jurusan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
