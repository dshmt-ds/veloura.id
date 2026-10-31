@section('title', 'Kelola Layanan')

<x-app-layout>
    <div class="w-full min-h-screen bg-white text-slate-700 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200/80 pb-5 w-full">
                <div class="text-left">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Kelola Layanan
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola daftar layanan yang tersedia di Indah Salon.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <a href="{{ route('admin.service-categories.index') }}" class="inline-flex items-center gap-2 bg-[#D8B08C] hover:bg-[#F7EFE9] text-[#6B3E4B] border border-[#D8B08C] hover:text-[#6B3E4B] px-4 py-2 rounded-xl text-sm font-medium shadow-xs transition">
                        <i class="fa-solid fa-layer-group text-xs  text-[#6B3E4B]"></i>
                        <span>Kategori Layanan</span>
                    </a>
                    <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 bg-[#6B3E4B] hover:bg-[#542d39] text-white px-4 py-2 rounded-xl text-sm font-medium shadow-xs transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Layanan</span>
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div id="service-success-alert" role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ([
                    ['Total Layanan', number_format($totalServices, 0, ',', '.')],
                    ['Layanan Aktif', number_format($activeServices, 0, ',', '.')],
                    ['Layanan Nonaktif', number_format($inactiveServices, 0, ',', '.')],
                    ['Rata-rata Harga Layanan Aktif', 'Rp ' . number_format($averagePrice, 0, ',', '.')],
                ] as [$label, $value])
                    <div class="bg-[#F7EFE9] border border-slate-200 rounded-2xl p-5">
                        <p class="text-xs text-slate-500">{{ $label }}</p>
                        <p class="text-2xl font-semibold text-[#6B3E4B] mt-2">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <!-- 2. Status Navigation Tabs & Filter Bar -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-200 pb-2 w-full">
                
                <!-- Status Tabs -->
                <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm font-medium">
                    <a href="{{ route('admin.services.index', request()->except(['status', 'page'])) }}" 
                       class="pb-2 border-b-2 {{ !request('status') ? 'border-[#6B3E4B] text-[#6B3E4B] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                        Semua Layanan
                    </a>
                    <a href="{{ route('admin.services.index', array_merge(request()->except('page'), ['status' => 'active'])) }}" 
                       class="pb-2 border-b-2 {{ request('status') === 'active' ? 'border-[#6B3E4B] text-[#6B3E4B] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                        Layanan Aktif
                    </a>
                    <a href="{{ route('admin.services.index', array_merge(request()->except('page'), ['status' => 'inactive'])) }}" 
                       class="pb-2 border-b-2 {{ request('status') === 'inactive' ? 'border-[#6B3E4B] text-[#6B3E4B] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                        Nonaktif
                    </a>
                </div>

                <!-- Controls Form Toolbar -->
                <form method="GET" action="{{ route('admin.services.index') }}" class="flex items-center gap-2 flex-wrap w-full md:w-auto">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <!-- Search Input -->
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-xs text-slate-400"></i>
                        </span>
                        <input type="text"
                               name="search"
                               aria-label="Cari layanan"
                               value="{{ request('search') }}"
                               placeholder="Cari..."
                               class="w-36 sm:w-52 rounded-xl border border-slate-200 bg-white pl-9 pr-3 py-1.5 text-sm text-slate-800 focus:border-[#6B3E4B] focus:outline-none transition shadow-xs">
                    </div>

                    <!-- Filter Category Dropdown -->
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-slate-500 pointer-events-none">
                            <i class="fa-solid fa-filter text-xs text-slate-500"></i>
                        </span>
                        <select name="category" aria-label="Filter kategori" onchange="this.form.submit()" class="bg-white border border-slate-200 text-slate-700 text-sm font-medium py-1.5 pl-8 pr-7 rounded-xl shadow-xs focus:outline-none focus:border-[#6B3E4B] cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @selected(request('category') === $category)>{{$category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-slate-500 pointer-events-none">
                            <i class="fa-solid fa-arrow-down-wide-short text-xs text-slate-500"></i>
                        </span>
                        <select name="sort" aria-label="Urutkan layanan" onchange="this.form.submit()" class="bg-white border border-slate-200 text-slate-700 text-sm font-medium py-1.5 pl-8 pr-7 rounded-xl shadow-xs focus:outline-none focus:border-[#6B3E4B] cursor-pointer">
                            <option value="latest" @selected(request('sort', 'latest') === 'latest')>Urutkan: Terbaru</option>
                            <option value="name_asc" @selected(request('sort') === 'name_asc')>Nama A-Z</option>
                            <option value="name_desc" @selected(request('sort') === 'name_desc')>Nama Z-A</option>
                            <option value="price_low" @selected(request('sort') === 'price_low')>Harga Terendah</option>
                            <option value="price_high" @selected(request('sort') === 'price_high')>Harga Tertinggi</option>
                            <option value="duration_low" @selected(request('sort') === 'duration_low')>Durasi Terpendek</option>
                            <option value="duration_high" @selected(request('sort') === 'duration_high')>Durasi Terpanjang</option>
                        </select>
                    </div>
                    <button type="submit" class="rounded-xl bg-[#6B3E4B] hover:bg-[#542d39] px-4 py-2 text-xs font-medium text-white">Cari</button>
                    <a href="{{ route('admin.services.index') }}" class="px-3 py-2 text-xs text-slate-500 hover:text-[#6B3E4B]">Atur Ulang</a>
                </form>
            </div>

            <!-- 3. Table Container -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden text-left">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                                <th class="pl-6 pr-3 py-3.5 w-10">
                                    No.
                                </th>
                                <th class="px-4 py-3.5">Nama Layanan</th>
                                <th class="px-4 py-3.5">Kategori</th>
                                <th class="px-4 py-3.5">Harga</th>
                                <th class="px-4 py-3.5">Durasi</th>
                                <th class="px-4 py-3.5">Status</th>
                                <th class="pr-6 pl-4 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($services as $service)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="pl-6 pr-3 py-4">
                                        {{ $services->firstItem() + $loop->index }}
                                    </td>
                                    
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3 text-left">
                                            <div class="w-8 h-8 rounded-lg bg-[#F7EFE9] border border-[#EFE3DE] flex items-center justify-center font-bold text-[#6B3E4B] text-xs shrink-0">
                                                {{ mb_strtoupper(mb_substr($service->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-900">{{ $service->name }}</p>
                                                @if($service->description)
                                                    <p class="text-xs text-slate-400 max-w-xs truncate">{{ $service->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                                        {{ $service->category }}
                                    </td>

                                    <td class="px-4 py-4 font-medium text-slate-900 whitespace-nowrap">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                                        {{ $service->duration }} Menit
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($service->status === 'active')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="pr-6 pl-4 py-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center justify-end gap-1">
                                            <a href="{{ route('admin.services.edit', $service) }}" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form id="delete-form-{{ $service->id }}" method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" data-service-id="{{ $service->id }}" data-service-name="{{ $service->name }}" onclick="confirmDelete(this.dataset.serviceId, this.dataset.serviceName)" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                        <div class="max-w-xs mx-auto flex flex-col items-center">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-800">Layanan Tidak Ditemukan</p>
                                            <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci atau filter pencarian Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. Footer Pagination Info -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-medium">
                <div>
                    Menampilkan data {{ $services->firstItem() ?? 0 }} - {{ $services->lastItem() ?? 0 }} dari {{$services->total() }} layanan
                </div>
                <div>
                    @if($services->hasPages())
                        {{ $services->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div id="service-notification" data-success="{{ session('success') }}" hidden></div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const successMessage = document.getElementById('service-notification').dataset.success;
        const successAlert = document.getElementById('service-success-alert');

        if (successAlert) {
            window.setTimeout(() => successAlert.remove(), 3000);
        }

        if (successMessage && typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                timer: 3000,
                timerProgressBar: true,
                confirmButtonColor: '#6B3E4B',
                confirmButtonText: 'Selesai',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl text-sm font-medium px-5 py-2.5'
                }
            });
        }

        function confirmDelete(serviceId, serviceName) {
            if (typeof Swal === 'undefined') {
                if (window.confirm(`Hapus layanan "${serviceName}" secara permanen?`)) {
                    document.getElementById(`delete-form-${serviceId}`).submit();
                }
                return;
            }

            Swal.fire({
                title: 'Hapus Layanan?',
                text: `Layanan "${serviceName}" akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl text-sm font-medium px-4 py-2.5',
                    cancelButton: 'rounded-xl text-sm font-medium px-4 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${serviceId}`).submit();
                }
            });
        }
    </script>
</x-app-layout>
