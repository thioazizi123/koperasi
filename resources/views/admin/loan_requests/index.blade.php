@extends('layouts.app')

@section('header_title', auth()->user()->role === 'member' ? 'Riwayat Pengajuan' : 'Manajemen Pengajuan')

@section('content')
    <div class="space-y-8">
        <!-- Header Section with Premium Style -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
            <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-kop-blue-50/50">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white text-kop-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-800">
                            {{ auth()->user()->role === 'member' ? 'Daftar Pinjaman Anda' : 'Semua Pengajuan Pinjaman' }}
                        </h4>
                        <p class="text-sm text-slate-500">
                            {{ auth()->user()->role === 'member' ? 'Pantau status pengajuan pinjaman yang telah Anda buat.' : 'Kelola dan proses seluruh pengajuan pinjaman anggota.' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Stats for Staff if needed (Optional, omitted for now to keep it clean) -->

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-white">
                <h3 class="text-lg font-bold text-slate-800">Data Pengajuan</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" placeholder="Cari..." class="form-input pl-10 h-10 text-xs">
                        <svg class="w-4 h-4 absolute left-3.5 top-3 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button
                        class="px-4 py-2 bg-white border border-gray-200 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-50 transition-colors">
                        Filter
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr class="text-slate-400 text-[10px] uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4 font-bold">Anggota / ID</th>
                            <th class="px-6 py-4 font-bold">Nilai Pinjaman</th>
                            <th class="px-6 py-4 font-bold text-center">Durasi</th>
                            <th class="px-6 py-4 font-bold text-center">Status</th>
                            <th class="px-6 py-4 font-bold">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($loanRequests as $request)
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($request->user->name) }}&background=f0f9ff&color=0ea5e9"
                                            class="w-8 h-8 rounded-full border border-kop-blue-100 shadow-sm">
                                        <div>
                                            <p class="font-bold text-slate-800 group-hover:text-kop-blue-600 transition-colors">
                                                {{ $request->user->name }}
                                            </p>
                                            <p class="text-[10px] text-slate-400 font-medium">
                                                #PR-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-black text-slate-800">
                                    Rp {{ number_format($request->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">{{ $request->duration }}
                                        BLN</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClasses = [
                                            'draft' => 'bg-slate-100 text-slate-600',
                                            'submitted' => 'bg-blue-100 text-blue-600',
                                            'cs_verified' => 'bg-indigo-100 text-indigo-600',
                                            'manager_approved' => 'bg-purple-100 text-purple-600',
                                            'approved' => 'bg-emerald-100 text-emerald-600',
                                            'rejected' => 'bg-rose-100 text-rose-600',
                                        ];
                                        $statusLabels = [
                                            'draft' => 'DRAFT',
                                            'submitted' => 'PROSES CS',
                                            'cs_verified' => 'TERVERIFIKASI',
                                            'manager_approved' => 'LAYAK',
                                            'approved' => 'SIAP CAIR',
                                            'rejected' => 'DITOLAK',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[10px] font-black tracking-tight {{ $statusClasses[$request->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $statusLabels[$request->status] ?? strtoupper($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                                    {{ $request->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('loans.show', $request) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-kop-blue-50 text-kop-blue-600 rounded-lg text-[10px] font-black hover:bg-kop-blue-100 transition-all uppercase tracking-wider">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic font-medium">
                                    Belum ada pengajuan pinjaman yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection