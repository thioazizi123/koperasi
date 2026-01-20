@extends('layouts.app')

@section('header_title', 'Angsuran Saya')

@section('content')
    <div class="py-2">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @forelse ($loans as $loan)
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Pinjaman #LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</h3>
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold uppercase">{{ $loan->status }}</span>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Sisa Saldo</p>
                            <p class="text-xl font-bold text-rose-600">Rp {{ number_format($loan->remaining_balance, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-400">Total: Rp {{ number_format($loan->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-xl border border-gray-50">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50">
                                <tr class="text-slate-400 text-[10px] uppercase font-bold tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">Jumlah</th>
                                    <th class="px-6 py-4">Jatuh Tempo</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($loan->installments as $index => $installment)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-bold text-slate-700">Rp {{ number_format($installment->amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-slate-500">{{ $installment->due_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($installment->status === 'paid')
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold">LUNAS</span>
                                            @elseif ($installment->status === 'late')
                                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 rounded text-[10px] font-bold">TELAT</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[10px] font-bold">PENDING</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if ($installment->status !== 'paid')
                                                <form action="{{ route('installments.pay', $installment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membayar angsuran ini?')">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-kop-blue-500 hover:bg-kop-blue-600 text-white rounded-lg text-xs font-bold transition-colors shadow-sm shadow-kop-blue-100">
                                                        Bayar Sekarang
                                                    </button>
                                                </form>
                                            @else
                                                <div class="text-[10px] text-slate-400 font-medium italic">
                                                    Terbayar: {{ $installment->paid_at->format('d/m/y H:i') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Angsuran</h4>
                <p class="text-sm text-slate-400">Anda belum memiliki pinjaman aktif yang memerlukan pembayaran angsuran.</p>
            </div>
        @endforelse
    </div>
@endsection
