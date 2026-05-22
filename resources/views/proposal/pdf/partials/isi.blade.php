{{-- A. Latar Belakang --}}
<p class="section-title">A. Latar Belakang</p>
<p>{!! nl2br(e($proposal->latar_belakang)) !!}</p>

{{-- B. Nama Kegiatan --}}
<p class="section-title">B. Nama Kegiatan</p>
<p>{{ $proposal->nama_kegiatan }}</p>

{{-- C. Tema Kegiatan --}}
<p class="section-title">C. Tema Kegiatan</p>
<p>{{ $proposal->tema_kegiatan ?: '-' }}</p>

{{-- D. Tujuan Kegiatan --}}
<p class="section-title">D. Tujuan Kegiatan</p>
<p>{{ $proposal->nama_kegiatan }} memiliki tujuan sebagai berikut:</p>
@if(!empty($proposal->tujuan_kegiatan))
<ol>
    @foreach($proposal->tujuan_kegiatan as $tujuan)
        @if(trim($tujuan))
            <li>{{ $tujuan }}</li>
        @endif
    @endforeach
</ol>
@endif

{{-- E. Sasaran --}}
<p class="section-title">E. Sasaran Kegiatan</p>
<p>{!! nl2br(e($proposal->sasaran_kegiatan)) !!}</p>

{{-- F. Waktu dan Tempat --}}
<p class="section-title">F. Waktu dan Tempat</p>
<table class="no-border" style="width:auto; margin-bottom:8pt;">
    <tr>
        <td style="width:130pt; padding:1pt 0;">Hari, Tanggal</td>
        <td style="padding:1pt 0;">: {{ $proposal->tanggal_pelaksanaan }}</td>
    </tr>
    <tr>
        <td style="padding:1pt 0;">Waktu</td>
        <td style="padding:1pt 0;">:
            {{ $proposal->waktu_mulai ? \Carbon\Carbon::parse($proposal->waktu_mulai)->format('H:i') : '-' }}
            –
            {{ $proposal->waktu_selesai ? \Carbon\Carbon::parse($proposal->waktu_selesai)->format('H:i') : '-' }}
            WIB
        </td>
    </tr>
    <tr>
        <td style="padding:1pt 0;">Tempat</td>
        <td style="padding:1pt 0;">: {{ $proposal->tempat_kegiatan }}</td>
    </tr>
</table>

{{-- G. Bentuk Kegiatan --}}
<p class="section-title">G. Bentuk Kegiatan</p>
<p>{!! nl2br(e($proposal->bentuk_kegiatan)) !!}</p>

{{-- H. Materi --}}
<p class="section-title">H. Materi Kegiatan</p>
<p>Materi yang disampaikan pada kegiatan kali ini adalah:</p>
@if(!empty($proposal->materi_kegiatan))
<ol>
    @foreach($proposal->materi_kegiatan as $materi)
        @if(!empty($materi['judul']))
        <li>
            <span class="bold">{{ $materi['judul'] }}</span>
            @if(!empty($materi['deskripsi']))
                <br>{!! nl2br(e($materi['deskripsi'])) !!}
            @endif
        </li>
        @endif
    @endforeach
</ol>
@endif

{{-- I. Narasumber --}}
<p class="section-title">I. Narasumber Kegiatan</p>
<p>{!! nl2br(e($proposal->narasumber_kegiatan)) !!}</p>

{{-- J. Rundown --}}
<p class="section-title">J. Susunan Acara (Rundown)</p>
@if($proposal->rundowns->count() > 0)
<table>
    <thead>
        <tr>
            <th style="width:70pt;">Waktu Mulai</th>
            <th style="width:70pt;">Waktu Selesai</th>
            <th style="width:70pt;">Durasi (mnt)</th>
            <th>Aktivitas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proposal->rundowns as $row)
        <tr>
            <td class="text-center">{{ \Carbon\Carbon::parse($row->waktu_mulai)->format('H:i') }}</td>
            <td class="text-center">{{ \Carbon\Carbon::parse($row->waktu_selesai)->format('H:i') }}</td>
            <td class="text-center">{{ $row->durasi_menit }}</td>
            <td>{{ $row->aktivitas }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- K. Analisis Risiko --}}
<p class="section-title">K. Analisis Resiko</p>
<p style="margin-bottom:4pt;">
    Nama Kegiatan &nbsp;&nbsp;: {{ $proposal->nama_kegiatan }}<br>
    Ketua Kegiatan &nbsp;&nbsp;: {{ $proposal->ketua_pelaksana_nama }}<br>
    Dosen Pembina &nbsp;&nbsp;&nbsp;: {{ $proposal->pembina_nama }}<br>
    Lokasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $proposal->tempat_kegiatan }}<br>
    Tanggal Dibuat &nbsp;&nbsp;: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
