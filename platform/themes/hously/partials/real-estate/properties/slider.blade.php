{{-- File: platform/themes/hously/partials/real-estate/properties/slider.blade.php --}}
@php
    // Debug dan safely get data
    $images = [];
    $videos = [];
    $youtubeURL = null;

    // Parse images dari JSON string
    if (isset($item->images) && !empty($item->images)) {
        if (is_string($item->images)) {
            $decoded = json_decode($item->images, true);
            if (is_array($decoded)) {
                $images = array_values($decoded);
            }
        } elseif (is_array($item->images)) {
            $images = array_values($item->images);
        }
    }

    // Parse videos dari JSON string atau null check
    if (isset($item->videos) && !empty($item->videos) && $item->videos !== null) {
        if (is_string($item->videos)) {
            $decoded = json_decode($item->videos, true);
            if (is_array($decoded)) {
                $videos = array_values($decoded);
            }
        } elseif (is_array($item->videos)) {
            $videos = array_values($item->videos);
        }
    }
    
    // Jika videos masih null, coba cek apakah ada video dummy untuk testing
    if (empty($videos)) {
        // Tambahkan dummy video untuk testing - hapus setelah production
        $videos = ['dummy-video.mp4'];
    }

    // Get YouTube URL
    if (isset($item->youtube_url) && !empty($item->youtube_url) && $item->youtube_url !== null) {
        $youtubeURL = $item->youtube_url;
    }

    // Build media array
    $allMedia = [];
    
    // Add images
    foreach($images as $image) {
        if (!empty($image)) {
            try {
                $allMedia[] = [
                    'type' => 'image',
                    'url' => RvMedia::getImageUrl($image),
                    'file' => $image
                ];
            } catch (Exception $e) {
                // Skip broken images
            }
        }
    }

    // Add videos dengan dummy untuk testing
    foreach($videos as $video) {
        if (!empty($video)) {
            try {
                // Skip dummy video untuk production
                if ($video === 'dummy-video.mp4') {
                    $allMedia[] = [
                        'type' => 'video',
                        'url' => 'https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_1mb.mp4', // Sample video URL
                        'file' => $video
                    ];
                } else {
                    $allMedia[] = [
                        'type' => 'video', 
                        'url' => RvMedia::url($video),
                        'file' => $video
                    ];
                }
            } catch (Exception $e) {
                // Skip broken videos
            }
        }
    }

    // Add YouTube
    if ($youtubeURL) {
        $allMedia[] = [
            'type' => 'youtube',
            'url' => $youtubeURL,
            'file' => $youtubeURL
        ];
    }

    $totalItems = count($allMedia);
@endphp

{{-- Debug info (hapus setelah testing) --}}
<div style="background: #f0f0f0; padding: 10px; margin: 10px 0; font-size: 12px;">
    <strong>DEBUG:</strong><br>
    Total Images: {{ count($images) }}<br>
    Total Videos: {{ count($videos) }}<br>
    YouTube URL: {{ $youtubeURL ?: 'NULL' }}<br>
    Total Media: {{ $totalItems }}<br>
    @if($totalItems > 0)
        Media Types: 
        @foreach($allMedia as $index => $media)
            {{ $index+1 }}={{ $media['type'] }} 
        @endforeach
    @endif
</div>

