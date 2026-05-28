{{-- ===== FOOTER (area konten utama, di bawah halaman) ===== --}}
<footer class="bg-[#E03A3E] text-white mt-auto">
    <div class="px-6 md:px-10 py-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-10">

            {{-- Kolom kiri: identitas direktorat --}}
            <div class="md:col-span-4 space-y-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('img/logo-telkom.png') }}" alt="Telkom University"
                         class="h-9 w-auto" style="filter: brightness(0) invert(1);">
                    <img src="{{ asset('img/logo-direktorat.png') }}" alt="Direktorat Kemahasiswaan"
                         class="h-9 w-auto" style="filter: brightness(0) invert(1);">
                </div>
                <p class="text-sm font-semibold leading-snug">
                    Direktorat Kemahasiswaan, Karier, dan Alumni
                </p>
                <p class="text-xs leading-relaxed text-white/85">
                    Gedung Pelampong Telkom University, Jl. Telekomunikasi, Terusan Buah Batu,
                    Indonesia 40257, Bandung, Indonesia
                </p>

                {{-- Sosial media --}}
                <div class="flex items-center gap-3 pt-1">
                    <a href="https://www.instagram.com/ditmawa_univtelkom/" target="_blank" rel="noopener noreferrer"
                       aria-label="Instagram"
                       class="flex items-center justify-center w-9 h-9 rounded-full bg-white/15 hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@ditmawa_univtelkom" target="_blank" rel="noopener noreferrer"
                       aria-label="TikTok"
                       class="flex items-center justify-center w-9 h-9 rounded-full bg-white/15 hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43V8.69a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1.04-.12z"/>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/channel/UC1rBn2q8ZeR5FZlnsOwFtew" target="_blank" rel="noopener noreferrer"
                       aria-label="YouTube"
                       class="flex items-center justify-center w-9 h-9 rounded-full bg-white/15 hover:bg-white/30 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="currentColor" stroke="none"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Kolom kanan: 3 sub-kolom tautan --}}
            <div class="md:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-8">

                {{-- Halaman --}}
                <div>
                    <h3 class="text-sm font-semibold mb-3 uppercase tracking-wide">Halaman</h3>
                    <ul class="space-y-2 text-sm text-white/85">
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-white transition-colors">Profil</a></li>
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('proposal.create') }}" class="hover:text-white transition-colors">Generate Proposal</a></li>
                        <li><a href="{{ Route::has('lpj.create') ? route('lpj.create') : '#' }}"
                               class="hover:text-white transition-colors {{ Route::has('lpj.create') ? '' : 'opacity-50 cursor-not-allowed' }}">Generate LPJ</a></li>
                    </ul>
                </div>

                {{-- Tautan Cepat --}}
                <div>
                    <h3 class="text-sm font-semibold mb-3 uppercase tracking-wide">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm text-white/85">
                        <li>
                            <a href="https://wa.me/6281323323677" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Hotline Satgas PPKPT</a>
                        </li>
                        <li>
                            <a href="https://wa.me/6282130155601" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Konseling</a>
                        </li>
                        <li>
                            <a href="https://wa.me/6281214242600" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Beasiswa</a>
                        </li>
                        <li>
                            <a href="https://wa.me/6281321115302" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Pelaporan Prestasi</a>
                        </li>
                        <li>
                            <a href="https://studentaffairs.telkomuniversity.ac.id/links" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Links</a>
                        </li>                       
                    </ul>
                </div>

                {{-- Direktori --}}
                <div>
                    <h3 class="text-sm font-semibold mb-3 uppercase tracking-wide">Direktori</h3>
                    <ul class="space-y-2 text-sm text-white/85">
                        <li>
                            <a href="https://telkomuniversity.ac.id" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Website Telkom University</a>
                        </li>
                        <li>
                            <a href="https://igracias.telkomuniversity.ac.id/" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">iGracias</a>
                        </li>
                        <li>
                            <a href="https://studentaffairs.telkomuniversity.ac.id/asrama/" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">Asrama</a>
                        </li>
                        <li>
                            <a href="https://studentaffairs.telkomuniversity.ac.id/pkkmb/" target="_blank" rel="noopener noreferrer"
                               class="hover:text-white transition-colors">PKKMB</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris bawah: copyright + credit --}}
    <div class="border-t border-white/20">
        <div class="px-6 md:px-10 py-4 flex flex-col md:flex-row items-center justify-between gap-2 text-xs text-white/90">
            <p>&copy; {{ date('Y') }} Direktorat Kemahasiswaan, Karier dan Alumni</p>
            <p>
                Developed by
                <a href="https://www.instagram.com/cciunitel/" target="_blank" rel="noopener noreferrer"
                   class="text-white hover:opacity-80 transition-opacity">Central Computer Improvement</a>
            </p>
        </div>
    </div>
</footer>
