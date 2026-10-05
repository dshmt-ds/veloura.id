@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <!-- Pilih Staff -->
    <div class="md:col-span-2">
        <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-2">
            Pilih Staff <span class="text-red-500">*</span>
        </label>
        <select
            id="staff_id"
            name="staff_id"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none cursor-pointer @error('staff_id') border-red-500 @enderror"
            required
        >
            <option value="">-- Pilih Staff --</option>
            @foreach ($staffs as $staff)
                <option
                    value="{{ $staff->id }}"
                    @selected(old('staff_id', $staffSchedule->staff_id ?? '') == $staff->id)
                >
                    {{ $staff->name }}
                </option>
            @endforeach
        </select>
        @error('staff_id')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tanggal Jadwal -->
    <div class="md:col-span-2">
        <label for="schedule_date" class="block text-sm font-medium text-gray-700 mb-2">
            Tanggal <span class="text-red-500">*</span>
        </label>
        <input
            type="date"
            id="schedule_date"
            name="schedule_date"
            value="{{ old('schedule_date', isset($staffSchedule) && $staffSchedule->schedule_date ? $staffSchedule->schedule_date->format('Y-m-d') : '') }}"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none @error('schedule_date') border-red-500 @enderror"
            required
        >
        @error('schedule_date')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Jam Mulai -->
    <div>
        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
            Jam Mulai <span class="text-red-500">*</span>
        </label>
        <input
            type="time"
            id="start_time"
            name="start_time"
            value="{{ old('start_time', isset($staffSchedule->start_time) ? \Carbon\Carbon::parse($staffSchedule->start_time)->format('H:i') : '') }}"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none @error('start_time') border-red-500 @enderror"
            required
        >
        @error('start_time')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Jam Selesai -->
    <div>
        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
            Jam Selesai <span class="text-red-500">*</span>
        </label>
        <input
            type="time"
            id="end_time"
            name="end_time"
            value="{{ old('end_time', isset($staffSchedule->end_time) ? \Carbon\Carbon::parse($staffSchedule->end_time)->format('H:i') : '') }}"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none @error('end_time') border-red-500 @enderror"
            required
        >
        @error('end_time')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Catatan / Keterangan -->
    <div class="md:col-span-2">
        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
            Catatan (Opsional)
        </label>
        <textarea
            id="notes"
            name="notes"
            rows="3"
            placeholder="Contoh: Shift pagi, lembur, atau catatan khusus..."
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none @error('notes') border-red-500 @enderror"
        >{{ old('notes', $staffSchedule->notes ?? '') }}</textarea>
        @error('notes')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>