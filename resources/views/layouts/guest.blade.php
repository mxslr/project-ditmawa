<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — Direktorat Kemahasiswaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data style="font-family: 'Inter', system-ui, sans-serif; margin: 0; padding: 0; min-height: 100vh; display: flex;">

    {{-- ===== KIRI: Area Form (40%) ===== --}}
    <div class="flex flex-col justify-center" style="width: 40%; min-height: 100vh; padding: 48px 56px; background: #fff; box-shadow: 4px 0 24px rgba(0,0,0,0.04);">

        {{-- Logo & Tagline --}}
        <div class="mb-10">
            <a href="{{ route('home') }}" style="text-decoration:none; display: inline-block; margin-bottom: 16px;">
                <img src="{{ asset('img/logo-direktorat.png') }}" alt="Direktorat Kemahasiswaan" style="height: 48px; width: auto;">
            </a>
            <p style="font-size: 13px; color: var(--ink-500); margin-top: 8px;">
                Sistem Dokumentasi Kegiatan Mahasiswa
            </p>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert-success mb-4 flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-error mb-4 flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Form content --}}
        @yield('content')
    </div>

    {{-- ===== KANAN: Panel Dekoratif (60%) ===== --}}
    <div class="hidden md:flex flex-col items-center justify-center flex-1 relative overflow-hidden"
         style="background: linear-gradient(135deg, #E03A3E 0%, #C0392B 40%, #922B21 100%);">

        {{-- Pattern SVG --}}
        <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dots" x="0" y="0" width="24" height="24" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1.5" fill="white" opacity="0.06"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dots)"/>
        </svg>

        {{-- Konten teks tengah --}}
        <div class="relative z-10 text-center text-white px-12">
            <div class="mb-8">
                <img src="{{ asset('img/logo-telkom.png') }}" alt="Telkom University" style="height: 64px; width: auto; margin: 0 auto; filter: brightness(0) invert(1);">
            </div>
            <h1 style="font-family: 'Source Serif Pro', Georgia, serif; font-size: 36px; font-weight: 700; line-height: 1.2; margin-bottom: 16px; color: #fff;">
                Direktorat<br>Kemahasiswaan,<br>Karier, dan Alumni
            </h1>
            <p style="font-size: 15px; opacity: 0.85; line-height: 1.6; margin-bottom: 8px;">
                Universitas Telkom
            </p>
            <p style="font-size: 13px; opacity: 0.65; max-width: 320px; margin: 0 auto; line-height: 1.6;">
                Platform terpadu untuk pembuatan dokumen administratif kegiatan mahasiswa
            </p>
        </div>

        {{-- Ornamen dekoratif bawah --}}
        <div class="absolute bottom-0 left-0 right-0 h-32 opacity-10"
             style="background: linear-gradient(to top, rgba(255,255,255,0.3), transparent);"></div>
    </div>

</body>
</html>
