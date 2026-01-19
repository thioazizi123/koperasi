<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Koperasi Pinjam Simpan') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-900">
    <div class="min-h-full flex flex-col md:flex-row bg-white">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-kop-blue-50 border-r border-kop-blue-100 flex-shrink-0">
            <div class="h-full flex flex-col p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-10 h-10 bg-kop-blue-500 rounded-xl flex items-center justify-center shadow-lg shadow-kop-blue-200 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-kop-blue-900">Co-Op Loans</span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-kop-blue-100 text-kop-blue-900 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-kop-blue-600 hover:bg-kop-blue-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Pengajuan</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-kop-blue-600 hover:bg-kop-blue-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Riwayat</span>
                    </a>
                </nav>

                <!-- Profile & Logout -->
                <div class="pt-6 border-t border-kop-blue-100 flex flex-col space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-kop-blue-200 border-2 border-white overflow-hidden shadow-sm flex items-center justify-center font-bold text-kop-blue-700">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 truncate">
                            <p class="text-sm font-semibold text-kop-blue-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-kop-blue-500 truncate capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg text-rose-600 hover:bg-rose-50 transition-colors font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col bg-white">
            <header class="h-16 flex items-center justify-between px-8 border-b border-gray-100 bg-white sticky top-0 z-10">
                <h2 class="text-lg font-semibold text-slate-800">@yield('header_title', 'Dashboard')</h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-slate-400 hover:text-kop-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                    <div class="h-8 w-px bg-gray-100 mr-2"></div>
                </div>
            </header>

            <div class="p-8 flex-1 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
