@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Data Jurusan</h1>
        <a href="{{ route('jurusan.create') }}" class="btn btn-dark btn-sm">Tambah Jurusan</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jumlah Kompetensi</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurusans as $jurusan)
                            <tr>
                                <td>{{ $jurusans->firstItem() + $loop->index }}</td>
                                <td>{{ $jurusan->kode }}</td>
                                <td>{{ $jurusan->nama }}</td>
                                <td>{{ $jurusan->kompetensi_count }}</td>
                                <td>{{ $jurusan->created_at->isoFormat('D MMM YYYY') }}</td>
                                <td>
                                    <a href="{{ route('jurusan.edit', $jurusan) }}"
                                        class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                    <form method="POST" action="{{ route('jurusan.destroy', $jurusan) }}" class="d-inline"
                                        onsubmit="return confirm('Hapus jurusan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data jurusan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $jurusans->links() }}
    </div>
@endsection
