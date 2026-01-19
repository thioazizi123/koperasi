@extends('layouts.app')

@section('header_title', 'Dashboard Anggota')

@section('content')
    <div class="space-y-8">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-l-emerald-500 p-4 rounded-xl flex items-center space-x-3 animate-pulse">
                <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Welcome Section -->
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Halo, {{ auth()->user()->name }}! 👋</h3>
            <p class="text-slate-500">Selamat datang di sistem pinjaman Koperasi. Berikut ringkasan akun Anda hari ini.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Loans Card -->
            <div class="card-premium border-l-4 border-l-kop-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-kop-blue-50 rounded-lg text-kop-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-kop-blue-500 bg-kop-blue-50 px-2 py-1 rounded-full">+5% dari bulan
                        lalu</span>
                </div>
                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pinjaman Aktif</h4>
                <p class="text-2xl font-black text-slate-800">{{ $activeLoansCount }} Pinjaman</p>
            </div>

            <!-- Pending Verification Card -->
            <div class="card-premium border-l-4 border-l-amber-400">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-amber-50 rounded-lg text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                </div>
                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Menunggu Verifikasi</h4>
                <p class="text-2xl font-black text-slate-800">{{ $pendingRequestsCount }} Pengajuan</p>
                <p class="text-[10px] text-slate-400 mt-2 italic">Dalam proses verifikasi CS</p>
            </div>

            <!-- Savings Card -->
            <div class="card-premium border-l-4 border-l-emerald-400">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 002-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Tabungan</h4>
                <p class="text-2xl font-black text-slate-800">Rp 10.500.000</p>
                <p class="text-[10px] text-emerald-500 mt-2 font-bold">Saldo Aman</p>
            </div>
        </div>

        <!-- Recent Requests Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800">Pengajuan Pinjaman Terbaru</h3>
                <a href="{{ route('loans.create') }}" class="btn-primary">Ajukan Baru</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr class="text-slate-400 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-medium">No. Pengajuan</th>
                            <th class="px-6 py-4 font-medium">Tanggal</th>
                            <th class="px-6 py-4 font-medium">Jumlah</th>
                            <th class="px-6 py-4 font-medium text-center">Status</th>
                            <th class="px-6 py-4 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($loanRequests as $request)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">REQ-{{ $request->id }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $request->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">Rp
                                    {{ number_format($request->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-3 py-1 bg-kop-blue-50 text-kop-blue-600 rounded-full text-[10px] font-bold uppercase tracking-tight">
                                        {{ str_replace('_', ' ', $request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('loans.show', $request->id) }}"
                                        class="text-kop-blue-500 hover:text-kop-blue-700 font-bold transition-colors">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Belum ada pengajuan
                                    pinjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection