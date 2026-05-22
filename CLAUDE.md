# CLAUDE.md

Dokumen ini adalah panduan utama untuk Claude Code dalam mengembangkan proyek **Sistem Generator Laporan & LPJ Direktorat Kemahasiswaan Telkom University**. Baca seluruh dokumen ini sebelum menulis kode apa pun.

---

## 1. Ringkasan Proyek

Aplikasi web internal untuk **Direktorat Kemahasiswaan, Karier, dan Alumni Telkom University** yang memungkinkan mahasiswa/UKM/HIMA membuat dokumen administratif (Proposal Kegiatan dan Laporan Pertanggungjawaban) melalui form input dinamis, lalu meng-generate hasilnya menjadi PDF yang **persis** mengikuti template resmi Direktorat Kemahasiswaan.

### Tujuan utama
1. **Autentikasi**: register, login, logout, edit profil (nama, email, password).
2. **Generate Proposal Kegiatan** dalam format PDF mengikuti `CONTOH_TEMPLATE_LAPORAN.pdf` (catatan: nama file aslinya `LAPORAN` tapi isinya adalah template **Proposal Kegiatan**).
3. **Generate Laporan Pertanggungjawaban (LPJ)** dalam format PDF mengikuti `CONTOH_TEMPLATE_LPJ.pdf`.
4. Sidebar dengan menu **expandable**: "Generate Laporan" → di-expand muncul "Generate Proposal" dan "Generate LPJ".

### Stack
- **Backend**: Laravel 11 (PHP 8.2+)
- **Auth**: Laravel Breeze (atau manual session-based)
- **Frontend**: Blade + Tailwind CSS + Alpine.js (untuk interaktivitas ringan)
- **PDF Generator**: `barryvdh/laravel-dompdf` (utama) atau `spatie/laravel-browsershot` (jika butuh rendering modern)
- **Database**: MySQL/MariaDB
- **File Upload**: Laravel Storage (disk `public`) untuk logo cover, lampiran, dan dokumentasi

---

## 2. Konteks Bisnis & Aturan Penting

### 2.1 Tentang dokumen Proposal
- Dokumen Proposal adalah dokumen **pra-kegiatan** yang berisi rencana kegiatan.
- Struktur (lihat `CONTOH_TEMPLATE_LAPORAN.pdf`):
  1. Cover (judul kegiatan, tanggal, logo Telkom + logo UKM, "BANDUNG", tahun)
  2. Lembar Evaluasi Proposal (tabel tanda tangan Kepala Urusan & Kepala Bagian)
  3. Form Kontrol Pengajuan Proposal (tabel administrasi)
  4. Rekap Proposal (tabel data ringkasan)
  5. Daftar Isi
  6. A. Latar Belakang (paragraf)
  7. B. Nama Kegiatan
  8. C. Tema Kegiatan
  9. D. Tujuan Kegiatan (list numerik)
  10. E. Sasaran Kegiatan
  11. F. Waktu dan Tempat
  12. G. Bentuk Kegiatan
  13. H. Materi Kegiatan (list numerik dengan deskripsi)
  14. I. Narasumber Kegiatan
  15. J. Susunan Acara/Rundown (tabel waktu-durasi-aktivitas)
  16. K. Analisis Resiko (tabel dengan kolom: No, Uraian, Identifikasi Bahaya, Peluang, Akibat, Tingkat Risiko, Pengendalian, Penanggung Jawab)
  17. L. Monitoring dan Evaluasi (paragraf + bullet)
  18. M. Struktur Kepanitiaan (tabel: Jabatan, Nama, Jurusan, Tahun, Fakultas, NIM)
  19. N. Rencana Anggaran Biaya (3 sub-tabel: Pemasukan, Pengeluaran, Sumber Dana)
  20. O. Penutup (paragraf)
  21. P. Lembar Pengesahan (4 kotak tanda tangan: President UKM, Sekretaris, Ketua Pelaksana, Pembina, lalu Direktur Kemahasiswaan)
  22. Q. Lampiran (gambar-gambar)

