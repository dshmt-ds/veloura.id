@section('title', 'Laporan & Transaksi')

<x-app-layout>
    <div class="bg-white min-h-screen py-8 text-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="border-b border-slate-200 pb-5">
                <h1 class="text-2xl font-semibold text-slate-900 tracking-tight">
                    Laporan Transaksi & Keuangan
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Pantau pendapatan, riwayat pembayaran, dan performa reservasi Indah Salon
                </p>
            </div>

            {{-- Kartu Ringkasan KPI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total Pendapatan --}}
                <div class="bg-[#F7EFE9] p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Total Pendapatan</p>
                        <h3 class="text-2xl font-semibold break-words text-[#6B3E4B] mt-1">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-[#6B3E4B]/10 text-[#6B3E4B] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                {{-- Total Transaksi --}}
                <div class="bg-[#F7EFE9] p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Total Transaksi</p>
                        <h3 class="text-2xl font-semibold break-words text-gray-800 mt-1">
                            {{ number_format($totalTransactions) }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0 border border-blue-100">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                </div>

                {{-- Transaksi Sukses --}}
                <div class="bg-[#F7EFE9] p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Pembayaran Lunas</p>
                        <h3 class="text-2xl font-semibold break-words text-emerald-600 mt-1">
                            {{ number_format($successfulCount) }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 border border-emerald-100">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                {{-- Menunggu Pembayaran --}}
                <div class="bg-[#F7EFE9] p-5 rounded-2xl border border-slate-200 shadow-sm flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Menunggu Pembayaran</p>
                        <h3 class="text-2xl font-semibold break-words text-amber-600 mt-1">
                            {{ number_format($pendingCount) }}
                        </h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 border border-amber-100">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>

            {{-- Filter Periode & Status --}}
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-slate-900">Saring Laporan</h3>
                    <p class="text-xs text-slate-500 mt-1">Pilih periode transaksi dan status pembayaran.</p>
                </div>
                <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-2" for="start_date">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="w-full min-w-0 h-10 text-sm rounded-xl border-slate-200 bg-white focus:border-[#6B3E4B] focus:ring-[#6B3E4B]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-2" for="end_date">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="w-full min-w-0 h-10 text-sm rounded-xl border-slate-200 bg-white focus:border-[#6B3E4B] focus:ring-[#6B3E4B]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-2" for="status">Status Pembayaran</label>
                        <select id="status" name="status" class="w-full min-w-0 h-10 text-sm rounded-xl border-slate-200 bg-white focus:border-[#6B3E4B] focus:ring-[#6B3E4B]">
                            <option value="all" {{ $selectedStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="paid" {{ $selectedStatus === 'paid' ? 'selected' : '' }}>Lunas</option>
                            <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="failed" {{ $selectedStatus === 'failed' ? 'selected' : '' }}>Gagal</option>
                            <option value="expired" {{ $selectedStatus === 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                            <option value="cancelled" {{ $selectedStatus === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="w-full py-2.5 px-4 bg-[#6B3E4B] hover:bg-[#522e39] text-white text-xs font-semibold rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition flex items-center justify-center">
                            Atur Ulang
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabel Riwayat Transaksi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
                    <h3 class="font-semibold text-base text-[#6B3E4B] flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-[#D8B08C]"></i> Rincian Transaksi
                    </h3>
                    <span class="text-xs text-slate-500 rounded-full bg-slate-100 px-3 py-1.5">{{ number_format($payments->total(), 0, ',', '.') }} transaksi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px] text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider font-semibold border-b border-slate-200">
                                <th class="px-6 py-4">Referensi Transaksi</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Metode Pembayaran</th>
                                <th class="px-6 py-4">Jumlah Biaya</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Waktu Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-gray-700">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="font-mono font-bold text-[#6B3E4B] text-xs">
                                            {{ $payment->payment_reference }}
                                        </p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">
                                            Pemesanan: #{{ $payment->booking->booking_code ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="font-bold text-gray-800 text-sm">
                                            {{ $payment->booking->customer->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $payment->booking->customer->email ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="uppercase text-xs font-semibold px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 border border-gray-200">
                                            {{ $payment->payment_method ?? 'Midtrans' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-[#6B3E4B]">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $st = strtolower($payment->status);
                                            $badgeClasses = match($st) {
                                                'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'failed', 'expired', 'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                default => 'bg-gray-50 text-gray-700 border-gray-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClasses }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ match ($payment->status) { 'paid' => 'Lunas', 'pending' => 'Menunggu Pembayaran', 'failed' => 'Gagal', 'expired' => 'Kedaluwarsa', 'cancelled' => 'Dibatalkan', 'refunded' => 'Dana Dikembalikan', default => $payment->status } }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ $payment->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-slate-500 text-sm">
                                        <i class="fa-solid fa-receipt block text-3xl text-slate-300 mb-3" aria-hidden="true"></i><p class="font-medium text-slate-700">Belum ada transaksi</p><p class="text-xs text-slate-400 mt-1">Coba ubah periode atau status pembayaran yang dipilih.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-3 text-xs text-slate-500 border-t border-slate-100">Menampilkan {{ $payments->firstItem() ?? 0 }}–{{ $payments->lastItem() ?? 0 }} dari {{ $payments->total() }} transaksi</div>
                @if($payments->hasPages())
                    <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
