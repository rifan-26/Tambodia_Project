# SweetAlert2 - Modern Alert Dialogs

**Date**: 2025-10-29  
**Feature**: Replace native alerts with SweetAlert2  
**Status**: ✅ IMPLEMENTED

---

## Overview

Mengganti `alert()` dan `confirm()` native JavaScript dengan **SweetAlert2** untuk tampilan yang lebih modern, cantik, dan user-friendly.

---

## Before vs After

### ❌ Before (Native Alert)
```javascript
// Ugly, tidak bisa di-customize
if (!confirm('Apakah Anda yakin?')) return;
alert('Berhasil!');
```

**Problems**:
- Tampilan jelek dan kuno
- Tidak bisa di-style
- Tidak ada icon
- Tidak responsive
- Blocking UI

### ✅ After (SweetAlert2)
```javascript
// Beautiful, customizable, modern
const result = await Swal.fire({
  title: 'Hapus Petugas?',
  text: 'Apakah Anda yakin?',
  icon: 'warning',
  showCancelButton: true
});

if (result.isConfirmed) {
  Swal.fire('Berhasil!', 'Data telah dihapus', 'success');
}
```

**Benefits**:
- ✅ Tampilan modern dan cantik
- ✅ Fully customizable
- ✅ Icon support
- ✅ Responsive
- ✅ Non-blocking
- ✅ Animations
- ✅ Themes

---

## Implementation

### 1. CDN Added

**CSS**:
```html
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet" />
```

**JavaScript**:
```html
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
```

### 2. Delete Confirmation

**Before**:
```javascript
if (!confirm(`Apakah Anda yakin ingin menghapus "${name}"?`)) return;
```

**After**:
```javascript
const result = await Swal.fire({
  title: 'Hapus Petugas?',
  html: `Apakah Anda yakin ingin menghapus<br><strong>"${name}"</strong>?`,
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#dc3545',
  cancelButtonColor: '#6c757d',
  confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
  cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
  reverseButtons: true,
  focusCancel: true
});

if (!result.isConfirmed) return;
```

### 3. Success Message

**Before**:
```javascript
toast('Petugas berhasil dihapus');
```

**After**:
```javascript
await Swal.fire({
  title: 'Berhasil!',
  text: 'Petugas berhasil dihapus',
  icon: 'success',
  timer: 2000,
  showConfirmButton: false
});
```

### 4. Error Message

**Before**:
```javascript
toast('Gagal menghapus petugas', 'error');
```

**After**:
```javascript
Swal.fire({
  title: 'Gagal!',
  text: 'Gagal menghapus petugas',
  icon: 'error',
  confirmButtonColor: '#1f9e76'
});
```

---

## Custom Styling

### Theme Colors
```css
/* Success icon color */
.swal2-icon.swal2-success {
  border-color: #1f9e76 !important;
  color: #1f9e76 !important;
}

/* Title styling */
.swal2-title {
  color: #2c3a67 !important;
  font-size: 1.5rem !important;
  font-weight: 600 !important;
}

/* Button styling */
.swal2-confirm.btn-danger {
  padding: 0.5rem 1.5rem !important;
  border-radius: 8px !important;
}
```

---

## Usage Examples

### 1. Simple Alert
```javascript
Swal.fire('Hello!', 'This is a message', 'info');
```

### 2. Confirmation Dialog
```javascript
const result = await Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!'
});

if (result.isConfirmed) {
  // User clicked "Yes"
  Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
}
```

### 3. Input Dialog
```javascript
const { value: name } = await Swal.fire({
  title: 'Enter your name',
  input: 'text',
  inputPlaceholder: 'Your name',
  showCancelButton: true,
  inputValidator: (value) => {
    if (!value) {
      return 'You need to write something!';
    }
  }
});

if (name) {
  Swal.fire(`Hello ${name}!`);
}
```

### 4. Auto-close Timer
```javascript
Swal.fire({
  title: 'Auto close alert!',
  text: 'This will close in 2 seconds',
  timer: 2000,
  timerProgressBar: true,
  showConfirmButton: false
});
```

### 5. Loading State
```javascript
Swal.fire({
  title: 'Loading...',
  text: 'Please wait',
  allowOutsideClick: false,
  didOpen: () => {
    Swal.showLoading();
  }
});

// Close when done
Swal.close();
```

### 6. Custom HTML
```javascript
Swal.fire({
  title: '<strong>HTML <u>example</u></strong>',
  icon: 'info',
  html: `
    You can use <b>bold text</b>,
    <a href="#">links</a>,
    and other HTML tags
  `,
  showCloseButton: true,
  focusConfirm: false
});
```

### 7. Multiple Buttons
```javascript
Swal.fire({
  title: 'Choose an option',
  showDenyButton: true,
  showCancelButton: true,
  confirmButtonText: 'Save',
  denyButtonText: `Don't save`,
  cancelButtonText: 'Cancel'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire('Saved!', '', 'success');
  } else if (result.isDenied) {
    Swal.fire('Changes are not saved', '', 'info');
  }
});
```

### 8. Toast Notification
```javascript
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  }
});