### 2.2 Tentang dokumen LPJ
- Dokumen LPJ adalah dokumen **pasca-kegiatan** yang berisi pertanggungjawaban.
- Struktur (lihat `CONTOH_TEMPLATE_LPJ.pdf`):
  1. Cover (judul "LAPORAN PERTANGGUNGJAWABAN", nama kegiatan, akronim, logo Telkom + logo UKM, "BANDUNG", tahun)
  2. Daftar Isi
  3. A. Latar Belakang
  4. B. Nama Kegiatan
  5. C. Tema Kegiatan
  6. D. Tujuan Kegiatan
  7. E. Sasaran Kegiatan
  8. F. Waktu dan Tempat
  9. G. Bentuk Kegiatan
  10. H. Deskripsi Pelaksanaan Kegiatan (paragraf pasca-kegiatan)
  11. I. Susunan Acara/Rundown
  12. J. Analisis Risiko
  13. K. Monitoring dan Evaluasi (tabel: Tanggal, Detail Kegiatan, PIC, Keterangan)
  14. L. Simpulan dan Rekomendasi
  15. M. Struktur Kepanitiaan
  16. N. Realisasi Anggaran Biaya (Dana Masuk + Dana Keluar)
  17. O. Penutup
  18. P. Lembar Pengesahan
  19. Q. Lampiran (nota, bukti pembayaran, dokumentasi, poster)

### 2.3 Aturan Header/Kop Surat (PENTING)
Dari arahan project manager:
- **LPJ**: Tidak menggunakan kop surat/header di setiap halaman. Mulai dari halaman setelah cover, **tidak ada header**. Template asli LPJ memang punya header "UNIT KEGIATAN MAHASISWA TIM BUDI PEKERTI TELKOM UNIVERSITY" — **ABAIKAN INI**, jangan dijadikan template.
- **Proposal**: Sama, **tidak menggunakan kop surat/header** di setiap halaman.
- **Cover**: Logo Telkom tetap masuk sebagai bawaan template. Logo UKM/organisasi di-upload oleh user via form, lalu di-render di cover.
- **Lampiran**: User upload gambar (logo organisasi, foto dokumentasi, nota, bukti transfer, dll), lalu sistem menempatkannya di bagian lampiran sesuai urutan.

### 2.4 Aturan Lembar Pengesahan
- Tanda tangan **dikosongkan semua** (tidak ada gambar tanda tangan).
- Hanya disediakan **ruang/tempat kosong** untuk tanda tangan basah, dengan nama dan NIM/NIP di bawahnya.

### 2.5 Bahasa
- Seluruh UI dan dokumen menggunakan **Bahasa Indonesia**.
- Field database boleh pakai bahasa Inggris (snake_case), tapi label form harus Bahasa Indonesia.

---

## 3. Identitas Visual & Desain

### 3.1 Referensi
- Website acuan: **https://studentaffairs.telkomuniversity.ac.id/**
- Screenshot referensi: hero section dengan gradient merah-pink di atas foto gedung, navigasi dengan logo Direktorat di kiri, menu di tengah, tombol "Kontak" merah di kanan, font serif untuk heading besar.

### 3.2 Palette Warna (Telkom Brand)
```
--telkom-red:        #E03A3E   /* Warna utama brand Telkom, tombol primer, link aktif */
--telkom-red-dark:   #B82A2E   /* Hover state tombol primer */
--telkom-red-light:  #F5B5B7   /* Background lembut, badge */
--telkom-gray:       #58595B   /* Logo Telkom abu-abu */
--ink-900:           #1A1A1A   /* Heading utama */
--ink-700:           #343434   /* Body text */
--ink-500:           #666666   /* Text sekunder */
--ink-300:           #BDBDBD   /* Border lembut */
--surface:           #FFFFFF
--surface-alt:       #F8F8F8   /* Background section selang-seling */
--surface-muted:     #EAEAEA   /* Background input/disabled */
--success:           #2E7D32
--warning:           #ED6C02
--danger:            #D32F2F
```

