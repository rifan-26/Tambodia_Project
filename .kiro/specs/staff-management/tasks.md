# Rencana Implementasi

- [x] 1. Verifikasi dan setup database



  - Verifikasi tabel `staff` sudah ada dengan struktur yang benar
  - Verifikasi Staff model sudah ada dan lengkap
  - Pastikan storage link sudah di-setup untuk public access
  - _Persyaratan: 2.4, 3.2, 6.5_



- [x] 2. Setup routing untuk API staff management

  - [x] 2.1 Tambahkan route GET untuk mengambil semua data staff

    - Tambahkan route `GET /api/staff` di routes/web.php atau routes/api.php
    - Route harus mengarah ke method `getStaff` di LayoutController_clean
    - _Persyaratan: 3.1, 3.2_


  - [x] 2.2 Tambahkan route POST untuk menambah staff baru


    - Tambahkan route `POST /api/staff` untuk create staff
    - Route harus mengarah ke method `storeStaff` di LayoutController_clean
    - _Persyaratan: 2.1, 2.2, 2.3, 2.4_



  - [x] 2.3 Tambahkan route PUT untuk update staff
    - Tambahkan route `PUT /api/staff/{id}` untuk update staff
    - Route harus mengarah ke method `updateStaff` di LayoutController_clean
    - _Persyaratan: 4.1, 4.2, 4.3, 4.4, 4.5_





  - [x] 2.4 Tambahkan route DELETE untuk hapus staff
    - Tambahkan route `DELETE /api/staff/{id}` untuk delete staff





    - Route harus mengarah ke method `deleteStaff` di LayoutController_clean
    - _Persyaratan: 5.1, 5.2, 5.3, 5.4, 5.5_

- [ ] 3. Implementasi tab navigation system di layout manager
  - [x] 3.1 Modifikasi view layout-manager untuk menambahkan tab navigation

    - Tambahkan HTML structure untuk tab navigation (Gallery dan Petugas)
    - Buat container untuk konten Gallery dan konten Petugas

    - Tambahkan styling untuk tab active/inactive
    - _Persyaratan: 1.1, 1.2, 1.3, 1.4_

  - [x] 3.2 Implementasi JavaScript untuk tab switching
    - Buat fungsi untuk handle click event pada tab

    - Implementasi show/hide konten berdasarkan tab yang dipilih
    - Simpan state tab aktif di localStorage
    - Restore state tab saat halaman di-load
    - _Persyaratan: 1.2, 1.3, 1.5_

- [x] 4. Buat UI untuk staff management di tab Petugas

  - [x] 4.1 Buat form untuk menambah staff baru
    - Tambahkan form dengan field: nama, foto, posisi
    - Implementasi file input dengan preview image
    - Tambahkan tombol submit "Tambah Petugas"
    - _Persyaratan: 2.1, 2.2, 2.3_


  - [x] 4.2 Implementasi staff list display
    - Buat container untuk menampilkan daftar staff
    - Design card/list item untuk setiap staff (foto, nama, posisi)
    - Tambahkan tombol Edit dan Hapus untuk setiap staff

    - Implementasi empty state "Belum ada data petugas"
    - _Persyaratan: 3.1, 3.2, 3.3, 3.4, 3.5_

  - [x] 4.3 Buat modal untuk edit staff
    - Buat modal dengan form edit (nama, foto, posisi)

    - Pre-fill form dengan data staff yang akan diedit
    - Implementasi preview foto existing dan foto baru
    - _Persyaratan: 4.1, 4.2, 4.3, 4.4_

  - [ ] 4.4 Buat modal konfirmasi delete
    - Buat modal konfirmasi dengan pesan warning
    - Tambahkan tombol Batal dan Hapus

    - _Persyaratan: 5.1, 5.2_

