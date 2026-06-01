<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes slide-down {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-down { animation: slide-down 0.3s ease-out; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- POPUP ALERT --}}
    @if(session('success') || session('error'))
        <div id="popup-alert" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-3xl shadow-2xl p-6 w-full max-w-md mx-4 relative animate-slide-down">
                <button onclick="closePopup()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition text-2xl">×</button>
                <div class="flex flex-col items-center text-center">
                    @if(session('success'))
                        <div class="h-20 w-20 rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Berhasil!</h2>
                        <p class="text-gray-600">{{ session('success') }}</p>
                    @endif
                    @if(session('error'))
                        <div class="h-20 w-20 rounded-full bg-red-100 flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Gagal!</h2>
                        <p class="text-gray-600">{{ session('error') }}</p>
                    @endif
                    <button onclick="closePopup()" class="mt-6 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-semibold transition">OK</button>
                </div>
            </div>
        </div>
        <script>
            const popup = document.getElementById('popup-alert');
            setTimeout(() => { closePopup(); }, 3000);
            popup.addEventListener('click', function(e) { if (e.target === popup) { closePopup(); } });
            function closePopup() { popup.style.display = 'none'; }
        </script>
    @endif
</body>
</html>