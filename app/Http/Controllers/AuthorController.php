<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->sukses(Author::orderBy('name')->get(), 'Get All Resource');
    }

    public function show(Author $author): JsonResponse
    {
        return $this->sukses($author, 'Get Detail Resource');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        return $this->sukses(Author::create($data), 'Resource created successfully', 201);
    }

    public function update(Request $request, Author $author): JsonResponse
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        $author->update($data);

        return $this->sukses($author, 'Resource updated successfully');
    }

    public function destroy(Author $author): JsonResponse
    {
        if ($author->books()->exists()) {
            return $this->gagal('Author masih punya buku, tidak bisa dihapus.', 409);
        }

        $author->delete();

        return $this->sukses(null, 'Resource deleted successfully');
    }
}
