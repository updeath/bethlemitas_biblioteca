<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\editorial;

class editorialSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $editorial = new editorial();
        $editorial->name_editorial = "Diana";
        $editorial->save();

        $editorial2 = new editorial();
        $editorial2->name_editorial = "El tiempo";
        $editorial2->save();

        $editorial3 = new editorial();
        $editorial3->name_editorial = "Norma";
        $editorial3->save();

    }
}
