# Cara Update Landing Page untuk Support Social Media Videos

## Masalah
Video dari TikTok, Instagram, Facebook, Twitter tidak tampil di landing page karena menggunakan `<video>` tag yang hanya support file upload.

## Solusi
Gunakan component `media-renderer` yang sudah dibuat di `resources/views/components/media-renderer.blade.php`

## Cara Update

### SEBELUM (Hanya support file upload):
```blade
@php $item1 = $media->where('layout_order', 1)->first(); @endphp
@if($item1)
  @if($item1->type === 'Gambar')
    <img src="{{ asset('storage/' . $item1->file_path) }}" alt="{{ $item1->name }}" loading="lazy">
  @elseif($item1->type === 'Video')
    <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
      <source src="{{ asset('storage/' . $item1->file_path) }}" type="video/mp4">
    </video>
  @endif
@endif
```

### SESUDAH (Support semua platform):
```blade
@php $item1 = $media->where('layout_order', 1)->first(); @endphp
<x-media-renderer :media="$item1" />
```

## Update Semua Items

Ganti semua bagian rendering (item1, item2, item3, item4, item5, item6) dengan component:

```blade
<!-- Item 1 -->
<div class="gallery-item">
  @php $item1 = $media->where('layout_order', 1)->first(); @endphp
  <x-media-renderer :media="$item1" />
</div>

<!-- Item 2 -->
<div class="gallery-item">
  @php $item2 = $media->where('layout_order', 2)->first(); @endphp
  <x-media-renderer :media="$item2" />
</div>

<!-- Item 3 -->
<div class="gallery-item">
  @php $item3 = $media->where('layout_order', 3)->first(); @endphp
  <x-media-renderer :media="$item3" />
</div>

<!-- Item 4 -->
<div class="gallery-item">
  @php $item4 = $media->where('layout_order', 4)->first(); @endphp
  <x-media-renderer :media="$item4" />
</div>

<!-- Item 5 -->
<div class="gallery-item">
  @php $item5 = $media->where('layout_order', 5)->first(); @endphp
  <x-media-renderer :media="$item5" />
</div>

<!-- Item 6 -->
<div class="gallery-item">
  @php $item6 = $media->where('layout_order', 6)->first(); @endphp
  <x-media-renderer :media="$item6" />
</div>
```

## Keuntungan

✅ **YouTube** - Iframe embed dengan autoplay
✅ **TikTok** - Blockquote embed dengan script
✅ **Instagram** - Blockquote embed dengan script
✅ **Facebook** - Iframe embed dengan autoplay
✅ **Twitter** - Blockquote embed dengan script
✅ **Uploaded Videos** - Video tag (existing behavior)
✅ **Images** - Img tag (existing behavior)

## Testing

1. Tambahkan video YouTube di layout manager → Harus tampil di landing page
2. Tambahkan video TikTok di layout manager → Harus tampil di landing page
3. Tambahkan video Instagram di layout manager → Harus tampil di landing page
4. Tambahkan video Facebook di layout manager → Harus tampil di landing page
5. Tambahkan video Twitter di layout manager → Harus tampil di landing page

## Catatan

- Component sudah handle semua platform
- Component sudah handle error (fallback)
- Component sudah handle empty slots
- Tidak perlu ubah CSS atau JavaScript
- Cukup ganti rendering logic saja
