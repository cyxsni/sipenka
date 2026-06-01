<?php

namespace App\Services;

use App\Models\SuratKeluar;

class NomorSuratService
{
    const BATAS_PER_TANGGAL = 50;
    const EPOCH_DATE = '2026-04-01';

    public function generateNomorBerikutnya($tanggal): string
    {
        // 1. Hitung base nomor
        $epoch = strtotime(self::EPOCH_DATE);
        $tgl   = strtotime($tanggal);

        $selisihHari = (int)(($tgl - $epoch) / 86400);

        if ($selisihHari < 0) {
            throw new \Exception(
                'Tanggal surat tidak boleh sebelum ' . self::EPOCH_DATE
            );
        }

        $baseNomor = $selisihHari * self::BATAS_PER_TANGGAL + 1;

        // 2. Ambil surat approved
        $approvedTanggalIni = SuratKeluar::whereDate('tanggal_surat', $tanggal)
            ->where('status', 'approved')
            ->whereNotNull('nomor_surat')
            ->orderBy('updated_at', 'asc')
            ->get();

        $urutanApprove = $approvedTanggalIni->count() + 1;

        // 3. Generate nomor
        if ($urutanApprove <= self::BATAS_PER_TANGGAL) {

            $nomorBaru = (string)($baseNomor + $urutanApprove - 1);

        } else {

            $subIndex = (int)(($urutanApprove - 1) / self::BATAS_PER_TANGGAL);

            $dasarIndex = ($urutanApprove - 1)
                % self::BATAS_PER_TANGGAL + 1;

            $nomorBaru = ($baseNomor + $dasarIndex - 1)
                . '.' . $subIndex;

            if ($subIndex > 10) {
                throw new \Exception(
                    'Kuota sub-nomor maksimal .10 sudah tercapai.'
                );
            }
        }

        return $nomorBaru;
    }

    public function previewNomor($tanggal): string
    {
        $epoch = strtotime(self::EPOCH_DATE);
        $tgl   = strtotime($tanggal);

        $selisihHari = (int)(($tgl - $epoch) / 86400);

        if ($selisihHari < 0) {
            return 'N/A';
        }

        $baseNomor = $selisihHari * self::BATAS_PER_TANGGAL + 1;

        $totalApproved = SuratKeluar::whereDate('tanggal_surat', $tanggal)
            ->where('status', 'approved')
            ->count();

        $urutan = $totalApproved + 1;

        if ($urutan <= self::BATAS_PER_TANGGAL) {

            return (string)($baseNomor + $urutan - 1);

        } else {

            $subIndex = (int)(($urutan - 1) / self::BATAS_PER_TANGGAL);

            $dasarIndex = ($urutan - 1)
                % self::BATAS_PER_TANGGAL + 1;

            return ($baseNomor + $dasarIndex - 1)
                . '.' . $subIndex;
        }
    }
}