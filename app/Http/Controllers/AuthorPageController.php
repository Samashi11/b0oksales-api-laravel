<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthorPageController extends Controller
{
    public function index(): View
    {
        return view('authors.index', ['authors' => Author::orderBy('name')->get()]);
    }

    public function show(Author $author): View
    {
        return view('authors.show', ['author' => $author]);
    }

    public function create(): View
    {
        return view('authors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Author::create($this->validasi($request));

        return redirect()->route('authors.page.index')->with('status', 'Author berhasil ditambahkan.');
    }

    public function edit(Author $author): View
    {
        return view('authors.edit', ['author' => $author]);
    }

    public function update(Request $request, Author $author): RedirectResponse
    {
        $author->update($this->validasi($request));

        return redirect()->route('authors.page.show', $author)->with('status', 'Author berhasil diperbarui.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        if ($author->books()->exists()) {
            return back()->withErrors(['delete' => 'Author tidak bisa dihapus karena masih punya buku.']);
        }

        $author->delete();

        return redirect()->route('authors.page.index')->with('status', 'Author berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);
    }
}
