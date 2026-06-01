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

    public function index(Request $request)
{
    $query = SuratKeluar::where('user_id', Auth::id());

    // Search
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

    // Date range
    if ($request->filled('start_date')) {
        $query->whereDate('tanggal_surat', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('tanggal_surat', '<=', $request->end_date);
    }

    $surat = $query->orderBy('tanggal_surat', 'desc')->get();

    return view('user.dashboard', compact('surat'));
}

    public function create()
    {
        $kodePetunjuk = KodePetunjuk::orderBy('nama')->get();
        return view('user.pengajuan', compact('kodePetunjuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'kode_petunjuk' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        SuratKeluar::create([
            'user_id' => Auth::id(),
            'tujuan' => $request->tujuan,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal' => $request->perihal,
            'kode_petunjuk' => $request->kode_petunjuk,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function show($id)
    {
        $surat = SuratKeluar::where('user_id', Auth::id())->findOrFail($id);
        $previewNomor = null;
        if ($surat->status === 'pending') {
            $previewNomor = $this->nomorService->previewNomor($surat->tanggal_surat);
        }
        return view('user.show', compact('surat', 'previewNomor'));
    }
    public function download($id)
{
    $surat = SuratKeluar::where('user_id', Auth::id())
                ->where('status', 'approved')
                ->findOrFail($id);
    
    $pdf = Pdf::loadView('user.surat-pdf', compact('surat'));
    
    // Ganti A4 menjadi A5 agar ukurannya kecil
    $pdf->setPaper('a5', 'portrait');
    
    return $pdf->download('Surat_' . $surat->nomor_surat . '_' . $surat->perihal . '.pdf');
}
    public function print($id)
    {
        $surat = SuratKeluar::where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->findOrFail($id);
        
        return view('user.surat-pdf', compact('surat'));
    }
}