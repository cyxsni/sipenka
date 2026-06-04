<?php

namespace App\Services;

use App\Models\SuratKeluar;

class NomorSuratService
{
    const BATAS_PER_TANGGAL = 50;
    const EPOCH_DATE = '2026-04-01';

    /**
     * Generate nomor surat berdasarkan jenis.
     *
     * @param string $tanggal
     * @param string $jenis  'surat_keluar' atau 'surat_keputusan'
     * @return string
     */
    public function generateNomorBerikutnya($tanggal, $jenis = 'surat_keluar'): string
    {
        if ($jenis === 'surat_keputusan') {
            return $this->generateNomorSK();
        }
        return $this->generateNomorKeluar($tanggal);
    }

    /**
     * Preview nomor surat berdasarkan jenis.
     */
    public function previewNomor($tanggal, $jenis = 'surat_keluar'): string
    {
        if ($jenis === 'surat_keputusan') {
            return $this->previewNomorSK();
        }
        return $this->previewNomorKeluar($tanggal);
    }

    // ==================== SURAT KELUAR BIASA ====================

    private function generateNomorKeluar($tanggal): string
    {
        $epoch = strtotime(self::EPOCH_DATE);
        $tgl   = strtotime($tanggal);
        $selisihHari = (int)(($tgl - $epoch) / 86400);
        if ($selisihHari < 0) {
            throw new \Exception('Tanggal surat tidak boleh sebelum ' . self::EPOCH_DATE);
        }
        $baseNomor = $selisihHari * self::BATAS_PER_TANGGAL + 1;

        $approvedTanggalIni = SuratKeluar::whereDate('tanggal_surat', $tanggal)
            ->where('status', 'approved')
            ->where('jenis_surat', 'surat_keluar')
            ->whereNotNull('nomor_surat')
            ->orderBy('updated_at', 'asc')
            ->get();

        $urutanApprove = $approvedTanggalIni->count() + 1;

        if ($urutanApprove <= self::BATAS_PER_TANGGAL) {
            return (string)($baseNomor + $urutanApprove - 1);
        }

        // Sub-nomor
        $subIndex   = (int)(($urutanApprove - 1) / self::BATAS_PER_TANGGAL);
        $dasarIndex = ($urutanApprove - 1) % self::BATAS_PER_TANGGAL + 1;
        $nomorBaru  = ($baseNomor + $dasarIndex - 1) . '.' . $subIndex;

        if ($subIndex > 10) {
            throw new \Exception('Kuota sub-nomor maksimal .10 sudah tercapai.');
        }
        return $nomorBaru;
    }

    private function previewNomorKeluar($tanggal): string
    {
        $epoch = strtotime(self::EPOCH_DATE);
        $tgl   = strtotime($tanggal);
        $selisihHari = (int)(($tgl - $epoch) / 86400);
        if ($selisihHari < 0) return 'N/A';

        $baseNomor = $selisihHari * self::BATAS_PER_TANGGAL + 1;
        $totalApproved = SuratKeluar::whereDate('tanggal_surat', $tanggal)
            ->where('status', 'approved')
            ->where('jenis_surat', 'surat_keluar')
            ->count();
        $urutan = $totalApproved + 1;

        if ($urutan <= self::BATAS_PER_TANGGAL) {
            return (string)($baseNomor + $urutan - 1);
        }
        $subIndex   = (int)(($urutan - 1) / self::BATAS_PER_TANGGAL);
        $dasarIndex = ($urutan - 1) % self::BATAS_PER_TANGGAL + 1;
        return ($baseNomor + $dasarIndex - 1) . '.' . $subIndex;
    }

    // ==================== SURAT KEPUTUSAN (SK) ====================

    private function generateNomorSK(): string
    {
        $lastSK = SuratKeluar::where('jenis_surat', 'surat_keputusan')
                    ->whereNotNull('nomor_surat')
                    ->orderByRaw('CAST(nomor_surat AS UNSIGNED) DESC')
                    ->first();

        return $lastSK ? (string) ((int) $lastSK->nomor_surat + 1) : '1';
    }

    private function previewNomorSK(): string
    {
        $lastSK = SuratKeluar::where('jenis_surat', 'surat_keputusan')
                    ->whereNotNull('nomor_surat')
                    ->orderByRaw('CAST(nomor_surat AS UNSIGNED) DESC')
                    ->first();

        return $lastSK ? (string) ((int) $lastSK->nomor_surat + 1) : '1';
    }
}