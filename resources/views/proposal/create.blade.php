@extends('layouts.app')
@section('title', 'Buat Proposal Kegiatan')

@push('styles')
<style>
.step-bar { display: flex; gap: 4px; margin-bottom: 32px; }
.step-dot {
    flex: 1; height: 6px; border-radius: 3px;
    background: var(--surface-muted); transition: background 0.3s;
}
.step-dot.done { background: var(--success); }
.step-dot.active { background: var(--telkom-red); }
.step-label { font-size: 12px; color: var(--ink-500); margin-bottom: 20px; font-weight: 600; }

.repeater-table { width: 100%; border-collapse: collapse; }
.repeater-table th {
    background: var(--surface-alt); font-size: 12px; font-weight: 600;
    padding: 8px 10px; text-align: left; border-bottom: 2px solid var(--ink-300);
    color: var(--ink-700);
}
.repeater-table td { padding: 6px 4px; vertical-align: top; }
.repeater-table .form-input { font-size: 13px; padding: 6px 8px; }

.section-heading {
    font-size: 13px; font-weight: 700; color: var(--telkom-red);
    text-transform: uppercase; letter-spacing: 0.5px;
    border-left: 3px solid var(--telkom-red); padding-left: 10px;
    margin-bottom: 16px; margin-top: 8px;
}
</style>
@endpush

