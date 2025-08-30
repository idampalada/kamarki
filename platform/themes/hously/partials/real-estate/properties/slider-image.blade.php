{{-- File: platform/themes/hously/partials/real-estate/properties/slider-image.blade.php --}}
@php
    $moreText = isset($mores) && $mores > 0 ? $mores : 0;
    $isHidden = $hidden ?? false;
    $totalItems = $totalItems ?? 0;
@endphp

<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $isHidden])>
    <div class="absolute inset-0 cursor-pointer" onclick="openMediaModal('{{ RvMedia::getImageUrl($image) }}', 'image')">
        <img src="{{ RvMedia::getImageUrl($image) }}" 
             alt="{{ $property->name }}" 
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
        
        {{-- Overlay effects --}}
        @if ($moreText > 0)
            {{-- Show +X more overlay --}}
            <div class="absolute inset-0 duration-500 ease-in-out bg-slate-900/70"></div>
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2">
                <span class="text-black bg-white rounded-full btn font-semibold">+{{ $moreText }}</span>
            </div>
        @else
            {{-- Normal hover effect --}}
            <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900/70"></div>
            <div class="absolute start-0 end-0 invisible text-center -translate-y-1/2 top-1/2 group-hover:visible">
                <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary transition-all duration-300">
                    <i class="mdi mdi-camera text-xl"></i>
                </span>
            </div>
        @endif
    </div>
</div>