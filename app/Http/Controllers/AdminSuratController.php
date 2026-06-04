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

    // ==================== SURAT KELUAR ====================

    public function indexKeluar(Request $request)
    {
        return $this->indexByType($request, 'surat_keluar');
    }

    // ==================== SURAT KEPUTUSAN ====================

    public function indexKeputusan(Request $request)
    {
        return $this->indexByType($request, 'surat_keputusan');
    }

    // ==================== PRIVATE HELPER ====================

    private function indexByType(Request $request, string $jenis)
    {
        $status = $request->query('status', 'pending');

        $query = SuratKeluar::with('user')
                    ->where('jenis_surat', $jenis);

        if ($status == 'all') {
            $query->whereIn('status', ['pending', 'approved', 'rejected']);
        } else {
            $query->where('status', $status);
        }

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

        $total = SuratKeluar::where('jenis_surat', $jenis)->count();
        $pending = SuratKeluar::where('jenis_surat', $jenis)->where('status', 'pending')->count();
        $approved = SuratKeluar::where('jenis_surat', $jenis)->where('status', 'approved')->count();
        $rejected = SuratKeluar::where('jenis_surat', $jenis)->where('status', 'rejected')->count();

        return view('admin.dashboard', compact('surat', 'status', 'total', 'pending', 'approved', 'rejected', 'jenis'));
    }

    // ==================== SHOW ====================

    public function show($id)
    {
        $surat = SuratKeluar::with('user')->findOrFail($id);
        $previewNomor = null;
        if ($surat->status === 'pending') {
            $previewNomor = $this->nomorService->previewNomor($surat->tanggal_surat, $surat->jenis_surat);
        }
        return view('admin.show', compact('surat', 'previewNomor'));
    }

    // ==================== APPROVE ====================

    public function approve($id)
    {
        try {
            $surat = SuratKeluar::where('status', 'pending')->findOrFail($id);
            $nomor = $this->nomorService->generateNomorBerikutnya($surat->tanggal_surat, $surat->jenis_surat);
            $surat->update([
                'status' => 'approved',
                'nomor_surat' => $nomor,
            ]);

            $redirectRoute = ($surat->jenis_surat == 'surat_keputusan')
                                ? 'admin.surat-keputusan.dashboard'
                                : 'admin.surat-keluar.dashboard';

            return redirect()
                ->route($redirectRoute, ['status' => 'approved'])
                ->with('success', 'Surat berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui surat: ' . $e->getMessage());
        }
    }

    // ==================== REJECT ====================

    public function reject($id)
    {
        $surat = SuratKeluar::where('status', 'pending')->findOrFail($id);
        $surat->update(['status' => 'rejected']);

        $redirectRoute = ($surat->jenis_surat == 'surat_keputusan')
                            ? 'admin.surat-keputusan.dashboard'
                            : 'admin.surat-keluar.dashboard';

        return redirect()
            ->route($redirectRoute, ['status' => 'rejected'])
            ->with('success', 'Pengajuan ditolak.');
    }

    // ==================== DESTROY ====================

    public function destroy($id)
    {
        $surat = SuratKeluar::where('status', 'rejected')->findOrFail($id);
        $surat->delete();

        return redirect()->back()->with('success', 'Surat berhasil dihapus.');
    }

    // ==================== CHECK NEW (POLLING) ====================

    public function checkNew(Request $request)
    {
        $lastId = $request->input('last_id', 0);
        $status = $request->input('status', 'pending');
        $jenis = $request->input('jenis', 'surat_keluar');

        $query = SuratKeluar::with('user')
                    ->where('jenis_surat', $jenis)
                    ->where('id', '>', $lastId);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $surat = $query->orderBy('id', 'asc')->get();
        $newCount = $surat->count();

        $pending = SuratKeluar::where('jenis_surat', $jenis)->where('status', 'pending')->count();
        $total = SuratKeluar::where('jenis_surat', $jenis)->count();
        $approved = SuratKeluar::where('jenis_surat', $jenis)->where('status', 'approved')->count();
        $rejected = SuratKeluar::where('jenis_surat', $jenis)->where('status', 'rejected')->count();

        $html = view('admin.partials.table-rows', compact('surat'))->render();

        return response()->json([
            'new_count' => $newCount,
            'html' => $html,
            'max_id' => $surat->max('id') ?? $lastId,
            'counts' => [
                'total' => $total,
                'pending' => $pending,
                'approved' => $approved,
                'rejected' => $rejected,
            ]
        ]);
    }
}