<?php

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Sanctum::actingAs(User::factory()->admin()->create());
});

it('admin menjalankan CRUD genre', function () {
    $id = $this->postJson('/api/genres', ['name' => 'Horor', 'description' => 'Menyeramkan'])
        ->assertCreated()
        ->json('data.id');

    $this->putJson("/api/genres/{$id}", ['name' => 'Horor Klasik'])
        ->assertOk()
        ->assertJsonPath('data.name', 'Horor Klasik');

    $this->getJson("/api/genres/{$id}")->assertOk();

    $this->deleteJson("/api/genres/{$id}")->assertOk();
    $this->getJson("/api/genres/{$id}")->assertNotFound();
});

it('genre wajib punya nama', function () {
    $this->postJson('/api/genres', ['description' => 'tanpa nama'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('name');
});

it('genre yang dipakai buku tidak bisa dihapus', function () {
    $buku = Book::factory()->create();

    $this->deleteJson("/api/genres/{$buku->genre_id}")->assertStatus(409);

    expect(Genre::find($buku->genre_id))->not->toBeNull();
});
