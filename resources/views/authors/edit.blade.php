@extends('layouts.app')

@section('title', 'Ubah Author')

@section('content')
    <h1>Ubah Author</h1>

    <form class="form" method="POST" action="{{ route('authors.page.update', $author) }}">
        @csrf
        @method('PUT')
        <label>Nama
            <input type="text" name="name" value="{{ old('name', $author->name) }}" required>
        </label>
        @error('name') <span class="pesan-error">{{ $message }}</span> @enderror

        <label>Nama file foto
            <input type="text" name="photo" value="{{ old('photo', $author->photo) }}">
        </label>
        @error('photo') <span class="pesan-error">{{ $message }}</span> @enderror

        <label>Biografi
            <textarea name="bio" rows="4">{{ old('bio', $author->bio) }}</textarea>
        </label>
        @error('bio') <span class="pesan-error">{{ $message }}</span> @enderror

        <div class="aksi">
            <button class="btn" type="submit">Perbarui</button>
            <a href="{{ route('authors.page.show', $author) }}">Batal</a>
        </div>
    </form>
@endsection
