@props(['type' => 'primary', 'icon' => null, 'href' => null, 'size' => 'md'])

@php
    $baseClasses = "inline-flex items-center justify-center font-cinzel font-bold uppercase tracking-wider rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed";
    
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-8 py-4 text-base',
        default => 'px-5 py-2.5 text-sm',
    };

    $variantClasses = match($type) {
        'primary' => 'bg-gradient-to-b from-medieval-brown to-medieval-dark-brown text-medieval-light-gold border-2 border-medieval-gold shadow-medieval hover:shadow-gold hover:from-medieval-brown hover:to-medieval-brown',
        'secondary' => 'bg-medieval-gold text-medieval-dark-brown border-2 border-medieval-dark-brown shadow-md hover:bg-medieval-light-gold',
        'outline' => 'bg-transparent border-2 border-medieval-brown text-medieval-brown hover:bg-medieval-brown hover:text-white',
        'danger' => 'bg-medieval-crimson text-white border-2 border-red-900 shadow-md hover:bg-red-900',
        'success' => 'bg-medieval-forest text-white border-2 border-green-900 shadow-md hover:bg-green-800',
        default => 'bg-medieval-brown text-white',
    };
    
    $classes = "$baseClasses $sizeClasses $variantClasses";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) <i class="{{ $icon }} mr-2"></i> @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon) <i class="{{ $icon }} mr-2"></i> @endif
        {{ $slot }}
    </button>
@endif
