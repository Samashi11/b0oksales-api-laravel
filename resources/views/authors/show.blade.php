@extends('layouts.app')

@section('title', $author->name)

@section('content')
    <h1>{{ $author->name }}</h1>
    <p class="redup">Foto: {{ $author->photo ?? '-' }}</p>
    <p>{{ $author->bio ?? 'Belum ada biografi.' }}</p>
    <p class="redup">Menulis {{ $author->books()->count() }} buku.</p>
    <p><a href="{{ route('authors.page.index') }}">&larr; Kembali ke daftar</a></p>
@endsection
