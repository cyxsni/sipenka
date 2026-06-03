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
    <td class="px-4 py-4"><code class="text-xs bg-gray-100 px-2 py-1 rounded-lg text-gray-600 font-mono whitespace-nowrap">{{ $s->kode_petunjuk }}</code></td>
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
        <p class="text-gray-500">Tidak ada pengajuan baru.</p>
    </td>
</tr>
@endforelse