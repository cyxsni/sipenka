<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        Dashboard {{ $jenis == 'surat_keputusan' ? 'Surat Keputusan (SK)' : 'Surat Keluar' }}
                    </h2>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Live • {{ now()->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $total = App\Models\SuratKeluar::where('jenis_surat', $jenis)->count();
                $pending = App\Models\SuratKeluar::where('jenis_surat', $jenis)->where('status', 'pending')->count();
                $approved = App\Models\SuratKeluar::where('jenis_surat', $jenis)->where('status', 'approved')->count();
                $rejected = App\Models\SuratKeluar::where('jenis_surat', $jenis)->where('status', 'rejected')->count();

                $routeName = $jenis == 'surat_keputusan' ? 'admin.surat-keputusan.dashboard' : 'admin.surat-keluar.dashboard';
                $showRoute = $jenis == 'surat_keputusan' ? 'admin.surat-keputusan.surat.show' : 'admin.surat-keluar.surat.show';
                $checkRoute = $jenis == 'surat_keputusan' ? 'admin.surat-keputusan.check-new' : 'admin.surat-keluar.check-new';
                $deleteRoute = $jenis == 'surat_keputusan' ? 'admin.surat-keputusan.surat.destroy' : 'admin.surat-keluar.surat.destroy';
            @endphp

            <!-- STATS CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                <!-- Total -->
                <a href="{{ route($routeName, array_merge(request()->except('status'), ['status' => 'all'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer h-full
                          {{ $status == 'all' ? 'ring-2 ring-offset-2 ring-blue-500 bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200' : 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-700 mb-1">Total</p>
                                <p class="card-total text-4xl lg:text-5xl font-bold text-blue-800 tracking-tight">{{ $total }}</p>
                                <p class="text-xs text-blue-600 mt-1">semua pengajuan</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-blue-200">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Menunggu -->
                <a href="{{ route($routeName, array_merge(request()->except('status'), ['status' => 'pending'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer h-full
                          {{ $status == 'pending' ? 'ring-2 ring-offset-2 ring-yellow-500 bg-gradient-to-br from-amber-50 to-yellow-50 border-yellow-200' : 'bg-gradient-to-br from-amber-50 to-yellow-50 border-yellow-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-yellow-700 mb-1 flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                                    Menunggu
                                </p>
                                <p class="card-pending text-4xl lg:text-5xl font-bold text-yellow-800 tracking-tight">{{ $pending }}</p>
                                <p class="text-xs text-yellow-600 mt-1">perlu persetujuan</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-yellow-200">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Disetujui -->
                <a href="{{ route($routeName, array_merge(request()->except('status'), ['status' => 'approved'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer h-full
                          {{ $status == 'approved' ? 'ring-2 ring-offset-2 ring-green-500 bg-gradient-to-br from-emerald-50 to-green-50 border-green-200' : 'bg-gradient-to-br from-emerald-50 to-green-50 border-green-100' }}">
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
                                <p class="card-approved text-4xl lg:text-5xl font-bold text-green-800 tracking-tight">{{ $approved }}</p>
                                <p class="text-xs text-green-600 mt-1">surat terbit</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-green-200">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Ditolak -->
                <a href="{{ route($routeName, array_merge(request()->except('status'), ['status' => 'rejected'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer h-full
                          {{ $status == 'rejected' ? 'ring-2 ring-offset-2 ring-red-500 bg-gradient-to-br from-rose-50 to-red-50 border-red-200' : 'bg-gradient-to-br from-rose-50 to-red-50 border-red-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-red-700 mb-1">Ditolak</p>
                                <p class="card-rejected text-4xl lg:text-5xl font-bold text-red-800 tracking-tight">{{ $rejected }}</p>
                                <p class="text-xs text-red-600 mt-1">tidak disetujui</p>
                            </div>
                            <div class="h-12 w-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-red-200">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- FILTER BAR -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-sm border border-white/50 p-5 mb-6">
                <form method="GET" action="{{ route($routeName) }}" class="space-y-4">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="jenis" value="{{ $jenis }}">
                    
                    <div class="flex flex-wrap items-end gap-3">
                        <!-- Search -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Cari</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Perihal, tujuan, pengaju..."
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

                        <!-- Bidang -->
                        <div class="w-48">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Bidang</label>
                            <select name="bidang"
                                    class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                                <option value="">Semua Bidang</option>
                                <option value="PGTK" {{ request('bidang') == 'PGTK' ? 'selected' : '' }}>PGTK</option>
                                <option value="SD" {{ request('bidang') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ request('bidang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="GTK" {{ request('bidang') == 'GTK' ? 'selected' : '' }}>GTK</option>
                                <option value="Umum" {{ request('bidang') == 'Umum' ? 'selected' : '' }}>📋 Umum</option>
                            </select>
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
                            @if(request('start_date') || request('end_date') || request('bidang') || request('search'))
                                <a href="{{ route($routeName, ['status' => $status]) }}" class="px-4 py-3 text-gray-500 hover:text-gray-700 rounded-2xl hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Active Filters -->
                    @if(request('start_date') || request('end_date') || request('bidang') || request('search'))
                        <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-gray-200/50">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Filter Aktif</span>
                            @if(request('search'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">🔍 {{ request('search') }}</span>
                            @endif
                            @if(request('start_date'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">📅 {{ \Carbon\Carbon::parse(request('start_date'))->format('d M') }}</span>
                            @endif
                            @if(request('end_date'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">→ {{ \Carbon\Carbon::parse(request('end_date'))->format('d M') }}</span>
                            @endif
                            @if(request('bidang'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">🏷️ {{ request('bidang') }}</span>
                            @endif
                        </div>
                    @endif
                </form>
            </div>

            <!-- TABEL -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengaju</th>
                                <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tgl</th>
                                <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Perihal</th>
                                @if($jenis != 'surat_keputusan')
                                <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kode</th>
                                @endif
                                <th class="px-4 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($surat as $s)
                            <tr data-id="{{ $s->id }}" class="group hover:bg-gray-50/50 transition-all duration-200">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm flex-shrink-0">
                                            {{ substr($s->user->name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 text-sm truncate">{{ $s->user->name }}</p>
                                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">{{ $s->user->bidang ?? 'Admin' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4"><span class="text-sm text-gray-700">{{ $s->tanggal_surat->format('d/m') }}</span></td>
                                <td class="px-4 py-4"><span class="text-sm text-gray-800 line-clamp-2">{{ Str::limit($s->perihal, 25) }}</span></td>
                                @if($jenis != 'surat_keputusan')
                                <td class="px-4 py-4"><code class="text-xs bg-gray-100 px-2 py-1 rounded-lg text-gray-600 font-mono whitespace-nowrap">{{ $s->kode_petunjuk }}</code></td>
                                @endif
                                <td class="px-4 py-4">
                                    @if($s->status == 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Menunggu
                                        </span>
                                    @elseif($s->status == 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> {{ $s->nomor_surat }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route($showRoute, $s->id) }}" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if($s->status == 'rejected')
                                            <button type="button" 
                                                    onclick="confirmDelete({{ $s->id }})"
                                                    class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $jenis == 'surat_keputusan' ? '5' : '6' }}" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-20 w-20 bg-gray-100 rounded-3xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-900 font-semibold text-lg">Tidak ada data</p>
                                        <p class="text-gray-500 text-sm mt-1">Coba ubah filter yang dipilih</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($surat->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $surat->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
        <div class="bg-white rounded-3xl shadow-2xl p-6 w-full max-w-md mx-4">
            <div class="text-center">
                <div class="h-16 w-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Yakin Hapus?</h3>
                <p class="text-sm text-gray-500 mb-6">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                <div class="flex gap-3 justify-center">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        // Bangun URL manual berdasarkan jenis surat
        let prefix = '{{ $jenis == "surat_keputusan" ? "/admin/surat-keputusan/surat" : "/admin/surat-keluar/surat" }}';
        form.action = prefix + '/' + id;
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>

    <!-- Polling realtime -->
    <script>
        let lastId = {{ $surat->max('id') ?? 0 }};

        function checkNewSurat() {
            fetch('{{ route($checkRoute) }}?last_id=' + lastId + '&status={{ $status }}&jenis={{ $jenis }}')
                .then(response => response.json())
                .then(data => {
                    if (data.counts) {
                        const totalEl = document.querySelector('.card-total');
                        if (totalEl) totalEl.textContent = data.counts.total;
                        const pendingEl = document.querySelector('.card-pending');
                        if (pendingEl) pendingEl.textContent = data.counts.pending;
                        const approvedEl = document.querySelector('.card-approved');
                        if (approvedEl) approvedEl.textContent = data.counts.approved;
                        const rejectedEl = document.querySelector('.card-rejected');
                        if (rejectedEl) rejectedEl.textContent = data.counts.rejected;
                    }

                    if (data.new_count > 0) {
                        const tbody = document.querySelector('table tbody');
                        const existingEmpty = tbody.querySelector('tr td[colspan]');
                        if (existingEmpty) existingEmpty.parentElement.remove();
                        tbody.insertAdjacentHTML('beforeend', data.html);

                        const newRows = tbody.querySelectorAll('tr');
                        if (newRows.length > 0) {
                            const lastRow = newRows[newRows.length - 1];
                            const newId = lastRow.getAttribute('data-id');
                            if (newId) lastId = parseInt(newId);
                        }

                        const notif = document.createElement('div');
                        notif.className = 'fixed bottom-6 right-6 bg-emerald-500 text-white px-4 py-3 rounded-2xl shadow-xl z-50 animate-slide-up';
                        notif.innerHTML = '🔔 ' + data.new_count + ' pengajuan baru!';
                        document.body.appendChild(notif);
                        setTimeout(() => notif.remove(), 4000);
                    }
                });
        }

        setInterval(checkNewSurat, 5000);
    </script>

    <style>
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slide-up 0.3s ease-out; }
    </style>
</x-app-layout>