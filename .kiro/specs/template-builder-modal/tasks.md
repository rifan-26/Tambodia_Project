# Implementation Plan - Template Builder Modal

## Task Overview

Implementasi Template Builder dalam modal full-screen di halaman Master Layout tanpa redirect.

---

## Phase 1: Modal Infrastructure

### Task 1.1: Add Modal HTML Structure to Master Layout
- Add modal overlay div to `master-layout.blade.php`
- Add modal panel div with header and content areas
- Add hidden class by default
- _Requirements: 1.1, 1.2, 1.3_

### Task 1.2: Add Modal CSS Styles
- Style modal overlay (fixed, full-screen, dark background)
- Style modal panel (fixed, slide from right, white background)
- Add transition animations (slide, fade)
- Add responsive breakpoints (desktop, tablet, mobile)
- _Requirements: 1.4, 5.1, 5.2, 5.3_

### Task 1.3: Create Builder Content Component
- Extract builder interface from `builder.blade.php`
- Create `resources/views/components/template-builder-content.blade.php`
- Include grid selector, canvas, properties panels
- Make it reusable for modal context
- _Requirements: 7.1, 7.2, 7.3_

---

## Phase 2: JavaScript Modal Controller

### Task 2.1: Create TemplateBuilderModal Class
- Create `public/js/template-builder-modal.js`
- Implement constructor with initial state
- Add properties: isOpen, mode, templateId, templateData, hasUnsavedChanges
- _Requirements: 1.1, 6.1_

### Task 2.2: Implement Modal Open Method
- Create `open(mode, templateId)` method
- Show overlay and modal panel
- Add 'active' class for animations
- Disable body scroll
- Initialize builder based on mode
- _Requirements: 1.1, 1.2, 4.1_

### Task 2.3: Implement Modal Close Method
- Create `close()` method
- Check for unsaved changes
- Show confirmation if needed
- Hide overlay and modal
- Enable body scroll
- Clear builder state
- _Requirements: 2.1, 2.2, 2.3, 2.4_

### Task 2.4: Implement ESC Key Handler
- Add keydown event listener for ESC key
- Call close() method when ESC pressed
- Only active when modal is open
- _Requirements: 2.3_

### Task 2.5: Implement Overlay Click Handler
- Add click event listener on overlay
- Call close() method when overlay clicked
- Prevent click propagation from modal panel
- _Requirements: 2.2_

---

## Phase 3: Template Loading and Initialization

### Task 3.1: Implement Load Template Method
- Create `loadTemplate(id)` method
- Fetch template data via AJAX GET
- Show loading spinner during fetch
- Handle fetch errors
- _Requirements: 4.2, 4.3, 4.4_

### Task 3.2: Implement Initialize Builder Method
- Create `initBuilder(data)` method
- Populate grid selector with current grid
- Populate canvas with elements
- Populate properties panel
- Initialize builder tools
- _Requirements: 4.1, 4.5, 7.1, 7.2, 7.3_

### Task 3.3: Implement Empty Builder Initialization
- Handle create mode (no template data)
- Set default grid type
- Clear all elements
- Reset properties panel
- _Requirements: 4.1_

---

## Phase 4: Template Save Functionality

### Task 4.1: Implement Save Template Method
- Create `save()` method
- Collect template data from builder
- Validate required fields (name, grid_type)
- Show loading state on save button
- _Requirements: 3.1, 3.5_

### Task 4.2: Implement AJAX Save for Create Mode
- POST request to `/admin/templates`
- Include CSRF token
- Send template data as JSON
- Handle success response
- Handle error response
- _Requirements: 3.1, 3.4_

### Task 4.3: Implement AJAX Save for Edit Mode
- PUT request to `/admin/templates/{id}`
- Include CSRF token
- Send updated template data
- Handle success response
- Handle error response
- _Requirements: 3.1, 3.4_

### Task 4.4: Implement Post-Save Actions
- Close modal on successful save
- Reload template list
- Show success message (SweetAlert2)
- Clear unsaved changes flag
- _Requirements: 3.2, 3.3_

---

## Phase 5: Change Tracking and Auto-Save

### Task 5.1: Implement Change Tracking
- Create `trackChanges()` method
- Listen to builder events (grid change, element add/edit/delete)
- Set hasUnsavedChanges flag
- Debounce change detection (500ms)
- _Requirements: 6.1, 6.2_

### Task 5.2: Implement Auto-Save Draft
- Create `saveDraft()` method
- Save current state to localStorage
- Trigger every 30 seconds if changes detected
- Include timestamp in draft
- _Requirements: 6.1_

### Task 5.3: Implement Draft Recovery
- Create `loadDraft()` method
- Check localStorage for draft on open
- Show recovery dialog if draft exists
- Load draft data if user confirms
- Clear draft if user declines
- _Requirements: 6.3_

### Task 5.4: Implement Unsaved Changes Confirmation
- Create `confirmClose()` method
- Show SweetAlert2 confirmation dialog
- Options: "Simpan", "Buang Perubahan", "Batal"
- Handle each option appropriately
- _Requirements: 6.2, 6.5_

---

## Phase 6: Integration with Template Selector

### Task 6.1: Update Template Card Click Handlers
- Intercept "+ Tambah Template" card clicks
- Prevent default link behavior
- Call `builderModal.open('create')`
- _Requirements: 1.1_

### Task 6.2: Update Edit Button Click Handlers
- Intercept "Edit" button clicks
- Prevent default link behavior
- Extract template ID from button
- Call `builderModal.open('edit', templateId)`
- _Requirements: 1.2_

