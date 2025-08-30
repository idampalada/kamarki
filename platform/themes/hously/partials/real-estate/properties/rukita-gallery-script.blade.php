{{-- JavaScript untuk Rukita Style Gallery Modal --}}
<script>
// Global variables untuk gallery
var propertyGalleryData = @json($allMedia ?? []);
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
    modal.className = 'fixed inset-0 bg-black z-50 flex flex-col';
    modal.style.backgroundColor = '#2d3748'; // Dark background like Rukita
    
    // Header dengan back button, title, dan tabs
    var headerHTML = 
        '<div class="bg-white border-b sticky top-0 z-20">' +
            '<div class="flex items-center justify-between p-4">' +
                '<button onclick="closeRukitaGallery()" class="text-gray-600 hover:text-gray-800">' +
                    '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>' +
                    '</svg>' +
                '</button>' +
                '<h3 class="text-lg font-semibold text-center flex-1 mx-4">' + propertyGalleryName + '</h3>' +
                '<div class="w-6"></div>' + // Spacer for centering
            '</div>' +
            
            // Navigation tabs
            '<div class="flex border-t bg-gray-50">' +
                '<button onclick="switchTab(\'360\')" class="flex-1 py-3 text-center font-medium border-b-2 ' + 
                (currentTab === '360' ? 'text-teal-600 border-teal-600' : 'text-gray-500 border-transparent hover:text-gray-700') + '">360</button>' +
                
                '<button onclick="switchTab(\'video\')" class="flex-1 py-3 text-center font-medium border-b-2 ' + 
                (currentTab === 'video' ? 'text-teal-600 border-teal-600' : 'text-gray-500 border-transparent hover:text-gray-700') + '">Video</button>' +
                
                '<button onclick="switchTab(\'foto\')" class="flex-1 py-3 text-center font-medium border-b-2 ' + 
                (currentTab === 'foto' ? 'text-teal-600 border-teal-600' : 'text-gray-500 border-transparent hover:text-gray-700') + '">Foto</button>' +
            '</div>' +
        '</div>';

    // Content area dengan scrollable media
    var contentHTML = '<div id="media-content" class="flex-1 overflow-y-auto">' + renderTabContent() + '</div>';

    modal.innerHTML = headerHTML + contentHTML;
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function switchTab(tab) {
    currentTab = tab;
    
    // Update tab styling
    var tabs = document.querySelectorAll('#rukita-gallery-modal button[onclick*="switchTab"]');
    tabs.forEach(function(tabBtn) {
        tabBtn.className = tabBtn.className.replace('text-teal-600 border-teal-600', 'text-gray-500 border-transparent hover:text-gray-700');
    });
    
    var activeTab = document.querySelector('#rukita-gallery-modal button[onclick="switchTab(\'' + tab + '\')"]');
    if (activeTab) {
        activeTab.className = activeTab.className.replace('text-gray-500 border-transparent hover:text-gray-700', 'text-teal-600 border-teal-600');
    }
    
    // Update content
    document.getElementById('media-content').innerHTML = renderTabContent();
}

function renderTabContent() {
    if (currentTab === '360') {
        return '<div class="p-8 text-center text-white"><div class="text-6xl mb-4">📐</div><p class="text-lg">360° View tidak tersedia</p></div>';
    }
    
    var mediaToShow = [];
    if (currentTab === 'video') {
        mediaToShow = propertyGalleryData.filter(function(item) {
            return item.type === 'video' || item.type === 'youtube';
        });
    } else if (currentTab === 'foto') {
        mediaToShow = propertyGalleryData.filter(function(item) {
            return item.type === 'image';
        });
    }
    
    if (mediaToShow.length === 0) {
        return '<div class="p-8 text-center text-white"><p class="text-lg">Tidak ada ' + currentTab + ' tersedia</p></div>';
    }
    
    var html = '<div class="p-4 space-y-4">';
    
    mediaToShow.forEach(function(media, index) {
        html += '<div class="bg-white rounded-lg overflow-hidden shadow-lg cursor-pointer" onclick="openFullScreenMedia(' + getGlobalIndex(media) + ')">';
        
        if (media.type === 'image') {
            html += 
                '<div class="relative aspect-video">' +
                    '<img src="' + media.url + '" alt="Property Image" class="w-full h-full object-cover">' +
                    '<div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">' +
                        '<div class="opacity-0 hover:opacity-100 transition-opacity duration-300">' +
                            '<div class="bg-white rounded-full p-3">' +
                                '<svg class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 20 20">' +
                                    '<path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>' +
                                '</svg>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        } else if (media.type === 'youtube') {
            var videoId = extractYouTubeId(media.url);
            html += 
                '<div class="relative aspect-video">' +
                    '<img src="https://img.youtube.com/vi/' + videoId + '/maxresdefault.jpg" alt="YouTube Video" class="w-full h-full object-cover">' +
                    '<div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">' +
                        '<div class="bg-red-600 rounded-full p-4 hover:bg-red-700 transition-colors">' +
                            '<svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">' +
                                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8.108v3.784a1 1 0 001.555.832l3.101-1.892a1 1 0 000-1.664L9.555 7.168z" clip-rule="evenodd"></path>' +
                            '</svg>' +
                        '</div>' +
                    '</div>' +
                    '<div class="absolute top-3 left-3">' +
                        '<span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold">YouTube</span>' +
                    '</div>' +
                '</div>';
        } else if (media.type === 'video') {
            html += 
                '<div class="relative aspect-video">' +
                    '<video class="w-full h-full object-cover" preload="metadata">' +
                        '<source src="' + media.url + '#t=1" type="video/mp4">' +
                    '</video>' +
                    '<div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">' +
                        '<div class="bg-blue-600 rounded-full p-4 hover:bg-blue-700 transition-colors">' +
                            '<svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">' +
                                '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8.108v3.784a1 1 0 001.555.832l3.101-1.892a1 1 0 000-1.664L9.555 7.168z" clip-rule="evenodd"></path>' +
                            '</svg>' +
                        '</div>' +
                    '</div>' +
                    '<div class="absolute top-3 left-3">' +
                        '<span class="bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold">VIDEO</span>' +
                    '</div>' +
                '</div>';
        }
        
        html += '</div>';
    });
    
    html += '</div>';
    return html;
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
        
        '<div class="flex-1 flex items-center justify-center relative">' +
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
    var counter = document.querySelector('#fullscreen-media-modal .bg-black.bg-opacity-50 span');
    if (counter) {
        counter.textContent = (currentGalleryIndex + 1) + ' of ' + propertyGalleryData.length;
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