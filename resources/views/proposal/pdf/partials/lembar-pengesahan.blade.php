<p class="section-title">P. Lembar Pengesahan</p>

{{-- Baris 1: 3 kolom --}}
<table class="signature-grid no-border" style="margin-top:16pt; width:100%;">
    <tbody>
        <tr>
            <td class="text-center" style="width:33.33%;">President {{ $proposal->penyelenggara ?? 'UKM' }}</td>
            <td class="text-center" style="width:33.33%;">Sekretaris</td>
            <td class="text-center" style="width:33.33%;">Ketua Pelaksana</td>
        </tr>
        <tr>
            <td><span class="signature-box"></span></td>
            <td><span class="signature-box"></span></td>
            <td><span class="signature-box"></span></td>
        </tr>
        <tr>
            <td class="text-center">
                <span class="signature-name bold">{{ $proposal->president_ukm_nama }}</span><br>
                NIM. {{ $proposal->president_ukm_nim }}
            </td>
            <td class="text-center">
                <span class="signature-name bold">{{ $proposal->sekretaris_nama }}</span><br>
                NIM. {{ $proposal->sekretaris_nim }}
            </td>
            <td class="text-center">
                <span class="signature-name bold">{{ $proposal->ketua_pelaksana_nama }}</span><br>
                NIM. {{ $proposal->ketua_pelaksana_nim }}
            </td>
        </tr>
    </tbody>
</table>

{{-- Pembina --}}
<table class="signature-grid no-border" style="margin-top:16pt; width:100%;">
    <tbody>
        <tr>
            <td style="width:33.33%;"></td>
            <td class="text-center" style="width:33.33%;">Pembina</td>
            <td style="width:33.33%;"></td>
        </tr>
        <tr>
            <td></td>
            <td><span class="signature-box"></span></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">
                <span class="signature-name bold">{{ $proposal->pembina_nama }}</span><br>
                NIP. {{ $proposal->pembina_nip }}
            </td>
            <td></td>
        </tr>
    </tbody>
</table>

{{-- Direktur --}}
<table class="signature-grid no-border" style="margin-top:12pt; width:100%;">
    <tbody>
        <tr>
            <td style="width:33.33%;"></td>
            <td class="text-center" style="width:33.33%;">
                Menyetujui,<br>
                Direktur Kemahasiswaan, Karier dan Alumni
            </td>
            <td style="width:33.33%;"></td>
        </tr>
        <tr>
            <td></td>
            <td><span class="signature-box"></span></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center">
                <span class="signature-name bold">{{ $proposal->direktur_nama }}</span><br>
                NIP. {{ $proposal->direktur_nip }}
            </td>
            <td></td>
        </tr>
    </tbody>
</table>
