# Quick Guide - Confirm Delete Modal

## 🚀 Quick Start

### 1. Include Component (One Time)
```blade
@include('components.confirm-delete-modal')
```

### 2. Use in JavaScript
```javascript
showConfirmDeleteModal({
  title: 'Hapus Item',
  message: 'Apakah Anda yakin ingin menghapus <strong>"Nama Item"</strong>?',
  warnings: ['Warning 1', 'Warning 2'],
  confirmText: 'Ya, Hapus!',
  onConfirm: function() {
    // Your delete code here
  }
});
```

## 📋 Common Use Cases

### Delete with Name
```javascript
showConfirmDeleteModal({
  title: 'Hapus Media',
  message: `Apakah Anda yakin ingin menghapus <strong>"${name}"</strong>?`,
  warnings: ['File akan dihapus permanen'],
  onConfirm: () => executeDelete(id)
});
```

### Delete with Multiple Warnings
```javascript
showConfirmDeleteModal({
  title: 'Hapus Petugas',
  message: `Hapus petugas <strong>"${name}"</strong>?`,
  warnings: [
    'Data akan dihapus permanen',
    'Foto akan dihapus dari storage',
    'Tidak bisa di-undo'
  ],
  onConfirm: () => deleteStaff(id)
});
```

### Delete with Async Function
```javascript
showConfirmDeleteModal({
  title: 'Hapus Media',
  message: `Hapus media <strong>"${name}"</strong>?`,
  warnings: ['Media akan hilang dari semua jadwal'],
  onConfirm: async () => {
    const success = await deleteMedia(id);
    if (success) {
      await refreshList();
    }
  }
});
```

## ⚙️ All Parameters

```javascript
showConfirmDeleteModal({
  title: 'String',           // Modal title
  message: 'HTML String',    // Main message (supports HTML)
  warnings: ['Array'],       // Warning messages (array or string)
  confirmText: 'String',     // Confirm button text
  onConfirm: function() {}   // Callback function (required)
});
```

## 🎯 Default Values

```javascript
{
  title: 'Konfirmasi Hapus',
  message: 'Apakah Anda yakin ingin menghapus item ini?',
  warnings: [],
  confirmText: 'Ya, Hapus!'
}
```

## ✅ Checklist

- [ ] Include component di head
- [ ] Replace `confirm()` dengan `showConfirmDeleteModal()`
- [ ] Set title yang descriptive
- [ ] Set message dengan nama item (gunakan `<strong>`)
- [ ] Tambahkan warnings yang relevan
- [ ] Set confirmText yang jelas
- [ ] Implement onConfirm callback
- [ ] Test: modal muncul tanpa redirect
- [ ] Test: cancel button works
- [ ] Test: confirm button execute delete

## 🐛 Troubleshooting

### Modal tidak muncul
```javascript
// Check if component included
console.log(typeof showConfirmDeleteModal); // should be 'function'

// Check if Bootstrap loaded
console.log(typeof bootstrap); // should be 'object'
```

### Multiple modals
```javascript
// Make sure to close previous modal first
const existingModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
if (existingModal) {
  existingModal.hide();
}
```

### Callback not firing
```javascript
// Make sure onConfirm is a function
onConfirm: function() {
  console.log('Confirmed!');
  // Your code here
}
```

## 📱 Responsive

Modal automatically responsive:
- Desktop: Centered with max-width
- Tablet: Adjusted padding
- Mobile: Full width with proper spacing

## 🎨 Customization

To customize styling, edit:
```
resources/views/components/confirm-delete-modal.blade.php
```

Common customizations:
- Change colors
- Adjust border radius
- Modify padding/spacing
- Change icon
- Add animations

---
**Quick Reference** | **Version 1.0** | **30 Oktober 2025**
