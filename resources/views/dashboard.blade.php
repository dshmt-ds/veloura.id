@section('title', 'Dasbor')

<x-app-layout>
    @php
        $rupiah = fn ($amount) => 'Rp ' . number_format($amount, 0, ',', '.');
        $statuses = [
            'pending_payment' => 'Menunggu Pembayaran',
            'confirmed' => 'Terkonfirmasi',
            'in_progress' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kedaluwarsa',
            'no_show' => 'Tidak Hadir',
        ];
        $maxRevenue = max(1, $revenueChart->max('total'));
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
        <section class="bg-[#6B3E4B] rounded-2xl p-6 sm:p-8 text-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs text-white/70">{{ now()->translatedFormat('d F Y') }}</p>
                    <h1 class="text-2xl sm:text-3xl font-semibold mt-2">Selamat datang, {{ auth()->user()->name }}</h1>
                    <p class="text-sm text-white/70 mt-2">Ringkasan aktivitas dan pendapatan Indah Salon.</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="bg-white/15 hover:bg-white/20 rounded-full px-4 py-2 text-sm">Lihat Laporan</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mt-6">
                @foreach ([
                    'Pemesanan Hari Ini' => number_format($stats['booking_hari_ini'], 0, ',', '.'),
                    'Pelanggan Baru Hari Ini' => number_format($stats['pelanggan_baru'], 0, ',', '.'),
                    'Pendapatan Hari Ini' => $rupiah($stats['pendapatan_hari_ini']),
                    'Rata-rata Pembayaran Hari Ini' => $rupiah($stats['rata_rata_transaksi']),
                ] as $label => $value)
                    <div class="bg-[#F7EFE9] text-[#6B3E4B] rounded-xl p-4">
                        <p class="text-xs text-gray-500">{{ $label }}</p>
                        <p class="text-2xl font-semibold mt-2 break-words">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-white/60 mt-4">Pemesanan berdasarkan jadwal layanan. Pendapatan dan rata-rata berdasarkan pembayaran lunas pada hari ini.</p>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" aria-label="Statistik keseluruhan">
            @foreach ([
                ['Total Pelanggan', number_format($stats['total_pelanggan'], 0, ',', '.'), 'Akun dengan peran pelanggan'],
                ['Total Layanan', number_format($stats['total_layanan'], 0, ',', '.'), 'Seluruh layanan terdaftar'],
                ['Total Transaksi', number_format($stats['total_transaksi'], 0, ',', '.'), 'Seluruh percobaan pembayaran'],
                ['Total Pendapatan', $rupiah($stats['total_pendapatan']), 'Seluruh pembayaran berstatus lunas'],
            ] as [$label, $value, $description])
                <div class="bg-[#F7EFE9] rounded-2xl border border-[#D8B08C]/30 p-5 shadow-sm">
                    <p class="text-xs text-gray-500">{{ $label }}</p>
                    <p class="text-2xl font-semibold text-[#6B3E4B] mt-2 break-words">{{ $value }}</p>
                    <p class="text-xs text-gray-400 mt-2">{{ $description }}</p>
                </div>
            @endforeach
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <section class="lg:col-span-2 bg-white rounded-2xl border border-[#D8B08C]/30 p-5 shadow-sm">
                <h2 class="font-semibold text-[#6B3E4B]">Analisis Pendapatan</h2>
                <p class="text-xs text-gray-500 mt-1">Pembayaran lunas selama tujuh hari terakhir</p>
                <p class="text-2xl font-semibold mt-4">{{ $rupiah($revenueChart->sum('total')) }}</p>
                <div class="grid grid-cols-7 gap-2 sm:gap-4 mt-6">
                    @foreach ($revenueChart as $day)
                        <div class="text-center min-w-0">
                            <div class="h-40 flex items-end justify-center bg-[#F7EFE9] rounded-lg overflow-hidden" title="{{ $day['label'] }}: {{ $rupiah($day['total']) }}">
                                <div class="w-full bg-[#6B3E4B] rounded-t-lg" style="height: {{ $day['total'] / $maxRevenue * 100 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">{{ $day['label'] }}</p>
                            <p class="text-[10px] text-[#6B3E4B] mt-1 break-words">{{ $rupiah($day['total']) }}</p>
                        </div>
                    @endforeach
                </div>
                @if ($revenueChart->sum('total') == 0)
                    <p class="text-sm text-gray-500 mt-4">Belum ada pembayaran lunas dalam tujuh hari terakhir.</p>
                @endif
            </section>

            <section class="bg-white rounded-2xl border border-[#D8B08C]/30 p-5 shadow-sm">
                <h2 class="font-semibold text-[#6B3E4B]">Ringkasan Operasional</h2>
                <div class="space-y-3 mt-4">
                    @foreach ([
                        ['Pemesanan Menunggu Pembayaran', $stats['menunggu_pembayaran'], route('admin.bookings.index', ['status' => 'pending_payment'])],
                        ['Pembayaran Pending', $stats['pembayaran_pending'], route('admin.reports.index', ['status' => 'pending'])],
                        ['Staf Aktif', $stats['staff_aktif'], route('admin.staffs.index')],
                    ] as [$label, $value, $url])
                        <a href="{{ $url }}" class="flex items-center justify-between gap-3 bg-[#F7EFE9] hover:bg-[#EFE3DE] rounded-xl p-4">
                            <span class="text-sm">{{ $label }}</span>
                            <span class="text-xl font-semibold">{{ number_format($value, 0, ',', '.') }}</span>
                        </a>
                    @endforeach
                </div>
                <p class="text-xs text-gray-400 mt-4">Jumlah keseluruhan dari database. Klik ringkasan untuk membuka halaman terkait.</p>
            </section>
        </div>

        <section class="bg-white rounded-2xl border border-[#D8B08C]/30 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between gap-4 p-5 border-b border-[#F7EFE9]">
                <h2 class="font-semibold text-[#6B3E4B]">Pemesanan Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs text-[#6B3E4B] hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#F7EFE9] text-xs text-gray-500">
                        <tr>
                            <th scope="col" class="px-5 py-3">Kode / Pelanggan</th>
                            <th scope="col" class="px-5 py-3">Layanan</th>
                            <th scope="col" class="px-5 py-3">Jadwal / Staf</th>
                            <th scope="col" class="px-5 py-3">Total</th>
                            <th scope="col" class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F7EFE9]">
                        @forelse ($latestBookings as $booking)
                            <tr>
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="font-medium hover:underline">{{ $booking->booking_code }}</a>
                                    <p class="text-xs text-gray-500 mt-1">{{ $booking->customer?->name ?? 'Pelanggan tidak tersedia' }}</p>
                                </td>
                                <td class="px-5 py-4">{{ $booking->items->pluck('service_name')->join(', ') ?: 'Layanan tidak tersedia' }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    {{ $booking->start_at?->format('d/m/Y H:i') ?? '-' }}
                                    <p class="text-xs text-gray-500 mt-1">{{ $booking->staff?->name ?? 'Staf tidak tersedia' }}</p>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ $rupiah($booking->total_amount) }}</td>
                                <td class="px-5 py-4"><span class="inline-block rounded-full bg-[#F7EFE9] px-3 py-1 text-xs">{{ $statuses[$booking->status] ?? $booking->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">Belum ada pemesanan yang tercatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
