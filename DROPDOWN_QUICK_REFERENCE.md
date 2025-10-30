# Staff Manager Dropdown - Quick Reference

## Element IDs

### HTML Elements
```html
<!-- Add Form -->
<select id="staffNameSelect">...</select>
<button id="btnAddNewName">+</button>

<!-- Edit Form -->
<select id="editNameSelect">...</select>
<button id="btnEditAddNewName">+</button>

<!-- Modal -->
<div id="addNameModal">
  <input id="newNameInput">
  <button id="btnSaveNewName">Tambah ke Daftar</button>
</div>
```

### JavaScript References
```javascript
const staffNameSelect = document.getElementById('staffNameSelect');
const editNameSelect = document.getElementById('editNameSelect');
const btnAddNewName = document.getElementById('btnAddNewName');
const btnEditAddNewName = document.getElementById('btnEditAddNewName');
const newNameInput = document.getElementById('newNameInput');
const btnSaveNewName = document.getElementById('btnSaveNewName');
```

---

## Key Functions

### 1. Load Staff Data
```javascript
async function loadStaff()
```
- Fetches staff from `/api/staff`
- Renders staff cards
- Shows empty state if no data

### 2. Add Staff
```javascript
document.getElementById('addStaffForm').addEventListener('submit', ...)
```
- Submits form data to `/api/staff` (POST)
- Includes: name, position, photo
- Reloads staff list on success

### 3. Edit Staff
```javascript
async function editStaff(id)
```
- Fetches staff data
- Populates edit modal
- Pre-selects current name in dropdown

### 4. Update Staff
```javascript
document.getElementById('editStaffForm').addEventListener('submit', ...)
```
- Submits to `/api/staff/{id}` (POST)
- Updates name, position, and optionally photo

### 5. Delete Staff
```javascript
async function deleteStaff(id, name)
```
- Confirms deletion
- Sends DELETE to `/api/staff/{id}`
- Reloads staff list

### 6. Add New Name
```javascript
btnSaveNewName.addEventListener('click', ...)
```
- Validates input (not empty, not duplicate)
- Adds to both dropdowns
- Auto-selects in active form
- Shows success toast

---

## Event Listeners

### Change Events (Visual Feedback)
```javascript
staffNameSelect.addEventListener('change', function() {
  this.style.borderColor = this.value ? '#1f9e76' : '#e5e7eb';
});
```

### Modal Open Events
```javascript
btnAddNewName.addEventListener('click', function() {
  newNameInput.value = '';
  addNameModal.show();
  setTimeout(() => newNameInput.focus(), 300);
});
```

### Enter Key Handler
```javascript
newNameInput.addEventListener('keypress', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault();
    btnSaveNewName.click();
  }
});
```

---

## API Endpoints

### GET /api/staff
**Response**:
```json
{
  "success": true,
  "staff": [
    {
      "id": 1,
      "name": "Ahmad Fauzi",
      "photo_path": "staff/photo.jpg",
      "position": 1,
      "is_active": true
    }
  ]
}
```

### POST /api/staff
**Request**: FormData
- `name`: string (required)
- `position`: 1|2 (required)
- `photo`: file (required)

**Response**:
```json
{
  "success": true,
  "message": "Staff berhasil ditambahkan"
}
```

### PUT /api/staff/{id}
**Request**: FormData
- `name`: string (required)
- `position`: 1|2 (required)
- `photo`: file (optional)

**Response**:
```json
{
  "success": true,
  "message": "Staff berhasil diupdate"
}
```

### DELETE /api/staff/{id}
**Response**:
```json
{
  "success": true,
  "message": "Staff berhasil dihapus"
}
```

---

## CSS Classes

### Visual States
```css
/* Default border */
.form-control {
  border: 2px solid #e5e7eb;
}

/* Selected/Active border */
.form-control {
  border-color: #1f9e76;
}

/* Focus state */
.form-control:focus {
  border-color: #1f9e76;
  box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1);
}
```

