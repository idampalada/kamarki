@php
    use Illuminate\Support\Str;

    // Cek apakah image adalah array (video) atau string biasa (gambar)
    $isVideoItem = is_array($image) && isset($image['type']) && $image['type'] === 'video';
    
    if ($isVideoItem) {
        $url = $image['url'];
    } else {
        $url = RvMedia::getImageUrl($image); // akan mengembalikan url apa adanya utk non-image
    }
    
    $lower = Str::lower(parse_url($url, PHP_URL_PATH) ?? $url);
    $isFileVideo = Str::endsWith($lower, ['.mp4', '.webm', '.ogg']);
    
    // Cek apakah URL YouTube
    $isYoutube = false;
    $youtubeId = null;
    if ($isVideoItem && !$isFileVideo) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|live/)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
        if (!empty($matches[1])) {
            $isYoutube = true;
            $youtubeId = $matches[1];
        }
    }

    $numbers = $mores ?? false;
@endphp

<style>
    .video-overlay {
        background: rgba(0, 0, 0, 0.5) !important;
        transition: all 0.3s ease;
    }
    .video-overlay:hover {
        background: rgba(0, 0, 0, 0.7) !important;
    }
</style>

<div @class(['group relative overflow-hidden pt-[56.25%]', 'hidden' => $hidden ?? false])>
    @if ($isVideoItem && $isYoutube)
        {{-- YouTube Video --}}
        <a href="#" class="absolute inset-0 lightbox video-lightbox" data-type="youtube" data-id="{{ $youtubeId }}">
            <img src="https://img.youtube.com/vi/{{ $youtubeId }}/maxresdefault.jpg" alt="{{ $property->name }}" class="w-full h-full object-cover" />
            <div class="absolute inset-0 video-overlay"></div>
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2">
                <span class="text-white rounded-full btn btn-icon bg-red-600 hover:bg-red-700 shadow-lg">
                    <i class="mdi mdi-play text-2xl"></i>
                </span>
                <div class="mt-2 text-white text-sm font-medium">
                    <i class="mdi mdi-youtube mr-1"></i>Property Video
                </div>
            </div>
        </a>
        
    @elseif ($isVideoItem && $isFileVideo)
        {{-- File Video --}}
        <a href="#" class="absolute inset-0 lightbox video-lightbox" data-type="video" data-src="{{ $url }}">
            <video class="w-full h-full object-cover" preload="metadata" muted>
                <source src="{{ $url }}#t=1">
            </video>
            <div class="absolute inset-0 video-overlay"></div>
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2">
                <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary shadow-lg">
                    <i class="mdi mdi-play text-2xl"></i>
                </span>
                <div class="mt-2 text-white text-sm font-medium">
                    <i class="mdi mdi-video mr-1"></i>Property Video
                </div>
            </div>
        </a>
        
    @elseif ($isVideoItem)
        {{-- Iframe/Other Video --}}
        <a href="#" class="absolute inset-0 lightbox video-lightbox" data-type="iframe" data-src="{{ $url }}">
            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                <i class="mdi mdi-video text-6xl text-gray-600"></i>
            </div>
            <div class="absolute inset-0 video-overlay"></div>
            <div class="absolute start-0 end-0 text-center -translate-y-1/2 top-1/2">
                <span class="text-white rounded-full btn btn-icon bg-primary hover:bg-secondary shadow-lg">
                    <i class="mdi mdi-play text-2xl"></i>
                </span>
                <div class="mt-2 text-white text-sm font-medium">
                    <i class="mdi mdi-video mr-1"></i>Property Video
                </div>
            </div>
        </a>
        
    @else
        {{-- Regular Image --}}
        <a href="{{ $url }}" class="absolute inset-0 lightbox" data-group="lightbox-pt-images-{{ $property->id }}">
            <img src="{{ $url }}" alt="{{ $property->name }}" class="w-full h-full object-cover" />
            @if ($numbers > 5 || $numbers === 3)
                <div class="absolute inset-0 duration-500 ease-in-out bg-slate-900/70 group-hover:bg-slate-900/70"></div>
                <div class="absolute start-0 end-0 visible text-center -translate-y-1/2 top-1/2">
                    <span class="text-black bg-white rounded-full btn">
                        +{{ $numbers > 5 ? $numbers - 5 : $numbers - 2 }}
                    </span>
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
    @endif
</div>