Toast.fire({
  icon: 'success',
  title: 'Signed in successfully'
});
```

---

## Configuration Options

### Basic Options
```javascript
{
  title: 'Title',                    // Dialog title
  text: 'Message',                   // Dialog text
  html: '<b>HTML</b> content',       // HTML content
  icon: 'success',                   // Icon type
  iconColor: '#1f9e76',              // Icon color
  showConfirmButton: true,           // Show confirm button
  showCancelButton: false,           // Show cancel button
  showDenyButton: false,             // Show deny button
  confirmButtonText: 'OK',           // Confirm button text
  cancelButtonText: 'Cancel',        // Cancel button text
  confirmButtonColor: '#3085d6',     // Confirm button color
  cancelButtonColor: '#d33',         // Cancel button color
  timer: 0,                          // Auto-close timer (ms)
  timerProgressBar: false,           // Show timer progress bar
  allowOutsideClick: true,           // Allow click outside to close
  allowEscapeKey: true,              // Allow ESC key to close
  allowEnterKey: true,               // Allow Enter key
  showCloseButton: false,            // Show X close button
  focusConfirm: true,                // Focus confirm button
  focusCancel: false,                // Focus cancel button
  reverseButtons: false,             // Reverse button order
  buttonsStyling: true,              // Use SweetAlert2 button styling
  customClass: {                     // Custom CSS classes
    container: 'my-container',
    popup: 'my-popup',
    title: 'my-title',
    confirmButton: 'my-confirm',
    cancelButton: 'my-cancel'
  }
}
```

### Icon Types
- `success` - ✓ Green checkmark
- `error` - ✗ Red X
- `warning` - ⚠ Yellow warning
- `info` - ℹ Blue info
- `question` - ? Question mark

### Position Options
- `top`
- `top-start`
- `top-end`
- `center` (default)
- `center-start`
- `center-end`
- `bottom`
- `bottom-start`
- `bottom-end`

---

## Advanced Features

### 1. Chaining Alerts
```javascript
Swal.fire({
  title: 'Step 1',
  text: 'First step'
}).then(() => {
  return Swal.fire({
    title: 'Step 2',
    text: 'Second step'
  });
}).then(() => {
  Swal.fire({
    title: 'Done!',
    text: 'All steps completed'
  });
});
```

### 2. Queue Multiple Alerts
```javascript
Swal.queue([
  {
    title: 'Alert 1',
    text: 'First alert'
  },
  {
    title: 'Alert 2',
    text: 'Second alert'
  },
  {
    title: 'Alert 3',
    text: 'Third alert'
  }
]);
```

### 3. Custom Validation
```javascript
Swal.fire({
  title: 'Enter email',
  input: 'email',
  inputValidator: (value) => {
    if (!value) {
      return 'Email is required!';
    }
    if (!value.includes('@')) {
      return 'Invalid email format!';
    }
  }
});
```

### 4. Async/Await Pattern
```javascript
async function deleteItem() {
  const result = await Swal.fire({
    title: 'Delete?',
    showCancelButton: true
  });

  if (result.isConfirmed) {
    await performDelete();
    await Swal.fire('Deleted!', '', 'success');
  }
}
```

---

## Integration with Bootstrap

### Bootstrap Buttons
```javascript
Swal.fire({
  title: 'Bootstrap Styled',
  confirmButtonText: 'Confirm',
  cancelButtonText: 'Cancel',
  showCancelButton: true,
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false  // Disable SweetAlert2 styling
});
```

### Bootstrap Icons
```javascript
Swal.fire({
  title: 'With Icons',
  confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Confirm',
  cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Cancel',
  showCancelButton: true
});
```

---

## Best Practices

### 1. Use Async/Await
```javascript
// ✅ Good
const result = await Swal.fire({...});
if (result.isConfirmed) { ... }

// ❌ Avoid
Swal.fire({...}).then((result) => {
  if (result.isConfirmed) { ... }
});
```

### 2. Consistent Styling
```javascript
// Create reusable config
const deleteConfig = {
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#dc3545',
  cancelButtonColor: '#6c757d',
  confirmButtonText: 'Yes, delete!',
  cancelButtonText: 'Cancel'
};

// Use it
Swal.fire({
  ...deleteConfig,
  title: 'Delete item?'
});
```

### 3. Error Handling
```javascript
try {
  const result = await Swal.fire({...});
  if (result.isConfirmed) {
    await performAction();
  }
} catch (error) {
  Swal.fire('Error!', error.message, 'error');
}
```

---

## Browser Support

- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 11+
- ✅ Edge 79+
- ✅ Mobile browsers

---

## Resources

- **Official Docs**: https://sweetalert2.github.io/
- **Examples**: https://sweetalert2.github.io/#examples
- **GitHub**: https://github.com/sweetalert2/sweetalert2

---

## Conclusion

✅ **Modern alert dialogs implemented**  
✅ **Better UX than native alerts**  
✅ **Fully customizable**  
✅ **Mobile-friendly**  
✅ **Production ready**

---

**Developer**: Kiro AI  
**Date**: 2025-10-29  
**Status**: ✅ READY TO USE
