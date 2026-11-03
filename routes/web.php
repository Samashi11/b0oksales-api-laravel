<?php

use App\Http\Controllers\AuthorPageController;
use App\Http\Controllers\GenrePageController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/books', function () {
    $buku = Book::with(['author', 'genre'])->orderBy('title')->get();

    return view('books.index', ['books' => $buku]);
})->name('books.page.index');

$halaman = [
    'genres'  => GenrePageController::class,
    'authors' => AuthorPageController::class,
];

foreach ($halaman as $uri => $controller) {
    Route::resource($uri, $controller)
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->names("{$uri}.page")
        ->middleware('admin');

    Route::resource($uri, $controller)
        ->only(['index', 'show'])
        ->names("{$uri}.page");
}
