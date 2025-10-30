# Requirements Document

## Introduction

Sistem saat ini hanya mendukung link YouTube untuk video. User membutuhkan kemampuan untuk menambahkan link dari berbagai platform media sosial lainnya seperti TikTok, Instagram, Facebook, Twitter, dan platform lainnya. Fitur ini akan memperluas fleksibilitas sistem dalam menampilkan konten video dari berbagai sumber.

## Glossary

- **Media Input System**: Sistem untuk menambahkan media (gambar, video, audio) ke dalam aplikasi
- **Social Media Link**: URL dari platform media sosial yang mengarah ke konten video
- **Video Type**: Jenis video yang dapat berupa file upload atau link eksternal
- **Embed Support**: Kemampuan untuk menampilkan video dari platform eksternal di dalam aplikasi
- **Platform Detection**: Sistem untuk mendeteksi platform media sosial dari URL yang diinput

## Requirements

### Requirement 1

**User Story:** Sebagai admin, saya ingin dapat menambahkan link video dari berbagai platform media sosial (TikTok, Instagram, Facebook, Twitter, dll), sehingga saya tidak terbatas hanya pada YouTube.

#### Acceptance Criteria

1. WHEN user memilih tipe "Link Video" di form input media, THE Media Input System SHALL menampilkan field untuk memasukkan URL video
2. WHEN user memasukkan URL dari platform yang didukung, THE Media Input System SHALL menerima dan menyimpan URL tersebut
3. WHEN user memasukkan URL, THE Platform Detection SHALL mendeteksi platform asal (YouTube, TikTok, Instagram, Facebook, Twitter)
4. WHEN URL tidak valid atau platform tidak didukung, THE Media Input System SHALL menampilkan pesan error yang jelas
5. WHEN data disimpan, THE Media Input System SHALL menyimpan informasi platform dan URL ke database

### Requirement 2

**User Story:** Sebagai admin, saya ingin sistem dapat mendeteksi otomatis platform media sosial dari URL yang saya masukkan, sehingga saya tidak perlu memilih platform secara manual.

#### Acceptance Criteria

1. WHEN user memasukkan URL YouTube, THE Platform Detection SHALL mendeteksi sebagai "youtube"
2. WHEN user memasukkan URL TikTok, THE Platform Detection SHALL mendeteksi sebagai "tiktok"
3. WHEN user memasukkan URL Instagram, THE Platform Detection SHALL mendeteksi sebagai "instagram"
4. WHEN user memasukkan URL Facebook, THE Platform Detection SHALL mendeteksi sebagai "facebook"
5. WHEN user memasukkan URL Twitter/X, THE Platform Detection SHALL mendeteksi sebagai "twitter"

### Requirement 3

**User Story:** Sebagai admin, saya ingin melihat preview atau informasi platform saat memasukkan link, sehingga saya tahu link yang saya masukkan sudah benar.

#### Acceptance Criteria

1. WHEN user memasukkan URL yang valid, THE Media Input System SHALL menampilkan badge atau icon platform yang terdeteksi
2. WHEN platform terdeteksi, THE Media Input System SHALL menampilkan nama platform (YouTube, TikTok, Instagram, dll)
3. WHEN URL berubah, THE Media Input System SHALL update deteksi platform secara real-time
4. WHEN URL tidak valid, THE Media Input System SHALL menampilkan peringatan
5. WHEN form disubmit, THE Media Input System SHALL memvalidasi URL sekali lagi sebelum menyimpan

### Requirement 4

**User Story:** Sebagai developer, saya ingin database dapat menyimpan informasi platform dan URL dengan struktur yang jelas, sehingga mudah untuk menampilkan dan mengelola konten dari berbagai platform.

#### Acceptance Criteria

1. WHEN media dengan link eksternal disimpan, THE Database SHALL menyimpan URL di field `file_path`
2. WHEN media dengan link eksternal disimpan, THE Database SHALL menyimpan platform di field `video_platform` (youtube, tiktok, instagram, facebook, twitter)
3. WHEN media dengan link eksternal disimpan, THE Database SHALL menyimpan type sebagai "Video"
4. WHEN media ditampilkan, THE System SHALL dapat membedakan antara video upload dan video link berdasarkan field `video_platform`
5. WHEN video link ditampilkan, THE System SHALL menggunakan embed URL yang sesuai dengan platform

### Requirement 5

**User Story:** Sebagai user yang melihat landing page, saya ingin video dari berbagai platform dapat ditampilkan dengan baik, sehingga saya dapat menikmati konten dari berbagai sumber.

#### Acceptance Criteria

1. WHEN video YouTube ditampilkan, THE Landing Page SHALL menggunakan YouTube embed player
2. WHEN video TikTok ditampilkan, THE Landing Page SHALL menggunakan TikTok embed player
3. WHEN video Instagram ditampilkan, THE Landing Page SHALL menggunakan Instagram embed player
4. WHEN video Facebook ditampilkan, THE Landing Page SHALL menggunakan Facebook embed player
5. WHEN video Twitter ditampilkan, THE Landing Page SHALL menggunakan Twitter embed player
