@section('title', 'Daftar')

<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-white px-4 py-8">

        <div class="w-full max-w-md bg-white rounded-3xl px-7 py-6 sm:px-9 shadow-lg">

            <!-- Logo / Brand -->
            <div class="text-center mb-6">

                <div class="flex justify-center mb-3">
                    <div class="w-16 h-16 rounded-full overflow-hidden shadow-md">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Indah Salon"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>

                <h1
                    class="text-4xl font-light tracking-[0.08em] uppercase text-[#6B3E4B]"
                    style="font-family: 'Bodoni Moda', 'Times New Roman', serif;"
                >
                    Indah Salon
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Feel Beautiful, Feel You
                </p>

            </div>


            <!-- Daftar Content -->
            <div>

                <!-- Heading -->
                <div class="mb-6">

                    <h2
                        class="text-2xl font-serif font-medium text-[#6B3E4B]"
                    >
                        Buat Akun
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Daftar di Indah Salon dan mulai perawatan Anda
                    </p>

                </div>


                <!-- Daftar Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama -->
                    <div>

                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Nama
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda"
                            class="block w-full rounded-xl border
                            border-gray-200 bg-[#FAF8F6]
                            px-4 py-3 text-sm text-gray-700
                            placeholder-gray-400
                            focus:border-[#6B3E4B]
                            focus:ring-1 focus:ring-[#6B3E4B]
                            outline-none transition"
                        >

                        <x-input-error
                            :messages="$errors->get('name')"
                            class="mt-2"
                        />

                    </div>


                    <!-- Email -->
                    <div class="mt-4">

                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            placeholder="Masukkan alamat email Anda"
                            class="block w-full rounded-xl border
                            border-gray-200 bg-[#FAF8F6]
                            px-4 py-3 text-sm text-gray-700
                            placeholder-gray-400
                            focus:border-[#6B3E4B]
                            focus:ring-1 focus:ring-[#6B3E4B]
                            outline-none transition"
                        >

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />

                    </div>


                    <!-- Kata Sandi -->
                    <div class="mt-4">

                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Kata Sandi
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Buat kata sandi"
                            class="block w-full rounded-xl border
                            border-gray-200 bg-[#FAF8F6]
                            px-4 py-3 text-sm text-gray-700
                            placeholder-gray-400
                            focus:border-[#6B3E4B]
                            focus:ring-1 focus:ring-[#6B3E4B]
                            outline-none transition"
                        >

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />

                    </div>


                    <!-- Konfirmasi Kata Sandi -->
                    <div class="mt-4">

                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Konfirmasi Kata Sandi
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Konfirmasi kata sandi Anda"
                            class="block w-full rounded-xl border
                            border-gray-200 bg-[#FAF8F6]
                            px-4 py-3 text-sm text-gray-700
                            placeholder-gray-400
                            focus:border-[#6B3E4B]
                            focus:ring-1 focus:ring-[#6B3E4B]
                            outline-none transition"
                        >

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-2"
                        />

                    </div>


                    <!-- Daftar Button -->
                    <div class="mt-6">

                        <button
                            type="submit"
                            class="w-full inline-flex items-center
                            justify-center bg-[#6B3E4B]
                            text-white px-6 py-3 rounded-full
                            text-sm font-medium
                            hover:bg-[#542d39]
                            transition duration-200
                            shadow-md shadow-[#6B3E4B]/20"
                        >
                            Daftar
                        </button>

                    </div>

                </form>


                <!-- Masuk -->
                <div class="mt-4 text-center">

                    <p class="text-sm text-gray-500">

                        Sudah memiliki akun?

                        <a
                            href="{{ route('login') }}"
                            class="font-medium text-[#6B3E4B]
                            hover:text-[#542d39] transition"
                        >
                            Masuk
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>