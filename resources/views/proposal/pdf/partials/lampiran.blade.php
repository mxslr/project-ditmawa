<p style="font-weight:bold; font-size:12pt; margin: 0 0 16pt 0;">Q. Lampiran</p>

@forelse($proposal->lampiranAttachments as $i => $attachment)

    @if($i > 0 && $i % 2 === 0)
        <div style="page-break-before: always;"></div>
    @endif

    <div style="margin-bottom: 20pt; text-align: center; page-break-inside: avoid;">
        @if($attachment->caption)
            <p style="font-weight: bold; font-size: 11pt; margin: 0 0 6pt 0;">
                {{ $attachment->caption }}
            </p>
        @else
            <p style="font-size: 11pt; margin: 0 0 6pt 0; color: #666;">
                Lampiran {{ $i + 1 }}
            </p>
        @endif

        @php
            $filePath = storage_path('app/public/' . $attachment->file_path);
            $mimeType = $attachment->file_type ?? '';
        @endphp

        @if(file_exists($filePath) && (str_starts_with($mimeType, 'image/') || preg_match('/\.(jpg|jpeg|png|gif)$/i', $attachment->file_path)))
            <img src="{{ $filePath }}"
                 style="max-width:100%; max-height:380pt; object-fit:contain; display:inline-block;">
        @else
            <p style="font-size:10pt; color:#999; font-style:italic;">
                [File: {{ basename($attachment->file_path) }}]
            </p>
        @endif
    </div>

@empty
    <p style="font-size:11pt; font-style:italic; color:#666;">Tidak ada lampiran.</p>
@endforelse
