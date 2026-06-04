<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $jenis = $request->input('jenis', 'semua');

        $query = SuratKeluar::where('status', 'approved');

        // Filter tahun (jika bukan "semua")
        if ($tahun !== 'semua') {
            $query->whereYear('tanggal_surat', $tahun);
        }

        // Filter jenis surat
        if ($jenis !== 'semua') {
            $query->where('jenis_surat', $jenis);
        }

        // Ambil data per bulan
        $rekap = $query->selectRaw('MONTH(tanggal_surat) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Siapkan array 12 bulan
        $totalPerBulan = [];
        $bulanLabels = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $totalKeseluruhan = 0;

        for ($i = 1; $i <= 12; $i++) {
            $jumlah = $rekap->get($i, 0);
            $totalPerBulan[] = [
                'bulan' => $bulanLabels[$i],
                'total' => $jumlah,
            ];
            $totalKeseluruhan += $jumlah;
        }

        // Tahun yang tersedia di database
        $availableYears = SuratKeluar::where('status', 'approved')
            ->selectRaw('YEAR(tanggal_surat) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.laporan.rekapitulasi', compact(
            'totalPerBulan',
            'tahun',
            'jenis',
            'totalKeseluruhan',
            'availableYears'
        ));
    }
}