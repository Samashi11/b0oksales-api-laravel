@extends('layouts.app')

@section('title', 'Ubah Genre')

@section('content')
    <h1>Ubah Genre</h1>

    <form class="form" method="POST" action="{{ route('genres.page.update', $genre) }}">
        @csrf
        @method('PUT')
        <label>Nama
            <input type="text" name="name" value="{{ old('name', $genre->name) }}" required>
        </label>
        @error('name') <span class="pesan-error">{{ $message }}</span> @enderror

        <label>Deskripsi
            <textarea name="description" rows="4">{{ old('description', $genre->description) }}</textarea>
        </label>
        @error('description') <span class="pesan-error">{{ $message }}</span> @enderror

        <div class="aksi">
            <button class="btn" type="submit">Perbarui</button>
            <a href="{{ route('genres.page.show', $genre) }}">Batal</a>
        </div>
    </form>
@endsection
