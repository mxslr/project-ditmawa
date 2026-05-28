<p style="font-weight:bold; font-size:12pt; margin: 16pt 0 10pt 0;">P. Lembar Pengesahan</p>

<div style="page-break-inside: avoid;">
<table style="width:100%; border:none; border-collapse: collapse;">

    {{-- Label jabatan --}}
    <tr>
        <td style="border:none; text-align:center; width:33%; font-size:10.5pt; padding:0 4pt 3pt 4pt;">
            President {{ $proposal->penyelenggara ?? 'UKM' }}
        </td>
        <td style="border:none; text-align:center; width:33%; font-size:10.5pt; padding:0 4pt 3pt 4pt;">
            Sekretaris {{ $proposal->penyelenggara ?? 'UKM' }}
        </td>
        <td style="border:none; text-align:center; width:33%; font-size:10.5pt; padding:0 4pt 3pt 4pt;">
            Ketua Pelaksana
        </td>
    </tr>
    {{-- Ruang TTD --}}
    <tr>
        <td style="border:none; height:55pt;">&nbsp;</td>
        <td style="border:none; height:55pt;">&nbsp;</td>
        <td style="border:none; height:55pt;">&nbsp;</td>
    </tr>
    {{-- Nama & NIM --}}
    <tr>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt;">
            <strong>{{ $proposal->president_ukm_nama }}</strong><br>
            NIM. {{ $proposal->president_ukm_nim }}
        </td>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt;">
            <strong>{{ $proposal->sekretaris_nama }}</strong><br>
            NIM. {{ $proposal->sekretaris_nim }}
        </td>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt;">
            <strong>{{ $proposal->ketua_pelaksana_nama }}</strong><br>
            NIM. {{ $proposal->ketua_pelaksana_nim }}
        </td>
    </tr>

    {{-- Spacer --}}
    <tr><td colspan="3" style="border:none; height:8pt;"></td></tr>

    {{-- Pembina --}}
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt 3pt 4pt;">Pembina</td>
        <td style="border:none;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none; height:55pt;">&nbsp;</td>
        <td style="border:none;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt;">
            <strong>{{ $proposal->pembina_nama }}</strong><br>
            NIP. {{ $proposal->pembina_nip }}
        </td>
        <td style="border:none;">&nbsp;</td>
    </tr>

    {{-- Spacer --}}
    <tr><td colspan="3" style="border:none; height:8pt;"></td></tr>

    {{-- Direktur --}}
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt 3pt 4pt;">
            Menyetujui,<br>Direktur Kemahasiswaan, Karier dan Alumni
        </td>
        <td style="border:none;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none; height:55pt;">&nbsp;</td>
        <td style="border:none;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border:none;">&nbsp;</td>
        <td style="border:none; text-align:center; font-size:10.5pt; padding:0 4pt;">
            <strong>{{ $proposal->direktur_nama }}</strong><br>
            NIP. {{ $proposal->direktur_nip }}
        </td>
        <td style="border:none;">&nbsp;</td>
    </tr>

</table>
</div>
