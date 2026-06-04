<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KodePetunjuk;
use App\Services\NomorSuratService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UserSuratController extends Controller
{
    protected $nomorService;

    public function __construct(NomorSuratService $nomorService)
    {
        $this->nomorService = $nomorService;
    }

    // ==================== SURAT KELUAR ====================

    public function indexKeluar(Request $request)
    {
        return $this->indexByType($request, 'surat_keluar');
    }

    public function createKeluar()
    {
        return $this->createByType('surat_keluar');
    }

    public function showKeluar($id)
    {
        return $this->showByType($id, 'surat_keluar');
    }

    // ==================== SURAT KEPUTUSAN ====================

    public function indexKeputusan(Request $request)
    {
        return $this->indexByType($request, 'surat_keputusan');
    }

    public function createKeputusan()
    {
        return $this->createByType('surat_keputusan');
    }

    public function showKeputusan($id)
    {
        return $this->showByType($id, 'surat_keputusan');
    }

    // ==================== PRIVATE HELPERS ====================

    private function indexByType(Request $request, string $jenis)
    {
        $query = SuratKeluar::where('user_id', Auth::id())
                    ->where('jenis_surat', $jenis);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('perihal', 'like', "%{$search}%")
                  ->orWhere('tujuan', 'like', "%{$search}%")
                  ->orWhere('kode_petunjuk', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_surat', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_surat', '<=', $request->end_date);
        }

        $surat = $query->orderBy('tanggal_surat', 'desc')->get();

        return view('user.dashboard', compact('surat', 'jenis'));
    }

    private function createByType(string $jenis)
    {
        $kodePetunjuk = KodePetunjuk::orderBy('nama')->get();
        return view('user.pengajuan', compact('kodePetunjuk', 'jenis'));
    }

    private function showByType($id, string $jenis)
    {
        $surat = SuratKeluar::where('user_id', Auth::id())
                    ->where('jenis_surat', $jenis)
                    ->findOrFail($id);
        $previewNomor = null;
        if ($surat->status === 'pending') {
            $previewNomor = $this->nomorService->previewNomor($surat->tanggal_surat, $jenis);
        }
        return view('user.show', compact('surat', 'previewNomor'));
    }

    // ==================== STORE ====================

    public function store(Request $request)
{
    $request->validate([
        'jenis_surat' => 'required|in:surat_keluar,surat_keputusan',
        'tujuan' => 'required|string|max:255',
        'tanggal_surat' => 'required|date',
        'perihal' => 'required|string',
        'kode_petunjuk' => 'required_if:jenis_surat,surat_keluar|string|nullable',
        'keterangan' => 'required|string',
    ]);

    SuratKeluar::create([
        'user_id' => Auth::id(),
        'jenis_surat' => $request->jenis_surat,
        'tujuan' => $request->tujuan,
        'tanggal_surat' => $request->tanggal_surat,
        'perihal' => $request->perihal,
        'kode_petunjuk' => $request->kode_petunjuk ?? '', // default kosong untuk SK
        'keterangan' => $request->keterangan,
        'status' => 'pending',
    ]);

    $redirectRoute = ($request->jenis_surat == 'surat_keputusan')
                        ? 'user.surat-keputusan.dashboard'
                        : 'user.surat-keluar.dashboard';

    return redirect()->route($redirectRoute)
        ->with('success', 'Pengajuan berhasil dikirim.');
}
    // ==================== DOWNLOAD & PRINT ====================

    public function download($id)
    {
        $surat = SuratKeluar::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->findOrFail($id);

        $pdf = Pdf::loadView('user.surat-pdf', compact('surat'));
        $pdf->setPaper('a5', 'portrait');

        return $pdf->download('Surat_' . $surat->nomor_surat . '.pdf');
    }

    public function print($id)
    {
        $surat = SuratKeluar::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->findOrFail($id);

        return view('user.surat-pdf', compact('surat'));
    }
}