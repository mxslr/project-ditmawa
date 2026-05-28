@php
    $grouped = $lpj->attachments
        ->where('jenis', '!=', 'cover_logo')
        ->sortBy('urutan')
        ->groupBy('jenis');

    $sectionLabels = [
        'nota'           => 'Nota Pembelian',
        'bukti_transfer' => 'Bukti Transfer / Pembayaran',
        'dokumentasi'    => 'Dokumentasi Kegiatan',
        'poster'         => 'Poster / Flyer Kegiatan',
    ];

    $lampiranCounter = 0;
@endphp

<p style="font-weight:bold; font-size:12pt; margin: 0 0 16pt 0;">Q. Lampiran</p>

@forelse($grouped as $jenis => $files)
    @php
        $lampiranCounter++;
        $label = $sectionLabels[$jenis] ?? ucfirst(str_replace('_', ' ', $jenis));
        $isMultiple = $files->count() > 1;
    @endphp

    {{-- Judul section muncul sekali --}}
    <p style="font-size:11pt; font-weight:bold; margin-top:14pt; margin-bottom:8pt;">
        Lampiran {{ $lampiranCounter }}. {{ $label }}
    </p>

    @foreach($files as $fIdx => $attachment)
        @php
            $filePath = storage_path('app/public/' . $attachment->file_path);
            $subLabel = $isMultiple ? chr(97 + $fIdx) . '. ' : '';
        @endphp

        @if(file_exists($filePath))
            <div style="margin-bottom:14pt; text-align:center; page-break-inside:avoid;">
                @if($attachment->caption || $isMultiple)
                    <p style="font-size:10pt; margin:0 0 4pt 0; text-align:left;">
                        {{ $subLabel }}{{ $attachment->caption ?? '' }}
                    </p>
                @endif
                <img
                    src="{{ $filePath }}"
                    style="max-width:420pt; max-height:300pt; display:inline-block; object-fit:contain;"
                    alt="{{ $attachment->caption ?? $label }}">
            </div>
        @endif
    @endforeach

@empty
    <p style="font-size:11pt; font-style:italic; color:#666;">Tidak ada lampiran.</p>
@endforelse
