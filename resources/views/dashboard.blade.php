@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    {{-- Blok notifikasi (user Google + daftar notifikasi admin) --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" class="rounded-circle mb-3" width="80" height="80" alt="avatar"
                            referrerpolicy="no-referrer">
                    @endif
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'secondary' }}">{{ $user->level }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>Notifikasi</strong>
                    @if ($user->unreadNotifications->count())
                        <form action="{{ route('notifikasi.baca') }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($notifikasi as $n)
                        <li class="list-group-item d-flex justify-content-between {{ $n->read_at ? '' : 'fw-semibold' }}">
                            <span>{{ $n->data['pesan'] }}</span>
                            <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada notifikasi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

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

    <div class="card shadow-sm mb-4">
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
