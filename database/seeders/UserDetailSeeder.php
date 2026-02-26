<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserQR;
use App\Support\HelperRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserDetailSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $ids = UserDetail::create([
            'img'=>null,
            'identification' => '0000',
            'name' => 'ADMINISTRATOR',
            'year' => null,
            'section' => null,
            'user_type' => 0,
        ]);

         User::create([
            'user_detail_id' => $ids->id,
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => 'p@ssw0rd',
            'remember_token' => Str::random(10),
            'user_type' => 0,
        ]);

        $qrcode = HelperRepository::GenerateQrCode($ids);
        UserQR::create($qrcode);

    }
}
       