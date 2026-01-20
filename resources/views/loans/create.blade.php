@extends('layouts.app')

@section('header_title', 'Ajukan Pinjaman Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex items-center space-x-4 bg-kop-blue-50/50">
                <div class="w-12 h-12 bg-white text-kop-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-slate-800">Formulir Pengajuan</h4>
                    <p class="text-sm text-slate-500">Lengkapi data di bawah ini untuk mengajukan pinjaman.</p>
                </div>
            </div>

            <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="amount" class="text-sm font-semibold text-slate-700">Jumlah Pinjaman (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-slate-400 font-medium text-sm">Rp</span>

                        <input type="text" id="amount" name="amount" list="amount-suggestions" placeholder="Contoh: 50.000"
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-gray-200 focus:border-kop-blue-400 focus:ring focus:ring-kop-blue-100 transition-all outline-none bg-white font-medium text-slate-700"
                            required autocomplete="off">

                        <datalist id="amount-suggestions">
                            <option value="50000">Rp 50.000 (Minimal)</option>
                            @php
                                $amounts = [100000, 250000, 500000, 1000000, 2000000, 3000000, 5000000, 7500000, 10000000];
                            @endphp
                            @foreach ($amounts as $val)
                                <option value="{{ $val }}">Rp {{ number_format($val, 0, ',', '.') }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <p class="mt-2 text-[10px] text-slate-400 font-medium italic">* Minimal peminjaman Rp 50.000 dan
                        maksimal Rp 10.000.000</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="duration" class="text-sm font-semibold text-slate-700">Durasi (Bulan)</label>
                        <select id="duration" name="duration"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-kop-blue-400 focus:ring focus:ring-kop-blue-100 transition-all outline-none"
                            required>
                            <option value="6">6 Bulan</option>
                            <option value="12">12 Bulan</option>
                            <option value="24">24 Bulan</option>
                            <option value="36">36 Bulan</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700">Estimasi Angsuran</label>
                        <div id="repayment-estimate"
                            class="px-4 py-2.5 bg-slate-50 rounded-xl border border-dashed border-gray-200 text-slate-500 text-sm italic">
                            Akan dihitung otomatis
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="purpose" class="text-sm font-semibold text-slate-700">Tujuan Pinjaman</label>
                    <textarea id="purpose" name="purpose" rows="3"
                        placeholder="Jelaskan secara singkat kegunaan pinjaman ini..."
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-kop-blue-400 focus:ring focus:ring-kop-blue-100 transition-all outline-none"
                        required></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Dokumen Pendukung</label>
                    <input type="file" name="documents[]" id="documents" class="hidden" multiple
                        accept=".jpg,.jpeg,.png,.pdf">
                    <div onclick="document.getElementById('documents').click()"
                        class="p-4 border-2 border-dashed border-gray-200 rounded-2xl bg-slate-50 flex flex-col items-center justify-center space-y-2 hover:border-kop-blue-300 transition-colors cursor-pointer group">
                        <div
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-400 group-hover:text-kop-blue-500 transition-colors shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <span id="file-label" class="text-sm text-slate-500 font-medium">Klik atau drop file di sini (KTP,
                            Slip Gaji)</span>
                        <span class="text-xs text-slate-400 italic">Maksimal 5MB per file</span>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-2.5 text-slate-600 font-semibold hover:text-slate-800 transition-colors">Batal</a>
                    <button type="submit" name="submit" class="btn-primary px-8">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('documents').addEventListener('change', function (e) {
            const label = document.getElementById('file-label');
            if (e.target.files.length > 0) {
                label.innerText = e.target.files.length + ' file dipilih';
                label.classList.add('text-kop-blue-600');
            } else {
                label.innerText = 'Klik atau drop file di sini (KTP, Slip Gaji)';
                label.classList.remove('text-kop-blue-600');
            }
        });
    </script>
@endsection