{{-- File: platform/themes/hously/partials/real-estate/properties/slider-video.blade.php --}}
@php
    $videoUrl = RvMedia::url($video ?? '');
    $moreText = isset($mores) && $mores > 0 ? $mores : 0;
    $isHidden = $hidden ?? false;
    $totalItems = $totalItems ?? 0;
@endphp

<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $isHidden])>
    <div class="absolute inset-0 cursor-pointer" onclick="openMediaModal('{{ $videoUrl }}', 'video')">
        {{-- Video preview dengan thumbnail yang muncul lancar --}}
        <video class="w-full h-full object-cover" 
               muted 
               preload="metadata" 
               data-preload="metadata"
               onloadedmetadata="this.currentTime = 1;">
            <source src="{{ $videoUrl }}#t=1" type="video/mp4">
            <source src="{{ $videoUrl }}" type="video/webm">
        </video>
        
        {{-- Overlay hover effect --}}
        <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900/70"></div>
        
        {{-- Play button --}}
        <div class="absolute start-0 end-0 invisible text-center -translate-y-1/2 top-1/2 group-hover:visible">
            <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary transition-all duration-300">
                <i class="mdi mdi-play text-xl"></i>
            </span>
        </div>
        
        {{-- Video label --}}
        <div class="absolute top-2 left-2">
            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium shadow-lg">
                <i class="mdi mdi-video"></i> Video
            </span>
        </div>
        
        {{-- More count overlay (if this is the last visible item) --}}
        @if($moreText > 0)
            <div class="absolute inset-0 duration-500 ease-in-out bg-slate-900/70"></div>
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2">
                <span class="text-black bg-white rounded-full btn font-semibold">+{{ $moreText }}</span>
            </div>
        @endif
    </div>
</div>

{{-- Preload script untuk memastikan video preview muncul dengan lancar --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preload video metadata untuk preview yang lancar
    const videoElements = document.querySelectorAll('video[data-preload="metadata"]');
    
    videoElements.forEach(video => {
        video.addEventListener('loadedmetadata', function() {
            // Set ke detik ke-1 untuk thumbnail yang lebih baik
            this.currentTime = 1;
        });
        
        video.addEventListener('error', function() {
            // Fallback jika video gagal load
            const fallbackImg = document.createElement('div');
            fallbackImg.className = 'w-full h-full bg-gray-300 flex items-center justify-center';
            fallbackImg.innerHTML = '<i class="mdi mdi-video text-4xl text-gray-500"></i>';
            this.parentNode.appendChild(fallbackImg);
            this.style.display = 'none';
        });
        
        // Force load untuk memastikan metadata dimuat
        video.load();
    });
});
</script>