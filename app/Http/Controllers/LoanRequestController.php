<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LoanRequest;
use Illuminate\Support\Facades\Auth;

class LoanRequestController extends Controller
{
    /**
     * Menampilkan daftar semua pengajuan pinjaman untuk staf.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'member') {
            $loanRequests = $user->loanRequests()->with('user')->latest()->get();
        } else {
            $loanRequests = LoanRequest::with('user')->latest()->get();
        }
        return view('admin.loan_requests.index', compact('loanRequests'));
    }

    /**
     * Menampilkan detail pengajuan pinjaman.
     */
    public function show(LoanRequest $loanRequest)
    {
        // Pastikan hanya pemilik atau staf yang bisa melihat
        $user = Auth::user();
        if ($user->role === 'member' && $loanRequest->user_id !== $user->id) {
            abort(403);
        }

        return view('loans.show', compact('loanRequest'));
    }

    /**
     * Anggota menyimpan draf atau mengirim pengajuan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100000',
            'duration' => 'required|integer|min:1',
            'purpose' => 'required|string',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('documents', 'public');
                $documentPaths[] = $path;
            }
        }

        LoanRequest::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'duration' => $request->duration,
            'purpose' => $request->purpose,
            'documents' => $documentPaths,
            'status' => $request->has('submit') ? 'submitted' : 'draft',
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengajuan pinjaman berhasil dikirim!');
    }

    /**
     * CS memverifikasi data (berkas lengkap & valid).
     */
    public function verify(Request $request, LoanRequest $loanRequest)
    {
        // Pastikan hanya CS yang bisa akses (akan ditangani middleware)
        $validated = $request->validate([
            'is_valid' => 'required|boolean',
            'rejection_reason' => 'required_if:is_valid,false|string|nullable',
        ]);

        if ($validated['is_valid']) {
            $loanRequest->update(['status' => 'cs_verified']);
        } else {
            $loanRequest->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason']
            ]);
        }

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }

    /**
     * Manager menganalisis kelayakan.
     */
    public function analyze(Request $request, LoanRequest $loanRequest)
    {
        $validated = $request->validate([
            'is_approved' => 'required|boolean',
            'rejection_reason' => 'required_if:is_approved,false|string|nullable',
        ]);

        if ($validated['is_approved']) {
            $loanRequest->update(['status' => 'manager_approved']);
        } else {
            $loanRequest->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason']
            ]);
        }

        return response()->json(['message' => 'Analisis berhasil disimpan']);
    }

    /**
     * Pengurus memberikan persetujuan akhir.
     */
    public function approve(Request $request, LoanRequest $loanRequest)
    {
        $validated = $request->validate([
            'is_approved' => 'required|boolean',
            'rejection_reason' => 'required_if:is_approved,false|string|nullable',
        ]);

        if ($validated['is_approved']) {
            $loanRequest->update(['status' => 'approved']);
        } else {
            $loanRequest->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason']
            ]);
        }

        return response()->json(['message' => 'Persetujuan akhir berhasil disimpan']);
    }
}
