<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Services\NomorSuratService;
use Illuminate\Http\Request;

class AdminSuratController extends Controller
{
    protected $nomorService;

    public function __construct(NomorSuratService $nomorService)
    {
        $this->nomorService = $nomorService;
    }

    public function index(Request $request)
{
    $status = $request->query('status', 'pending');

    $query = SuratKeluar::with('user')
                ->where('status', $status);

    // Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('perihal', 'like', "%{$search}%")
              ->orWhere('tujuan', 'like', "%{$search}%")
              ->orWhere('kode_petunjuk', 'like', "%{$search}%")
              ->orWhere('nomor_surat', 'like', "%{$search}%")
              ->orWhereHas('user', function ($userQuery) use ($search) {
                  $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('bidang', 'like', "%{$search}%");
              });
        });
    }

    // Date range & bidang filters tetap sama (tidak diketik ulang agar jawaban tidak terlalu panjang)
    if ($request->filled('start_date')) {
        $query->whereDate('tanggal_surat', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('tanggal_surat', '<=', $request->end_date);
    }
    if ($request->filled('bidang')) {
        $query->whereHas('user', fn($q) => $q->where('bidang', $request->bidang));
    }

    $surat = $query->orderBy('created_at', 'asc')
                   ->paginate(20)
                   ->appends($request->query());

    return view('admin.dashboard', compact('surat', 'status'));
}

    public function show($id)
    {
        $surat = SuratKeluar::with('user')->findOrFail($id);
        $previewNomor = null;
        if ($surat->status === 'pending') {
            $previewNomor = $this->nomorService->previewNomor($surat->tanggal_surat);
        }
        return view('admin.show', compact('surat', 'previewNomor'));
    }

    public function approve($id)
{
    try {

        $surat = SuratKeluar::where('status', 'pending')
            ->findOrFail($id);

        $nomor = $this->nomorService
            ->generateNomorBerikutnya($surat->tanggal_surat);

        $surat->update([
            'status' => 'approved',
            'nomor_surat' => $nomor,
        ]);

        return redirect()
            ->route('admin.dashboard', ['status' => 'approved'])
            ->with('success', 'Surat berhasil disetujui.');

    } catch (\Exception $e) {

        return redirect()->back()
            ->with('error', 'Gagal menyetujui surat: ' . $e->getMessage());
    }
}

    public function reject($id)
    {
        $surat = SuratKeluar::where('status', 'pending')->findOrFail($id);
        $surat->update(['status' => 'rejected']);
        return redirect()->route('admin.dashboard', ['status' => 'rejected'])
            ->with('success', 'Pengajuan ditolak.');
    }
}