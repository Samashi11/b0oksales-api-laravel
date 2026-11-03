<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GenrePageController extends Controller
{
    public function index(): View
    {
        return view('genres.index', ['genres' => Genre::orderBy('name')->get()]);
    }

    public function show(Genre $genre): View
    {
        return view('genres.show', ['genre' => $genre]);
    }

    public function create(): View
    {
        return view('genres.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Genre::create($this->validasi($request));

        return redirect()->route('genres.page.index')->with('status', 'Genre berhasil ditambahkan.');
    }

    public function edit(Genre $genre): View
    {
        return view('genres.edit', ['genre' => $genre]);
    }

    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $genre->update($this->validasi($request));

        return redirect()->route('genres.page.show', $genre)->with('status', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        if ($genre->books()->exists()) {
            return back()->withErrors(['delete' => 'Genre tidak bisa dihapus karena masih dipakai buku.']);
        }

        $genre->delete();

        return redirect()->route('genres.page.index')->with('status', 'Genre berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    }
}
