@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Total Jurusan</div>
                    <div class="fs-3 fw-bold">{{ $totalJurusan }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Total Kompetensi</div>
                    <div class="fs-3 fw-bold">{{ $totalKompetensi }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">Jumlah Kompetensi per Jurusan</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jumlah Kompetensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kompetensiPerJurusan as $jurusan)
                            <tr>
                                <td>{{ $jurusan->kode }}</td>
                                <td>{{ $jurusan->nama }}</td>
                                <td>{{ $jurusan->kompetensi_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold">5 Jurusan Terbaru</div>
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
                        @forelse ($latestJurusan as $jurusan)
                            <tr>
                                <td>{{ $jurusan->kode }}</td>
                                <td>{{ $jurusan->nama }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header fw-semibold">5 Kompetensi Terbaru</div>
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
                        @forelse ($latestKompetensi as $kompetensi)
                            <tr>
                                <td>{{ $kompetensi->kode }}</td>
                                <td>{{ $kompetensi->nama }}</td>
                                <td>{{ $kompetensi->jurusan->nama }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
