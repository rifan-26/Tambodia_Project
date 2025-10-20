# Dokumen Persyaratan

## Pendahuluan

Dokumen ini menguraikan persyaratan untuk mengimplementasikan sistem manajemen petugas di layout manager yang memungkinkan admin untuk mengelola foto dan nama petugas yang ditampilkan di halaman landing. Sistem ini akan memiliki dua halaman tab: Gallery untuk konten visual dan Petugas untuk manajemen data petugas.

## Glosarium

- **Sistem_Layout_Manager**: Aplikasi web untuk mengelola konten halaman landing
- **Halaman_Gallery**: Tab pertama yang menampilkan dan mengelola konten galeri visual
- **Halaman_Petugas**: Tab kedua yang menampilkan dan mengelola data petugas
- **Data_Petugas**: Informasi petugas yang terdiri dari foto dan nama
- **Foto_Petugas**: Gambar/foto dari petugas yang akan ditampilkan
- **Nama_Petugas**: Identitas nama petugas
- **Sistem_Tab**: Navigasi antara halaman Gallery dan Petugas
- **Form_Input**: Formulir untuk memasukkan data petugas baru

## Persyaratan

### Persyaratan 1

**User Story:** Sebagai admin, saya ingin melihat sistem tab di layout manager dengan dua halaman (Gallery dan Petugas), sehingga saya dapat dengan mudah beralih antara manajemen galeri dan manajemen petugas.

#### Kriteria Penerimaan

1. Sistem_Layout_Manager HARUS menampilkan Sistem_Tab dengan dua opsi: "Gallery" dan "Petugas"
2. KETIKA admin mengklik tab "Gallery", Sistem_Layout_Manager HARUS menampilkan Halaman_Gallery
3. KETIKA admin mengklik tab "Petugas", Sistem_Layout_Manager HARUS menampilkan Halaman_Petugas
4. Sistem_Layout_Manager HARUS menandai tab yang aktif dengan indikator visual yang jelas
5. Sistem_Layout_Manager HARUS mempertahankan state tab yang dipilih saat halaman di-refresh

### Persyaratan 2

**User Story:** Sebagai admin, saya ingin menambahkan data petugas baru dengan foto dan nama, sehingga informasi petugas dapat ditampilkan di halaman landing.

#### Kriteria Penerimaan

1. Halaman_Petugas HARUS menampilkan Form_Input untuk menambah data petugas baru
2. Form_Input HARUS menyediakan field untuk upload Foto_Petugas
3. Form_Input HARUS menyediakan field text input untuk Nama_Petugas
4. KETIKA admin mengisi form dan menekan tombol simpan, Sistem_Layout_Manager HARUS menyimpan Data_Petugas ke database
5. Sistem_Layout_Manager HARUS menampilkan pesan konfirmasi setelah Data_Petugas berhasil disimpan

### Persyaratan 3

**User Story:** Sebagai admin, saya ingin melihat daftar semua petugas yang sudah diinput, sehingga saya dapat mengelola data petugas yang ada.

#### Kriteria Penerimaan

1. Halaman_Petugas HARUS menampilkan daftar semua Data_Petugas yang tersimpan
2. Sistem_Layout_Manager HARUS menampilkan Foto_Petugas dan Nama_Petugas untuk setiap entri
3. Sistem_Layout_Manager HARUS menampilkan Data_Petugas dalam format yang mudah dibaca
4. Halaman_Petugas HARUS menampilkan minimal 10 entri Data_Petugas per halaman
5. KETIKA tidak ada Data_Petugas, Sistem_Layout_Manager HARUS menampilkan pesan "Belum ada data petugas"

### Persyaratan 4

**User Story:** Sebagai admin, saya ingin mengedit data petugas yang sudah ada, sehingga saya dapat memperbarui informasi petugas jika terjadi perubahan.

#### Kriteria Penerimaan

1. Halaman_Petugas HARUS menampilkan tombol "Edit" untuk setiap Data_Petugas
2. KETIKA admin mengklik tombol "Edit", Sistem_Layout_Manager HARUS menampilkan Form_Input dengan data yang sudah ada
3. Sistem_Layout_Manager HARUS memungkinkan admin mengubah Foto_Petugas
4. Sistem_Layout_Manager HARUS memungkinkan admin mengubah Nama_Petugas
5. KETIKA admin menyimpan perubahan, Sistem_Layout_Manager HARUS memperbarui Data_Petugas di database

### Persyaratan 5

**User Story:** Sebagai admin, saya ingin menghapus data petugas yang tidak diperlukan lagi, sehingga daftar petugas tetap relevan dan up-to-date.

#### Kriteria Penerimaan

1. Halaman_Petugas HARUS menampilkan tombol "Hapus" untuk setiap Data_Petugas
2. KETIKA admin mengklik tombol "Hapus", Sistem_Layout_Manager HARUS menampilkan dialog konfirmasi
3. KETIKA admin mengkonfirmasi penghapusan, Sistem_Layout_Manager HARUS menghapus Data_Petugas dari database
4. Sistem_Layout_Manager HARUS menghapus Foto_Petugas dari storage server
5. Sistem_Layout_Manager HARUS menampilkan pesan konfirmasi setelah penghapusan berhasil

### Persyaratan 6

**User Story:** Sebagai admin, saya ingin foto petugas yang diupload divalidasi, sehingga hanya file gambar yang valid yang dapat disimpan.

#### Kriteria Penerimaan

1. Sistem_Layout_Manager HARUS menerima hanya file dengan format JPG, JPEG, PNG, dan GIF
2. Sistem_Layout_Manager HARUS membatasi ukuran Foto_Petugas maksimal 5MB
3. KETIKA admin mengupload file yang tidak valid, Sistem_Layout_Manager HARUS menampilkan pesan error yang jelas
4. Sistem_Layout_Manager HARUS menampilkan preview Foto_Petugas sebelum disimpan
5. Sistem_Layout_Manager HARUS mengoptimalkan ukuran Foto_Petugas sebelum menyimpan ke storage

### Persyaratan 7

**User Story:** Sebagai pengunjung website, saya ingin melihat foto dan nama petugas di halaman landing, sehingga saya dapat mengetahui siapa saja petugas yang bertugas.

#### Kriteria Penerimaan

1. Halaman landing HARUS menampilkan semua Data_Petugas yang aktif
2. Halaman landing HARUS menampilkan Foto_Petugas dengan ukuran yang konsisten
3. Halaman landing HARUS menampilkan Nama_Petugas di bawah atau di samping Foto_Petugas
4. Halaman landing HARUS menampilkan Data_Petugas dalam tata letak yang responsif
5. Halaman landing HARUS memuat dan menampilkan Data_Petugas dalam waktu 2 detik
