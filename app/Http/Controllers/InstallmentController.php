<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Installment;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    /**
     * Menampilkan daftar angsuran untuk anggota.
     */
    public function index()
    {
        $user = auth()->user();
        $loans = Loan::where('user_id', $user->id)
            ->with(['installments' => function($query) {
                $query->orderBy('due_date', 'asc');
            }])
            ->get();

        return view('installments.index', compact('loans'));
    }

    /**
     * Mencatat pembayaran angsuran.
     */
    public function pay(Installment $installment)
    {
        if ($installment->status === 'paid') {
            return back()->with('error', 'Angsuran sudah lunas');
        }

        DB::transaction(function () use ($installment) {
            // 1. Update status angsuran
            $installment->update([
                'status' => 'paid',
                'paid_at' => Carbon::now(),
            ]);

            // 2. Kurangi sisa saldo pinjaman
            $loan = $installment->loan;
            $loan->decrement('remaining_balance', $installment->amount);

            // 3. Jika saldo 0, tandai pinjaman lunas
            if ($loan->remaining_balance <= 0) {
                $loan->update(['status' => 'completed']);
            }
        });

        return redirect()->route('installments.index')->with('success', 'Pembayaran angsuran berhasil dicatat');
    }

    /**
     * Monitoring: Mencari angsuran yang telat.
     */
    public function monitorLatePayments()
    {
        $lateInstallments = Installment::where('status', 'pending')
            ->where('due_date', '<', Carbon::today())
            ->get();

        foreach ($lateInstallments as $installment) {
            $installment->update(['status' => 'late']);
            // Di sini bisa ditambahkan logika kirim notifikasi/denda (Ingatkan / denda di diagram)
        }

        return response()->json([
            'message' => 'Monitoring selesai',
            'late_count' => $lateInstallments->count()
        ]);
    }
}