### 3.3 Tipografi
- **Heading display** (hero, judul besar): serif — `"Source Serif Pro", "Minion Pro", Georgia, serif`. Bobot 600–700.
- **Heading UI** (h2–h6 di dashboard): sans-serif — `"Inter", "Segoe UI", system-ui, sans-serif`. Bobot 600.
- **Body**: `"Inter", "Segoe UI", system-ui, sans-serif`. Bobot 400, ukuran 15–16px, line-height 1.6.
- **PDF (dompdf)**: gunakan `DejaVu Sans` (default dompdf) atau register `Times New Roman` untuk mengikuti template resmi yang serif/Times.

### 3.4 Komponen UI
- **Tombol primer**: background `--telkom-red`, text putih, rounded-full (pill shape, mengikuti tombol "Kontak" di website acuan), padding `12px 28px`, hover gelap.
- **Tombol sekunder**: outline merah, hover fill merah.
- **Card**: background putih, border-radius 12px, shadow halus `0 2px 8px rgba(0,0,0,0.06)`, padding 24px.
- **Input**: border-bottom only (style minimalist) atau border 1px solid `--ink-300` rounded 8px. Focus ring merah lembut.
- **Sidebar**: width 260px, background putih, border-right 1px solid `--ink-300`. Item aktif: background `--telkom-red-light`, text `--telkom-red`, dengan strip kiri 4px merah penuh.

### 3.5 Animasi & Sentuhan Modern
- Transition default: `transition: all 0.2s ease-out`.
- **Fade-in** halaman saat load (`opacity 0→1`, `translateY(8px)→0`, 300ms).
- **Sidebar expand**: animasi smooth height/max-height transition (300ms ease-in-out) saat sub-menu dibuka.
- **Tombol**: hover sedikit scale (1.02) + shadow tumbuh.
- **Form input**: focus ring tumbuh halus.
- **Page load**: skeleton loader untuk konten yang menunggu data.
- Gunakan **Alpine.js** untuk transitions kecil dan **AOS** (Animate On Scroll) opsional untuk landing.
- Hindari animasi berlebihan; harus terasa profesional, bukan playful.

---

## 4. Struktur Folder Laravel

```
direktorat-kemahasiswaan-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                       # Breeze controllers
│   │   │   ├── ProfileController.php       # Edit nama, email, password, logout
│   │   │   ├── DashboardController.php
│   │   │   ├── ProposalController.php      # CRUD + generate PDF Proposal
│   │   │   └── LpjController.php           # CRUD + generate PDF LPJ
│   │   ├── Requests/
│   │   │   ├── ProposalStoreRequest.php
│   │   │   └── LpjStoreRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Proposal.php
│   │   ├── Lpj.php
│   │   ├── ProposalAttachment.php          # Lampiran cover/logo/dokumen
│   │   └── LpjAttachment.php
│   └── Services/
│       ├── ProposalPdfService.php          # Logic generate PDF proposal
│       └── LpjPdfService.php               # Logic generate PDF LPJ
├── database/
│   └── migrations/
│       ├── ..._create_users_table.php
│       ├── ..._create_proposals_table.php
│       ├── ..._create_proposal_rundowns_table.php
│       ├── ..._create_proposal_risks_table.php
│       ├── ..._create_proposal_committees_table.php
│       ├── ..._create_proposal_budgets_table.php
│       ├── ..._create_proposal_attachments_table.php
│       ├── ..._create_lpjs_table.php
│       └── (relasi LPJ yang mirror proposal)
├── resources/
│   ├── views/
│   │   ├── auth/                           # login, register, dll
│   │   ├── layouts/
│   │   │   ├── app.blade.php               # layout utama (sidebar + topbar)
│   │   │   └── guest.blade.php             # layout untuk auth pages
│   │   ├── components/
│   │   │   ├── sidebar.blade.php
│   │   │   ├── topbar.blade.php
│   │   │   └── form/                       # input, textarea, repeater, file-upload
│   │   ├── profile/
│   │   │   ├── edit.blade.php
│   │   ├── proposal/
│   │   │   ├── index.blade.php             # list proposal user
│   │   │   ├── create.blade.php            # form multi-step
│   │   │   └── pdf/                        # blade templates untuk PDF
│   │   │       ├── proposal.blade.php      # master PDF
│   │   │       ├── partials/
│   │   │       │   ├── cover.blade.php
│   │   │       │   ├── lembar-evaluasi.blade.php
│   │   │       │   ├── form-kontrol.blade.php
│   │   │       │   ├── rekap.blade.php
│   │   │       │   ├── daftar-isi.blade.php
│   │   │       │   ├── isi.blade.php
│   │   │       │   ├── lembar-pengesahan.blade.php
│   │   │       │   └── lampiran.blade.php
│   │   ├── lpj/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── pdf/
│   │   │       ├── lpj.blade.php
│   │   │       └── partials/...
│   │   └── dashboard.blade.php
│   ├── css/
│   │   └── app.css                         # tailwind entry + custom utilities
│   └── js/
│       └── app.js                          # alpine.js init
├── public/
│   └── img/
│       ├── logo-telkom.png                 # logo bawaan template (WAJIB ada)
│       ├── logo-direktorat.png             # logo Direktorat Kemahasiswaan
│       └── hero-bg.jpg
├── routes/
│   ├── web.php
│   └── auth.php
└── CLAUDE.md (file ini)
```

