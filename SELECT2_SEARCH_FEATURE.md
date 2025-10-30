# Select2 Search Feature - Staff Name Dropdown

**Date**: 2025-10-29  
**Feature**: Searchable Dropdown with Select2  
**Status**: ✅ IMPLEMENTED

---

## Overview

Menambahkan fitur search di dropdown nama petugas menggunakan **Select2** library untuk meningkatkan user experience, terutama ketika jumlah nama bertambah banyak.

---

## Features

### ✨ What's New

1. **Search Box in Dropdown**
   - Ketik untuk mencari nama
   - Real-time filtering
   - Highlight matching text

2. **Keyboard Navigation**
   - Arrow keys untuk navigasi
   - Enter untuk select
   - Esc untuk close

3. **Clear Button**
   - X button untuk clear selection
   - Quick reset

4. **Better UX**
   - Loading indicator saat search
   - "No results" message
   - Smooth animations

5. **Responsive Design**
   - Works on mobile
   - Touch-friendly
   - Adaptive width

---

## Implementation

### 1. CDN Libraries Added

**CSS**:
```html
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
```

**JavaScript**:
```html
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
```

### 2. Custom Styling

```css
/* Select2 Custom Styling */
.select2-container--bootstrap-5 .select2-selection {
  border: 2px solid #e5e7eb !important;
  border-radius: 8px !important;
  min-height: 45px !important;
}

.select2-container--bootstrap-5.select2-container--focus .select2-selection {
  border-color: #1f9e76 !important;
  box-shadow: 0 0 0 3px rgba(31, 158, 118, 0.1) !important;
}

.select2-container--bootstrap-5 .select2-results__option--highlighted {
  background-color: #1f9e76 !important;
  color: white !important;
}
```

### 3. JavaScript Initialization

```javascript
// Initialize Select2 for Add Form
$('#staffNameSelect').select2({
  theme: 'bootstrap-5',
  placeholder: 'Pilih atau cari nama petugas',
  allowClear: true,
  width: '100%',
  language: {
    noResults: function() {
      return 'Nama tidak ditemukan';
    },
    searching: function() {
      return 'Mencari...';
    }
  }
});

// Initialize Select2 for Edit Form
$('#editNameSelect').select2({
  theme: 'bootstrap-5',
  placeholder: 'Pilih atau cari nama petugas',
  allowClear: true,
  width: '100%',
  dropdownParent: $('#editModal'), // Important for modal!
  language: {
    noResults: function() {
      return 'Nama tidak ditemukan';
    },
    searching: function() {
      return 'Mencari...';
    }
  }
});
```

### 4. Event Handlers

```javascript
// Visual feedback on select
$('#staffNameSelect').on('select2:select', function() {
  $(this).next('.select2-container')
    .find('.select2-selection')
    .css('border-color', '#1f9e76');
});

// Reset border on clear
$('#staffNameSelect').on('select2:clear', function() {
  $(this).next('.select2-container')
    .find('.select2-selection')
    .css('border-color', '#e5e7eb');
});
```

### 5. Load Names from Database

```javascript
async function loadStaffNames() {
  const response = await fetch('/api/staff-names');
  const data = await response.json();
  
  if (data.success && data.names) {
    // Clear and repopulate
    $('#staffNameSelect').empty()
      .append('<option value="">Pilih atau cari nama petugas</option>');
    $('#editNameSelect').empty()
      .append('<option value="">Pilih atau cari nama petugas</option>');
    
    // Add all names
    data.names.forEach(nameObj => {
      const option1 = new Option(nameObj.name, nameObj.name, false, false);
      const option2 = new Option(nameObj.name, nameObj.name, false, false);
      $('#staffNameSelect').append(option1);
      $('#editNameSelect').append(option2);
    });
    
    // Trigger change to update Select2
    $('#staffNameSelect').trigger('change');
    $('#editNameSelect').trigger('change');
  }
}
```

### 6. Set Value Programmatically

```javascript
// Set value and trigger change
$('#staffNameSelect').val('John Doe').trigger('change');

// With visual feedback
$('#staffNameSelect').val('John Doe').trigger('change');
$('#staffNameSelect').next('.select2-container')
  .find('.select2-selection')
  .css('border-color', '#1f9e76');
```

---

## Usage

### For Users

1. **Search by Typing**:
   - Click dropdown
   - Start typing nama
   - Select from filtered results

2. **Browse All Names**:
   - Click dropdown
   - Scroll through list
   - Click to select

3. **Clear Selection**:
   - Click X button
   - Or select placeholder option

4. **Keyboard Shortcuts**:
   - `↓` / `↑` - Navigate options
   - `Enter` - Select highlighted option
   - `Esc` - Close dropdown

### For Developers

#### Initialize Select2
```javascript
$('#mySelect').select2({
  theme: 'bootstrap-5',
  placeholder: 'Select an option',
  allowClear: true
});
```

#### Get Selected Value
```javascript
const value = $('#mySelect').val();
```

#### Set Value
```javascript
$('#mySelect').val('value').trigger('change');
```

#### Reload Options
```javascript
$('#mySelect').empty();
// Add new options
$('#mySelect').append(new Option('Text', 'Value'));
$('#mySelect').trigger('change');
```

