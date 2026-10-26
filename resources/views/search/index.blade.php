@extends('layouts.app')

@section('title', 'Pencarian')

@section('content')
    <h1 class="mb-3">Pencarian</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('search.index') }}" class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="q" value="{{ $q }}"
                        placeholder="Cari jurusan atau kompetensi..." class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    @if ($q !== '')
        @php $total = $jurusans->count() + $kompetensis->count(); @endphp

        @if ($total > 0)
            <div class="alert alert-success">
                Ditemukan <strong>{{ $total }}</strong> data dengan kata: <strong>{{ $q }}</strong>
            </div>
        @else
            <div class="alert alert-warning">
                <strong>Data "{{ $q }}" tidak ditemukan</strong>
                <div class="mt-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-dark btn-sm">Kembali</a>
                </div>
            </div>
        @endif

        @if ($total > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold">Jurusan ({{ $jurusans->count() }})</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jurusans as $jurusan)
                                    <tr>
                                        <td>{{ $jurusan->kode }}</td>
                                        <td>{{ $jurusan->nama }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Tidak ada jurusan ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Kompetensi ({{ $kompetensis->count() }})</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kompetensis as $kompetensi)
                                    <tr>
                                        <td>{{ $kompetensi->kode }}</td>
                                        <td>{{ $kompetensi->nama }}</td>
                                        <td>{{ $kompetensi->jurusan->nama }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada kompetensi ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
