@php
$numbers = $mores ?? false;
$videoId = null;
if (isset($youtubeURL)) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|live/)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeURL, $matches);
    $videoId = $matches[1] ?? null;
}
@endphp
<style>
    div[data-type="youtube"] iframe {
        width: 100%;
    }
</style>
@if (isset($videoId) && $videoId)
<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $hidden ?? false])>
<a href="#" class="absolute inset-0 image-gallery-item" 
   data-image-url="{{ RvMedia::getImageUrl($image) }}"
   onclick="openMediaModal('{{ RvMedia::getImageUrl($image) }}', 'image'); return false;">
        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $property->name }}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900/70"></div>
        <div class="absolute start-0 end-0 invisible text-center -translate-y-1/2 top-1/2 group-hover:visible">
            <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary">
                <i class="mdi mdi-play"></i>
            </span>
        </div>
    </a>
</div>
@else
<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $hidden ?? false])>
    <a href="{{ RvMedia::getImageUrl($image) }}" class="absolute inset-0 lightbox" data-group="lightbox-pt-images-{{ $property->id }}">
        <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $property->name }}" class="w-full h-full object-cover" />
        @if ($numbers > 5 || $numbers === 3)
            <div class="absolute inset-0 duration-500 ease-in-out bg-slate-900/70 group-hover:bg-slate-900/70"></div>
            <div class="absolute start-0 end-0 visible text-center -translate-y-1/2 top-1/2">
                <span class="text-black bg-white rounded-full btn">+{{ $numbers > 5 ? $numbers - 5 : $numbers - 2 }}</span>
            </div>
        @else
            <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900/70"></div>
            <div class="absolute start-0 end-0 invisible text-center -translate-y-1/2 top-1/2 group-hover:visible">
                <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary">
                    <i class="mdi mdi-camera"></i>
                </span>
            </div>
        @endif
    </a>
</div>
@endif
