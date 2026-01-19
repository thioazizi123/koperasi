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
        User::factory()->create([
            'name' => 'Anggota Koperasi',
            'email' => 'anggota@example.com',
            'role' => 'member',
            'password' => bcrypt('password'),
        ]);

        // Customer Service
        User::factory()->create([
            'name' => 'CS Koperasi',
            'email' => 'cs@example.com',
            'role' => 'cs',
            'password' => bcrypt('password'),
        ]);

        // Manager
        User::factory()->create([
            'name' => 'Manager Pinjam Simpan',
            'email' => 'manager@example.com',
            'role' => 'manager',
            'password' => bcrypt('password'),
        ]);

        // Pengurus (Management)
        User::factory()->create([
            'name' => 'Pengurus Koperasi',
            'email' => 'pengurus@example.com',
            'role' => 'management',
            'password' => bcrypt('password'),
        ]);

        // Finance
        User::factory()->create([
            'name' => 'Bagian Keuangan',
            'email' => 'finance@example.com',
            'role' => 'finance',
            'password' => bcrypt('password'),
        ]);
    }
}
