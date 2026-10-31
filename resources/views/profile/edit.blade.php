@section('title', 'Profil Saya')

<x-app-layout>
    <div class="bg-white min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="border-b border-slate-200 pb-5">
                <h1 class="text-2xl font-semibold text-slate-900">Profil Saya</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola informasi pribadi dan keamanan akun Anda.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <aside class="bg-[#6B3E4B] rounded-2xl p-6 text-white">
                    <div class="w-16 h-16 rounded-2xl bg-white/15 flex items-center justify-center text-2xl font-semibold" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                    <h2 class="text-xl font-semibold mt-4 break-words">{{ $user->name }}</h2>
                    <p class="text-sm text-white/70 mt-1 break-all">{{ $user->email }}</p>
                    <span class="inline-block mt-4 rounded-full bg-white/15 px-3 py-1 text-xs">{{ $user->isAdmin() ? 'Administrator' : 'Pelanggan' }}</span>
                    <div class="border-t border-white/15 mt-6 pt-5 space-y-3 text-sm">
                        <a href="#informasi-profil" class="block hover:underline">Informasi Profil</a>
                        <a href="#keamanan-akun" class="block hover:underline">Keamanan Akun</a>
                        <a href="#hapus-akun" class="block hover:underline">Hapus Akun</a>
                    </div>
                </aside>
                <div class="lg:col-span-2 min-w-0 space-y-6">
                    <div id="informasi-profil" class="scroll-mt-28 p-5 sm:p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div id="keamanan-akun" class="scroll-mt-28 p-5 sm:p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
                        @include('profile.partials.update-password-form')
                    </div>
                    <div id="hapus-akun" class="scroll-mt-28 p-5 sm:p-6 bg-white rounded-2xl border border-red-200 shadow-sm">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
