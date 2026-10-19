@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
        <div class="card" style="flex: 1;">
            <div style="font-size: 0.85rem; color: #777;">Total Jurusan</div>
            <div style="font-size: 1.6rem; font-weight: 600;">{{ $totalJurusan }}</div>
        </div>
        <div class="card" style="flex: 1;">
            <div style="font-size: 0.85rem; color: #777;">Total Kompetensi</div>
            <div style="font-size: 1.6rem; font-weight: 600;">{{ $totalKompetensi }}</div>
        </div>
    </div>

    <div class="card" style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">Jumlah Kompetensi per Jurusan</h2>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                    <th style="padding: 0.5rem;">Kode</th>
                    <th style="padding: 0.5rem;">Nama</th>
                    <th style="padding: 0.5rem;">Jumlah Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kompetensiPerJurusan as $jurusan)
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 0.5rem;">{{ $jurusan->kode }}</td>
                        <td style="padding: 0.5rem;">{{ $jurusan->nama }}</td>
                        <td style="padding: 0.5rem;">{{ $jurusan->kompetensi_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 0.5rem; color: #777;">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card" style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">5 Jurusan Terbaru</h2>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                    <th style="padding: 0.5rem;">Kode</th>
                    <th style="padding: 0.5rem;">Nama</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestJurusan as $jurusan)
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 0.5rem;">{{ $jurusan->kode }}</td>
                        <td style="padding: 0.5rem;">{{ $jurusan->nama }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="padding: 0.5rem; color: #777;">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">5 Kompetensi Terbaru</h2>
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                    <th style="padding: 0.5rem;">Kode</th>
                    <th style="padding: 0.5rem;">Nama</th>
                    <th style="padding: 0.5rem;">Jurusan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestKompetensi as $kompetensi)
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 0.5rem;">{{ $kompetensi->kode }}</td>
                        <td style="padding: 0.5rem;">{{ $kompetensi->nama }}</td>
                        <td style="padding: 0.5rem;">{{ $kompetensi->jurusan->nama }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 0.5rem; color: #777;">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
