<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Veloura Beauty Studio') }} | @yield('title', 'Feel Beautiful, Feel You')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/thumbnail.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..700;1,6..96,400..700&family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .swiper-pagination-bullet-active {
            background-color: #6B3E4B !important;
            width: 24px !important;
            border-radius: 9999px !important;
        }
        .swiper-pagination-bullet {
            background-color: #D8B08C;
            opacity: 0.7;
        }
    </style>
</head>

<body class="bg-[#F7EFE9] text-[#6B3E4B] font-['Poppins',sans-serif] antialiased selection:bg-[#D8B08C] selection:text-white min-h-screen flex flex-col">

    <!-- NAVIGATION BAR -->
    @include('layouts.navigation')

    <!-- HEADER PAGE (Opsional) -->
    @isset($header)
        <header class="bg-white border-b border-[#EFE3DE] pt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- MAIN CONTENT -->
    <main class="flex-1 pt-20">
        {{ $slot }}
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#432630] text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-5 text-center">
            <h3 class="font-serif text-2xl tracking-widest uppercase" style="font-family: 'Bodoni Moda', serif;">
                Veloura
            </h3>
            <p class="text-xs text-white/50 mt-1">Feel Beautiful, Feel You.</p>

            <div class="border-t border-white/10 mt-6 pt-6">
                <p class="text-xs text-white/40">
                    © {{ date('Y') }} Veloura Beauty Studio. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Swiper.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>
</html>