@section('content')
<div x-data="proposalForm()" x-init="init()">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 style="font-family:'Source Serif Pro',Georgia,serif; font-size:24px; font-weight:700; color:var(--ink-900); margin-bottom:4px;">
                Buat Proposal Kegiatan
            </h1>
            <p style="font-size:14px; color:var(--ink-500);">
                Langkah <span x-text="currentStep"></span> dari <span x-text="totalSteps"></span>
                — <span x-text="stepLabels[currentStep - 1]"></span>
            </p>
        </div>
        <a href="{{ route('proposal.index') }}" class="btn-secondary text-sm">
            <i data-lucide="x" class="w-4 h-4"></i> Batal
        </a>
    </div>

    {{-- Step progress bar --}}
    <div class="step-bar mb-2">
        <template x-for="i in totalSteps" :key="i">
            <div class="step-dot"
                 :class="{ 'done': i < currentStep, 'active': i === currentStep }"></div>
        </template>
    </div>
    <p class="step-label mb-6" x-text="stepLabels[currentStep - 1]"></p>

    {{-- Form --}}
    <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data" id="proposalForm">
        @csrf

        {{-- ========== STEP 1 — Identitas Kegiatan ========== --}}
        <div x-show="currentStep === 1" class="card">
            <h2 class="section-heading">Identitas Kegiatan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="form-label">Nama Kegiatan <span style="color:var(--telkom-red)">*</span></label>
                    <input type="text" name="nama_kegiatan" class="form-input"
                           placeholder="Contoh: Orbit Star #1" required
                           :value="data.nama_kegiatan"
                           @input="data.nama_kegiatan = $event.target.value">
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Tema Kegiatan</label>
                    <input type="text" name="tema_kegiatan" class="form-input"
                           placeholder="Contoh: Learning together, growing stronger"
                           :value="data.tema_kegiatan"
                           @input="data.tema_kegiatan = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Penyelenggara <span style="color:var(--telkom-red)">*</span></label>
                    <input type="text" name="penyelenggara" class="form-input"
                           placeholder="Contoh: Digistar Club Campus Chapter Telkom University"
                           :value="data.penyelenggara"
                           @input="data.penyelenggara = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Afiliasi</label>
                    <input type="text" name="afiliasi" class="form-input"
                           placeholder="Contoh: Digistar Telkom University dan SRE Telkom University"
                           :value="data.afiliasi"
                           @input="data.afiliasi = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Tanggal Mulai <span style="color:var(--telkom-red)">*</span></label>
                    <input type="date" name="tanggal_mulai" class="form-input" required
                           :value="data.tanggal_mulai"
                           @input="data.tanggal_mulai = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Tanggal Selesai <span style="color:var(--telkom-red)">*</span></label>
                    <input type="date" name="tanggal_selesai" class="form-input" required
                           :value="data.tanggal_selesai"
                           @input="data.tanggal_selesai = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" class="form-input"
                           :value="data.waktu_mulai"
                           @input="data.waktu_mulai = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="form-input"
                           :value="data.waktu_selesai"
                           @input="data.waktu_selesai = $event.target.value">
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Tempat Kegiatan</label>
                    <input type="text" name="tempat_kegiatan" class="form-input"
                           placeholder="Contoh: Teras Priangan - Outdoor Class"
                           :value="data.tempat_kegiatan"
                           @input="data.tempat_kegiatan = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Kota</label>
                    <input type="text" name="kota" class="form-input" value="BANDUNG"
                           :value="data.kota || 'BANDUNG'"
                           @input="data.kota = $event.target.value">
                </div>
                <div>
                    <label class="form-label">Tahun <span style="color:var(--telkom-red)">*</span></label>
                    <input type="number" name="tahun" class="form-input" required
                           :value="data.tahun || new Date().getFullYear()"
                           @input="data.tahun = $event.target.value">
                </div>
            </div>
        </div>

        {{-- ========== STEP 2 — Cover & Logo ========== --}}
        <div x-show="currentStep === 2" class="card">
            <h2 class="section-heading">Cover & Logo Organisasi</h2>
            <div class="mb-4 p-4 rounded-lg" style="background:var(--telkom-red-light); border:1px solid var(--telkom-red);">
                <p class="text-sm" style="color:var(--telkom-red);">
                    <i data-lucide="info" class="w-4 h-4 inline"></i>
                    Logo Telkom University sudah otomatis disertakan. Upload logo UKM/organisasi kamu di sini.
                </p>
            </div>
            <div>
                <label class="form-label">Logo UKM / Organisasi</label>
                <input type="file" name="logo_organisasi" accept="image/png,image/jpeg,image/jpg"
                       class="form-input" style="padding: 8px;"
                       @change="previewLogo($event)">
                <p class="text-xs mt-1" style="color:var(--ink-500);">Format: PNG, JPG. Maks 2MB.</p>
            </div>
            <div x-show="logoPreview" class="mt-4">
                <p class="form-label">Preview:</p>
                <img :src="logoPreview" class="mt-2 rounded-lg" style="max-height:160px; object-fit:contain; border:1px solid var(--ink-300); padding:8px;">
            </div>
        </div>

        {{-- ========== STEP 3 — Narasi Kegiatan ========== --}}
        <div x-show="currentStep === 3" class="card">
            <h2 class="section-heading">Narasi Kegiatan</h2>

            <div class="mb-6">
                <label class="form-label">A. Latar Belakang <span style="color:var(--telkom-red)">*</span></label>
                <textarea name="latar_belakang" rows="8" class="form-input"
                          placeholder="Tuliskan latar belakang kegiatan. Contoh: Dalam era digitalisasi saat ini, komunitas teknologi memiliki peran yang semakin penting dalam membentuk generasi yang kompeten..."
                          @input="data.latar_belakang = $event.target.value"
                          x-text="data.latar_belakang"></textarea>
            </div>

            <div class="mb-6">
                <label class="form-label">D. Tujuan Kegiatan</label>
                <div class="space-y-2">
                    <template x-for="(tujuan, idx) in tujuanList" :key="idx">
                        <div class="flex items-center gap-2">
                            <span x-text="(idx + 1) + '.'" class="text-sm font-semibold" style="color:var(--ink-500); min-width:20px;"></span>
                            <input type="text" :name="'tujuan_kegiatan[' + idx + ']'"
                                   x-model="tujuanList[idx]"
                                   class="form-input flex-1"
                                   placeholder="Contoh: Meningkatkan wawasan dan kemampuan anggota dalam bidang teknologi">
                            <button type="button" @click="removeTujuan(idx)"
                                    x-show="tujuanList.length > 1"
                                    class="p-2 rounded-lg hover:bg-red-50 transition-all"
                                    style="color:var(--danger);">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="addTujuan()" class="btn-secondary mt-3 text-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Tujuan
                </button>
            </div>

            <div class="mb-6">
                <label class="form-label">E. Sasaran Kegiatan</label>
                <textarea name="sasaran_kegiatan" rows="3" class="form-input"
                          placeholder="Contoh: Seluruh pengurus Digistar Club Campus Chapter Telkom University dan SRE Telkom University"
                          @input="data.sasaran_kegiatan = $event.target.value"
                          x-text="data.sasaran_kegiatan"></textarea>
            </div>

            <div>
                <label class="form-label">G. Bentuk Kegiatan</label>
                <textarea name="bentuk_kegiatan" rows="4" class="form-input"
                          placeholder="Contoh: Studi banding dan sharing session bersama komunitas teknologi di Bandung"
                          @input="data.bentuk_kegiatan = $event.target.value"
                          x-text="data.bentuk_kegiatan"></textarea>
            </div>
        </div>

        {{-- ========== STEP 4 — Materi & Narasumber ========== --}}
        <div x-show="currentStep === 4" class="card">
            <h2 class="section-heading">Materi & Narasumber</h2>

            <div class="mb-6">
                <label class="form-label">H. Materi Kegiatan</label>
                <div class="space-y-4">
                    <template x-for="(materi, idx) in materiList" :key="idx">
                        <div class="p-4 rounded-lg border" style="border-color:var(--ink-300);">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold" style="color:var(--ink-700);">
                                    Materi <span x-text="idx + 1"></span>
                                </span>
                                <button type="button" @click="removeMateri(idx)"
                                        x-show="materiList.length > 1"
                                        class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                            <div class="mb-2">
                                <input type="text" :name="'materi_kegiatan[' + idx + '][judul]'"
                                       x-model="materiList[idx].judul"
                                       class="form-input" placeholder="Judul Materi">
                            </div>
                            <div>
                                <textarea :name="'materi_kegiatan[' + idx + '][deskripsi]'"
                                          x-model="materiList[idx].deskripsi"
                                          rows="3" class="form-input"
                                          placeholder="Deskripsi materi..."></textarea>
                            </div>
                        </div>
                    </template>
                </div>
                <button type="button" @click="addMateri()" class="btn-secondary mt-3 text-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Materi
                </button>
            </div>

            <div>
                <label class="form-label">I. Narasumber Kegiatan</label>
                <textarea name="narasumber_kegiatan" rows="3" class="form-input"
                          placeholder="Contoh: Para pengurus serta stakeholder dari setiap student chapter yang hadir"
                          @input="data.narasumber_kegiatan = $event.target.value"
                          x-text="data.narasumber_kegiatan"></textarea>
            </div>
        </div>

        {{-- ========== STEP 5 — Rundown ========== --}}
        <div x-show="currentStep === 5" class="card">
            <h2 class="section-heading">J. Susunan Acara (Rundown)</h2>
            <div style="overflow-x:auto;">
                <table class="repeater-table">
                    <thead>
                        <tr>
                            <th style="width:100px;">Waktu Mulai</th>
                            <th style="width:100px;">Waktu Selesai</th>
                            <th style="width:80px;">Durasi (menit)</th>
                            <th>Aktivitas</th>
                            <th style="width:40px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, idx) in rundowns" :key="idx">
                            <tr>
                                <td>
                                    <input type="time" :name="'rundowns[' + idx + '][waktu_mulai]'"
                                           x-model="rundowns[idx].waktu_mulai"
                                           @change="calcDurasi(idx)"
                                           class="form-input">
                                </td>
                                <td>
                                    <input type="time" :name="'rundowns[' + idx + '][waktu_selesai]'"
                                           x-model="rundowns[idx].waktu_selesai"
                                           @change="calcDurasi(idx)"
                                           class="form-input">
                                </td>
                                <td>
                                    <input type="number" :name="'rundowns[' + idx + '][durasi_menit]'"
                                           x-model="rundowns[idx].durasi_menit"
                                           readonly class="form-input text-center"
                                           style="background:var(--surface-muted);">
                                </td>
                                <td>
                                    <input type="text" :name="'rundowns[' + idx + '][aktivitas]'"
                                           x-model="rundowns[idx].aktivitas"
                                           class="form-input"
                                           placeholder="Contoh: Pembukaan & Sambutan">
                                </td>
                                <td>
                                    <button type="button" @click="removeRundown(idx)"
                                            x-show="rundowns.length > 1"
                                            class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <button type="button" @click="addRundown()" class="btn-secondary mt-3 text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Baris
            </button>
        </div>

        {{-- ========== STEP 6 — Analisis Risiko ========== --}}
        <div x-show="currentStep === 6" class="card">
            <h2 class="section-heading">K. Analisis Risiko</h2>
            <div style="overflow-x:auto;">
                <table class="repeater-table">
                    <thead>
                        <tr>
                            <th style="width:32px;">No</th>
                            <th style="min-width:120px;">Uraian Kegiatan</th>
                            <th style="min-width:130px;">Identifikasi Bahaya</th>
                            <th style="width:80px;">Peluang</th>
                            <th style="width:80px;">Akibat</th>
                            <th style="width:90px;">Tingkat Risiko</th>
                            <th style="min-width:140px;">Pengendalian Risiko</th>
                            <th style="min-width:110px;">Penanggung Jawab</th>
                            <th style="width:40px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, idx) in risks" :key="idx">
                            <tr>
                                <td class="text-center text-sm" x-text="idx + 1"></td>
                                <td><input type="text" :name="'risks[' + idx + '][uraian_kegiatan]'"
                                           x-model="risks[idx].uraian_kegiatan" class="form-input"
                                           placeholder="Uraian"></td>
                                <td><input type="text" :name="'risks[' + idx + '][identifikasi_bahaya]'"
                                           x-model="risks[idx].identifikasi_bahaya" class="form-input"
                                           placeholder="Bahaya"></td>
                                <td><input type="text" :name="'risks[' + idx + '][peluang]'"
                                           x-model="risks[idx].peluang" class="form-input"
                                           placeholder="Contoh: 4/5"></td>
                                <td><input type="text" :name="'risks[' + idx + '][akibat]'"
                                           x-model="risks[idx].akibat" class="form-input"
                                           placeholder="Contoh: 2/5"></td>
                                <td><input type="text" :name="'risks[' + idx + '][tingkat_risiko]'"
                                           x-model="risks[idx].tingkat_risiko" class="form-input"
                                           placeholder="Contoh: 4/4"></td>
                                <td><textarea :name="'risks[' + idx + '][pengendalian_risiko]'"
                                             x-model="risks[idx].pengendalian_risiko" rows="2"
                                             class="form-input" placeholder="Pengendalian"></textarea></td>
                                <td><input type="text" :name="'risks[' + idx + '][penanggung_jawab]'"
                                           x-model="risks[idx].penanggung_jawab" class="form-input"
                                           placeholder="PJ"></td>
                                <td>
                                    <button type="button" @click="removeRisk(idx)"
                                            x-show="risks.length > 1"
                                            class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <button type="button" @click="addRisk()" class="btn-secondary mt-3 text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Risiko
            </button>
        </div>

        {{-- ========== STEP 7 — Monitoring & Evaluasi ========== --}}
        <div x-show="currentStep === 7" class="card">
            <h2 class="section-heading">L. Monitoring dan Evaluasi</h2>
            <textarea name="monitoring_evaluasi" rows="8" class="form-input"
                      placeholder="Tuliskan indikator keberhasilan, ketepatan waktu, kepuasan peserta, dan aspek evaluasi lainnya. Contoh:&#10;• Minimal 80% peserta hadir&#10;• Kegiatan selesai tepat waktu&#10;• Tingkat kepuasan peserta ≥ 4/5"
                      @input="data.monitoring_evaluasi = $event.target.value"
                      x-text="data.monitoring_evaluasi"></textarea>
            <p class="text-xs mt-2" style="color:var(--ink-500);">
                Tuliskan indikator keberhasilan, ketepatan waktu, kepuasan peserta, dan aspek evaluasi lainnya.
            </p>
        </div>

        {{-- ========== STEP 8 — Struktur Kepanitiaan ========== --}}
        <div x-show="currentStep === 8" class="card">
            <h2 class="section-heading">M. Struktur Kepanitiaan</h2>
            <div style="overflow-x:auto;">
                <table class="repeater-table">
                    <thead>
                        <tr>
                            <th style="min-width:130px;">Jabatan</th>
                            <th style="min-width:140px;">Nama</th>
                            <th style="min-width:120px;">Jurusan</th>
                            <th style="width:80px;">Angkatan</th>
                            <th style="min-width:100px;">Fakultas</th>
                            <th style="width:100px;">NIM</th>
                            <th style="width:40px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, idx) in committees" :key="idx">
                            <tr>
                                <td><input type="text" :name="'committees[' + idx + '][jabatan]'"
                                           x-model="committees[idx].jabatan" class="form-input"
                                           placeholder="Ketua Pelaksana"></td>
                                <td><input type="text" :name="'committees[' + idx + '][nama]'"
                                           x-model="committees[idx].nama" class="form-input"
                                           placeholder="Nama lengkap"></td>
                                <td><input type="text" :name="'committees[' + idx + '][jurusan]'"
                                           x-model="committees[idx].jurusan" class="form-input"
                                           placeholder="S1 Informatika"></td>
                                <td><input type="text" :name="'committees[' + idx + '][tahun_angkatan]'"
                                           x-model="committees[idx].tahun_angkatan" class="form-input"
                                           placeholder="2022"></td>
                                <td><input type="text" :name="'committees[' + idx + '][fakultas]'"
                                           x-model="committees[idx].fakultas" class="form-input"
                                           placeholder="FIT"></td>
                                <td><input type="text" :name="'committees[' + idx + '][nim]'"
                                           x-model="committees[idx].nim" class="form-input"
                                           placeholder="123456789"></td>
                                <td>
                                    <button type="button" @click="removeCommittee(idx)"
                                            x-show="committees.length > 1"
                                            class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <button type="button" @click="addCommittee()" class="btn-secondary mt-3 text-sm">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Anggota
            </button>
        </div>

        {{-- ========== STEP 9 — Rencana Anggaran Biaya ========== --}}
        <div x-show="currentStep === 9" class="card space-y-8">
            <h2 class="section-heading">N. Rencana Anggaran Biaya</h2>

            {{-- Pemasukan --}}
            <div>
                <h3 class="font-semibold mb-3" style="color:var(--ink-900); font-size:15px;">1. Pemasukan</h3>
                <table class="repeater-table">
                    <thead>
                        <tr><th style="width:40px;">No.</th><th>Keterangan</th><th style="width:160px;">Jumlah (Rp)</th><th style="width:40px;"></th></tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, idx) in budgetsPemasukan" :key="idx">
                            <tr>
                                <td class="text-center text-sm" x-text="idx + 1"></td>
                                <td><input type="text" :name="'budgets_pemasukan[' + idx + '][keterangan]'"
                                           x-model="budgetsPemasukan[idx].keterangan" class="form-input"
                                           placeholder="Keterangan pemasukan"></td>
                                <td><input type="number" :name="'budgets_pemasukan[' + idx + '][total]'"
                                           x-model="budgetsPemasukan[idx].total" class="form-input text-right"
                                           placeholder="0" min="0"></td>
                                <td>
                                    <button type="button" @click="budgetsPemasukan.splice(idx,1)"
                                            x-show="budgetsPemasukan.length > 1"
                                            class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr>
                            <td colspan="2" class="text-right font-semibold text-sm pr-4">Total Pemasukan</td>
                            <td class="text-right font-semibold text-sm">
                                Rp <span x-text="formatRp(budgetsPemasukan.reduce((s,r) => s + parseFloat(r.total||0), 0))"></span>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" @click="budgetsPemasukan.push({keterangan:'',total:0})" class="btn-secondary mt-2 text-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Baris
                </button>
            </div>

            {{-- Pengeluaran --}}
            <div>
                <h3 class="font-semibold mb-3" style="color:var(--ink-900); font-size:15px;">2. Pengeluaran</h3>
                <div style="overflow-x:auto;">
                    <table class="repeater-table">
                        <thead>
                            <tr>
                                <th style="width:40px;">No.</th>
                                <th>Keterangan</th>
                                <th style="width:80px;">Qty</th>
                                <th style="width:80px;">Satuan</th>
                                <th style="width:130px;">Harga Satuan</th>
                                <th style="width:130px;">Total</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, idx) in budgetsPengeluaran" :key="idx">
                                <tr>
                                    <td class="text-center text-sm" x-text="idx + 1"></td>
                                    <td><input type="text" :name="'budgets_pengeluaran[' + idx + '][keterangan]'"
                                               x-model="budgetsPengeluaran[idx].keterangan" class="form-input"
                                               placeholder="Keterangan"></td>
                                    <td><input type="number" :name="'budgets_pengeluaran[' + idx + '][kuantitas]'"
                                               x-model.number="budgetsPengeluaran[idx].kuantitas"
                                               @input="calcBudget(idx)"
                                               class="form-input text-center" min="0"></td>
                                    <td><input type="text" :name="'budgets_pengeluaran[' + idx + '][satuan]'"
                                               x-model="budgetsPengeluaran[idx].satuan" class="form-input"
                                               placeholder="pcs"></td>
                                    <td><input type="number" :name="'budgets_pengeluaran[' + idx + '][harga_satuan]'"
                                               x-model.number="budgetsPengeluaran[idx].harga_satuan"
                                               @input="calcBudget(idx)"
                                               class="form-input text-right" min="0"></td>
                                    <td>
                                        <input type="number" :name="'budgets_pengeluaran[' + idx + '][total]'"
                                               x-model="budgetsPengeluaran[idx].total"
                                               readonly class="form-input text-right"
                                               style="background:var(--surface-muted);">
                                    </td>
                                    <td>
                                        <button type="button" @click="budgetsPengeluaran.splice(idx,1)"
                                                x-show="budgetsPengeluaran.length > 1"
                                                class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <tr>
                                <td colspan="5" class="text-right font-semibold text-sm pr-4">TOTAL PENGELUARAN</td>
                                <td class="text-right font-semibold text-sm">
                                    Rp <span x-text="formatRp(budgetsPengeluaran.reduce((s,r) => s + parseFloat(r.total||0), 0))"></span>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" @click="budgetsPengeluaran.push({keterangan:'',kuantitas:0,satuan:'',harga_satuan:0,total:0})" class="btn-secondary mt-2 text-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Baris
                </button>
            </div>

            {{-- Sumber Dana --}}
            <div>
                <h3 class="font-semibold mb-3" style="color:var(--ink-900); font-size:15px;">3. Sumber Dana</h3>
                <table class="repeater-table">
                    <thead>
                        <tr><th style="width:40px;">No.</th><th>Keterangan</th><th style="width:160px;">Total (Rp)</th><th style="width:40px;"></th></tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, idx) in budgetsSumberDana" :key="idx">
                            <tr>
                                <td class="text-center text-sm" x-text="idx + 1"></td>
                                <td><input type="text" :name="'budgets_sumber_dana[' + idx + '][keterangan]'"
                                           x-model="budgetsSumberDana[idx].keterangan" class="form-input"
                                           placeholder="Sumber dana"></td>
                                <td><input type="number" :name="'budgets_sumber_dana[' + idx + '][total]'"
                                           x-model="budgetsSumberDana[idx].total" class="form-input text-right"
                                           placeholder="0" min="0"></td>
                                <td>
                                    <button type="button" @click="budgetsSumberDana.splice(idx,1)"
                                            x-show="budgetsSumberDana.length > 1"
                                            class="p-1 hover:bg-red-50 rounded" style="color:var(--danger);">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <button type="button" @click="budgetsSumberDana.push({keterangan:'',total:0})" class="btn-secondary mt-2 text-sm">
                    <i data-lucide="plus" class="w-4 h-4"></i> Tambah Baris
                </button>
            </div>
        </div>

        {{-- ========== STEP 10 — Penutup & Pengesahan ========== --}}
        <div x-show="currentStep === 10" class="card">
            <h2 class="section-heading">Penutup & Lembar Pengesahan</h2>

            <div class="mb-6">
                <label class="form-label">O. Penutup</label>
                <textarea name="penutup" rows="6" class="form-input"
                          placeholder="Demikian proposal kegiatan ini kami susun dengan harapan mendapat persetujuan dan dukungan dari pihak Direktorat Kemahasiswaan..."
                          @input="data.penutup = $event.target.value"
                          x-text="data.penutup"></textarea>
            </div>

            <h3 class="font-semibold mb-4" style="font-size:15px; color:var(--ink-900);">P. Lembar Pengesahan — Data Penandatangan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 rounded-lg border" style="border-color:var(--ink-300);">
                    <p class="text-sm font-semibold mb-3" style="color:var(--ink-700);">President UKM / Organisasi</p>
                    <label class="form-label">Nama</label>
                    <input type="text" name="president_ukm_nama" class="form-input mb-2"
                           placeholder="Nama President UKM">
                    <label class="form-label">NIM</label>
                    <input type="text" name="president_ukm_nim" class="form-input"
                           placeholder="NIM President">
                </div>
                <div class="p-4 rounded-lg border" style="border-color:var(--ink-300);">
                    <p class="text-sm font-semibold mb-3" style="color:var(--ink-700);">Sekretaris</p>
                    <label class="form-label">Nama</label>
                    <input type="text" name="sekretaris_nama" class="form-input mb-2"
                           placeholder="Nama Sekretaris">
                    <label class="form-label">NIM</label>
                    <input type="text" name="sekretaris_nim" class="form-input"
                           placeholder="NIM Sekretaris">
                </div>
                <div class="p-4 rounded-lg border" style="border-color:var(--ink-300);">
                    <p class="text-sm font-semibold mb-3" style="color:var(--ink-700);">Ketua Pelaksana</p>
                    <label class="form-label">Nama</label>
                    <input type="text" name="ketua_pelaksana_nama" class="form-input mb-2"
                           placeholder="Nama Ketua Pelaksana">
                    <label class="form-label">NIM</label>
                    <input type="text" name="ketua_pelaksana_nim" class="form-input"
                           placeholder="NIM Ketua Pelaksana">
                </div>
                <div class="p-4 rounded-lg border" style="border-color:var(--ink-300);">
                    <p class="text-sm font-semibold mb-3" style="color:var(--ink-700);">Pembina</p>
                    <label class="form-label">Nama</label>
                    <input type="text" name="pembina_nama" class="form-input mb-2"
                           placeholder="Nama Pembina">
                    <label class="form-label">NIP</label>
                    <input type="text" name="pembina_nip" class="form-input"
                           placeholder="NIP Pembina">
                </div>
                <div class="md:col-span-2 p-4 rounded-lg border" style="border-color:var(--ink-300); background:var(--surface-alt);">
                    <p class="text-sm font-semibold mb-3" style="color:var(--ink-700);">Direktur Kemahasiswaan (dapat diubah jika perlu)</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Nama Direktur</label>
                            <input type="text" name="direktur_nama" class="form-input"
                                   value="Dr. Maulana Rezi Ramadhana, S.Psi., M.Psi., Psikolog">
                        </div>
                        <div>
                            <label class="form-label">NIP Direktur</label>
                            <input type="text" name="direktur_nip" class="form-input" value="20820005">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== STEP 11 — Lampiran ========== --}}
        <div x-show="currentStep === 11" class="card">
            <h2 class="section-heading">Q. Lampiran</h2>
            <div class="mb-4 p-4 rounded-lg" style="background:var(--surface-alt); border:1px solid var(--ink-300);">
                <p class="text-sm" style="color:var(--ink-500);">
                    Upload foto dokumentasi, nota, bukti transfer, poster kegiatan, atau file pendukung lainnya.
                    Format: PNG, JPG, PDF. Maks 2MB per file.
                </p>
            </div>

            <div class="mb-4">
                <label class="form-label">Pilih File Lampiran</label>
                <input type="file" name="lampirans[]" multiple accept="image/*,application/pdf"
                       class="form-input" style="padding:8px;"
                       @change="addLampirans($event)">
            </div>

            <div class="space-y-3">
                <template x-for="(file, idx) in lampiranPreviews" :key="idx">
                    <div class="flex items-center gap-3 p-3 rounded-lg border" style="border-color:var(--ink-300);">
                        <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 flex items-center justify-center"
                             style="background:var(--surface-muted);">
                            <template x-if="file.type.startsWith('image/')">
                                <img :src="file.preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!file.type.startsWith('image/')">
                                <i data-lucide="file-text" class="w-6 h-6" style="color:var(--ink-500);"></i>
                            </template>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium mb-1" style="color:var(--ink-700);" x-text="file.name"></p>
                            <input type="text" :name="'lampiran_captions[' + idx + ']'"
                                   class="form-input text-sm"
                                   placeholder="Caption / keterangan (opsional)">
                        </div>
                        <button type="button" @click="lampiranPreviews.splice(idx, 1)"
                                class="p-2 hover:bg-red-50 rounded" style="color:var(--danger);">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </template>
            </div>

            <p x-show="lampiranPreviews.length === 0" class="text-sm text-center py-8" style="color:var(--ink-300);">
                Belum ada file yang dipilih.
            </p>
        </div>

        {{-- ========== STEP 12 — Review & Generate ========== --}}
        <div x-show="currentStep === 12" class="card">
            <h2 class="section-heading">Review & Generate PDF</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="p-4 rounded-xl" style="background:var(--surface-alt); border:1px solid var(--ink-300);">
                    <h3 class="font-semibold mb-3 text-sm" style="color:var(--ink-500); text-transform:uppercase; letter-spacing:0.5px;">Informasi Kegiatan</h3>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span style="color:var(--ink-500);">Nama Kegiatan</span>
                            <p class="font-semibold" style="color:var(--ink-900);" x-text="data.nama_kegiatan || '—'"></p>
                        </div>
                        <div>
                            <span style="color:var(--ink-500);">Penyelenggara</span>
                            <p class="font-semibold" style="color:var(--ink-900);" x-text="data.penyelenggara || '—'"></p>
                        </div>
                        <div>
                            <span style="color:var(--ink-500);">Tanggal</span>
                            <p class="font-semibold" style="color:var(--ink-900);" x-text="(data.tanggal_mulai || '—') + ' s.d. ' + (data.tanggal_selesai || '—')"></p>
                        </div>
                        <div>
                            <span style="color:var(--ink-500);">Tempat</span>
                            <p class="font-semibold" style="color:var(--ink-900);" x-text="data.tempat_kegiatan || '—'"></p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-xl" style="background:var(--surface-alt); border:1px solid var(--ink-300);">
                    <h3 class="font-semibold mb-3 text-sm" style="color:var(--ink-500); text-transform:uppercase; letter-spacing:0.5px;">Ringkasan Dokumen</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span style="color:var(--ink-500);">Anggota Kepanitiaan</span>
                            <span class="font-semibold" x-text="committees.filter(r => r.nama).length + ' orang'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:var(--ink-500);">Baris Rundown</span>
                            <span class="font-semibold" x-text="rundowns.filter(r => r.aktivitas).length + ' item'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:var(--ink-500);">Total Pengeluaran</span>
                            <span class="font-semibold">
                                Rp <span x-text="formatRp(budgetsPengeluaran.reduce((s,r) => s + parseFloat(r.total||0), 0))"></span>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:var(--ink-500);">Lampiran</span>
                            <span class="font-semibold" x-text="lampiranPreviews.length + ' file'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:var(--ink-500);">Logo Organisasi</span>
                            <span class="font-semibold" x-text="logoPreview ? 'Diunggah ✓' : 'Tidak ada'"></span>
                        </div>
                    </div>
                    <div x-show="logoPreview" class="mt-3">
                        <img :src="logoPreview" style="max-height:64px; object-fit:contain;">
                    </div>
                </div>
            </div>

            <div class="p-4 mb-6 rounded-lg" style="background:#FFF3E0; border:1px solid #ED6C02;">
                <p class="text-sm" style="color:#ED6C02;">
                    <i data-lucide="alert-circle" class="w-4 h-4 inline"></i>
                    Setelah submit, proposal akan disimpan dan PDF akan langsung diunduh.
                    Pastikan semua data sudah benar sebelum melanjutkan.
                </p>
            </div>

            <button type="submit" class="btn-primary w-full py-4 text-base justify-center">
                <i data-lucide="download" class="w-5 h-5"></i>
                Generate Proposal PDF
            </button>
        </div>

        {{-- Navigasi --}}
        <div class="flex justify-between mt-6">
            <button type="button" @click="prevStep()"
                    x-show="currentStep > 1"
                    class="btn-secondary">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Sebelumnya
            </button>
            <div x-show="currentStep === 1"></div>

            <button type="button" @click="nextStep()"
                    x-show="currentStep < totalSteps"
                    class="btn-primary ml-auto">
                Selanjutnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
