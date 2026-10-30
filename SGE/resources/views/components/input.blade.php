@props([
    'name' => '',
    'id' => null,
    'type' => 'text',
    'placeholder' => '',
    'icon' => null,
    'label' => null,
])

@php
    $inputId = $id ?? $name;
@endphp

<div class="relative w-full group" x-data="{ type: '{{ $type }}' }">
    @if($label)
        <label for="{{ $inputId }}" class="sr-only">{{ $label }}</label>
    @endif
    <input 
        id="{{ $inputId }}"
        x-bind:type="type"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-lg bg-white border-2 border-transparent text-brand-brown font-bold placeholder-brand-brown/75 focus:outline-none focus:border-brand-yellow focus:ring-4 focus:ring-brand-yellow/40 caret-brand-brown transition-all duration-300 shadow-sm']) }}
    >
    
    @if($icon)
        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-brown transition-colors duration-300 flex items-center justify-center">
            @if($icon === 'chevron-down')
                <svg aria-hidden="true" class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
            @elseif($icon === 'chevron-up')
                <svg aria-hidden="true" class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
            @elseif($icon === 'eye')
                <button type="button"
                        @click="type = type === 'password' ? 'text' : 'password'"
                        :aria-label="type === 'password' ? 'Mostrar senha' : 'Ocultar senha'"
                        :aria-pressed="(type === 'text').toString()"
                        class="p-1 rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-brown hover:scale-110 transition-transform">
                    <svg aria-hidden="true" x-show="type === 'password'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg aria-hidden="true" x-show="type === 'text'" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            @endif
        </div>
    @endif
</div>
