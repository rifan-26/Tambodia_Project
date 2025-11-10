# Testing Guide - Template Builder Modal

## Panduan Testing untuk Template Builder Modal

Dokumen ini berisi langkah-langkah testing untuk memverifikasi bahwa Template Builder Modal berfungsi dengan baik.

---

## Prerequisites

1. ✅ Server Laravel sudah running
2. ✅ Database sudah di-migrate
3. ✅ User sudah login
4. ✅ Browser modern (Chrome, Firefox, Safari, Edge)

---

## Test Scenarios

### 1. Test Create Template Flow

#### Steps:
1. Buka browser dan navigasi ke `/layout`
2. Klik card "+ Tambah Template"
3. Verifikasi modal muncul dari kanan dengan animasi smooth
4. Verifikasi builder interface muncul (grid selector, canvas, properties)
5. Pilih salah satu grid layout (misalnya 2x2)
6. Verifikasi canvas berubah sesuai grid yang dipilih
7. Klik tombol "Teks" di toolbar
8. Klik salah satu area di canvas
9. Verifikasi elemen teks muncul di area tersebut
10. Edit nama template di header (misalnya "Template Test 1")
11. Klik tombol "Simpan Template"
12. Verifikasi loading indicator muncul di tombol
13. Verifikasi success message muncul (SweetAlert2)
14. Verifikasi modal tertutup dengan animasi
15. Verifikasi template baru muncul di grid

#### Expected Results:
- ✅ Modal opens smoothly
- ✅ Builder loads within 500ms
- ✅ Grid selection works
- ✅ Element addition works
- ✅ Save succeeds
- ✅ Modal closes
- ✅ Template appears in list

---

### 2. Test Edit Template Flow

#### Steps:
1. Buka browser dan navigasi ke `/layout`
2. Klik tombol "Edit" pada salah satu template card
3. Verifikasi modal muncul dengan loading spinner
4. Verifikasi template data ter-load (grid dan elements)
5. Verifikasi nama template muncul di header
6. Ubah salah satu element (misalnya ubah teks)
7. Klik tombol "Simpan Template"
8. Verifikasi success message muncul
9. Verifikasi modal tertutup
10. Verifikasi perubahan ter-reflect di template list

#### Expected Results:
- ✅ Modal opens with loading state
- ✅ Template data loads within 1 second
- ✅ Grid and elements populate correctly
- ✅ Modifications work
- ✅ Save succeeds
- ✅ Changes reflected in list

---

### 3. Test Modal Close Behaviors

#### Test 3.1: Close via "Kembali" Button
1. Buka modal (create atau edit)
2. Klik tombol "Kembali" di header
3. Verifikasi modal tertutup dengan animasi

#### Test 3.2: Close via ESC Key
1. Buka modal
2. Tekan tombol ESC di keyboard
3. Verifikasi modal tertutup

#### Test 3.3: Close via Overlay Click
1. Buka modal
2. Klik area gelap di luar modal (overlay)
3. Verifikasi modal tertutup

#### Test 3.4: Close with Unsaved Changes
1. Buka modal (create atau edit)
2. Buat perubahan (pilih grid atau tambah element)
3. Klik "Kembali" atau ESC atau overlay
4. Verifikasi confirmation dialog muncul
5. Pilih "Buang Perubahan"
6. Verifikasi modal tertutup
7. Ulangi steps 1-4
8. Pilih "Simpan"
9. Verifikasi template tersimpan dan modal tertutup
10. Ulangi steps 1-4
11. Pilih "Batal"
12. Verifikasi modal tetap terbuka

#### Expected Results:
- ✅ All close methods work
- ✅ Unsaved changes warning appears
- ✅ User can save, discard, or cancel

---

### 4. Test Responsive Design

#### Test 4.1: Desktop (>1024px)
1. Buka browser dengan lebar > 1024px
2. Buka modal
3. Verifikasi:
   - Modal width = calc(100% - 280px)
   - Sidebar tetap visible
   - Three-panel layout (grid selector, canvas, properties)
   - Semua panel terlihat dengan baik

#### Test 4.2: Tablet (768px - 1024px)
1. Resize browser ke lebar 768-1024px (atau gunakan device emulator)
2. Buka modal
3. Verifikasi:
   - Modal width = 100%
   - Panel widths adjusted
   - Semua fitur masih accessible
   - Layout tetap horizontal

#### Test 4.3: Mobile (<768px)
1. Resize browser ke lebar < 768px (atau gunakan device emulator)
2. Buka modal
3. Verifikasi:
   - Modal full-screen
   - Panels stacked vertically
   - Toolbar wraps if needed
   - Touch-friendly controls
   - Semua fitur masih accessible

#### Test 4.4: Screen Resize
1. Buka modal di desktop
2. Resize browser window ke tablet size
3. Verifikasi layout adjust smoothly
4. Resize ke mobile size
5. Verifikasi layout adjust smoothly
6. Resize kembali ke desktop
7. Verifikasi layout kembali normal

#### Expected Results:
- ✅ Desktop layout works
- ✅ Tablet layout works
- ✅ Mobile layout works
- ✅ Smooth transitions on resize

---

### 5. Test Builder Tools

#### Test 5.1: Grid Selection
1. Buka modal (create mode)
2. Klik setiap grid option (1-col, 2-col, 3-col, 2x2, 3x3)
3. Verifikasi canvas berubah sesuai grid yang dipilih
4. Verifikasi active state pada grid option

#### Test 5.2: Add Text Element
1. Buka modal
2. Pilih grid layout
3. Klik tombol "Teks" di toolbar
4. Klik area di canvas
5. Verifikasi text element muncul
6. Klik element untuk select
7. Verifikasi properties panel muncul
8. Edit properties (font size, color, etc.)
9. Verifikasi perubahan ter-apply

