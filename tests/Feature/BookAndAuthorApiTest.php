<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('daftar buku memuat nama author dan genre', function () {
    $buku = Book::factory()->create();

    $this->getJson('/api/books')
        ->assertOk()
        ->assertJsonPath('data.0.author.name', $buku->author->name)
        ->assertJsonPath('data.0.genre.name', $buku->genre->name);
});

it('admin bisa menambah buku dengan author dan genre yang valid', function () {
    Sanctum::actingAs(User::factory()->admin()->create());

    $this->postJson('/api/books', [
        'title' => 'Buku Baru',
        'price' => 50000,
        'stock' => 5,
        'genre_id' => Genre::factory()->create()->id,
        'author_id' => Author::factory()->create()->id,
    ])->assertCreated()->assertJsonPath('data.title', 'Buku Baru');

    expect(Book::where('title', 'Buku Baru')->exists())->toBeTrue();
});

it('menolak buku dengan genre atau author yang tidak ada', function () {
    Sanctum::actingAs(User::factory()->admin()->create());

    $this->postJson('/api/books', [
        'title' => 'Buku Ngawur',
        'price' => 1000,
        'stock' => 1,
        'genre_id' => 999,
        'author_id' => 999,
    ])->assertUnprocessable()->assertJsonValidationErrors(['genre_id', 'author_id']);
});

it('author yang masih punya buku tidak bisa dihapus', function () {
    Sanctum::actingAs(User::factory()->admin()->create());
    $buku = Book::factory()->create();

    $this->deleteJson("/api/authors/{$buku->author_id}")->assertStatus(409);

    expect(Author::find($buku->author_id))->not->toBeNull();
});
