<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LoanRequest;
use App\Models\Loan;
use App\Models\Installment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DisbursementController extends Controller
{
    /**
     * Bagian Keuangan mencairkan pinjaman.
     */
    public function disburse(LoanRequest $loanRequest)
    {
        if ($loanRequest->status !== 'approved') {
            return response()->json(['message' => 'Pengajuan belum disetujui akhir'], 422);
        }

        DB::transaction(function () use ($loanRequest) {
            // 1. Update status pengajuan
            $loanRequest->update(['status' => 'disbursed']);

            // 2. Buat record Pinjaman Aktif
            $monthlyInstallment = $loanRequest->amount / $loanRequest->duration; // Perhitungan simpel tanpa bunga

            $loan = Loan::create([
                'user_id' => $loanRequest->user_id,
                'loan_request_id' => $loanRequest->id,
                'total_amount' => $loanRequest->amount,
                'monthly_installment' => $monthlyInstallment,
                'remaining_balance' => $loanRequest->amount,
                'status' => 'active',
            ]);

            // 3. Buat jadwal angsuran (Monitoring)
            for ($i = 1; $i <= $loanRequest->duration; $i++) {
                Installment::create([
                    'loan_id' => $loan->id,
                    'amount' => $monthlyInstallment,
                    'due_date' => Carbon::now()->addMonths($i)->startOfMonth()->addDays(9), // Contoh: Jatuh tempo setiap tanggal 10
                    'status' => 'pending',
                ]);
            }
        });

        return response()->json(['message' => 'Pinjaman berhasil dicairkan dan jadwal angsuran dibuat']);
    }
}
