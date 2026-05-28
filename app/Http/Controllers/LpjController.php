<?php

namespace App\Http\Controllers;

use App\Http\Requests\LpjStoreRequest;
use App\Models\Lpj;
use App\Models\LpjRundown;
use App\Models\LpjRisk;
use App\Models\LpjCommittee;
use App\Models\LpjBudget;
use App\Models\LpjAttachment;
use App\Models\LpjDanaKeluarDivision;
use App\Models\LpjDanaKeluarCategory;
use App\Models\LpjDanaKeluarSubitem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LpjController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $lpjs = Lpj::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('lpj.index', compact('lpjs'));
    }

    public function create()
    {
        return view('lpj.create');
    }

    public function store(LpjStoreRequest $request): RedirectResponse
    {
        $lpj = DB::transaction(function () use ($request) {
            $tujuan = array_values(array_filter(
                $request->input('tujuan_kegiatan', []),
                fn($v) => trim($v) !== ''
            ));

            $lpj = Lpj::create([
                'user_id'               => auth()->id(),
                'nama_kegiatan'         => $request->nama_kegiatan,
                'akronim'               => $request->akronim,
                'tema_kegiatan'         => $request->tema_kegiatan,
                'tanggal_mulai'         => $request->tanggal_mulai,
                'tanggal_selesai'       => $request->tanggal_selesai,
                'waktu_mulai'           => $request->waktu_mulai ?: null,
                'waktu_selesai'         => $request->waktu_selesai ?: null,
                'tempat_kegiatan'       => $request->tempat_kegiatan,
                'kota'                  => $request->kota ?: 'BANDUNG',
                'tahun'                 => $request->tahun,
                'penyelenggara'         => $request->penyelenggara,
                'afiliasi'              => $request->afiliasi,
                'latar_belakang'        => $request->latar_belakang,
                'tujuan_kegiatan'       => $tujuan,
                'sasaran_kegiatan'      => $request->sasaran_kegiatan,
                'bentuk_kegiatan'       => $request->bentuk_kegiatan,
                'deskripsi_pelaksanaan' => $request->deskripsi_pelaksanaan,
                'simpulan_rekomendasi'  => $request->simpulan_rekomendasi,
                'penutup'               => $request->penutup,
                'ketua_pelaksana_nama'  => $request->ketua_pelaksana_nama,
                'ketua_pelaksana_nim'   => $request->ketua_pelaksana_nim,
                'ketua_ukm_nama'        => $request->ketua_ukm_nama,
                'ketua_ukm_nim'         => $request->ketua_ukm_nim,
                'pembina_1_nama'        => $request->pembina_1_nama,
                'pembina_1_nip'         => $request->pembina_1_nip,
                'pembina_2_nama'        => $request->pembina_2_nama,
                'pembina_2_nip'         => $request->pembina_2_nip,
                'direktur_nama'         => $request->direktur_nama ?: 'Dr. Maulana Rezi Ramadhana, S.Psi., M.Psi., Psikolog',
                'direktur_nip'          => $request->direktur_nip ?: '20820005',
                'status'                => 'draft',
            ]);

            // Logo organisasi
            if ($request->hasFile('logo_organisasi')) {
                $path = $request->file('logo_organisasi')->store('lpj-logos', 'public');
                LpjAttachment::create([
                    'lpj_id'    => $lpj->id,
                    'jenis'     => 'cover_logo',
                    'file_path' => $path,
                    'file_type' => $request->file('logo_organisasi')->getMimeType(),
                    'urutan'    => 0,
                ]);
                $lpj->update(['logo_organisasi_path' => $path]);
            }

            // Rundown
            foreach ($request->input('rundowns', []) as $i => $row) {
                if (empty($row['detail_kegiatan'])) continue;
                LpjRundown::create([
                    'lpj_id'          => $lpj->id,
                    'urutan'          => $i,
                    'waktu_mulai'     => $row['waktu_mulai'] ?? '',
                    'waktu_selesai'   => $row['waktu_selesai'] ?? '',
                    'durasi'          => $row['durasi'] ?? '',
                    'detail_kegiatan' => $row['detail_kegiatan'],
                    'pic'             => $row['pic'] ?? '',
                ]);
            }

            // Risiko
            foreach ($request->input('risks', []) as $i => $row) {
                if (empty($row['uraian_kegiatan'])) continue;
                LpjRisk::create([
                    'lpj_id'               => $lpj->id,
                    'urutan'               => $i,
                    'uraian_kegiatan'      => $row['uraian_kegiatan'],
                    'identifikasi_bahaya'  => $row['identifikasi_bahaya'] ?? '',
                    'peluang'              => $row['peluang'] ?? '',
                    'akibat'               => $row['akibat'] ?? '',
                    'tingkat_risiko'       => $row['tingkat_risiko'] ?? '',
                    'pengendalian_risiko'  => $row['pengendalian_risiko'] ?? '',
                    'penanggung_jawab'     => $row['penanggung_jawab'] ?? '',
                ]);
            }

            // Monitoring dan Evaluasi (grup tanggal/fase -> banyak detail kegiatan)
            $this->simpanMonitoringGroups($lpj, $request->input('monitoring_groups', []));

            // Kepanitiaan
            foreach ($request->input('committees', []) as $i => $row) {
                if (empty($row['nama'])) continue;
                LpjCommittee::create([
                    'lpj_id'   => $lpj->id,
                    'urutan'   => $i,
                    'jabatan'  => $row['jabatan'] ?? '',
                    'nama'     => $row['nama'],
                    'nim'      => $row['nim'] ?? '',
                    'jurusan'  => $row['jurusan'] ?? '',
                    'fakultas' => $row['fakultas'] ?? '',
                    'angkatan' => $row['angkatan'] ?? '',
                ]);
            }

            // Anggaran: Dana Masuk
            foreach ($request->input('dana_masuk', []) as $i => $row) {
                if (empty($row['sumber_dana'])) continue;
                LpjBudget::create([
                    'lpj_id'       => $lpj->id,
                    'jenis'        => 'dana_masuk',
                    'urutan'       => $i,
                    'sumber_dana'  => $row['sumber_dana'],
                    'target'       => (float) ($row['target'] ?? 0),
                    'jumlah_total' => (float) ($row['jumlah_total'] ?? 0),
                ]);
            }

            // Anggaran: Dana Keluar (3-level hierarchy via JSON)
            if ($request->filled('dana_keluar_json')) {
                $this->simpanDanaKeluar($lpj, $request->input('dana_keluar_json'));
            }

            // Lampiran: multi-file per section (Alpine.js structure: lampiran[sIdx][files][fIdx][file])
            $allowedJenis = ['nota', 'bukti_transfer', 'dokumentasi', 'poster'];
            foreach ($request->file('lampiran', []) as $sIdx => $section) {
                $jenis = $request->input("lampiran.{$sIdx}.jenis", 'lampiran');
                if (!in_array($jenis, $allowedJenis)) continue;
                $files = $section['files'] ?? [];
                foreach ($files as $fIdx => $fileData) {
                    $file = $fileData['file'] ?? null;
                    if (!$file || !$file->isValid()) continue;
                    $path    = $file->store("lpj-attachments/{$lpj->id}/{$jenis}", 'public');
                    $caption = $request->input("lampiran.{$sIdx}.files.{$fIdx}.caption");
                    LpjAttachment::create([
                        'lpj_id'    => $lpj->id,
                        'jenis'     => $jenis,
                        'caption'   => $caption ?: null,
                        'file_path' => $path,
                        'file_type' => $file->getMimeType(),
                        'urutan'    => $sIdx * 100 + $fIdx + 1,
                    ]);
                }
            }

            return $lpj;
        });

        return redirect()->route('lpj.show', $lpj)
            ->with('success', 'LPJ berhasil disimpan!');
    }

    public function show(Lpj $lpj)
    {
        $this->authorize('view', $lpj);
        $lpj->load(['rundowns', 'risks', 'monitoringGroups.items', 'committees', 'budgets', 'attachments']);

        return view('lpj.show', compact('lpj'));
    }

    public function generatePdf(Lpj $lpj)
    {
        $this->authorize('view', $lpj);
        $lpj->load(['rundowns', 'risks', 'monitoringGroups.items', 'committees', 'budgets', 'attachments', 'danaKeluarDivisions.categories.subitems']);

        $pdf = Pdf::loadView('lpj.pdf.lpj', compact('lpj'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled'      => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled'         => true,
                'defaultFont'          => 'dejavu serif',
                'dpi'                  => 96,
                'chroot'               => base_path(),
            ]);

        $lpj->update(['status' => 'generated', 'generated_at' => now()]);

        $filename = 'LPJ - ' . $lpj->nama_kegiatan . '.pdf';

        return $pdf->download($filename);
    }

    public function saveDanaKeluar(Request $request, Lpj $lpj): RedirectResponse
    {
        $this->authorize('update', $lpj);

        $request->validate(['dana_keluar_json' => 'required|string']);

        $this->simpanDanaKeluar($lpj, $request->input('dana_keluar_json'));

        return back()->with('success', 'Dana keluar berhasil disimpan.');
    }

    /**
     * Simpan section K. Monitoring dan Evaluasi.
     * Struktur: setiap grup (tanggal + fase) memiliki banyak item detail kegiatan.
     * Input: monitoring_groups[gIdx][tanggal|fase][items][iIdx][detail_kegiatan|pic|keterangan]
     */
    private function simpanMonitoringGroups(Lpj $lpj, array $groups): void
    {
        $lpj->monitoringGroups()->delete();

        foreach (array_values($groups) as $gIdx => $groupData) {
            $items = array_values(array_filter(
                $groupData['items'] ?? [],
                fn ($item) => trim($item['detail_kegiatan'] ?? '') !== ''
            ));

            // Lewati grup tanpa tanggal/fase maupun item berisi.
            if ($items === []
                && trim($groupData['tanggal'] ?? '') === ''
                && trim($groupData['fase'] ?? '') === '') {
                continue;
            }

            $group = $lpj->monitoringGroups()->create([
                'urutan'  => $gIdx,
                'tanggal' => ($groupData['tanggal'] ?? '') ?: null,
                'fase'    => ($groupData['fase'] ?? '') ?: null,
            ]);

            foreach ($items as $iIdx => $item) {
                $group->items()->create([
                    'urutan'          => $iIdx,
                    'detail_kegiatan' => $item['detail_kegiatan'],
                    'pic'             => $item['pic'] ?? '',
                    'keterangan'      => $item['keterangan'] ?? '',
                ]);
            }
        }
    }

    private function simpanDanaKeluar(Lpj $lpj, string $danaKeluarJson): void
    {
        $lpj->danaKeluarDivisions()->delete();

        $data = json_decode($danaKeluarJson, true);
        if (!$data || !is_array($data)) return;

        foreach ($data as $dIdx => $divisiData) {
            if (empty(trim($divisiData['nama_divisi'] ?? ''))) continue;

            $divisi = $lpj->danaKeluarDivisions()->create([
                'nama_divisi' => trim($divisiData['nama_divisi']),
                'urutan'      => $dIdx,
            ]);

            foreach ($divisiData['categories'] ?? [] as $kIdx => $katData) {
                if (empty(trim($katData['nama_kategori'] ?? ''))) continue;

                $kategori = $divisi->categories()->create([
                    'nama_kategori' => trim($katData['nama_kategori']),
                    'nomor'         => $kIdx + 1,
                    'urutan'        => $kIdx,
                ]);

                foreach ($katData['subitems'] ?? [] as $sIdx => $subData) {
                    if (empty(trim($subData['rincian_kebutuhan'] ?? ''))) continue;

                    $kategori->subitems()->create([
                        'rincian_kebutuhan' => trim($subData['rincian_kebutuhan']),
                        'jumlah'            => (float) ($subData['jumlah'] ?? 0),
                        'satuan'            => trim($subData['satuan'] ?? ''),
                        'harga_satuan'      => (float) ($subData['harga_satuan'] ?? 0),
                        'urutan'            => $sIdx,
                    ]);
                }
            }
        }
    }

    public function destroy(Lpj $lpj): RedirectResponse
    {
        $this->authorize('delete', $lpj);

        if ($lpj->logo_organisasi_path) {
            Storage::disk('public')->delete($lpj->logo_organisasi_path);
        }

        foreach ($lpj->attachments as $att) {
            Storage::disk('public')->delete($att->file_path);
        }

        $lpj->delete();

        return redirect()->route('lpj.index')
            ->with('success', 'LPJ berhasil dihapus.');
    }
}
