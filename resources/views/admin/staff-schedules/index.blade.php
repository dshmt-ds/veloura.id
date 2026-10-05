@section('title', 'Jadwal Staff')

<x-app-layout>
    <div class="w-full min-h-screen bg-[#F8FAFC] text-slate-700 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-slate-900">
                        Jadwal Staff
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Kelola jam kerja dan shift staff Veloura.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @if (Route::has('admin.staffs.index'))
                        <a
                            href="{{ route('admin.staffs.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#E5C099] hover:bg-[#D9AE82] text-[#6B3F35] text-sm font-medium transition"
                        >
                            <i class="fa-solid fa-list text-xs text-[#6B3F35]"></i>
                            <span>Daftar Staff</span>
                        </a>
                    @endif

                    <a
                        href="{{ route('admin.staff-schedules.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#6B3F35] hover:bg-[#573229] text-white text-sm font-semibold transition shadow-sm"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Jadwal</span>
                    </a>
                </div>
            </div>

            <div class="border-b border-slate-200"></div>

            {{-- TABS & SEARCH/FILTER BAR --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 py-4 border-b border-slate-200">

                {{-- FILTER TABS (JADWAL TANGGAL) --}}
                <div class="flex items-center gap-6 text-sm overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    <a
                        href="{{ route('admin.staff-schedules.index', request()->except('schedule_date', 'page')) }}"
                        class="relative py-2 whitespace-nowrap {{ !request('schedule_date') ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Semua Jadwal
                        @if (!request('schedule_date'))
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.staff-schedules.index', array_merge(request()->except('page'), ['schedule_date' => now()->toDateString()])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('schedule_date') === now()->toDateString() ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Hari Ini
                        @if (request('schedule_date') === now()->toDateString())
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>
                </div>

                {{-- SEARCH + FILTER + SORT FORM --}}
                <form
                    action="{{ route('admin.staff-schedules.index') }}"
                    method="GET"
                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full lg:w-auto"
                >
                    @if (request('schedule_date'))
                        <input type="hidden" name="schedule_date" value="{{ request('schedule_date') }}">
                    @endif

                    {{-- Search Input --}}
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari staff / catatan..."
                            class="w-full sm:w-44 lg:w-48 h-10 pl-9 pr-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none"
                        >
                    </div>

                    {{-- Filter Staff --}}
                    <div class="relative">
                        <i class="fa-solid fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                        <select
                            name="staff_id"
                            onchange="this.form.submit()"
                            class="w-full sm:w-48 h-10 pl-9 pr-9 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 appearance-none focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none cursor-pointer"
                        >
                            <option value="">Filter Staff</option>
                            @foreach ($staffs as $staff)
                                <option
                                    value="{{ $staff->id }}"
                                    @selected(request('staff_id') == $staff->id)
                                >
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Sort Dropdown --}}
                    <div class="relative">
                        <i class="fa-solid fa-arrow-down-wide-short absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="w-full sm:w-44 h-10 pl-9 pr-9 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 appearance-none focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none cursor-pointer"
                        >
                            <option value="date_desc" @selected(request('sort', 'date_desc') === 'date_desc')>Sort: Terbaru</option>
                            <option value="date_asc" @selected(request('sort') === 'date_asc')>Sort: Terlama</option>
                            <option value="staff_name_asc" @selected(request('sort') === 'staff_name_asc')>Staff: A-Z</option>
                            <option value="oldest" @selected(request('sort') === 'oldest')>Pertama Dibuat</option>
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
                    <table class="w-full min-w-[800px] text-sm">
                        <thead>
                            <tr class="bg-[#F8FAFC] border-b border-slate-200">
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Staff
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Tanggal
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Jam Kerja
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Catatan
                                </th>
                                <th class="px-4 py-3.5 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($schedules as $schedule)
                                <tr class="hover:bg-slate-50/70 transition">
                                    {{-- Staff Info --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 shrink-0 rounded-xl bg-[#F7EFE9] border border-[#EFE1D8] flex items-center justify-center">
                                                <span class="text-sm font-semibold text-[#6B3F35]">
                                                    {{ strtoupper(substr($schedule->staff->name ?? 'S', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-slate-800 truncate">
                                                    {{ $schedule->staff->name ?? 'Staff Tidak Ditemukan' }}
                                                </p>
                                                <p class="text-xs text-slate-400 mt-0.5">
                                                    {{ $schedule->staff->phone ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-4 py-4 text-slate-700 whitespace-nowrap">
                                        <span class="font-medium">
                                            {{ $schedule->schedule_date ? \Carbon\Carbon::parse($schedule->schedule_date)->translatedFormat('d M Y') : '-' }}
                                        </span>
                                    </td>

                                    {{-- Jam Kerja --}}
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#F7EFE9] text-[#6B3F35] text-xs font-semibold">
                                            <i class="fa-regular fa-clock text-xs"></i>
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </span>
                                    </td>

                                    {{-- Catatan --}}
                                    <td class="px-4 py-4 text-slate-600">
                                        {{ $schedule->note ?? ($schedule->notes ?? '-') }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a
                                                href="{{ route('admin.staff-schedules.edit', $schedule) }}"
                                                title="Edit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                            >
                                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                                            </a>

                                            <form
                                                id="delete-form-{{ $schedule->id }}"
                                                action="{{ route('admin.staff-schedules.destroy', $schedule) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('{{ $schedule->id }}', '{{$schedule->staff->name ?? 'Staff' }}')"
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
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i class="fa-regular fa-calendar-days text-slate-400 text-xl"></i>
                                            </div>
                                            <p class="font-medium text-slate-700">Belum ada jadwal staff</p>
                                            <p class="text-sm text-slate-400 mt-1">Tambahkan jadwal untuk mengatur kerja staff.</p>
                                            <a
                                                href="{{ route('admin.staff-schedules.create') }}"
                                                class="mt-4 px-4 py-2 rounded-xl bg-[#6B3F35] text-white text-sm font-medium hover:bg-[#573229] transition"
                                            >
                                                <i class="fa-solid fa-plus mr-1"></i> Tambah Jadwal
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            @if ($schedules->total() > 0)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-5">
                    <p class="text-xs text-slate-500">
                        Menampilkan
                        <span class="font-medium text-slate-700">{{ $schedules->firstItem() }}</span>
                        -
                        <span class="font-medium text-slate-700">{{ $schedules->lastItem() }}</span>
                        dari
                        <span class="font-medium text-slate-700">{{ $schedules->total() }}</span>
                        jadwal
                    </p>

                    <div>
                        {{ $schedules->onEachSide(1)->links() }}
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

    {{-- JAVASCRIPT DELETE CONFIRMATION --}}
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Jadwal untuk staff "${name}" akan dihapus!`,
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
    </script>
</x-app-layout>