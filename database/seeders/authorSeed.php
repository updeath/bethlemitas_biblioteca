<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class authorSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = new Author();
        $author->name_author = 'Gabriel García Marquez';
        $author->save();

        $author2 = new Author();
        $author2->name_author = 'Jesús Carlos Gómez Martínez';
        $author2->save();

        $author3 = new Author();
        $author3->name_author = 'Edgar Allan Poe';
        $author3->save();
        
    }
}
