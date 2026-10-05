@section('title', 'Tambah Kategori Layanan')

<x-app-layout>
    <div class="bg-white min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <a
                    href="{{ route('admin.service-categories.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#6B3E4B] transition"
                >
                    ← Kembali ke Kategori Layanan
                </a>

                <h1 class="text-2xl font-semibold text-[#6B3E4B] mt-4">
                    Tambah Kategori Layanan
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Buat kategori baru untuk mengelompokkan layanan salon Veloura.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-[#EFE3DE] shadow-sm">
                <div class="px-6 py-5 border-b border-[#EFE3DE]">
                    <h2 class="font-semibold text-[#6B3E4B]">
                        Informasi Kategori
                    </h2>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.service-categories.store') }}"
                    class="p-6 space-y-5"
                >
                    @csrf

                    <!-- Nama Kategori -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Hair Treatment"
                            required
                            class="w-full rounded-xl border {{ $errors->has('name') ? 'border-red-300 bg-red-50/30' : 'border-[#EFE3DE] bg-white' }} px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-[#6B3E4B] focus:ring-2 focus:ring-[#6B3E4B]/10 focus:outline-none transition"
                        >
                        @error('name')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="is_active"
                            name="is_active"
                            class="w-full rounded-xl border border-[#EFE3DE] bg-white px-4 py-2.5 text-sm text-gray-800 focus:border-[#6B3E4B] focus:ring-2 focus:ring-[#6B3E4B]/10 focus:outline-none transition cursor-pointer"
                        >
                            <option value="1" @selected(old('is_active', '1') == '1')>Aktif</option>
                            <option value="0" @selected(old('is_active') == '0')>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <p class="text-xs text-red-500 mt-1.5">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Deskripsi
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Masukkan deskripsi singkat kategori layanan..."
                            class="w-full rounded-xl border {{ $errors->has('description') ? 'border-red-300 bg-red-50/30' : 'border-[#EFE3DE] bg-white' }} px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 resize-none focus:border-[#6B3E4B] focus:ring-2 focus:ring-[#6B3E4B]/10 focus:outline-none transition"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 mt-1.5">
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 mt-7 pt-5 border-t border-[#EFE3DE]">
                        <a
                            href="{{ route('admin.service-categories.index') }}"
                            class="px-5 py-2.5 rounded-full border border-[#EFE3DE] text-gray-600 text-sm font-medium hover:bg-[#F7EFE9] transition"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-full bg-[#6B3E4B] text-white text-sm font-medium hover:bg-[#542d39] transition"
                        >
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>