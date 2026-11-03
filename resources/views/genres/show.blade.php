@extends('layouts.app')

@section('title', $genre->name)

@section('content')
    <h1>{{ $genre->name }}</h1>
    <p>{{ $genre->description ?? 'Belum ada deskripsi.' }}</p>
    <p class="redup">Dipakai oleh {{ $genre->books()->count() }} buku.</p>
    <p><a href="{{ route('genres.page.index') }}">&larr; Kembali ke daftar</a></p>
@endsection