@if($totalItems > 0)
<div class="container-fluid">
    <div class="mt-4 md:flex">
        {{-- First Item --}}
        @php $firstItem = $allMedia[0] ?? null; @endphp
        
        @if($firstItem)
            <div class="@if ($totalItems > 1) lg:w-2/3 md:w-2/3 @else w-full @endif p-1">
                <div class="group relative overflow-hidden cursor-pointer" style="padding-top: 56.25%;" onclick="openPropertyGallery(0)">
                    @if($firstItem['type'] === 'image')
                        <img src="{{ $firstItem['url'] }}" 
                             alt="{{ $item->name }}" 
                             class="absolute inset-0 w-full h-full object-cover" />
                        <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900" style="background-color: rgba(0,0,0,0); transition: background-color 0.5s;"></div>
                        <div class="absolute start-0 end-0 invisible text-center top-1/2 group-hover:visible" style="transform: translateY(-50%);">
                            <span class="text-white rounded-full inline-flex items-center justify-center w-12 h-12 bg-blue-600 hover:bg-blue-700" style="transition: all 0.3s;">
                                <i class="mdi mdi-camera"></i>
                            </span>
                        </div>
                    @elseif($firstItem['type'] === 'youtube')
                        @php
                            // Extract YouTube video ID
                            $videoId = null;
                            $url = $firstItem['url'];
                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if($videoId)
                            <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" 
                                 alt="YouTube Video" 
                                 class="absolute inset-0 w-full h-full object-cover"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'" />
                            <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900" style="background-color: rgba(0,0,0,0.3);"></div>
                            <div class="absolute start-0 end-0 text-center top-1/2" style="transform: translateY(-50%);">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-full shadow-lg">
                                    <i class="mdi mdi-play text-white text-2xl" style="margin-left: 2px;"></i>
                                </div>
                            </div>
                            <div class="absolute top-2 left-2">
                                <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium">
                                    <i class="mdi mdi-youtube"></i> YouTube
                                </span>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-gray-800 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <i class="mdi mdi-youtube text-4xl text-red-500 mb-2"></i>
                                    <p class="text-sm">Invalid YouTube URL</p>
                                </div>
                            </div>
                        @endif
                    @elseif($firstItem['type'] === 'video')
                        <video class="absolute inset-0 w-full h-full object-cover" muted preload="metadata">
                            <source src="{{ $firstItem['url'] }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900" style="background-color: rgba(0,0,0,0);"></div>
                        <div class="absolute start-0 end-0 invisible text-center top-1/2 group-hover:visible" style="transform: translateY(-50%);">
                            <span class="text-white rounded-full inline-flex items-center justify-center w-12 h-12 bg-blue-600 hover:bg-blue-700">
                                <i class="mdi mdi-play"></i>
                            </span>
                        </div>
                        <div class="absolute top-2 left-2">
                            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium">
                                <i class="mdi mdi-video"></i> Video
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

                        {{-- Remaining Items - perbaiki untuk menampilkan semua media termasuk YouTube --}}
                        @if ($totalItems > 1)
                            <div class="p-1 lg:w-1/3 md:w-1/3">
                                <div class="grid grid-cols-2 gap-1 h-full">
                                    @for($i = 1; $i < min(5, $totalItems); $i++)
                                        @php
                                            $mediaItem = $allMedia[$i] ?? null;
                                            $isLastSlot = ($i === 4 && $totalItems > 5);
                                            $moreCount = $isLastSlot ? ($totalItems - 5) : 0;
                                        @endphp
                                        
                                        @if($mediaItem)
                                            <div class="group relative overflow-hidden cursor-pointer" style="padding-top: 56.25%;" onclick="openPropertyGallery({{ $i }})">
                                                @if($mediaItem['type'] === 'image')
                                                    <img src="{{ $mediaItem['url'] }}" 
                                                         alt="{{ $item->name }}" 
                                                         class="absolute inset-0 w-full h-full object-cover" />
                                                @elseif($mediaItem['type'] === 'youtube')
                                                    @php
                                                        $videoId = null;
                                                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $mediaItem['url'], $matches)) {
                                                            $videoId = $matches[1];
                                                        }
                                                    @endphp
                                                    @if($videoId)
                                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" 
                                                             alt="YouTube Video" 
                                                             class="absolute inset-0 w-full h-full object-cover"
                                                             onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'" />
                                                        <div class="absolute top-2 left-2">
                                                            <span class="bg-red-600 text-white px-1 py-0.5 rounded text-xs">
                                                                <i class="mdi mdi-youtube text-xs"></i>
                                                            </span>
                                                        </div>
                                                        {{-- YouTube play overlay --}}
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center opacity-80">
                                                                <i class="mdi mdi-play text-white text-sm" style="margin-left: 1px;"></i>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="absolute inset-0 bg-gray-800 flex items-center justify-center">
                                                            <i class="mdi mdi-youtube text-2xl text-red-500"></i>
                                                        </div>
                                                    @endif
                                                @elseif($mediaItem['type'] === 'video')
                                                    <video class="absolute inset-0 w-full h-full object-cover" muted preload="metadata">
                                                        <source src="{{ $mediaItem['url'] }}" type="video/mp4">
                                                    </video>
                                                    <div class="absolute top-2 left-2">
                                                        <span class="bg-red-600 text-white px-1 py-0.5 rounded text-xs">
                                                            <i class="mdi mdi-video text-xs"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                @if($moreCount > 0)
                                                    <div class="absolute inset-0 bg-slate-900" style="background-color: rgba(0,0,0,0.7);"></div>
                                                    <div class="absolute start-0 end-0 text-center top-1/2" style="transform: translateY(-50%);">
                                                        <span class="text-black bg-white rounded-full px-3 py-1 font-semibold">+{{ $moreCount }}</span>
                                                    </div>
                                                @else
                                                    <div class="absolute inset-0 duration-500 ease-in-out group-hover:bg-slate-900" style="background-color: rgba(0,0,0,0);"></div>
                                                    <div class="absolute start-0 end-0 invisible text-center top-1/2 group-hover:visible" style="transform: translateY(-50%);">
                                                        <span class="text-white rounded-full inline-flex items-center justify-center w-8 h-8 bg-blue-600 hover:bg-blue-700">
                                                            @if($mediaItem['type'] === 'video' || $mediaItem['type'] === 'youtube')
                                                                <i class="mdi mdi-play"></i>
                                                            @else
                                                                <i class="mdi mdi-camera"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif
    </div>
