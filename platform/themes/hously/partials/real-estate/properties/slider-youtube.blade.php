{{-- File: platform/themes/hously/partials/real-estate/properties/slider-youtube.blade.php --}}
@php
    $videoId = null;
    $youtubeURL = $youtubeURL ?? '';
    
    if ($youtubeURL) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|live/)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeURL, $matches);
        $videoId = $matches[1] ?? null;
    }
    
    $moreText = isset($mores) && $mores > 0 ? $mores : 0;
    $isHidden = $hidden ?? false;
    $totalItems = $totalItems ?? 0;
@endphp

@if($videoId)
<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $isHidden])>
    <div class="absolute inset-0 cursor-pointer" onclick="openMediaModal('{{ $youtubeURL }}', 'youtube')">
        {{-- YouTube thumbnail dengan quality tinggi --}}
        <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" 
             alt="YouTube Video Thumbnail" 
             class="w-full h-full object-cover"
             onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'">
        
        {{-- Overlay hover effect --}}
        <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900/70"></div>
        
        {{-- Play button dengan style YouTube --}}
        <div class="absolute start-0 end-0 invisible text-center -translate-y-1/2 top-1/2 group-hover:visible">
            <span class="text-white rounded-full btn btn-icon bg-red-600 hover:bg-red-700 transition-all duration-300">
                <i class="mdi mdi-play text-xl"></i>
            </span>
        </div>
        
        {{-- YouTube label --}}
        <div class="absolute top-2 left-2">
            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium shadow-lg">
                <i class="mdi mdi-youtube"></i> YouTube
            </span>
        </div>
        
        {{-- More count overlay (if this is the last visible item) --}}
        @if($moreText > 0)
            <div class="absolute inset-0 duration-500 ease-in-out bg-slate-900/70"></div>
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2">
                <span class="text-black bg-white rounded-full btn font-semibold">+{{ $moreText }}</span>
            </div>
        @endif
        
        {{-- YouTube play overlay (always visible) --}}
        @if($moreText <= 0)
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2 opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-full shadow-lg">
                    <i class="mdi mdi-play text-white text-2xl ml-1"></i>
                </div>
            </div>
        @endif
    </div>
</div>
@else
    {{-- Fallback jika YouTube URL tidak valid --}}
    <div @class(['group relative overflow-hidden pt-[56.25%] bg-gray-200', 'hidden' => $isHidden])>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-gray-500">
                <i class="mdi mdi-youtube text-4xl mb-2"></i>
                <p class="text-sm">Invalid YouTube URL</p>
            </div>
        </div>
    </div>
@endif