@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <!-- Nama -->
    <div class="md:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Nama Layanan
        </label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $service->name ?? '') }}"
            placeholder="Contoh: Hair Spa"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
        >
        @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Kategori -->
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
            Kategori
        </label>
        <select
            id="category"
            name="category"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
        >
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option 
                    value="{{ $cat->name }}" 
                    @selected(old('category', $service->category ?? '') === $cat->name)
                >
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Harga -->
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
            Harga
        </label>
        <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">
                Rp
            </span>
            <input
                type="number"
                id="price"
                name="price"
                min="0"
                value="{{ old('price', $service->price ?? '') }}"
                placeholder="150000"
                class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] pl-11 pr-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
            >
        </div>
        @error('price')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Durasi -->
    <div>
        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
            Durasi
        </label>
        <div class="relative">
            <input
                type="number"
                id="duration"
                name="duration"
                min="1"
                value="{{ old('duration', $service->duration ?? '') }}"
                placeholder="60"
                class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 pr-20 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
            >
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400">
                menit
            </span>
        </div>
        @error('duration')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
            Status
        </label>
        <select
            id="status"
            name="status"
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
        >
            <option
                value="active"
                @selected(old('status', $service->status ?? 'active') === 'active')
            >
                Aktif
            </option>
            <option
                value="inactive"
                @selected(old('status', $service->status ?? '') === 'inactive')
            >
                Nonaktif
            </option>
        </select>
        @error('status')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Deskripsi -->
    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Deskripsi
        </label>
        <textarea
            id="description"
            name="description"
            rows="5"
            placeholder="Jelaskan detail layanan..."
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
        >{{ old('description', $service->description ?? '') }}</textarea>
        @error('description')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>