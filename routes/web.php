<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LoanRequestController;
use App\Http\Controllers\DisbursementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Routes untuk Anggota
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/loans/create', function () {
        return view('loans.create');
    })->name('loans.create');
    Route::post('/loans', [LoanRequestController::class, 'store'])->name('loans.store');
    Route::get('/loans/{loanRequest}', [LoanRequestController::class, 'show'])->name('loans.show');
});

// Routes untuk Customer Service
Route::middleware(['auth', 'role:cs'])->group(function () {
    Route::get('/cs/verifikasi', [StaffController::class, 'csDashboard'])->name('cs.verifikasi');
    Route::post('/cs/verifikasi/{loanRequest}', [LoanRequestController::class, 'verify'])->name('cs.verify.action');
});

// Routes untuk Manager
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/analisis', [StaffController::class, 'managerDashboard'])->name('manager.analisis');
    Route::post('/manager/analisis/{loanRequest}', [LoanRequestController::class, 'analyze'])->name('manager.analyze.action');
});

// Routes untuk Pengurus (Management)
Route::middleware(['auth', 'role:management'])->group(function () {
    Route::get('/management/persetujuan', [StaffController::class, 'managementDashboard'])->name('management.persetujuan');
    Route::post('/management/persetujuan/{loanRequest}', [LoanRequestController::class, 'approve'])->name('management.approve.action');
});

// Routes untuk Keuangan (Finance)
Route::middleware(['auth', 'role:finance'])->group(function () {
    Route::get('/finance/pencairan', [StaffController::class, 'financeDashboard'])->name('finance.pencairan');
    Route::post('/finance/pencairan/{loanRequest}', [DisbursementController::class, 'disburse'])->name('finance.disburse.action');
});

// Routes untuk Monitoring & Semua Pengajuan (Bisa diakses Manager/Pengurus/Finance/CS/Member)
Route::middleware(['auth', 'role:member,cs,manager,management,finance'])->group(function () {
    Route::get('/staff/monitoring', [StaffController::class, 'monitoringDashboard'])->name('staff.monitoring');
    Route::get('/loan-requests', [LoanRequestController::class, 'index'])->name('loan-requests.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