</p>
@if($proposal->risks->count() > 0)
<table style="font-size:9pt;">
    <thead>
        <tr>
            <th style="width:4%;">No</th>
            <th style="width:13%;">Uraian Kegiatan</th>
            <th style="width:14%;">Identifikasi Bahaya</th>
            <th style="width:8%;">Peluang</th>
            <th style="width:8%;">Akibat</th>
            <th style="width:9%;">Tingkat Risiko</th>
            <th style="width:22%;">Pengendalian Risiko</th>
            <th style="width:14%;">Penanggung Jawab</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proposal->risks as $i => $risk)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $risk->uraian_kegiatan }}</td>
            <td>{{ $risk->identifikasi_bahaya }}</td>
            <td class="text-center">{{ $risk->peluang }}</td>
            <td class="text-center">{{ $risk->akibat }}</td>
            <td class="text-center">{{ $risk->tingkat_risiko }}</td>
            <td>{{ $risk->pengendalian_risiko }}</td>
            <td class="text-center">{{ $risk->penanggung_jawab }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- L. Monitoring & Evaluasi --}}
<p class="section-title">L. Monitoring dan Evaluasi</p>
<p>{!! nl2br(e($proposal->monitoring_evaluasi)) !!}</p>

{{-- M. Kepanitiaan --}}
<p class="section-title">M. Struktur Kepanitiaan</p>
@if($proposal->committees->count() > 0)
<table>
    <thead>
        <tr>
            <th>Jabatan</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th style="width:50pt;">Tahun</th>
            <th>Fakultas</th>
            <th style="width:80pt;">NIM</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proposal->committees as $member)
        <tr>
            <td>{{ $member->jabatan }}</td>
            <td>{{ $member->nama }}</td>
            <td>{{ $member->jurusan }}</td>
            <td class="text-center">{{ $member->tahun_angkatan }}</td>
            <td>{{ $member->fakultas }}</td>
            <td>{{ $member->nim }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- N. Anggaran --}}
<p class="section-title">N. Rencana Anggaran Biaya</p>

@php
    $pemasukan   = $proposal->budgets->where('jenis', 'pemasukan');
    $pengeluaran = $proposal->budgets->where('jenis', 'pengeluaran');
    $sumberDana  = $proposal->budgets->where('jenis', 'sumber_dana');
@endphp

<p class="bold">1. Pemasukan</p>
<table>
    <thead><tr><th style="width:5%;">No.</th><th>Keterangan</th><th style="width:130pt;">Total (Rp)</th></tr></thead>
    <tbody>
        @foreach($pemasukan as $i => $b)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $b->keterangan }}</td>
            <td class="currency">{{ number_format($b->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="text-right bold">Total Pemasukan</td>
            <td class="currency bold">{{ number_format($pemasukan->sum('total'), 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<p class="bold">2. Pengeluaran</p>
<table style="font-size:9.5pt;">
    <thead>
        <tr>
            <th style="width:5%;">No.</th>
            <th>Keterangan</th>
            <th style="width:50pt;">Kuantitas</th>
            <th style="width:50pt;">Satuan</th>
            <th style="width:100pt;">Harga Satuan (Rp)</th>
            <th style="width:100pt;">Total (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengeluaran as $i => $b)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $b->keterangan }}</td>
            <td class="text-center">{{ $b->kuantitas }}</td>
            <td>{{ $b->satuan }}</td>
            <td class="currency">{{ $b->harga_satuan ? number_format($b->harga_satuan, 0, ',', '.') : '-' }}</td>
            <td class="currency">{{ number_format($b->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="5" class="text-right bold">TOTAL PENGELUARAN</td>
            <td class="currency bold">{{ number_format($pengeluaran->sum('total'), 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

<p class="bold">3. Sumber Dana</p>
<table>
    <thead><tr><th style="width:5%;">No.</th><th>Keterangan</th><th style="width:130pt;">Total (Rp)</th></tr></thead>
    <tbody>
        @foreach($sumberDana as $i => $b)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $b->keterangan }}</td>
            <td class="currency">{{ number_format($b->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2" class="text-right bold">Total Sumber Dana</td>
            <td class="currency bold">{{ number_format($sumberDana->sum('total'), 0, ',', '.') }}</td>
        </tr>
    </tbody>
</table>

{{-- O. Penutup --}}
<p class="section-title">O. Penutup</p>
<p>{!! nl2br(e($proposal->penutup)) !!}</p>
