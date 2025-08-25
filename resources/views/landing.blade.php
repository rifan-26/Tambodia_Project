<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Gallery - Welcome</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .media-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">MediaHub</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#images" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Images</a>
                    <a href="#videos" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Videos</a>
                    <a href="#audio" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Audio</a>
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Admin Login
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-5xl font-bold mb-4 animate-fade-in">Welcome to MediaHub</h2>
            <p class="text-xl mb-8 opacity-90">Explore our collection of images, videos, and audio content</p>
            <div class="flex justify-center space-x-4">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <i class="fas fa-image text-3xl mb-2"></i>
                    <p class="text-lg font-semibold">{{ $stats['images'] }} Images</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <i class="fas fa-video text-3xl mb-2"></i>
                    <p class="text-lg font-semibold">{{ $stats['videos'] }} Videos</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <i class="fas fa-music text-3xl mb-2"></i>
                    <p class="text-lg font-semibold">{{ $stats['audio'] }} Audio Files</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Carousel -->
    @if($featured->count() > 0)
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Featured Content</h3>
            <div class="swiper featuredSwiper">
                <div class="swiper-wrapper">
                    @foreach($featured as $item)
                    <div class="swiper-slide">
                        <div class="relative rounded-lg overflow-hidden shadow-lg">
                            @if($item->type === 'Gambar')
                                <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->name }}" class="w-full h-96 object-cover">
                            @elseif($item->type === 'Video')
                                <video class="w-full h-96 object-cover" controls>
                                    <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                                </video>
                            @else
                                <div class="h-96 bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                                    <div class="text-center text-white">
                                        <i class="fas fa-music text-6xl mb-4"></i>
                                        <p class="text-2xl font-bold">{{ $item->name }}</p>
                                        <audio controls class="mt-4">
                                            <source src="{{ asset('storage/' . $item->file_path) }}" type="audio/mpeg">
                                        </audio>
                                    </div>
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                <h4 class="text-white text-xl font-bold">{{ $item->name }}</h4>
                                <p class="text-gray-200 text-sm">{{ $item->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif
    
    <!-- Images Section -->
    @if($images->count() > 0)
    <section id="images" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800 mb-8">
                <i class="fas fa-image text-indigo-600 mr-3"></i>Image Gallery
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($images as $image)
                <div class="media-card bg-white rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl">
                    <div class="relative aspect-square">
                        <img src="{{ asset('storage/' . $image->file_path) }}" 
                             alt="{{ $image->name }}" 
                             class="w-full h-full object-cover cursor-pointer"
                             onclick="openLightbox('{{ asset('storage/' . $image->file_path) }}', '{{ $image->name }}')">
                        <div class="absolute top-2 right-2">
                            <span class="bg-white bg-opacity-90 text-gray-800 text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-image mr-1"></i>Image
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 truncate">{{ $image->name }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $image->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Videos Section -->
    @if($videos->count() > 0)
    <section id="videos" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800 mb-8">
                <i class="fas fa-video text-indigo-600 mr-3"></i>Video Collection
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($videos as $video)
                <div class="media-card bg-white rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl">
                    <div class="relative aspect-video">
                        <video class="w-full h-full object-cover" controls poster="">
                            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div class="absolute top-2 right-2">
                            <span class="bg-white bg-opacity-90 text-gray-800 text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-video mr-1"></i>Video
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 truncate">{{ $video->name }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $video->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Audio Section -->
    @if($audioFiles->count() > 0)
    <section id="audio" class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800 mb-8">
                <i class="fas fa-music text-indigo-600 mr-3"></i>Audio Library
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($audioFiles as $audio)
                <div class="media-card bg-white rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl">
                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold">{{ $audio->name }}</h4>
                                <p class="text-sm opacity-90 mt-1">{{ $audio->created_at->format('M d, Y') }}</p>
                            </div>
                            <i class="fas fa-music text-4xl opacity-50"></i>
                        </div>
                    </div>
                    <div class="p-4">
                        <audio controls class="w-full">
                            <source src="{{ asset('storage/' . $audio->file_path) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Empty State -->
    @if($images->count() == 0 && $videos->count() == 0 && $audioFiles->count() == 0)
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">No Content Available</h3>
            <p class="text-gray-500">Media content will appear here once uploaded by administrators.</p>
        </div>
    </section>
    @endif
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold">MediaHub</h3>
                    <p class="text-gray-400 mt-1">Your digital media gallery</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; 2025 MediaHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center p-4">
        <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-full rounded-lg">
        <div id="lightboxCaption" class="absolute bottom-4 left-4 right-4 text-center text-white text-lg"></div>
    </div>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <script>
        // Initialize Swiper
        var swiper = new Swiper(".featuredSwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        
        // Lightbox functions
        function openLightbox(src, caption) {
            document.getElementById('lightboxImage').src = src;
            document.getElementById('lightboxCaption').textContent = caption;
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
        }
        
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
        }
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
