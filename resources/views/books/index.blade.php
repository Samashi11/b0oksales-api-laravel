@extends('layouts.app')

@section('title', 'Buku')

@section('content')
    <h1>Daftar Buku</h1>

    <div class="grid">
        @forelse ($books as $buku)
            <article class="kartu">
                <span class="redup">{{ $buku->genre->name }}</span>
                <h2>{{ $buku->title }}</h2>
                <p>{{ $buku->description }}</p>
                <p class="redup">Penulis: {{ $buku->author->name }}</p>
                <p><strong>Rp {{ number_format($buku->price, 0, ',', '.') }}</strong> &middot; stok {{ $buku->stock }}</p>
            </article>
        @empty
            <p>Belum ada buku.</p>
        @endforelse
    </div>
@endsection
