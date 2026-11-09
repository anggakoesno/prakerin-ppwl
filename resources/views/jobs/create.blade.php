@extends('layouts.app')

@section('title', 'Tambah Lowongan')

@section('content')
    <h1 class="mb-3">Tambah Lowongan</h1>

    <div class="card shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('jobs.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Lowongan</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                    <select name="jenis_pekerjaan" id="jenis_pekerjaan"
                        class="form-select @error('jenis_pekerjaan') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Full-time" @selected(old('jenis_pekerjaan', $job->jenis_pekerjaan ?? '') === 'Full-time')>Full-time</option>
                        <option value="Part-time" @selected(old('jenis_pekerjaan', $job->jenis_pekerjaan ?? '') === 'Part-time')>Part-time</option>
                    </select>
                    @error('jenis_pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        class="form-control @error('location') is-invalid @enderror">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="company" class="form-label">Nama Perusahaan</label>
                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                        class="form-control @error('company') is-invalid @enderror">
                    @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="salary" class="form-label">Gaji</label>
                    <input type="number" name="salary" id="salary" value="{{ old('salary') }}"
                        class="form-control @error('salary') is-invalid @enderror">
                    @error('salary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="logo" class="form-label">Logo Perusahaan</label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                        class="form-control @error('logo') is-invalid @enderror">
                    @error('logo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
