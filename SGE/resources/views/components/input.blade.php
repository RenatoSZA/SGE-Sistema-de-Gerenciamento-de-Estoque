@props([
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
])

<div class="relative w-full group" x-data="{ type: '{{ $type }}' }">
    <input 
        x-bind:type="type"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-lg bg-white border-2 border-transparent text-brand-brown font-bold placeholder-brand-brown/80 focus:outline-none focus:border-brand-yellow focus:ring-4 focus:ring-brand-yellow/20 focus:text-brand-yellow caret-brand-yellow transition-all duration-300 shadow-sm']) }}
    >
    
    @if($icon)
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-brown group-focus-within:text-brand-yellow transition-colors duration-300 flex items-center justify-center">
            @if($icon === 'chevron-down')
                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
            @elseif($icon === 'chevron-up')
                <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
            @elseif($icon === 'eye')
                <button type="button" @click="type = type === 'password' ? 'text' : 'password'" class="focus:outline-none focus:text-brand-yellow hover:scale-110 transition-transform">
                    <svg x-show="type === 'password'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7.5 4.27 9 5.15"/>
                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/>
                        <path d="m3.3 7 8.7 5 8.7-5"/>
                        <path d="M12 22V12"/>
                    </svg>
                    <svg x-show="type === 'text'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                        <path d="M12 22v-9"/>
                        <path d="M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z"/>
                        <path d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13"/>
                        <path d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z"/>
                    </svg>
                </button>
            @endif
        </div>
    @endif
</div>
