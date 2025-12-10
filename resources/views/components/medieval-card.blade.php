@props(['title' => null, 'icon' => null, 'actions' => null])

<div {{ $attributes->merge(['class' => 'relative bg-white rounded-xl shadow-medieval border-2 border-medieval-gold/30 overflow-hidden group']) }}>
    <!-- Decorative Corner Borders -->
    <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-medieval-gold rounded-tl-lg pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-medieval-gold rounded-tr-lg pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-medieval-gold rounded-bl-lg pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-medieval-gold rounded-br-lg pointer-events-none"></div>

    @if($title)
    <div class="px-6 py-4 bg-gradient-to-r from-medieval-brown to-medieval-dark-brown border-b-2 border-medieval-gold flex justify-between items-center relative">
        <!-- Gold sheen effect on header -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-medieval-gold/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
        
        <h3 class="font-cinzel font-bold text-lg text-medieval-light-gold flex items-center shadow-black drop-shadow-md">
            @if($icon)
                <i class="{{ $icon }} mr-2 text-medieval-gold"></i>
            @endif
            {{ $title }}
        </h3>
        @if($actions)
            <div class="flex items-center space-x-2 z-10">
                {{ $actions }}
            </div>
        @endif
    </div>
    @endif

    <div class="p-6 bg-medieval-parchment/10 relative z-0">
        <!-- Inner Watermark/Texture optional -->
        {{ $slot }}
    </div>
</div>
