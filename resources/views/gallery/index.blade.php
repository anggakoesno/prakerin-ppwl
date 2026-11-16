@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Gallery</h1>
        <a href="{{ route('gallery.create') }}" class="btn btn-dark btn-sm">Upload Gambar</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-2">
                @forelse ($galleries as $gallery)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip"
                            data-title="{{ $gallery->description }}">
                            <img class="img-fluid rounded mb-2"
                                src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->title }}">
                        </a>
                        <div class="d-flex gap-1 mb-2">
                            <a href="{{ route('gallery.edit', $gallery) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('gallery.destroy', $gallery) }}" class="d-inline"
                                onsubmit="return confirm('Hapus gambar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Tidak ada data.</div>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>
@endsection
