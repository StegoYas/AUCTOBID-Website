@props(['label' => null, 'name', 'type' => 'text', 'value' => '', 'placeholder' => '', 'required' => false])

<div class="mb-5 group">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-cinzel font-bold text-medieval-brown mb-2 group-focus-within:text-medieval-gold transition-colors">
            {{ $label }}
            @if($required) <span class="text-medieval-crimson">*</span> @endif
        </label>
    @endif
    
    <div class="relative">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-3 bg-white/80 border-2 border-medieval-gold/50 rounded-lg text-medieval-slate placeholder-medieval-slate/40 font-merriweather focus:border-medieval-gold focus:ring-2 focus:ring-medieval-gold/20 focus:bg-white transition-all duration-300 shadow-inner-parchment']) }}
        >
        
        <!-- Subtle icon or decoration (wax seal style) on right could go here -->
        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-medieval-gold opacity-0 group-focus-within:opacity-100 transition-opacity duration-300">
            <i class="ri-quill-pen-line"></i>
        </div>
    </div>

    @error($name)
        <p class="mt-1 text-sm text-medieval-crimson font-medium flex items-center">
            <i class="ri-error-warning-line mr-1"></i> {{ $message }}
        </p>
    @enderror
</div>
