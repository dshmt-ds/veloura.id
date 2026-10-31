@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    <div class="md:col-span-2">
        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Layanan</label>
        <div class="flex flex-col sm:flex-row gap-4 items-start">
            <img src="{{ isset($service) ? $service->image_url : asset('images/service-default.svg') }}" alt="Gambar layanan saat ini" class="w-40 h-28 rounded-xl object-cover border border-[#EFE3DE]" onerror="this.onerror=null; this.src='{{ asset('images/service-default.svg') }}';">
            <div class="flex-1 min-w-0 w-full">
                <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-xl border border-[#EFE3DE] bg-[#FCFAF8] p-3 text-sm file:mr-3 file:rounded-full file:border-0 file:bg-[#6B3E4B] file:px-4 file:py-2 file:text-white file:cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">JPG, PNG, atau WebP, maksimal 2 MB. Tanpa gambar, layanan memakai gambar default.</p>
                @if (isset($service) && $service->image)
                    <label class="flex items-center gap-2 text-sm text-gray-600 mt-3">
                        <input type="checkbox" name="remove_image" value="1" @checked(old('remove_image')) class="rounded border-[#EFE3DE] text-[#6B3E4B] focus:ring-[#6B3E4B]">
                        Hapus gambar saat ini dan gunakan gambar default
                    </label>
                    <p class="text-xs text-gray-400 mt-1">Jika mengunggah gambar baru, gambar baru yang akan digunakan.</p>
                @endif
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                <x-input-error :messages="$errors->get('remove_image')" class="mt-2" />
            </div>
        </div>
    </div>

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
        <label for="service_category_id" class="block text-sm font-medium text-gray-700 mb-2">
            Kategori
        </label>
        <select
            id="service_category_id"
            name="service_category_id"
            required
            class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm focus:border-[#6B3E4B] focus:ring-[#6B3E4B]"
        >
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option 
                    value="{{ $cat->id }}"
                    @selected(old('service_category_id', $service->service_category_id ?? '') == $cat->id)
                >
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('service_category_id')
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
