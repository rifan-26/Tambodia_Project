# Global SweetAlert2 - Usage Guide

**Date**: 2025-10-29  
**Component**: `resources/views/components/sweetalert2.blade.php`  
**Status**: ✅ AVAILABLE GLOBALLY

---

## Overview

SweetAlert2 sekarang tersedia di **semua halaman** melalui global component. Anda bisa menggunakan alert modern di mana saja tanpa perlu setup tambahan.

---

## Pages with SweetAlert2

✅ **Already Included**:
- Dashboard (`Dashboard.blade.php`)
- Input Media (`input.blade.php`)
- Jadwal (`jadwal.blade.php`)
- Layout Manager (`layout-manager.blade.php`)
- Staff Manager (`staff-manager.blade.php`)
- Super Admin (`superadmin.blade.php`)
- Super Akun (`superakun.blade.php`)

---

## Quick Start

### 1. Include Component (Already Done!)

```blade
@include('components.sweetalert2')
```

### 2. Use Helper Functions

```javascript
// Success alert
swalSuccess('Berhasil!', 'Data telah disimpan');

// Error alert
swalError('Gagal!', 'Terjadi kesalahan');

// Confirm dialog
const result = await swalConfirm('Yakin?', 'Data akan dihapus');
if (result.isConfirmed) {
  // Do something
}

// Delete confirmation
const result = await swalConfirmDelete('Nama Item');
if (result.isConfirmed) {
  // Delete item
}

// Toast notification
swalToast('Data berhasil disimpan', 'success');
```

---

## Helper Functions

### 1. Success Alert
```javascript
swalSuccess(title, text = '', timer = 2000)
```

**Example**:
```javascript
// Auto-close after 2 seconds
swalSuccess('Berhasil!', 'Data telah disimpan');

// No auto-close
swalSuccess('Berhasil!', 'Data telah disimpan', 0);
```

### 2. Error Alert
```javascript
swalError(title, text = '')
```

**Example**:
```javascript
swalError('Gagal!', 'Terjadi kesalahan saat menyimpan data');
```

### 3. Warning Alert
```javascript
swalWarning(title, text = '')
```

**Example**:
```javascript
swalWarning('Peringatan!', 'Data tidak lengkap');
```

### 4. Info Alert
```javascript
swalInfo(title, text = '')
```

**Example**:
```javascript
swalInfo('Informasi', 'Fitur ini masih dalam pengembangan');
```

### 5. Confirm Dialog
```javascript
swalConfirm(title, text = '', confirmText = 'Ya', cancelText = 'Batal')
```

**Example**:
```javascript
const result = await swalConfirm(
  'Simpan Perubahan?',
  'Data akan diupdate',
  'Ya, Simpan',
  'Batal'
);

if (result.isConfirmed) {
  // User clicked "Ya, Simpan"
  await saveData();
}
```

### 6. Delete Confirmation
```javascript
swalConfirmDelete(itemName = '')
```

**Example**:
```javascript
const result = await swalConfirmDelete('Petugas Ahmad');

if (result.isConfirmed) {
  // User confirmed deletion
  await deleteItem();
  swalSuccess('Terhapus!', 'Data berhasil dihapus');
}
```

### 7. Toast Notification
```javascript
swalToast(message, icon = 'success', position = 'top-end')
```

**Example**:
```javascript
// Success toast
swalToast('Data berhasil disimpan', 'success');

// Error toast
swalToast('Gagal menyimpan data', 'error');

// Info toast
swalToast('Sedang memproses...', 'info');

// Custom position
swalToast('Notifikasi', 'success', 'bottom-end');
```

**Position Options**:
- `top-start`, `top`, `top-end`
- `center-start`, `center`, `center-end`
- `bottom-start`, `bottom`, `bottom-end`

### 8. Loading Alert
```javascript
swalLoading(title = 'Loading...', text = 'Please wait')
```

**Example**:
```javascript
// Show loading
swalLoading('Memproses...', 'Mohon tunggu sebentar');

// Do async work
await processData();

// Close loading
swalClose();
```

### 9. Input Dialog
```javascript
swalInput(title, inputType = 'text', placeholder = '')
```

**Example**:
```javascript
const { value: name } = await swalInput(
  'Masukkan Nama',
  'text',
  'Nama Anda'
);

if (name) {
  console.log('User entered:', name);
}
```

**Input Types**:
- `text`, `email`, `password`, `number`, `tel`, `url`
- `textarea`, `select`, `radio`, `checkbox`, `file`, `range`

---

## Real-World Examples

