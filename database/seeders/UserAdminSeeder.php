<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'admin jago',
            'email' => 'admin@gmail.com',
            'zip_code'=>40132,
            'role' => User::ROLE_ADMIN,
            'password' => 'admin',
            'avatar_url' => 'https://www.clipartmax.com/png/middle/347-3473462_blue-icon-data-public-clip-art-black-and-white-library-link-icon.png',
        ]);
    }
}
