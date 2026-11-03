<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class BookSalesSeeder extends Seeder
{
    public function run(): void
    {
        $dataAuthor = [
            ['name' => 'Tere Liye', 'photo' => 'tere_liye.jpg', 'bio' => 'Penulis novel terkenal dari Indonesia.'],
            ['name' => 'Andrea Hirata', 'photo' => 'andrea.jpg', 'bio' => 'Penulis novel Laskar Pelangi.'],
            ['name' => 'J.K. Rowling', 'photo' => 'rowling.jpg', 'bio' => 'Penulis serial populer Harry Potter.'],
            ['name' => 'Agatha Christie', 'photo' => 'agatha.jpg', 'bio' => 'Penulis novel detektif kawakan.'],
            ['name' => 'Dee Lestari', 'photo' => 'dee.jpg', 'bio' => 'Penulis seri Supernova.'],
        ];

        $dataGenre = [
            ['name' => 'Fantasi', 'description' => 'Cerita dengan dunia dan unsur sihir.'],
            ['name' => 'Inspiratif', 'description' => 'Kisah perjuangan yang memotivasi.'],
            ['name' => 'Misteri', 'description' => 'Teka-teki dan kasus yang harus dipecahkan.'],
            ['name' => 'Romansa', 'description' => 'Cerita bertema cinta.'],
            ['name' => 'Petualangan', 'description' => 'Perjalanan penuh tantangan.'],
        ];

        foreach ($dataAuthor as $baris) {
            Author::updateOrCreate(['name' => $baris['name']], $baris);
        }

        foreach ($dataGenre as $baris) {
            Genre::updateOrCreate(['name' => $baris['name']], $baris);
        }

        // buku dihubungkan ke author & genre lewat NAMA, bukan angka id
        $dataBuku = [
            ['Bumi', 'Petualangan 3 sahabat di dunia paralel.', 95000, 20, 'bumi.jpg', 'Tere Liye', 'Fantasi'],
            ['Laskar Pelangi', 'Kisah inspiratif anak-anak Belitung.', 85000, 15, 'laskar.jpg', 'Andrea Hirata', 'Inspiratif'],
            ['Harry Potter and the Philosopher Stone', 'Awal petualangan penyihir muda.', 150000, 10, 'hp.jpg', 'J.K. Rowling', 'Fantasi'],
            ['Murder on the Orient Express', 'Kasus pembunuhan di dalam kereta malam.', 75000, 12, 'orient.jpg', 'Agatha Christie', 'Misteri'],
            ['Perahu Kertas', 'Kisah perjuangan meraih cita-cita dan cinta.', 88000, 18, 'perahu.jpg', 'Dee Lestari', 'Romansa'],
        ];

        foreach ($dataBuku as [$judul, $deskripsi, $harga, $stok, $sampul, $namaAuthor, $namaGenre]) {
            Book::updateOrCreate(
                ['title' => $judul],
                [
                    'description' => $deskripsi,
                    'price' => $harga,
                    'stock' => $stok,
                    'cover_photo' => $sampul,
                    'author_id' => Author::where('name', $namaAuthor)->value('id'),
                    'genre_id' => Genre::where('name', $namaGenre)->value('id'),
                ]
            );
        }
    }
}
