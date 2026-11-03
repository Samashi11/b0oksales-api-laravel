@extends('layouts.app')

@section('title', 'Tambah Author')

@section('content')
    <h1>Tambah Author</h1>

    <form class="form" method="POST" action="{{ route('authors.page.store') }}">
        @csrf
        <label>Nama
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label>
        @error('name') <span class="pesan-error">{{ $message }}</span> @enderror

        <label>Nama file foto
            <input type="text" name="photo" value="{{ old('photo') }}">
        </label>
        @error('photo') <span class="pesan-error">{{ $message }}</span> @enderror

        <label>Biografi
            <textarea name="bio" rows="4">{{ old('bio') }}</textarea>
        </label>
        @error('bio') <span class="pesan-error">{{ $message }}</span> @enderror

        <div class="aksi">
            <button class="btn" type="submit">Simpan</button>
            <a href="{{ route('authors.page.index') }}">Batal</a>
        </div>
    </form>
@endsection
