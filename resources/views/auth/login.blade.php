@section('title', 'Masuk')
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white px-4 py-8">

        <div class="w-full max-w-md bg-white rounded-3xl px-7 py-6 sm:px-9 shadow-lg">

            <!-- Logo / Brand -->
            <div class="text-center mb-8">

                <div class="flex justify-center mb-4">
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

                <p class="mt-2 text-sm text-gray-500">
                    Feel Beautiful, Feel You
                </p>

            </div>


            <!-- Masuk Content -->
            <div>

                <!-- Heading -->
                <div class="mb-6">

                    <h2 class="text-2xl font-serif font-medium text-[#6B3E4B]">
                        Selamat Datang Kembali
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Silakan masuk ke akun Anda
                    </p>

                </div>


                <!-- Session Status -->
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')"
                />


                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div>

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
                            autofocus
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
                    <div class="mt-5">

                        <div class="flex items-center justify-between mb-2">

                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Kata Sandi
                            </label>

                            @if (Route::has('password.request'))
                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-xs text-[#6B3E4B]
                                    hover:text-[#542d39] transition"
                                >
                                    Lupa kata sandi?
                                </a>
                            @endif

                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan kata sandi Anda"
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


                    <!-- Remember -->
                    <div class="mt-4">

                        <label
                            for="remember_me"
                            class="inline-flex items-center cursor-pointer"
                        >

                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300
                                text-[#6B3E4B]
                                focus:ring-[#6B3E4B]"
                            >

                            <span class="ms-2 text-sm text-gray-500">
                                Ingat saya
                            </span>

                        </label>

                    </div>


                    <!-- Masuk Button -->
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
                            Masuk
                        </button>

                    </div>

                </form>


                <!-- Daftar -->
                @if (Route::has('register'))
                    <div class="mt-5 text-center">

                        <p class="text-sm text-gray-500">
                            Belum memiliki akun?

                            <a
                                href="{{ route('register') }}"
                                class="font-medium text-[#6B3E4B]
                                hover:text-[#542d39] transition"
                            >
                                Daftar
                            </a>
                        </p>

                    </div>
                @endif

            </div>

        </div>

    </div>
</x-guest-layout>