@section('title', 'Laporan & Transaksi')

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#6B3E4B] leading-tight">
                    Laporan Transaksi & Keuangan
                </h2>
                <p class="text-xs text-[#8b686e] mt-1">
                    Pantau pendapatan, riwayat pembayaran, dan performa reservasi Veloura Studio
                </p>
            </div>
        </div>
    </x-slot>

    <div class="bg-[#F7EFE9] min-h-[calc(100vh-160px)] py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Ringkasan KPI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Total Pendapatan --}}
                <div class="bg-white p-5 rounded-3xl border border-[#EFE3DE] shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-xl font-bold text-[#6B3E4B] mt-1">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-[#6B3E4B]/10 text-[#6B3E4B] flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                {{-- Total Transaksi --}}
                <div class="bg-white p-5 rounded-3xl border border-[#EFE3DE] shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Transaksi</p>
                        <h3 class="text-xl font-bold text-gray-800 mt-1">
                            {{ number_format($totalTransactions) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0 border border-blue-100">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                </div>

                {{-- Transaksi Sukses --}}
                <div class="bg-white p-5 rounded-3xl border border-[#EFE3DE] shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pembayaran Lunas</p>
                        <h3 class="text-xl font-bold text-emerald-600 mt-1">
                            {{ number_format($successfulCount) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 border border-emerald-100">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                {{-- Menunggu Pembayaran --}}
                <div class="bg-white p-5 rounded-3xl border border-[#EFE3DE] shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Menunggu Pembayaran</p>
                        <h3 class="text-xl font-bold text-amber-600 mt-1">
                            {{ number_format($pendingCount) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 border border-amber-100">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>
            </div>

            {{-- Filter Periode & Status --}}
            <div class="bg-white p-6 rounded-3xl border border-[#EFE3DE] shadow-sm">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-[#6B3E4B] uppercase tracking-wider mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs rounded-xl border-[#EFE3DE] focus:border-[#6B3E4B] focus:ring-[#6B3E4B]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#6B3E4B] uppercase tracking-wider mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs rounded-xl border-[#EFE3DE] focus:border-[#6B3E4B] focus:ring-[#6B3E4B]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#6B3E4B] uppercase tracking-wider mb-2">Status Pembayaran</label>
                        <select name="status" class="w-full text-xs rounded-xl border-[#EFE3DE] focus:border-[#6B3E4B] focus:ring-[#6B3E4B]">
                            <option value="all" {{ $selectedStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="paid" {{ $selectedStatus === 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                            <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ $selectedStatus === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="expired" {{ $selectedStatus === 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="cancelled" {{ $selectedStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="w-full py-2.5 px-4 bg-[#6B3E4B] hover:bg-[#522e39] text-white text-xs font-semibold rounded-xl transition shadow-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabel Riwayat Transaksi --}}
            <div class="bg-white rounded-3xl shadow-sm border border-[#EFE3DE] overflow-hidden">
                <div class="p-6 border-b border-[#EFE3DE] flex items-center justify-between bg-white/50">
                    <h3 class="font-semibold text-base text-[#6B3E4B] flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-[#D8B08C]"></i> Rincian Transaksi
                    </h3>
                    <span class="text-xs text-gray-400">Total Data: {{ $payments->total() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F7EFE9]/50 text-[#6B3E4B] uppercase text-[11px] tracking-wider font-semibold border-b border-[#EFE3DE]">
                                <th class="px-6 py-4">Referensi Transaksi</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Metode & Metode Pembayaran</th>
                                <th class="px-6 py-4">Jumlah Biaya</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Waktu Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#EFE3DE] text-sm text-gray-700">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-[#F7EFE9]/30 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="font-mono font-bold text-[#6B3E4B] text-xs">
                                            {{ $payment->payment_reference }}
                                        </p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">
                                            Booking: #{{ $payment->booking->booking_code ?? '-' }}
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
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ $payment->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
                                        Tidak ada data transaksi pada rentang periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($payments->hasPages())
                    <div class="p-4 border-t border-[#EFE3DE] bg-[#F7EFE9]/20">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>