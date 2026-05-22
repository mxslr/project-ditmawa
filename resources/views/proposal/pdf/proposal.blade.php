<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proposal - {{ $proposal->nama_kegiatan }}</title>
    <style>
        @page { margin: 2.5cm 2.5cm 2.5cm 3cm; }
        * { box-sizing: border-box; }
        body {
            font-family: "DejaVu Serif", serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #000000;
            margin: 0; padding: 0;
        }
        h1 { font-size: 14pt; font-weight: bold; text-align: center; margin: 0 0 6pt 0; }
        h2 { font-size: 12pt; font-weight: bold; margin: 0 0 4pt 0; }
        p  { text-align: justify; margin: 0 0 6pt 0; }
        .text-center { text-align: center !important; }
        .text-right  { text-align: right !important; }
        .text-left   { text-align: left !important; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 10pt; font-size: 10pt; }
        table td, table th { border: 1px solid #000; padding: 5pt 7pt; vertical-align: top; }
        table th { font-weight: bold; text-align: center; background-color: #f0f0f0; }
        .no-border td, .no-border th { border: none !important; }
        .no-border { border: none !important; }

        .page-break { page-break-after: always; }

        .section-title {
            font-size: 11pt; font-weight: bold;
            margin: 14pt 0 5pt 0;
        }

        ol { margin: 3pt 0 8pt 18pt; padding: 0; }
        ol li { margin-bottom: 3pt; text-align: justify; }

        /* Cover */
        .cover-wrapper { text-align: center; padding-top: 30pt; }
        .cover-title { font-size: 14pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5pt; margin-bottom: 8pt; }
        .cover-subtitle { font-size: 12pt; font-weight: bold; text-transform: uppercase; margin-bottom: 6pt; }
        .cover-date { font-size: 11pt; margin-bottom: 30pt; }
        .cover-logo-row { margin: 24pt 0; text-align: center; }
        .cover-logo-row img { height: 90pt; margin: 0 16pt; }
        .cover-bottom { margin-top: 60pt; text-align: center; }

        /* Signature */
        .signature-grid { width: 100%; border-collapse: collapse; }
        .signature-grid td { border: none; text-align: center; vertical-align: top; padding: 0 8pt; }
        .signature-box { display: block; height: 80pt; }
        .signature-name { font-weight: bold; margin-top: 3pt; }

        /* Budget */
        .currency { text-align: right; }
    </style>
</head>
<body>

    @include('proposal.pdf.partials.cover')
    <div class="page-break"></div>

    @include('proposal.pdf.partials.lembar-evaluasi')
    <div class="page-break"></div>

    @include('proposal.pdf.partials.form-kontrol')
    <div class="page-break"></div>

    @include('proposal.pdf.partials.rekap')
    <div class="page-break"></div>

    @include('proposal.pdf.partials.daftar-isi')
    <div class="page-break"></div>

    @include('proposal.pdf.partials.isi')

    <div class="page-break"></div>
    @include('proposal.pdf.partials.lembar-pengesahan')

    @if($proposal->lampiranAttachments->count() > 0)
        <div class="page-break"></div>
        @include('proposal.pdf.partials.lampiran')
    @endif

</body>
</html>
