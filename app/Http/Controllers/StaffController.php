<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LoanRequest;
use App\Models\Loan;
use App\Models\Installment;

class StaffController extends Controller
{
    public function csDashboard()
    {
        $requests = LoanRequest::where('status', 'submitted')->latest()->get();
        return view('staff.cs.index', compact('requests'));
    }

    public function managerDashboard()
    {
        $requests = LoanRequest::where('status', 'cs_verified')->latest()->get();
        return view('staff.manager.index', compact('requests'));
    }

    public function managementDashboard()
    {
        $requests = LoanRequest::where('status', 'manager_approved')->latest()->get();
        return view('staff.management.index', compact('requests'));
    }

    public function financeDashboard()
    {
        $requests = LoanRequest::where('status', 'approved')->latest()->get();
        return view('staff.finance.index', compact('requests'));
    }

    public function monitoringDashboard()
    {
        $loans = Loan::with('user')->where('status', 'active')->get();
        return view('staff.monitoring', compact('loans'));
    }
}
