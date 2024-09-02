<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classification;

class classificationSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clasif = new Classification();
        $clasif->clasifPGC = '099';
        $clasif->name_classification = 'Libros notables por su formato';
        $clasif->save();
    }
}
