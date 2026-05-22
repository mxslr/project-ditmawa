<h2 class="text-center bold" style="margin-bottom:16pt; font-size:12pt;">LEMBAR EVALUASI PROPOSAL</h2>

<table>
    <thead>
        <tr>
            <th colspan="2">DATA KEGIATAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="width:35%;" class="bold">Nama / Tema Kegiatan</td>
            <td>{{ $proposal->nama_kegiatan }}{{ $proposal->tema_kegiatan ? ' / ' . $proposal->tema_kegiatan : '' }}</td>
        </tr>
        <tr>
            <td class="bold">Tanggal Pelaksanaan</td>
            <td>{{ $proposal->tanggal_pelaksanaan }}</td>
        </tr>
        <tr>
            <td class="bold">Pelaksana</td>
            <td>{{ $proposal->penyelenggara }}</td>
        </tr>
        <tr>
            <td class="bold">Tempat Kegiatan</td>
            <td>{{ $proposal->tempat_kegiatan }}</td>
        </tr>
        <tr>
            <td class="bold">Tanggal Evaluasi</td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>

<table style="margin-top:16pt;">
    <thead>
        <tr>
            <th colspan="2" style="width:50%;">KEPALA URUSAN</th>
            <th colspan="2" style="width:50%;">KEPALA BAGIAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" style="height:80pt; vertical-align:bottom; text-align:center;">&nbsp;</td>
            <td colspan="2" style="height:80pt; vertical-align:bottom; text-align:center;">&nbsp;</td>
        </tr>
        <tr>
            <td style="width:12%;" class="bold">Nama&nbsp;:</td>
            <td style="width:38%;"></td>
            <td style="width:12%;" class="bold">Nama&nbsp;:</td>
            <td style="width:38%;"></td>
        </tr>
        <tr>
            <td class="bold">NIP&nbsp;:</td>
            <td></td>
            <td class="bold">NIP&nbsp;:</td>
            <td></td>
        </tr>
    </tbody>
</table>
