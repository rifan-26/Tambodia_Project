# Requirements Document

## Introduction

Sistem penjadwalan audio saat ini tidak berfungsi dengan baik. Audio yang sudah dijadwalkan tidak diputar pada waktu yang ditentukan. Masalah ini terjadi karena kondisi query yang terlalu ketat dan logika pengecekan waktu yang tidak tepat. Fitur ini perlu diperbaiki agar audio dapat diputar sesuai jadwal yang telah ditentukan oleh user.

## Glossary

- **Audio System**: Sistem yang mengelola pemutaran audio terjadwal di dashboard admin
- **Schedule**: Jadwal yang menentukan kapan media (audio) harus ditampilkan/diputar
- **Active Schedule**: Jadwal yang sedang aktif berdasarkan tanggal, hari, dan waktu saat ini
- **Time Window**: Rentang waktu dimana audio schedule dianggap aktif
- **Tracking System**: Sistem yang mencatat audio mana yang sudah diputar untuk mencegah pemutaran berulang

## Requirements

### Requirement 1

**User Story:** Sebagai admin, saya ingin audio yang sudah dijadwalkan dapat diputar otomatis pada waktu yang ditentukan, sehingga saya tidak perlu memutar audio secara manual.

#### Acceptance Criteria

1. WHEN waktu saat ini sama dengan atau melewati waktu jadwal audio, THE Audio System SHALL memutar audio tersebut secara otomatis
2. WHEN audio dijadwalkan tanpa waktu spesifik (time = null), THE Audio System SHALL memutar audio tersebut sepanjang hari pada tanggal yang ditentukan
3. WHEN audio dijadwalkan dengan hari tertentu (day_of_week), THE Audio System SHALL hanya memutar audio pada hari yang sesuai
4. WHEN audio dijadwalkan tanpa hari tertentu (day_of_week = null), THE Audio System SHALL memutar audio setiap hari dalam rentang tanggal yang ditentukan
5. WHEN tanggal saat ini berada dalam rentang start_date dan end_date, THE Audio System SHALL menganggap jadwal tersebut aktif

### Requirement 2

**User Story:** Sebagai admin, saya ingin audio hanya diputar sekali per hari untuk setiap jadwal, sehingga audio tidak diputar berulang-ulang sepanjang hari.

#### Acceptance Criteria

1. WHEN audio sudah diputar untuk jadwal tertentu pada hari ini, THE Tracking System SHALL mencatat jadwal tersebut sebagai "played"
2. WHEN sistem memeriksa jadwal audio, THE Tracking System SHALL mengecualikan jadwal yang sudah ditandai "played" pada hari yang sama
3. WHEN hari berganti (00:00), THE Tracking System SHALL mereset semua tracking sehingga audio dapat diputar lagi
4. WHEN user membuka halaman dashboard, THE Tracking System SHALL memuat data tracking dari localStorage
5. WHEN audio selesai diputar, THE Tracking System SHALL menyimpan status "played" ke localStorage

### Requirement 3

**User Story:** Sebagai admin, saya ingin melihat notifikasi popup ketika audio dijadwalkan akan diputar, sehingga saya tahu audio sedang berjalan dan dapat mengontrol volume atau menghentikannya.

#### Acceptance Criteria

1. WHEN audio mulai diputar, THE Audio System SHALL menampilkan popup notifikasi dengan informasi nama audio
2. WHEN popup ditampilkan, THE Audio System SHALL menyediakan kontrol volume yang dapat diatur oleh user
3. WHEN popup ditampilkan, THE Audio System SHALL menyediakan tombol untuk menghentikan audio
4. WHEN user mengubah volume, THE Audio System SHALL menyimpan preferensi volume ke localStorage
5. WHEN audio selesai diputar, THE Audio System SHALL menutup popup secara otomatis

### Requirement 4

**User Story:** Sebagai admin, saya ingin sistem dapat menangani kasus dimana browser memblokir autoplay, sehingga saya masih bisa memutar audio dengan klik manual.

#### Acceptance Criteria

1. WHEN browser memblokir autoplay audio, THE Audio System SHALL menampilkan popup dengan tombol "Play"
2. WHEN user mengklik tombol "Play", THE Audio System SHALL memutar audio tersebut
3. WHEN autoplay berhasil, THE Audio System SHALL langsung memutar audio tanpa interaksi user
4. WHEN audio gagal dimuat, THE Audio System SHALL menampilkan pesan error yang jelas
5. WHEN file audio tidak ditemukan, THE Audio System SHALL memberikan notifikasi kepada user

### Requirement 5

**User Story:** Sebagai developer, saya ingin API endpoint audio schedules mengembalikan data yang akurat, sehingga frontend dapat menampilkan dan memutar audio dengan benar.

#### Acceptance Criteria

1. WHEN API endpoint `/api/dashboard/audio-schedules` dipanggil, THE API SHALL mengembalikan semua jadwal audio yang aktif pada waktu saat ini
2. WHEN menentukan jadwal aktif, THE API SHALL menggunakan logika: waktu saat ini >= waktu jadwal (bukan sama dengan)
3. WHEN jadwal tidak memiliki end_date, THE API SHALL menganggap jadwal tersebut aktif tanpa batas waktu akhir
4. WHEN jadwal tidak memiliki time, THE API SHALL menganggap jadwal tersebut aktif sepanjang hari
5. WHEN API mengembalikan data, THE API SHALL menyertakan informasi lengkap media (id, name, file_path, type)
