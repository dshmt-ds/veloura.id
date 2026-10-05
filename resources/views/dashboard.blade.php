@section('title', 'Dashboard')

<x-app-layout>

    <div class="bg-white min-h-screen">
        <div class="px-4 sm:px-6 lg:px-8 pt-6">

            <div class="max-w-7xl mx-auto">

                <div class="bg-[#6B3E4B] rounded-2xl p-6 sm:p-7 text-white shadow-sm">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                        <div>

                            <div class="flex flex-wrap items-center gap-3">

                                <h1 class="text-2xl sm:text-3xl font-semibold">
                                    Selamat datang, {{ Auth::user()->name }}
                                </h1>

                                <span class="text-[10px] bg-white/15 px-2.5 py-1 rounded-full">
                                    {{ now()->translatedFormat('d F Y') }}
                                </span>

                            </div>

                            <p class="text-sm text-white/70 mt-1">
                                Berikut ringkasan performa penjualan Veloura hari ini.
                            </p>

                        </div>

                        <div class="flex items-center gap-2">

                            <button
                                type="button"
                                class="px-4 py-2 rounded-full text-xs font-medium
                                       bg-white/10 hover:bg-white/20 transition"
                            >
                                Export
                            </button>

                            <button
                                type="button"
                                class="w-9 h-9 rounded-full
                                       bg-white/10 hover:bg-white/20
                                       flex items-center justify-center transition"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M4 4v5h5M20 20v-5h-5M5.5 9A7 7 0 0117.9 5.2L20 7M18.5 15A7 7 0 016.1 18.8L4 17"
                                    />
                                </svg>
                            </button>

                        </div>

                    </div>


                    <!-- Mini Stats -->

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mt-6">

                        <div class="bg-white/10 rounded-xl p-4">

                            <p class="text-xs text-white/65">
                                Booking Hari Ini
                            </p>

                            <div class="flex items-end justify-between mt-2">

                                <h3 class="text-2xl font-semibold">
                                    47
                                </h3>

                                <span class="text-[10px] text-[#D8B08C]">
                                    +12.5%
                                </span>

                            </div>

                        </div>


                        <div class="bg-white/10 rounded-xl p-4">

                            <p class="text-xs text-white/65">
                                Pelanggan Baru
                            </p>

                            <div class="flex items-end justify-between mt-2">

                                <h3 class="text-2xl font-semibold">
                                    23
                                </h3>

                                <span class="text-[10px] text-[#D8B08C]">
                                    +8.2%
                                </span>

                            </div>

                        </div>


                        <div class="bg-white/10 rounded-xl p-4">

                            <p class="text-xs text-white/65">
                                Pendapatan Hari Ini
                            </p>

                            <div class="flex items-end justify-between mt-2">

                                <h3 class="text-2xl font-semibold">
                                    Rp 4,8 Jt
                                </h3>

                                <span class="text-[10px] text-[#D8B08C]">
                                    +15.3%
                                </span>

                            </div>

                        </div>


                        <div class="bg-white/10 rounded-xl p-4">

                            <p class="text-xs text-white/65">
                                Rata-rata Transaksi
                            </p>

                            <div class="flex items-end justify-between mt-2">

                                <h3 class="text-2xl font-semibold">
                                    Rp 102K
                                </h3>

                                <span class="text-[10px] text-[#D8B08C]">
                                    +5.8%
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ============================= -->
        <!-- MAIN CONTENT -->
        <!-- ============================= -->

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">


            <!-- ============================= -->
            <!-- STATISTIC CARDS -->
            <!-- ============================= -->

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


                <!-- Total Pelanggan -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs text-gray-500">
                                Total Pelanggan
                            </p>

                            <h3 class="text-2xl font-semibold text-[#6B3E4B] mt-2">
                                12,543
                            </h3>

                            <p class="text-[11px] text-[#D8B08C] mt-1">
                                +12.5% dari bulan lalu
                            </p>

                        </div>

                        <div class="w-10 h-10 rounded-xl bg-[#F7EFE9]
                                    flex items-center justify-center">

                            <svg
                                class="w-5 h-5 text-[#6B3E4B]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2
                                    M9 11a4 4 0 100-8 4 4 0 000 8z
                                    M22 21v-2a4 4 0 00-3-3.87
                                    M16 3.13a4 4 0 010 7.75"
                                />
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4">

                        <div class="h-1.5 bg-[#F7EFE9] rounded-full overflow-hidden">

                            <div
                                class="h-full w-[75%] bg-[#6B3E4B] rounded-full"
                            ></div>

                        </div>

                        <div class="flex justify-between mt-1">

                            <span class="text-[9px] text-gray-400">
                                Progress
                            </span>

                            <span class="text-[9px] text-gray-400">
                                75%
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Total Layanan -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs text-gray-500">
                                Total Layanan
                            </p>

                            <h3 class="text-2xl font-semibold text-[#6B3E4B] mt-2">
                                28
                            </h3>

                            <p class="text-[11px] text-[#D8B08C] mt-1">
                                +8.2% dari bulan lalu
                            </p>

                        </div>

                        <div class="w-10 h-10 rounded-xl bg-[#F7EFE9]
                                    flex items-center justify-center">

                            <svg
                                class="w-5 h-5 text-[#6B3E4B]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M4 7h16M4 12h16M4 17h16"
                                />
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4">

                        <div class="h-1.5 bg-[#F7EFE9] rounded-full">

                            <div
                                class="h-full w-[82%] bg-[#D8B08C] rounded-full"
                            ></div>

                        </div>

                        <div class="flex justify-between mt-1">

                            <span class="text-[9px] text-gray-400">
                                Progress
                            </span>

                            <span class="text-[9px] text-gray-400">
                                82%
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Total Transaksi -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs text-gray-500">
                                Total Transaksi
                            </p>

                            <h3 class="text-2xl font-semibold text-[#6B3E4B] mt-2">
                                9,238
                            </h3>

                            <p class="text-[11px] text-[#D8B08C] mt-1">
                                +15.3% dari bulan lalu
                            </p>

                        </div>

                        <div class="w-10 h-10 rounded-xl bg-[#F7EFE9]
                                    flex items-center justify-center">

                            <svg
                                class="w-5 h-5 text-[#6B3E4B]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M3 10h18M7 15h.01M11 15h2
                                    M5 5h14a2 2 0 012 2v10a2 2
                                    0 01-2 2H5a2 2 0 01-2-2V7
                                    a2 2 0 012-2z"
                                />
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4">

                        <div class="h-1.5 bg-[#F7EFE9] rounded-full">

                            <div
                                class="h-full w-[85%] bg-[#6B3E4B] rounded-full"
                            ></div>

                        </div>

                        <div class="flex justify-between mt-1">

                            <span class="text-[9px] text-gray-400">
                                Progress
                            </span>

                            <span class="text-[9px] text-gray-400">
                                85%
                            </span>

                        </div>

                    </div>

                </div>


                <!-- Total Pendapatan -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            p-5 shadow-sm">

                    <div class="flex items-start justify-between">

                        <div>

                            <p class="text-xs text-gray-500">
                                Total Pendapatan
                            </p>

                            <h3 class="text-2xl font-semibold text-[#6B3E4B] mt-2">
                                Rp 24,8 Jt
                            </h3>

                            <p class="text-[11px] text-[#D8B08C] mt-1">
                                +23.7% dari bulan lalu
                            </p>

                        </div>

                        <div class="w-10 h-10 rounded-xl bg-[#F7EFE9]
                                    flex items-center justify-center">

                            <svg
                                class="w-5 h-5 text-[#6B3E4B]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.7"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2
                                    3 2 3 .895 3 2-1.343 2-3 2m0-10V6m0
                                    12v-2m9-4a9 9 0 11-18 0 9 9 0
                                    0118 0z"
                                />
                            </svg>

                        </div>

                    </div>

                    <div class="mt-4">

                        <div class="h-1.5 bg-[#F7EFE9] rounded-full">

                            <div
                                class="h-full w-[90%] bg-[#D8B08C] rounded-full"
                            ></div>

                        </div>

                        <div class="flex justify-between mt-1">

                            <span class="text-[9px] text-gray-400">
                                Progress
                            </span>

                            <span class="text-[9px] text-gray-400">
                                90%
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ============================= -->
            <!-- REVENUE + ACTIVITY -->
            <!-- ============================= -->

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">


                <!-- Revenue Analytics -->

                <div class="lg:col-span-2 bg-white rounded-2xl
                            border border-[#D8B08C]/30 shadow-sm">

                    <div class="px-5 py-4 border-b border-[#F7EFE9]">

                        <div class="flex flex-col sm:flex-row
                                    sm:items-center sm:justify-between gap-3">

                            <div>

                                <h3 class="font-semibold text-[#6B3E4B]">
                                    Analisis Pendapatan
                                </h3>

                                <p class="text-xs text-gray-400 mt-1">
                                    Performa pendapatan layanan Veloura
                                </p>

                            </div>

                            <div class="flex gap-1 bg-[#F7EFE9] p-1 rounded-lg">

                                <button
                                    class="px-3 py-1.5 rounded-md bg-[#6B3E4B]
                                           text-white text-[10px]"
                                >
                                    Bulan Ini
                                </button>

                                <button
                                    class="px-3 py-1.5 rounded-md
                                           text-gray-500 text-[10px]"
                                >
                                    Tahun Ini
                                </button>

                            </div>

                        </div>

                    </div>


                    <div class="p-5">

                        <!-- January -->

                        <div class="mb-5">

                            <div class="flex justify-between items-center mb-2">

                                <div>

                                    <p class="text-xs font-medium text-gray-700">
                                        Januari
                                    </p>

                                    <p class="text-[9px] text-gray-400">
                                        842 transaksi
                                    </p>

                                </div>

                                <div class="text-right">

                                    <span class="text-[9px] text-[#D8B08C]">
                                        +12.5%
                                    </span>

                                    <p class="text-xs font-semibold text-[#6B3E4B]">
                                        Rp 18,4 Jt
                                    </p>

                                </div>

                            </div>

                            <div class="h-7 bg-[#F7EFE9] rounded-lg overflow-hidden">

                                <div
                                    class="h-full w-[68%] bg-[#6B3E4B]
                                           rounded-lg flex items-center justify-end px-3"
                                >
                                    <span class="text-[9px] text-white">
                                        68%
                                    </span>
                                </div>

                            </div>

                        </div>


                        <!-- February -->

                        <div class="mb-5">

                            <div class="flex justify-between items-center mb-2">

                                <div>

                                    <p class="text-xs font-medium text-gray-700">
                                        Februari
                                    </p>

                                    <p class="text-[9px] text-gray-400">
                                        1,024 transaksi
                                    </p>

                                </div>

                                <div class="text-right">

                                    <span class="text-[9px] text-[#D8B08C]">
                                        +22.2%
                                    </span>

                                    <p class="text-xs font-semibold text-[#6B3E4B]">
                                        Rp 22,2 Jt
                                    </p>

                                </div>

                            </div>

                            <div class="h-7 bg-[#F7EFE9] rounded-lg overflow-hidden">

                                <div
                                    class="h-full w-[78%] bg-[#D8B08C]
                                           rounded-lg flex items-center justify-end px-3"
                                >
                                    <span class="text-[9px] text-[#6B3E4B]">
                                        78%
                                    </span>
                                </div>

                            </div>

                        </div>


                        <!-- March -->

                        <div>

                            <div class="flex justify-between items-center mb-2">

                                <div>

                                    <p class="text-xs font-medium text-gray-700">
                                        Maret
                                    </p>

                                    <p class="text-[9px] text-gray-400">
                                        1,150 transaksi
                                    </p>

                                </div>

                                <div class="text-right">

                                    <span class="text-[9px] text-[#D8B08C]">
                                        +31.7%
                                    </span>

                                    <p class="text-xs font-semibold text-[#6B3E4B]">
                                        Rp 24,8 Jt
                                    </p>

                                </div>

                            </div>

                            <div class="h-7 bg-[#F7EFE9] rounded-lg overflow-hidden">

                                <div
                                    class="h-full w-[85%] bg-[#6B3E4B]
                                           rounded-lg flex items-center justify-end px-3"
                                >
                                    <span class="text-[9px] text-white">
                                        85%
                                    </span>
                                </div>

                            </div>

                        </div>


                        <!-- Summary -->

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6">

                            <div class="bg-[#F7EFE9] rounded-xl p-3">

                                <p class="text-[9px] text-gray-400">
                                    Total Revenue
                                </p>

                                <p class="text-sm font-semibold text-[#6B3E4B] mt-1">
                                    Rp 64 Jt
                                </p>

                            </div>

                            <div class="bg-[#F7EFE9] rounded-xl p-3">

                                <p class="text-[9px] text-gray-400">
                                    Growth
                                </p>

                                <p class="text-sm font-semibold text-[#6B3E4B] mt-1">
                                    +18.5%
                                </p>

                            </div>

                            <div class="bg-[#F7EFE9] rounded-xl p-3">

                                <p class="text-[9px] text-gray-400">
                                    Service Revenue
                                </p>

                                <p class="text-sm font-semibold text-[#6B3E4B] mt-1">
                                    Rp 21,3 Jt
                                </p>

                            </div>

                            <div class="bg-[#F7EFE9] rounded-xl p-3">

                                <p class="text-[9px] text-gray-400">
                                    Transaksi
                                </p>

                                <p class="text-sm font-semibold text-[#6B3E4B] mt-1">
                                    3,022
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Activity -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            shadow-sm">

                    <div class="px-5 py-4 border-b border-[#F7EFE9]">

                        <div class="flex items-center justify-between">

                            <div>

                                <h3 class="font-semibold text-[#6B3E4B]">
                                    Aktivitas Terbaru
                                </h3>

                                <p class="text-xs text-gray-400 mt-1">
                                    Booking dan transaksi terbaru
                                </p>

                            </div>

                            <span class="flex items-center gap-1 text-[9px] text-green-600">

                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>

                                Live

                            </span>

                        </div>

                    </div>


                    <div class="p-5">

                        <div class="space-y-4">


                            <!-- Activity 1 -->

                            <div class="flex gap-3">

                                <div class="w-8 h-8 rounded-full bg-[#F7EFE9]
                                            flex items-center justify-center shrink-0">

                                    <svg
                                        class="w-4 h-4 text-[#6B3E4B]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            d="M12 6v6l4 2"
                                        />
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                            stroke-width="1.7"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="text-[11px] text-gray-600">
                                        Booking baru dari
                                        <span class="font-medium text-[#6B3E4B]">
                                            Amanda
                                        </span>
                                    </p>

                                    <p class="text-[9px] text-gray-400 mt-1">
                                        Facial Treatment • Rp 450K
                                    </p>

                                    <p class="text-[8px] text-gray-400 mt-1">
                                        5 menit lalu
                                    </p>

                                </div>

                            </div>


                            <!-- Activity 2 -->

                            <div class="flex gap-3">

                                <div class="w-8 h-8 rounded-full bg-[#F7EFE9]
                                            flex items-center justify-center shrink-0">

                                    <svg
                                        class="w-4 h-4 text-[#D8B08C]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            d="M5 12l4 4L19 6"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="text-[11px] text-gray-600">
                                        Pembayaran diterima dari
                                        <span class="font-medium text-[#6B3E4B]">
                                            Farah
                                        </span>
                                    </p>

                                    <p class="text-[9px] text-gray-400 mt-1">
                                        Hair Treatment • Rp 650K
                                    </p>

                                    <p class="text-[8px] text-gray-400 mt-1">
                                        12 menit lalu
                                    </p>

                                </div>

                            </div>


                            <!-- Activity 3 -->

                            <div class="flex gap-3">

                                <div class="w-8 h-8 rounded-full bg-[#F7EFE9]
                                            flex items-center justify-center shrink-0">

                                    <svg
                                        class="w-4 h-4 text-[#6B3E4B]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            d="M12 3v18M3 12h18"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="text-[11px] text-gray-600">
                                        Layanan baru ditambahkan
                                    </p>

                                    <p class="text-[9px] text-gray-400 mt-1">
                                        Premium Hair Spa
                                    </p>

                                    <p class="text-[8px] text-gray-400 mt-1">
                                        32 menit lalu
                                    </p>

                                </div>

                            </div>


                            <!-- Activity 4 -->

                            <div class="flex gap-3">

                                <div class="w-8 h-8 rounded-full bg-[#F7EFE9]
                                            flex items-center justify-center shrink-0">

                                    <svg
                                        class="w-4 h-4 text-[#D8B08C]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            d="M5 12l4 4L19 6"
                                        />
                                    </svg>

                                </div>

                                <div>

                                    <p class="text-[11px] text-gray-600">
                                        Booking selesai
                                    </p>

                                    <p class="text-[9px] text-gray-400 mt-1">
                                        Nail Art • Rp 250K
                                    </p>

                                    <p class="text-[8px] text-gray-400 mt-1">
                                        1 jam lalu
                                    </p>

                                </div>

                            </div>

                        </div>


                        <a
                            href="{{ Route::has('bookings.index') ? route('bookings.index') : '#' }}"
                            class="block text-center text-[10px] font-medium
                                   text-[#6B3E4B] hover:text-[#542d39] mt-5"
                        >
                            Lihat Semua Aktivitas
                        </a>

                    </div>

                </div>

            </div>


            <!-- ============================= -->
            <!-- QUICK ACTIONS + BEST SELLER -->
            <!-- ============================= -->

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">


                <!-- Quick Actions -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            shadow-sm">

                    <div class="px-5 py-4 border-b border-[#F7EFE9]">

                        <h3 class="font-semibold text-[#6B3E4B]">
                            Quick Actions
                        </h3>

                        <p class="text-xs text-gray-400 mt-1">
                            Akses cepat untuk mengelola salon
                        </p>

                    </div>


                    <div class="p-5 grid grid-cols-2 gap-3">

                        <a
                            href="{{ Route::has('services.create') ? route('services.create') : '#' }}"
                            class="rounded-xl bg-[#6B3E4B] p-4 text-white
                                   hover:bg-[#542d39] transition"
                        >

                            <svg
                                class="w-5 h-5 mb-3"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    d="M12 5v14M5 12h14"
                                />
                            </svg>

                            <p class="text-xs font-medium">
                                Tambah Layanan
                            </p>

                            <p class="text-[9px] text-white/60 mt-1">
                                Buat layanan baru
                            </p>

                        </a>


                        <a
                            href="{{ Route::has('bookings.index') ? route('bookings.index') : '#' }}"
                            class="rounded-xl bg-[#D8B08C] p-4 text-[#6B3E4B]
                                   hover:opacity-90 transition"
                        >

                            <svg
                                class="w-5 h-5 mb-3"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14
                                    a2 2 0 002-2V7a2 2 0 00-2-2H5
                                    a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>

                            <p class="text-xs font-medium">
                                Booking
                            </p>

                            <p class="text-[9px] opacity-70 mt-1">
                                Kelola booking
                            </p>

                        </a>


                        <a
                            href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}"
                            class="rounded-xl bg-[#F7EFE9] p-4 text-[#6B3E4B]
                                   border border-[#D8B08C]/30
                                   hover:bg-[#EFE2D8] transition"
                        >

                            <svg
                                class="w-5 h-5 mb-3"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    d="M9 17v-6m4 6V7m4 10v-3
                                    M5 21h14a2 2 0 002-2V5
                                    a2 2 0 00-2-2H5a2 2 0 00-2 2v14
                                    a2 2 0 002 2z"
                                />
                            </svg>

                            <p class="text-xs font-medium">
                                Laporan
                            </p>

                            <p class="text-[9px] opacity-70 mt-1">
                                Analisis data
                            </p>

                        </a>


                        <a
                            href="{{ Route::has('schedules.index') ? route('schedules.index') : '#' }}"
                            class="rounded-xl bg-[#6B3E4B] p-4 text-white
                                   hover:bg-[#542d39] transition"
                        >

                            <svg
                                class="w-5 h-5 mb-3"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    d="M12 8v4l3 2"
                                />
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke-width="1.7"
                                />
                            </svg>

                            <p class="text-xs font-medium">
                                Jadwal
                            </p>

                            <p class="text-[9px] text-white/60 mt-1">
                                Atur operasional
                            </p>

                        </a>

                    </div>

                </div>


                <!-- Best Sellers -->

                <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                            shadow-sm">

                    <div class="px-5 py-4 border-b border-[#F7EFE9]">

                        <div class="flex items-center justify-between">

                            <div>

                                <h3 class="font-semibold text-[#6B3E4B]">
                                    Layanan Terlaris
                                </h3>

                                <p class="text-xs text-gray-400 mt-1">
                                    Layanan dengan transaksi terbanyak
                                </p>

                            </div>

                            <a
                                href="{{ Route::has('services.index') ? route('services.index') : '#' }}"
                                class="text-[10px] font-medium text-[#6B3E4B]"
                            >
                                Lihat Semua →
                            </a>

                        </div>

                    </div>


                    <div class="p-5 space-y-4">


                        <!-- Service 1 -->

                        <div class="flex items-center gap-3">

                            <div class="w-9 h-9 rounded-full bg-[#D8B08C]
                                        flex items-center justify-center
                                        text-xs font-semibold text-[#6B3E4B]">
                                01
                            </div>

                            <div class="flex-1">

                                <div class="flex justify-between gap-3">

                                    <div>

                                        <p class="text-xs font-medium text-gray-700">
                                            Premium Hair Spa
                                        </p>

                                        <p class="text-[9px] text-gray-400">
                                            245 transaksi
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p class="text-xs font-semibold text-[#6B3E4B]">
                                            Rp 8,4 Jt
                                        </p>

                                        <p class="text-[9px] text-[#D8B08C]">
                                            +14.5%
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Service 2 -->

                        <div class="flex items-center gap-3">

                            <div class="w-9 h-9 rounded-full bg-[#F7EFE9]
                                        flex items-center justify-center
                                        text-xs font-semibold text-[#6B3E4B]">
                                02
                            </div>

                            <div class="flex-1">

                                <div class="flex justify-between gap-3">

                                    <div>

                                        <p class="text-xs font-medium text-gray-700">
                                            Facial Treatment
                                        </p>

                                        <p class="text-[9px] text-gray-400">
                                            198 transaksi
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p class="text-xs font-semibold text-[#6B3E4B]">
                                            Rp 6,8 Jt
                                        </p>

                                        <p class="text-[9px] text-[#D8B08C]">
                                            +10.2%
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Service 3 -->

                        <div class="flex items-center gap-3">

                            <div class="w-9 h-9 rounded-full bg-[#F7EFE9]
                                        flex items-center justify-center
                                        text-xs font-semibold text-[#6B3E4B]">
                                03
                            </div>

                            <div class="flex-1">

                                <div class="flex justify-between gap-3">

                                    <div>

                                        <p class="text-xs font-medium text-gray-700">
                                            Nail Art
                                        </p>

                                        <p class="text-[9px] text-gray-400">
                                            167 transaksi
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p class="text-xs font-semibold text-[#6B3E4B]">
                                            Rp 5,2 Jt
                                        </p>

                                        <p class="text-[9px] text-[#D8B08C]">
                                            +8.7%
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Service 4 -->

                        <div class="flex items-center gap-3">

                            <div class="w-9 h-9 rounded-full bg-[#F7EFE9]
                                        flex items-center justify-center
                                        text-xs font-semibold text-[#6B3E4B]">
                                04
                            </div>

                            <div class="flex-1">

                                <div class="flex justify-between gap-3">

                                    <div>

                                        <p class="text-xs font-medium text-gray-700">
                                            Manicure & Pedicure
                                        </p>

                                        <p class="text-[9px] text-gray-400">
                                            142 transaksi
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p class="text-xs font-semibold text-[#6B3E4B]">
                                            Rp 4,7 Jt
                                        </p>

                                        <p class="text-[9px] text-[#D8B08C]">
                                            +6.5%
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ============================= -->
            <!-- PENDING ACTIONS -->
            <!-- ============================= -->

            <div class="bg-white rounded-2xl border border-[#D8B08C]/30
                        shadow-sm mb-6">

                <div class="px-5 py-4 border-b border-[#F7EFE9]">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="font-semibold text-[#6B3E4B]">
                                Perlu Diproses
                            </h3>

                            <p class="text-xs text-gray-400 mt-1">
                                Aktivitas yang membutuhkan perhatian
                            </p>

                        </div>

                        <span class="text-[10px] text-[#6B3E4B]
                                     bg-[#F7EFE9] px-3 py-1 rounded-full">
                            25 Pending
                        </span>

                    </div>

                </div>


                <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-4">


                    <!-- Pending Booking -->

                    <div class="bg-[#F7EFE9] rounded-xl p-4">

                        <div class="flex items-start justify-between">

                            <div class="w-9 h-9 rounded-lg bg-[#D8B08C]
                                        flex items-center justify-center">

                                <svg
                                    class="w-4 h-4 text-[#6B3E4B]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14
                                        a2 2 0 002-2V7a2 2 0 00-2-2H5
                                        a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>

                            </div>

                            <span class="bg-[#D8B08C] text-[#6B3E4B]
                                         text-[10px] font-semibold
                                         px-2 py-1 rounded-full">
                                12
                            </span>

                        </div>

                        <h4 class="text-xs font-semibold text-[#6B3E4B] mt-3">
                            Booking Menunggu
                        </h4>

                        <p class="text-[9px] text-gray-500 mt-1">
                            Booking baru yang perlu dikonfirmasi.
                        </p>

                        <a
                            href="{{ Route::has('bookings.index') ? route('bookings.index') : '#' }}"
                            class="block text-center mt-3
                                   bg-[#6B3E4B] text-white
                                   py-2 rounded-lg text-[10px]
                                   hover:bg-[#542d39] transition"
                        >
                            Proses Sekarang →
                        </a>

                    </div>


                    <!-- Transaction -->

                    <div class="bg-[#F7EFE9] rounded-xl p-4">

                        <div class="flex items-start justify-between">

                            <div class="w-9 h-9 rounded-lg bg-[#6B3E4B]
                                        flex items-center justify-center">

                                <svg
                                    class="w-4 h-4 text-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        d="M3 10h18M7 15h.01M11 15h2
                                        M5 5h14a2 2 0 012 2v10a2 2
                                        0 01-2 2H5a2 2 0 01-2-2V7
                                        a2 2 0 012-2z"
                                    />
                                </svg>

                            </div>

                            <span class="bg-[#6B3E4B] text-white
                                         text-[10px] font-semibold
                                         px-2 py-1 rounded-full">
                                8
                            </span>

                        </div>

                        <h4 class="text-xs font-semibold text-[#6B3E4B] mt-3">
                            Transaksi Pending
                        </h4>

                        <p class="text-[9px] text-gray-500 mt-1">
                            Pembayaran yang perlu diverifikasi.
                        </p>

                        <a
                            href="{{ Route::has('transactions.index') ? route('transactions.index') : '#' }}"
                            class="block text-center mt-3
                                   bg-[#6B3E4B] text-white
                                   py-2 rounded-lg text-[10px]
                                   hover:bg-[#542d39] transition"
                        >
                            Lihat Transaksi →
                        </a>

                    </div>


                    <!-- Report -->

                    <div class="bg-[#F7EFE9] rounded-xl p-4">

                        <div class="flex items-start justify-between">

                            <div class="w-9 h-9 rounded-lg bg-[#6B3E4B]
                                        flex items-center justify-center">

                                <svg
                                    class="w-4 h-4 text-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        d="M9 17v-6m4 6V7m4 10v-3
                                        M5 21h14a2 2 0 002-2V5
                                        a2 2 0 00-2-2H5a2 2 0
                                        00-2 2v14a2 2 0 002 2z"
                                    />
                                </svg>

                            </div>

                            <span class="bg-[#D8B08C] text-[#6B3E4B]
                                         text-[10px] font-semibold
                                         px-2 py-1 rounded-full">
                                5
                            </span>

                        </div>

                        <h4 class="text-xs font-semibold text-[#6B3E4B] mt-3">
                            Laporan Perlu Dicek
                        </h4>

                        <p class="text-[9px] text-gray-500 mt-1">
                            Laporan penjualan yang belum diperiksa.
                        </p>

                        <a
                            href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}"
                            class="block text-center mt-3
                                   bg-[#6B3E4B] text-white
                                   py-2 rounded-lg text-[10px]
                                   hover:bg-[#542d39] transition"
                        >
                            Lihat Laporan →
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>