---

## 5. Skema Database

### 5.1 `users` (Laravel default + tambahan)
```
id, name, email, email_verified_at, password,
organization (string nullable),    # contoh: "SRE Telkom University"
position (string nullable),        # contoh: "Ketua Pelaksana"
remember_token, timestamps
```

### 5.2 `proposals`
```
id, user_id, 
nama_kegiatan, tema_kegiatan, 
tanggal_mulai (date), tanggal_selesai (date),
waktu_mulai (time), waktu_selesai (time),
tempat_kegiatan, kota (default 'BANDUNG'), tahun (year),
penyelenggara, afiliasi,
total_anggaran (decimal nullable), pengajuan_dana (decimal nullable),
latar_belakang (text),
tujuan_kegiatan (json),                # array of string
sasaran_kegiatan (text),
bentuk_kegiatan (text),
materi_kegiatan (json),                # array of {judul, deskripsi}
narasumber_kegiatan (text),
monitoring_evaluasi (text),
penutup (text),
ketua_pelaksana_nama, ketua_pelaksana_nim,
president_ukm_nama, president_ukm_nim,
sekretaris_nama, sekretaris_nim,
pembina_nama, pembina_nip,
direktur_nama (default 'Dr. Maulana Rezi Ramadhana, S.Psi., M.Psi., Psikolog'),
direktur_nip (default '20820005'),
logo_organisasi_path (string nullable),    # logo UKM upload
status (enum: draft, generated),
generated_at (timestamp nullable),
timestamps
```

### 5.3 `proposal_rundowns` (tabel anak)
```
id, proposal_id, urutan (int), 
waktu_mulai (time), waktu_selesai (time), 
durasi_menit (int), aktivitas (string), timestamps
```

### 5.4 `proposal_risks`
```
id, proposal_id, urutan,
uraian_kegiatan, identifikasi_bahaya,
peluang (string, contoh "4/5"), akibat (string),
tingkat_risiko (string), pengendalian_risiko (text),
penanggung_jawab, timestamps
```

### 5.5 `proposal_committees`
```
id, proposal_id, urutan,
jabatan, nama, jurusan, tahun_angkatan, fakultas, nim, timestamps
```

### 5.6 `proposal_budgets`
```
id, proposal_id, 
jenis (enum: pemasukan, pengeluaran, sumber_dana),
keterangan, kuantitas (int nullable), satuan (string nullable),
harga_satuan (decimal nullable), total (decimal), urutan, timestamps
```

### 5.7 `proposal_attachments`
```
id, proposal_id, jenis (enum: cover_logo, lampiran),
caption (string nullable), file_path, file_type, urutan, timestamps
```

### 5.8 LPJ tables
- `lpjs` — mirror struktur proposals, ditambah:
  - `deskripsi_pelaksanaan (text)`
  - `simpulan_rekomendasi (text)`
  - `ketua_ukm_nama, ketua_ukm_nim`
  - `pembina_1_nama, pembina_1_nip, pembina_2_nama, pembina_2_nip`
