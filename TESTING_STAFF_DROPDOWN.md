# Testing Checklist: Staff Manager Dropdown

## Tanggal Testing: [Isi tanggal saat testing]
## Tester: [Nama tester]

---

## 1. Form Tambah Petugas

### 1.1 Dropdown Nama Petugas (Add Form)
- [ ] Dropdown menampilkan placeholder "Pilih Nama Petugas"
- [ ] Dropdown menampilkan 20 nama petugas yang sudah ada
- [ ] Dropdown bisa dibuka dengan klik
- [ ] Nama bisa dipilih dari dropdown
- [ ] Border berubah hijau (#1f9e76) setelah memilih nama
- [ ] Tombol "+" di samping dropdown terlihat dan berfungsi

### 1.2 Tombol Tambah Nama Baru (Add Form)
- [ ] Klik tombol "+" membuka modal "Tambah Nama Baru"
- [ ] Modal memiliki input field untuk nama baru
- [ ] Input field auto-focus saat modal dibuka
- [ ] Placeholder text terlihat jelas

### 1.3 Modal Tambah Nama Baru
- [ ] Modal memiliki header "Tambah Nama Baru" dengan icon
- [ ] Input field berfungsi dengan baik
- [ ] Tombol "Batal" menutup modal tanpa menyimpan
- [ ] Tombol "Tambah ke Daftar" berfungsi

### 1.4 Validasi Tambah Nama
- [ ] Jika input kosong, muncul toast error "Nama tidak boleh kosong"
- [ ] Jika nama sudah ada, muncul toast error "Nama sudah ada dalam daftar"
- [ ] Jika nama valid, muncul toast success "Nama berhasil ditambahkan ke daftar"
- [ ] Nama baru otomatis terpilih di dropdown setelah ditambahkan
- [ ] Border dropdown berubah hijau setelah nama ditambahkan
- [ ] Modal otomatis tertutup setelah berhasil menambah

### 1.5 Enter Key Functionality
- [ ] Tekan Enter di input field = sama dengan klik "Tambah ke Daftar"
- [ ] Enter key berfungsi untuk menyimpan nama baru

---

## 2. Form Edit Petugas

### 2.1 Dropdown Nama Petugas (Edit Form)
- [ ] Dropdown menampilkan nama petugas yang sedang diedit
- [ ] Dropdown menampilkan semua 20 nama + nama baru yang ditambahkan
- [ ] Dropdown bisa dibuka dan nama bisa diubah
- [ ] Border berubah hijau saat dropdown memiliki nilai
- [ ] Tombol "+" di samping dropdown terlihat dan berfungsi

### 2.2 Tombol Tambah Nama Baru (Edit Form)
- [ ] Klik tombol "+" membuka modal "Tambah Nama Baru"
- [ ] Modal yang sama digunakan untuk add dan edit form
- [ ] Input field auto-focus saat modal dibuka

### 2.3 Tambah Nama dari Edit Form
- [ ] Nama baru ditambahkan ke dropdown edit
- [ ] Nama baru juga ditambahkan ke dropdown add form
- [ ] Nama baru otomatis terpilih di dropdown edit setelah ditambahkan
- [ ] Border dropdown edit berubah hijau
- [ ] Modal tertutup setelah berhasil

---

## 3. Sinkronisasi Dropdown

### 3.1 Konsistensi Data
- [ ] Nama yang ditambahkan dari add form muncul di edit form
- [ ] Nama yang ditambahkan dari edit form muncul di add form
- [ ] Kedua dropdown selalu memiliki daftar nama yang sama

---

## 4. Visual & UX

### 4.1 Styling
- [ ] Dropdown memiliki border 2px solid #e5e7eb (default)
- [ ] Dropdown memiliki border hijau #1f9e76 saat ada nilai
- [ ] Focus state menampilkan shadow hijau
- [ ] Tombol "+" memiliki border hijau dan hover effect
- [ ] Modal memiliki header gradient hijau

### 4.2 Responsiveness
- [ ] Form responsive di layar kecil
- [ ] Modal responsive di layar kecil
- [ ] Dropdown tidak overflow di layar kecil

### 4.3 Animations
- [ ] Modal fade in/out smooth
- [ ] Toast notifications muncul dengan smooth
- [ ] Border color transition smooth

---

## 5. Integration Testing

### 5.1 Full Flow - Add Staff
1. [ ] Buka halaman Master Profil
2. [ ] Klik dropdown nama petugas
3. [ ] Pilih nama dari list
4. [ ] Pilih posisi (Kiri/Kanan)
5. [ ] Upload foto
6. [ ] Klik "Tambah Petugas"
7. [ ] Verifikasi petugas muncul di daftar

### 5.2 Full Flow - Add New Name & Add Staff
1. [ ] Buka halaman Master Profil
2. [ ] Klik tombol "+" di samping dropdown
3. [ ] Ketik nama baru di modal
4. [ ] Klik "Tambah ke Daftar"
5. [ ] Verifikasi nama terpilih di dropdown
6. [ ] Pilih posisi
7. [ ] Upload foto
8. [ ] Klik "Tambah Petugas"
9. [ ] Verifikasi petugas muncul di daftar

### 5.3 Full Flow - Edit Staff
1. [ ] Klik tombol "Edit" pada salah satu petugas
2. [ ] Modal edit terbuka dengan data petugas
3. [ ] Ubah nama dari dropdown
4. [ ] Klik "Simpan Perubahan"
5. [ ] Verifikasi perubahan tersimpan

### 5.4 Full Flow - Add Name from Edit
1. [ ] Klik tombol "Edit" pada salah satu petugas
2. [ ] Klik tombol "+" di modal edit
3. [ ] Tambah nama baru
4. [ ] Verifikasi nama terpilih di dropdown edit
5. [ ] Simpan perubahan
6. [ ] Buka form add, verifikasi nama baru ada di dropdown

---

## 6. Error Handling

### 6.1 Network Errors
- [ ] Jika API gagal load staff, muncul toast error
- [ ] Jika API gagal add staff, muncul toast error
- [ ] Jika API gagal update staff, muncul toast error
- [ ] Jika API gagal delete staff, muncul toast error

### 6.2 Validation Errors
- [ ] Form tidak submit jika nama kosong
- [ ] Form tidak submit jika posisi kosong
- [ ] Form tidak submit jika foto kosong (add form)

---

## 7. Browser Compatibility

### 7.1 Chrome
- [ ] Semua fungsi bekerja di Chrome
- [ ] Visual sesuai design

### 7.2 Firefox
- [ ] Semua fungsi bekerja di Firefox
- [ ] Visual sesuai design

### 7.3 Edge
- [ ] Semua fungsi bekerja di Edge
- [ ] Visual sesuai design

### 7.4 Safari (jika tersedia)
- [ ] Semua fungsi bekerja di Safari
- [ ] Visual sesuai design

---

## Bugs Found

| No | Deskripsi Bug | Severity | Status |
|----|---------------|----------|--------|
| 1  |               |          |        |
| 2  |               |          |        |
| 3  |               |          |        |

---

## Notes & Observations

[Tulis catatan tambahan di sini]

---

## Summary

- **Total Tests**: 70+
- **Passed**: ___
- **Failed**: ___
- **Blocked**: ___
- **Overall Status**: [ ] PASS / [ ] FAIL

---

## Sign-off

**Tester**: ___________________  
**Date**: ___________________  
**Signature**: ___________________
