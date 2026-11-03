<?php

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('customer membuat transaksi dan total dihitung server', function () {
    $pelanggan = User::factory()->create();
    $buku = Book::factory()->create(['price' => 85000]);
    Sanctum::actingAs($pelanggan);

    $this->postJson('/api/transactions', [
        'order_number' => 'ORD-001',
        'book_id' => $buku->id,
        'quantity' => 3,
    ])
        ->assertCreated()
        ->assertJsonPath('data.total_amount', '255000.00')
        ->assertJsonPath('data.customer_id', $pelanggan->id);
});

it('menolak total_amount dan customer_id yang dikirim klien', function () {
    Sanctum::actingAs(User::factory()->create());
    $buku = Book::factory()->create();

    $this->postJson('/api/transactions', [
        'order_number' => 'ORD-002',
        'book_id' => $buku->id,
        'quantity' => 1,
        'total_amount' => 1,
        'customer_id' => 999,
    ])->assertUnprocessable()->assertJsonValidationErrors(['total_amount', 'customer_id']);
});

it('nomor order harus unik dan jumlah minimal 1', function () {
    Sanctum::actingAs(User::factory()->create());
    $buku = Book::factory()->create();

    $this->postJson('/api/transactions', ['order_number' => 'ORD-003', 'book_id' => $buku->id, 'quantity' => 1])
        ->assertCreated();

    $this->postJson('/api/transactions', ['order_number' => 'ORD-003', 'book_id' => $buku->id, 'quantity' => 1])
        ->assertUnprocessable()->assertJsonValidationErrors('order_number');

    $this->postJson('/api/transactions', ['order_number' => 'ORD-004', 'book_id' => $buku->id, 'quantity' => 0])
        ->assertUnprocessable()->assertJsonValidationErrors('quantity');
});

it('customer tidak bisa melihat atau mengubah transaksi orang lain', function () {
    $milikOrangLain = Transaction::create([
        'order_number' => 'ORD-X',
        'customer_id' => User::factory()->create()->id,
        'book_id' => Book::factory()->create()->id,
        'quantity' => 1,
        'total_amount' => 10000,
    ]);

    Sanctum::actingAs(User::factory()->create());

    $this->getJson("/api/transactions/{$milikOrangLain->id}")->assertNotFound();
    $this->putJson("/api/transactions/{$milikOrangLain->id}", ['quantity' => 5])->assertNotFound();
});

it('mengubah jumlah akan menghitung ulang total', function () {
    $pelanggan = User::factory()->create();
    $buku = Book::factory()->create(['price' => 10000]);
    Sanctum::actingAs($pelanggan);

    $id = $this->postJson('/api/transactions', ['order_number' => 'ORD-005', 'book_id' => $buku->id, 'quantity' => 1])
        ->json('data.id');

    $this->putJson("/api/transactions/{$id}", ['quantity' => 4])
        ->assertOk()
        ->assertJsonPath('data.total_amount', '40000.00');
});

it('admin boleh melihat semua dan menghapus transaksi, tetapi tidak boleh membeli', function () {
    $transaksi = Transaction::create([
        'order_number' => 'ORD-A',
        'customer_id' => User::factory()->create()->id,
        'book_id' => Book::factory()->create()->id,
        'quantity' => 1,
        'total_amount' => 10000,
    ]);

    Sanctum::actingAs(User::factory()->admin()->create());

    $this->getJson('/api/transactions')->assertOk()->assertJsonCount(1, 'data');
    $this->postJson('/api/transactions', [])->assertForbidden();
    $this->deleteJson("/api/transactions/{$transaksi->id}")->assertOk();
});

it('tamu tidak bisa memakai endpoint transaksi', function () {
    $this->getJson('/api/transactions')->assertUnauthorized();
    $this->postJson('/api/transactions', [])->assertUnauthorized();
});
