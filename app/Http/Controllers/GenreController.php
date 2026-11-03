<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->sukses(Genre::orderBy('name')->get(), 'Get All Resource');
    }

    public function show(Genre $genre): JsonResponse
    {
        return $this->sukses($genre, 'Get Detail Resource');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return $this->sukses(Genre::create($data), 'Resource created successfully', 201);
    }

    public function update(Request $request, Genre $genre): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $genre->update($data);

        return $this->sukses($genre, 'Resource updated successfully');
    }

    public function destroy(Genre $genre): JsonResponse
    {
        if ($genre->books()->exists()) {
            return $this->gagal('Genre masih dipakai oleh buku, tidak bisa dihapus.', 409);
        }

        $genre->delete();

        return $this->sukses(null, 'Resource deleted successfully');
    }
}