- `lpj_rundowns`, `lpj_risks`, `lpj_committees` — mirror.
- `lpj_monitoring` — tambahan khusus LPJ:
  ```
  id, lpj_id, urutan, tanggal, fase (string contoh "Pra-Acara"),
  detail_kegiatan, pic, keterangan, timestamps
  ```
- `lpj_budgets` — sama dengan proposal_budgets tapi `jenis` = `dana_masuk` / `dana_keluar`. Tambahan kolom `divisi (string nullable)` untuk pengeluaran.
- `lpj_attachments` — sama; `jenis` enum bisa: `cover_logo`, `nota`, `bukti_transfer`, `dokumentasi`, `poster`.

---

## 6. Routing

```php
// routes/web.php
Route::get('/', fn() => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Proposal
    Route::resource('proposal', ProposalController::class);
    Route::get('/proposal/{proposal}/generate', [ProposalController::class, 'generatePdf'])->name('proposal.generate');
    Route::get('/proposal/{proposal}/preview', [ProposalController::class, 'preview'])->name('proposal.preview');

    // LPJ
    Route::resource('lpj', LpjController::class);
    Route::get('/lpj/{lpj}/generate', [LpjController::class, 'generatePdf'])->name('lpj.generate');
    Route::get('/lpj/{lpj}/preview', [LpjController::class, 'preview'])->name('lpj.preview');
});

require __DIR__.'/auth.php';
```

---

## 7. Spesifikasi Form Input (PENTING — sesuai konteks template)

### 7.1 Prinsip umum
- Form **multi-step** atau **single page panjang dengan accordion** per seksi (A–Q). Sesi seperti Rundown, Anggaran, Struktur Kepanitiaan, Analisis Risiko adalah **repeater** (user bisa tambah/hapus baris).
- Semua field punya **placeholder contoh** yang diambil dari template asli, supaya user paham apa yang harus diisi. Contoh:
  - Nama Kegiatan → placeholder: `Contoh: Orbit Star #1`
  - Tema → placeholder: `Contoh: Learning together, growing stronger`
  - Latar Belakang → placeholder paragraf panjang dari contoh.
- Validation: required untuk field utama, dates harus logis (selesai ≥ mulai).
- Field tanggal pakai `<input type="date">`, waktu pakai `<input type="time">`.
- Anggaran auto-kalkulasi total per baris (`kuantitas * harga_satuan`) lewat Alpine.js, dan grand total per seksi.

### 7.2 Step-by-step form Proposal (rekomendasi)
1. **Step 1 — Identitas Kegiatan**: nama, tema, penyelenggara, afiliasi, tanggal mulai/selesai, waktu mulai/selesai, tempat, kota, tahun.
2. **Step 2 — Cover & Logo**: upload logo UKM/organisasi (PNG, max 2MB).
3. **Step 3 — Narasi (Latar Belakang–Bentuk Kegiatan)**: textarea untuk A, B, C, D (repeater list tujuan), E, F, G.
4. **Step 4 — Materi & Narasumber**: repeater materi (judul + deskripsi), narasumber.
5. **Step 5 — Rundown**: repeater (waktu mulai, waktu selesai, durasi auto-hitung, aktivitas).
6. **Step 6 — Analisis Risiko**: repeater (7 kolom sesuai template).
7. **Step 7 — Monitoring & Evaluasi**: textarea narasi + sub-bullet KPI.
8. **Step 8 — Struktur Kepanitiaan**: repeater (jabatan, nama, jurusan, angkatan, fakultas, NIM).
9. **Step 9 — Anggaran**: 3 sub-section (Pemasukan, Pengeluaran, Sumber Dana). Repeater per section.
10. **Step 10 — Penutup & Pengesahan**: textarea penutup, isian nama+NIM untuk President UKM, Sekretaris, Ketua Pelaksana, Pembina (nama+NIP).
11. **Step 11 — Lampiran**: multi-file upload dengan caption per file.
12. **Step 12 — Review & Generate**: tampilkan ringkasan, tombol "Generate PDF".

