<?php

use App\Models\User;
use App\Models\Loan;
use App\Models\LoanRequest;
use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = User::where('email', 'anggota@example.com')->first();

if (!$user) {
    echo "User anggota@example.com tidak ditemukan.\n";
    exit;
}

DB::transaction(function () use ($user) {
    $amount = 12000000;
    $duration = 12;
    $monthly = $amount / $duration;

    // 1. Buat Pengajuan Pinjaman (LoanRequest)
    $request = LoanRequest::create([
        'user_id' => $user->id,
        'amount' => $amount,
        'duration' => $duration,
        'purpose' => 'Modal Usaha',
        'status' => 'disbursed',
    ]);

    // 2. Buat Pinjaman Aktif (Loan)
    $loan = Loan::create([
        'user_id' => $user->id,
        'loan_request_id' => $request->id,
        'total_amount' => $amount,
        'monthly_installment' => $monthly,
        'remaining_balance' => $amount,
        'status' => 'active',
    ]);

    // 3. Buat Jadwal Angsuran (Installment)
    for ($i = 1; $i <= $duration; $i++) {
        Installment::create([
            'loan_id' => $loan->id,
            'amount' => $monthly,
            'due_date' => Carbon::now()->addMonths($i)->startOfMonth()->addDays(9),
            'status' => 'pending',
        ]);
    }
});

echo "Data pengajuan, pinjaman, dan angsuran contoh untuk anggota@example.com berhasil dibuat.\n";
