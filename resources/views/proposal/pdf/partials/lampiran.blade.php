<p class="section-title">Q. Lampiran</p>

@foreach($proposal->lampiranAttachments as $i => $attachment)
    @if($i > 0 && $i % 2 === 0)
        <div class="page-break"></div>
    @endif
    <div style="margin-bottom: 20pt; text-align: center;">
        @if($attachment->caption)
            <p class="bold" style="margin-bottom: 6pt;">{{ $attachment->caption }}</p>
        @endif
        @if($attachment->file_type && str_starts_with($attachment->file_type, 'image/'))
            <img src="{{ storage_path('app/public/' . $attachment->file_path) }}"
                 style="max-width: 100%; max-height: 400pt; object-fit: contain;">
        @else
            <p style="color: #555;">[File: {{ basename($attachment->file_path) }}]</p>
        @endif
    </div>
@endforeach