### 7.3 LPJ form
Sama dengan proposal, dengan perbedaan:
- Hilangkan: Lembar Evaluasi, Form Kontrol Pengajuan (ini khusus proposal).
- Tambah: **Deskripsi Pelaksanaan Kegiatan** (paragraf pasca kegiatan), **Monitoring & Evaluasi** dalam bentuk tabel (Tanggal, Fase, Detail, PIC, Keterangan), **Simpulan dan Rekomendasi**.
- Anggaran berubah dari "Rencana" ke "Realisasi" (Dana Masuk + Dana Keluar dengan kolom Divisi).
- Lampiran wajib: nota, bukti pembayaran, dokumentasi foto, poster.

---

## 8. Spesifikasi PDF Generator

### 8.1 Library
Pakai **`barryvdh/laravel-dompdf`** sebagai default.

Install:
```bash
composer require barryvdh/laravel-dompdf
```

Konfigurasi `config/dompdf.php`:
- `default_paper_size` = `a4`
- `default_font` = `Times New Roman` atau `DejaVu Serif` (mendekati template aslinya)
- `enable_remote` = `true` (untuk load logo dari storage)
- `dpi` = 96

### 8.2 Blade PDF — aturan WAJIB
1. **TIDAK ADA HEADER/KOP SURAT di setiap halaman** untuk Proposal maupun LPJ. Template asli LPJ punya kop "UNIT KEGIATAN MAHASISWA TIM BUDI PEKERTI" — **JANGAN DITIRU**. Setiap halaman polos di bagian atas.
2. **Footer**: nomor halaman di tengah/kanan bawah. Romawi (I, II, III) untuk bagian sebelum isi (cover, daftar isi, dll mengikuti template asli), Arab (1, 2, 3, …) mulai bagian A. Latar Belakang. (Bisa disederhanakan jadi Arab semua jika kompleksitas tinggi — diskusikan dulu.)
3. **Cover**:
   - Judul kegiatan all caps, bold, center, font besar (16–18pt).
   - Sub-info (tanggal, dll) di bawah judul.
   - Logo Telkom WAJIB tampil (gunakan `public/img/logo-telkom.png`).
   - Logo organisasi/UKM dari upload user (path: `storage/app/public/...`).
   - "BANDUNG" dan tahun di bagian bawah, center.
4. **Lembar Pengesahan**:
   - Tata letak grid 3 kolom (President UKM, Sekretaris, Ketua Pelaksana).
   - Spasi kosong setinggi ~80px untuk tanda tangan basah.
   - Di bawahnya: nama tebal + NIM/NIP.
   - Row kedua: Pembina (center, 1 kolom).
   - Row ketiga: Direktur Kemahasiswaan (center, 1 kolom), default nama "Dr. Maulana Rezi Ramadhana, S.Psi., M.Psi., Psikolog" — NIP "20820005".
   - **KOSONGKAN semua tanda tangan**.
5. **Tabel**: border tipis 1px solid `#000`, padding 6–8px, header tabel bold center.
6. **Lampiran**: tampilkan gambar yang di-upload user, satu per page atau 2 per page tergantung jumlah, dengan caption di atas/bawah.
7. **Page break**: gunakan `<div style="page-break-after: always;"></div>` di antara seksi besar.

### 8.3 Contoh skeleton blade PDF
```blade
<!-- resources/views/proposal/pdf/proposal.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proposal - {{ $proposal->nama_kegiatan }}</title>
    <style>
        @page { margin: 80px 70px 80px 70px; }
        body { font-family: "Times New Roman", serif; font-size: 12pt; line-height: 1.5; color: #000; }
        h1, h2, h3 { font-weight: bold; }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        table { width: 100%; border-collapse: collapse; }
        table td, table th { border: 1px solid #000; padding: 6px; vertical-align: top; }
        .no-border, .no-border td { border: none; }
        .page-break { page-break-after: always; }
        .signature-box { height: 80px; }
    </style>
</head>
<body>
    @include('proposal.pdf.partials.cover')
    <div class="page-break"></div>
    @include('proposal.pdf.partials.lembar-evaluasi')
    <div class="page-break"></div>
    @include('proposal.pdf.partials.form-kontrol')
    {{-- dst --}}
</body>
</html>
```

