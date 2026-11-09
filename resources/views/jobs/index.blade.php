@extends('layouts.app')

@section('title', 'Daftar Lowongan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Daftar Lowongan</h1>
        <a href="{{ route('jobs.create') }}" class="btn btn-dark btn-sm">Tambah Lowongan</a>
    </div>

    <div class="row g-3 mb-3">
        @foreach ($jobs as $job)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if ($job->logo)
                        <img src="{{ asset('storage/' . $job->logo) }}" class="card-img-top" alt="logo"
                            style="height: 160px; object-fit: contain;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $job->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $job->company }}</h6>
                        <p class="card-text small mb-1"><strong>Lokasi:</strong> {{ $job->location }}</p>
                        <p class="card-text small mb-1"><strong>Jenis:</strong> {{ $job->jenis_pekerjaan ?? '-' }}</p>
                        <p class="card-text small"><strong>Gaji:</strong> {{ $job->salary }}</p>
                    </div>
                    <div class="card-footer bg-white d-flex gap-2">
                        <a href="{{ route('jobs.edit', $job) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="POST" action="{{ route('jobs.destroy', $job) }}" class="d-inline"
                            onsubmit="return confirm('Hapus data?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $jobs->links() }}
    </div>
@endsection
