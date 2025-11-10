# Requirements Document - Template Builder Modal

## Introduction

Fitur untuk menampilkan Template Builder dalam modal/panel di halaman Master Layout yang sama, tanpa redirect ke halaman terpisah. User tetap berada di halaman `/layout` saat membuat atau mengedit template.

## Glossary

- **Master Layout Page**: Halaman utama yang menampilkan daftar template (`/layout`)
- **Template Builder**: Interface untuk membuat/mengedit template layout
- **Builder Modal**: Full-screen modal yang menampilkan Template Builder
- **Template Selector**: Grid yang menampilkan daftar template cards
- **Overlay**: Background gelap di belakang modal

## Requirements

### Requirement 1: Template Builder Modal Display

**User Story:** As a user, I want to create or edit templates without leaving the Master Layout page, so that I have a seamless experience.

#### Acceptance Criteria

1. WHEN user clicks "+ Tambah Template" card, THE System SHALL display Template Builder in a full-screen modal overlay
2. WHEN user clicks "Edit" button on a template card, THE System SHALL display Template Builder with template data loaded in a full-screen modal overlay
3. WHEN Template Builder modal is displayed, THE System SHALL show overlay background behind the modal
4. WHEN Template Builder modal is displayed, THE System SHALL hide the Template Selector grid
5. WHEN Template Builder modal is displayed, THE System SHALL maintain the sidebar visibility

### Requirement 2: Modal Navigation and Controls

**User Story:** As a user, I want to close the builder modal and return to template list, so that I can navigate easily.

#### Acceptance Criteria

1. WHEN user clicks "Kembali" button in builder header, THE System SHALL close the modal and show Template Selector
2. WHEN user clicks overlay background, THE System SHALL close the modal and show Template Selector
3. WHEN user presses ESC key, THE System SHALL close the modal and show Template Selector
4. WHEN modal is closed, THE System SHALL reload the template list to show any changes
5. WHEN modal is closing, THE System SHALL animate the transition smoothly

### Requirement 3: Template Save from Modal

**User Story:** As a user, I want to save my template from the builder modal, so that it appears in the template list immediately.

#### Acceptance Criteria

1. WHEN user clicks "Simpan Template" in builder modal, THE System SHALL save the template data via AJAX
2. WHEN template save is successful, THE System SHALL close the modal automatically
3. WHEN modal closes after save, THE System SHALL reload template list showing the new/updated template
4. WHEN template save fails, THE System SHALL display error message without closing modal
5. WHEN template is being saved, THE System SHALL show loading indicator on save button

### Requirement 4: Builder Content Loading

**User Story:** As a user, I want the builder to load quickly in the modal, so that I don't wait long.

#### Acceptance Criteria

1. WHEN modal opens for new template, THE System SHALL initialize empty builder interface within 500ms
2. WHEN modal opens for edit template, THE System SHALL load template data and populate builder within 1 second
3. WHEN builder is loading, THE System SHALL display loading spinner in modal
4. WHEN builder load fails, THE System SHALL display error message with retry option
5. WHEN builder is loaded, THE System SHALL enable all builder tools and controls

### Requirement 5: Modal Responsive Behavior

**User Story:** As a user, I want the builder modal to work on different screen sizes, so that I can use it on any device.

#### Acceptance Criteria

1. WHEN modal is displayed on desktop (>1024px), THE System SHALL show modal at full width minus sidebar (calc(100% - 280px))
2. WHEN modal is displayed on tablet (768px-1024px), THE System SHALL show modal at full width
3. WHEN modal is displayed on mobile (<768px), THE System SHALL show modal at full width with adjusted controls
4. WHEN screen is resized while modal is open, THE System SHALL adjust modal dimensions accordingly
5. WHEN on mobile, THE System SHALL hide sidebar when modal is open

### Requirement 6: State Management

**User Story:** As a user, I want my work to be preserved if I accidentally close the modal, so that I don't lose progress.

#### Acceptance Criteria

1. WHEN user makes changes in builder, THE System SHALL auto-save draft to localStorage every 30 seconds
2. WHEN user closes modal without saving, THE System SHALL show confirmation dialog if there are unsaved changes
3. WHEN user reopens builder after closing with unsaved changes, THE System SHALL offer to restore draft
4. WHEN template is successfully saved, THE System SHALL clear the draft from localStorage
5. WHEN user explicitly discards changes, THE System SHALL clear the draft from localStorage

### Requirement 7: Builder Integration

**User Story:** As a developer, I want the builder to work seamlessly in modal context, so that all features function correctly.

#### Acceptance Criteria

1. WHEN builder is in modal, THE System SHALL maintain all grid selection functionality
2. WHEN builder is in modal, THE System SHALL maintain all element tools (Text, Color, Image)
3. WHEN builder is in modal, THE System SHALL maintain all property editing functionality
4. WHEN builder is in modal, THE System SHALL maintain undo/redo functionality
5. WHEN builder is in modal, THE System SHALL maintain preview functionality
