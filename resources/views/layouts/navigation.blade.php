<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo-banyumas.png') }}" alt="Logo" class="h-8 w-8 object-contain" onerror="this.src='https://via.placeholder.com/32?text=BMS'">
                        <span class="font-bold text-gray-900 text-lg hidden sm:block">SIPENKA</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(auth()->user()->isAdmin())
                        {{-- Admin --}}
                        <x-nav-link :href="route('admin.surat-keluar.dashboard')" :active="request()->routeIs('admin.surat-keluar.*')">
                            Surat Keluar
                        </x-nav-link>
                        <x-nav-link :href="route('admin.surat-keputusan.dashboard')" :active="request()->routeIs('admin.surat-keputusan.*')">
                            Surat Keputusan
                        </x-nav-link>
                        <x-nav-link :href="route('admin.laporan.rekapitulasi')" :active="request()->routeIs('admin.laporan.*')">
                            Rekapitulasi
                        </x-nav-link>
                    @else
                        {{-- User --}}
                        <!-- Dashboard Surat Keluar -->
                        <x-nav-link :href="route('user.surat-keluar.dashboard')" :active="request()->routeIs('user.surat-keluar.*')">
                            Surat Keluar
                        </x-nav-link>

                        <!-- Dashboard Surat Keputusan -->
                        <x-nav-link :href="route('user.surat-keputusan.dashboard')" :active="request()->routeIs('user.surat-keputusan.*')">
                            Surat Keputusan
                        </x-nav-link>

                        
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center space-x-3">
                                <div class="flex flex-col items-end">
                                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                                    <span class="text-xs text-gray-500">{{ Auth::user()->isAdmin() ? 'Admin' : Auth::user()->bidang }}</span>
                                </div>
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Profil Saya
                            </span>
                        </x-dropdown-link>

                        <!-- Form Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <span class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isAdmin())
                {{-- Admin mobile --}}
                <x-responsive-nav-link :href="route('admin.surat-keluar.dashboard')" :active="request()->routeIs('admin.surat-keluar.*')">
                    Surat Keluar
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.surat-keputusan.dashboard')" :active="request()->routeIs('admin.surat-keputusan.*')">
                    Surat Keputusan
                </x-responsive-nav-link>
            @else
                {{-- User mobile --}}
                <x-responsive-nav-link :href="route('user.surat-keluar.dashboard')" :active="request()->routeIs('user.surat-keluar.*')">
                    Surat Keluar
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.surat-keputusan.dashboard')" :active="request()->routeIs('user.surat-keputusan.*')">
                    Surat Keputusan
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.surat-keluar.pengajuan.create')" :active="request()->routeIs('user.surat-keluar.pengajuan.*')">
                    Surat Keluar
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.surat-keputusan.pengajuan.create')" :active="request()->routeIs('user.surat-keputusan.pengajuan.*')">
                    Ajukan Surat Keputusan
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil Saya
                </x-responsive-nav-link>

                <!-- Form Logout Mobile -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Keluar
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>