<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rekapitulasi Surat 
            @if($jenis == 'surat_keluar')
                Keluar
            @elseif($jenis == 'surat_keputusan')
                Keputusan (SK)
            @else
                (Semua Jenis)
            @endif
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filter --}}
            <form method="GET" action="{{ route('admin.laporan.rekapitulasi') }}" class="mb-6 flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select name="tahun" class="mt-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="semua" {{ $tahun == 'semua' ? 'selected' : '' }}>Semua Tahun</option>
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $tahun ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Surat</label>
                    <select name="jenis" class="mt-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="semua" {{ $jenis == 'semua' ? 'selected' : '' }}>Semua Jenis</option>
                        <option value="surat_keluar" {{ $jenis == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                        <option value="surat_keputusan" {{ $jenis == 'surat_keputusan' ? 'selected' : '' }}>Surat Keputusan (SK)</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Filter
                </button>
            </form>

            {{-- Tabel Rekapitulasi --}}
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <h3 class="text-lg font-medium mb-4">
                    Total Surat Disetujui {{ $tahun == 'semua' ? 'Semua Tahun' : 'Tahun ' . $tahun }}
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Bulan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($totalPerBulan as $data)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $data['bulan'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 font-bold">{{ $data['total'] }}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold">
                                <td class="px-4 py-2 text-sm text-gray-900">Total</td>
                                <td class="px-4 py-2 text-sm text-gray-900">{{ $totalKeseluruhan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>