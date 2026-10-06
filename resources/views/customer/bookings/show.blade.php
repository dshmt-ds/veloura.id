@section('title', 'Detail Booking #' . $booking->booking_code)

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#8b686e] hover:text-[#6B3E4B] transition mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Booking
                </a>
                <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#6B3E4B] leading-tight">
                    Detail Reservasi
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-mono text-xs font-bold text-[#6B3E4B] bg-white px-3 py-1.5 rounded-full border border-[#EFE3DE] shadow-sm">
                    #{{ $booking->booking_code }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="bg-[#F7EFE9] min-h-[calc(100vh-160px)] py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-[#EFE3DE] p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-[#EFE3DE]">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Status Pesanan</p>
                        <div class="mt-1 flex items-center gap-2">
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
                        </div>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Tanggal Operasional</p>
                        <p class="text-sm font-semibold text-[#6B3E4B] mt-1">
                            <i class="fa-regular fa-calendar-check text-[#D8B08C] mr-1"></i>
                            {{ $booking->start_at ? \Carbon\Carbon::parse($booking->start_at)->format('d M Y, H:i') : '-' }} WIB
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-b border-[#EFE3DE]">
                    <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                        <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Informasi Pemesan</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $booking->customer->name ?? $booking->user->name ?? Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $booking->customer->email ?? $booking->user->email ?? Auth::user()->email }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                        <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Staff Bertugas</p>
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-[#6B3E4B] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr($booking->staff->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 text-sm">{{ $booking->staff->name ?? 'Staff Umum' }}</p>
                                <p class="text-xs text-gray-500">Veloura Studio Specialist</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <h4 class="font-semibold text-base text-[#6B3E4B] mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-spa text-[#D8B08C]"></i> Rincian Treatment
                    </h4>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[11px] uppercase tracking-wider text-gray-400 border-b border-[#EFE3DE]">
                                    <th class="pb-3">Layanan</th>
                                    <th class="pb-3 text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EFE3DE] text-sm">
                                @if(isset($booking->items) && count($booking->items) > 0)
                                    @foreach($booking->items as $item)
                                        <tr>
                                            <td class="py-3.5 font-medium text-gray-800">
                                                {{ $item->service->name ?? $item->service_name }}
                                            </td>
                                            <td class="py-3.5 text-right font-semibold text-[#6B3E4B]">
                                                Rp {{ number_format($item->price ?? $item->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="py-3.5 font-medium text-gray-800">
                                            {{ $booking->service->name ?? 'Layanan Perawatan Veloura' }}
                                        </td>
                                        <td class="py-3.5 text-right font-semibold text-[#6B3E4B]">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-[#EFE3DE]">
                                    <td class="pt-4 font-bold text-base text-gray-900">Total Pembayaran</td>
                                    <td class="pt-4 text-right font-bold text-lg text-[#6B3E4B]">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-2">
                @if(in_array(strtolower($booking->status), ['pending', 'pending_payment', 'menunggu']))
                    <button type="button" onclick="confirmCancel()" class="px-5 py-2.5 rounded-full bg-[#EFE3DE] border border-[#EFE3DE] text-[#6B3E4B] hover:bg-[#EFE3DE] transition text-xs font-semibold">
                        Batalkan Booking
                    </button>
                    
                    <form id="cancel-form" action="{{ route('customer.bookings.destroy', $booking) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @else
                    <div></div>
                @endif

                @if (strtolower($booking->status) !== 'confirmed' && strtolower($booking->latestPayment?->status ?? 'pending') !== 'paid')
                    @php
                        $paymentRoute = Route::has('customer.bookings.payment') 
                            ? route('customer.bookings.payment', $booking) 
                            : (Route::has('customer.payment') ? route('customer.payment', $booking) : '#');
                    @endphp

                    <a
                        href="{{ $paymentRoute }}"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-[#6B3E4B] hover:bg-[#522e39] text-white font-semibold text-xs transition shadow-sm"
                    >
                        <i class="fa-solid fa-credit-card mr-2"></i> Bayar Sekarang
                    </a>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmCancel() {
                Swal.fire({
                    title: 'Batalkan Booking?',
                    text: "Apakah Anda yakin ingin membatalkan jadwal reservasi ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#6B3E4B',
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Kembali',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-full px-5 py-2 text-xs font-semibold',
                        cancelButton: 'rounded-full px-5 py-2 text-xs font-semibold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('cancel-form').submit();
                    }
                });
            }

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
            });
        </script>
    @endpush
</x-app-layout>