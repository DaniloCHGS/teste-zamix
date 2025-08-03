@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200';
    
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 disabled:bg-blue-400',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500 disabled:bg-gray-400',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 disabled:bg-green-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 disabled:bg-red-400',
        'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500 disabled:bg-yellow-400',
        'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-gray-500 disabled:bg-gray-100 disabled:text-gray-400',
        'ghost' => 'text-gray-700 hover:bg-gray-100 focus:ring-gray-500 disabled:text-gray-400',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
    ];
    
    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size];
    
    if ($disabled) {
        $classes .= ' cursor-not-allowed opacity-50';
    }
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => $classes]) }}
    {{ $disabled ? 'disabled' : '' }}
>
    {{ $slot }}
</button> 