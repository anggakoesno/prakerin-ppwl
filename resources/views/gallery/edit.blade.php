@extends('layouts.app')

@section('title', 'Edit Gambar')

@section('content')
    <h1 class="mb-3">Edit Gambar</h1>

    <div class="card shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('gallery.update', $post) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                        class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $post->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar saat ini</label>
                    @if ($post->picture && $post->picture !== 'noimage.png')
                        <div class="mb-2">
                            <img src="{{ asset('storage/posts_image/' . $post->picture) }}" alt="" width="120"
                                class="rounded">
                        </div>
                    @endif
                    <label for="picture" class="form-label">Ganti Gambar (opsional)</label>
                    <input type="file" name="picture" id="picture" accept="image/*"
                        class="form-control @error('picture') is-invalid @enderror">
                    @error('picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Simpan</button>
                    <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
