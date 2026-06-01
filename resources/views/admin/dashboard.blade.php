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
                    <h2 class="text-2xl font-bold text-gray-900">Dashboard Admin</h2>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Live • {{ now()->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @php
                $total = App\Models\SuratKeluar::count();
                $pending = App\Models\SuratKeluar::where('status', 'pending')->count();
                $approved = App\Models\SuratKeluar::where('status', 'approved')->count();
                $rejected = App\Models\SuratKeluar::where('status', 'rejected')->count();
            @endphp

            <!-- STATS CARDS – 4 KOLOM, BISA DIKLIK -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                
                <!-- Total -->
                <a href="{{ route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'all'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer
                          {{ $status == 'all' ? 'ring-2 ring-offset-2 ring-blue-500 bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200' : 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-700 mb-2">Total</p>
                                <p class="text-5xl font-bold text-blue-800 tracking-tight">{{ $total }}</p>
                                <p class="text-xs text-blue-600 mt-2">semua pengajuan</p>
                            </div>
                            <div class="h-14 w-14 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-blue-200">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-blue-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full w-full"></div>
                        </div>
                    </div>
                </a>

                <!-- Menunggu -->
                <a href="{{ route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'pending'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer
                          {{ $status == 'pending' ? 'ring-2 ring-offset-2 ring-yellow-500 bg-gradient-to-br from-amber-50 to-yellow-50 border-yellow-200' : 'bg-gradient-to-br from-amber-50 to-yellow-50 border-yellow-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-yellow-700 mb-2 flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></span>
                                    Menunggu
                                </p>
                                <p class="text-5xl font-bold text-yellow-800 tracking-tight">{{ $pending }}</p>
                                <p class="text-xs text-yellow-600 mt-2">perlu persetujuan</p>
                            </div>
                            <div class="h-14 w-14 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-yellow-200">
                                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-yellow-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-yellow-500 to-amber-500 rounded-full w-full"></div>
                        </div>
                    </div>
                </a>

                <!-- Disetujui -->
                <a href="{{ route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'approved'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer
                          {{ $status == 'approved' ? 'ring-2 ring-offset-2 ring-green-500 bg-gradient-to-br from-emerald-50 to-green-50 border-green-200' : 'bg-gradient-to-br from-emerald-50 to-green-50 border-green-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-700 mb-2 flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Disetujui
                                </p>
                                <p class="text-5xl font-bold text-green-800 tracking-tight">{{ $approved }}</p>
                                <p class="text-xs text-green-600 mt-2">surat terbit</p>
                            </div>
                            <div class="h-14 w-14 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-green-200">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-green-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full w-full"></div>
                        </div>
                    </div>
                </a>

                <!-- Ditolak -->
                <a href="{{ route('admin.dashboard', array_merge(request()->except('status'), ['status' => 'rejected'])) }}"
                   class="group relative overflow-hidden rounded-3xl border shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer
                          {{ $status == 'rejected' ? 'ring-2 ring-offset-2 ring-red-500 bg-gradient-to-br from-rose-50 to-red-50 border-red-200' : 'bg-gradient-to-br from-rose-50 to-red-50 border-red-100' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-200/30 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-red-700 mb-2">Ditolak</p>
                                <p class="text-5xl font-bold text-red-800 tracking-tight">{{ $rejected }}</p>
                                <p class="text-xs text-red-600 mt-2">tidak disetujui</p>
                            </div>
                            <div class="h-14 w-14 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-sm border border-red-200">
                                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 h-1.5 bg-red-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-red-500 to-rose-500 rounded-full w-full"></div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- FILTER BAR -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-sm border border-white/50 p-5 mb-6">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="space-y-4">
                    <input type="hidden" name="status" value="{{ $status }}">
                    
                    <div class="flex flex-wrap items-end gap-3">
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
                        <div class="w-48">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Bidang</label>
                            <select name="bidang"
                                    class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 text-sm">
                                <option value="">Semua Bidang</option>
                                <option value="PGTK" {{ request('bidang') == 'PGTK' ? 'selected' : '' }}>PGTK</option>
                                <option value="SD" {{ request('bidang') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ request('bidang') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="GTK" {{ request('bidang') == 'GTK' ? 'selected' : '' }}>GTK</option>
                                <option value="Umum" {{ request('bidang') == 'Umum' ? 'selected' : '' }}>Umum</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-2xl text-sm font-medium transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-lg shadow-gray-900/20 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            @if(request('start_date') || request('end_date') || request('bidang') || request('search'))
                                <a href="{{ route('admin.dashboard', ['status' => $status]) }}" class="px-4 py-3 text-gray-500 hover:text-gray-700 rounded-2xl hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    @if(request('start_date') || request('end_date') || request('bidang') || request('search'))
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
                            @if(request('bidang'))
                                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">{{ request('bidang') }}</span>
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
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengaju</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Tgl</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Perihal</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($surat as $s)
                            <tr class="group hover:bg-gray-50/50 transition-all duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                            {{ substr($s->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ $s->user->name }}</p>
                                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">{{ $s->user->bidang ?? 'Admin' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><span class="text-sm text-gray-700">{{ $s->tanggal_surat->format('d/m') }}</span></td>
                                <td class="px-6 py-4"><span class="text-sm text-gray-800">{{ Str::limit($s->perihal, 28) }}</span></td>
                                <td class="px-6 py-4"><code class="text-xs bg-gray-100 px-2 py-1 rounded-lg text-gray-600 font-mono">{{ $s->kode_petunjuk }}</code></td>
                                <td class="px-6 py-4">
                                    @if($s->status == 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> Menunggu
                                        </span>
                                    @elseif($s->status == 'approved')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> {{ $s->nomor_surat }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.surat.show', $s->id) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        Detail
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
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
        </div>
    </div>
</x-app-layout>