- [ ] 5. Implementasi JavaScript untuk operasi CRUD staff
  - [x] 5.1 Implementasi fungsi untuk fetch dan display staff list
    - Buat fungsi AJAX GET untuk mengambil data staff dari API
    - Render data staff ke dalam list/card

    - Handle loading state dan error state
    - _Persyaratan: 3.1, 3.2, 3.3_

  - [x] 5.2 Implementasi fungsi untuk add staff
    - Buat fungsi untuk handle form submit add staff
    - Implementasi validasi client-side (nama required, foto required, format file)

    - Kirim data ke API dengan FormData (untuk file upload)
    - Handle response sukses (refresh list, show message, reset form)
    - Handle response error (show error message)
    - _Persyaratan: 2.1, 2.2, 2.3, 2.4, 2.5, 6.1, 6.2, 6.3, 6.4_

  - [x] 5.3 Implementasi fungsi untuk edit staff



    - Buat fungsi untuk populate modal edit dengan data staff
    - Handle form submit edit staff
    - Kirim data ke API dengan method PUT

    - Handle response sukses dan error
    - _Persyaratan: 4.1, 4.2, 4.3, 4.4, 4.5_

  - [x] 5.4 Implementasi fungsi untuk delete staff
    - Buat fungsi untuk show modal konfirmasi delete
    - Handle konfirmasi delete dan kirim request ke API

    - Handle response sukses (refresh list, show message)
    - Handle response error
    - _Persyaratan: 5.1, 5.2, 5.3, 5.4, 5.5_

  - [x] 5.5 Implementasi image preview functionality



    - Buat fungsi untuk preview foto sebelum upload (add dan edit)
    - Validasi file type dan size di client-side
    - Show error message jika file tidak valid
    - _Persyaratan: 6.1, 6.2, 6.3, 6.4_


- [ ] 6. Integrasi staff display di landing page
  - [ ] 6.1 Tambahkan section untuk display staff di landing page
    - Buat HTML structure untuk staff display section
    - Design layout untuk menampilkan foto dan nama staff
    - Implementasi responsive design (mobile, tablet, desktop)


    - _Persyaratan: 7.1, 7.2, 7.3, 7.4_

  - [x] 6.2 Implementasi fetch dan render staff data di landing page

    - Buat fungsi untuk fetch data staff dari API
    - Render foto dan nama staff ke dalam layout
    - Filter hanya staff yang aktif (is_active = true)
    - Sort berdasarkan posisi
    - _Persyaratan: 7.1, 7.2, 7.3, 7.5_

  - [x] 6.3 Implementasi lazy loading untuk foto staff

    - Tambahkan lazy loading attribute pada image tags
    - Implementasi placeholder saat foto loading
    - _Persyaratan: 7.5_

- [ ] 7. Testing dan optimization
  - [x] 7.1 Buat feature test untuk API endpoints


    - Test GET /api/staff
    - Test POST /api/staff dengan valid data
    - Test POST /api/staff dengan invalid data (validasi)
    - Test PUT /api/staff/{id}
    - Test DELETE /api/staff/{id}
    - _Persyaratan: 2.1, 2.2, 2.3, 2.4, 2.5, 4.1, 4.2, 4.3, 4.4, 4.5, 5.1, 5.2, 5.3, 5.4, 5.5_

  - [ ] 7.2 Test file upload functionality
    - Test upload dengan berbagai format file (jpg, png, gif)
    - Test upload dengan file size > 5MB (harus error)
    - Test upload dengan file type invalid (harus error)
    - _Persyaratan: 6.1, 6.2, 6.3_

  - [ ] 7.3 Implementasi image optimization
    - Resize foto ke ukuran maksimal 800x800px saat upload
    - Compress foto dengan quality 80%
    - _Persyaratan: 6.5_

  - [ ] 7.4 Test UI functionality
    - Test tab switching (Gallery <-> Petugas)
    - Test form validation feedback
    - Test modal interactions (open, close, submit)
    - Test image preview
    - Test responsive design di berbagai device
    - _Persyaratan: 1.1, 1.2, 1.3, 1.4, 1.5, 2.1, 2.2, 2.3, 4.1, 4.2, 5.1, 5.2_

  - [ ] 7.5 Test landing page integration
    - Test staff data display di landing page
    - Test responsive layout
    - Test lazy loading images
    - Test performance (load time < 2 detik)
    - _Persyaratan: 7.1, 7.2, 7.3, 7.4, 7.5_

  - [ ] 7.6 Cross-browser testing dan bug fixes
    - Test di Chrome, Firefox, Safari, Edge
    - Fix compatibility issues jika ada
    - Test di mobile browsers
    - _Persyaratan: 1.1, 1.2, 1.3, 7.4_
