<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'is_active' => 1,
            'role' => User::ADMIN_ROLE,
        ]);
    }
}