### Button Styles
```css
.btn-outline-primary {
  border: 2px solid #1f9e76;
  color: #1f9e76;
}

.btn-outline-primary:hover {
  background: #1f9e76;
  color: white;
}
```

---

## Common Tasks

### Add a New Pre-defined Name
1. Open `staff-manager.blade.php`
2. Find `<select id="staffNameSelect">`
3. Add new option:
```html
<option value="New Name">New Name</option>
```
4. Repeat for `<select id="editNameSelect">`

### Change Validation Rules
Edit the add name handler:
```javascript
btnSaveNewName.addEventListener('click', function() {
  const newName = newNameInput.value.trim();
  
  // Add your validation here
  if (!newName) {
    toast('Nama tidak boleh kosong', 'error');
    return;
  }
  
  // Check for duplicates
  const existingOptions = Array.from(staffNameSelect.options);
  const nameExists = existingOptions.some(option => 
    option.value.toLowerCase() === newName.toLowerCase()
  );
  
  if (nameExists) {
    toast('Nama sudah ada dalam daftar', 'error');
    return;
  }
  
  // Add name...
});
```

### Customize Toast Messages
```javascript
function toast(message, type = 'success') {
  const bg = type === 'success' ? '#1f9e76' : '#dc3545';
  Toastify({
    text: message,
    duration: 3000,
    close: true,
    gravity: 'top',
    position: 'right',
    style: { background: bg }
  }).showToast();
}
```

---

## Troubleshooting

### Dropdown not showing names
**Check**: Element ID is correct (`staffNameSelect` or `editNameSelect`)
```javascript
console.log(document.getElementById('staffNameSelect')); // Should not be null
```

### Add name button not working
**Check**: Button ID and event listener
```javascript
console.log(document.getElementById('btnAddNewName')); // Should not be null
```

### Names not syncing between forms
**Check**: Both dropdowns are being updated
```javascript
// Should add to both
staffNameSelect.appendChild(newOption1);
editNameSelect.appendChild(newOption2);
```

### Visual feedback not working
**Check**: Border color is being set
```javascript
element.style.borderColor = '#1f9e76'; // Green
element.style.borderColor = '#e5e7eb'; // Gray
```

---

## Testing Commands

### Run All Tests
```bash
php artisan test
```

### Run Staff Tests Only
```bash
php artisan test tests/Feature/StaffManagementTest.php
```

### Run Specific Test
```bash
php artisan test --filter it_can_create_staff_with_valid_data
```

### Check Diagnostics
Use Kiro's getDiagnostics tool:
```javascript
getDiagnostics(['resources/views/staff-manager.blade.php'])
```

---

## File Locations

- **View**: `resources/views/staff-manager.blade.php`
- **Controller**: `app/Http/Controllers/StaffController.php`
- **Model**: `app/Models/Staff.php`
- **Routes**: `routes/web.php` and `routes/api.php`
- **Tests**: `tests/Feature/StaffManagementTest.php`
- **Migration**: `database/migrations/*_create_staff_table.php`

---

## Quick Fixes

### Reset Dropdown to Default
```javascript
staffNameSelect.value = '';
staffNameSelect.style.borderColor = '#e5e7eb';
```

### Clear Modal Input
```javascript
newNameInput.value = '';
```

### Force Reload Staff List
```javascript
loadStaff();
```

### Show Loading Overlay
```javascript
showLoading();  // Show
hideLoading();  // Hide
```

---

## Browser Console Debugging

### Check if elements exist
```javascript
console.log('staffNameSelect:', document.getElementById('staffNameSelect'));
console.log('editNameSelect:', document.getElementById('editNameSelect'));
console.log('btnAddNewName:', document.getElementById('btnAddNewName'));
```

### Check dropdown options
```javascript
console.log('Options:', Array.from(staffNameSelect.options).map(o => o.value));
```

### Test API endpoint
```javascript
fetch('/api/staff')
  .then(r => r.json())
  .then(d => console.log('Staff data:', d));
```

---

## Version History

- **v1.0** (2025-10-29): Initial implementation with datalist (broken)
- **v1.1** (2025-10-29): Fixed element references, working dropdown system
