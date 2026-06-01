<x-guest-layout>
    <div class="min-h-screen flex">
        
        <!-- Left Side - Hero -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-gradient-to-br from-[#1e3c72] to-[#2a5298]">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="dots" width="30" height="30" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1.5" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#dots)"/>
                </svg>
            </div>
            
            <div class="relative z-10 flex flex-col justify-between w-full p-12 text-white">
                <div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 backdrop-blur-sm p-2 rounded-2xl">
                            <img src="{{ asset('images/logosipenka.png') }}" alt="Logo" class="h-10 w-10 object-contain" onerror="this.src='https://via.placeholder.com/40?text=BMS'">
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg leading-tight">Dinas Pendidikan</h3>
                            <p class="text-sm text-white/70">Kabupaten Banyumas</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <h1 class="text-5xl font-bold leading-tight">Selamat Datang<br>di SIPENKA</h1>
                    <p class="text-xl text-white/80 max-w-md">Sistem Penomoran Surat Keluar yang modern, efisien, dan terintegrasi.</p>
                </div>
                
                <div class="border-l-4 border-white/30 pl-4">
                    <p class="text-sm text-white/60 italic">"Melayani dengan Cepat, Tepat, dan Transparan"</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12 bg-white">
            <div class="w-full max-w-md">
                
                <div class="lg:hidden text-center mb-10">
                    <div class="flex justify-center">
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-2xl shadow-sm">
                            <img src="{{ asset('images/logosipenka.png') }}" alt="Logo" class="h-16 w-16 object-contain" onerror="this.src='https://via.placeholder.com/64?text=BMS'">
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mt-4">SIPENKA</h2>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Masuk ke Akun</h2>
                    <p class="text-gray-500 mt-2">Silakan login untuk melanjutkan</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-red-800">Gagal Masuk</h3>
                                <div class="mt-1 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@dindik.test"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 text-gray-900 placeholder-gray-400">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required placeholder="••••••••"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 text-gray-900 pr-12">
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 p-1">
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600">Ingat saya</label>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-3.5 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-gray-900/20">
                        Masuk
                    </button>
                </form>

                <p class="text-center text-xs text-gray-400 mt-8">© 2026 Dinas Pendidikan Kabupaten Banyumas</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }
    </script>
</x-guest-layout>