### Task 6.3: Implement Template List Reload
- Create `reloadTemplates()` function
- Call existing `loadTemplates()` function
- Trigger after modal close (if saved)
- Highlight newly created/updated template
- _Requirements: 2.4, 3.3_

---

## Phase 7: Builder Tools Integration

### Task 7.1: Verify Grid Selector Functionality
- Test grid selection in modal context
- Ensure grid preview updates
- Verify canvas updates on grid change
- _Requirements: 7.1_

### Task 7.2: Verify Element Tools Functionality
- Test "Add Text" tool in modal
- Test "Add Color" tool in modal
- Test "Add Image" tool in modal
- Verify image upload works
- _Requirements: 7.2_

### Task 7.3: Verify Properties Panel Functionality
- Test property editing for text elements
- Test property editing for color elements
- Test property editing for image elements
- Verify real-time preview updates
- _Requirements: 7.3_

### Task 7.4: Verify Undo/Redo Functionality
- Test undo button in modal
- Test redo button in modal
- Verify history state management
- _Requirements: 7.4_

### Task 7.5: Verify Preview Functionality
- Test preview button in modal
- Verify preview display
- Test preview close
- _Requirements: 7.5_

---

## Phase 8: Responsive Design

### Task 8.1: Implement Desktop Layout
- Modal width: calc(100% - 280px)
- Full height
- Slide from right animation
- _Requirements: 5.1_

### Task 8.2: Implement Tablet Layout
- Modal width: 100%
- Adjust builder panels for smaller width
- Maintain functionality
- _Requirements: 5.2_

### Task 8.3: Implement Mobile Layout
- Modal width: 100%
- Stack builder panels vertically
- Hide sidebar when modal open
- Adjust touch interactions
- _Requirements: 5.3, 5.5_

### Task 8.4: Test Responsive Transitions
- Test screen resize while modal open
- Verify layout adjusts smoothly
- Test orientation change on mobile
- _Requirements: 5.4_

---

## Phase 9: Error Handling and Edge Cases

### Task 9.1: Handle Network Errors
- Implement retry logic for failed requests
- Show user-friendly error messages
- Provide manual retry option
- _Requirements: 3.4, 4.4_

### Task 9.2: Handle Validation Errors
- Validate template name (required, max length)
- Validate grid selection (required)
- Show inline validation errors
- Prevent save if validation fails
- _Requirements: 3.4_

### Task 9.3: Handle Concurrent Edits
- Detect if template was modified by another user
- Show warning message
- Offer to reload or overwrite
- _Requirements: 3.4_

### Task 9.4: Handle Browser Back Button
- Prevent accidental navigation
- Show unsaved changes warning
- Use history API if needed
- _Requirements: 6.2_

---

## Phase 10: Testing and Polish

### Task 10.1: Manual Testing - Create Flow
- Test "+ Tambah Template" click
- Test builder initialization
- Test template design
- Test save and close
- Verify template appears in list
- _Requirements: All_

### Task 10.2: Manual Testing - Edit Flow
- Test "Edit" button click
- Test template data loading
- Test template modification
- Test save and close
- Verify changes reflected in list
- _Requirements: All_

### Task 10.3: Manual Testing - Close Scenarios
- Test "Kembali" button
- Test overlay click
- Test ESC key
- Test with unsaved changes
- Test without unsaved changes
- _Requirements: 2.1, 2.2, 2.3, 6.2_

### Task 10.4: Manual Testing - Error Scenarios
- Test network failure during save
- Test network failure during load
- Test invalid data
- Test concurrent edits
- _Requirements: 3.4, 4.4_

### Task 10.5: Cross-Browser Testing
- Test on Chrome
- Test on Firefox
- Test on Safari
- Test on Edge
- Fix compatibility issues
- _Requirements: All_

### Task 10.6: Performance Testing
- Test modal open/close speed
- Test builder initialization time
- Test save operation time
- Optimize if needed
- _Requirements: 4.1, 4.2_

### Task 10.7: Accessibility Testing
- Test keyboard navigation
- Test screen reader compatibility
- Test focus management
- Add ARIA labels if needed
- _Requirements: All_

---

## Phase 11: Documentation and Cleanup

### Task 11.1: Add Code Comments
- Comment complex logic
- Add JSDoc for public methods
- Document state management
- _Requirements: All_

### Task 11.2: Update User Documentation
- Create user guide for modal builder
- Add screenshots
- Document keyboard shortcuts
- _Requirements: All_

### Task 11.3: Clean Up Console Logs
- Remove debug console.log statements
- Keep only essential error logging
- _Requirements: All_

### Task 11.4: Code Review and Refactoring
- Review code quality
- Refactor duplicated code
- Optimize performance
- _Requirements: All_

---

## Implementation Priority

**High Priority (MVP)**:
- Phase 1: Modal Infrastructure
- Phase 2: JavaScript Modal Controller
- Phase 3: Template Loading
- Phase 4: Template Save
- Phase 6: Integration with Template Selector

**Medium Priority**:
- Phase 5: Change Tracking
- Phase 7: Builder Tools Integration
- Phase 8: Responsive Design

**Low Priority (Nice to Have)**:
- Phase 9: Advanced Error Handling
- Phase 10: Comprehensive Testing
- Phase 11: Documentation

## Estimated Timeline

- Phase 1-2: 2-3 hours
- Phase 3-4: 2-3 hours
- Phase 5-6: 1-2 hours
- Phase 7-8: 2-3 hours
- Phase 9-11: 2-3 hours

**Total**: 9-14 hours of development time