### 8.4 Controller PDF
```php
public function generatePdf(Proposal $proposal)
{
    $this->authorize('view', $proposal);

    $pdf = Pdf::loadView('proposal.pdf.proposal', compact('proposal'))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont' => 'Times New Roman',
        ]);

    $filename = 'Proposal_' . Str::slug($proposal->nama_kegiatan) . '_' . now()->format('YmdHis') . '.pdf';
    return $pdf->download($filename);
}
```

---

## 9. Layout Aplikasi (UI)

### 9.1 Halaman Auth (Login/Register)
- Layout split: kiri form (40%), kanan ilustrasi/gradient merah Telkom (60%).
- Logo Direktorat di pojok kiri atas.
- Tombol primer pill-shape merah, full-width.
- Link "Belum punya akun? Daftar di sini" di bawah form.

### 9.2 Layout Dashboard
```
+----------------------------------------------------------+
|  [Logo Direktorat]    Cari...      [User Avatar ▾]       |  <- topbar (sticky)
+--------+-------------------------------------------------+
|        |                                                 |
| SIDE   |              MAIN CONTENT                       |
| BAR    |                                                 |
|        |                                                 |
| 🏠 Dashboard                                             |
| 📄 Generate Laporan ▾   <- expand                       |
|    └─ Generate Proposal                                  |
|    └─ Generate LPJ                                       |
| 👤 Profil                                                |
| 🚪 Logout                                                |
|        |                                                 |
+--------+-------------------------------------------------+
```

### 9.3 Sidebar — implementasi expand
Gunakan Alpine.js:
```blade
<aside class="w-64 bg-white border-r border-gray-200 h-screen">
    <nav x-data="{ openLaporan: {{ request()->routeIs('proposal.*', 'lpj.*') ? 'true' : 'false' }} }">
        <a href="{{ route('dashboard') }}" class="nav-item">
            <i data-lucide="home"></i> Dashboard
        </a>

        <button @click="openLaporan = !openLaporan" class="nav-item w-full justify-between">
            <span><i data-lucide="file-text"></i> Generate Laporan</span>
            <i data-lucide="chevron-down" :class="{ 'rotate-180': openLaporan }" class="transition-transform"></i>
        </button>
        <div x-show="openLaporan" x-collapse class="ml-6">
            <a href="{{ route('proposal.create') }}" class="nav-sub-item">Generate Proposal</a>
            <a href="{{ route('lpj.create') }}" class="nav-sub-item">Generate LPJ</a>
        </div>

        <a href="{{ route('profile.edit') }}" class="nav-item">
            <i data-lucide="user"></i> Profil
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item w-full text-left">
                <i data-lucide="log-out"></i> Logout
            </button>
        </form>
    </nav>
</aside>
```

Untuk animasi `x-collapse`, install plugin Alpine: `npm i @alpinejs/collapse`.

### 9.4 Halaman Profil
Tab vertikal: **Informasi Akun**, **Ubah Password**. Setiap tab punya form sendiri, simpan independen.

### 9.5 Halaman Form Proposal/LPJ
Stepper di atas (Step 1 of 12), tombol "Sebelumnya" dan "Selanjutnya". Auto-save draft ke `localStorage` setiap perubahan (atau ke server lewat AJAX).

---

## 10. Validasi & Security

- Semua route dashboard dibungkus middleware `auth`.
- `Proposal` dan `Lpj` punya policy: hanya owner (`user_id`) yang bisa view/edit/delete.
- File upload: validasi mime (`image/png,image/jpeg,image/jpg`), max size 2MB per file, max 20 file per dokumen.
- CSRF token aktif di semua form.
- Password minimal 8 karakter, butuh huruf+angka.
- Email harus unique.
- Rate limit login: 5x per menit.
- Sanitize input text yang akan masuk PDF — escape HTML untuk hindari XSS di Blade PDF (Blade `{{ }}` otomatis escape).

---

