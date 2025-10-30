# 🎯 INSTRUKSI UPDATE LANDING PAGE

## ⚠️ PENTING
File `landingpage.blade.php` sudah di-minify (semua dalam 1 baris), jadi perlu di-format dulu sebelum edit.

## 📝 Langkah-Langkah:

### 1. Format File (Opsional tapi Recommended)
Buka `landingpage.blade.php` di VS Code, lalu:
- Tekan `Shift + Alt + F` (Windows) atau `Shift + Option + F` (Mac)
- Atau klik kanan → Format Document

### 2. Cari dan Ganti (Find & Replace)

Gunakan Find & Replace di VS Code (`Ctrl + H`):

#### ✅ Replace Item 1:
**Find:**
```
@php $item1 = $media->where('layout_order', 1)->first(); @endphp
              @if($item1)
                @if($item1->type === 'Gambar')
                  <img src="{{ asset('storage/' . $item1->file_path) }}" alt="{{ $item1->name }}" loading="lazy">
                @elseif($item1->type === 'Video')
                  <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset('storage/' . $item1->file_path) }}" type="video/mp4"></video>
                @endif
              @endif
```

**Replace with:**
```
@php $item1 = $media->where('layout_order', 1)->first(); @endphp
              <x-media-renderer :media="$item1" />
```

#### ✅ Replace Item 2:
**Find:**
```
@php $item2 = $media->where('layout_order', 2)->first(); @endphp
                @if($item2)
                  @if($item2->type === 'Gambar')
                    <img src="{{ asset('storage/' . $item2->file_path) }}" alt="{{ $item2->name }}" loading="lazy">
                  @elseif($item2->type === 'Video')
                    <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;"><source src="{{ asset('storage/' . $item2->file_path) }}" type="video/mp4"></video>
                  @endif
                @endif
```

**Replace with:**
```
@php $item2 = $media->where('layout_order', 2)->first(); @endphp
                <x-media-renderer :media="$item2" />
```

#### ✅ Replace Item 3, 4, 5, 6:
Ulangi pattern yang sama untuk item3, item4, item5, item6.

### 3. Cara Cepat (Regex Find & Replace)

Enable Regex mode di Find & Replace (`Alt + R`), lalu:

**Find (Regex):**
```regex
@php \$item(\d+) = \$media->where\('layout_order', \d+\)->first\(\); @endphp\s+@if\(\$item\1\)\s+@if\(\$item\1->type === 'Gambar'\).*?@endif\s+@endif
```

**Replace with:**
```
@php $item$1 = $media->where('layout_order', $1)->first(); @endphp
              <x-media-renderer :media="$$item$1" />
```

### 4. Verifikasi

Setelah replace, pastikan:
- ✅ Semua 6 items sudah diganti
- ✅ Syntax blade masih benar
- ✅ Tidak ada error di file

### 5. Test

1. Buka landing page di browser
2. Pastikan semua media tampil normal
3. Test dengan video dari berbagai platform

## 🚀 Alternatif: Manual Edit

Jika Find & Replace tidak berhasil, edit manual:

1. Cari `@php $item1 =` 
2. Hapus semua dari `@if($item1)` sampai `@endif @endif`
3. Ganti dengan `<x-media-renderer :media="$item1" />`
4. Ulangi untuk item2 sampai item6

## ✅ Hasil Akhir

Setelah update, setiap item akan terlihat seperti ini:

```blade
<!-- Item 1 -->
<div class="gallery-item">
  @php $item1 = $media->where('layout_order', 1)->first(); @endphp
  <x-media-renderer :media="$item1" />
</div>
```

## 🎉 Selesai!

Sekarang video dari semua platform (YouTube, TikTok, Instagram, Facebook, Twitter) akan tampil di landing page!
