@section('title', 'Pembayaran Pemesanan #' . $booking->booking_code)

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#8b686e] hover:text-[#6B3E4B] transition mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Pemesanan
                </a>
                <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#6B3E4B] leading-tight">
                    Pembayaran Pemesanan
                </h2>
            </div>
            <div class="flex items-center gap-2">
                <span class="font-mono text-xs font-bold text-[#6B3E4B] bg-white px-3 py-1.5 rounded-full border border-[#EFE3DE] shadow-sm">
                    #{{ $booking->booking_code }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="bg-white min-h-[calc(100vh-160px)] py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Main Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-[#EFE3DE] overflow-hidden">

                {{-- Pemesanan Header --}}
                <div class="p-6 border-b border-[#EFE3DE] bg-white">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Kode Pemesanan</p>
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

                {{-- Pemesanan Information --}}
                <div class="p-6 md:p-8 space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Pelanggan --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Pelanggan</p>
                            <p class="font-bold text-gray-800 text-sm">
                                {{ $booking->customer->name ?? auth()->user()?->name ?? 'Pelanggan Indah Salon' }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $booking->customer->email ?? auth()->user()?->email ?? '-' }}
                            </p>
                        </div>

                        {{-- Staf --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Staf Bertugas</p>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#6B3E4B] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($booking->staff->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">
                                        {{ $booking->staff->name ?? 'Staf Umum' }}
                                    </p>
                                    <p class="text-xs text-gray-500">Tenaga Perawatan Indah Salon</p>
                                </div>
                            </div>
                        </div>

                        {{-- Jadwal --}}
                        <div class="p-4 rounded-2xl bg-[#F7EFE9]/50 border border-[#EFE3DE]">
                            <p class="text-xs text-[#8b686e] font-medium uppercase tracking-wider mb-2">Jadwal Perawatan</p>
                            <p class="font-bold text-gray-800 text-sm">
                                <i class="fa-regular fa-calendar-check text-[#D8B08C] mr-1"></i>
                                {{ $booking->start_at ? \Carbon\Carbon::parse($booking->start_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : '-' }}
                            </p>
                            @if($booking->end_at)
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Durasi sampai {{ \Carbon\Carbon::parse($booking->end_at)->timezone('Asia/Jakarta')->format('H:i') }} WIB
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

                    {{-- Layanan --}}
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
                                                {{ $item->service_name ?? $item->service?->name ?? 'Layanan Perawatan Indah Salon' }}
                                            </p>
                                            @if($item->duration_minutes)
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ $item->duration_minutes }} menit
                                                </p>
                                            @endif
                                        </div>
                                        <p class="font-semibold text-[#6B3E4B] text-sm">
                                            Rp {{ number_format($item->price ?? $item->amount ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">
                                            {{ $booking->service->name ?? 'Layanan Perawatan Indah Salon' }}
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
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">
                                    Pembayaran Online
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    QRIS, Virtual Account, e-Wallet, Kartu Kredit/Debit.
                                </p>
                            </div>
                            <div class="sm:text-right min-w-0">
                                <p class="text-[11px] text-[#8b686e] uppercase tracking-wider font-semibold">
                                    Referensi
                                </p>
                                <p class="text-xs font-mono font-bold text-[#6B3E4B] break-all">
                                    {{ $payment->payment_reference }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Pay Button --}}
                    <div class="pt-2">
                        <p id="payment-error" role="alert" class="hidden mb-3 text-sm text-red-700"></p>
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
        $redirectUrl = \Illuminate\Support\Facades\Route::has('customer.bookings.show')
            ? route('customer.bookings.show', $booking)
            : (\Illuminate\Support\Facades\Route::has('bookings.show') ? route('bookings.show', $booking->id) : url('/'));
    @endphp

    @push('scripts')
        <div id="checkout-config" data-snap-token="{{ $payment->snap_token }}" data-redirect-url="{{ $redirectUrl }}" hidden></div>
        <script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const payButton = document.getElementById('pay-button');
                const payText = document.getElementById('pay-text');
                const payLoading = document.getElementById('pay-loading');
                const paymentError = document.getElementById('payment-error');
                const checkoutConfig = document.getElementById('checkout-config');
                const snapToken = checkoutConfig.dataset.snapToken;
                const targetUrl = checkoutConfig.dataset.redirectUrl;

                function setLoading(loading) {
                    payButton.disabled = loading;
                    payButton.setAttribute('aria-busy', String(loading));
                    payText.classList.toggle('hidden', loading);
                    payLoading.classList.toggle('hidden', !loading);
                }

                function showError(message) {
                    setLoading(false);
                    paymentError.textContent = message;
                    paymentError.classList.remove('hidden');
                }

                payButton.addEventListener('click', function () {
                    if (payButton.disabled) return;

                    paymentError.classList.add('hidden');

                    if (!window.snap || typeof window.snap.pay !== 'function') {
                        showError('Layanan pembayaran belum tersedia. Muat ulang halaman dan coba lagi.');
                        return;
                    }

                    if (!snapToken) {
                        showError('Token pembayaran tidak tersedia. Muat ulang halaman untuk mencoba lagi.');
                        return;
                    }

                    setLoading(true);

                    try {
                        window.snap.pay(snapToken, {
                            onSuccess: function () {
                                window.location.href = targetUrl;
                            },
                            onPending: function () {
                                window.location.href = targetUrl;
                            },
                            onError: function () {
                                showError('Gagal memproses transaksi. Silakan coba lagi.');
                            },
                            onClose: function () {
                                setLoading(false);
                            }
                        });
                    } catch (error) {
                        showError('Gagal membuka pembayaran. Muat ulang halaman dan coba lagi.');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
