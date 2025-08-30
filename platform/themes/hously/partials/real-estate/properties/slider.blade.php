@php
    $images = $item->images ? array_values($item->images) : [];
    $videos = $item->videos ? array_values($item->videos) : [];
    $youtubeURL = $item->youtube_url;
    
    // Gabungkan semua media dalam urutan: images dulu, lalu videos
    $allMedia = [];
    foreach($images as $image) {
        $allMedia[] = ['type' => 'image', 'file' => $image];
    }
    foreach($videos as $video) {
        $allMedia[] = ['type' => 'video', 'file' => $video];
    }
    if ($youtubeURL) {
        $allMedia[] = ['type' => 'youtube', 'file' => $youtubeURL];
    }
    
    $totalItems = count($allMedia);
@endphp

<div class="container-fluid">
    <div class="mt-4 md:flex">
        @if (($firstItem = Arr::first($allMedia)))
            <div class="@if ($totalItems > 1) lg:w-2/3 md:w-2/3 @else w-full @endif p-1">
                @if($firstItem['type'] === 'image')
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $firstItem['file']]) !!}
                @elseif($firstItem['type'] === 'youtube')
                    {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => Arr::first($images), 'youtubeURL' => $firstItem['file']]) !!}
                @else
                    {!! Theme::partial('real-estate.properties.slider-video', ['property' => $item, 'video' => $firstItem['file']]) !!}
                @endif
            </div>
        @endif

        @if ($totalItems > 1)
            <div class="p-1 lg:w-1/3 md:w-1/3">
                <div class="grid grid-cols-2 gap-1 h-full">
                    @foreach(array_slice($allMedia, 1, 4) as $index => $mediaItem)
                        @if($mediaItem['type'] === 'image')
                            {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => $mediaItem['file']]) !!}
                        @elseif($mediaItem['type'] === 'youtube')
                            {!! Theme::partial('real-estate.properties.slider-image', ['property' => $item, 'image' => Arr::first($images), 'youtubeURL' => $mediaItem['file']]) !!}
                        @else
                            {!! Theme::partial('real-estate.properties.slider-video', ['property' => $item, 'video' => $mediaItem['file']]) !!}
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
    <script>
function openMediaModal(mediaUrl, type) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center';
    
    if (type === 'video') {
        modal.innerHTML = `
            <div class="relative w-full max-w-5xl mx-4">
                <video controls autoplay class="w-full h-auto">
                    <source src="${mediaUrl}" type="video/mp4">
                </video>
                <button class="absolute -top-12 right-0 text-white text-4xl hover:text-gray-300" onclick="closeMediaModal(this)">×</button>
            </div>
        `;
    } else {
        modal.innerHTML = `
            <div class="relative max-w-full max-h-full">
                <img src="${mediaUrl}" class="max-w-full max-h-screen object-contain">
                <button class="absolute -top-12 right-0 text-white text-4xl hover:text-gray-300" onclick="closeMediaModal(this)">×</button>
            </div>
        `;
    }
    
    modal.id = 'custom-media-modal';
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeMediaModal();
        }
    });
}

function closeMediaModal(button) {
    const modal = button ? button.closest('.fixed') : document.getElementById('custom-media-modal');
    if (modal) {
        modal.remove();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMediaModal();
    }
});
</script>
