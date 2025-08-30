@php
    $videoUrl = RvMedia::url($video ?? '');
    $moreText = isset($mores) && $mores > 0 ? $mores : 0;
    $isHidden = $hidden ?? false;
@endphp

<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $isHidden])>
    <div class="absolute inset-0 cursor-pointer" onclick="openMediaModal('{{ $videoUrl }}', 'video')">
        {{-- Video thumbnail dengan aspect ratio yang benar --}}
        <video class="w-full h-full object-cover" muted preload="metadata">
            <source src="{{ $videoUrl }}#t=1" type="video/mp4">
        </video>
        
        {{-- Sama seperti slider-image styling --}}
        <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900/70"></div>
        <div class="absolute start-0 end-0 invisible text-center -translate-y-1/2 top-1/2 group-hover:visible">
            <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary">
                <i class="mdi mdi-play"></i>
            </span>
        </div>
        
        <div class="absolute top-2 left-2">
            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium">
                <i class="mdi mdi-video"></i> Video
            </span>
        </div>
    </div>
</div>

<script>
function openMediaModal(mediaUrl, type) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
    
    if (type === 'video') {
        modal.innerHTML = `
            <div class="relative max-w-full max-h-full flex items-center justify-center">
                <video controls autoplay class="max-w-full max-h-full" style="object-fit: contain;">
                    <source src="${mediaUrl}" type="video/mp4">
                </video>
                <button class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center" onclick="this.closest('.fixed').remove()">×</button>
            </div>
        `;
    }
    
    modal.id = 'custom-media-modal';
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('custom-media-modal');
        if (modal) modal.remove();
    }
});
</script>