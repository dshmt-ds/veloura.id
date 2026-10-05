@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <!-- Nama Staff -->
    <div class="md:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Nama Staff <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $staff->name ?? '') }}"
            placeholder="Contoh: Siti Rahmawati"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none @error('name') border-red-500 @enderror"
            required
        >
        @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- No. Telepon -->
    <div class="md:col-span-2">
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
            No. Telepon
        </label>
        <input
            type="text"
            id="phone"
            name="phone"
            value="{{ old('phone', $staff->phone ?? '') }}"
            placeholder="Contoh: 081234567890"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none @error('phone') border-red-500 @enderror"
        >
        @error('phone')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status Aktif -->
    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-3 cursor-pointer">
            <input
                type="hidden"
                name="is_active"
                value="0"
            >
            <input
                type="checkbox"
                name="is_active"
                value="1"
                class="w-4 h-4 rounded border-[#EFE3DE] text-[#6B3E4B] focus:ring-[#6B3E4B]"
                @checked(old('is_active', $staff->is_active ?? true))
            >
            <span class="text-sm font-medium text-gray-700">Staff Aktif</span>
        </label>
        <p class="text-xs text-gray-400 mt-0.5 ml-7">
            Staff aktif dapat menerima penugasan dan jadwal reservasi pelanggan.
        </p>
    </div>

    <!-- Layanan yang Dikuasai -->
    <div class="md:col-span-2 pt-4 border-t border-[#EFE3DE]">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Layanan yang Dikuasai
        </label>

        @if (isset($services) && $services->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-60 overflow-y-auto p-3 bg-[#FCFAF8] rounded-xl border border-[#EFE3DE]">
                @foreach ($services as $service)
                    @php
                        $selectedServices = old('services', isset($staff) ? $staff->services->pluck('id')->toArray() : []);
                    @endphp
                    <label class="flex items-center gap-2.5 p-2.5 rounded-lg bg-white border border-[#EFE3DE] hover:border-[#6B3E4B] cursor-pointer transition">
                        <input
                            type="checkbox"
                            name="services[]"
                            value="{{ $service->id }}"
                            class="w-4 h-4 rounded border-[#EFE3DE] text-[#6B3E4B] focus:ring-[#6B3E4B]"
                            @checked(in_array($service->id, $selectedServices))
                        >
                        <span class="text-sm text-slate-700 font-medium">{{ $service->name }}</span>
                    </label>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400 italic">Belum ada data layanan. Silakan tambahkan layanan terlebih dahulu.</p>
        @endif

        @error('services')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>