@if ($isVideoItem)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle video lightbox clicks - hindari konflik dengan Tobii
    document.querySelectorAll('.video-lightbox').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Stop event bubbling to prevent Tobii interference
            
            const type = this.getAttribute('data-type');
            const videoId = this.getAttribute('data-id');
            const src = this.getAttribute('data-src');
            
            console.log('Video clicked:', { type, videoId, src });
            
            // Use same dimensions as image gallery
            const maxWidth = Math.min(window.innerWidth * 0.9, 1200);
            const maxHeight = Math.min(window.innerHeight * 0.8, 675);
            const aspectRatio = 16 / 9;
            
            let videoWidth, videoHeight;
            if (maxWidth / aspectRatio <= maxHeight) {
                videoWidth = maxWidth;
                videoHeight = maxWidth / aspectRatio;
            } else {
                videoHeight = maxHeight;
                videoWidth = maxHeight * aspectRatio;
            }
            
            let videoContent = '';
            
            if (type === 'youtube' && videoId) {
                videoContent = `
                    <iframe width="${videoWidth}" height="${videoHeight}" 
                            src="https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&controls=1&showinfo=0&rel=0" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                    </iframe>`;
            } else if (type === 'video' && src) {
                videoContent = `
                    <video width="${videoWidth}" height="${videoHeight}" controls autoplay 
                           style="background: #000; object-fit: contain; display: block;">
                        <source src="${src}" type="video/mp4">
                        <source src="${src}" type="video/webm">
                        <p style="color: white; text-align: center; padding: 20px;">
                            Video tidak dapat diputar. <a href="${src}" style="color: #00aaff;">Download video</a>
                        </p>
                    </video>`;
            } else if (type === 'iframe' && src) {
                videoContent = `
                    <iframe width="${videoWidth}" height="${videoHeight}" 
                            src="${src}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>`;
            }
            
            if (videoContent) {
                // Remove existing modals dengan lebih hati-hati
                const existingModals = document.querySelectorAll('.custom-video-modal');
                existingModals.forEach(modal => {
                    modal.remove();
                });
                
                // Destroy Tobii instance temporarily untuk mencegah konflik
                if (window.tobii) {
                    try {
                        window.tobii.destroy();
                    } catch(e) {
                        console.log('Tobii cleanup handled');
                    }
                }
                
                // Create custom modal yang tidak menggunakan class konflik
                const modal = document.createElement('div');
                modal.className = 'custom-video-modal'; // Nama class unik
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 99999;
                    padding: 0;
                    box-sizing: border-box;
                `;
                
                // Close function
                const closeModal = () => {
                    modal.remove();
                    document.body.style.overflow = '';
                    
                    // Reinitialize Tobii setelah modal ditutup
                    setTimeout(() => {
                        if (typeof window.Tobii !== 'undefined') {
                            try {
                                window.tobii = new window.Tobii();
                            } catch(e) {
                                console.log('Tobii reinit handled');
                            }
                        }
                    }, 100);
                };
                
                modal.innerHTML = `
                    <!-- Close Button -->
                    <div onclick="event.stopPropagation();" 
                         style="position: absolute; top: 15px; right: 15px; 
                                background: none; border: none; color: white; 
                                font-size: 32px; cursor: pointer; z-index: 100001;
                                width: 50px; height: 50px; display: flex;
                                align-items: center; justify-content: center;
                                font-family: Arial, sans-serif; font-weight: normal;
                                opacity: 0.8; transition: opacity 0.2s ease;"
                         onmouseover="this.style.opacity='1'" 
                         onmouseout="this.style.opacity='0.8'"
                         id="custom-close-btn">
                        ×
                    </div>
                    
                    <!-- Navigation untuk ke images -->
                    <div onclick="event.stopPropagation();"
                         style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%);
                                background: rgba(255,255,255,0.1); border: none; color: white;
                                font-size: 24px; cursor: pointer; z-index: 100001;
                                width: 50px; height: 50px; border-radius: 50%;
                                display: flex; align-items: center; justify-content: center;
                                opacity: 0.7; transition: all 0.2s ease;"
                         onmouseover="this.style.opacity='1'; this.style.background='rgba(255,255,255,0.2)'" 
                         onmouseout="this.style.opacity='0.7'; this.style.background='rgba(255,255,255,0.1)'"
                         title="View Images"
                         id="custom-next-btn">
                        →
                    </div>
                    
                    <!-- Video Container -->
                    <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
                        <div style="background: #000; border-radius: 4px; overflow: hidden; 
                                    box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
                            ${videoContent}
                        </div>
                    </div>
                    
                    <!-- Info Counter -->
                    <div style="position: absolute; top: 20px; left: 20px; color: white; 
                                font-size: 16px; background: rgba(0,0,0,0.5); padding: 8px 12px;
                                border-radius: 4px; font-family: Arial, sans-serif;">
                        Video
                    </div>
                `;
                
                document.body.appendChild(modal);
                document.body.style.overflow = 'hidden';
                
                // Event listeners dengan ID untuk menghindari konflik
                const closeBtn = document.getElementById('custom-close-btn');
                const nextBtn = document.getElementById('custom-next-btn');
                
                if (closeBtn) {
                    closeBtn.addEventListener('click', closeModal);
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', function() {
                        closeModal();
                        setTimeout(() => {
                            const imageLinks = document.querySelectorAll('[data-group*="lightbox-pt-images"]');
                            if (imageLinks.length > 0) {
                                imageLinks[0].click();
                            }
                        }, 200);
                    });
                }
                
                // Close on background click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
                
                // Close on ESC dengan cleanup
                const escHandler = function(e) {
                    if (e.key === 'Escape') {
                        closeModal();
                        document.removeEventListener('keydown', escHandler);
                    }
                    if (e.key === 'ArrowRight' && nextBtn) {
                        nextBtn.click();
                    }
                };
                document.addEventListener('keydown', escHandler);
                
                console.log(`Custom video modal created: ${videoWidth}x${videoHeight}`);
            }
        });
    });
});
</script>
@endif