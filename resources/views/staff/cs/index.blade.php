@extends('layouts.app')

@section('header_title', 'Verifikasi CS')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Antrean Verifikasi</h3>
            <p class="text-sm text-slate-500">Daftar pengajuan pinjaman yang perlu diverifikasi kelengkapan berkasnya.</p>
        </div>
        <div class="flex space-x-2">
            <span class="px-3 py-1 bg-kop-blue-50 text-kop-blue-600 rounded-full text-xs font-bold ring-1 ring-kop-blue-100">{{ $requests->count() }} Menunggu</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-medium">Anggota</th>
                    <th class="px-6 py-4 font-medium">Jumlah Pinjaman</th>
                    <th class="px-6 py-4 font-medium">Dokumen</th>
                    <th class="px-6 py-4 font-medium">Tanggal Masuk</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($requests as $request)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($request->user->name) }}&background=f0f9ff&color=0ea5e9" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $request->user->name }}</p>
                                <p class="text-xs text-slate-400">NIK: {{ $request->user->nik ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">Rp {{ number_format($request->amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-400">{{ $request->duration }} Bulan</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-1">
                            @if($request->documents)
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold">LENGKAP</span>
                            @else
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded text-[10px] font-bold">BELUM LENGKAP</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $request->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('cs.verify.action', $request) }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_valid" value="1">
                            <button type="submit" class="px-4 py-1.5 bg-kop-blue-500 text-white rounded-lg text-xs font-bold hover:bg-kop-blue-600 transition-shadow shadow-md shadow-kop-blue-100">
                                Verifikasi
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Tidak ada antrean verifikasi saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
