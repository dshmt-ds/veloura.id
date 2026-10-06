@section('title', 'Detail Booking')

<x-app-layout>
    <div class="bg-[#F8FAFC] min-h-screen py-8 text-slate-700 font-sans">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header & Navigation -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <a
                        href="{{ route('admin.bookings.index') }}"
                        class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-[#6B3E4B] transition"
                    >
                        &larr; Kembali ke Kelola Booking
                    </a>

                    <h1 class="text-2xl font-semibold text-slate-900 mt-2 flex items-center gap-3">
                        Detail Booking: <span class="font-mono text-[#6B3E4B]">{{ $booking->booking_code }}</span>
                    </h1>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('admin.bookings.edit', $booking) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 text-sm font-medium transition"
                    >
                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                        <span>Edit Booking</span>
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
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 text-sm font-medium transition"
                        >
                            <i class="fa-regular fa-trash-can text-xs"></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Info Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Left Details (Customer, Staff, & Notes) -->
                <div class="md:col-span-2 space-y-6">
                    
                    <!-- Customer & Staff Info -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
                        <h2 class="font-semibold text-slate-900 text-base border-b border-slate-100 pb-3">
                            Informasi Pihak Terkait
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Customer -->
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-[#F8FAFC] border border-slate-100">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-[#F7EFE9] border border-[#EFE1D8] flex items-center justify-center text-[#6B3E4B] font-semibold">
                                    {{ strtoupper(substr($booking->customer?->name ?? 'G', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Customer</p>
                                    <p class="font-semibold text-slate-800 truncate mt-0.5">{{ $booking->customer?->name ?? 'Guest' }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $booking->customer?->email ?? '-' }}</p>
                                    <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-phone text-[10px] mr-1"></i> {{ $booking->customer?->phone ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Staff -->
                            <div class="flex items-start gap-3 p-4 rounded-xl bg-[#F8FAFC] border border-slate-100">
                                <div class="w-10 h-10 shrink-0 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 font-semibold">
                                    {{ strtoupper(substr($booking->staff?->name ?? 'S', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Staff / Terapis</p>
                                    <p class="font-semibold text-slate-800 truncate mt-0.5">{{ $booking->staff?->name ?? 'Belum ditentukan' }}</p>
                                    <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-phone text-[10px] mr-1"></i> {{ $booking->staff?->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($booking->customer_notes || $booking->cancellation_reason)
                            <div class="space-y-3 pt-2">
                                @if ($booking->customer_notes)
                                    <div class="p-3.5 rounded-xl bg-amber-50/50 border border-amber-100 text-xs text-amber-900">
                                        <span class="font-semibold block mb-1">Catatan Customer:</span>
                                        <p class="italic">"{{ $booking->customer_notes }}"</p>
                                    </div>
                                @endif

                                @if ($booking->cancellation_reason)
                                    <div class="p-3.5 rounded-xl bg-red-50/50 border border-red-100 text-xs text-red-900">
                                        <span class="font-semibold block mb-1">Alasan Pembatalan:</span>
                                        <p class="italic">"{{ $booking->cancellation_reason }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Ordered Services Items -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                        <h2 class="font-semibold text-slate-900 text-base border-b border-slate-100 pb-3">
                            Rincian Layanan Perawatan
                        </h2>

                        <div class="divide-y divide-slate-100">
                            @forelse ($booking->items as $item)
                                <div class="py-3 flex items-center justify-between gap-4 first:pt-0 last:pb-0">
                                    <div>
                                        <p class="font-medium text-slate-800 text-sm">{{ $item->service_name }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Estimasi Durasi: {{ $item->duration_minutes ?? '-' }} Menit</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-slate-800 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-3">Tidak ada rincian item layanan.</p>
                            @endforelse
                        </div>

                        <div class="border-t border-slate-200 pt-4 flex items-center justify-between">
                            <span class="font-semibold text-slate-900 text-sm">Total Pembayaran</span>
                            <span class="font-bold text-lg text-[#6B3E4B]">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar (Status & Time Meta) -->
                <div class="space-y-6">
                    
                    <!-- Status & Schedule Box -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
                        <h2 class="font-semibold text-slate-900 text-base border-b border-slate-100 pb-3">
                            Status & Jadwal
                        </h2>

                        <!-- Status Badge -->
                        <div>
                            <span class="text-xs text-slate-400 font-medium uppercase tracking-wider block mb-1.5">Status Booking</span>
                            @php
                                $statusClasses = [                                     'pending_payment' => 'bg-amber-50 text-amber-700 border-amber-200',                                     'confirmed'       => 'bg-blue-50 text-blue-700 border-blue-200',                                     'in_progress'     => 'bg-purple-50 text-purple-700 border-purple-200',                                     'completed'       => 'bg-green-50 text-green-700 border-green-200',                                     'cancelled'       => 'bg-red-50 text-red-700 border-red-200',                                     'expired'         => 'bg-slate-100 text-slate-600 border-slate-200',                                     'no_show'         => 'bg-rose-50 text-rose-700 border-rose-200',                                 ];$currentStatusClass = $statusClasses[$booking->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs font-semibold {{ $currentStatusClass }}">
                                <span class="w-2 h-2 rounded-full bg-current"></span>
                                {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>

                        <!-- Schedule Time -->
                        <div class="space-y-3 pt-2 text-xs">
                            <div class="flex items-start gap-2.5 text-slate-600">
                                <i class="fa-regular fa-calendar text-slate-400 mt-0.5"></i>
                                <div>
                                    <span class="block text-slate-400 font-medium">Mulai Perawatan:</span>
                                    <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($booking->start_at)->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-2.5 text-slate-600">
                                <i class="fa-regular fa-clock text-slate-400 mt-0.5"></i>
                                <div>
                                    <span class="block text-slate-400 font-medium">Selesai (Estimasi):</span>
                                    <span class="font-semibold text-slate-800">{{ $booking->end_at ? \Carbon\Carbon::parse($booking->end_at)->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>

                            @if ($booking->payment_due_at)
                                <div class="flex items-start gap-2.5 text-slate-600">
                                    <i class="fa-regular fa-hourglass-half text-amber-500 mt-0.5"></i>
                                    <div>
                                        <span class="block text-slate-400 font-medium">Batas Waktu Pembayaran:</span>
                                        <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($booking->payment_due_at)->translatedFormat('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-slate-100 pt-4 text-[11px] text-slate-400 space-y-1">
                            <p>Dibuat: {{ $booking->created_at?->format('d/m/Y H:i') }}</p>
                            <p>Terakhir Diperbarui: {{ $booking->updated_at?->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id, code) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Data booking "${code}" akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6B3E4B',
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