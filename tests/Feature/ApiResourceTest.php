<?php

use App\Models\Book;
use App\Models\User;

it('menampilkan daftar buku, genre, dan author tanpa login', function () {
    Book::factory()->count(2)->create();

    foreach (['books', 'genres', 'authors'] as $sumber) {
        $this->getJson("/api/{$sumber}")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(2, 'data');
    }
});

it('membalas 404 berformat JSON untuk data yang tidak ada', function () {
    $this->getJson('/api/books/9999')
        ->assertNotFound()
        ->assertJsonPath('success', false);
});

it('mendaftarkan pelanggan baru dengan role customer', function () {
    $this->postJson('/api/register', [
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'password' => 'rahasia123',
        'role' => 'admin', // percobaan menyelundupkan role harus diabaikan
    ])
        ->assertCreated()
        ->assertJsonPath('data.user.role', 'customer')
        ->assertJsonStructure(['data' => ['token']]);
});

it('login berhasil memberi token, password salah ditolak', function () {
    $user = User::factory()->create(['email' => 'ani@example.com']);

    $this->postJson('/api/login', ['email' => 'ani@example.com', 'password' => 'password'])
        ->assertOk()
        ->assertJsonStructure(['data' => ['token']]);

    $this->postJson('/api/login', ['email' => $user->email, 'password' => 'salah'])
        ->assertUnauthorized();
});
