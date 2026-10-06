<nav x-data="{ open: false, userMenuOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-[#EFE3DE]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[76px] items-center">

            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-full overflow-hidden border border-[#EFE3DE] bg-[#F7EFE9] shrink-0">
                        <img
                            src="{{ asset('images/thumbnail.png') }}"
                            alt="Veloura Logo"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Veloura&background=6B3E4B&color=fff';"
                        >
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-normal tracking-[0.08em] uppercase text-[#6B3E4B] leading-none" style="font-family: 'Bodoni Moda', serif;">
                            Veloura
                        </h1>
                        <p class="text-[8px] tracking-[0.25em] text-[#8b686e] font-medium mt-1">
                            FEEL BEAUTIFUL, FEEL YOU
                        </p>
                    </div>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                @if(request()->routeIs('home') || request()->is('/'))
                    <a href="{{ url('/#home') }}" class="px-3 py-1.5 rounded-full transition {{ request()->is('/') || request()->routeIs('home') ? 'bg-[#6B3E4B] text-white' : 'text-gray-600 hover:text-[#6B3E4B]' }}">Home</a>
                    <a href="{{ url('/#services') }}" class="px-3 py-1.5 rounded-full transition text-gray-600 hover:text-[#6B3E4B]">Services</a>
                    <a href="{{ url('/#prices') }}" class="px-3 py-1.5 rounded-full transition text-gray-600 hover:text-[#6B3E4B]">Treatments</a>
                    <a href="{{ url('/#about') }}" class="px-3 py-1.5 rounded-full transition text-gray-600 hover:text-[#6B3E4B]">About Us</a>
                    <a href="{{ url('/#contact') }}" class="px-3 py-1.5 rounded-full transition text-gray-600 hover:text-[#6B3E4B]">Contact</a>
                @else
                    @auth
                        @if(strtolower(Auth::user()->role) === 'admin')
                            @if (Route::has('admin.dashboard'))
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-full transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#6B3E4B] text-white' : 'text-gray-600 hover:text-[#6B3E4B]' }}">Dashboard</a>
                            @endif
                            
                            @if (Route::has('admin.services.index'))
                                <a href="{{ route('admin.services.index') }}" class="px-3 py-1.5 rounded-full transition {{ request()->routeIs('admin.services.*') ? 'bg-[#6B3E4B] text-white' : 'text-gray-600 hover:text-[#6B3E4B]' }}">Layanan</a>
                            @endif

                            @if (Route::has('admin.staffs.index'))
                                <a href="{{ route('admin.staffs.index') }}" class="px-3 py-1.5 rounded-full transition {{ request()->routeIs('admin.staffs.*') ? 'bg-[#6B3E4B] text-white' : 'text-gray-600 hover:text-[#6B3E4B]' }}">Staff</a>
                            @endif

                            @if (Route::has('admin.bookings.index'))
                                <a href="{{ route('admin.bookings.index') }}" class="px-3 py-1.5 rounded-full transition {{ request()->routeIs('admin.bookings.*') ? 'bg-[#6B3E4B] text-white' : 'text-gray-600 hover:text-[#6B3E4B]' }}">Booking</a>
                            @endif


                            @if (Route::has('admin.reports.index'))
                                <a href="{{ route('admin.reports.index') }}" class="px-3 py-1.5 rounded-full transition {{ request()->routeIs('admin.reports.*') ? 'bg-[#6B3E4B] text-white' : 'text-gray-600 hover:text-[#6B3E4B]' }}">Laporan</a>
                            @endif
                        @endif
                    @endauth
                @endif
            </div>

            <div class="hidden md:flex items-center gap-3">
                @auth
                    <div class="relative">
                        <button 
                            @click="userMenuOpen = !userMenuOpen" 
                            @click.away="userMenuOpen = false"
                            type="button" 
                            class="flex items-center gap-2.5 py-1.5 px-3 rounded-full hover:bg-[#F7EFE9] transition duration-200 focus:outline-none"
                        >
                            <div class="w-9 h-9 rounded-full bg-[#6B3E4B] text-white flex items-center justify-center font-semibold text-sm shadow-sm shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-[#2D2D2D]">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': userMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div 
                            x-show="userMenuOpen" 
                            x-transition
                            x-cloak
                            class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-3 z-50 text-left overflow-hidden"
                        >
                            <div class="px-5 py-2">
                                <p class="font-bold text-[#1E293B] text-sm leading-tight truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 text-[10px] font-semibold px-2 py-0.5 rounded bg-[#F7EFE9] text-[#6B3E4B] uppercase">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                            <div class="border-t border-gray-100 my-1"></div>

                            @if(strtolower(Auth::user()->role) === 'admin')
                                @if(request()->routeIs('home') || request()->is('/'))
                                    @if(Route::has('admin.dashboard'))
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-2 text-sm font-medium text-gray-600 hover:bg-[#F7EFE9] hover:text-[#6B3E4B] transition">
                                            <i class="fa-solid fa-chart-line text-xs text-gray-400"></i> Admin Dashboard
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-5 py-2 text-sm font-medium text-gray-600 hover:bg-[#F7EFE9] hover:text-[#6B3E4B] transition">
                                        <i class="fa-solid fa-house text-xs text-gray-400"></i> Landing Page
                                    </a>
                                @endif
                            @else
                                @if(Route::has('customer.bookings.index'))
                                    <a href="{{ route('customer.bookings.index') }}" class="flex items-center gap-3 px-5 py-2 text-sm font-medium text-gray-600 hover:bg-[#F7EFE9] hover:text-[#6B3E4B] transition">
                                        <i class="fa-solid fa-calendar-check text-xs text-gray-400"></i> Riwayat Booking
                                    </a>
                                @endif
                            @endif

                            @if(Route::has('profile.edit'))
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2 text-sm font-medium text-gray-600 hover:bg-[#F7EFE9] hover:text-[#6B3E4B] transition">
                                    <i class="fa-solid fa-user text-xs text-gray-400"></i> Profile
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-5 py-2 text-sm font-medium text-rose-600 hover:bg-rose-50 transition text-left">
                                    <i class="fa-solid fa-right-from-bracket text-xs text-rose-500"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="border border-[#6B3E4B] text-[#6B3E4B] px-5 py-2 rounded-full text-sm font-medium hover:bg-[#6B3E4B] hover:text-white transition">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-[#6B3E4B] text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-[#542d39] transition shadow-sm">
                            Register
                        </a>
                    @endif
                @endauth
            </div>

            <button @click="open = !open" type="button" class="md:hidden p-2 rounded-lg text-[#6B3E4B] hover:bg-[#F7EFE9] focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak class="md:hidden bg-white border-b border-[#ead9d4] px-5 pt-4 pb-6 space-y-4 shadow-lg">
        <nav class="flex flex-col gap-1 font-medium text-sm">
            @if(request()->routeIs('home') || request()->is('/'))
                <a @click="open = false" href="{{ url('/#home') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Home</a>
                <a @click="open = false" href="{{ url('/#services') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Services</a>
                <a @click="open = false" href="{{ url('/#prices') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Treatments</a>
                <a @click="open = false" href="{{ url('/#about') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">About Us</a>
                <a @click="open = false" href="{{ url('/#contact') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Contact</a>
            @else
                @auth
                    @if(strtolower(Auth::user()->role) === 'admin')
                        @if (Route::has('admin.dashboard')) <a href="{{ route('admin.dashboard') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Dashboard</a> @endif
                        @if (Route::has('admin.services.index')) <a href="{{ route('admin.services.index') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Layanan</a> @endif
                        @if (Route::has('admin.staffs.index')) <a href="{{ route('admin.staffs.index') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Staff</a> @endif
                        @if (Route::has('admin.bookings.index')) <a href="{{ route('admin.bookings.index') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Booking</a> @endif
                        @if (Route::has('admin.staff-schedules.index')) <a href="{{ route('admin.staff-schedules.index') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Jadwal Staff</a> @endif
                        @if (Route::has('admin.operating-hours.index')) <a href="{{ route('admin.operating-hours.index') }}" class="py-2 px-3 rounded-lg hover:bg-[#F7EFE9]">Jam Operasional</a> @endif
                    @endif
                @endauth
            @endif
        </nav>

        <div class="pt-4 border-t border-gray-100 flex flex-col gap-2">
            @auth
                <div class="p-3 bg-[#F7EFE9] rounded-xl flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#6B3E4B] text-white flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="font-semibold text-sm text-[#2D2D2D] truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                @if(strtolower(Auth::user()->role) === 'admin')
                    @if(request()->routeIs('home') || request()->is('/'))
                        @if(Route::has('admin.dashboard'))
                            <a href="{{ route('admin.dashboard') }}" class="w-full text-center bg-[#6B3E4B] text-white py-2 rounded-full text-sm font-medium">Dashboard Admin</a>
                        @endif
                    @else
                        <a href="{{ route('home') }}" class="w-full text-center border border-[#6B3E4B] text-[#6B3E4B] py-2 rounded-full text-sm font-medium">Lihat Landing Page</a>
                    @endif
                @endif

                @if (Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}" class="w-full text-center border border-gray-200 py-2 rounded-full text-sm font-medium">Profile</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center bg-rose-50 border border-rose-200 text-rose-600 py-2 rounded-full text-sm font-medium">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full text-center border border-[#6B3E4B] text-[#6B3E4B] py-2.5 rounded-full text-sm font-medium">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="w-full text-center bg-[#6B3E4B] text-white py-2.5 rounded-full text-sm font-medium shadow-sm">Register</a>
                @endif
            @endauth
        </div>
    </div>
</nav>