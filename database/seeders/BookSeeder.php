<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'isbn' => 'RB-BOOK-001',
                'description' => 'Kisah perjuangan dan pendidikan anak-anak di Belitung.',
                'stock' => 5,
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'isbn' => 'RB-BOOK-002',
                'description' => 'Novel tentang kehidupan dan masyarakat pada masa kolonial.',
                'stock' => 4,
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publisher' => 'Kompas',
                'isbn' => 'RB-BOOK-003',
                'description' => 'Pengantar praktis untuk memahami filosofi Stoisisme.',
                'stock' => 6,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia',
                'isbn' => 'RB-BOOK-004',
                'description' => 'Panduan membangun kebiasaan baik secara bertahap.',
                'stock' => 3,
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['isbn' => $book['isbn']],
                $book
            );
        }
    }
}