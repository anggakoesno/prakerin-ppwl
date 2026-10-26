@extends('layouts.app')

@section('title', 'Tambah Kompetensi')

@section('content')
    <h1 class="mb-3">Tambah Kompetensi</h1>

    <div class="card shadow-sm" style="max-width: 480px;">
        <div class="card-body">
            <form method="POST" action="{{ route('kompetensi.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="jurusan_id" class="form-label">Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" class="form-select @error('jurusan_id') is-invalid @enderror">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" @selected(old('jurusan_id') == $jurusan->id)>{{ $jurusan->nama }}</option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="text" name="kode" id="kode" value="{{ old('kode') }}" maxlength="20"
                        class="form-control @error('kode') is-invalid @enderror">
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                        class="form-control @error('nama') is-invalid @enderror">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                    <a href="{{ route('kompetensi.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
