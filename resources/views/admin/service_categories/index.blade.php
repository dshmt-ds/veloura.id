@section('title', 'Kategori Layanan')

<x-app-layout>
    <div class="w-full min-h-screen bg-[#F8FAFC] text-slate-700 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Header Section -->
            <div class="flex flex-row items-center justify-between gap-4 border-b border-slate-200/80 pb-5 w-full">
                <div class="text-left">
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                        Kategori Layanan
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola kategori layanan salon Veloura.
                    </p>
                </div>

                <!-- Action Buttons Top Right -->
                <div class="flex items-center gap-2.5 shrink-0">
                    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2 rounded-xl text-sm font-medium shadow-xs transition">
                        <i class="fa-solid fa-list text-xs text-[#6B3E4B]"></i>
                        <span>Daftar Layanan</span>
                    </a>
                    <a href="{{ route('admin.service-categories.create') }}" class="inline-flex items-center gap-2 bg-[#6B3E4B] hover:bg-[#542d39] text-white px-4 py-2 rounded-xl text-sm font-medium shadow-xs transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Kategori</span>
                    </a>
                </div>
            </div>

            <!-- 2. Status Navigation Tabs & Filter Bar -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-200 pb-2 w-full">
                
                <!-- Status Tabs -->
                <div class="flex items-center gap-4 sm:gap-6 text-sm font-medium shrink-0">
                    <a href="{{ route('admin.service-categories.index', request()->except('status')) }}" 
                       class="pb-2 border-b-2 {{ !request()->has('status') ? 'border-[#6B3E4B] text-[#6B3E4B] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                        Semua Kategori
                    </a>
                    <a href="{{ route('admin.service-categories.index', array_merge(request()->query(), ['status' => '1'])) }}" 
                       class="pb-2 border-b-2 {{ request('status') === '1' ? 'border-[#6B3E4B] text-[#6B3E4B] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                        Aktif
                    </a>
                    <a href="{{ route('admin.service-categories.index', array_merge(request()->query(), ['status' => '0'])) }}" 
                       class="pb-2 border-b-2 {{ request('status') === '0' ? 'border-[#6B3E4B] text-[#6B3E4B] font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }} transition">
                        Nonaktif
                    </a>
                </div>

                <!-- Controls Form Toolbar -->
                <form method="GET" action="{{ route('admin.service-categories.index') }}" class="flex items-center justify-end gap-2 flex-wrap shrink-0 w-full md:w-auto">
                    @if(request()->has('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <!-- Search Input -->
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari kategori..."
                               class="w-36 sm:w-52 rounded-xl border border-slate-200 bg-white pl-9 pr-3 py-1.5 text-sm text-slate-800 focus:border-[#6B3E4B] focus:outline-none transition shadow-xs">
                    </div>

                    <button type="submit" class="px-4 py-1.5 rounded-xl bg-slate-800 text-white text-sm font-medium hover:bg-slate-700 transition">
                        Cari
                    </button>

                    @if(request('search') || request()->has('status'))
                        <a href="{{ route('admin.service-categories.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-medium hover:bg-slate-200 transition">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- 3. Table Container -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-x-auto w-full">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-semibold uppercase tracking-wider">
                            <th class="px-4 py-4 w-14 text-center">NO.</th>
                            <th class="px-4 py-4 w-48">NAMA KATEGORI</th>
                            <th class="px-4 py-4 w-36">SLUG</th>
                            <th class="px-4 py-4">DESKRIPSI</th>
                            <th class="px-4 py-4 w-32 text-center">STATUS</th>
                            <th class="px-4 py-4 w-36 text-center bg-slate-100/80 font-bold text-slate-700">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3.5 text-slate-400 font-medium text-center whitespace-nowrap">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>
                                
                                <td class="px-4 py-3.5 whitespace-nowrap font-semibold text-slate-900">
                                    {{ $category->name }}
                                </td>

                                <td class="px-4 py-3.5 text-slate-500 font-mono text-xs whitespace-nowrap">
                                    {{ $category->slug }}
                                </td>

                                <td class="px-4 py-3.5 text-slate-600 align-top">
                                    <p class="text-xs text-slate-500 whitespace-normal break-words leading-relaxed">
                                        {{ $category->description ?: '-' }}
                                    </p>
                                </td>

                                <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                    @if ($category->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <!-- Kolom Aksi -->
                                <td class="px-4 py-3.5 text-center whitespace-nowrap bg-slate-50/30">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.service-categories.edit', $category) }}" 
                                           class="px-2 py-1 bg-[#F7EFE9] text-[#6B3E4B] hover:bg-[#efe3de] rounded-md text-xs font-medium transition inline-flex items-center gap-1" 
                                           title="Edit Kategori">
                                            <i class="fa-solid fa-light fa-square-pen"></i>
                                            <span>Edit</span>
                                        </a>

                                        <form id="delete-form-{{ $category->id }}" method="POST" action="{{ route('admin.service-categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    onclick="confirmDelete({{ $category->id }}, '{{$category->name }}')" 
                                                    class="px-2 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-md text-xs font-medium transition inline-flex items-center gap-1" 
                                                    title="Hapus Kategori">
                                                <i class="fa-solid fa-trash"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <div class="max-w-xs mx-auto flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3 text-slate-400">
                                            <i class="fa-solid fa-layer-group text-lg"></i>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-800">Belum ada kategori layanan</p>
                                        <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau tambah kategori baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 4. Footer Pagination Info -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-medium">
                <div>
                    Menampilkan data {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} dari {{$categories->total() }} kategori
                </div>
                <div>
                    @if ($categories->hasPages())
                        {{ $categories->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#6B3E4B',
                confirmButtonText: 'Selesai',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl text-sm font-medium px-5 py-2.5'
                }
            });
        @endif

        function confirmDelete(categoryId, categoryName) {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: `Kategori "${categoryName}" akan dihapus secara permanen.`,
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
                    document.getElementById(`delete-form-${categoryId}`).submit();
                }
            });
        }
    </script>
</x-app-layout>