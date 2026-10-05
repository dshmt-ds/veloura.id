@section('title', 'Tambah Jadwal Staff')

<x-app-layout>
    <div class="bg-white min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <a
                    href="{{ route('admin.staff-schedules.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#6B3E4B]"
                >
                    ← Kembali ke Jadwal
                </a>

                <h1 class="text-2xl font-semibold text-[#6B3E4B] mt-4">
                    Tambah Jadwal Staff
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Atur jadwal kerja baru untuk staff Veloura.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-[#EFE3DE] shadow-sm">
                <div class="px-6 py-5 border-b border-[#EFE3DE]">
                    <h2 class="font-semibold text-[#6B3E4B]">
                        Informasi Jadwal
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Pilih staff, tanggal, dan tentukan jam kerjanya.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.staff-schedules.store') }}"
                    class="p-6"
                >
                    @include('admin.staff-schedules._form')

                    <div class="flex justify-end gap-3 mt-7 pt-5 border-t border-[#EFE3DE]">
                        <a
                            href="{{ route('admin.staff-schedules.index') }}"
                            class="px-5 py-2.5 rounded-full border border-[#EFE3DE] text-gray-600 text-sm font-medium hover:bg-[#F7EFE9]"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-full bg-[#6B3E4B] text-white text-sm font-medium hover:bg-[#542d39]"
                        >
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>