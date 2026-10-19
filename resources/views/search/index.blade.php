@extends('layouts.app')

@section('title', 'Pencarian')

@section('content')
    <h1>Pencarian</h1>

    <div class="card" style="margin-bottom: 1.5rem;">
        <form method="GET" action="{{ route('search.index') }}" style="display: flex; gap: 0.75rem;">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Cari jurusan atau kompetensi..."
                style="flex: 1; padding: 0.45rem 0.6rem; border: 1px solid #ccc; border-radius: 4px;"
            >
            <button type="submit" style="padding: 0.45rem 1rem; background: #1b1b18; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Cari</button>
        </form>
    </div>

    @if ($q !== '')
        <div class="card" style="margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">Jurusan ({{ $jurusans->count() }})</h2>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead>
                    <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                        <th style="padding: 0.5rem;">Kode</th>
                        <th style="padding: 0.5rem;">Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jurusans as $jurusan)
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td style="padding: 0.5rem;">{{ $jurusan->kode }}</td>
                            <td style="padding: 0.5rem;">{{ $jurusan->nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="padding: 0.5rem; color: #777;">Tidak ada jurusan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">Kompetensi ({{ $kompetensis->count() }})</h2>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead>
                    <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                        <th style="padding: 0.5rem;">Kode</th>
                        <th style="padding: 0.5rem;">Nama</th>
                        <th style="padding: 0.5rem;">Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kompetensis as $kompetensi)
                        <tr style="border-bottom: 1px solid #f0f0f0;">
                            <td style="padding: 0.5rem;">{{ $kompetensi->kode }}</td>
                            <td style="padding: 0.5rem;">{{ $kompetensi->nama }}</td>
                            <td style="padding: 0.5rem;">{{ $kompetensi->jurusan->nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 0.5rem; color: #777;">Tidak ada kompetensi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection
