# Implementation Plan

- [x] 1. Setup database schema dan models





  - [ ] 1.1 Create migration untuk layout_templates table
    - Write migration file dengan struktur: name, description, thumbnail_path, grid_type, grid_config (JSON), elements (JSON), is_active, created_by
    - Add indexes untuk is_active dan created_by columns
    - Add foreign key constraint untuk created_by ke users table


    - Add soft deletes untuk history tracking
    - _Requirements: 1.1, 8.3, 8.4_
  
  - [ ] 1.2 Create LayoutTemplate model dengan relationships
    - Create Eloquent model dengan fillable fields


    - Add JSON casting untuk grid_config dan elements
    - Define relationship dengan User model (creator)
    - Add scope untuk active template




    - _Requirements: 1.1, 2.2, 8.3_
  
  - [ ] 1.3 Create seeder untuk sample templates
    - Create factory untuk LayoutTemplate
    - Create seeder dengan 2-3 sample templates


    - Seed sample data untuk testing
    - _Requirements: 1.1_

- [ ] 2. Implement Master Layout Page (Template List)
  - [x] 2.1 Create TemplateController dengan index method

    - Create controller dengan resource methods
    - Implement index method untuk list semua templates
    - Add pagination (12 templates per page)
    - Order by updated_at descending
    - _Requirements: 1.1, 1.2, 1.3_
  
  - [x] 2.2 Create template list view (index.blade.php)


    - Create Blade template dengan Bootstrap grid layout
    - Display templates dalam card grid (3 columns)
    - Show thumbnail, name, date, dan active badge
    - Add "Tambah Template" floating action button




    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_
  
  - [ ] 2.3 Implement template card component
    - Create reusable template card component
    - Display thumbnail preview dengan fallback placeholder

    - Show template name dan creation date
    - Add action buttons: Pilih, Edit, Hapus
    - Show "Active" badge untuk template aktif
    - _Requirements: 1.1, 1.2, 1.3, 1.5_
  
  - [x] 2.4 Add routes untuk template management


    - Add resource routes untuk templates
    - Add custom route untuk activate template
    - Add route untuk duplicate template





    - Protect routes dengan auth middleware
    - _Requirements: 1.1, 2.1, 3.1_

- [ ] 3. Implement template activation functionality
  - [x] 3.1 Create activate method di TemplateController

    - Implement logic untuk set template sebagai active
    - Deactivate semua template lain (hanya 1 active)
    - Update is_active flag di database
    - Return success response dengan redirect




    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_
  
  - [ ] 3.2 Add confirmation modal untuk template activation
    - Create Bootstrap modal untuk konfirmasi
    - Show template preview di modal


    - Add "Ya, Pilih Template" dan "Batal" buttons
    - Handle AJAX request untuk activation
    - _Requirements: 2.1, 2.3_
  

  - [ ] 3.3 Update landing page untuk load active template
    - Modify LandingController@index untuk load active template
    - Add fallback ke default layout jika tidak ada active template
    - Pass template data ke view
    - _Requirements: 2.4, 11.1, 11.5_




- [ ] 4. Implement template deletion functionality
  - [ ] 4.1 Create destroy method di TemplateController
    - Implement validation untuk prevent delete active template
    - Delete associated images dari storage
    - Soft delete template dari database

    - Return success response
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5_
  
  - [ ] 4.2 Add confirmation modal untuk template deletion
    - Create SweetAlert2 confirmation dialog
    - Show warning untuk active template

    - Handle AJAX delete request
    - Update UI setelah deletion
    - _Requirements: 10.1, 10.2, 10.4_


- [x] 5. Create Template Builder page structure

  - [ ] 5.1 Create builder view (builder.blade.php)
    - Create 3-column layout: Grid Selector | Canvas | Properties Panel
    - Add header dengan template name input dan action buttons
    - Add toolbar di bawah canvas
    - Setup responsive layout

    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5_
  
  - [ ] 5.2 Implement create dan edit methods di controller
    - Create method untuk show builder page (new template)
    - Edit method untuk load existing template
    - Pass template data ke view untuk editing

    - _Requirements: 3.1, 3.2, 9.1, 9.2_
  
  - [ ] 5.3 Add CSS styling untuk builder interface
    - Style grid selector panel dengan hover effects
    - Style canvas area dengan border dan background
    - Style properties panel dengan form controls

    - Add responsive breakpoints

    - _Requirements: 3.3, 3.4, 12.1, 12.2_

- [ ] 6. Implement Grid Selector functionality
  - [ ] 6.1 Create grid preset components
    - Create HTML untuk 6 grid presets (1-col, 2-col, 3-col, 2x2, 3x3, custom)

    - Add preview thumbnail untuk setiap preset
    - Add click handler untuk select grid
    - Highlight selected grid
    - _Requirements: 4.1, 4.2, 4.5_
  
  - [x] 6.2 Implement grid rendering di canvas

    - Create JavaScript function untuk render grid di canvas
    - Generate CSS Grid berdasarkan grid config
    - Show grid lines sebagai visual guide
    - Add grid area labels (A1, A2, etc)
    - _Requirements: 4.2, 4.3, 4.5_

  

  - [ ] 6.3 Add grid change functionality
    - Allow changing grid setelah elements ditambahkan
    - Preserve elements yang masih fit di grid baru
    - Show warning jika elements akan hilang
    - _Requirements: 4.3, 4.4_



- [ ] 7. Implement Text Element functionality
  - [ ] 7.1 Add text element tool di toolbar
    - Create "Add Text" button di toolbar
    - Show cursor change ketika text mode active
    - Click pada grid area untuk add text element

    - _Requirements: 5.1, 5.2_
  
  - [ ] 7.2 Create text element component
    - Create editable text element di canvas
    - Allow inline editing dengan contenteditable
    - Show text element dengan default styling

    - Add selection indicator
    - _Requirements: 5.2, 5.4_
  
  - [ ] 7.3 Implement text properties panel
    - Create form controls untuk text properties



    - Add font size slider/input
    - Add color picker untuk text color
    - Add alignment buttons (left, center, right)
    - Update element ketika properties change
    - _Requirements: 5.3, 5.5_



- [ ] 8. Implement Color Element functionality
  - [ ] 8.1 Add color element tool di toolbar
    - Create "Add Color" button di toolbar
    - Show color picker modal ketika clicked
    - Click pada grid area untuk add color background
    - _Requirements: 6.1, 6.2_

  
  - [ ] 8.2 Create color picker component
    - Implement HTML5 color input
    - Add preset color swatches
    - Support HEX, RGB, RGBA formats
    - Show color preview

    - _Requirements: 6.1, 6.3_
  
  - [ ] 8.3 Apply color ke grid area
    - Set background color untuk selected grid area

    - Allow different colors untuk setiap area

    - Update preview real-time
    - Save color config ke elements array
    - _Requirements: 6.2, 6.4, 6.5_

- [ ] 9. Implement Image Element functionality
  - [x] 9.1 Add image upload tool di toolbar

    - Create "Add Image" button di toolbar
    - Open file picker ketika clicked
    - Show upload progress indicator
    - _Requirements: 7.1, 7.2_
  
  - [x] 9.2 Implement image upload handler

    - Create uploadImage method di TemplateController
    - Validate file type (JPG, PNG, WebP)
    - Validate file size (max 5MB)
    - Store image di storage/app/public/templates
    - Return image path dan media ID
    - _Requirements: 7.2, 7.3_

  
  - [ ] 9.3 Create image element component
    - Display uploaded image di canvas
    - Add image ke selected grid area

    - Show image dengan object-fit cover default

    - Add selection indicator
    - _Requirements: 7.2, 7.4_
  
  - [ ] 9.4 Implement image properties panel
    - Add object-fit controls (cover, contain, fill)

    - Add object-position controls
    - Add opacity slider
    - Update image display real-time
    - _Requirements: 7.4, 7.5_


