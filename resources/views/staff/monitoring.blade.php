@extends('layouts.app')

@section('header_title', 'Monitoring Pembayaran')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Tagihan</p>
            <p class="text-xl font-bold text-slate-800">Rp 1.2M</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tertagih</p>
            <p class="text-xl font-bold text-emerald-600">Rp 850jt</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-amber-400">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tunggakan</p>
            <p class="text-xl font-bold text-amber-600">14 User</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm border-l-4 border-l-kop-blue-400">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lunas Bulan Ini</p>
            <p class="text-xl font-bold text-kop-blue-600">8 User</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-white">
            <h4 class="text-lg font-bold text-slate-800">Status Angsuran Berjalan</h4>
            <div class="flex space-x-2">
                <button class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Filter</button>
            </div>
        </div>
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr class="text-slate-400 text-[10px] uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-bold">Anggota</th>
                    <th class="px-6 py-4 font-bold">Sisa Pinjaman</th>
                    <th class="px-6 py-4 font-bold">Jatuh Tempo</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($loans as $loan)
                <tr class="hover:bg-slate-50/30 transition-colors group">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $loan->user->name }}</p>
                        <p class="text-[11px] text-slate-400 leading-none">ID: LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-700">Rp {{ number_format($loan->remaining_balance, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-slate-400">Total: Rp {{ number_format($loan->total_amount, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-slate-600">Terakhir: {{ $loan->updated_at->format('d M Y') }}</p>
                        <p class="text-[10px] text-emerald-500 font-bold">Lancar</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold">{{ strtoupper($loan->status) }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-kop-blue-500 hover:underline font-bold text-xs">Detail</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Belum ada pinjaman aktif yang terpantau.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
