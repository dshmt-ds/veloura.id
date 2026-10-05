@section('title', 'Kelola Staff')

<x-app-layout>
    <div class="w-full min-h-screen bg-[#F8FAFC] text-slate-700 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-slate-900">
                        Kelola Staff
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Lihat dan kelola semua staff Veloura.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @if (Route::has('admin.services.index'))
                        <a
                            href="{{ route('admin.services.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#E5C099] hover:bg-[#D9AE82] text-[#6B3F35] text-sm font-medium transition"
                        >
                            <i class="fa-solid fa-layer-group text-xs"></i>
                            <span>Layanan</span>
                        </a>
                    @endif

                    @if (Route::has('admin.staff-schedules.index'))
                        <a
                            href="{{ route('admin.staff-schedules.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#E5C099] hover:bg-[#D9AE82] text-[#6B3F35] text-sm font-medium transition"
                        >
                            <i class="fa-regular fa-calendar-days text-xs"></i>
                            <span>Jadwal Staff</span>
                        </a>
                    @endif

                    <a
                        href="{{ route('admin.staffs.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#6B3F35] hover:bg-[#573229] text-white text-sm font-semibold transition shadow-sm"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Staff</span>
                    </a>
                </div>
            </div>

            <div class="border-b border-slate-200"></div>

            {{-- TABS & SEARCH/FILTER BAR --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 py-4 border-b border-slate-200">

                {{-- STATUS TABS --}}
                <div class="flex items-center gap-6 text-sm overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    <a
                        href="{{ route('admin.staffs.index', request()->except('status', 'page')) }}"
                        class="relative py-2 whitespace-nowrap {{ !request('status') ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Semua Staff
                        @if (!request('status'))
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.staffs.index', array_merge(request()->except('page'), ['status' => 'active'])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('status') === 'active' ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Staff Aktif
                        @if (request('status') === 'active')
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.staffs.index', array_merge(request()->except('page'), ['status' => 'inactive'])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('status') === 'inactive' ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Nonaktif
                        @if (request('status') === 'inactive')
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>
                </div>

                {{-- SEARCH + FILTER + SORT FORM --}}
                <form
                    action="{{ route('admin.staffs.index') }}"
                    method="GET"
                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full lg:w-auto"
                >
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama / telepon..."
                            class="w-full sm:w-44 lg:w-48 h-10 pl-9 pr-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none"
                        >
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                        <select
                            name="service_id"
                            onchange="this.form.submit()"
                            class="w-full sm:w-48 h-10 pl-9 pr-9 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 appearance-none focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none cursor-pointer"
                        >
                            <option value="">Filter Layanan</option>
                            @foreach ($services as $service)
                                <option
                                    value="{{ $service->id }}"
                                    @selected(request('service_id') == $service->id)
                                >
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-arrow-down-wide-short absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="w-full sm:w-44 h-10 pl-9 pr-9 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 appearance-none focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none cursor-pointer"
                        >
                            <option value="latest" @selected(request('sort', 'latest') === 'latest')>Sort: Terbaru</option>
                            <option value="oldest" @selected(request('sort') === 'oldest')>Sort: Terlama</option>
                            <option value="name_asc" @selected(request('sort') === 'name_asc')>Nama: A-Z</option>
                            <option value="name_desc" @selected(request('sort') === 'name_desc')>Nama: Z-A</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>

                    <button
                        type="submit"
                        class="h-10 px-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium transition"
                    >
                        Cari
                    </button>
                </form>
            </div>

            {{-- TABLE SECTION --}}
            <div class="mt-5 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-sm">
                        <thead>
                            <tr class="bg-[#F8FAFC] border-b border-slate-200">
                                <th class="w-12 px-4 py-3.5 text-center">
                                    <input
                                        type="checkbox"
                                        id="selectAll"
                                        class="w-4 h-4 rounded border-slate-300 text-[#6B3F35] focus:ring-[#6B3F35]"
                                    >
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Staff
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    No. Telepon
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Layanan
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>
                                <th class="px-4 py-3.5 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($staffs as $staff)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-4 text-center">
                                        <input
                                            type="checkbox"
                                            name="selected_staff[]"
                                            value="{{ $staff->id }}"
                                            class="staff-checkbox w-4 h-4 rounded border-slate-300 text-[#6B3F35] focus:ring-[#6B3F35]"
                                        >
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3 min-w-[230px]">
                                            <div class="w-10 h-10 shrink-0 rounded-xl bg-[#F7EFE9] border border-[#EFE1D8] flex items-center justify-center">
                                                <span class="text-sm font-semibold text-[#6B3F35]">
                                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-slate-800 truncate">
                                                    {{ $staff->name }}
                                                </p>
                                                <p class="text-xs text-slate-400 mt-0.5">
                                                    Staff Veloura
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                                        {{ $staff->phone ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-1.5 max-w-[300px]">
                                            @forelse ($staff->services->take(3) as $service)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#F7EFE9] text-[#6B3F35] text-xs font-medium">
                                                    {{ $service->name }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-slate-400">Belum ada layanan</span>
                                            @endforelse

                                            @if ($staff->services->count() > 3)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-100 text-slate-500 text-xs font-medium">
                                                    +{{ $staff->services->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-4 py-4">
                                        @if ($staff->is_active)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-green-200 bg-green-50 text-green-700 text-xs font-medium">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-500 text-xs font-medium">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a
                                                href="{{ route('admin.staffs.show', $staff) }}"
                                                title="Detail"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-[#6B3F35] hover:bg-[#F7EFE9] transition"
                                            >
                                                <i class="fa-regular fa-eye text-sm"></i>
                                            </a>

                                            <a
                                                href="{{ route('admin.staffs.edit', $staff) }}"
                                                title="Edit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                            >
                                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                                            </a>

                                            <form
                                                id="delete-form-{{ $staff->id }}"
                                                action="{{ route('admin.staffs.destroy', $staff) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('{{ $staff->id }}', '{{$staff->name }}')"
                                                    title="Hapus"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition"
                                                >
                                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i class="fa-solid fa-users text-slate-400 text-xl"></i>
                                            </div>
                                            <p class="font-medium text-slate-700">Belum ada staff</p>
                                            <p class="text-sm text-slate-400 mt-1">Tambahkan staff untuk mulai mengelola data.</p>
                                            <a
                                                href="{{ route('admin.staffs.create') }}"
                                                class="mt-4 px-4 py-2 rounded-xl bg-[#6B3F35] text-white text-sm font-medium hover:bg-[#573229] transition"
                                            >
                                                <i class="fa-solid fa-plus mr-1"></i> Tambah Staff
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER / PAGINATION --}}
            @if ($staffs->total() > 0)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-5">
                    <p class="text-xs text-slate-500">
                        Menampilkan
                        <span class="font-medium text-slate-700">{{ $staffs->firstItem() }}</span>
                        -
                        <span class="font-medium text-slate-700">{{ $staffs->lastItem() }}</span>
                        dari
                        <span class="font-medium text-slate-700">{{ $staffs->total() }}</span>
                        staff
                    </p>

                    <div>
                        {{ $staffs->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SWEETALERT NOTIFICATION --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                });
            });
        </script>
    @endif

    {{-- JAVASCRIPT --}}
    <script>
        // SweetAlert Delete Confirmation
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data staff "${name}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6B3F35',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'px-4 py-2 rounded-xl font-medium',
                    cancelButton: 'px-4 py-2 rounded-xl font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }

        // Checkbox Select All
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.staff-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = selectAll.checked;
                    });
                });
            }

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const checkedCount = document.querySelectorAll('.staff-checkbox:checked').length;
                    
                    if (selectAll) {
                        selectAll.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
                        selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
                    }
                });
            });
        });
    </script>
</x-app-layout>