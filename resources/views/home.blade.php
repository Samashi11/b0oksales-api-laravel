@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h1>Toko Buku BookSales</h1>
    <p>Pilih salah satu menu untuk melihat katalog.</p>

    <div class="grid">
        <section class="kartu">
            <h2>Buku</h2>
            <p>Daftar buku lengkap dengan author dan genre.</p>
            <p><a href="{{ route('books.page.index') }}">Lihat buku &rarr;</a></p>
        </section>
        <section class="kartu">
            <h2>Genre</h2>
            <p>Kategori buku yang tersedia.</p>
            <p><a href="{{ route('genres.page.index') }}">Lihat genre &rarr;</a></p>
        </section>
        <section class="kartu">
            <h2>Author</h2>
            <p>Para penulis di katalog kami.</p>
            <p><a href="{{ route('authors.page.index') }}">Lihat author &rarr;</a></p>
        </section>
    </div>
@endsection
