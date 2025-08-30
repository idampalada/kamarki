// File: platform/themes/hously/assets/js/property-gallery.js

class PropertyMediaGallery {
    constructor() {
        this.currentIndex = 0;
        this.mediaData = [];
        this.propertyName = '';
        this.modal = null;
        this.preloadedImages = new Map();
        
        this.bindEvents();
    }

    init(mediaData, propertyName, startIndex = 0) {
        this.mediaData = mediaData || [];
        this.propertyName = propertyName || 'Property Gallery';
        this.currentIndex = startIndex;
        
        // Preload beberapa media untuk performance
        this.preloadMedia();
        
        this.createModal();
        this.render();
    }

    bindEvents() {
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!this.modal) return;
            
            switch(e.key) {
                case 'Escape':
                    this.close();
                    break;
                case 'ArrowLeft':
                    this.navigate('prev');
                    break;
                case 'ArrowRight':
                    this.navigate('next');
                    break;
                case ' ': // Spacebar
                    e.preventDefault();
                    this.toggleVideoPlay();
                    break;
            }
        });

        // Touch/swipe support untuk mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', (e) => {
            if (!this.modal) return;
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', (e) => {
            if (!this.modal) return;
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(touchStartX, touchEndX);
        });
    }

    handleSwipe(startX, endX) {
        const swipeThreshold = 50;
        const diff = startX - endX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.navigate('next');
            } else {
                this.navigate('prev');
            }
        }
    }

    preloadMedia() {
        // Preload current dan next/prev images untuk smooth transition
        const indices = [
            this.currentIndex,
            (this.currentIndex + 1) % this.mediaData.length,
            (this.currentIndex - 1 + this.mediaData.length) % this.mediaData.length
        ];

        indices.forEach(index => {
            const media = this.mediaData[index];
            if (media && media.type === 'image' && !this.preloadedImages.has(media.url)) {
                const img = new Image();
                img.src = media.url;
                this.preloadedImages.set(media.url, img);
            }
        });
    }

    createModal() {
        // Hapus modal existing
        this.close();

        this.modal = document.createElement('div');
        this.modal.id = 'property-gallery-modal';
        this.modal.className = 'fixed inset-0 bg-black z-50 flex flex-col opacity-0 transition-opacity duration-300';
        
        // Struktur modal
        this.modal.innerHTML = `
            <div class="absolute top-0 left-0 right-0 z-10 flex justify-between items-center p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%); padding-bottom: 3rem;">
                <button id="gallery-back-btn" class="text-white hover:text-gray-300 transition-all duration-200 w-10 h-10 flex items-center justify-center rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h3 id="gallery-title" class="text-white text-lg font-medium text-center flex-1 mx-4 truncate" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">${this.propertyName}</h3>
                <button id="gallery-close-btn" class="text-white hover:text-gray-300 text-2xl transition-all duration-200 w-10 h-10 flex items-center justify-center rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20">×</button>
            </div>

            <div class="flex-1 flex items-center justify-center relative">
                <button id="gallery-prev-btn" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 text-white hover:text-gray-300 transition-all duration-300 bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center hover:scale-110 backdrop-blur-sm border border-white border-opacity-10 hover:border-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <div id="gallery-content" class="max-w-full max-h-full flex items-center justify-center p-8">
                    <!-- Media content akan di-render disini -->
                </div>
                
                <button id="gallery-next-btn" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 text-white hover:text-gray-300 transition-all duration-300 bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center hover:scale-110 backdrop-blur-sm border border-white border-opacity-10 hover:border-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div class="absolute bottom-4 left-4 z-10">
                <div class="bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm border border-white border-opacity-10" style="box-shadow: 0 8px 32px rgba(0,0,0,0.3);">
                    <span id="current-index">1</span> of <span id="total-items">${this.mediaData.length}</span>
                </div>
            </div>
        `;

        document.body.appendChild(this.modal);
        document.body.style.overflow = 'hidden';

        // Bind event listeners
        this.bindModalEvents();

        // Animate in
        setTimeout(() => {
            this.modal.classList.remove('opacity-0');
        }, 10);
    }

    bindModalEvents() {
        // Close buttons
        this.modal.querySelector('#gallery-close-btn').onclick = () => this.close();
        this.modal.querySelector('#gallery-back-btn').onclick = () => this.close();

        // Navigation buttons
        this.modal.querySelector('#gallery-prev-btn').onclick = () => this.navigate('prev');
        this.modal.querySelector('#gallery-next-btn').onclick = () => this.navigate('next');

        // Click outside to close
        this.modal.querySelector('#gallery-content').onclick = (e) => {
            if (e.target.id === 'gallery-content') {
                this.close();
            }
        };
    }

    render() {
        const contentEl = this.modal.querySelector('#gallery-content');
        const currentIndexEl = this.modal.querySelector('#current-index');
        
        if (currentIndexEl) {
            currentIndexEl.textContent = this.currentIndex + 1;
        }

        // Show loading
        contentEl.innerHTML = `
            <div class="flex items-center justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white"></div>
            </div>
        `;

        // Render media
        setTimeout(() => {
            contentEl.innerHTML = this.renderMedia();
        }, 100);

        // Preload next media
        this.preloadMedia();
    }

    renderMedia() {
        const media = this.mediaData[this.currentIndex];
        if (!media) return '<div class="text-white">Media tidak ditemukan</div>';

        switch(media.type) {
            case 'image':
                return `<img src="${media.url}" alt="${this.propertyName}" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" style="box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">`;
                
            case 'video':
                return `
                    <video controls autoplay class="max-w-full max-h-full rounded-lg shadow-2xl" style="object-fit: contain; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">
                        <source src="${media.url}" type="video/mp4">
                        <source src="${media.url}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                `;
                
            case 'youtube':
                const videoId = this.extractYouTubeId(media.url);
                return `
                    <div class="relative w-full max-w-5xl rounded-lg overflow-hidden shadow-2xl" style="padding-top: 56.25%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">
                        <iframe class="absolute inset-0 w-full h-full" 
                                src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0" 
                                frameborder="0" 
                                allowfullscreen>
                        </iframe>
                    </div>
                `;
                
            default:
                return '<div class="text-white">Format media tidak didukung</div>';
        }
    }

    navigate(direction) {
        const oldIndex = this.currentIndex;
        
        if (direction === 'next') {
            this.currentIndex = (this.currentIndex + 1) % this.mediaData.length;
        } else {
            this.currentIndex = (this.currentIndex - 1 + this.mediaData.length) % this.mediaData.length;
        }

        // Animate transition
        const contentEl = this.modal.querySelector('#gallery-content');
        contentEl.style.opacity = '0';
        contentEl.style.transform = direction === 'next' ? 'translateX(20px)' : 'translateX(-20px)';

        setTimeout(() => {
            this.render();
            contentEl.style.opacity = '1';
            contentEl.style.transform = 'translateX(0)';
        }, 150);
    }

    toggleVideoPlay() {
        const video = this.modal.querySelector('video');
        if (video) {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }
    }

    close() {
        if (this.modal) {
            this.modal.classList.add('opacity-0');
            setTimeout(() => {
                this.modal.remove();
                this.modal = null;
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    extractYouTubeId(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length === 11) ? match[7] : null;
    }
}

// Global instance
window.propertyGallery = new PropertyMediaGallery();

// Global functions untuk backward compatibility
window.openPropertyGallery = (index = 0) => {
    if (window.propertyGalleryData && window.propertyGalleryName) {
        window.propertyGallery.init(window.propertyGalleryData, window.propertyGalleryName, index);
    }
};

window.closePropertyGallery = () => {
    window.propertyGallery.close();
};

window.navigatePropertyGallery = (direction) => {
    window.propertyGallery.navigate(direction);
};
    constructor() {
        this.currentIndex = 0;
        this.mediaData = [];
        this.propertyName = '';
        this.modal = null;
        this.preloadedImages = new Map();
        
        this.bindEvents();
    }

    init(mediaData, propertyName, startIndex = 0) {
        this.mediaData = mediaData || [];
        this.propertyName = propertyName || 'Property Gallery';
        this.currentIndex = startIndex;
        
        // Preload beberapa media untuk performance
        this.preloadMedia();
        
        this.createModal();
        this.render();
    }

    bindEvents() {
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!this.modal) return;
            
            switch(e.key) {
                case 'Escape':
                    this.close();
                    break;
                case 'ArrowLeft':
                    this.navigate('prev');
                    break;
                case 'ArrowRight':
                    this.navigate('next');
                    break;
                case ' ': // Spacebar
                    e.preventDefault();
                    this.toggleVideoPlay();
                    break;
            }
        });

        // Touch/swipe support untuk mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', (e) => {
            if (!this.modal) return;
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', (e) => {
            if (!this.modal) return;
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(touchStartX, touchEndX);
        });
    }

    handleSwipe(startX, endX) {
        const swipeThreshold = 50;
        const diff = startX - endX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.navigate('next');
            } else {
                this.navigate('prev');
            }
        }
    }

    preloadMedia() {
        // Preload current dan next/prev images untuk smooth transition
        const indices = [
            this.currentIndex,
            (this.currentIndex + 1) % this.mediaData.length,
            (this.currentIndex - 1 + this.mediaData.length) % this.mediaData.length
        ];

        indices.forEach(index => {
            const media = this.mediaData[index];
            if (media && media.type === 'image' && !this.preloadedImages.has(media.url)) {
                const img = new Image();
                img.src = media.url;
                this.preloadedImages.set(media.url, img);
            }
        });
    }

    createModal() {
        // Hapus modal existing
        this.close();

        this.modal = document.createElement('div');
        this.modal.id = 'rukita-gallery-modal';
        this.modal.className = 'fixed inset-0 bg-black z-50 flex flex-col opacity-0 transition-opacity duration-300';
        
        // Struktur modal
        this.modal.innerHTML = `
            <div class="absolute top-0 left-0 right-0 z-10 flex justify-between items-center p-4" style="background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%); padding-bottom: 3rem;">
                <button id="gallery-back-btn" class="text-white hover:text-gray-300 transition-all duration-200 w-10 h-10 flex items-center justify-center rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h3 id="gallery-title" class="text-white text-lg font-medium text-center flex-1 mx-4 truncate" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">${this.propertyName}</h3>
                <button id="gallery-close-btn" class="text-white hover:text-gray-300 text-2xl transition-all duration-200 w-10 h-10 flex items-center justify-center rounded-lg bg-white bg-opacity-10 backdrop-blur-sm hover:bg-opacity-20">×</button>
            </div>

            <div class="flex-1 flex items-center justify-center relative">
                <button id="gallery-prev-btn" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 text-white hover:text-gray-300 transition-all duration-300 bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center hover:scale-110 backdrop-blur-sm border border-white border-opacity-10 hover:border-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <div id="gallery-content" class="max-w-full max-h-full flex items-center justify-center p-8">
                    <!-- Media content akan di-render disini -->
                </div>
                
                <button id="gallery-next-btn" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 text-white hover:text-gray-300 transition-all duration-300 bg-black bg-opacity-30 hover:bg-opacity-50 rounded-full w-12 h-12 flex items-center justify-center hover:scale-110 backdrop-blur-sm border border-white border-opacity-10 hover:border-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div class="absolute bottom-4 left-4 z-10">
                <div class="bg-black bg-opacity-60 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm border border-white border-opacity-10" style="box-shadow: 0 8px 32px rgba(0,0,0,0.3);">
                    <span id="current-index">1</span> of <span id="total-items">${this.mediaData.length}</span>
                </div>
            </div>
        `;

        document.body.appendChild(this.modal);
        document.body.style.overflow = 'hidden';

        // Bind event listeners
        this.bindModalEvents();

        // Animate in
        setTimeout(() => {
            this.modal.classList.remove('opacity-0');
        }, 10);
    }

    bindModalEvents() {
        // Close buttons
        this.modal.querySelector('#gallery-close-btn').onclick = () => this.close();
        this.modal.querySelector('#gallery-back-btn').onclick = () => this.close();

        // Navigation buttons
        this.modal.querySelector('#gallery-prev-btn').onclick = () => this.navigate('prev');
        this.modal.querySelector('#gallery-next-btn').onclick = () => this.navigate('next');

        // Click outside to close
        this.modal.querySelector('#gallery-content').onclick = (e) => {
            if (e.target.id === 'gallery-content') {
                this.close();
            }
        };
    }

    render() {
        const contentEl = this.modal.querySelector('#gallery-content');
        const currentIndexEl = this.modal.querySelector('#current-index');
        
        if (currentIndexEl) {
            currentIndexEl.textContent = this.currentIndex + 1;
        }

        // Show loading
        contentEl.innerHTML = `
            <div class="flex items-center justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white"></div>
            </div>
        `;

        // Render media
        setTimeout(() => {
            contentEl.innerHTML = this.renderMedia();
        }, 100);

        // Preload next media
        this.preloadMedia();
    }

    renderMedia() {
        const media = this.mediaData[this.currentIndex];
        if (!media) return '<div class="text-white">Media tidak ditemukan</div>';

        switch(media.type) {
            case 'image':
                return `<img src="${media.url}" alt="${this.propertyName}" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" style="box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">`;
                
            case 'video':
                return `
                    <video controls autoplay class="max-w-full max-h-full rounded-lg shadow-2xl" style="object-fit: contain; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">
                        <source src="${media.url}" type="video/mp4">
                        <source src="${media.url}" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                `;
                
            case 'youtube':
                const videoId = this.extractYouTubeId(media.url);
                return `
                    <div class="relative w-full max-w-5xl rounded-lg overflow-hidden shadow-2xl" style="padding-top: 56.25%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);">
                        <iframe class="absolute inset-0 w-full h-full" 
                                src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0" 
                                frameborder="0" 
                                allowfullscreen>
                        </iframe>
                    </div>
                `;
                
            default:
                return '<div class="text-white">Format media tidak didukung</div>';
        }
    }

    navigate(direction) {
        const oldIndex = this.currentIndex;
        
        if (direction === 'next') {
            this.currentIndex = (this.currentIndex + 1) % this.mediaData.length;
        } else {
            this.currentIndex = (this.currentIndex - 1 + this.mediaData.length) % this.mediaData.length;
        }

        // Animate transition
        const contentEl = this.modal.querySelector('#gallery-content');
        contentEl.style.opacity = '0';
        contentEl.style.transform = direction === 'next' ? 'translateX(20px)' : 'translateX(-20px)';

        setTimeout(() => {
            this.render();
            contentEl.style.opacity = '1';
            contentEl.style.transform = 'translateX(0)';
        }, 150);
    }

    toggleVideoPlay() {
        const video = this.modal.querySelector('video');
        if (video) {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }
    }

    close() {
        if (this.modal) {
            this.modal.classList.add('opacity-0');
            setTimeout(() => {
                this.modal.remove();
                this.modal = null;
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    extractYouTubeId(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length === 11) ? match[7] : null;
    }
}

// Global instance
window.rukitaGallery = new RukitaMediaGallery();

// Global functions untuk backward compatibility
window.openRukitaGallery = (index = 0) => {
    if (window.rukitaGalleryData && window.rukitaPropertyName) {
        window.rukitaGallery.init(window.rukitaGalleryData, window.rukitaPropertyName, index);
    }
};

window.closeRukitaGallery = () => {
    window.rukitaGallery.close();
};

window.navigateGallery = (direction) => {
    window.rukitaGallery.navigate(direction);
};