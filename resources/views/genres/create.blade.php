@extends('layouts.app')

@section('title', 'Tambah Genre')

@section('content')
    <h1>Tambah Genre</h1>

    <form class="form" method="POST" action="{{ route('genres.page.store') }}">
        @csrf
        <label>Nama
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        @error('name') <span class="pesan-error">{{ $message }}</span> @enderror

        <label>Deskripsi
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </label>
        @error('description') <span class="pesan-error">{{ $message }}</span> @enderror

        <div class="aksi">
            <button class="btn" type="submit">Simpan</button>
            <a href="{{ route('genres.page.index') }}">Batal</a>
        </div>
    </form>
@endsection
