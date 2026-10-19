@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h1 style="margin-bottom: 0;">Data Jurusan</h1>
        <a href="{{ route('jurusan.create') }}" style="padding: 0.45rem 1rem; background: #1b1b18; color: #fff; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">Tambah Jurusan</a>
    </div>

    <div class="card">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid #e3e3e0; text-align: left;">
                    <th style="padding: 0.5rem;">Kode</th>
                    <th style="padding: 0.5rem;">Nama</th>
                    <th style="padding: 0.5rem;">Jumlah Kompetensi</th>
                    <th style="padding: 0.5rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jurusans as $jurusan)
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 0.5rem;">{{ $jurusan->kode }}</td>
                        <td style="padding: 0.5rem;">{{ $jurusan->nama }}</td>
                        <td style="padding: 0.5rem;">{{ $jurusan->kompetensi_count }}</td>
                        <td style="padding: 0.5rem;">
                            <a href="{{ route('jurusan.edit', $jurusan) }}" style="color: #06c; margin-right: 0.75rem;">Edit</a>
                            <form method="POST" action="{{ route('jurusan.destroy', $jurusan) }}" style="display: inline;" onsubmit="return confirm('Hapus jurusan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #c00; cursor: pointer; padding: 0; font-size: 0.9rem;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 0.5rem; color: #777;">Belum ada data jurusan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
