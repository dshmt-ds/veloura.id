@section('title', 'Detail Pemesanan ' . $booking->booking_code)

<x-app-layout>
    @php
        $statuses = [
            'pending_payment' => ['Menunggu Pembayaran', 'bg-amber-50 text-amber-700 border-amber-200'],
            'confirmed' => ['Terkonfirmasi', 'bg-blue-50 text-blue-700 border-blue-200'],
            'in_progress' => ['Sedang Berlangsung', 'bg-purple-50 text-purple-700 border-purple-200'],
            'completed' => ['Selesai', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            'cancelled' => ['Dibatalkan', 'bg-rose-50 text-rose-700 border-rose-200'],
            'expired' => ['Kedaluwarsa', 'bg-slate-100 text-slate-600 border-slate-200'],
            'no_show' => ['Tidak Hadir', 'bg-slate-100 text-slate-600 border-slate-200'],
        ];
        [$statusLabel, $statusClass] = $statuses[$booking->status] ?? [ucfirst($booking->status), 'bg-slate-100 text-slate-600 border-slate-200'];
        $payment = $booking->latestPayment;
        $isPaid = $hasPaidPayment;
        $canPay = $booking->status === 'pending_payment' && !$isPaid && (!$booking->payment_deadline || $booking->payment_deadline->isFuture());
        $canCancel = $booking->status === 'pending_payment' && !$isPaid;
        $paymentLabels = ['pending' => 'Menunggu Pembayaran', 'paid' => 'Lunas', 'failed' => 'Gagal', 'expired' => 'Kedaluwarsa', 'cancelled' => 'Dibatalkan', 'refunded' => 'Dana Dikembalikan'];
    @endphp

    <div class="bg-white min-h-screen py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="border-b border-[#EFE3DE] pb-5">
                <a href="{{ route('customer.bookings.index') }}" class="text-xs text-gray-500 hover:text-[#6B3E4B]">&larr; Kembali ke Riwayat Pemesanan</a>
                <div class="flex flex-wrap items-center justify-between gap-3 mt-2">
                    <h1 class="text-2xl font-semibold text-slate-900">Detail Pemesanan</h1>
                    <span class="rounded-full bg-[#F7EFE9] px-4 py-2 text-xs font-semibold text-[#6B3E4B] break-all">{{ $booking->booking_code }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Informasi jadwal, layanan, dan pembayaran perawatan Anda.</p>
            </div>

            @if (session('success'))
                <div role="status" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            @if ($booking->status === 'pending_payment' && !$isPaid)
                <div role="status" class="flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                    <i class="fa-regular fa-clock mt-1" aria-hidden="true"></i>
                    <div>
                        <p class="font-semibold">{{ $canPay ? 'Selesaikan pembayaran dalam 1 x 24 jam' : 'Batas pembayaran telah lewat' }}</p>
                        @if ($booking->payment_deadline)
                            <p class="mt-1">Batas pembayaran: {{ $booking->payment_deadline->translatedFormat('d F Y, H:i') }}.</p>
                            @if ($canPay)<p class="mt-1 text-xs">{{ $booking->payment_deadline->locale('id')->diffForHumans() }}. Bayar sebelum batas waktu untuk mengonfirmasi reservasi.</p>@endif
                        @endif
                        @unless ($canPay)<p class="mt-1 text-xs">Hubungi salon untuk bantuan pemesanan ulang.</p>@endunless
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <div class="lg:col-span-2 min-w-0 space-y-6">
                    <section class="rounded-2xl border border-[#EFE3DE] overflow-hidden">
                        <div class="flex flex-wrap justify-between items-center gap-3 bg-[#F7EFE9] px-5 py-4">
                            <h2 class="font-semibold text-[#6B3E4B]">Informasi Reservasi</h2>
                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-medium {{ $statusClass }}"><span class="h-1.5 w-1.5 rounded-full bg-current" aria-hidden="true"></span>{{ $statusLabel }}</span>
                        </div>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5 p-5 text-sm">
                            <div><dt class="text-xs text-gray-500 mb-2">Tanggal Perawatan</dt><dd class="font-medium text-slate-800">{{ $booking->start_at?->translatedFormat('d F Y') ?? '-' }}</dd></div>
                            <div><dt class="text-xs text-gray-500 mb-2">Jam Perawatan</dt><dd class="font-medium text-slate-800">{{ $booking->start_at?->format('H:i') ?? '-' }} - {{ $booking->end_at?->format('H:i') ?? '-' }}</dd></div>
                            <div><dt class="text-xs text-gray-500 mb-2">Pemesan</dt><dd class="font-medium text-slate-800 break-words">{{ $booking->customer?->name ?? auth()->user()->name }}</dd><dd class="text-xs text-gray-500 mt-1 break-all">{{ $booking->customer?->email ?? auth()->user()->email }}</dd></div>
                            <div><dt class="text-xs text-gray-500 mb-2">Staf Bertugas</dt><dd class="font-medium text-slate-800">{{ $booking->staff?->name ?? 'Staf tidak tersedia' }}</dd><dd class="text-xs text-gray-500 mt-1">Indah Salon</dd></div>
                        </dl>
                        @if ($booking->customer_notes)
                            <div class="mx-5 mb-5 rounded-xl bg-[#F7EFE9] p-4"><p class="text-xs text-gray-500 mb-1">Catatan Anda</p><p class="text-sm text-slate-700 whitespace-pre-line break-words">{{ $booking->customer_notes }}</p></div>
                        @endif
                        @if ($booking->status === 'cancelled')
                            <div class="mx-5 mb-5 rounded-xl bg-rose-50 p-4 text-sm text-rose-700">Pemesanan dibatalkan{{ $booking->cancelled_at ? ' pada ' . $booking->cancelled_at->format('d/m/Y H:i') : '' }}.
                                @if ($booking->cancellation_reason)<p class="mt-1 break-words">{{ $booking->cancellation_reason }}</p>@endif
                            </div>
                        @endif
                    </section>

                    <section class="rounded-2xl border border-[#EFE3DE] overflow-hidden">
                        <h2 class="font-semibold text-[#6B3E4B] bg-[#F7EFE9] px-5 py-4">Rincian Layanan</h2>
                        <div class="divide-y divide-[#EFE3DE] px-5">
                            @forelse ($booking->items as $item)
                                <div class="flex flex-wrap justify-between gap-3 py-4 text-sm">
                                    <div class="min-w-0"><p class="font-medium text-slate-800 break-words">{{ $item->service_name }}</p><p class="text-xs text-gray-500 mt-1">{{ $item->duration_minutes }} menit</p></div>
                                    <p class="font-semibold text-[#6B3E4B]">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            @empty
                                <p class="py-6 text-sm text-gray-500">Rincian layanan belum tersedia.</p>
                            @endforelse
                        </div>
                    </section>
                </div>

                <section class="rounded-2xl border border-[#EFE3DE] p-5 space-y-5">
                    <h2 class="font-semibold text-[#6B3E4B]">Ringkasan Pembayaran</h2>
                    <div class="rounded-xl bg-[#F7EFE9] p-4"><p class="text-xs text-gray-500">Total Biaya</p><p class="text-2xl font-semibold text-[#6B3E4B] mt-2 break-words">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p></div>
                    <dl class="text-sm space-y-4">
                        <div><dt class="text-xs text-gray-500">Status Pembayaran</dt><dd class="font-medium mt-1">{{ $isPaid ? 'Lunas' : ($payment ? ($paymentLabels[$payment->status] ?? ucfirst($payment->status)) : 'Belum ada pembayaran') }}</dd></div>
                        @if ($payment)
                            <div><dt class="text-xs text-gray-500">Referensi Terakhir</dt><dd class="mt-1 break-all">{{ $payment->payment_reference }}</dd></div>
                            <div><dt class="text-xs text-gray-500">Metode Pembayaran Terakhir</dt><dd class="mt-1 uppercase">{{ $payment->payment_method ?? 'Belum tersedia' }}</dd></div>
                        @endif
                        @if ($booking->payment_deadline && !$isPaid)
                            <div><dt class="text-xs text-gray-500">Batas Pembayaran</dt><dd class="mt-1">{{ $booking->payment_deadline->format('d/m/Y H:i') }}</dd></div>
                        @endif
                    </dl>
                    @if ($canPay)
                        <button id="booking-pay-button" type="button" data-payment-url="{{ route('customer.bookings.payment.prepare', $booking) }}" class="flex justify-center items-center gap-2 w-full rounded-full bg-[#6B3E4B] text-white px-5 py-3 text-sm font-medium hover:bg-[#542d39] disabled:opacity-60 disabled:cursor-wait transition"><i class="fa-regular fa-credit-card" aria-hidden="true"></i><span id="booking-pay-label">Bayar Sekarang</span></button>
                        <p id="booking-payment-message" role="status" aria-live="polite" class="hidden rounded-xl bg-[#F7EFE9] p-3 text-xs text-[#6B3E4B]"></p>
                    @elseif ($booking->status === 'pending_payment' && !$isPaid)
                        <p class="rounded-xl bg-amber-50 p-3 text-xs text-amber-800">Batas pembayaran telah lewat. Hubungi salon untuk bantuan.</p>
                    @endif
                    @if ($canCancel)
                        <form action="{{ route('customer.bookings.destroy', $booking) }}" method="POST" onsubmit="return window.confirm('Batalkan pemesanan ini? Riwayat booking tetap tersimpan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-full border border-[#EFE3DE] text-[#6B3E4B] px-5 py-2.5 text-sm font-medium hover:bg-[#F7EFE9] transition">Batalkan Pemesanan</button>
                        </form>
                    @endif
                </section>
            </div>
        </div>
    </div>
    @if ($canPay)
        @push('scripts')
            <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const button = document.getElementById('booking-pay-button');
                    const label = document.getElementById('booking-pay-label');
                    const message = document.getElementById('booking-payment-message');

                    function setLoading(loading) {
                        button.disabled = loading;
                        button.setAttribute('aria-busy', String(loading));
                        label.textContent = loading ? 'Memproses...' : 'Bayar Sekarang';
                    }

                    function showMessage(text) {
                        message.textContent = text;
                        message.classList.remove('hidden');
                    }

                    button.addEventListener('click', async function () {
                        if (button.disabled) return;
                        message.classList.add('hidden');
                        if (!window.snap || typeof window.snap.pay !== 'function') {
                            showMessage('Layanan pembayaran belum tersedia. Muat ulang halaman dan coba lagi.');
                            return;
                        }

                        setLoading(true);
                        try {
                            const response = await fetch(button.dataset.paymentUrl, {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            if (response.status === 401 || response.status === 419) {
                                throw new Error('Sesi Anda telah berakhir. Muat ulang halaman dan masuk kembali.');
                            }
                            if (!response.ok) {
                                throw new Error(response.status === 422 ? 'Pemesanan tidak dapat dibayar atau batas pembayaran telah lewat. Muat ulang halaman.' : 'Gagal menyiapkan pembayaran. Silakan coba lagi.');
                            }
                            const data = await response.json();
                            if (!data.snap_token) throw new Error('Token pembayaran tidak tersedia. Silakan coba lagi.');

                            window.snap.pay(data.snap_token, {
                                onSuccess: function () {
                                    setLoading(false);
                                    button.disabled = true;
                                    label.textContent = 'Menunggu Konfirmasi';
                                    showMessage('Pembayaran sedang diverifikasi. Status akan diperbarui setelah konfirmasi Midtrans. Muat ulang halaman untuk melihat status terbaru.');
                                },
                                onPending: function () {
                                    setLoading(false);
                                    showMessage('Pembayaran menunggu penyelesaian. Klik Bayar Sekarang untuk melanjutkan.');
                                },
                                onError: function () {
                                    setLoading(false);
                                    showMessage('Pembayaran belum berhasil. Silakan coba lagi.');
                                },
                                onClose: function () { setLoading(false); }
                            });
                        } catch (error) {
                            setLoading(false);
                            showMessage(error.message || 'Tidak dapat membuka pembayaran. Silakan coba lagi.');
                        }
                    });
                });
            </script>
        @endpush
    @endif
</x-app-layout>