### Example 1: Delete Item
```javascript
async function deleteStaff(id, name) {
  const result = await swalConfirmDelete(name);
  
  if (!result.isConfirmed) return;
  
  swalLoading('Menghapus...', 'Mohon tunggu');
  
  try {
    const response = await fetch(`/api/staff/${id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    });
    
    const data = await response.json();
    
    swalClose();
    
    if (data.success) {
      await swalSuccess('Berhasil!', 'Data berhasil dihapus');
      loadData();
    } else {
      swalError('Gagal!', data.message);
    }
  } catch (error) {
    swalClose();
    swalError('Error!', 'Terjadi kesalahan');
  }
}
```

### Example 2: Save Data
```javascript
async function saveData() {
  const result = await swalConfirm(
    'Simpan Data?',
    'Data akan disimpan ke database'
  );
  
  if (!result.isConfirmed) return;
  
  swalLoading('Menyimpan...', 'Mohon tunggu');
  
  try {
    const response = await fetch('/api/save', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
      },
      body: JSON.stringify(formData)
    });
    
    const data = await response.json();
    
    swalClose();
    
    if (data.success) {
      swalToast('Data berhasil disimpan', 'success');
    } else {
      swalError('Gagal!', data.message);
    }
  } catch (error) {
    swalClose();
    swalError('Error!', error.message);
  }
}
```

### Example 3: Form Validation
```javascript
async function submitForm() {
  const { value: email } = await swalInput(
    'Masukkan Email',
    'email',
    'email@example.com'
  );
  
  if (!email) return;
  
  // Validate email
  if (!email.includes('@')) {
    swalError('Invalid!', 'Format email tidak valid');
    return;
  }
  
  // Process email
  swalToast('Email berhasil disimpan', 'success');
}
```

### Example 4: Multi-Step Process
```javascript
async function multiStepProcess() {
  // Step 1: Confirm
  const result1 = await swalConfirm('Mulai Proses?', 'Ini akan memakan waktu');
  if (!result1.isConfirmed) return;
  
  // Step 2: Loading
  swalLoading('Step 1/3', 'Memproses data...');
  await step1();
  
  // Step 3: Update loading
  swalLoading('Step 2/3', 'Menyimpan ke database...');
  await step2();
  
  // Step 4: Final loading
  swalLoading('Step 3/3', 'Finalisasi...');
  await step3();
  
  // Step 5: Success
  swalClose();
  await swalSuccess('Selesai!', 'Semua proses berhasil');
}
```

---

## Advanced Usage

### Using Full Swal API
```javascript
// You can still use full Swal.fire() for custom needs
Swal.fire({
  title: 'Custom Alert',
  html: '<b>Bold text</b> and <i>italic</i>',
  icon: 'info',
  showCancelButton: true,
  confirmButtonColor: '#1f9e76',
  cancelButtonColor: '#d33',
  confirmButtonText: 'OK',
  cancelButtonText: 'Cancel',
  customClass: {
    popup: 'my-custom-class'
  }
});
```

### Chaining Alerts
```javascript
async function chainedAlerts() {
  await swalInfo('Step 1', 'First step');
  await swalInfo('Step 2', 'Second step');
  await swalSuccess('Done!', 'All steps completed');
}
```

### Custom Styling
```javascript
Swal.fire({
  title: 'Custom Styled',
  text: 'With custom colors',
  icon: 'success',
  confirmButtonColor: '#your-color',
  customClass: {
    title: 'your-title-class',
    content: 'your-content-class'
  }
});
```

---

## Migration Guide

### From Native Alert
```javascript
// ❌ Old way
alert('Success!');

// ✅ New way
swalSuccess('Success!');
```

### From Native Confirm
```javascript
// ❌ Old way
if (confirm('Are you sure?')) {
  deleteItem();
}

// ✅ New way
const result = await swalConfirm('Are you sure?');
if (result.isConfirmed) {
  deleteItem();
}
```

### From Toastify
```javascript
// ❌ Old way
Toastify({
  text: 'Success',
  duration: 3000,
  style: { background: '#1f9e76' }
}).showToast();

// ✅ New way
swalToast('Success', 'success');
```

---

## Tips & Best Practices

### 1. Use Async/Await
```javascript
// ✅ Good
const result = await swalConfirm('Delete?');
if (result.isConfirmed) { ... }

// ❌ Avoid
swalConfirm('Delete?').then(result => {
  if (result.isConfirmed) { ... }
});
```

### 2. Always Close Loading
```javascript
try {
  swalLoading();
  await doSomething();
  swalClose(); // ✅ Always close
} catch (error) {
  swalClose(); // ✅ Close in catch too
  swalError('Error!', error.message);
}
```

### 3. Use Toast for Non-Critical Messages
```javascript
// ✅ Good for non-critical
swalToast('Data saved', 'success');

// ❌ Overkill for simple messages
swalSuccess('Data saved', 'Your data has been saved successfully');
```

### 4. Consistent Button Text
```javascript
// ✅ Consistent
swalConfirm('Delete?', '', 'Ya, Hapus', 'Batal');
swalConfirm('Save?', '', 'Ya, Simpan', 'Batal');

// ❌ Inconsistent
swalConfirm('Delete?', '', 'OK', 'No');
swalConfirm('Save?', '', 'Yes', 'Cancel');
```

---

## Troubleshooting

### Issue: Swal is not defined
**Solution**: Make sure component is included
```blade
@include('components.sweetalert2')
```

### Issue: Helper functions not working
**Solution**: Check if jQuery is loaded (if needed)
```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

### Issue: Styling not applied
**Solution**: Clear browser cache (Ctrl+Shift+R)

---

## Summary

✅ **Available in all pages**  
✅ **Easy to use helper functions**  
✅ **Consistent styling**  
✅ **Modern and beautiful**  
✅ **Mobile-friendly**

---

**Developer**: Kiro AI  
**Date**: 2025-10-29  
**Status**: ✅ READY TO USE EVERYWHERE