- [ ] 10. Implement Template Save functionality
  - [ ] 10.1 Create save button handler
    - Add "Simpan Template" button di header
    - Show modal untuk input template name

    - Validate template name required

    - Collect all template data (grid config + elements)
    - _Requirements: 8.1, 8.2_
  
  - [ ] 10.2 Implement store method di TemplateController
    - Validate request data
    - Generate thumbnail dari canvas

    - Save template ke database
    - Save associated images
    - Return success response dengan redirect
    - _Requirements: 8.2, 8.3, 8.4, 8.5_
  
  - [x] 10.3 Generate thumbnail preview

    - Capture canvas sebagai image
    - Resize ke thumbnail size (300x200)
    - Save thumbnail ke storage
    - Store thumbnail path di database
    - _Requirements: 1.2, 8.4_




  
  - [ ] 10.4 Add success notification
    - Show SweetAlert2 success message
    - Redirect ke template list page
    - Highlight newly created template
    - _Requirements: 8.5_



- [ ] 11. Implement Template Edit functionality
  - [ ] 11.1 Load existing template data ke builder
    - Fetch template dari database by ID
    - Parse grid_config JSON

    - Parse elements JSON
    - Populate builder dengan existing data
    - _Requirements: 9.1, 9.2_
  
  - [x] 11.2 Render existing elements di canvas

    - Loop through elements array
    - Create element components untuk setiap element
    - Apply saved styles dan properties
    - Position elements di correct grid areas
    - _Requirements: 9.2, 9.3_
  
  - [ ] 11.3 Implement update method di TemplateController
    - Validate request data
    - Update template di database
    - Update thumbnail jika ada perubahan
    - Handle image updates
    - _Requirements: 9.3, 9.4_
  
  - [ ] 11.4 Auto-update landing page jika template active
    - Check jika edited template adalah active template
    - Clear cache untuk landing page
    - Trigger landing page refresh
    - _Requirements: 9.4, 9.5_

- [ ] 12. Implement Real-time Preview functionality
  - [ ] 12.1 Create preview update system
    - Add event listeners untuk semua changes
    - Debounce preview updates (500ms)
    - Re-render canvas on every change
    - _Requirements: 12.1, 12.2_
  
  - [ ] 12.2 Add device preview toggle
    - Create toggle buttons (Desktop / Mobile)
    - Adjust canvas width untuk mobile preview
    - Scale elements proportionally
    - _Requirements: 12.3_
  
  - [ ] 12.3 Implement zoom controls
    - Add zoom in/out buttons
    - Support zoom levels: 50%, 75%, 100%, 125%, 150%
    - Scale canvas dengan CSS transform
    - _Requirements: 12.4, 12.5_

- [ ] 13. Implement Undo/Redo functionality
  - [ ] 13.1 Create history management system
    - Create history array untuk store states
    - Add state ke history on every change
    - Limit history ke 50 states
    - Track current history index
    - _Requirements: 12.1, 12.2_
  
  - [ ] 13.2 Implement undo method
    - Create undo button di toolbar
    - Move history index backward
    - Restore previous state
    - Update canvas dan properties panel
    - _Requirements: 12.1, 12.2_
  
  - [ ] 13.3 Implement redo method
    - Create redo button di toolbar
    - Move history index forward
    - Restore next state
    - Update canvas dan properties panel
    - _Requirements: 12.1, 12.2_

