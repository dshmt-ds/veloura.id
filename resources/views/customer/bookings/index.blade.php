@section('title', 'Riwayat Pemesanan')

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
    @endphp

    <div class="bg-white min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#EFE3DE] pb-5">
                <div>
                    <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-[#6B3E4B]">&larr; Kembali ke Beranda</a>
                    <h1 class="text-2xl sm:text-3xl font-semibold text-[#6B3E4B] mt-3 tracking-tight">Riwayat Pemesanan Saya</h1>
                    <p class="text-sm text-gray-500 mt-1">Pantau jadwal dan detail perawatan Anda di Indah Salon.</p>
                </div>
                <a href="{{ url('/#booking') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[#6B3E4B] text-white px-5 py-3 text-sm font-medium hover:bg-[#542d39] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#6B3E4B] focus-visible:ring-offset-2 transition">
                    <i class="fa-solid fa-plus text-xs" aria-hidden="true"></i> Pemesanan Baru
                </a>
            </div>

            @if (session('success'))
                <div role="status" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="font-semibold text-[#6B3E4B]">Daftar Reservasi</h2>
                <span class="rounded-full bg-[#F7EFE9] px-3 py-1.5 text-xs text-[#6B3E4B]">{{ number_format($bookings->total(), 0, ',', '.') }} booking</span>
            </div>

            <div class="space-y-4">
                @forelse ($bookings as $booking)
                    @php
                        [$statusLabel, $statusClass] = $statuses[$booking->status] ?? [ucfirst($booking->status), 'bg-slate-100 text-slate-600 border-slate-200'];
                    @endphp
                    <article class="rounded-2xl border border-[#EFE3DE] bg-white shadow-sm overflow-hidden hover:border-[#D8B08C] transition-colors">
                        <div class="flex flex-wrap items-center justify-between gap-3 bg-[#F7EFE9] px-4 sm:px-6 py-3.5">
                            <a href="{{ route('customer.bookings.show', $booking) }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-[#6B3E4B] hover:underline break-all"><i class="fa-regular fa-calendar-check shrink-0" aria-hidden="true"></i>{{ $booking->booking_code }}</a>
                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-medium {{ $statusClass }}">
                                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-current" aria-hidden="true"></span>{{ $statusLabel }}
                            </span>
                        </div>
                        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="sm:col-span-2 lg:col-span-4 flex items-start gap-4 pb-5 border-b border-[#EFE3DE]">
                                <div class="w-16 shrink-0 rounded-xl bg-[#F7EFE9] text-center py-2.5 text-[#6B3E4B]" aria-hidden="true">
                                    <span class="block text-2xl font-semibold leading-none">{{ $booking->start_at?->format('d') ?? '-' }}</span>
                                    <span class="block text-[10px] uppercase tracking-wider mt-1.5">{{ $booking->start_at?->translatedFormat('M Y') ?? '-' }}</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-gray-500 mb-2">Layanan Perawatan</p>
                                    <h3 class="text-base sm:text-lg font-semibold text-slate-800 break-words leading-relaxed">{{ $booking->items->pluck('service_name')->join(', ') ?: 'Layanan tidak tersedia' }}</h3>
                                    <p class="text-xs text-gray-500 mt-2">{{ $booking->items->count() }} layanan &middot; {{ $booking->items->sum('duration_minutes') }} menit</p>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 mb-2">Tanggal Perawatan</p>
                                <p class="text-sm font-medium text-slate-800">{{ $booking->start_at?->translatedFormat('d F Y') ?? '-' }}</p>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-500 mb-2">Jam Perawatan</p>
                                <p class="text-sm font-medium text-slate-800">{{ $booking->start_at?->format('H:i') ?? '-' }} - {{ $booking->end_at?->format('H:i') ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Staf Salon</p>
                                <p class="text-sm font-medium text-slate-800 break-words">{{ $booking->staff?->name ?? 'Staf tidak tersedia' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Total Biaya</p>
                                <p class="text-lg font-semibold text-[#6B3E4B] break-words">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-t border-[#EFE3DE] px-4 sm:px-6 py-4">
                            <p class="text-xs text-gray-500">
                                @if ($booking->status === 'pending_payment')
                                    @if ($booking->payment_deadline?->isPast())
                                        <span class="text-red-700">Batas pembayaran telah lewat. Hubungi salon untuk bantuan.</span>
                                    @else
                                        <span class="text-amber-800">Selesaikan pembayaran dalam 1 x 24 jam sejak pemesanan dibuat.</span>
                                        @if ($booking->payment_deadline)
                                            <span class="block mt-1">Batas: {{ $booking->payment_deadline->format('d/m/Y H:i') }} &middot; {{ $booking->payment_deadline->locale('id')->diffForHumans() }}</span>
                                        @endif
                                    @endif
                                @else
                                    Lihat detail untuk informasi reservasi Anda.
                                @endif
                            </p>
                            <a href="{{ route('customer.bookings.show', $booking) }}" aria-label="Lihat detail pemesanan {{ $booking->booking_code }}" class="inline-flex shrink-0 justify-center items-center gap-2 rounded-full bg-[#6B3E4B] text-white px-5 py-2.5 text-xs font-medium hover:bg-[#542d39] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#6B3E4B] focus-visible:ring-offset-2 transition whitespace-nowrap">Lihat Detail <i class="fa-solid fa-arrow-right text-[10px]" aria-hidden="true"></i></a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-[#EFE3DE] py-16 px-5 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-[#F7EFE9] text-[#6B3E4B] flex items-center justify-center mx-auto mb-4"><i class="fa-regular fa-calendar text-2xl" aria-hidden="true"></i></div>
                        <h3 class="text-lg font-semibold text-slate-800">Belum Ada Riwayat Pemesanan</h3>
                        <p class="text-sm text-gray-500 mt-2">Pilih perawatan favorit Anda dan buat pemesanan pertama.</p>
                        <a href="{{ url('/#prices') }}" class="inline-flex mt-5 rounded-full bg-[#6B3E4B] text-white px-5 py-2.5 text-sm hover:bg-[#542d39] transition">Jelajahi Perawatan</a>
                    </div>
                @endforelse
            </div>

            @if ($bookings->total() > 0)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-gray-500">
                    <p>Menampilkan {{ $bookings->firstItem() }} &ndash; {{ $bookings->lastItem() }} dari {{ $bookings->total() }} booking</p>
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
