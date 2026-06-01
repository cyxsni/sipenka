<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Umum',
            'email' => 'admin@dindik.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // User Bidang PGTK
        User::create([
            'name' => 'PGTK User',
            'email' => 'pgtk@dindik.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'bidang' => 'PGTK',
            'email_verified_at' => now(),
        ]);

        // User Bidang SD
        User::create([
            'name' => 'SD User',
            'email' => 'sd@dindik.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'bidang' => 'SD',
            'email_verified_at' => now(),
        ]);
    }
}