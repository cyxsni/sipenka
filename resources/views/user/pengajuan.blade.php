<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ ($jenis ?? 'surat_keluar') == 'surat_keputusan' ? 'Pengajuan Nomor Surat Keputusan (SK)' : 'Ajukan Nomor Surat Keluar' }}
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Isi form di bawah untuk mengajukan nomor surat baru
                </p>
            </div>
            @php
                $backRoute = ($jenis ?? 'surat_keluar') == 'surat_keputusan' ? 'user.surat-keputusan.dashboard' : 'user.surat-keluar.dashboard';
            @endphp
            <a href="{{ route($backRoute) }}" 
               class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 lg:p-8">
                    
                    @php
                        $storeRoute = ($jenis ?? 'surat_keluar') == 'surat_keputusan' ? 'user.surat-keputusan.pengajuan.store' : 'user.surat-keluar.pengajuan.store';
                    @endphp
                    <form method="POST" action="{{ route($storeRoute) }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="jenis_surat" value="{{ $jenis ?? 'surat_keluar' }}">

                        {{-- Error Summary --}}
                        @if ($errors->any())
                            <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-4">
                                <ul class="list-disc list-inside text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Tujuan -->
                        <div>
                            <label for="tujuan" class="block text-sm font-medium text-gray-700 mb-2">
                                Tujuan Surat
                            </label>
                            <input type="text" 
                                   name="tujuan" 
                                   id="tujuan"
                                   value="{{ old('tujuan') }}" 
                                   placeholder="Contoh: Kepala Dinas Pendidikan Banyumas"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                                          focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                                          transition-all duration-200 text-gray-900 placeholder-gray-400">
                            @error('tujuan')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Surat -->
                        <div>
                            <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Surat
                            </label>
                            <input type="date" 
                                   name="tanggal_surat" 
                                   id="tanggal_surat"
                                   value="{{ old('tanggal_surat', date('Y-m-d')) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                                          focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                                          transition-all duration-200 text-gray-900">
                            @error('tanggal_surat')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Perihal -->
                        <div>
                            <label for="perihal" class="block text-sm font-medium text-gray-700 mb-2">
                                Perihal
                            </label>
                            <input type="text" 
                                   name="perihal" 
                                   id="perihal"
                                   value="{{ old('perihal') }}" 
                                   placeholder="Contoh: Permohonan Cuti Sakit"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                                          focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                                          transition-all duration-200 text-gray-900 placeholder-gray-400">
                            @error('perihal')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Petunjuk (HANYA untuk Surat Keluar) -->
                        @if(($jenis ?? 'surat_keluar') != 'surat_keputusan')
                        <div>
                            <label for="kode_petunjuk" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Petunjuk
                            </label>
                            <select name="kode_petunjuk" 
                                    id="kode_petunjuk"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                                           focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                                           transition-all duration-200 text-gray-900">
                                <option value="">Pilih Kode Petunjuk</option>
                                @foreach($kodePetunjuk as $kode)
                                    <option value="{{ $kode->kode }}" {{ old('kode_petunjuk') == $kode->kode ? 'selected' : '' }}>
                                        {{ $kode->kode }} - {{ $kode->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_petunjuk')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Keterangan -->
                        <div>
                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan (Bidang Tujuan)
                            </label>
                            <input type="text" 
                                   name="keterangan" 
                                   id="keterangan"
                                   value="{{ old('keterangan') }}" 
                                   placeholder="Contoh: PGTK, SD, SMP"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                                          focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 
                                          transition-all duration-200 text-gray-900 placeholder-gray-400">
                            @error('keterangan')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end space-x-3 pt-4">
                            <a href="{{ route($backRoute) }}" 
                               class="px-5 py-2.5 text-gray-600 hover:text-gray-900 font-medium text-sm rounded-xl 
                                      hover:bg-gray-100 transition">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2.5 rounded-xl text-sm font-medium 
                                           transition-all duration-200 transform hover:scale-105 active:scale-95 
                                           shadow-lg shadow-gray-900/20">
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
            <!-- Info Box -->
            <div class="mt-6 bg-blue-50/50 rounded-xl p-4 border border-blue-100">
                <p class="text-sm text-blue-800 flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>
                        Pengajuan akan diverifikasi oleh Admin. Nomor surat akan diberikan setelah disetujui.
                    </span>
                </p>
            </div>
            
        </div>
    </div>
</x-app-layout>