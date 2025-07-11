<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('masud'),
        ]);

        // Create gudang user
        User::create([
            'name' => 'Gudang',
            'email' => 'gudang@gudang.com',
            'password' => Hash::make('admingudang'),
        ]);
    }
} 