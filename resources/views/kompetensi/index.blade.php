@extends('layouts.app')

@section('title', 'Kompetensi')

@section('content')
    <h1>Data Kompetensi</h1>

    <div class="card">
        <form method="GET" action="{{ route('kompetensi.index') }}" style="margin-bottom: 1rem; display: flex; gap: 0.75rem; align-items: end;">
            <div>
                <label for="jurusan_id" style="display: block; font-size: 0.85rem; margin-bottom: 0.25rem;">Jurusan</label>
                <select name="jurusan_id" id="jurusan_id" style="padding: 0.4rem 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">Semua Jurusan</option>
                    @foreach ($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" @selected($selectedJurusan === $jurusan->id)>{{ $jurusan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" style="padding: 0.45rem 1rem; background: #1b1b18; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            @if ($selectedJurusan)
                <a href="{{ route('kompetensi.index') }}" style="padding: 0.45rem 0.5rem; color: #444; font-size: 0.85rem;">Reset</a>
            @endif
        </form>

        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                    <th style="padding: 0.5rem;">Kode</th>
                    <th style="padding: 0.5rem;">Nama</th>
                    <th style="padding: 0.5rem;">Jurusan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kompetensi as $item)
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 0.5rem;">{{ $item->kode }}</td>
                        <td style="padding: 0.5rem;">{{ $item->nama }}</td>
                        <td style="padding: 0.5rem;">{{ $item->jurusan->nama }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 0.5rem; color: #777;">Tidak ada data kompetensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
