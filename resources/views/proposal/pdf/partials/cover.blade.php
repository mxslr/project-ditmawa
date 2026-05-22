<div class="cover-wrapper">
    <p class="cover-title">PROPOSAL KEGIATAN</p>
    <p class="cover-subtitle">{{ strtoupper($proposal->nama_kegiatan) }}</p>
    <p class="cover-date">{{ $proposal->tanggal_pelaksanaan }}</p>

    <div class="cover-logo-row">
        <img src="{{ public_path('img/logo-telkom.png') }}" alt="Telkom University">
        @if($proposal->logo_organisasi_path)
            <img src="{{ storage_path('app/public/' . $proposal->logo_organisasi_path) }}" alt="Logo Organisasi">
        @endif
    </div>

    <div class="cover-bottom">
        <p class="bold">{{ strtoupper($proposal->kota ?: 'BANDUNG') }}</p>
        <p class="bold">{{ $proposal->tahun }}</p>
    </div>
</div>