#### Destroy Select2
```javascript
$('#mySelect').select2('destroy');
```

---

## Configuration Options

### Basic Options
```javascript
{
  theme: 'bootstrap-5',           // Theme
  placeholder: 'Select...',       // Placeholder text
  allowClear: true,               // Show clear button
  width: '100%',                  // Width
  minimumInputLength: 0,          // Min chars to search
  maximumSelectionLength: 1,      // Max selections
  closeOnSelect: true,            // Close after select
  dropdownParent: $('#modal')     // Parent for modal
}
```

### Language Options
```javascript
{
  language: {
    noResults: function() {
      return 'No results found';
    },
    searching: function() {
      return 'Searching...';
    },
    inputTooShort: function() {
      return 'Please enter more characters';
    },
    loadingMore: function() {
      return 'Loading more results...';
    }
  }
}
```

### AJAX Options (for large datasets)
```javascript
{
  ajax: {
    url: '/api/search',
    dataType: 'json',
    delay: 250,
    data: function(params) {
      return {
        q: params.term,
        page: params.page
      };
    },
    processResults: function(data, params) {
      return {
        results: data.items,
        pagination: {
          more: data.has_more
        }
      };
    }
  }
}
```

---

## Events

### Available Events
```javascript
// When dropdown opens
$('#mySelect').on('select2:open', function() {
  console.log('Dropdown opened');
});

// When option selected
$('#mySelect').on('select2:select', function(e) {
  console.log('Selected:', e.params.data);
});

// When selection cleared
$('#mySelect').on('select2:clear', function() {
  console.log('Selection cleared');
});

// When dropdown closes
$('#mySelect').on('select2:close', function() {
  console.log('Dropdown closed');
});

// When searching
$('#mySelect').on('select2:searching', function() {
  console.log('Searching...');
});
```

---

## Styling

### Custom Colors
```css
/* Primary color */
.select2-container--bootstrap-5 .select2-results__option--highlighted {
  background-color: #your-color !important;
}

/* Border color */
.select2-container--bootstrap-5.select2-container--focus .select2-selection {
  border-color: #your-color !important;
}

/* Selected option */
.select2-container--bootstrap-5 .select2-results__option--selected {
  background-color: #your-light-color !important;
  color: #your-color !important;
}
```

### Custom Height
```css
.select2-container--bootstrap-5 .select2-selection {
  min-height: 50px !important;
}

.select2-container--bootstrap-5 .select2-selection__rendered {
  line-height: 34px !important;
}
```

---

## Troubleshooting

### Issue: Dropdown not showing in modal
**Solution**: Use `dropdownParent` option
```javascript
$('#mySelect').select2({
  dropdownParent: $('#myModal')
});
```

### Issue: Width not correct
**Solution**: Set width explicitly
```javascript
$('#mySelect').select2({
  width: '100%'
});
```

### Issue: Search not working
**Solution**: Check if `minimumInputLength` is set
```javascript
$('#mySelect').select2({
  minimumInputLength: 0  // Allow search from first char
});
```

### Issue: Options not updating
**Solution**: Trigger change after updating
```javascript
$('#mySelect').empty();
// Add options...
$('#mySelect').trigger('change');
```

### Issue: jQuery not defined
**Solution**: Load jQuery before Select2
```html
<script src="jquery.min.js"></script>
<script src="select2.min.js"></script>
```

---

## Performance

### For Large Datasets (1000+ items)

Use AJAX loading:
```javascript
$('#mySelect').select2({
  ajax: {
    url: '/api/search',
    delay: 250,
    data: function(params) {
      return { q: params.term };
    }
  },
  minimumInputLength: 2
});
```

### Lazy Loading
```javascript
$('#mySelect').select2({
  ajax: {
    url: '/api/items',
    data: function(params) {
      return {
        page: params.page || 1,
        per_page: 20
      };
    }
  }
});
```

---

## Browser Support

- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 11+
- ✅ Edge 79+
- ✅ Mobile browsers

---

## Benefits

### Before (Standard Select)
- ❌ No search functionality
- ❌ Hard to find names in long list
- ❌ Poor UX with many options
- ❌ No keyboard navigation

### After (Select2)
- ✅ Fast search
- ✅ Easy to find names
- ✅ Great UX even with 100+ names
- ✅ Full keyboard support
- ✅ Mobile-friendly
- ✅ Clear button
- ✅ Custom styling

---

## Future Enhancements

### Possible Improvements
1. **Grouping**: Group names by department
2. **Tags**: Allow multiple selection
3. **Templates**: Custom option templates with icons
4. **Infinite Scroll**: Load more on scroll
5. **Recent Selections**: Show recently used names first

---

## Resources

- **Select2 Docs**: https://select2.org/
- **Bootstrap 5 Theme**: https://github.com/apalfrey/select2-bootstrap-5-theme
- **Examples**: https://select2.org/examples

---

## Conclusion

✅ **Search feature implemented successfully**  
✅ **Better UX for users**  
✅ **Scalable for large datasets**  
✅ **Mobile-friendly**  
✅ **Production ready**

---

**Developer**: Kiro AI  
**Date**: 2025-10-29  
**Status**: ✅ READY TO USE
