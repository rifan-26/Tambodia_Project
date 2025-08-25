# Tambodia Design System

## Color Palette

### Primary Colors
- Primary Green: #1F9E76
- Primary Blue: #0071BC
- Primary Light Blue: #7CB8F4
- Primary Teal: #58CBA9

### Secondary Colors
- Background Light: #FFFFFF
- Background Gray: #F8F9FA
- Background Gradient Start: #E7FFEA
- Background Gradient Middle: #FFFFFF
- Background Gradient End: #DCEDFF

### Accent Colors
- Success: #45B649
- Warning: #FFA500
- Error: #D8000C
- Info: #007BFF

### Text Colors
- Primary Text: #2C3A67
- Secondary Text: #4B596A
- Tertiary Text: #6C757D
- Light Text: #FFFFFF

## Typography

### Font Family
- Primary: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
- Secondary: 'Poppins', sans-serif (for login page)

### Font Sizes
- Heading 1: 2.5rem
- Heading 2: 2rem
- Heading 3: 1.5rem
- Heading 4: 1.25rem
- Body Text: 1rem
- Small Text: 0.875rem

### Font Weights
- Light: 300
- Regular: 400
- Medium: 500
- Semi Bold: 600
- Bold: 700

## Spacing System

### Base Unit
- Base Unit: 0.5rem

### Spacing Scale
- XS: 0.25rem
- S: 0.5rem
- M: 1rem
- L: 1.5rem
- XL: 2rem
- XXL: 3rem

## Components

### Buttons
```css
.btn-primary {
  background-color: #1F9E76;
  color: #FFFFFF;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #1a8a66;
}

.btn-secondary {
  background-color: #0071BC;
  color: #FFFFFF;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.btn-secondary:hover {
  background-color: #0062a3;
}

.btn-danger {
  background-color: #D8000C;
  color: #FFFFFF;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.btn-danger:hover {
  background-color: #b5000a;
}
```

### Cards
```css
.card {
  background: #FFFFFF;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  padding: 1.5rem;
  border: none;
}
```

### Navigation
```css
.nav-link {
  color: #4B596A;
  padding: 0.5rem 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
  border-radius: 0.375rem;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-link:hover:not(.active) {
  background-color: #BCDDC9;
  color: #1F9E76;
}

.nav-link.active {
  background-color: #1F9E76 !important;
  color: #FFFFFF !important;
  font-weight: 600;
}
```

### Forms
```css
.form-control {
  border: 1px solid #A7B6D9;
  border-radius: 0.5rem;
  padding: 0.55rem 0.75rem;
  font-size: 1rem;
  color: #405672;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  outline: none;
  border-color: #1F9E76;
  box-shadow: 0 0 8px rgba(31, 158, 118, 0.6);
}

.form-label {
  font-weight: 500;
  margin-bottom: 0.3rem;
  display: inline-block;
  color: #405672;
}
```

### Tables
```css
table {
  width: 100%;
  border-collapse: collapse;
  background-color: #FFFFFF;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
}

thead {
  background-color: #E0E7FF;
}

thead th {
  color: #3B82F6;
  font-weight: 600;
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #C7D2FE;
}

tbody td {
  padding: 12px 15px;
  border-bottom: 1px solid #E0E7FF;
  color: #475569;
}

tbody tr:hover {
  background-color: #F1F5F9;
}
```

## Layout

### Breakpoints
- Mobile: 0px - 768px
- Tablet: 769px - 1024px
- Desktop: 1025px+

### Sidebar
```css
.sidebar {
  background: linear-gradient(180deg, #E7FFEA 0%, #FFFFFF 50%, #DCEDFF 100%);
  border-right: none;
  min-height: 100vh;
  width: 240px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding-top: 0.1rem;
  box-sizing: border-box;
  position: fixed;
  left: 0;
  top: 0;
}
```

### Main Content Area
```css
.content-area {
  margin-left: 240px;
  padding: 1.75rem 2rem 2rem 2rem;
  min-height: 100vh;
  background: linear-gradient(90deg, #FFFFFF, #E9EDFA);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  position: relative;
}
```

## Responsive Design

### Mobile First Approach
- Default styles for mobile
- Media queries for tablet and desktop

### Media Queries
```css
@media (max-width: 768px) {
  .sidebar {
    width: 60px;
  }
  
  .content-area {
    margin-left: 60px;
    padding: 1rem;
  }
  
  .nav-link {
    font-size: 0;
    justify-content: center;
    padding: 0.5rem 0;
  }
  
  .nav-link .bi {
    font-size: 1.6rem;
  }
}
```

## Accessibility

### Focus States
- All interactive elements must have visible focus states
- Use outline or box-shadow for focus indicators

### Contrast Ratios
- Text and background must meet WCAG 2.1 AA standards (4.5:1)
- Large text must meet WCAG 2.1 AA standards (3:1)

### Semantic HTML
- Use appropriate HTML elements for content structure
- Ensure proper heading hierarchy (h1-h6)
- Use ARIA attributes where necessary