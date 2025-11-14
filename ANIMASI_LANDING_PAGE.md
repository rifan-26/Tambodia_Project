# Animasi Landing Page - Dokumentasi (Versi Optimized)

## Animasi yang Ditambahkan

### 1. **Header Section**
- **Logo**: Animasi `pulse` (4 detik) - Logo berkedip lembut secara bergantian dengan delay
- **Judul H1**: 
  - Animasi `textGlow` (3 detik) - Efek cahaya berkedip pada teks
  - Animasi `slideUp` (2 detik) - Efek naik-turun halus
- **Subtitle**: Animasi `textGlow` (3.5 detik) - Efek cahaya dengan delay
- **Background**: Animasi `shimmer` (3 detik) - Efek kilau bergerak dari kiri ke kanan
- **Block Gold**: Animasi `glow` (3 detik) - Efek cahaya emas yang berkedip

### 2. **Welcome Section**
- **Teks Welcome**: 
  - Animasi `slideInLeft` - Masuk dari kiri (awal)
  - Animasi `textGlow` (2.5 detik) - Efek cahaya berkedip
  - Animasi `slideUp` (2.5 detik) - Efek naik-turun halus
- **Staff Container**: Animasi `slideInRight` - Masuk dari kanan (awal)
- **Staff Name**: 
  - Animasi `textGlow` (2.8 detik) - Efek cahaya pada nama
  - Animasi `slideUp` (2.5 detik) - Efek naik-turun halus

### 3. **Gallery Section**
- **Gallery Items**: 
  - Animasi `fadeInUp` - Muncul dari bawah saat load
  - Delay bertahap untuk setiap item (0s, 0.1s, 0.2s, 0.3s, 0.4s, 0.5s)
- **Hover Effect**: 
  - Transform scale (1.02) + translateY (-5px)
  - Box shadow enhancement
- **Images/Videos**: Zoom in saat hover (scale 1.1)
- **Text Overlay**: 
  - Animasi `slideInUp` - Muncul dari bawah
  - Logo BPS: Animasi `pulse` (2 detik)

## Jenis Animasi

### Animasi Awal (Load) - Sekali Saja
- `fadeInUp` - Fade in dari bawah (gallery items)
- `slideInLeft` - Slide dari kiri (welcome text)
- `slideInRight` - Slide dari kanan (staff container)

### Animasi Berulang (Infinite) - Fokus pada Teks
- `textGlow` - Efek cahaya teks (2.5-3.5 detik) - **UTAMA untuk teks**
- `slideUp` - Naik-turun halus (2-2.5 detik) - **UTAMA untuk teks**
- `pulse` - Berkedip/scale (4 detik) - Logo dan elemen kecil
- `glow` - Efek cahaya (3 detik) - Block gold
- `shimmer` - Kilau bergerak (3 detik) - Header background

### Animasi Interaktif (Hover)
- Scale + Transform (subtle)
- Box shadow enhancement
- Image/Video zoom (1.1x)

## Karakteristik Animasi (Versi Optimized)

- **Fokus pada Teks**: Animasi paling terlihat pada elemen teks (judul, welcome, nama staff)
- **Smooth & Subtle**: Semua animasi menggunakan `ease-in-out` untuk transisi halus
- **Performance Optimized**: Menggunakan transform dan opacity untuk performa terbaik
- **Non-intrusive**: Animasi tidak mengganggu konten atau readability
- **Staggered**: Item gallery muncul secara bertahap untuk efek yang lebih menarik
- **Reduced Motion**: Mengurangi animasi berlebihan pada gallery items untuk tampilan lebih rapi

## Tips Customization

Untuk mengubah kecepatan animasi, edit nilai duration di CSS:
```css
animation: float 6s ease-in-out infinite;
           ^^^^^  ^^^ ^^^^^^^^^ ^^^^^^^^
           nama   durasi easing  repeat
```

Untuk menonaktifkan animasi tertentu, hapus atau comment baris `animation:` pada elemen yang diinginkan.
