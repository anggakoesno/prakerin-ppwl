@extends('layouts.app')

@section('title', 'Data Kompetensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Data Kompetensi</h1>
        <a href="{{ route('kompetensi.create') }}" class="btn btn-dark btn-sm">Tambah Kompetensi</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('kompetensi.index') }}" class="row g-2 align-items-end mb-3">
                <div class="col-md-4">
                    <label for="jurusan_id" class="form-label mb-1">Jurusan</label>
                    <select name="jurusan_id" id="jurusan_id" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" @selected($selectedJurusan === $jurusan->id)>{{ $jurusan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tanggal" class="form-label mb-1">Tanggal Dibuat</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $selectedTanggal ?? '' }}"
                        class="form-control">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-dark">Filter</button>
                </div>
                @if ($selectedJurusan || $selectedTanggal)
                    <div class="col-auto">
                        <a href="{{ route('kompetensi.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kompetensi as $item)
                            <tr>
                                <td>{{ $kompetensi->firstItem() + $loop->index }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jurusan->nama }}</td>
                                <td>{{ $item->created_at->isoFormat('D MMM YYYY') }}</td>
                                <td>
                                    <a href="{{ route('kompetensi.edit', $item) }}"
                                        class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                    <form method="POST" action="{{ route('kompetensi.destroy', $item) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus kompetensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data kompetensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $kompetensi->links() }}
    </div>
@endsection
