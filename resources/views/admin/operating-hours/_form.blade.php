@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5" x-data="{ isClosed: {{ old('is_closed', isset($operatingHour) && $operatingHour->is_closed ? 'true' : 'false') }} }">

    <!-- Hari -->
    <div class="md:col-span-2">
        <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-2">
            Hari <span class="text-red-500">*</span>
        </label>
        <select
            id="day_of_week"
            name="day_of_week"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none cursor-pointer @error('day_of_week') border-red-500 @enderror"
            required
        >
            <option value="">-- Pilih Hari --</option>
            @php
                $days = [
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jumat',
                    6 => 'Sabtu',
                    7 => 'Minggu',
                ];
            @endphp
            @foreach ($days as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(old('day_of_week', $operatingHour->day_of_week ?? '') == $value)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('day_of_week')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status Libur / Tutup -->
    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-3 cursor-pointer">
            <input type="hidden" name="is_closed" value="0">
            <input
                type="checkbox"
                name="is_closed"
                value="1"
                x-model="isClosed"
                class="w-4 h-4 rounded border-[#EFE3DE] text-[#6B3E4B] focus:ring-[#6B3E4B]"
                @checked(old('is_closed', $operatingHour->is_closed ?? false))
            >
            <span class="text-sm font-medium text-gray-700">Tutup / Libur Pada Hari Ini</span>
        </label>
        <p class="text-xs text-gray-400 mt-0.5 ml-7">
            Jika dicentang, jam buka dan jam tutup tidak wajib diisi.
        </p>
    </div>

    <!-- Jam Buka -->
    <div>
        <label for="open_time" class="block text-sm font-medium text-gray-700 mb-2">
            Jam Buka
        </label>
        <input
            type="time"
            id="open_time"
            name="open_time"
            :disabled="isClosed"
            value="{{ old('open_time', isset($operatingHour->open_time) ? \Carbon\Carbon::parse($operatingHour->open_time)->format('H:i') : '') }}"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none disabled:bg-gray-100 disabled:cursor-not-allowed @error('open_time') border-red-500 @enderror"
        >
        @error('open_time')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Jam Tutup -->
    <div>
        <label for="close_time" class="block text-sm font-medium text-gray-700 mb-2">
            Jam Tutup
        </label>
        <input
            type="time"
            id="close_time"
            name="close_time"
            :disabled="isClosed"
            value="{{ old('close_time', isset($operatingHour->close_time) ? \Carbon\Carbon::parse($operatingHour->close_time)->format('H:i') : '') }}"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none disabled:bg-gray-100 disabled:cursor-not-allowed @error('close_time') border-red-500 @enderror"
        >
        @error('close_time')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>