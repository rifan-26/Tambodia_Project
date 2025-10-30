{{-- Media Renderer Component - Supports Images, Videos (uploaded & external links) --}}
@props(['media'])

@if($media)
    @if($media->type === 'Gambar')
        {{-- Image --}}
        <img src="{{ asset('storage/' . $media->file_path) }}" 
             alt="{{ $media->name }}" 
             loading="lazy"
             style="width: 100%; height: 100%; object-fit: cover;">
             
    @elseif($media->type === 'Video')
        @if($media->isExternalVideo())
            {{-- External Video Link (YouTube, TikTok, Instagram, Facebook, Twitter) --}}
            
            @if($media->video_platform === 'youtube')
                {{-- YouTube Embed --}}
                <iframe src="{{ $media->getEmbedUrl() }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen
                        style="width: 100%; height: 100%; border: none; object-fit: cover;"></iframe>
                        
            @elseif($media->video_platform === 'tiktok')
                {{-- TikTok Embed --}}
                <blockquote class="tiktok-embed" 
                            cite="{{ $media->file_path }}" 
                            data-video-id="{{ $media->getTikTokVideoId() }}"
                            style="max-width: 100%; min-width: 100%; height: 100%;">
                    <section></section>
                </blockquote>
                <script async src="https://www.tiktok.com/embed.js"></script>
                
            @elseif($media->video_platform === 'instagram')
                {{-- Instagram Embed --}}
                <blockquote class="instagram-media" 
                            data-instgrm-permalink="{{ $media->file_path }}"
                            data-instgrm-version="14"
                            style="max-width: 100%; width: 100%; height: 100%;">
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
                
            @elseif($media->video_platform === 'facebook')
                {{-- Facebook Embed --}}
                <iframe src="{{ $media->getEmbedUrl() }}" 
                        frameborder="0" 
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                        style="width: 100%; height: 100%; border: none;"></iframe>
                        
            @elseif($media->video_platform === 'twitter')
                {{-- Twitter Embed --}}
                <blockquote class="twitter-tweet" data-theme="dark">
                    <a href="{{ $media->file_path }}"></a>
                </blockquote>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                
            @else
                {{-- Fallback for unknown platform --}}
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #000; color: #fff;">
                    <div style="text-align: center; padding: 20px;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 2rem; margin-bottom: 10px;"></i>
                        <p>Platform tidak didukung</p>
                        <small>{{ $media->video_platform }}</small>
                    </div>
                </div>
            @endif
            
        @else
            {{-- Uploaded Video File --}}
            <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                <source src="{{ asset('storage/' . $media->file_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @endif
        
    @elseif($media->type === 'Audio')
        {{-- Audio (should not appear in layout, but handle gracefully) --}}
        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff;">
            <div style="text-align: center; padding: 20px;">
                <i class="bi bi-music-note-beamed" style="font-size: 3rem; margin-bottom: 10px;"></i>
                <p style="margin: 0; font-weight: 600;">{{ $media->name }}</p>
                <small>Audio File</small>
            </div>
        </div>
    @endif
@else
    {{-- Empty Slot --}}
    <div style="width: 100%; height: 100%; background: transparent;"></div>
@endif
