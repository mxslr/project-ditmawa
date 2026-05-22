<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Direktorat Kemahasiswaan, Karier, dan Alumni — Telkom University</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data style="margin: 0; padding: 0; background: #fff;">

    {{-- ===== NAVBAR ===== --}}
    <nav class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-8 bg-white border-b border-gray-100"
         style="height: 64px; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
        <a href="{{ route('home') }}" style="text-decoration:none;">
            <img src="{{ asset('img/logo-direktorat.png') }}" alt="Direktorat Kemahasiswaan" style="height: 36px; width: auto;">
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="btn-secondary" style="padding: 8px 20px;">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="btn-primary" style="padding: 8px 20px;">
                Daftar
            </a>
        </div>
    </nav>

    {{-- ===== HERO SECTION ===== --}}
    <section style="min-height: 100vh; display: flex; align-items: center; padding-top: 64px;
                    background: linear-gradient(135deg, #E03A3E 0%, #C0392B 45%, #7B241C 100%);
                    position: relative; overflow: hidden;">

        {{-- Background pattern --}}
        <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.07;">
            <defs>
                <pattern id="hero-dots" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="2" fill="white"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#hero-dots)"/>
        </svg>

        {{-- Ornamen lingkaran besar --}}
        <div style="position: absolute; top: -120px; right: -120px; width: 500px; height: 500px;
                    border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events:none;"></div>
        <div style="position: absolute; bottom: -80px; left: -80px; width: 300px; height: 300px;
                    border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events:none;"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-8 py-24 flex flex-col md:flex-row items-center gap-16">

            {{-- Kiri: Teks --}}
            <div class="flex-1">
                <div class="mb-6">
                    <img src="{{ asset('img/logo-telkom.png') }}" alt="Telkom University"
                         style="height: 56px; width: auto; filter: brightness(0) invert(1); opacity: 0.95;">
                </div>
                <h1 style="font-family: 'Source Serif Pro', Georgia, serif; font-size: clamp(32px, 5vw, 52px);
                            font-weight: 700; color: #fff; line-height: 1.15; margin-bottom: 20px;">
                    Direktorat<br>Kemahasiswaan,<br>Karier, dan Alumni
                </h1>
                <p style="font-size: 17px; color: rgba(255,255,255,0.85); line-height: 1.7; max-width: 480px; margin-bottom: 36px;">
                    Platform terpadu untuk pembuatan <strong style="color: #fff;">Proposal Kegiatan</strong> dan
                    <strong style="color: #fff;">Laporan Pertanggungjawaban (LPJ)</strong> sesuai template resmi
                    Direktorat Kemahasiswaan Telkom University.
                </p>
                <div class="flex items-center gap-3 flex-wrap">
                    <a href="{{ route('register') }}"
                       style="display:inline-flex; align-items:center; gap:8px; background:#fff; color:var(--telkom-red);
                              padding:12px 28px; border-radius:9999px; font-size:15px; font-weight:700;
                              text-decoration:none; transition: all 0.2s ease-out; box-shadow: 0 4px 16px rgba(0,0,0,0.15);"
                       onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.2)';"
                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.15)';">
                        <i data-lucide="user-plus" style="width:18px; height:18px;"></i>
                        Mulai Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                       style="display:inline-flex; align-items:center; gap:8px; background:transparent; color:#fff;
                              padding:12px 28px; border-radius:9999px; font-size:15px; font-weight:600;
                              text-decoration:none; border: 2px solid rgba(255,255,255,0.5); transition: all 0.2s ease-out;"
                       onmouseover="this.style.borderColor='rgba(255,255,255,0.9)'; this.style.background='rgba(255,255,255,0.1)';"
                       onmouseout="this.style.borderColor='rgba(255,255,255,0.5)'; this.style.background='transparent';">
                        Sudah punya akun? Masuk
                    </a>
                </div>
            </div>

            {{-- Kanan: Feature cards --}}
            <div class="flex-1 max-w-sm w-full">
                <div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(12px);
                            border: 1px solid rgba(255,255,255,0.2); border-radius: 16px; padding: 28px;">
                    <h3 style="font-size: 14px; font-weight: 700; color: rgba(255,255,255,0.7);
                               letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 20px;">
                        Fitur Utama
                    </h3>
                    <div class="space-y-4">
                        @foreach([
                            ['file-plus-2', 'Generate Proposal', 'Buat proposal kegiatan lengkap dengan satu form'],
                            ['clipboard-check', 'Generate LPJ', 'Buat LPJ pasca kegiatan secara mudah dan cepat'],
                            ['download', 'Export PDF', 'Download langsung sebagai PDF siap print'],
                            ['shield-check', 'Template Resmi', 'Sesuai template standar Direktorat Kemahasiswaan'],
                        ] as [$icon, $title, $desc])
                            <div class="flex items-start gap-3">
                                <div style="width:36px; height:36px; border-radius:8px; background:rgba(255,255,255,0.15);
                                            display:flex; align-items:center; justify-content:center; shrink:0; flex-shrink:0;">
                                    <i data-lucide="{{ $icon }}" style="width:18px; height:18px; color:#fff;"></i>
                                </div>
                                <div>
                                    <p style="font-size:14px; font-weight:600; color:#fff; margin-bottom:2px;">{{ $title }}</p>
                                    <p style="font-size:12px; color:rgba(255,255,255,0.7); line-height:1.5;">{{ $desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