function proposalForm() {
    return {
        currentStep: 1,
        totalSteps: 12,
        stepLabels: [
            'Identitas Kegiatan', 'Cover & Logo', 'Narasi Kegiatan',
            'Materi & Narasumber', 'Susunan Acara', 'Analisis Risiko',
            'Monitoring & Evaluasi', 'Struktur Kepanitiaan', 'Rencana Anggaran',
            'Penutup & Pengesahan', 'Lampiran', 'Review & Generate'
        ],
        data: {
            nama_kegiatan: '', tema_kegiatan: '', penyelenggara: '', afiliasi: '',
            tanggal_mulai: '', tanggal_selesai: '', waktu_mulai: '', waktu_selesai: '',
            tempat_kegiatan: '', kota: 'BANDUNG', tahun: new Date().getFullYear(),
            latar_belakang: '', sasaran_kegiatan: '', bentuk_kegiatan: '',
            narasumber_kegiatan: '', monitoring_evaluasi: '', penutup: ''
        },
        logoPreview: null,
        tujuanList: [''],
        materiList: [{ judul: '', deskripsi: '' }],
        rundowns: [{ waktu_mulai: '', waktu_selesai: '', durasi_menit: 0, aktivitas: '' }],
        risks: [{ uraian_kegiatan: '', identifikasi_bahaya: '', peluang: '', akibat: '', tingkat_risiko: '', pengendalian_risiko: '', penanggung_jawab: '' }],
        committees: [{ jabatan: '', nama: '', jurusan: '', tahun_angkatan: '', fakultas: '', nim: '' }],
        budgetsPemasukan: [{ keterangan: '', total: 0 }],
        budgetsPengeluaran: [{ keterangan: '', kuantitas: 0, satuan: '', harga_satuan: 0, total: 0 }],
        budgetsSumberDana: [{ keterangan: '', total: 0 }],
        lampiranPreviews: [],

        init() {
            // Re-init lucide on step change
            this.$watch('currentStep', () => {
                this.$nextTick(() => { if (window.lucide) lucide.createIcons(); });
            });
        },

        prevStep() { if (this.currentStep > 1) this.currentStep--; window.scrollTo(0, 0); },
        nextStep() {
            if (!this.validateStep()) return;
            if (this.currentStep < this.totalSteps) this.currentStep++;
            window.scrollTo(0, 0);
        },

        validateStep() {
            if (this.currentStep === 1) {
                if (!this.data.nama_kegiatan.trim()) {
                    alert('Nama Kegiatan wajib diisi.'); return false;
                }
                if (!this.data.tanggal_mulai || !this.data.tanggal_selesai) {
                    alert('Tanggal Mulai dan Selesai wajib diisi.'); return false;
                }
                if (this.data.tanggal_selesai < this.data.tanggal_mulai) {
                    alert('Tanggal Selesai tidak boleh sebelum Tanggal Mulai.'); return false;
                }
            }
            return true;
        },

        previewLogo(event) {
            const file = event.target.files[0];
            if (file) this.logoPreview = URL.createObjectURL(file);
        },

        addTujuan() { this.tujuanList.push(''); },
        removeTujuan(idx) { if (this.tujuanList.length > 1) this.tujuanList.splice(idx, 1); },

        addMateri() { this.materiList.push({ judul: '', deskripsi: '' }); },
        removeMateri(idx) { if (this.materiList.length > 1) this.materiList.splice(idx, 1); },

        addRundown() { this.rundowns.push({ waktu_mulai: '', waktu_selesai: '', durasi_menit: 0, aktivitas: '' }); },
        removeRundown(idx) { if (this.rundowns.length > 1) this.rundowns.splice(idx, 1); },
        calcDurasi(idx) {
            const r = this.rundowns[idx];
            if (r.waktu_mulai && r.waktu_selesai) {
                const [h1, m1] = r.waktu_mulai.split(':').map(Number);
                const [h2, m2] = r.waktu_selesai.split(':').map(Number);
                const diff = (h2 * 60 + m2) - (h1 * 60 + m1);
                r.durasi_menit = diff > 0 ? diff : 0;
            }
        },

        addRisk() { this.risks.push({ uraian_kegiatan:'', identifikasi_bahaya:'', peluang:'', akibat:'', tingkat_risiko:'', pengendalian_risiko:'', penanggung_jawab:'' }); },
        removeRisk(idx) { if (this.risks.length > 1) this.risks.splice(idx, 1); },

        addCommittee() { this.committees.push({ jabatan:'', nama:'', jurusan:'', tahun_angkatan:'', fakultas:'', nim:'' }); },
        removeCommittee(idx) { if (this.committees.length > 1) this.committees.splice(idx, 1); },

        calcBudget(idx) {
            const row = this.budgetsPengeluaran[idx];
            const qty = parseFloat(row.kuantitas) || 0;
            const harga = parseFloat(row.harga_satuan) || 0;
            row.total = qty * harga;
        },

        addLampirans(event) {
            const files = Array.from(event.target.files);
            files.forEach(file => {
                this.lampiranPreviews.push({
                    name: file.name,
                    type: file.type,
                    preview: file.type.startsWith('image/') ? URL.createObjectURL(file) : null,
                });
            });
        },

        formatRp(val) {
            return Number(val || 0).toLocaleString('id-ID');
        },
    };
}
</script>
@endpush
