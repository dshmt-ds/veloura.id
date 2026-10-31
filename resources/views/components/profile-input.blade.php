@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-xl border-[#EFE3DE] bg-[#FCFAF8] px-4 py-3 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#6B3E4B] focus:ring-[#6B3E4B] outline-none disabled:opacity-50']) }}>