</div>

{{-- JavaScript untuk Property Media Gallery --}}
<script>
// Global variables untuk gallery
var propertyGalleryData = @json($allMedia);
var currentGalleryIndex = 0;
var propertyGalleryName = "{{ $item->name ?? 'Property Gallery' }}";
var currentTab = 'foto'; // default tab

function openPropertyGallery(index) {
    index = index || 0;
    currentGalleryIndex = index;
    
    // Determine initial tab based on media type
    var currentMedia = propertyGalleryData[currentGalleryIndex];
    if (currentMedia && (currentMedia.type === 'video' || currentMedia.type === 'youtube')) {
        currentTab = 'video';
    } else {
        currentTab = 'foto';
    }
    
    createRukitaModal();
}

function createRukitaModal() {
    // Hapus modal yang ada
    var existingModal = document.getElementById('rukita-gallery-modal');
    if (existingModal) {
        existingModal.remove();
    }

    // Hide main navigation
    var mainNav = document.querySelector('nav, .navbar, header');
    if (mainNav) {
        mainNav.style.display = 'none';
    }

    // Filter media by type
    var fotoMedia = propertyGalleryData.filter(function(item) {
        return item.type === 'image';
    });
    
    var videoMedia = propertyGalleryData.filter(function(item) {
        return item.type === 'video' || item.type === 'youtube';
    });

    // Buat modal baru
    var modal = document.createElement('div');
    modal.id = 'rukita-gallery-modal';
    modal.className = 'fixed inset-0 z-50 flex flex-col';
    modal.style.backgroundColor = '#2d3748';
    modal.style.zIndex = '9999'; // Ensure it's above everything
    
    // Header dengan back button, title, dan tabs (tanpa 360)
    modal.innerHTML = 
        '<div class="bg-white border-b sticky top-0 z-20" style="box-shadow: 0 2px 4px rgba(0,0,0,0.1);">' +
            '<div class="flex items-center justify-between p-4">' +
                '<button onclick="closeRukitaGallery()" class="text-gray-600 hover:text-gray-800 p-2">' +
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>' +
                    '</svg>' +
                '</button>' +
                '<h3 class="text-lg font-semibold text-center flex-1 mx-4 truncate">' + propertyGalleryName + '</h3>' +
                '<div class="w-10"></div>' +
            '</div>' +
            
            '<div class="flex bg-gray-50">' +
                '<button id="tab-video" onclick="scrollToSection(\'video-section\')" class="flex-1 py-4 text-center font-medium border-b-2 ' + 
                (currentTab === 'video' ? 'text-teal-600 border-teal-600' : 'text-gray-500 border-transparent hover:text-gray-700') + ' transition-colors">Video</button>' +
                '<button id="tab-foto" onclick="scrollToSection(\'foto-section\')" class="flex-1 py-4 text-center font-medium border-b-2 ' + 
                (currentTab === 'foto' ? 'text-teal-600 border-teal-600' : 'text-gray-500 border-transparent hover:text-gray-700') + ' transition-colors">Foto</button>' +
            '</div>' +
        '</div>' +
        
        '<div id="media-content" class="flex-1 overflow-y-auto" style="background-color: #2d3748;" onscroll="handleScroll()">' + 
            renderScrollableContent() + 
        '</div>';

    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function renderScrollableContent() {
    var videoMedia = propertyGalleryData.filter(function(item) {
        return item.type === 'video' || item.type === 'youtube';
    });
    
    var fotoMedia = propertyGalleryData.filter(function(item) {
        return item.type === 'image';
    });
    
    var html = '<div class="space-y-6">';
    
    // Video Section
    if (videoMedia.length > 0) {
        html += '<div id="video-section" class="px-3 py-2">';
        html += '<h2 class="text-white text-lg font-medium mb-3 px-1">Video</h2>';
        html += '<div class="space-y-3">';
        
        videoMedia.forEach(function(media) {
            var globalIndex = getGlobalIndex(media);
            html += '<div class="bg-white rounded-lg overflow-hidden shadow cursor-pointer" onclick="openFullScreenMedia(' + globalIndex + ')">';
            
            if (media.type === 'youtube') {
                var videoId = extractYouTubeId(media.url);
                html += 
                    '<div class="relative" style="height: 180px;">' +
                        '<img src="https://img.youtube.com/vi/' + videoId + '/maxresdefault.jpg" alt="YouTube Video" class="w-full h-full object-cover">' +
                        '<div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">' +
                            '<div class="bg-red-600 rounded-full p-3 hover:bg-red-700 transition-colors">' +
                                '<svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20">' +
                                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8.108v3.784a1 1 0 001.555.832l3.101-1.892a1 1 0 000-1.664L9.555 7.168z" clip-rule="evenodd"></path>' +
                                '</svg>' +
                            '</div>' +
                        '</div>' +
                        '<div class="absolute top-2 left-2">' +
                            '<span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-medium">YouTube</span>' +
                        '</div>' +
                    '</div>';
            } else if (media.type === 'video') {
                html += 
                    '<div class="relative" style="height: 180px;">' +
                        '<video class="w-full h-full object-cover" preload="metadata">' +
                            '<source src="' + media.url + '#t=1" type="video/mp4">' +
                        '</video>' +
                        '<div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">' +
                            '<div class="bg-blue-600 rounded-full p-3 hover:bg-blue-700 transition-colors">' +
                                '<svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20">' +
                                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8.108v3.784a1 1 0 001.555.832l3.101-1.892a1 1 0 000-1.664L9.555 7.168z" clip-rule="evenodd"></path>' +
                                '</svg>' +
                            '</div>' +
                        '</div>' +
                        '<div class="absolute top-2 left-2">' +
                            '<span class="bg-blue-600 text-white px-2 py-1 rounded text-xs font-medium">VIDEO</span>' +
                        '</div>' +
                    '</div>';
            }
            
            html += '</div>';
        });
        
        html += '</div>';
        html += '</div>';
    }
    
    // Foto Section
    if (fotoMedia.length > 0) {
        html += '<div id="foto-section" class="px-3 py-2">';
        html += '<h2 class="text-white text-lg font-medium mb-3 px-1">Foto</h2>';
        html += '<div class="space-y-3">';
        
        fotoMedia.forEach(function(media) {
            var globalIndex = getGlobalIndex(media);
            html += '<div class="bg-white rounded-lg overflow-hidden shadow cursor-pointer" onclick="openFullScreenMedia(' + globalIndex + ')">';
            html += 
                '<div class="relative" style="height: 180px;">' +
                    '<img src="' + media.url + '" alt="Property Image" class="w-full h-full object-cover">' +
                    '<div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center">' +
                        '<div class="opacity-0 hover:opacity-100 transition-opacity duration-200">' +
                            '<div class="bg-white rounded-full p-2">' +
                                '<svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">' +
                                    '<path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>' +
                                '</svg>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
            html += '</div>';
        });
        
        html += '</div>';
        html += '</div>';
    }
    
    html += '</div>';
    return html;
}

function scrollToSection(sectionId) {
    var section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

function handleScroll() {
    var scrollContainer = document.getElementById('media-content');
    var videoSection = document.getElementById('video-section');
    var fotoSection = document.getElementById('foto-section');
    
    if (!scrollContainer || (!videoSection && !fotoSection)) return;
    
    var scrollTop = scrollContainer.scrollTop;
    var containerHeight = scrollContainer.clientHeight;
    
    var activeSection = 'video'; // default
    
    // Check which section is more visible
    if (fotoSection) {
        var fotoRect = fotoSection.getBoundingClientRect();
        var containerRect = scrollContainer.getBoundingClientRect();
        
        // If foto section is more than 50% visible, make it active
        var fotoVisibleTop = Math.max(fotoRect.top, containerRect.top);
        var fotoVisibleBottom = Math.min(fotoRect.bottom, containerRect.bottom);
        var fotoVisibleHeight = Math.max(0, fotoVisibleBottom - fotoVisibleTop);
        
        if (fotoVisibleHeight > containerHeight * 0.3) { // 30% threshold
            activeSection = 'foto';
        }
    }
    
    updateActiveTab(activeSection);
}

function updateActiveTab(activeSection) {
    // Reset semua tabs
    var videoTab = document.getElementById('tab-video');
    var fotoTab = document.getElementById('tab-foto');
    
    if (videoTab) {
        videoTab.className = 'flex-1 py-4 text-center font-medium border-b-2 text-gray-500 border-transparent hover:text-gray-700 transition-colors';
    }
    if (fotoTab) {
        fotoTab.className = 'flex-1 py-4 text-center font-medium border-b-2 text-gray-500 border-transparent hover:text-gray-700 transition-colors';
    }
    
    // Set active tab
    if (activeSection === 'video' && videoTab) {
        videoTab.className = 'flex-1 py-4 text-center font-medium border-b-2 text-teal-600 border-teal-600 transition-colors';
    } else if (activeSection === 'foto' && fotoTab) {
        fotoTab.className = 'flex-1 py-4 text-center font-medium border-b-2 text-teal-600 border-teal-600 transition-colors';
    }
}

function getGlobalIndex(targetMedia) {
    return propertyGalleryData.findIndex(function(media) {
        return media.url === targetMedia.url && media.type === targetMedia.type;
    });
}

function openFullScreenMedia(index) {
    currentGalleryIndex = index;
    createFullScreenModal();
}

function createFullScreenModal() {
    var modal = document.createElement('div');
    modal.id = 'fullscreen-media-modal';
    modal.className = 'fixed inset-0 bg-black z-50 flex flex-col';
    
    var currentMedia = propertyGalleryData[currentGalleryIndex];
    
    modal.innerHTML = 
        '<div class="absolute top-4 left-4 right-4 z-10 flex justify-between items-center">' +
            '<button onclick="closeFullScreenModal()" class="text-white hover:text-gray-300 transition-colors bg-black bg-opacity-50 rounded-full p-2">' +
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>' +
                '</svg>' +
            '</button>' +
            '<div class="text-white text-center">' +
                '<span class="bg-black bg-opacity-50 px-3 py-1 rounded-full text-sm">' +
                    (currentGalleryIndex + 1) + ' of ' + propertyGalleryData.length +
                '</span>' +
            '</div>' +
            '<button onclick="closeFullScreenModal()" class="text-white hover:text-gray-300 text-2xl transition-colors bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">×</button>' +
        '</div>' +
        
        '<div class="flex-1 flex items-center justify-center relative p-4">' +
            '<button onclick="navigateFullScreen(-1)" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center">' +
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>' +
                '</svg>' +
            '</button>' +
            
            '<div id="fullscreen-content" class="max-w-full max-h-full">' +
                renderFullScreenMedia(currentMedia) +
            '</div>' +
            
            '<button onclick="navigateFullScreen(1)" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center">' +
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>' +
                '</svg>' +
            '</button>' +
        '</div>';

    document.body.appendChild(modal);
}

function renderFullScreenMedia(media) {
    if (media.type === 'image') {
        return '<img src="' + media.url + '" alt="Property Image" class="max-w-full max-h-full object-contain" style="border-radius: 8px;">';
    } else if (media.type === 'video') {
        return '<video controls autoplay class="max-w-full max-h-full" style="border-radius: 8px;"><source src="' + media.url + '" type="video/mp4">Your browser does not support the video tag.</video>';
    } else if (media.type === 'youtube') {
        var videoId = extractYouTubeId(media.url);
        return '<div class="relative w-full max-w-5xl" style="padding-top: 56.25%; border-radius: 8px; overflow: hidden;"><iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/' + videoId + '?autoplay=1" frameborder="0" allowfullscreen></iframe></div>';
    }
}

function navigateFullScreen(direction) {
    currentGalleryIndex = (currentGalleryIndex + direction + propertyGalleryData.length) % propertyGalleryData.length;
    
    var currentMedia = propertyGalleryData[currentGalleryIndex];
    document.getElementById('fullscreen-content').innerHTML = renderFullScreenMedia(currentMedia);
    
    // Update counter
    var counterSpan = document.querySelector('#fullscreen-media-modal .bg-black.bg-opacity-50 span');
    if (counterSpan) {
        counterSpan.textContent = (currentGalleryIndex + 1) + ' of ' + propertyGalleryData.length;
    }
}

function closeFullScreenModal() {
    var modal = document.getElementById('fullscreen-media-modal');
    if (modal) {
        modal.remove();
    }
}

function closeRukitaGallery() {
    var modal = document.getElementById('rukita-gallery-modal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
        
        // Show main navigation again
        var mainNav = document.querySelector('nav, .navbar, header');
        if (mainNav) {
            mainNav.style.display = '';
        }
    }
}

function extractYouTubeId(url) {
    if (!url) return null;
    var patterns = [
        /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/,
        /youtube\.com\/.*[?&]v=([a-zA-Z0-9_-]{11})/
    ];
    for (var i = 0; i < patterns.length; i++) {
        var match = url.match(patterns[i]);
        if (match && match[1]) return match[1];
    }
    return null;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (document.getElementById('fullscreen-media-modal')) {
        switch(e.key) {
            case 'Escape':
                closeFullScreenModal();
                break;
            case 'ArrowLeft':
                navigateFullScreen(-1);
                break;
            case 'ArrowRight':
                navigateFullScreen(1);
                break;
        }
    } else if (document.getElementById('rukita-gallery-modal')) {
        if (e.key === 'Escape') {
            closeRukitaGallery();
        }
    }
});
</script>

@else
    <div class="container-fluid">
        <div class="mt-4 p-8 text-center bg-gray-100 rounded-lg">
            <i class="mdi mdi-image-off text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600">No media available for this property</p>
        </div>
    </div>
@endif