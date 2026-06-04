<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function rekapitulasi(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $jenis = $request->input('jenis', 'surat_keluar');

        $data = SuratKeluar::where('jenis_surat', $jenis)
            ->where('status', 'approved')
            ->whereYear('tanggal_surat', $tahun)
            ->get()
            ->groupBy(fn($item) => (int) $item->tanggal_surat->format('m'))
            ->map(fn($items) => $items->count());

        $totalPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalPerBulan[] = $data->get($i, 0);
        }

        $totalKeseluruhan = array_sum($totalPerBulan);

        $tahunTersedia = SuratKeluar::where('jenis_surat', $jenis)
            ->where('status', 'approved')
            ->selectRaw('YEAR(tanggal_surat) as tahun')
            ->distinct()
            ->orderBy('tahun')
            ->pluck('tahun');

        return view('admin.laporan.rekapitulasi', compact(
            'totalPerBulan', 'tahun', 'jenis', 'totalKeseluruhan', 'tahunTersedia'
        ));
    }
}