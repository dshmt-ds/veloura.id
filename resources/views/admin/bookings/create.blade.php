@section('title', 'Tambah Pemesanan')

<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 hover:text-[#6B3E4B]">&larr; Kembali ke Kelola Pemesanan</a>
        <h1 class="text-2xl font-semibold text-[#6B3E4B] mt-4">Tambah Pemesanan</h1>
        <p class="text-sm text-gray-500 mt-1 mb-6">Tambahkan reservasi pelanggan secara manual.</p>
        <div class="bg-white rounded-2xl border border-[#EFE3DE] shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-[#EFE3DE]">
                <h2 class="font-semibold text-[#6B3E4B]">Informasi Pemesanan</h2>
                <p class="text-sm text-gray-500 mt-1">Isi pelanggan, staff, layanan, dan jadwal perawatan.</p>
            </div>
        <form method="POST" action="{{ route('admin.bookings.store') }}" class="p-6 space-y-5">
            @csrf
            @if ($errors->any())
                <div role="alert" class="rounded-xl bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                <select id="customer_id" name="customer_id" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                    <option value="">Pilih pelanggan</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }} ({{ $customer->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-2">Staf</label>
                <select id="staff_id" name="staff_id" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                    <option value="">Pilih staff aktif</option>
                    @foreach ($staff as $person)
                        <option value="{{ $person->id }}" @selected(old('staff_id') == $person->id)>{{ $person->name }}</option>
                    @endforeach
                </select>
            </div>
            <fieldset>
                <legend class="text-sm font-medium text-gray-700 mb-2">Layanan Perawatan</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto p-3 bg-[#FCFAF8] rounded-xl border border-[#EFE3DE]">
                    @forelse ($services as $service)
                        <label class="flex items-start gap-3 rounded-lg bg-white border border-[#EFE3DE] hover:border-[#6B3E4B] p-3 text-sm cursor-pointer transition">
                            <input type="checkbox" name="services[]" value="{{ $service->id }}" @checked(in_array($service->id, (array) old('services', []))) class="mt-1 rounded border-[#EFE3DE] text-[#6B3E4B] focus:ring-[#6B3E4B]">
                            <span>{{ $service->name }}<span class="block text-xs text-gray-500">Rp {{ number_format($service->price, 0, ',', '.') }} / {{ $service->duration }} menit</span></span>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada layanan aktif.</p>
                    @endforelse
                </div>
            </fieldset>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemesanan</label>
                    <input id="booking_date" type="date" name="booking_date" value="{{ old('booking_date') }}" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                </div>
                <div>
                    <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
                    <input id="booking_time" type="time" name="booking_time" value="{{ old('booking_time') }}" required class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                </div>
            </div>
            <div>
                <label for="payment_due_at" class="block text-sm font-medium text-gray-700 mb-2">Batas Pembayaran (Opsional)</label>
                <input id="payment_due_at" type="datetime-local" name="payment_due_at" value="{{ old('payment_due_at') }}" class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">
                <p class="text-xs text-gray-500 mt-2">Jika dikosongkan, batas pembayaran otomatis 24 jam sejak pemesanan dibuat.</p>
            </div>
            <div>
                <label for="customer_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Pelanggan</label>
                <textarea id="customer_notes" name="customer_notes" rows="3" class="w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none">{{ old('customer_notes') }}</textarea>
            </div>
            <p class="text-xs text-gray-500">Total biaya dan durasi dihitung dari layanan yang dipilih. Pemesanan baru akan berstatus menunggu pembayaran.</p>
            <div class="flex flex-wrap justify-end gap-3 mt-7 pt-5 border-t border-[#EFE3DE]">
                <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 rounded-full border border-[#EFE3DE] text-gray-600 text-sm font-medium hover:bg-[#F7EFE9] transition">Batal</a>
                <button type="submit" @disabled($customers->isEmpty() || $staff->isEmpty() || $services->isEmpty()) class="px-6 py-2.5 rounded-full bg-[#6B3E4B] text-white text-sm font-medium hover:bg-[#542d39] transition disabled:opacity-50">Simpan Pemesanan</button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>
