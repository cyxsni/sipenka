<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPENKA – Dinas Pendidikan Kabupaten Banyumas</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            position: relative;
            overflow: hidden;
        }
        /* Lingkaran dekoratif dengan animasi slow float */
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            transform: rotate(45deg);
            animation: floatCircle 8s ease-in-out infinite;
        }
        .hero-bg::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
            animation: floatCircle 10s ease-in-out infinite reverse;
        }
        @keyframes floatCircle {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.02); }
        }

        /* Animasi untuk elemen teks */
        .fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }
        .fade-in-up-delay-1 {
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards 0.2s;
        }
        .fade-in-up-delay-2 {
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards 0.4s;
        }
        .fade-in-right {
            opacity: 0;
            animation: fadeInRight 0.8s ease forwards 0.3s;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Animasi live dot */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .live-dot {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="antialiased text-gray-800">

    <!-- Header (navy) -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#1e3c72] shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1.5 rounded-xl shadow-sm">
                        <img src="{{ asset('images/logosipenka.png') }}" alt="Logo" class="h-8 w-8 object-contain" onerror="this.src='https://via.placeholder.com/32?text=BMS'">
                    </div>
                    <div>
                        <span class="font-extrabold text-white text-lg">SIPENKA</span>
                        <p class="text-xs text-blue-200 -mt-0.5 hidden sm:block">Dinas Pendidikan Kab. Banyumas</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-blue-200 font-medium text-sm px-4 py-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="border border-white text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-white hover:text-[#1e3c72] transition">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section (full screen, compact + animasi) -->
    <section class="min-h-screen flex items-center hero-bg text-white pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-3 fade-in-up">
                        Selamat Datang di <span class="text-yellow-300">SIPENKA</span>
                    </h1>
                    <p class="text-base md:text-lg text-white/80 mb-6 max-w-lg fade-in-up-delay-1">
                        Sistem penomoran surat keluar yang modern dan terintegrasi untuk mendukung proses administrasi yang lebih cepat, akurat, dan tertib.
                    </p>
                    <div class="fade-in-up-delay-2">
                        @guest
                            <a href="{{ route('login') }}" class="inline-block border border-white text-white px-6 py-3 rounded-xl font-semibold hover:bg-white hover:text-[#1e3c72] transition text-sm">
                                Login
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-block border border-white text-white px-6 py-3 rounded-xl font-semibold hover:bg-white hover:text-[#1e3c72] transition text-sm">
                                Dashboard Saya
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="hidden md:block fade-in-right">
                    <div class="glass-card rounded-3xl shadow-2xl p-6 border border-white/20 text-gray-900">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-semibold text-gray-800 text-base">Statistik Sistem</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full live-dot"></span> live
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-white p-4 rounded-2xl shadow-sm stat-card">
                                <div class="text-2xl font-bold text-blue-700">{{ $suratDiterbitkan ?? 0 }}</div>
                                <div class="text-xs text-gray-600 mt-1">Surat Diterbitkan</div>
                            </div>
                            <div class="bg-white p-4 rounded-2xl shadow-sm stat-card">
                                <div class="text-2xl font-bold text-green-700">{{ $bidangAktif ?? 0 }}</div>
                                <div class="text-xs text-gray-600 mt-1">Bidang Aktif</div>
                            </div>
                            <div class="bg-white p-4 rounded-2xl shadow-sm stat-card col-span-2">
                                <div class="text-2xl font-bold text-purple-700">{{ $totalPengajuan ?? 0 }}+</div>
                                <div class="text-xs text-gray-600 mt-1">Total Pengajuan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">Mengapa SIPENKA?</h2>
                <p class="text-gray-500 mt-3 text-lg">Sistem yang memudahkan seluruh bagian tanpa ribet.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="h-14 w-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-5 text-2xl">🔢</div>
                    <h3 class="font-semibold text-gray-900 text-lg mb-3">Penomoran Otomatis</h3>
                    <p class="text-gray-500">Nomor surat keluar dihasilkan secara otomatis sesuai aturan yang berlaku, tanpa perlu catat manual.</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="h-14 w-14 bg-green-100 rounded-2xl flex items-center justify-center mb-5 text-2xl">⚡</div>
                    <h3 class="font-semibold text-gray-900 text-lg mb-3">Proses Cepat & Real‑time</h3>
                    <p class="text-gray-500">Pengajuan dan persetujuan terjadi secara langsung. Admin dapat menyetujui kapan saja, di mana saja.</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
                    <div class="h-14 w-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-5 text-2xl">🖨️</div>
                    <h3 class="font-semibold text-gray-900 text-lg mb-3">Cetak & Arsip Digital</h3>
                    <p class="text-gray-500">Surat yang sudah disetujui bisa langsung dicetak atau diunduh sebagai PDF, siap untuk arsip.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900">Cara Kerja SIPENKA</h2>
                <p class="text-gray-500 mt-3 text-lg">Tiga langkah mudah untuk mendapatkan nomor surat.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-blue-100 text-blue-700 text-3xl font-bold mb-6">1</div>
                    <h3 class="font-semibold text-gray-900 text-lg mb-2">Ajukan Surat</h3>
                    <p class="text-gray-500">User dari masing‑masing bidang mengisi form pengajuan surat.</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-green-100 text-green-700 text-3xl font-bold mb-6">2</div>
                    <h3 class="font-semibold text-gray-900 text-lg mb-2">Verifikasi Admin</h3>
                    <p class="text-gray-500">Admin memeriksa dan menyetujui pengajuan, lalu nomor surat otomatis terbit.</p>
                </div>
                <div class="text-center">
                    <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-purple-100 text-purple-700 text-3xl font-bold mb-6">3</div>
                    <h3 class="font-semibold text-gray-900 text-lg mb-2">Cetak / Unduh</h3>
                    <p class="text-gray-500">Surat yang disetujui bisa langsung dicetak atau diunduh sebagai PDF.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-20 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <svg class="w-12 h-12 text-blue-200 mb-6 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.9 1.398-.9 1.698 0l1.34 4.075a.9.9 0 00.85.62h4.292c.88 0 1.25 1.13.56 1.65l-3.4 2.48a.9.9 0 00-.33 1.02l1.31 4.06c.3.9-.73 1.65-1.5 1.12L9 13.88a.9.9 0 00-1.08 0l-3.46 2.51c-.77.56-1.78-.18-1.49-1.08l1.31-4.06a.9.9 0 00-.33-1.02L.56 7.27c-.69-.52-.32-1.65.56-1.65h4.29a.9.9 0 00.85-.62L9.049 2.927z"/>
            </svg>
            <blockquote class="text-2xl font-medium text-gray-700 italic leading-relaxed">
                "Dengan SIPENKA, pelayanan administrasi persuratan di Dinas Pendidikan Banyumas menjadi lebih cepat, tertib, dan akuntabel. Ini adalah wujud nyata transformasi digital pelayanan publik."
            </blockquote>
            <div class="mt-8">
                <p class="font-semibold text-gray-900 text-lg">Kepala Dinas Pendidikan</p>
                <p class="text-gray-500">Kabupaten Banyumas</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-gray-900 text-center mb-12">Pertanyaan Umum</h2>
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <p class="font-semibold text-gray-900 text-lg">Siapa yang bisa menggunakan SIPENKA?</p>
                    <p class="text-gray-500 mt-2">Seluruh pegawai di lingkungan Dinas Pendidikan Kabupaten Banyumas yang membutuhkan nomor surat keluar resmi.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <p class="font-semibold text-gray-900 text-lg">Apakah nomor surat bisa duplikat?</p>
                    <p class="text-gray-500 mt-2">Tidak. Sistem kami dilengkapi mekanisme penguncian (lock) sehingga setiap nomor bersifat unik.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <p class="font-semibold text-gray-900 text-lg">Bagaimana jika butuh bantuan?</p>
                    <p class="text-gray-500 mt-2">Silakan hubungi Sub Bagian Umum Dinas Pendidikan Kabupaten Banyumas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-white font-bold text-xl mb-4">SIPENKA</h3>
                    <p class="text-gray-400">Sistem Penomoran Surat Keluar Dinas Pendidikan Kabupaten Banyumas.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <p class="text-gray-400">Jl. Perintis Kemerdekaan No.1, Purwokerto</p>
                    <p class="text-gray-400 mt-2">Telepon: (0281) 634567</p>
                    <p class="text-gray-400 mt-2">Email: dinas@banyumaskab.go.id</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Tautan</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                © 2026 Dinas Pendidikan Kabupaten Banyumas. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

</body>
</html>