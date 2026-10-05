@section('title', 'Detail Staff - ' . $staff->name)

<x-app-layout>
    <div class="w-full min-h-screen bg-[#F8FAFC] text-slate-700 font-sans py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <a
                        href="{{ route('admin.staffs.index') }}"
                        class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-[#6B3F35] transition"
                    >
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Kembali ke Daftar Staff</span>
                    </a>

                    <h1 class="text-2xl font-semibold text-slate-900 mt-3">
                        Detail Staff
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Informasi profil, daftar layanan yang dikuasai, dan riwayat jadwal kerja staff.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('admin.staffs.edit', $staff) }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F7EFE9] border border-[#EFE1D8] hover:bg-[#EFE1D8] font-medium text-sm transition"
                    >
                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                        <span>Edit Staff</span>
                    </a>
                </div>
            </div>

            {{-- PROFIL CARD --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 shrink-0 rounded-2xl bg-[#F7EFE9] border border-[#EFE1D8] flex items-center justify-center">
                            <span class="text-2xl font-bold text-[#6B3F35]">
                                {{ strtoupper(substr($staff->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <h2 class="text-xl font-bold text-slate-900">
                                    {{ $staff->name }}
                                </h2>
                                @if ($staff->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border border-green-200 bg-green-50 text-green-700 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border border-slate-200 bg-slate-50 text-slate-500 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                                <i class="fa-solid fa-phone text-xs text-slate-400"></i>
                                <span>{{ $staff->phone ?? 'Tidak ada nomor telepon' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="text-xs text-slate-400 self-end sm:self-center">
                        Terdaftar sejak {{ $staff->created_at ? $staff->created_at->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LAYANAN YANG DIKUASAI --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full">
                        <div class="px-6 py-4 bg-[#F8FAFC] border-b border-slate-200 flex items-center justify-between">
                            <h3 class="font-semibold text-slate-800 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-layer-group text-[#6B3F35]"></i>
                                <span>Layanan yang Dikuasai</span>
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full bg-[#F7EFE9] text-[#6B3F35] text-xs font-semibold">
                                {{ $staff->services->count() }}
                            </span>
                        </div>

                        <div class="p-6">
                            @forelse ($staff->services as $service)
                                <div class="py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }} flex items-center justify-between">
                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $service->name }}
                                    </span>
                                    @if(isset($service->duration))
                                        <span class="text-xs text-slate-400">
                                            {{ $service->duration }} mnt
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-circle-info text-xl mb-2"></i>
                                    <p class="text-xs">Belum ada layanan yang ditugaskan ke staff ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- JADWAL KERJA STAFF --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 bg-[#F8FAFC] border-b border-slate-200 flex items-center justify-between">
                            <h3 class="font-semibold text-slate-800 flex items-center gap-2 text-sm">
                                <i class="fa-regular fa-calendar-days text-[#6B3F35]"></i>
                                <span>Jadwal Kerja Staff</span>
                            </h3>
                            <span class="text-xs text-slate-500">
                                Total: {{ $staff->schedules->count() }} Jadwal
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="bg-[#F8FAFC] border-b border-slate-200 text-[11px] font-semibold text-slate-500 uppercase tracking-wide">
                                        <th class="px-6 py-3.5">Tanggal</th>
                                        <th class="px-6 py-3.5">Jam Kerja</th>
                                        <th class="px-6 py-3.5">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($staff->schedules as $schedule)
                                        <tr class="hover:bg-slate-50/70 transition">
                                            <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">
                                                {{ $schedule->schedule_date ? $schedule->schedule_date->translatedFormat('d M Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#F7EFE9] text-[#6B3F35] text-xs font-semibold">
                                                    <i class="fa-regular fa-clock text-xs"></i>
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                  {{ $schedule->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                                                <i class="fa-regular fa-calendar-xmark text-2xl mb-2 block"></i>
                                                <p class="text-xs">Belum ada riwayat jadwal kerja untuk staff ini.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>