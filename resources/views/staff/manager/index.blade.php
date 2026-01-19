@extends('layouts.app')

@section('header_title', 'Analisis Kelayakan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Analisis Pinjaman</h3>
            <p class="text-sm text-slate-500">Daftar pengajuan yang telah lolos verifikasi CS dan butuh analisis kelayakan.</p>
        </div>
        <span class="px-3 py-1 bg-kop-blue-50 text-kop-blue-600 rounded-full text-xs font-bold ring-1 ring-kop-blue-100">8 Perlu Analisis</span>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr class="text-slate-400 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-medium">Anggota</th>
                    <th class="px-6 py-4 font-medium">Nilai Pengajuan</th>
                    <th class="px-6 py-4 font-medium">Skorsing Kredit</th>
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
                                <p class="text-xs text-slate-400">Tujuan: {{ $request->purpose }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">Rp {{ number_format($request->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 w-[85%]"></div>
                            </div>
                            <span class="text-emerald-600 font-bold">A+</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('manager.analyze.action', $request) }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_approved" value="1">
                            <button type="submit" class="px-4 py-1.5 bg-kop-blue-500 text-white rounded-lg text-xs font-bold hover:bg-kop-blue-600 shadow-md shadow-kop-blue-100">
                                Analisis Layak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">Tidak ada antrean analisis saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
