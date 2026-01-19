@extends('layouts.app')

@section('header_title', 'Detail Pengajuan Pinjaman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ url()->previous() }}" class="flex items-center text-slate-500 hover:text-kop-blue-600 font-semibold transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali
        </a>
        <div class="px-4 py-1.5 bg-kop-blue-50 text-kop-blue-600 rounded-full text-xs font-bold uppercase tracking-wider">
            Status: {{ str_replace('_', ' ', $loanRequest->status) }}
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Loan Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Informasi Pinjaman</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Jumlah Pinjaman</p>
                        <p class="text-xl font-black text-slate-800">Rp {{ number_format($loanRequest->amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Durasi</p>
                        <p class="text-xl font-black text-slate-800">{{ $loanRequest->duration }} Bulan</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Tujuan Pinjaman</p>
                        <p class="text-slate-700 leading-relaxed">{{ $loanRequest->purpose }}</p>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Dokumen Pendukung</h3>
                </div>
                <div class="p-6">
                    @if($loanRequest->documents && count($loanRequest->documents) > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($loanRequest->documents as $doc)
                                <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="group relative aspect-square rounded-xl bg-slate-100 border border-gray-200 overflow-hidden flex items-center justify-center hover:border-kop-blue-400 transition-all">
                                    @if(Str::endsWith($doc, ['.jpg', '.jpeg', '.png']))
                                        <img src="{{ asset('storage/' . $doc) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    @else
                                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    @endif
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity text-white text-xs font-bold uppercase">Lihat Dokumen</div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-slate-400 italic">Tidak ada dokumen diunggah.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Requester Profile -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Profil Anggota</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-kop-blue-500 rounded-full flex items-center justify-center text-white font-bold">{{ substr($loanRequest->user->name, 0, 1) }}</div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $loanRequest->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $loanRequest->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log (Simplified) -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800">Timeline Pengajuan</h3>
                </div>
                <div class="p-6">
                    <div class="relative pl-6 border-l-2 border-slate-100 space-y-6">
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white"></div>
                            <p class="text-xs font-bold text-slate-800">Diajukan</p>
                            <p class="text-[10px] text-slate-400">{{ $loanRequest->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if($loanRequest->status !== 'submitted' && $loanRequest->status !== 'draft')
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-kop-blue-500 border-4 border-white"></div>
                            <p class="text-xs font-bold text-slate-800">Verifikasi Terakhir</p>
                            <p class="text-[10px] text-slate-400">{{ $loanRequest->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
