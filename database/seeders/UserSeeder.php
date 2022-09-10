<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        User::create([
            'role_id' => 1,
            'name' => "mr admin",
            'email' => "admin@gmail.com",
            'phone' => "0161234567",
            'cv_link' => " ",
            'status' => "active",
            'password' => Hash::make('@12345678'),
        ]);

        // ten dummy user
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'role_id' => 2,
                'name' => "user $i",
                'email' => "user$i@gmail.com",
                'phone' => "016123457$i",
                'cv_link' => "https://docs.google.com/document/d/1ekrOEsxs9c1S-Rl9C1d1SgYEpTu5BgufBtbpOnTEXgo/edit?usp=sharing&$i",
                'status' => "pending",
                'password' => Hash::make('@12345678'),
            ]);
        }
    }
}
