<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Penghapusan akun bersifat permanen. Simpan informasi yang Anda perlukan sebelum melanjutkan. Akun dengan riwayat pemesanan perlu menghubungi admin.') }}
        </p>
    </header>

    <button
        type="button"
        class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-[#6B3E4B] text-white text-sm font-medium hover:bg-[#542d39] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#6B3E4B] focus-visible:ring-offset-2 transition"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Yakin ingin menghapus akun Anda?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun.') }}
            </p>

            <div class="mt-6">
                <x-input-error :messages="$errors->userDeletion->get('account')" class="mb-3" />
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <x-profile-input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                   
                    placeholder="{{ __('Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3 pt-5 border-t border-[#EFE3DE]">
                <button type="button" class="inline-flex items-center justify-center px-5 py-2.5 rounded-full border border-[#EFE3DE] text-gray-600 text-sm font-medium hover:bg-[#F7EFE9] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#6B3E4B] focus-visible:ring-offset-2 transition" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-[#6B3E4B] text-white text-sm font-medium hover:bg-[#542d39] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#6B3E4B] focus-visible:ring-offset-2 transition">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
