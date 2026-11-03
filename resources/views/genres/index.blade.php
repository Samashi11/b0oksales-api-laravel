@extends('layouts.app')

@section('title', 'Genre')

@section('content')
    <h1>Daftar Genre</h1>
    <p><a class="btn" href="{{ route('genres.page.create') }}">+ Tambah genre</a></p>

    @error('delete')
        <p class="pesan-error" role="alert">{{ $message }}</p>
    @enderror

    <div class="grid">
        @forelse ($genres as $genre)
            <article class="kartu">
                <span class="redup">#{{ $genre->id }}</span>
                <h2>{{ $genre->name }}</h2>
                <p>{{ \Illuminate\Support\Str::limit($genre->description ?? '', 90) }}</p>
                <div class="aksi">
                    <a href="{{ route('genres.page.show', $genre) }}">Detail</a>
                    <a href="{{ route('genres.page.edit', $genre) }}">Ubah</a>
                    <form method="POST" action="{{ route('genres.page.destroy', $genre) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-bahaya" type="submit">Hapus</button>
                    </form>
                </div>
            </article>
        @empty
            <p>Belum ada data genre.</p>
        @endforelse
    </div>
@endsection