## 11. Yang HARUS Dihindari

1. **JANGAN** menyertakan kop surat / header organisasi di setiap halaman PDF Proposal maupun LPJ.
2. **JANGAN** menggunakan tanda tangan gambar — biarkan kosong untuk tanda tangan basah.
3. **JANGAN** hardcode nama UKM atau detail organisasi — semua harus dari input user (kecuali Direktur Kemahasiswaan yang punya default).
4. **JANGAN** pakai font yang tidak tersedia di dompdf tanpa register dulu.
5. **JANGAN** menempatkan logo Telkom di tempat user upload — logo Telkom **fixed** di cover, sementara logo organisasi user yang variabel.
6. **JANGAN** lupa: di Proposal struktur seperti Latar Belakang berhuruf "A.", "B.", "C.", dst. Konsisten dengan template asli.

---

## 12. Urutan Pengerjaan (Roadmap)

### Phase 1 — Foundation
1. Install Laravel 11 + Breeze (Blade) + Tailwind.
2. Setup Tailwind config dengan warna Telkom.
3. Buat layout `app.blade.php` + sidebar + topbar.
4. Implement auth (login, register, logout) — Breeze default.
5. Implement halaman Profil (edit nama, email, password).

### Phase 2 — Proposal
6. Migration + Model proposal & relasinya.
7. Form create proposal (multi-step).
8. Blade PDF proposal (mulai dari cover).
9. Service `ProposalPdfService` untuk assemble data.
10. Controller `generatePdf` — test download.
11. Iterasi sampai mirip template asli.

### Phase 3 — LPJ
12. Migration + Model LPJ.
13. Form create LPJ.
14. Blade PDF LPJ.
15. Test.

### Phase 4 — Polish
16. Animasi (fade-in, sidebar expand, button hover).
17. Responsive check (sidebar collapse di mobile).
18. Error handling & flash messages.
19. Seed data dummy untuk testing.

---

## 13. Catatan untuk Claude Code

- Saat user memberi instruksi, **selalu cek dulu CLAUDE.md ini** terutama bagian "Yang HARUS Dihindari" (section 11).
- Untuk konten Blade PDF, **selalu cocokkan dengan struktur template asli** di `CONTOH_TEMPLATE_LAPORAN.pdf` (untuk Proposal) dan `CONTOH_TEMPLATE_LPJ.pdf` (untuk LPJ). User punya kedua file ini.
- Saat menulis migration, gunakan urutan dependency yang benar (parent table dulu, child table belakangan).
- Saat menulis form repeater (rundown, anggaran, panitia, risiko), gunakan **Alpine.js** dengan array reactive, bukan jQuery clone.
- Jika ada keraguan tentang field/data, **tanya user dulu** dengan menyebut konteks template (misal: "Di section L Monitoring template Proposal ada bullet KPI — apakah ingin dibuat repeater atau cukup textarea?").
- Komit per phase, pesan commit jelas (`feat:`, `fix:`, `refactor:`, dll).
- Tulis kode dengan **PSR-12**, nama variable dalam **camelCase** (PHP) / **snake_case** (DB column), nama class **PascalCase**.

---

## 14. Test Manual Checklist (untuk QA)

- [ ] Register → email valid, password kuat
- [ ] Login → redirect ke dashboard
- [ ] Logout → balik ke landing
- [ ] Edit profil → nama/email/password berubah
- [ ] Sidebar expand "Generate Laporan" → muncul Proposal & LPJ
- [ ] Form Proposal step 1 → 12 navigable, validasi jalan
- [ ] Upload logo cover → preview muncul
- [ ] Upload multi lampiran → semua tersimpan
- [ ] Generate PDF Proposal → download otomatis
- [ ] PDF Proposal: tidak ada kop surat di halaman 2 dst
- [ ] PDF Proposal: tanda tangan kosong di Lembar Pengesahan
- [ ] PDF Proposal: cover punya logo Telkom + logo organisasi
- [ ] Sama untuk LPJ
- [ ] Mobile responsive (sidebar jadi drawer)

---

**Selesai. Mulailah dari Phase 1.**
