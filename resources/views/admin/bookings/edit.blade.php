@section('title', 'Edit Pemesanan')

<x-app-layout>
    <div class="bg-white min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <a
                    href="{{ route('admin.bookings.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#6B3E4B]"
                >
                    &larr; Kembali ke Kelola Pemesanan
                </a>

                <h1 class="text-2xl font-semibold text-[#6B3E4B] mt-4">
                    Edit Pemesanan: {{ $booking->booking_code }}
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui informasi reservasi dan status pemesanan pelanggan.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-[#EFE3DE] shadow-sm">
                <div class="px-6 py-5 border-b border-[#EFE3DE]">
                    <h2 class="font-semibold text-[#6B3E4B]">
                        Informasi Pemesanan
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui pelanggan, staff, layanan, jadwal, dan status reservasi.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.bookings.update', $booking) }}"
                    class="p-6 space-y-5"
                >
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Pelanggan & Staf Selection -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                            <select name="customer_id" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 cursor-pointer focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                                <option value="" disabled>Pilih Pelanggan</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id', $booking->customer_id) == $customer->id)>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Staf</label>
                            <select name="staff_id" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 cursor-pointer focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                                <option value="" disabled>Pilih Staf</option>
                                @foreach ($staff as $person)
                                    <option value="{{ $person->id }}" @selected(old('staff_id', $booking->staff_id) == $person->id)>
                                        {{ $person->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Layanan (Dropdown / Multiple) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Layanan Perawatan</label>
                        @php
                            $selectedServices = old('services', $booking->items->pluck('service_id')->toArray());
                        @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto p-3 bg-[#FCFAF8] rounded-xl border border-[#EFE3DE]">
                            @foreach ($services as $service)
                                <label class="flex items-start gap-3 rounded-lg bg-white border border-[#EFE3DE] hover:border-[#6B3E4B] p-3 text-sm cursor-pointer transition">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" @checked(in_array($service->id, (array) $selectedServices)) class="mt-1 rounded border-[#EFE3DE] text-[#6B3E4B] focus:ring-[#6B3E4B]">
                                    <span class="min-w-0 break-words">{{ $service->name }}<span class="block text-xs text-gray-500 mt-1">Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->duration }} menit</span></span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Pilih satu atau beberapa layanan. Total biaya dan durasi dihitung otomatis saat disimpan.</p>
                        @error('services')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal & Jam Mulai -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemesanan</label>
                            <input 
                                type="date" 
                                name="booking_date" 
                                value="{{ old('booking_date', \Carbon\Carbon::parse($booking->start_at)->format('Y-m-d')) }}" 
                                required 
                                class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jam Pemesanan</label>
                            <input 
                                type="time" 
                                name="booking_time" 
                                value="{{ old('booking_time', \Carbon\Carbon::parse($booking->start_at)->format('H:i')) }}" 
                                required 
                                class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none"
                            >
                        </div>
                    </div>

                    <!-- Status & Payment Due -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Pemesanan</label>
                            <select name="status" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 cursor-pointer focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                                @php
                                    $statuses = [
                                        'pending_payment' => 'Menunggu Pembayaran',
                                        'confirmed'       => 'Terkonfirmasi',
                                        'in_progress'     => 'Sedang Berlangsung',
                                        'completed'       => 'Selesai',
                                        'cancelled'       => 'Dibatalkan',
                                        'expired'         => 'Kedaluwarsa',
                                        'no_show'         => 'Tidak Hadir',
                                    ];
                                @endphp
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status', $booking->status) === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Batas Pembayaran (Opsional)</label>
                            <input 
                                type="datetime-local" 
                                name="payment_due_at" 
                                value="{{ old('payment_due_at', $booking->payment_due_at ? \Carbon\Carbon::parse($booking->payment_due_at)->format('Y-m-d\TH:i') : '') }}" 
                                class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none"
                            >
                        </div>
                    </div>

                    <!-- Catatan & Alasan Pembatalan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pelanggan</label>
                            <textarea name="customer_notes" rows="3" placeholder="Catatan tambahan dari pelanggan..." class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">{{ old('customer_notes', $booking->customer_notes) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Pembatalan (Jika dibatalkan)</label>
                            <textarea name="cancellation_reason" rows="3" placeholder="Alasan pembatalan booking..." class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">{{ old('cancellation_reason', $booking->cancellation_reason) }}</textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap justify-end gap-3 mt-7 pt-5 border-t border-[#EFE3DE]">
                        <a
                            href="{{ route('admin.bookings.index') }}"
                            class="px-5 py-2.5 rounded-full border border-[#EFE3DE] text-gray-600 text-sm font-medium hover:bg-[#F7EFE9] transition"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-full bg-[#6B3E4B] text-white text-sm font-medium hover:bg-[#542d39] transition shadow-md"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
