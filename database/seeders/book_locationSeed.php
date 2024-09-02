<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book_location;

class book_locationSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $location = new Book_location();
        $location->location = 'Biblioteca';
        $location->save();
    }
}
