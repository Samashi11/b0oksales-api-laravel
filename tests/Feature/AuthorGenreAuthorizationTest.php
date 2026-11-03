<?php

use App\Models\Author;
use App\Models\Genre;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

// [segmen URL API, kelas model]
dataset('sumber', [
    'genre'  => ['genres', Genre::class],
    'author' => ['authors', Author::class],
]);

it('menolak tamu (belum login) menulis data', function (string $sumber, string $model) {
    $data = $model::factory()->create();

    $this->postJson("/api/{$sumber}", ['name' => 'Baru'])->assertUnauthorized();
    $this->putJson("/api/{$sumber}/{$data->id}", ['name' => 'Ubah'])->assertUnauthorized();
    $this->deleteJson("/api/{$sumber}/{$data->id}")->assertUnauthorized();
})->with('sumber');

it('menolak customer menulis data', function (string $sumber, string $model) {
    $data = $model::factory()->create();
    Sanctum::actingAs(User::factory()->create());

    $this->postJson("/api/{$sumber}", ['name' => 'Baru'])->assertForbidden();
    $this->putJson("/api/{$sumber}/{$data->id}", ['name' => 'Ubah'])->assertForbidden();
    $this->deleteJson("/api/{$sumber}/{$data->id}")->assertForbidden();
})->with('sumber');

it('mengizinkan admin menulis data', function (string $sumber, string $model) {
    $data = $model::factory()->create();
    Sanctum::actingAs(User::factory()->admin()->create());

    $this->postJson("/api/{$sumber}", ['name' => 'Baru'])->assertCreated();
    $this->putJson("/api/{$sumber}/{$data->id}", ['name' => 'Ubah'])->assertOk();
    $this->deleteJson("/api/{$sumber}/{$data->id}")->assertOk();
})->with('sumber');
