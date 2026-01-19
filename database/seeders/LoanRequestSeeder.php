<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = \App\Models\User::where('role', 'member')->first();

        // 1. Pengajuan baru (untuk CS)
        \App\Models\LoanRequest::create([
            'user_id' => $member->id,
            'amount' => 15000000,
            'duration' => 12,
            'purpose' => 'Renovasi Rumah',
            'status' => 'submitted',
        ]);

        // 2. Pengajuan sudah verif CS (untuk Manager)
        \App\Models\LoanRequest::create([
            'user_id' => $member->id,
            'amount' => 5000000,
            'duration' => 6,
            'purpose' => 'Biaya Sekolah Anak',
            'status' => 'cs_verified',
        ]);

        // 3. Pengajuan sudah analisis Manager (untuk Pengurus)
        \App\Models\LoanRequest::create([
            'user_id' => $member->id,
            'amount' => 25000000,
            'duration' => 24,
            'purpose' => 'Modal Usaha Sembako',
            'status' => 'manager_approved',
        ]);

        // 4. Pengajuan sudah disetujui Pengurus (untuk Keuangan)
        \App\Models\LoanRequest::create([
            'user_id' => $member->id,
            'amount' => 10000000,
            'duration' => 12,
            'purpose' => 'Beli Alat Bengkel',
            'status' => 'approved',
        ]);
    }
}
