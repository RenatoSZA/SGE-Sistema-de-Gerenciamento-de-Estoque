@props(['variant' => 'primary', 'size' => 'md'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold rounded-lg transition-all duration-300 ease-in-out focus:outline-none focus:ring-4';
    
    $variants = [
        'primary' => 'bg-brand-yellow text-white hover:brightness-105 active:scale-95 focus:ring-brand-yellow/30 shadow-sm',
        'secondary' => 'bg-brand-gray text-white hover:brightness-105 active:scale-95 focus:ring-brand-gray/30 shadow-sm',
        'dark' => 'bg-brand-brown text-brand-yellow hover:brightness-105 active:scale-95 focus:ring-brand-brown/30 shadow-sm',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-8 py-3 text-base',
        'lg' => 'px-16 py-4 text-lg w-full max-w-sm',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
