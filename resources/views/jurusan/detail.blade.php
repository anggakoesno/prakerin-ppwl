@extends('layouts.app')

@section('title', 'Detail Jurusan')

@section('content')
    <section class="py-3 text-center bg-light">
        <div class="container">
            <h2>Jurusan: {{ $jurusan->nama }}</h2>
            <hr>
            <div class="row">
                @if ($jurusan->foto)
                    <div class="col-md-4 mb-3">
                        <a href="{{ asset('storage/' . $jurusan->foto) }}" data-lightbox="image-1"
                            data-title="{{ $jurusan->nama }}">
                            <img src="{{ asset('storage/' . $jurusan->foto) }}" style="width:200px; height:150px"
                                class="rounded">
                        </a>
                    </div>
                @endif
                @foreach ($kompetensis as $kompetensi)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $kompetensi->kode }}</h5>
                                <p class="card-text">{{ $kompetensi->nama }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">{{ $kompetensis->links() }}</div>
        </div>
    </section>
@endsection
