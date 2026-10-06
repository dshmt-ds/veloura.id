@section('title', 'Riwayat Booking')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#6B3E4B] leading-tight">
                    Riwayat Booking Saya
                </h2>
                <p class="text-xs text-[#8b686e] mt-1">
                    Kelola dan pantau jadwal perawatan kecantikan Anda di Veloura Studio
                </p>
            </div>
            <a href="{{ url('/#prices') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-[#6B3E4B] text-white text-xs font-semibold hover:bg-[#542d39] transition shadow-sm">
                <i class="fa-solid fa-plus text-xs"></i> Booking Baru
            </a>
        </div>
    </x-slot>

    <div class="bg-[#F7EFE9] min-h-[calc(100vh-160px)] py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-[#EFE3DE] overflow-hidden">
                <div class="p-6 border-b border-[#EFE3DE] flex items-center justify-between bg-white/50">
                    <h3 class="font-semibold text-base text-[#6B3E4B] flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-[#D8B08C]"></i> Daftar Reservasi
                    </h3>
                    <span class="text-xs text-gray-400">Total: {{ method_exists($bookings, 'total') ? $bookings->total() : count($bookings) }} Booking</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F7EFE9]/50 text-[#6B3E4B] uppercase text-[11px] tracking-wider font-semibold border-b border-[#EFE3DE]">
                                <th class="px-6 py-4">Kode Booking</th>
                                <th class="px-6 py-4">Tanggal & Waktu</th>
                                <th class="px-6 py-4">Staff Studio</th>
                                <th class="px-6 py-4">Total Biaya</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EFE3DE] text-sm text-gray-700">
                            @forelse ($bookings as $booking)
                                <tr class="hover:bg-[#F7EFE9]/30 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono font-bold text-[#6B3E4B] bg-[#F7EFE9] px-2.5 py-1 rounded-md text-xs border border-[#EFE3DE]">
                                            #{{ $booking->booking_code }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-clock text-[#D8B08C] text-xs"></i>
                                            <span class="font-medium text-gray-900">
                                                {{ $booking->start_at ? \Carbon\Carbon::parse($booking->start_at)->format('d M Y, H:i') : '-' }} WIB
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-[#6B3E4B]/10 text-[#6B3E4B] flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($booking->staff->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">
                                                {{ $booking->staff->name ?? 'Staff Umum' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-[#6B3E4B]">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $status = strtolower($booking->status);
                                            $badgeClasses = match($status) {
                                                'confirmed', 'approved', 'completed', 'selesai', 'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'pending', 'pending_payment', 'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'cancelled', 'batal', 'expired', 'failed' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                default => 'bg-gray-50 text-gray-700 border-gray-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClasses }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $detailRoute = Route::has('customer.bookings.show') 
                                                ? route('customer.bookings.show', $booking) 
                                                : (Route::has('bookings.show') ? route('bookings.show', $booking->id) : '#');
                                        @endphp

                                        <a href="{{ $detailRoute }}" class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-full border border-[#6B3E4B] text-[#6B3E4B] hover:bg-[#6B3E4B] hover:text-white transition text-xs font-medium shadow-sm">
                                            <i class="fa-solid fa-eye text-[10px]"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="max-w-xs mx-auto flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-full bg-[#F7EFE9] text-[#D8B08C] flex items-center justify-center text-2xl mb-3 border border-[#EFE3DE]">
                                                <i class="fa-regular fa-calendar-xmark"></i>
                                            </div>
                                            <p class="font-semibold text-gray-800 text-base">Belum Ada Riwayat Booking</p>
                                            <p class="text-xs text-gray-400 mt-1 mb-4">Anda belum memiliki pesanan jadwal perawatan saat ini.</p>
                                            <a href="{{ url('/#prices') }}" class="px-5 py-2 rounded-full bg-[#6B3E4B] text-white text-xs font-semibold hover:bg-[#542d39] transition shadow-sm">
                                                Pesan Treatment Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($bookings, 'hasPages') && $bookings->hasPages())
                    <div class="p-4 border-t border-[#EFE3DE] bg-[#F7EFE9]/20">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        confirmButtonColor: '#6B3E4B',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-full px-6 py-2.5 text-xs font-semibold'
                        }
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: "{{ session('error') }}",
                        confirmButtonColor: '#6B3E4B',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-full px-6 py-2.5 text-xs font-semibold'
                        }
                    });
                @endif
            });
        </script>
    @endpush
</x-app-layout>