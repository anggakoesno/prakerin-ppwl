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
        @php $total = $jurusans->count() + $kompetensis->count(); @endphp

        @if ($total > 0)
            <div style="background: #e6f6e6; border: 1px solid #9fd89f; color: #1e6b23; padding: 0.65rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                Ditemukan <strong>{{ $total }}</strong> data dengan kata: <strong>{{ $q }}</strong>
            </div>
        @else
            <div style="background: #fff7e6; border: 1px solid #e6c66b; color: #8a6100; padding: 0.65rem 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <strong>Data "{{ $q }}" tidak ditemukan</strong>
                <div style="margin-top: 0.5rem;">
                    <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 0.35rem 0.85rem; background: #1b1b18; color: #fff; border-radius: 4px; text-decoration: none; font-size: 0.85rem;">Kembali</a>
                </div>
            </div>
        @endif

        @if ($total > 0)
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
    @endif
@endsection
