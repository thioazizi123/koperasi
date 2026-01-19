<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $loanRequests = $user->loanRequests()->latest()->take(5)->get();
        $activeLoansCount = $user->loans()->where('status', 'active')->count();
        $pendingRequestsCount = $user->loanRequests()->whereNotIn('status', ['approved', 'disbursed', 'rejected'])->count();
        
        return view('dashboard', compact('loanRequests', 'activeLoansCount', 'pendingRequestsCount'));
    }
}
