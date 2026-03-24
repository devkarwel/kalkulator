<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ID_001',
            'email' => 'admin@karwel.com.pl',
            'phone' => '123456789',
            'company' => 'Karwel',
            'address' => 'Tesowa 1',
            'role' => UserRole::ADMIN,
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => null,
        ]);

        User::create([
            'name' => '128391823',
            'email' => 'user@test.pl',
            'phone' => '123456789',
            'company' => 'Karwel',
            'address' => 'Tesowa 133',
            'role' => UserRole::USER,
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('user'),
            'remember_token' => null,
        ]);
    }
}
