<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // password kedua akun: "password"
        User::factory()->admin()->create([
            'name' => 'Admin Toko',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Pelanggan Contoh',
            'email' => 'customer@example.com',
        ]);

        $this->call(BookSalesSeeder::class);
    }
}
