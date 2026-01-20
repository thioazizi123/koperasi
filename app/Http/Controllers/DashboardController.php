<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect staff ke halaman kerja masing-masing
        if ($user->role === 'cs') {
            return redirect()->route('cs.verifikasi');
        } elseif ($user->role === 'manager') {
            return redirect()->route('manager.analisis');
        } elseif ($user->role === 'management') {
            return redirect()->route('management.persetujuan');
        } elseif ($user->role === 'finance') {
            return redirect()->route('finance.pencairan');
        }

        // Dashboard untuk anggota
        $activeLoansCount = $user->loans()->where('status', 'active')->count();
        $pendingRequestsCount = $user->loanRequests()->whereNotIn('status', ['approved', 'disbursed', 'rejected'])->count();

        return view('dashboard', compact('activeLoansCount', 'pendingRequestsCount'));
    }
}
