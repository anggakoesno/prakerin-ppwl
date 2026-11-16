@extends('layouts.app')

@section('title', 'List Jurusan')

@section('content')
    <h1 class="mb-4">List Jurusan</h1>

    <div class="row g-3">
        @forelse ($jurusans as $jurusan)
            <div class="col-md-3">
                <a href="{{ route('jurusan.detail', $jurusan->jurusan_seo) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        @if ($jurusan->foto)
                            <img src="{{ asset('storage/' . $jurusan->foto) }}" class="card-img-top" alt="{{ $jurusan->nama }}"
                                style="height: 160px; object-fit: cover;">
                        @endif
                        <div class="card-body text-center">
                            <h6 class="card-title mb-0">{{ $jurusan->nama }}</h6>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Belum ada data.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $jurusans->links() }}
    </div>
@endsection
