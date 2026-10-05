@section('title', 'Jam Operasional')

<x-app-layout>
    <div class="w-full min-h-screen bg-[#F8FAFC] text-slate-700 font-sans py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5">
                <div>
                    <h1 class="text-xl sm:text-2xl font-semibold text-slate-900">
                        Jam Operasional
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Atur jam buka dan hari operasional tempat usaha Veloura.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('admin.operating-hours.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#6B3F35] hover:bg-[#573229] text-white text-sm font-semibold transition shadow-sm"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Jam Operasional</span>
                    </a>
                </div>
            </div>

            <div class="border-b border-slate-200"></div>

            {{-- TABLE SECTION --}}
            <div class="mt-5 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px] text-sm">
                        <thead>
                            <tr class="bg-[#F8FAFC] border-b border-slate-200">
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Hari
                                </th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Jam Buka
                                </th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Jam Tutup
                                </th>
                                <th class="px-6 py-3.5 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>
                                <th class="px-6 py-3.5 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($operatingHours as $item)
                                <tr class="hover:bg-slate-50/70 transition">
                                    {{-- Hari --}}
                                    <td class="px-6 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                        {{ $item->day_name }}
                                    </td>

                                    {{-- Jam Buka --}}
                                    <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                        @if (!$item->is_closed && $item->open_time)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-medium text-xs">
                                                <i class="fa-regular fa-clock text-xs"></i>
                                                {{ \Carbon\Carbon::parse($item->open_time)->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Jam Tutup --}}
                                    <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                        @if (!$item->is_closed && $item->close_time)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-700 font-medium text-xs">
                                                <i class="fa-regular fa-clock text-xs"></i>
                                                {{ \Carbon\Carbon::parse($item->close_time)->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->is_closed)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-rose-200 bg-rose-50 text-rose-700 text-xs font-medium">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Tutup
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-green-200 bg-green-50 text-green-700 text-xs font-medium">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Buka
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a
                                                href="{{ route('admin.operating-hours.edit', $item) }}"
                                                title="Edit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                            >
                                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                                            </a>

                                            <form
                                                id="delete-form-{{ $item->id }}"
                                                action="{{ route('admin.operating-hours.destroy', $item) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="button"
                                                    onclick="confirmDelete('{{ $item->id }}', '{{$item->day_name }}')"
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
                                                <i class="fa-regular fa-clock text-slate-400 text-xl"></i>
                                            </div>
                                            <p class="font-medium text-slate-700">Belum ada jam operasional</p>
                                            <p class="text-sm text-slate-400 mt-1">Tambahkan pengaturan jam operasional untuk hari kerja.</p>
                                            <a
                                                href="{{ route('admin.operating-hours.create') }}"
                                                class="mt-4 px-4 py-2 rounded-xl bg-[#6B3F35] text-white text-sm font-medium hover:bg-[#573229] transition"
                                            >
                                                <i class="fa-solid fa-plus mr-1"></i> Tambah Jam Operasional
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

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
        function confirmDelete(id, dayName) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Jam operasional hari "${dayName}" akan dihapus!`,
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