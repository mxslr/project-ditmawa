<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Direktorat Kemahasiswaan</title>
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data class="bg-gray-50" style="background-color: var(--surface-alt);">

    {{-- ===== TOPBAR ===== --}}
    <header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 bg-white border-b border-gray-100"
            style="height: var(--topbar-height); box-shadow: 0 1px 4px rgba(0,0,0,0.06);">

        {{-- Kiri: Logo --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3" style="text-decoration:none;">
            <img src="{{ asset('img/logo-direktorat.png') }}" alt="Direktorat Kemahasiswaan" style="height: 36px; width: auto;">
        </a>

        {{-- Tengah: Judul halaman --}}
        <div class="hidden md:block text-sm font-semibold" style="color: var(--ink-500);">
            @yield('title', 'Dashboard')
        </div>

        {{-- Kanan: Dropdown user --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.outside="open = false"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all"
                    style="color: var(--ink-700);">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold"
                     style="background: var(--telkom-red);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="hidden md:block max-w-xs truncate" style="max-width: 128px;">{{ auth()->user()->name }}</span>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-52 bg-white rounded-xl border border-gray-100 py-1"
                 style="box-shadow: 0 8px 24px rgba(0,0,0,0.1); z-index:100;"
                 x-cloak>
                <div class="px-4 py-2 border-b" style="border-color: var(--surface-muted);">
                    <p class="text-xs font-semibold truncate" style="color: var(--ink-900);">{{ auth()->user()->name }}</p>
                    <p class="text-xs truncate" style="color: var(--ink-500);">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-50 transition-all"
                   style="color: var(--ink-700); text-decoration:none;">
                    <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                </a>
                <div class="border-t mt-1" style="border-color: var(--surface-muted);">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 w-full text-left text-sm hover:bg-red-50 transition-all"
                                style="color: #D32F2F; background:transparent; border:none; cursor:pointer;">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex" style="padding-top: var(--topbar-height);">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="fixed left-0 bottom-0 bg-white border-r"
               style="top: var(--topbar-height); width: var(--sidebar-width); border-color: var(--ink-300); overflow-y: auto; z-index: 40;">

            <nav x-data="{ openLaporan: {{ request()->routeIs('proposal.*', 'lpj.*') ? 'true' : 'false' }} }"
                 class="p-4 space-y-1">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 shrink-0"></i>
                    <span>Dashboard</span>
                </a>

                {{-- Generate Dokumen (expandable) --}}
                <div>
                    <button @click="openLaporan = !openLaporan"
                            class="nav-item {{ request()->routeIs('proposal.*', 'lpj.*') ? 'active' : '' }}">
                        <i data-lucide="file-text" class="w-4 h-4 shrink-0"></i>
                        <span class="flex-1 text-left">Generate Dokumen</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 shrink-0 transition-transform duration-200"
                           :class="{ 'rotate-180': openLaporan }"></i>
                    </button>

                    <div x-show="openLaporan" x-collapse class="pl-4 mt-1 space-y-0.5">
                        <a href="{{ route('proposal.create') }}"
                           class="nav-sub-item {{ request()->routeIs('proposal.create') ? 'active' : '' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="file-plus-2" class="w-3.5 h-3.5"></i>
                                Generate Proposal
                            </span>
                        </a>
                        <a href="{{ route('proposal.index') }}"
                           class="nav-sub-item {{ request()->routeIs('proposal.index') ? 'active' : '' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="list" class="w-3.5 h-3.5"></i>
                                Daftar Proposal Saya
                            </span>
                        </a>
                        <a href="{{ route('lpj.create') }}"
                           class="nav-sub-item {{ request()->routeIs('lpj.create') ? 'active' : '' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="clipboard-check" class="w-3.5 h-3.5"></i>
                                Generate LPJ
                            </span>
                        </a>
                        <a href="{{ route('lpj.index') }}"
                           class="nav-sub-item {{ request()->routeIs('lpj.index') ? 'active' : '' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="list" class="w-3.5 h-3.5"></i>
                                Daftar LPJ Saya
                            </span>
                        </a>
                    </div>
                </div>

                {{-- Profil --}}
                <a href="{{ route('profile.edit') }}"
                   class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i data-lucide="user" class="w-4 h-4 shrink-0"></i>
                    <span>Profil</span>
                </a>

                <div class="py-2">
                    <div class="border-t" style="border-color: var(--ink-300);"></div>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item w-full" style="color: #D32F2F;">
                        <i data-lucide="log-out" class="w-4 h-4 shrink-0"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="flex-1 min-h-screen page-enter"
              style="margin-left: var(--sidebar-width); padding: 32px;">

            @if (session('success'))
                <div class="alert-success mb-6 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert-error mb-6 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
