<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\User;

it('menampilkan halaman daftar genre dan author untuk umum', function () {
    Genre::factory()->create(['name' => 'Fantasi']);
    Author::factory()->create(['name' => 'Tere Liye']);

    $this->get('/genres')->assertOk()->assertSee('Fantasi');
    $this->get('/authors')->assertOk()->assertSee('Tere Liye');
});

it('menampilkan halaman buku dengan harga terformat', function () {
    Book::factory()->create(['title' => 'Bumi', 'price' => 95000]);

    $this->get('/books')->assertOk()->assertSee('Bumi')->assertSee('95.000');
});

it('tamu dan customer tidak boleh membuka form tambah', function () {
    $this->get('/genres/create')->assertUnauthorized();

    $this->actingAs(User::factory()->create())
        ->get('/authors/create')
        ->assertForbidden();
});

it('admin menambah genre lewat form lalu diarahkan ke daftar', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post('/genres', ['name' => 'Sejarah', 'description' => 'Peristiwa masa lalu'])
        ->assertRedirect(route('genres.page.index'))
        ->assertSessionHas('status');

    expect(Genre::where('name', 'Sejarah')->exists())->toBeTrue();
});

it('form menolak nama kosong', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->post('/authors', ['name' => ''])
        ->assertSessionHasErrors('name');
});

it('admin tidak bisa menghapus genre yang masih dipakai buku', function () {
    $buku = Book::factory()->create();

    $this->actingAs(User::factory()->admin()->create())
        ->delete("/genres/{$buku->genre_id}")
        ->assertSessionHasErrors('delete');

    expect(Genre::find($buku->genre_id))->not->toBeNull();
});
