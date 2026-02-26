<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserQRSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'type' => 0,
            'description' => 'ADMINISTRATOR',
        ]);

        UserType::create([
            'type' => 1,
            'description' => 'FACULTY',
        ]);

        UserType::create([
            'type' => 2,
            'description' => 'STUDENT',
        ]);
    }
}