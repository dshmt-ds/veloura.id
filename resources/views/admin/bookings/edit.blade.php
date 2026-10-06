@section('title', 'Edit Booking')

<x-app-layout>
    <div class="bg-white min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-6">
                <a
                    href="{{ route('admin.bookings.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#6B3E4B]"
                >
                    ← Kembali ke Kelola Booking
                </a>

                <h1 class="text-2xl font-semibold text-[#6B3E4B] mt-4">
                    Edit Booking: {{ $booking->booking_code }}
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Perbarui informasi reservasi dan status booking pelanggan.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-[#EFE3DE] shadow-sm">
                <div class="px-6 py-5 border-b border-[#EFE3DE]">
                    <h2 class="font-semibold text-[#6B3E4B]">
                        Informasi Booking
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Sesuaikan detail customer, terapis, layanan, jadwal, serta status pembayaran atau pengerjaan.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.bookings.update', $booking) }}"
                    class="p-6 space-y-5"
                >
                    @csrf
                    @method('PUT')

                    <!-- Customer & Staff Selection -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Customer</label>
                            <select name="customer_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-white cursor-pointer focus:ring-2 focus:ring-[#D8B08C] outline-none">
                                <option value="" disabled>Pilih Customer</option>
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
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Staff / Terapis</label>
                            <select name="staff_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-white cursor-pointer focus:ring-2 focus:ring-[#D8B08C] outline-none">
                                <option value="" disabled>Pilih Staff</option>
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
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Layanan Perawatan</label>
                        @php
                            $selectedServices = old('services', $booking->items->pluck('service_id')->toArray());
                        @endphp
                        <select name="services[]" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-white cursor-pointer focus:ring-2 focus:ring-[#D8B08C] outline-none">
                            <option value="" disabled>Pilih Layanan Utama</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(in_array($service->id, $selectedServices))>
                                    {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }} - {{ $service->duration }} Menit)
                                </option>
                            @endforeach
                        </select>
                        @error('services')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal & Jam Mulai -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tanggal Booking</label>
                            <input 
                                type="date" 
                                name="booking_date" 
                                value="{{ old('booking_date', \Carbon\Carbon::parse($booking->start_at)->format('Y-m-d')) }}" 
                                required 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#D8B08C] outline-none"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jam Booking</label>
                            <input 
                                type="time" 
                                name="booking_time" 
                                value="{{ old('booking_time', \Carbon\Carbon::parse($booking->start_at)->format('H:i')) }}" 
                                required 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#D8B08C] outline-none"
                            >
                        </div>
                    </div>

                    <!-- Status & Payment Due -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Status Booking</label>
                            <select name="status" required class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm bg-white cursor-pointer focus:ring-2 focus:ring-[#D8B08C] outline-none">
                                @php
                                    $statuses = [
                                        'pending_payment' => 'Pending Payment',
                                        'confirmed'       => 'Confirmed',
                                        'in_progress'     => 'In Progress',
                                        'completed'       => 'Completed',
                                        'cancelled'       => 'Cancelled',
                                        'expired'         => 'Expired',
                                        'no_show'         => 'No Show',
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
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Batas Waktu Pembayaran (Payment Due At)</label>
                            <input 
                                type="datetime-local" 
                                name="payment_due_at" 
                                value="{{ old('payment_due_at', $booking->payment_due_at ? \Carbon\Carbon::parse($booking->payment_due_at)->format('Y-m-d\TH:i') : '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#D8B08C] outline-none"
                            >
                        </div>
                    </div>

                    <!-- Catatan & Alasan Pembatalan -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan Customer</label>
                            <textarea name="customer_notes" rows="3" placeholder="Catatan tambahan dari customer..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#D8B08C] outline-none">{{ old('customer_notes', $booking->customer_notes) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Alasan Pembatalan (Jika dibatalkan)</label>
                            <textarea name="cancellation_reason" rows="3" placeholder="Alasan pembatalan booking..." class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#D8B08C] outline-none">{{ old('cancellation_reason', $booking->cancellation_reason) }}</textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 mt-7 pt-5 border-t border-[#EFE3DE]">
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