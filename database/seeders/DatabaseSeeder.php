<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Member
        User::updateOrCreate(
            ['email' => 'anggota@example.com'],
            [
                'name' => 'Anggota Koperasi',
                'role' => 'member',
                'password' => bcrypt('password'),
            ]
        );

        // Customer Service
        User::updateOrCreate(
            ['email' => 'cs@example.com'],
            [
                'name' => 'CS Koperasi',
                'role' => 'cs',
                'password' => bcrypt('password'),
            ]
        );

        // Manager
        User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager Pinjam Simpan',
                'role' => 'manager',
                'password' => bcrypt('password'),
            ]
        );

        // Pengurus (Management)
        User::updateOrCreate(
            ['email' => 'pengurus@example.com'],
            [
                'name' => 'Pengurus Koperasi',
                'role' => 'management',
                'password' => bcrypt('password'),
            ]
        );

        // Finance
        User::updateOrCreate(
            ['email' => 'finance@example.com'],
            [
                'name' => 'Bagian Keuangan',
                'role' => 'finance',
                'password' => bcrypt('password'),
            ]
        );
    }
}
