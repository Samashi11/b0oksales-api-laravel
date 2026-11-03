<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        $buku = Book::with(['author', 'genre'])->orderBy('title')->get();

        return $this->sukses($buku, 'Get All Resource');
    }

    public function show(Book $book): JsonResponse
    {
        return $this->sukses($book->load(['author', 'genre']), 'Get Detail Resource');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'cover_photo' => 'nullable|string|max:255',
            'genre_id'    => 'required|integer|exists:genres,id',
            'author_id'   => 'required|integer|exists:authors,id',
        ]);

        $buku = Book::create($data);

        return $this->sukses($buku->load(['author', 'genre']), 'Resource created successfully', 201);
    }

    public function update(Request $request, Book $book): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
            'cover_photo' => 'nullable|string|max:255',
            'genre_id'    => 'sometimes|required|integer|exists:genres,id',
            'author_id'   => 'sometimes|required|integer|exists:authors,id',
        ]);

        $book->update($data);

        return $this->sukses($book->load(['author', 'genre']), 'Resource updated successfully');
    }

    public function destroy(Book $book): JsonResponse
    {
        // buku yang sudah pernah dibeli tidak boleh hilang (FK transactions = restrict)
        if ($book->transactions()->exists()) {
            return $this->gagal('Buku tidak bisa dihapus karena sudah ada transaksinya.', 409);
        }

        $book->delete();

        return $this->sukses(null, 'Resource deleted successfully');
    }
}
