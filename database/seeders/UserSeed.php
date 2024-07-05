<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "nameTest",
            "last_name" => "lastNameTest",
            "email" => "test@gmail.com",
            'image' => null,
            "password" => bcrypt("test123"),
        ]);

    }
}
