@extends('layouts.admin')

@section('title', 'Media Management')
@section('page-title', 'Media Files Management')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <!-- Header with Upload Button -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Media Library</h2>
                <p class="text-sm text-gray-600 mt-1">Manage your images, videos, and audio files</p>
            </div>
            <button onclick="openUploadModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center space-x-2">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Upload New Media</span>
            </button>
        </div>
        
        <!-- Filters -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="searchInput" placeholder="Search by name..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select id="typeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Types</option>
                    <option value="Gambar">Images</option>
                    <option value="Video">Videos</option>
                    <option value="Audio">Audio</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" id="dateFrom" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" id="dateTo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>
    </div>
    
    <!-- Media Grid -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="mediaGrid">
            @forelse($media as $item)
            <div class="media-item bg-gray-50 rounded-lg overflow-hidden shadow hover:shadow-lg transition" data-type="{{ $item->type }}" data-name="{{ strtolower($item->name) }}" data-date="{{ $item->created_at->format('Y-m-d') }}">
                <div class="relative aspect-video bg-gray-200">
                    @if($item->type === 'Gambar')
                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                    @elseif($item->type === 'Video')
                        <video class="w-full h-full object-cover">
                            <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button onclick="playVideo('{{ asset('storage/' . $item->file_path) }}')" class="bg-black bg-opacity-50 text-white rounded-full p-4 hover:bg-opacity-70 transition">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    @elseif($item->type === 'Audio')
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-600">
                            <i class="fas fa-music text-white text-4xl mb-4"></i>
                            <button onclick="playAudio('{{ asset('storage/' . $item->file_path) }}', '{{ $item->name }}')" class="bg-white text-indigo-600 px-4 py-2 rounded-full hover:bg-gray-100 transition">
                                <i class="fas fa-play mr-2"></i> Play Audio
                            </button>
                        </div>
                    @endif
                    
                    <!-- Badge for Landing Page -->
                    @if($item->show_on_landing)
                    <div class="absolute top-2 right-2">
                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-check"></i> Landing
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 truncate">{{ $item->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        <i class="fas fa-{{ $item->type === 'Gambar' ? 'image' : ($item->type === 'Video' ? 'video' : 'music') }} mr-1"></i>
                        {{ $item->type }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $item->created_at->format('M d, Y') }}
                    </p>
                    @if(Auth::user()->isSuperAdmin())
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-user mr-1"></i>
                        {{ $item->user->name }}
                    </p>
                    @endif
                    
                    <div class="flex justify-between mt-4">
                        <button onclick="toggleLanding({{ $item->id }}, {{ $item->show_on_landing ? 'false' : 'true' }})" class="text-sm {{ $item->show_on_landing ? 'text-red-600' : 'text-green-600' }} hover:underline">
                            <i class="fas fa-{{ $item->show_on_landing ? 'times' : 'check' }}"></i>
                            {{ $item->show_on_landing ? 'Remove from' : 'Add to' }} Landing
                        </button>
                        <button onclick="deleteMedia({{ $item->id }})" class="text-sm text-red-600 hover:underline">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">No media files found</p>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $media->links() }}
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Upload New Media</h3>
                <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Media Type</label>
                    <select name="jenisMedia" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Type</option>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                        <option value="audio">Audio</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Name</label>
                    <input type="text" name="namaFile" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter file name">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
                    <input type="file" name="file" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Max file size: 50MB</p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeUploadModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Audio Player Modal -->
<div id="audioModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold" id="audioTitle">Audio Player</h3>
                <button onclick="closeAudioModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <audio id="audioPlayer" controls class="w-full"></audio>
        </div>
    </div>
</div>

<!-- Video Player Modal -->
<div id="videoModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Video Player</h3>
                <button onclick="closeVideoModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <video id="videoPlayer" controls class="w-full"></video>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Upload Modal Functions
function openUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    document.getElementById('uploadForm').reset();
}

// Audio Player Functions
function playAudio(src, title) {
    document.getElementById('audioTitle').textContent = title;
    document.getElementById('audioPlayer').src = src;
    document.getElementById('audioModal').classList.remove('hidden');
    document.getElementById('audioPlayer').play();
}

function closeAudioModal() {
    document.getElementById('audioPlayer').pause();
    document.getElementById('audioModal').classList.add('hidden');
}

// Video Player Functions
function playVideo(src) {
    document.getElementById('videoPlayer').src = src;
    document.getElementById('videoModal').classList.remove('hidden');
    document.getElementById('videoPlayer').play();
}

function closeVideoModal() {
    document.getElementById('videoPlayer').pause();
    document.getElementById('videoModal').classList.add('hidden');
}

// Upload Form Handler
document.getElementById('uploadForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("media.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            Swal.fire('Success!', data.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error!', data.message || 'Upload failed', 'error');
        }
    } catch (error) {
        Swal.fire('Error!', 'An error occurred during upload', 'error');
    }
});

// Toggle Landing Page Display
async function toggleLanding(mediaId, show) {
    try {
        const response = await fetch('{{ route("media.toggle-landing") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                media_ids: [mediaId],
                show: show
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            Swal.fire('Success!', data.message, 'success').then(() => {
                location.reload();
            });
        }
    } catch (error) {
        Swal.fire('Error!', 'An error occurred', 'error');
    }
}

// Delete Media
async function deleteMedia(mediaId) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch(`/media/${mediaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire('Deleted!', data.message, 'success').then(() => {
                    location.reload();
                });
            }
        } catch (error) {
            Swal.fire('Error!', 'An error occurred', 'error');
        }
    }
}

// Filter Functions
document.getElementById('searchInput').addEventListener('input', filterMedia);
document.getElementById('typeFilter').addEventListener('change', filterMedia);
document.getElementById('dateFrom').addEventListener('change', filterMedia);
document.getElementById('dateTo').addEventListener('change', filterMedia);

function filterMedia() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const type = document.getElementById('typeFilter').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    const items = document.querySelectorAll('.media-item');
    
    items.forEach(item => {
        const itemName = item.dataset.name;
        const itemType = item.dataset.type;
        const itemDate = item.dataset.date;
        
        let show = true;
        
        if (search && !itemName.includes(search)) show = false;
        if (type && itemType !== type) show = false;
        if (dateFrom && itemDate < dateFrom) show = false;
        if (dateTo && itemDate > dateTo) show = false;
        
        item.style.display = show ? 'block' : 'none';
    });
}
</script>
@endpush
