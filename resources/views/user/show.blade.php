<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detail Pengajuan</h2>
                    <p class="text-sm text-gray-500">{{ $surat->status == 'pending' ? 'Menunggu Persetujuan' : ($surat->status == 'approved' ? 'Disetujui' : 'Ditolak') }}</p>
                </div>
            </div>
            @php
                $backRoute = ($surat->jenis_surat ?? 'surat_keluar') == 'surat_keputusan' ? 'user.surat-keputusan.dashboard' : 'user.surat-keluar.dashboard';
            @endphp
            <a href="{{ route($backRoute) }}" 
               class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Status Alert -->
            @if($surat->status == 'approved')
                <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center">
                    <div class="h-10 w-10 bg-emerald-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-emerald-800">Disetujui</p>
                        <p class="text-sm text-emerald-700">Nomor Surat: <strong class="text-lg">{{ $surat->nomor_surat }}</strong></p>
                    </div>
                </div>
            @elseif($surat->status == 'rejected')
                <div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl p-4 flex items-center">
                    <div class="h-10 w-10 bg-rose-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-rose-800">Ditolak</p>
                        <p class="text-sm text-rose-700">Pengajuan ini telah ditolak</p>
                    </div>
                </div>
            @endif

            <!-- Detail Surat -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="p-6 lg:p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
                        Informasi Pengajuan
                    </h3>
                    
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tujuan</dt>
                            <dd class="text-sm text-gray-900">{{ $surat->tujuan }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Surat</dt>
                            <dd class="text-sm text-gray-900">{{ $surat->tanggal_surat->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Perihal</dt>
                            <dd class="text-sm text-gray-900">{{ $surat->perihal }}</dd>
                        </div>
                        @if(($surat->jenis_surat ?? 'surat_keluar') != 'surat_keputusan')
                        <div>
                            <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kode Petunjuk</dt>
                            <dd><code class="text-sm bg-gray-100 px-3 py-1 rounded-lg text-gray-700 font-mono">{{ $surat->kode_petunjuk }}</code></dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan</dt>
                            <dd><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">{{ $surat->keterangan }}</span></dd>
                        </div>
                        <div>
                            <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diajukan Pada</dt>
                            <dd class="text-sm text-gray-500">{{ $surat->created_at->format('d M Y - H:i') }}</dd>
                        </div>
                        @if($surat->status == 'pending' && isset($previewNomor))
                            <div>
                                <dt class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Preview Nomor</dt>
                                <dd>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-lg font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $previewNomor }}
                                    </span>
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Tombol Print/Download jika Approved -->
            @if($surat->status == 'approved')
                <div class="flex gap-3">
                    @php
                        $printRoute = ($surat->jenis_surat ?? 'surat_keluar') == 'surat_keputusan' ? 'user.surat-keputusan.surat.print' : 'user.surat-keluar.surat.print';
                        $downloadRoute = ($surat->jenis_surat ?? 'surat_keluar') == 'surat_keputusan' ? 'user.surat-keputusan.surat.download' : 'user.surat-keluar.surat.download';
                    @endphp
                    <a href="{{ route($printRoute, $surat->id) }}" target="_blank"
                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-4 px-6 rounded-2xl transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12H5"/>
                        </svg>
                        Print
                    </a>
                    <a href="{{ route($downloadRoute, $surat->id) }}"
                       class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-4 px-6 rounded-2xl transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download PDF
                    </a>
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>