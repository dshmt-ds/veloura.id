@section('title', 'Kelola Booking')

<x-app-layout>
    <div class="w-full min-h-screen bg-[#F8FAFC] text-slate-700 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-slate-900">
                        Kelola Booking
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Lihat dan kelola seluruh jadwal booking pelanggan Veloura.
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

                    @if (Route::has('admin.staffs.index'))
                        <a
                            href="{{ route('admin.staffs.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#E5C099] hover:bg-[#D9AE82] text-[#6B3F35] text-sm font-medium transition"
                        >
                            <i class="fa-solid fa-user-tie text-xs"></i>
                            <span>Staff</span>
                        </a>
                    @endif

                    <a
                        href="{{ route('admin.bookings.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#6B3F35] hover:bg-[#573229] text-white text-sm font-semibold transition shadow-sm"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Booking</span>
                    </a>
                </div>
            </div>

            <div class="border-b border-slate-200"></div>

            {{-- TABS & SEARCH/FILTER BAR --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 py-4 border-b border-slate-200">

                {{-- STATUS TABS --}}
                <div class="flex items-center gap-6 text-sm overflow-x-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    <a
                        href="{{ route('admin.bookings.index', request()->except('status', 'page')) }}"
                        class="relative py-2 whitespace-nowrap {{ !request('status') ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Semua Booking
                        @if (!request('status'))
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.bookings.index', array_merge(request()->except('page'), ['status' => 'pending_payment'])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('status') === 'pending_payment' ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Pending Payment
                        @if (request('status') === 'pending_payment')
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.bookings.index', array_merge(request()->except('page'), ['status' => 'confirmed'])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('status') === 'confirmed' ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Confirmed
                        @if (request('status') === 'confirmed')
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.bookings.index', array_merge(request()->except('page'), ['status' => 'completed'])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('status') === 'completed' ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Completed
                        @if (request('status') === 'completed')
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>

                    <a
                        href="{{ route('admin.bookings.index', array_merge(request()->except('page'), ['status' => 'cancelled'])) }}"
                        class="relative py-2 whitespace-nowrap {{ request('status') === 'cancelled' ? 'text-[#6B3F35] font-medium' : 'text-slate-500 hover:text-slate-800' }}"
                    >
                        Cancelled
                        @if (request('status') === 'cancelled')
                            <span class="absolute left-0 right-0 -bottom-[17px] h-0.5 bg-[#6B3F35]"></span>
                        @endif
                    </a>
                </div>

                {{-- SEARCH FORM --}}
                <form
                    action="{{ route('admin.bookings.index') }}"
                    method="GET"
                    class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full lg:w-auto"
                >
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <div class="relative flex-1 sm:flex-none">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari kode / nama / email..."
                            class="w-full sm:w-60 h-10 pl-9 pr-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#B98B6B] focus:ring-1 focus:ring-[#B98B6B] outline-none"
                        >
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
                    <table class="w-full min-w-[1000px] text-sm">
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
                                    Kode Booking
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Customer
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Staff
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Jadwal Mulai
                                </th>
                                <th class="px-4 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Total
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
                            @forelse ($bookings as $booking)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-4 text-center">
                                        <input
                                            type="checkbox"
                                            name="selected_bookings[]"
                                            value="{{ $booking->id }}"
                                            class="booking-checkbox w-4 h-4 rounded border-slate-300 text-[#6B3F35] focus:ring-[#6B3F35]"
                                        >
                                    </td>

                                    <td class="px-4 py-4">
                                        <span class="font-semibold text-slate-800">
                                            {{ $booking->booking_code }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 shrink-0 rounded-xl bg-[#F7EFE9] border border-[#EFE1D8] flex items-center justify-center">
                                                <span class="text-xs font-semibold text-[#6B3F35]">
                                                    {{ strtoupper(substr($booking->customer?->name ?? 'G', 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-medium text-slate-800 truncate">
                                                    {{ $booking->customer?->name ?? 'Guest' }}
                                                </p>
                                                <p class="text-xs text-slate-400 truncate">
                                                    {{ $booking->customer?->email ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-slate-600">
                                        {{ $booking->staff?->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-slate-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->start_at)->translatedFormat('d M Y, H:i') }}
                                    </td>

                                    <td class="px-4 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-4">
                                        @php
                                            $statusClasses = [
                                                'pending_payment' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'confirmed'       => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'in_progress'     => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'completed'       => 'bg-green-50 text-green-700 border-green-200',
                                                'cancelled'       => 'bg-red-50 text-red-700 border-red-200',
                                                'expired'         => 'bg-slate-100 text-slate-600 border-slate-200',
                                                'no_show'         => 'bg-rose-50 text-rose-700 border-rose-200',
                                            ];
                                            $currentStatusClass = $statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-xs font-medium {{ $currentStatusClass }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a
                                                href="{{ route('admin.bookings.show', $booking) }}"
                                                title="Detail"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-[#6B3F35] hover:bg-[#F7EFE9] transition"
                                            >
                                                <i class="fa-regular fa-eye text-sm"></i>
                                            </a>

                                            <a
                                                href="{{ route('admin.bookings.edit', $booking) }}"
                                                title="Edit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                            >
                                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                                            </a>

                                            <form
                                                id="delete-form-{{ $booking->id }}"
                                                action="{{ route('admin.bookings.destroy', $booking) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('{{ $booking->id }}', '{{$booking->booking_code }}')"
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
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <i class="fa-regular fa-calendar-xmark text-slate-400 text-xl"></i>
                                            </div>
                                            <p class="font-medium text-slate-700">Belum ada data booking</p>
                                            <p class="text-sm text-slate-400 mt-1">Data booking pelanggan akan muncul di sini.</p>
                                            <a
                                                href="{{ route('admin.bookings.create') }}"
                                                class="mt-4 px-4 py-2 rounded-xl bg-[#6B3F35] text-white text-sm font-medium hover:bg-[#573229] transition"
                                            >
                                                <i class="fa-solid fa-plus mr-1"></i> Tambah Booking
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
            @if ($bookings->total() > 0)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-5">
                    <p class="text-xs text-slate-500">
                        Menampilkan
                        <span class="font-medium text-slate-700">{{ $bookings->firstItem() }}</span>
                        -
                        <span class="font-medium text-slate-700">{{ $bookings->lastItem() }}</span>
                        dari
                        <span class="font-medium text-slate-700">{{ $bookings->total() }}</span>
                        booking
                    </p>

                    <div>
                        {{ $bookings->onEachSide(1)->links() }}
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
        function confirmDelete(id, code) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data booking dengan kode "${code}" akan dihapus permanen!`,
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
            const checkboxes = document.querySelectorAll('.booking-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = selectAll.checked;
                    });
                });
            }

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const checkedCount = document.querySelectorAll('.booking-checkbox:checked').length;
                    
                    if (selectAll) {
                        selectAll.checked = checkedCount === checkboxes.length && checkboxes.length > 0;
                        selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
                    }
                });
            });
        });
    </script>
</x-app-layout>