#### Test 5.3: Add Color Element
1. Klik tombol "Warna" di toolbar
2. Klik area di canvas
3. Verifikasi color block muncul
4. Klik element untuk select
5. Edit color di properties panel
6. Verifikasi perubahan ter-apply

#### Test 5.4: Add Image Element
1. Klik tombol "Gambar" di toolbar
2. Klik area di canvas
3. Verifikasi file picker muncul
4. Pilih image file
5. Verifikasi image ter-upload dan muncul di canvas

#### Test 5.5: Undo/Redo
1. Buat beberapa perubahan (add elements, change grid)
2. Klik tombol "Undo"
3. Verifikasi perubahan terakhir di-undo
4. Klik tombol "Redo"
5. Verifikasi perubahan di-redo

#### Test 5.6: Zoom Control
1. Pilih zoom level 50%
2. Verifikasi canvas zoom out
3. Pilih zoom level 150%
4. Verifikasi canvas zoom in
5. Kembali ke 100%

#### Expected Results:
- ✅ All grid options work
- ✅ Text elements work
- ✅ Color elements work
- ✅ Image upload works
- ✅ Undo/redo works
- ✅ Zoom works

---

### 6. Test Error Handling

#### Test 6.1: Save Without Name
1. Buka modal (create mode)
2. Pilih grid dan tambah elements
3. Kosongkan nama template
4. Klik "Simpan Template"
5. Verifikasi error message muncul
6. Verifikasi modal tetap terbuka

#### Test 6.2: Save Without Grid
1. Buka modal (create mode)
2. Jangan pilih grid
3. Isi nama template
4. Klik "Simpan Template"
5. Verifikasi error message muncul

#### Test 6.3: Network Error (Simulate)
1. Buka browser DevTools
2. Go to Network tab
3. Set throttling to "Offline"
4. Buka modal dan coba save
5. Verifikasi error message muncul
6. Set throttling back to "Online"
7. Klik retry atau save lagi
8. Verifikasi berhasil

#### Expected Results:
- ✅ Validation errors shown
- ✅ Network errors handled
- ✅ User can retry
- ✅ Modal doesn't close on error

---

### 7. Test Browser Compatibility

#### Test on Each Browser:
1. Chrome (latest)
2. Firefox (latest)
3. Safari (latest)
4. Edge (latest)

#### For Each Browser:
1. Test create flow
2. Test edit flow
3. Test close behaviors
4. Test responsive design
5. Test builder tools

#### Expected Results:
- ✅ Works on all browsers
- ✅ No console errors
- ✅ Consistent behavior

---

### 8. Test Performance

#### Test 8.1: Modal Open Speed
1. Buka modal (create mode)
2. Measure time from click to fully loaded
3. Expected: < 500ms

#### Test 8.2: Template Load Speed
1. Buka modal (edit mode)
2. Measure time from click to data loaded
3. Expected: < 1 second

#### Test 8.3: Save Speed
1. Save template
2. Measure time from click to success message
3. Expected: < 2 seconds

#### Test 8.4: Animation Smoothness
1. Open/close modal multiple times
2. Verify smooth 60fps animations
3. No jank or stuttering

#### Expected Results:
- ✅ Fast load times
- ✅ Smooth animations
- ✅ No performance issues

---

## Bug Report Template

Jika menemukan bug, gunakan template ini:

```
**Bug Title**: [Short description]

**Steps to Reproduce**:
1. Step 1
2. Step 2
3. Step 3

**Expected Behavior**:
[What should happen]

**Actual Behavior**:
[What actually happens]

**Environment**:
- Browser: [Chrome/Firefox/Safari/Edge]
- Version: [Browser version]
- Device: [Desktop/Tablet/Mobile]
- Screen Size: [Width x Height]

**Screenshots**:
[Attach screenshots if applicable]

**Console Errors**:
[Copy any console errors]
```

---

## Success Criteria

### MVP Must Pass:
- ✅ Create template flow works end-to-end
- ✅ Edit template flow works end-to-end
- ✅ Modal opens and closes properly
- ✅ Save functionality works
- ✅ Template list refreshes after save
- ✅ Responsive on desktop, tablet, mobile
- ✅ No critical errors in console

### Nice to Have:
- ✅ All builder tools work perfectly
- ✅ Smooth animations on all devices
- ✅ Works on all browsers
- ✅ Fast performance
- ✅ Good error messages

---

## Testing Checklist

### Core Functionality
- [ ] Create template flow
- [ ] Edit template flow
- [ ] Save template (create mode)
- [ ] Save template (edit mode)
- [ ] Template list refresh

### Modal Behavior
- [ ] Open modal (create)
- [ ] Open modal (edit)
- [ ] Close via button
- [ ] Close via ESC
- [ ] Close via overlay
- [ ] Unsaved changes warning

### Responsive Design
- [ ] Desktop layout
- [ ] Tablet layout
- [ ] Mobile layout
- [ ] Screen resize

### Builder Tools
- [ ] Grid selection
- [ ] Add text
- [ ] Add color
- [ ] Add image
- [ ] Undo/redo
- [ ] Zoom control

### Error Handling
- [ ] Validation errors
- [ ] Network errors
- [ ] Retry functionality

### Browser Compatibility
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

### Performance
- [ ] Fast load times
- [ ] Smooth animations
- [ ] No console errors

---

## Notes

- Test dengan data real (bukan dummy data)
- Test dengan koneksi internet yang berbeda (fast, slow, offline)
- Test dengan berbagai ukuran screen
- Test dengan berbagai browser
- Catat semua bug yang ditemukan
- Prioritaskan bug berdasarkan severity

---

**Happy Testing! 🧪**
