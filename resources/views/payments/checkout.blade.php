@section('title', 'Pembayaran Booking #' . $booking->booking_code)

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#8b686e] hover:text-[#6B3E4B] transition mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Booking
                </a>
                <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#6B3E4B] leading-tight">
                    Pembayaran Booking
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-mono text-xs font-bold text-[#6B3E4B] bg-white px-3 py-1.5 rounded-full border border-[#EFE3DE] shadow-sm">
                    #{{ $booking->booking_code }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="bg-[#F7EFE9] min-h-[calc(100vh-160px)] py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Main Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-[#EFE3DE] overflow-hidden">

                {{-- Booking Header --}}
                <div class="p-6 border-b border-[#EFE3DE] bg-white">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Kode Booking</p>
                            <h3 class="text-xl font-bold text-[#6B3E4B] font-mono mt-1">
                                {{ $booking->booking_code }}
                            </h3>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Menunggu Pembayaran
                        </span>
                    </div>
                </div>

                {{-- Booking Information --}}
                <div class="p-6 md:p-8 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Customer --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Customer</p>
                            <p class="font-bold text-gray-800 text-sm">
                                {{ $booking->customer->name ?? $booking->user->name ?? Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $booking->customer->email ?? $booking->user->email ?? Auth::user()->email }}
                            </p>
                        </div>

                        {{-- Staff --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Staff Bertugas</p>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#6B3E4B] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($booking->staff->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">
                                        {{ $booking->staff->name ?? 'Staff Umum' }}
                                    </p>
                                    <p class="text-xs text-gray-500">Veloura Studio Specialist</p>
                                </div>
                            </div>
                        </div>

                        {{-- Jadwal --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Jadwal Perawatan</p>
                            <p class="font-bold text-gray-800 text-sm">
                                <i class="fa-regular fa-calendar-check text-[#D8B08C] mr-1"></i>
                                {{ $booking->start_at ? \Carbon\Carbon::parse($booking->start_at)->format('d M Y, H:i') : '-' }} WIB
                            </p>
                            @if($booking->end_at)
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Durasi sampai {{ \Carbon\Carbon::parse($booking->end_at)->format('H:i') }} WIB
                                </p>
                            @endif
                        </div>

                        {{-- Total --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Total Tagihan</p>
                            <p class="text-2xl font-bold text-[#6B3E4B]">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                    {{-- Services --}}
                    <div class="pt-4 border-t border-[#EFE3DE]">
                        <h4 class="font-semibold text-base text-[#6B3E4B] mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-spa text-[#D8B08C]"></i> Detail Layanan
                        </h4>

                        <div class="divide-y divide-[#EFE3DE] border border-[#EFE3DE] rounded-2xl overflow-hidden bg-white">
                            @if(isset($booking->items) && count($booking->items) > 0)
                                @foreach ($booking->items as $item)
                                    <div class="p-4 flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-800 text-sm">
                                                {{ $item->service_name ?? $item->service->name }}
                                            </p>
                                            @if($item->duration_minutes)
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ $item->duration_minutes }} menit
                                                </p>
                                            @endif
                                        </div>
                                        <p class="font-semibold text-[#6B3E4B] text-sm">
                                            Rp {{ number_format($item->price ?? $item->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">
                                            {{ $booking->service->name ?? 'Layanan Perawatan Veloura' }}
                                        </p>
                                    </div>
                                    <p class="font-semibold text-[#6B3E4B] text-sm">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Payment Info --}}
                    <div class="p-5 bg-[#F7EFE9]/60 rounded-2xl border border-[#EFE3DE]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">
                                    Pembayaran Online
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    QRIS, Virtual Account, e-Wallet, Kartu Kredit/Debit.
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] text-[#8b686e] uppercase tracking-wider font-semibold">
                                    Referensi
                                </p>
                                <p class="text-xs font-mono font-bold text-[#6B3E4B]">
                                    {{ $payment->payment_reference }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Pay Button --}}
                    <div class="pt-2">
                        <button
                            type="button"
                            id="pay-button"
                            class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-[#6B3E4B] hover:bg-[#522e39] text-white font-semibold text-sm rounded-full transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span id="pay-text">
                                <i class="fa-solid fa-credit-card mr-2"></i> Bayar Sekarang
                            </span>

                            <span id="pay-loading" class="hidden flex items-center gap-2">
                                <i class="fa-solid fa-spinner fa-spin"></i> Memproses Pembayaran...
                            </span>
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {{-- Script Midtrans (Otomatis Menyesuaikan Sandbox/Production via Config) --}}
    @php
        $snapUrl = config('midtrans.is_production', false)
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const payButton = document.getElementById('pay-button');
                const payText = document.getElementById('pay-text');
                const payLoading = document.getElementById('pay-loading');

                @php
                    $redirectUrl = Route::has('customer.bookings.show') 
                        ? route('customer.bookings.show', $booking) 
                        : (Route::has('bookings.show') ? route('bookings.show', $booking->id) : '#');
                @endphp

                const targetUrl = "{{ $redirectUrl }}";

                payButton.addEventListener('click', function () {
                    payButton.disabled = true;
                    payText.classList.add('hidden');
                    payLoading.classList.remove('hidden');

                    window.snap.pay(@json($payment->snap_token), {
                        onSuccess: function (result) {
                            console.log('SUCCESS', result);
                            window.location.href = targetUrl;
                        },
                        onPending: function (result) {
                            console.log('PENDING', result);
                            window.location.href = targetUrl;
                        },
                        onError: function (result) {
                            console.error('ERROR', result);
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal',
                                text: 'Gagal memproses transaksi. Silakan coba lagi.',
                                confirmButtonColor: '#6B3E4B',
                                customClass: { popup: 'rounded-3xl' }
                            });
                            payButton.disabled = false;
                            payText.classList.remove('hidden');
                            payLoading.classList.add('hidden');
                        },
                        onClose: function () {
                            console.log('Snap popup ditutup.');
                            payButton.disabled = false;
                            payText.classList.remove('hidden');
                            payLoading.classList.add('hidden');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>