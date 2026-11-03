@extends('layouts.app')

@section('title', 'Author')

@section('content')
    <h1>Daftar Author</h1>
    <p><a class="btn" href="{{ route('authors.page.create') }}">+ Tambah author</a></p>

    @error('delete')
        <p class="pesan-error" role="alert">{{ $message }}</p>
    @enderror

    <div class="grid">
        @forelse ($authors as $author)
            <article class="kartu">
                <span class="redup">#{{ $author->id }}</span>
                <h2>{{ $author->name }}</h2>
                <p>{{ \Illuminate\Support\Str::limit($author->bio ?? '', 90) }}</p>
                <div class="aksi">
                    <a href="{{ route('authors.page.show', $author) }}">Detail</a>
                    <a href="{{ route('authors.page.edit', $author) }}">Ubah</a>
                    <form method="POST" action="{{ route('authors.page.destroy', $author) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-bahaya" type="submit">Hapus</button>
                    </form>
                </div>
            </article>
        @empty
            <p>Belum ada data author.</p>
        @endforelse
    </div>
@endsection
