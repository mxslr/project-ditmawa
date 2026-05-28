<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProposalStoreRequest;
use App\Models\Proposal;
use App\Models\ProposalRundown;
use App\Models\ProposalRisk;
use App\Models\ProposalCommittee;
use App\Models\ProposalBudget;
use App\Models\ProposalAttachment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class ProposalController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $proposals = Proposal::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('proposal.index', compact('proposals'));
    }

    public function create()
    {
        return view('proposal.create');
    }

    public function store(ProposalStoreRequest $request): RedirectResponse
    {
        // Handle logo organisasi upload
        $logoPath = null;
        if ($request->hasFile('logo_organisasi')) {
            $logoPath = $request->file('logo_organisasi')->store('proposal-logos', 'public');
        }

        // Build tujuan_kegiatan array (filter empty entries)
        $tujuan = array_values(array_filter($request->input('tujuan_kegiatan', []), fn($v) => trim($v) !== ''));

        // Build materi_kegiatan array (filter empty)
        $materi = array_values(array_filter($request->input('materi_kegiatan', []), function ($m) {
            return isset($m['judul']) && trim($m['judul']) !== '';
        }));

        // Create proposal
        $proposal = Proposal::create([
            'user_id'              => auth()->id(),
            'nama_kegiatan'        => $request->nama_kegiatan,
            'tema_kegiatan'        => $request->tema_kegiatan,
            'penyelenggara'        => $request->penyelenggara,
            'afiliasi'             => $request->afiliasi,
            'tanggal_mulai'        => $request->tanggal_mulai,
            'tanggal_selesai'      => $request->tanggal_selesai,
            'waktu_mulai'          => $request->waktu_mulai ?: null,
            'waktu_selesai'        => $request->waktu_selesai ?: null,
            'tempat_kegiatan'      => $request->tempat_kegiatan,
            'kota'                 => $request->kota ?: 'BANDUNG',
            'tahun'                => $request->tahun,
            'latar_belakang'       => $request->latar_belakang,
            'tujuan_kegiatan'      => $tujuan,
            'sasaran_kegiatan'     => $request->sasaran_kegiatan,
            'bentuk_kegiatan'      => $request->bentuk_kegiatan,
            'materi_kegiatan'      => $materi,
            'narasumber_kegiatan'  => $request->narasumber_kegiatan,
            'monitoring_evaluasi'  => $request->monitoring_evaluasi,
            'penutup'              => $request->penutup,
            'president_ukm_nama'   => $request->president_ukm_nama,
            'president_ukm_nim'    => $request->president_ukm_nim,
            'sekretaris_nama'      => $request->sekretaris_nama,
            'sekretaris_nim'       => $request->sekretaris_nim,
            'ketua_pelaksana_nama' => $request->ketua_pelaksana_nama,
            'ketua_pelaksana_nim'  => $request->ketua_pelaksana_nim,
            'pembina_nama'         => $request->pembina_nama,
            'pembina_nip'          => $request->pembina_nip,
            'direktur_nama'        => $request->direktur_nama ?: 'Dr. Maulana Rezi Ramadhana, S.Psi., M.Psi., Psikolog',
            'direktur_nip'         => $request->direktur_nip ?: '20820005',
            'logo_organisasi_path' => $logoPath,
            'status'               => 'draft',
        ]);

        // Rundowns
        foreach ($request->input('rundowns', []) as $i => $row) {
            if (empty($row['aktivitas'])) continue;
            ProposalRundown::create([
                'proposal_id'  => $proposal->id,
                'urutan'       => $i,
                'waktu_mulai'  => $row['waktu_mulai'] ?? '00:00',
                'waktu_selesai'=> $row['waktu_selesai'] ?? '00:00',
                'durasi_menit' => (int) ($row['durasi_menit'] ?? 0),
                'aktivitas'    => $row['aktivitas'],
            ]);
        }

        // Risks
        foreach ($request->input('risks', []) as $i => $row) {
            if (empty($row['uraian_kegiatan'])) continue;

            // Hitung ulang tingkat risiko di server (jangan percaya nilai dari client):
            // round(identifikasi × peluang ÷ 5), lalu clamp ke skala 1–5 → format "X/5".
            $idNum = (int) explode('/', $row['identifikasi_bahaya'] ?? '1/5')[0];
            $plNum = (int) explode('/', $row['peluang'] ?? '1/5')[0];
            $idNum = max(1, min(5, $idNum));
            $plNum = max(1, min(5, $plNum));
            $tingkat = max(1, min(5, (int) round(($idNum * $plNum) / 5)));

            ProposalRisk::create([
                'proposal_id'         => $proposal->id,
                'urutan'              => $i,
                'uraian_kegiatan'     => $row['uraian_kegiatan'],
                'identifikasi_bahaya' => $row['identifikasi_bahaya'] ?? '1/5',
                'peluang'             => $row['peluang'] ?? '1/5',
                'akibat'              => $row['akibat'] ?? null,
                'tingkat_risiko'      => $tingkat . '/5',
                'pengendalian_risiko' => $row['pengendalian_risiko'] ?? null,
                'penanggung_jawab'    => $row['penanggung_jawab'] ?? null,
            ]);
        }

        // Committees
        foreach ($request->input('committees', []) as $i => $row) {
            if (empty($row['nama'])) continue;
            ProposalCommittee::create([
                'proposal_id'    => $proposal->id,
                'urutan'         => $i,
                'jabatan'        => $row['jabatan'] ?? '',
                'nama'           => $row['nama'],
                'jurusan'        => $row['jurusan'] ?? null,
                'tahun_angkatan' => $row['tahun_angkatan'] ?? null,
                'fakultas'       => $row['fakultas'] ?? null,
                'nim'            => $row['nim'] ?? null,
            ]);
        }

        // Budgets: pemasukan
        foreach ($request->input('budgets_pemasukan', []) as $i => $row) {
            if (empty($row['keterangan'])) continue;
            ProposalBudget::create([
                'proposal_id' => $proposal->id,
                'jenis'       => 'pemasukan',
                'keterangan'  => $row['keterangan'],
                'total'       => (float) ($row['total'] ?? 0),
                'urutan'      => $i,
            ]);
        }

        // Budgets: pengeluaran
        $totalPengeluaran = 0;
        foreach ($request->input('budgets_pengeluaran', []) as $i => $row) {
            if (empty($row['keterangan'])) continue;
            $qty       = (int) ($row['kuantitas'] ?? 0);
            $harga     = (float) ($row['harga_satuan'] ?? 0);
            $total     = $qty > 0 && $harga > 0 ? $qty * $harga : (float) ($row['total'] ?? 0);
            $totalPengeluaran += $total;
            ProposalBudget::create([
                'proposal_id' => $proposal->id,
                'jenis'       => 'pengeluaran',
                'keterangan'  => $row['keterangan'],
                'kuantitas'   => $qty ?: null,
                'satuan'      => $row['satuan'] ?? null,
                'harga_satuan'=> $harga ?: null,
                'total'       => $total,
                'urutan'      => $i,
            ]);
        }

        // Budgets: sumber dana
        foreach ($request->input('budgets_sumber_dana', []) as $i => $row) {
            if (empty($row['keterangan'])) continue;
            ProposalBudget::create([
                'proposal_id' => $proposal->id,
                'jenis'       => 'sumber_dana',
                'keterangan'  => $row['keterangan'],
                'total'       => (float) ($row['total'] ?? 0),
                'urutan'      => $i,
            ]);
        }

        // Lampiran uploads
        $captions = $request->input('lampiran_captions', []);
        if ($request->hasFile('lampirans')) {
            $storageDir = 'proposal-attachments/' . $proposal->id;
            foreach ($request->file('lampirans') as $i => $file) {
                $path = $file->store($storageDir, 'public');
                ProposalAttachment::create([
                    'proposal_id' => $proposal->id,
                    'jenis'       => 'lampiran',
                    'caption'     => $captions[$i] ?? null,
                    'file_path'   => $path,
                    'file_type'   => $file->getMimeType(),
                    'urutan'      => $i,
                ]);
            }
        }

        // Update total anggaran
        $proposal->update(['total_anggaran' => $totalPengeluaran]);

        return redirect()->route('proposal.show', $proposal)
            ->with('success', 'Proposal berhasil disimpan!');
    }

    public function show(Proposal $proposal)
    {
        $this->authorize('view', $proposal);
        $proposal->load(['rundowns', 'risks', 'committees', 'budgets', 'attachments']);

        return view('proposal.show', compact('proposal'));
    }

    public function generatePdf(Proposal $proposal)
    {
        $this->authorize('view', $proposal);
        $proposal->load(['rundowns', 'risks', 'committees', 'budgets', 'lampiranAttachments']);

        $pdf = Pdf::loadView('proposal.pdf.proposal', compact('proposal'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled'      => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled'         => true,
                'defaultFont'          => 'dejavu serif',
                'dpi'                  => 96,
                'chroot'               => base_path(),
            ]);

        $proposal->update(['status' => 'generated', 'generated_at' => now()]);

        $filename = 'Proposal Kegiatan - ' . $proposal->nama_kegiatan . '.pdf';

        return $pdf->download($filename);
    }

    public function destroy(Proposal $proposal): RedirectResponse
    {
        $this->authorize('delete', $proposal);

        if ($proposal->logo_organisasi_path) {
            Storage::disk('public')->delete($proposal->logo_organisasi_path);
        }

        foreach ($proposal->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
        }

        $proposal->delete();

        return redirect()->route('proposal.index')
            ->with('success', 'Proposal berhasil dihapus.');
    }
}
