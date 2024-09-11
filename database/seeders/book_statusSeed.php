<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book_statu;

class book_statusSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statu = new Book_statu();
        $statu->state = 'Bueno';
        $statu->save();

        $statu2 = new Book_statu();
        $statu2->state = 'Regular';
        $statu2->save();

        $statu3 = new Book_statu();
        $statu3->state = 'Malo u obsoleto';
        $statu3->save();
    }
}
