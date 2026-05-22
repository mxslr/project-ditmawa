@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    {{-- Greeting --}}
    <div class="mb-8">
        <h1 style="font-family: 'Source Serif Pro', Georgia, serif; font-size: 28px; font-weight: 700; color: var(--ink-900); margin-bottom: 8px;">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>
        <p style="font-size: 15px; color: var(--ink-500);">
            Apa yang ingin kamu buat hari ini?
        </p>
    </div>

    {{-- 2 Card Besar --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- Card Proposal --}}
        <div class="card group" style="transition: var(--transition); cursor: default;"
             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.10)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-card)';">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: var(--telkom-red-light);">
                    <i data-lucide="file-plus-2" class="w-6 h-6" style="color: var(--telkom-red);"></i>
                </div>
                <div class="flex-1">
                    <h3 style="font-size: 17px; font-weight: 700; color: var(--ink-900); margin-bottom: 8px;">
                        Proposal Kegiatan
                    </h3>
                    <p style="font-size: 14px; color: var(--ink-500); line-height: 1.6; margin-bottom: 20px;">
                        Buat proposal kegiatan UKM untuk diajukan ke Direktorat Kemahasiswaan. Lengkap dengan rundown, anggaran, dan lembar pengesahan.
                    </p>
                    <a href="{{ route('proposal.create') }}" class="btn-primary">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Buat Proposal
                    </a>
                </div>
            </div>
        </div>

        {{-- Card LPJ --}}
        <div class="card group" style="transition: var(--transition); cursor: default;"
             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.10)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-card)';">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: var(--telkom-red-light);">
                    <i data-lucide="clipboard-check" class="w-6 h-6" style="color: var(--telkom-red);"></i>
                </div>
                <div class="flex-1">
                    <h3 style="font-size: 17px; font-weight: 700; color: var(--ink-900); margin-bottom: 8px;">
                        Laporan Pertanggungjawaban (LPJ)
                    </h3>
                    <p style="font-size: 14px; color: var(--ink-500); line-height: 1.6; margin-bottom: 20px;">
                        Buat LPJ pasca kegiatan sebagai bentuk akuntabilitas pelaksanaan program. Lengkap dengan realisasi anggaran dan dokumentasi.
                    </p>
                    <a href="{{ route('lpj.create') }}" class="btn-primary">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Buat LPJ
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Dokumen Terakhir --}}
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 style="font-size: 16px; font-weight: 700; color: var(--ink-900);">
                Proposal Terakhir
            </h2>
            <a href="{{ route('proposal.index') }}"
               style="font-size: 13px; color: var(--telkom-red); text-decoration: none; font-weight: 600;">
                Lihat Semua
            </a>
        </div>

        @if($recentProposals->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--ink-300);">
                            <th style="text-align:left; padding: 8px 10px; font-size: 12px; font-weight: 600; color: var(--ink-500);">Nama Kegiatan</th>
                            <th style="text-align:left; padding: 8px 10px; font-size: 12px; font-weight: 600; color: var(--ink-500);">Tanggal</th>
                            <th style="text-align:center; padding: 8px 10px; font-size: 12px; font-weight: 600; color: var(--ink-500);">Status</th>
                            <th style="text-align:right; padding: 8px 10px; font-size: 12px; font-weight: 600; color: var(--ink-500);">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentProposals as $proposal)
                        <tr style="border-bottom: 1px solid var(--surface-muted);">
                            <td style="padding: 10px; font-size: 14px; font-weight: 600; color: var(--ink-900);">
                                <a href="{{ route('proposal.show', $proposal) }}"
                                   style="color: var(--ink-900); text-decoration: none;"
                                   onmouseover="this.style.color='var(--telkom-red)'"
                                   onmouseout="this.style.color='var(--ink-900)'">
                                    {{ $proposal->nama_kegiatan }}
                                </a>
                            </td>
                            <td style="padding: 10px; font-size: 13px; color: var(--ink-500);">
                                {{ $proposal->tanggal_pelaksanaan }}
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                @if($proposal->status === 'generated')
                                    <span style="display:inline-block; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:600; background:#E8F5E9; color:#2E7D32;">Generated</span>
                                @else
                                    <span style="display:inline-block; padding:2px 8px; border-radius:20px; font-size:11px; font-weight:600; background:var(--surface-muted); color:var(--ink-500);">Draft</span>
                                @endif
                            </td>
                            <td style="padding: 10px; text-align: right;">
                                <a href="{{ route('proposal.generate', $proposal) }}"
                                   style="font-size: 13px; font-weight: 600; color: var(--telkom-red); text-decoration: none;">
                                    <i data-lucide="download" class="w-3.5 h-3.5 inline"></i> Download
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 48px 0;">
                <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4"
                     style="background: var(--surface-muted);">
                    <i data-lucide="file-x" class="w-6 h-6" style="color: var(--ink-300);"></i>
                </div>
                <p style="font-size: 14px; color: var(--ink-500); margin-bottom: 4px;">
                    Belum ada dokumen
                </p>
                <p style="font-size: 13px; color: var(--ink-300);">
                    Mulai buat dokumen pertamamu menggunakan kartu di atas!
                </p>
            </div>
        @endif
    </div>
@endsection