- [ ] 14. Integrate template dengan Landing Page
  - [ ] 14.1 Create template renderer di LandingController
    - Load active template dari database
    - Parse grid_config dan elements
    - Generate HTML structure dari template data
    - Apply styles dari elements
    - _Requirements: 11.1, 11.2, 11.3_
  
  - [ ] 14.2 Create dynamic template view
    - Create Blade partial untuk render template
    - Loop through grid areas
    - Render elements di setiap area
    - Apply responsive styles
    - _Requirements: 11.2, 11.4_
  
  - [ ] 14.3 Implement fallback untuk no active template
    - Check jika ada active template
    - Show default layout jika tidak ada
    - Log warning di Laravel log
    - _Requirements: 11.5_
  
  - [ ] 14.4 Add responsive rendering
    - Add media queries untuk mobile
    - Adjust grid layout untuk tablet
    - Test di berbagai screen sizes
    - _Requirements: 11.4_

- [ ] 15. Add auto-save draft functionality
  - [ ] 15.1 Implement auto-save system
    - Create saveDraft method di TemplateController
    - Auto-save setiap 5 detik
    - Save ke localStorage sebagai backup
    - Show "Saving..." indicator
    - _Requirements: 12.1, 12.2_
  
  - [ ] 15.2 Implement draft recovery
    - Check localStorage on page load
    - Show modal untuk restore draft
    - Clear draft setelah save success
    - _Requirements: 12.1_

- [ ] 16. Implement template duplication
  - [ ] 16.1 Create duplicate method di TemplateController
    - Copy template data
    - Append "(Copy)" ke template name
    - Copy associated images
    - Set is_active ke false
    - _Requirements: 1.1, 8.3_
  
  - [ ] 16.2 Add duplicate button di template card
    - Add "Duplicate" button di action menu
    - Show confirmation modal
    - Redirect ke edit page setelah duplicate
    - _Requirements: 1.1_

- [ ] 17. Add search dan filter functionality
  - [ ] 17.1 Implement search di template list
    - Add search input di header
    - Search by template name
    - Update list real-time dengan AJAX
    - _Requirements: 1.1_
  
  - [ ] 17.2 Add filter by date
    - Add date range picker
    - Filter templates by creation date
    - Combine dengan search functionality
    - _Requirements: 1.3_

- [ ] 18. Polish UI dan add loading states
  - [ ] 18.1 Add loading indicators
    - Show spinner saat load template list
    - Show progress bar saat upload image
    - Show skeleton loader di builder
    - _Requirements: 3.2, 7.2, 11.3_
  
  - [ ] 18.2 Add animations dan transitions
    - Add fade-in animation untuk template cards
    - Add slide animation untuk panels
    - Add smooth transitions untuk hover effects
    - _Requirements: 1.1, 3.3_
  
  - [ ] 18.3 Improve error messages
    - Create user-friendly error messages
    - Add error toast notifications
    - Show validation errors inline
    - _Requirements: 8.2, 10.2_

- [ ]* 19. Write tests untuk template system
  - [ ]* 19.1 Write unit tests untuk LayoutTemplate model
    - Test model creation
    - Test JSON casting
    - Test relationships
    - Test scopes
    - _Requirements: 1.1, 2.2, 8.3_
  
  - [ ]* 19.2 Write feature tests untuk TemplateController
    - Test template CRUD operations
    - Test template activation
    - Test prevent delete active template
    - Test image upload
    - _Requirements: 1.1, 2.1, 8.1, 10.1_
  
  - [ ]* 19.3 Write browser tests untuk template builder
    - Test grid selection
    - Test element addition
    - Test element editing
    - Test template save
    - _Requirements: 4.1, 5.1, 8.1_

- [ ] 20. Documentation dan deployment preparation
  - [ ] 20.1 Create user documentation
    - Write guide untuk create template
    - Add screenshots untuk setiap step
    - Create video tutorial
    - _Requirements: 3.1, 8.1_
  
  - [ ] 20.2 Add inline help tooltips
    - Add tooltips untuk toolbar buttons
    - Add help text di properties panel
    - Create "?" help button dengan modal
    - _Requirements: 3.4, 5.3_
  
  - [ ] 20.3 Optimize performance
    - Minify JavaScript dan CSS
    - Optimize image loading
    - Add caching untuk active template
    - _Requirements: 11.3_
