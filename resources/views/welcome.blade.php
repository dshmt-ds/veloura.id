<x-app-layout>
    @slot('title', 'Welcome to Veloura Beauty Studio')

    <!-- HERO SECTION -->
    <section id="home" class="pt-[76px] min-h-[650px] overflow-hidden">
        <div class="max-w-7xl mx-auto px-5">
            <div class="grid lg:grid-cols-2 min-h-[620px] items-center gap-10">
                <div class="py-12 lg:py-20">
                    <p class="font-serif italic text-2xl text-[#A9787F] mb-3">
                        Welcome to Veloura <span class="text-[#D8B08C]">♡</span>
                    </p>
                    <h2 class="font-serif text-5xl md:text-6xl lg:text-7xl font-semibold leading-[1.05] text-[#6B3E4B]">
                        Feel Beautiful,
                        <span class="block text-[#A3485A]">Feel You.</span>
                    </h2>
                    <p class="mt-6 max-w-xl text-[#765e63] leading-7 text-sm md:text-base">
                        Discover a beauty experience made just for you. From hair styling and coloring to nails and relaxing treatments, Veloura is your sanctuary to look stunning and feel confident.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="#booking" class="bg-[#6B3E4B] text-white px-7 py-3.5 rounded-full text-sm font-medium hover:bg-[#542d39] transition shadow-lg shadow-[#6B3E4B]/20">
                            Book Now
                        </a>
                        <a href="#services" class="border border-[#6B3E4B] text-[#6B3E4B] px-7 py-3.5 rounded-full text-sm font-medium hover:bg-[#6B3E4B] hover:text-white transition">
                            Our Services
                        </a>
                    </div>
                </div>

                <div class="relative h-[480px] md:h-[560px] flex items-end justify-center">
                    <div class="absolute top-10 right-0 w-[320px] md:w-[400px] h-[420px] md:h-[500px] rounded-[45%_45%_10%_10%] bg-[#EFD4DA]"></div>
                    <img
                        src="https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=900&q=85"
                        alt="Veloura Beauty Treatment"
                        class="relative z-10 w-full max-w-[420px] md:max-w-[470px] h-[460px] md:h-[520px] object-cover rounded-[200px_200px_30px_30px] md:rounded-[230px_230px_30px_30px] shadow-2xl"
                    >
                    <div class="absolute bottom-5 -right-3 w-24 h-24 rounded-full bg-[#D8B08C]/80 blur-sm pointer-events-none"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION (SLIDER CATEGORIES) -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div>
                    <p class="uppercase tracking-[0.3em] text-xs text-[#D8B08C] font-semibold">What We Offer</p>
                    <h2 class="font-serif text-4xl md:text-5xl font-semibold mt-2">Our Services & Prices</h2>
                    <div class="w-16 h-[2px] bg-[#D8B08C] mt-4"></div>
                </div>

                <div class="flex items-center gap-3">
                    <button class="services-prev w-12 h-12 rounded-full border border-[#eadbd7] text-[#6B3E4B] flex items-center justify-center hover:bg-[#6B3E4B] hover:text-white transition duration-300">
                        &#x276E;
                    </button>
                    <button class="services-next w-12 h-12 rounded-full border border-[#eadbd7] text-[#6B3E4B] flex items-center justify-center hover:bg-[#6B3E4B] hover:text-white transition duration-300">
                        &#x276F;
                    </button>
                </div>
            </div>

            <div class="swiper services-swiper !pb-12">
                <div class="swiper-wrapper">
                    @forelse ($categories as $category)
                        <div class="swiper-slide h-auto">
                            <a href="#prices" class="group bg-[#F7EFE9] rounded-2xl overflow-hidden border border-[#eadbd7] hover:-translate-y-2 transition duration-300 shadow-sm hover:shadow-xl flex flex-col justify-between h-full">
                                <div>
                                    <div class="overflow-hidden h-52 bg-[#eadbd7]">
                                        <img
                                            src="{{ $category->image ? asset('storage/' . $category->image) : 'https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=700&q=80' }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                            alt="{{ $category->name }}"
                                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=700&q=80';"
                                        >
                                    </div>
                                    <div class="p-5">
                                        <span class="text-xs bg-[#6B3E4B] text-white px-2.5 py-1 rounded-full font-medium">
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <h3 class="font-serif text-xl font-semibold mt-3 text-gray-800 group-hover:text-[#A3485A] transition">
                                            {{ $category->name }}
                                        </h3>
                                        <p class="text-xs leading-5 text-gray-500 mt-2 line-clamp-3">
                                            {{ $category->description ?? 'Layanan perawatan terbaik untuk kebutuhan kecantikan Anda.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="px-5 pb-5 pt-2 flex items-center justify-between border-t border-[#eadbd7]/50 mt-2">
                                    @if(isset($category->services) && $category->services->count() > 0)
                                        <div class="text-xs font-semibold text-[#A3485A]">
                                            Rp {{ number_format($category->services->min('price'), 0, ',', '.') }} - Rp {{ number_format($category->services->max('price'), 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="text-xs font-medium text-[#A3485A]">
                                            Tersedia Berbagai Pilihan
                                        </div>
                                    @endif
                                    <span class="text-xs font-medium text-[#6B3E4B] group-hover:underline flex items-center gap-1">
                                        Lihat Menu &rarr;
                                    </span>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="swiper-slide text-center py-10 text-gray-500">
                            Belum ada kategori layanan yang tersedia saat ini.
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- FEATURED TREATMENTS & ALL SERVICES SECTION -->
    <section id="prices" class="py-20 bg-[#F7EFE9]" x-data="{ 
        activeCategory: 'all', 
        searchQuery: '',
        limit: 4,
        items: [],
        init() {
            this.$nextTick(() => { this.updateItems(); });
        },
        matches(catId, name) {
            const matchesCategory = this.activeCategory === 'all' || String(this.activeCategory) === String(catId);
            const matchesSearch = name.toLowerCase().includes(this.searchQuery.toLowerCase());
            return matchesCategory && matchesSearch;
        },
        get filteredCount() {
            let count = 0;
            this.items.forEach(item => {
                if (this.matches(item.catId, item.name)) count++;
            });
            return count;
        },
        updateItems() {
            const elements = this.$refs.servicesGrid ? Array.from(this.$refs.servicesGrid.children) : [];
            this.items = elements.map(el => ({
                catId: el.getAttribute('data-cat-id'),
                name: el.getAttribute('data-name') || ''
            }));
        },
        resetLimit() { this.limit = 4; }
    }">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <p class="uppercase tracking-[0.3em] text-xs text-[#D8B08C] font-semibold">Signature Offerings</p>
                <h2 class="font-serif text-4xl md:text-5xl font-semibold mt-2 text-[#6B3E4B]">Our Treatments & Services</h2>
                <p class="text-sm text-[#765e63] mt-3">Jelajahi seluruh layanan perawatan kecantikan terbaik kami.</p>
            </div>

            <!-- SEARCH & FILTER -->
            <div class="flex flex-col items-center gap-6 mb-12">
                <div class="relative w-full max-w-md">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        @input="resetLimit()"
                        placeholder="Cari perawatan kecantikan..." 
                        class="w-full pl-11 pr-4 py-3 rounded-full border border-[#eadbd7] bg-white text-sm text-[#6B3E4B] focus:outline-none focus:ring-2 focus:ring-[#D8B08C] shadow-sm transition"
                    >
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                    <button 
                        @click="activeCategory = 'all'; resetLimit()" 
                        :class="activeCategory === 'all' ? 'bg-[#6B3E4B] text-white shadow-md' : 'bg-white text-[#6B3E4B] hover:bg-[#F0E2D8] border border-[#eadbd7]'"
                        class="px-5 py-2.5 rounded-full text-xs md:text-sm font-medium transition-all duration-300"
                    >
                        Semua Layanan
                    </button>
                    @foreach ($categories as $cat)
                        <button 
                            @click="activeCategory = '{{ $cat->id }}'; resetLimit()" 
                            :class="String(activeCategory) === '{{ $cat->id }}' ? 'bg-[#6B3E4B] text-white shadow-md' : 'bg-white text-[#6B3E4B] hover:bg-[#F0E2D8] border border-[#eadbd7]'"
                            class="px-5 py-2.5 rounded-full text-xs md:text-sm font-medium transition-all duration-300"
                        >
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- SERVICES GRID -->
            <div x-ref="servicesGrid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($services as $service)
                    <div 
                        data-cat-id="{{ $service->service_category_id }}"
                        data-name="{{ $service->name }}"
                        x-show="matches('{{ $service->service_category_id }}', @js($service->name)) && (
                            (() => {
                                const grid = $el.parentElement;
                                const visibleChildren = Array.from(grid.children).filter(child => {
                                    return matches(child.getAttribute('data-cat-id'), child.getAttribute('data-name') || '');
                                });
                                return visibleChildren.indexOf($el) < limit;
                            })()
                        )"
                        class="bg-white rounded-3xl overflow-hidden border border-[#eadbd7] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group"
                    >
                        <div>
                            <div class="relative h-48 overflow-hidden bg-[#F7EFE9]">
                                <img 
                                    src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1605497788044-5a32c7078486?auto=format&fit=crop&w=800&q=80' }}" 
                                    alt="{{ $service->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1605497788044-5a32c7078486?auto=format&fit=crop&w=800&q=80';"
                                >
                                <span class="absolute top-4 left-4 bg-[#6B3E4B]/90 backdrop-blur-md text-white text-[10px] uppercase font-semibold px-3 py-1 rounded-full tracking-wider">
                                    {{ $service->category->name ?? 'General' }}
                                </span>
                                @if($service->duration)
                                    <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-[#6B3E4B] text-[10px] font-medium px-2.5 py-1 rounded-full shadow-sm">
                                        ⏱ {{ $service->duration }} Menit
                                    </span>
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="font-serif text-xl font-semibold text-[#6B3E4B] group-hover:text-[#A3485A] transition">
                                    {{ $service->name }}
                                </h3>
                                <p class="text-xs text-[#765e63] mt-2 leading-relaxed line-clamp-3">
                                    {{ $service->description ?? 'Nikmati perawatan khusus untuk kecantikan dan kenyamanan maksimal Anda.' }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-4 border-t border-[#F7EFE9] flex items-center justify-between">
                            <div>
                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-medium">Harga</p>
                                <p class="font-semibold text-[#A3485A] text-lg">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="#booking" class="inline-flex items-center gap-1 bg-[#6B3E4B] text-white text-xs font-medium px-4 py-2.5 rounded-full hover:bg-[#542d39] transition shadow-sm">
                                Book Now ➔
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        Belum ada layanan yang tersedia saat ini.
                    </div>
                @endforelse
            </div>

            <!-- LOAD MORE BUTTON -->
            <div x-show="limit < filteredCount" class="text-center mt-12">
                <button @click="limit += 4" class="inline-flex items-center gap-2 bg-[#6B3E4B] text-white px-8 py-3.5 rounded-full text-sm font-medium hover:bg-[#542d39] transition duration-300 shadow-md">
                    <span>More Services</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-5">
            <div class="text-center mb-12">
                <p class="uppercase tracking-[0.3em] text-xs text-[#D8B08C] font-semibold">Why Choose Us</p>
                <h2 class="font-serif text-4xl font-semibold mt-2">The Veloura Experience</h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 rounded-2xl bg-[#F7EFE9]">
                    <div class="text-3xl mb-4 text-[#6B3E4B]">✦</div>
                    <h3 class="font-semibold text-lg">Professional</h3>
                    <p class="text-xs text-gray-500 mt-2">Highly skilled and certified beauty specialists.</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-[#F7EFE9]">
                    <div class="text-3xl mb-4 text-[#6B3E4B]">♡</div>
                    <h3 class="font-semibold text-lg">Premium Products</h3>
                    <p class="text-xs text-gray-500 mt-2">Top-tier, dermatologically tested beauty products.</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-[#F7EFE9]">
                    <div class="text-3xl mb-4 text-[#6B3E4B]">✿</div>
                    <h3 class="font-semibold text-lg">Clean & Safe</h3>
                    <p class="text-xs text-gray-500 mt-2">Relaxing, clean, and fully sanitized environment.</p>
                </div>
                <div class="text-center p-6 rounded-2xl bg-[#F7EFE9]">
                    <div class="text-3xl mb-4 text-[#6B3E4B]">☆</div>
                    <h3 class="font-semibold text-lg">Client Satisfaction</h3>
                    <p class="text-xs text-gray-500 mt-2">Dedicated to making you feel comfortable and confident.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- BOOKING APPOINTMENT SECTION -->
    <section id="booking" class="py-20 bg-[#6B3E4B]">
        <div class="max-w-5xl mx-auto px-5">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <p class="uppercase tracking-[0.3em] text-xs text-[#D8B08C] font-semibold">Ready for your glow?</p>
                    <h2 class="font-serif text-4xl md:text-5xl font-semibold mt-3">
                        Book Your <span class="text-[#D8B08C]">Appointment</span>
                    </h2>
                    <p class="mt-5 text-white/70 leading-7 text-sm md:text-base">
                        Select your preferred service and date. Our team will handle the rest to make sure your session is effortless and rejuvenating.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-7 shadow-2xl">
                    <h3 class="font-serif text-2xl font-semibold mb-6 text-[#6B3E4B]">Make an Appointment</h3>

                    @auth
                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ Auth::id() }}">

                            <div>
                                <input type="text" value="{{ Auth::user()->name }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-gray-100 text-gray-500 cursor-not-allowed outline-none">
                            </div>
                            <div>
                                <input type="email" value="{{ Auth::user()->email }}" readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-gray-100 text-gray-500 cursor-not-allowed outline-none">
                            </div>
                            <div>
                                <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="WhatsApp / Phone Number" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#D8B08C] outline-none">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Layanan</label>
                                <select name="services[]" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-white cursor-pointer">
                                    <option value="" disabled selected>Pilih Layanan Perawatan</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Staff / Terapis</label>
                                <select name="staff_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-white cursor-pointer">
                                    <option value="" disabled selected>Pilih Staff</option>
                                    @foreach ($staffs as $person)
                                        <option value="{{ $person->id }}">{{ $person->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal</label>
                                    <input type="date" name="booking_date" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jam</label>
                                    <input type="time" name="booking_time" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm">
                                </div>
                            </div>

                            <div>
                                <textarea name="customer_notes" rows="2" placeholder="Catatan tambahan (opsional)" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm">{{ old('customer_notes') }}</textarea>
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-xl bg-[#6B3E4B] text-white font-medium hover:bg-[#542d39] transition shadow-md mt-2">
                                Book Appointment
                            </button>
                        </form>
                    @else
                        <div class="text-center py-8 px-4 border-2 border-dashed border-[#ead9d4] rounded-2xl bg-[#F7EFE9]/50">
                            <div class="w-16 h-16 bg-[#6B3E4B]/10 rounded-full flex items-center justify-center mx-auto mb-4 text-[#6B3E4B]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h4 class="font-serif text-xl font-semibold text-[#6B3E4B]">Login Diperlukan</h4>
                            <p class="text-xs text-[#765e63] mt-2 max-w-xs mx-auto">
                                Silakan masuk ke akun Anda terlebih dahulu untuk melakukan reservasi perawatan kecantikan.
                            </p>
                            <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-[#6B3E4B] text-white px-6 py-3 rounded-xl text-sm font-medium hover:bg-[#542d39] transition shadow-md">
                                    Login Sekarang
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center border border-[#6B3E4B] text-[#6B3E4B] px-6 py-3 rounded-xl text-sm font-medium hover:bg-[#6B3E4B] hover:text-white transition">
                                        Daftar Akun
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="py-16 bg-[#F7EFE9]">
        <div class="max-w-7xl mx-auto px-5 grid md:grid-cols-3 gap-10">
            <div>
                <h3 class="font-serif text-2xl font-semibold">Contact Us</h3>
                <div class="mt-5 space-y-3 text-sm text-gray-600">
                    <p>☎ +62 21 1234567</p>
                    <p>💬 WhatsApp: +62 812 1234 5678</p>
                    <p>📍 Jakarta, Indonesia</p>
                    <p>📷 Instagram: @velourabeauty</p>
                </div>
            </div>

            <div>
                <h3 class="font-serif text-2xl font-semibold">Opening Hours</h3>
                <div class="mt-5 space-y-3 text-sm text-gray-600">
                    <p><strong>Monday - Saturday</strong><br> 08:00 AM - 08:00 PM</p>
                    <p><strong>Sunday</strong><br> 10:00 AM - 06:00 PM</p>
                </div>
            </div>

            <div class="bg-[#6B3E4B] rounded-3xl p-7 text-white shadow-md">
                <p class="text-xs text-[#D8B08C] uppercase tracking-wider">Your beauty moment</p>
                <h3 class="font-serif text-2xl font-semibold mt-2">Ready to Glow?</h3>
                <p class="text-sm text-white/70 mt-2">Reserve your slot today and treat yourself.</p>
                <a href="#booking" class="inline-block mt-5 bg-white text-[#6B3E4B] px-6 py-3 rounded-full text-sm font-semibold hover:bg-[#F7EFE9] transition">
                    Book Now
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.services-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                grabCursor: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.services-next', prevEl: '.services-prev' },
                breakpoints: {
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 4, spaceBetween: 24 },
                },
            });
        });
    </script>
    @endpush
</x-app-layout>