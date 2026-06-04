<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <span class="text-white font-bold text-lg">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                        {{ $jenis == 'surat_keputusan' ? 'Dashboard Surat Keputusan' : 'Dashboard Surat Keluar' }}
                    </h2>
                    <p class="text-sm text-gray-500 flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full text-[10px] font-bold border border-blue-200">
                            {{ auth()->user()->bidang ?? 'Staff' }}
                        </span>
                        • {{ now()->format('d M Y') }}
                    </p>
                </div>
            </div>
            @php
                $createRoute = $jenis == 'surat_keputusan' ? 'user.surat-keputusan.pengajuan.create' : 'user.surat-keluar.pengajuan.create';
            @endphp
            <a href="{{ route($createRoute) }}" 
               class="group relative overflow-hidden bg-gray-900 hover:bg-gray-800 text-white px-5 py-3 rounded-2xl text-sm font-medium 
                      transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg shadow-gray-900/20">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4 transition-transform group-hover:rotate-90 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan {{ $jenis == 'surat_keputusan' ? 'SK' : 'Surat' }}
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @php
                $total = $surat->count();
                $pending = $surat->where('status', 'pending')->count();
                $approved = $surat->where('status', 'approved')->count();
                $rejected = $surat->where('status', 'rejected')->count();
            @endphp

            <!-- STATS CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                
                <!-- Total -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-700 mb-1">Total</p>
                                <p class="text-4xl lg:text-5xl font-bold text-blue-800 tracking-tight">{{ $total }}</p>
                                <p class="text-xs text-blue-600 mt-1">pengajuan</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-blue-200">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menunggu -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-50 to-yellow-50 border border-yellow-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-yellow-700 mb-1 flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                                    Menunggu
                                </p>
                                <p class="text-4xl lg:text-5xl font-bold text-yellow-800 tracking-tight">{{ $pending }}</p>
                                <p class="text-xs text-yellow-600 mt-1">perlu persetujuan</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-yellow-200">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disetujui -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-50 to-green-50 border border-green-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-700 mb-1 flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Disetujui
                                </p>
                                <p class="text-4xl lg:text-5xl font-bold text-green-800 tracking-tight">{{ $approved }}</p>
                                <p class="text-xs text-green-600 mt-1">surat terbit</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-green-200">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ditolak -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-rose-50 to-red-50 border border-red-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-red-700 mb-1">Ditolak</p>
                                <p class="text-4xl lg:text-5xl font-bold text-red-800 tracking-tight">{{ $rejected }}</p>
                                <p class="text-xs text-red-600 mt-1">tidak disetujui</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-red-200">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER BAR -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-sm border border-white/50 p-5 mb-6">
                @php
                    $filterRoute = $jenis == 'surat_keputusan' ? 'user.surat-keputusan.dashboard' : 'user.surat-keluar.dashboard';
                @endphp
                <form method="GET" action="{{ route($filterRoute) }}" class="space-y-4">
                    <div class="flex flex-wrap items-end gap-3">
                        <!-- Search -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Cari</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Perihal, tujuan, kode..."
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                            </div>
                        </div>
                        <!-- Start Date -->
                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Dari</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                            </div>
                        </div>
                        <!-- End Date -->
                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Sampai</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-2xl text-sm font-medium transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-lg shadow-gray-900/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            @if(request('start_date') || request('end_date') || request('search'))
                                <a href="{{ route($filterRoute) }}" class="px-4 py-3 text-gray-500 hover:text-gray-700 rounded-2xl hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    @if(request('start_date') || request('end_date') || request('search'))
                        <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-gray-200/50">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Filter Aktif</span>
                            @if(request('search'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">{{ request('search') }}</span>
                            @endif
                            @if(request('start_date'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">{{ \Carbon\Carbon::parse(request('start_date'))->format('d M') }}</span>
                            @endif
                            @if(request('end_date'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">→ {{ \Carbon\Carbon::parse(request('end_date'))->format('d M') }}</span>
                            @endif
                        </div>
                    @endif
                </form>
            </div>

            <!-- TABEL -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                @if($surat->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tgl</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Perihal</th>
                                    @if($jenis != 'surat_keputusan')
                                    <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kode</th>
                                    @endif
                                    <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nomor</th>
                                    <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($surat as $s)
                                <tr class="group hover:bg-gray-50/50 transition-all duration-200">
                                    <td class="px-4 py-4">
                                        <span class="text-sm font-medium text-gray-900">{{ $s->tanggal_surat->format('d/m') }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="text-sm text-gray-700">{{ Str::limit($s->perihal, 30) }}</span>
                                    </td>
                                    @if($jenis != 'surat_keputusan')
                                    <td class="px-4 py-4">
                                        <code class="text-xs bg-gray-100 px-2 py-1 rounded-lg text-gray-500">{{ $s->kode_petunjuk }}</code>
                                    </td>
                                    @endif
                                    <td class="px-4 py-4">
                                        <span class="text-sm font-mono text-gray-600">{{ $s->nomor_surat ?? '—' }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($s->status == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Menunggu
                                            </span>
                                        @elseif($s->status == 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Disetujui
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200 whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            {{-- Detail link --}}
                                            @php
                                                $detailRoute = $jenis == 'surat_keputusan' ? 'user.surat-keputusan.pengajuan.show' : 'user.surat-keluar.pengajuan.show';
                                            @endphp
                                            <a href="{{ route($detailRoute, $s->id) }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if($s->status == 'approved')
                                                @php
                                                    $printRoute = $jenis == 'surat_keputusan' ? 'user.surat-keputusan.surat.print' : 'user.surat-keluar.surat.print';
                                                    $downloadRoute = $jenis == 'surat_keputusan' ? 'user.surat-keputusan.surat.download' : 'user.surat-keluar.surat.download';
                                                @endphp
                                                <a href="{{ route($printRoute, $s->id) }}" target="_blank" class="p-2 text-blue-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12H5"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route($downloadRoute, $s->id) }}" class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-20 text-center">
                        <div class="h-20 w-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <p class="text-gray-900 font-semibold text-lg">Belum ada pengajuan</p>
                        <p class="text-gray-500 text-sm mt-1 mb-6">Ajukan surat pertama kamu sekarang</p>
                        <a href="{{ route($createRoute) }}" 
                           class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-5 py-3 rounded-2xl text-sm font-medium 
                                  transition-all duration-200 shadow-lg shadow-gray-900/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Ajukan {{ $jenis == 'surat_keputusan' ? 'SK' : 'Surat' }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>