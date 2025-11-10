/**
 * TemplateBuilderModal Class
 * Manages the template builder modal state and interactions
 */
class TemplateBuilderModal {
    /**
     * Initialize the modal controller
     */
    constructor() {
        // Modal state
        this.isOpen = false;
        this.mode = null; // 'create' or 'edit'
        this.templateId = null;
        this.templateData = {};
        this.hasUnsavedChanges = false;
        
        // DOM elements (will be initialized when needed)
        this.overlay = null;
        this.modal = null;
        this.closeBtn = null;
        this.saveBtn = null;
        
        // Initialize DOM references
        this.initDOMReferences();
        
        // Bind methods to maintain context
        this.handleEscKey = this.handleEscKey.bind(this);
        this.handleOverlayClick = this.handleOverlayClick.bind(this);
    }
    
    /**
     * Initialize DOM element references
     */
    initDOMReferences() {
        this.overlay = document.getElementById('builderOverlay');
        this.modal = document.getElementById('builderModal');
        this.closeBtn = document.querySelector('.btn-close-builder');
        this.saveBtn = document.getElementById('btnBuilderSave');
        this.nameInput = document.getElementById('builderTemplateName');
        this.contentArea = document.getElementById('builderContent');
    }
    
    /**
     * Open the modal in create or edit mode
     * @param {string} mode - 'create' or 'edit'
     * @param {number|null} templateId - Template ID for edit mode
     */
    open(mode, templateId = null) {
        console.log(`Opening builder modal in ${mode} mode`, templateId);
        
        this.mode = mode;
        this.templateId = templateId;
        this.isOpen = true;
        
        // Show overlay and modal
        if (this.overlay) {
            this.overlay.classList.add('active');
        }
        
        if (this.modal) {
            this.modal.classList.add('active');
        }
        
        // Disable body scroll
        document.body.style.overflow = 'hidden';
        
        // Add event listeners
        this.addEventListeners();
        
        // Initialize builder based on mode
        if (mode === 'create') {
            this.initEmptyBuilder();
        } else if (mode === 'edit' && templateId) {
            this.loadTemplate(templateId);
        }
    }
    
    /**
     * Close the modal
     * @param {boolean} force - Force close without confirmation
     */
    close(force = false) {
        // Check for unsaved changes
        if (!force && this.hasUnsavedChanges) {
            this.confirmClose();
            return;
        }
        
        console.log('Closing builder modal');
        
        // Hide overlay and modal
        if (this.overlay) {
            this.overlay.classList.remove('active');
        }
        
        if (this.modal) {
            this.modal.classList.remove('active');
        }
        
        // Enable body scroll
        document.body.style.overflow = '';
        
        // Remove event listeners
        this.removeEventListeners();
        
        // Clear state
        this.isOpen = false;
        this.mode = null;
        this.templateId = null;
        this.templateData = {};
        this.hasUnsavedChanges = false;
        
        // Clear builder state
        this.clearBuilderState();
    }
    
    /**
     * Add event listeners for modal interactions
     */
    addEventListeners() {
        // ESC key handler
        document.addEventListener('keydown', this.handleEscKey);
        
        // Overlay click handler
        if (this.overlay) {
            this.overlay.addEventListener('click', this.handleOverlayClick);
        }
        
        // Close button handler
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.close());
        }
        
        // Save button handler
        if (this.saveBtn) {
            this.saveBtn.addEventListener('click', () => this.save());
        }
    }
    
    /**
     * Remove event listeners
     */
    removeEventListeners() {
        document.removeEventListener('keydown', this.handleEscKey);
        
        if (this.overlay) {
            this.overlay.removeEventListener('click', this.handleOverlayClick);
        }
    }
    
    /**
     * Handle ESC key press
     * @param {KeyboardEvent} event
     */
    handleEscKey(event) {
        if (event.key === 'Escape' && this.isOpen) {
            this.close();
        }
    }
    
    /**
     * Handle overlay click
     * @param {MouseEvent} event
     */
    handleOverlayClick(event) {
        // Only close if clicking directly on overlay, not on modal content
        if (event.target === this.overlay) {
            this.close();
        }
    }
    
    /**
     * Initialize empty builder for create mode
     */
    async initEmptyBuilder() {
        console.log('Initializing empty builder');
        
        // Reset template data
        this.templateData = {
            name: 'Template Baru',
            description: '',
            grid_type: '1-col',
            elements: []
        };
        
        // Set template name
        if (this.nameInput) {
            this.nameInput.value = this.templateData.name;
        }
        
        // Builder component is already included in HTML, just initialize
        console.log('Initializing empty builder');
        
        // Show builder content (it's already in DOM)
        if (this.contentArea) {
            // Make sure builder content is visible
            const builderContent = this.contentArea.querySelector('.builder-main-content');
            if (builderContent) {
                builderContent.style.display = 'flex';
            }
        }
        
        // Initialize builder JavaScript
        this.initBuilderInstance();
    }
    
    /**
     * Load template data for edit mode
     * @param {number} id - Template ID
     */
    async loadTemplate(id) {
        console.log('Loading template:', id);
        
        // Show loading state
        if (this.contentArea) {
            this.contentArea.innerHTML = `
                <div class="builder-loading" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; padding: 3rem;">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Memuat template...</p>
                </div>
            `;
        }
        
        try {
            // Load template data
            const response = await fetch(`/admin/templates/${id}/edit`);
            
            if (!response.ok) {
                throw new Error('Failed to load template');
            }
            
            const data = await response.json();
            this.templateData = data.template;
            
            // Set template name
            if (this.nameInput) {
                this.nameInput.value = this.templateData.name || `Template ${id}`;
            }
            
            // Builder component is already included in HTML, just show it
            console.log('Showing builder for edit mode');
            
            if (this.contentArea) {
                // Make sure builder content is visible
                const builderContent = this.contentArea.querySelector('.builder-main-content');
                if (builderContent) {
                    builderContent.style.display = 'flex';
                }
            }
            
            // Initialize builder with template data
            this.initBuilderInstance(this.templateData);
            
        } catch (error) {
            console.error('Error loading template:', error);
            
            // Show error message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal memuat template',
                    icon: 'error'
                });
            }
            
            this.close(true);
        }
    }
    
    /**
     * Save template data
     */
    async save() {
        console.log('Saving template');
        
        // Show loading state on save button
        if (this.saveBtn) {
            this.saveBtn.disabled = true;
            this.saveBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        }
        
        try {
            // Collect template data from builder
            const templateData = this.collectTemplateData();
            
            console.log('Template data to save:', templateData);
            
            const url = this.mode === 'create' 
                ? '/admin/templates' 
                : `/admin/templates/${this.templateId}`;
            
            const method = this.mode === 'create' ? 'POST' : 'PUT';
            
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(templateData)
            });
            
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Failed to save template');
            }
            
            const result = await response.json();
            
            // Show success message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Template berhasil disimpan',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
            
            // Clear unsaved changes flag
            this.hasUnsavedChanges = false;
            
            // Close modal
            this.close(true);
            
            // Reload template list
            if (typeof loadTemplates === 'function') {
                loadTemplates();
            }
            
        } catch (error) {
            console.error('Error saving template:', error);
            
            // Show error message
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Gagal menyimpan template',
                    icon: 'error'
                });
            }
        } finally {
            // Restore save button state
            if (this.saveBtn) {
                this.saveBtn.disabled = false;
                this.saveBtn.innerHTML = '<i class="bi bi-save"></i> Simpan Template';
            }
        }
    }
    
    /**
     * Show confirmation dialog before closing with unsaved changes
     */
    confirmClose() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Perubahan Belum Disimpan',
                text: 'Anda memiliki perubahan yang belum disimpan. Apa yang ingin Anda lakukan?',
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Simpan',
                denyButtonText: 'Buang Perubahan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#6f42c1',
                denyButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Save and close
                    this.save();
                } else if (result.isDenied) {
                    // Discard changes and close
                    this.close(true);
                }
                // If cancelled, do nothing (stay in modal)
            });
        } else {
            // Fallback to native confirm
            const confirmed = confirm('Anda memiliki perubahan yang belum disimpan. Tutup tanpa menyimpan?');
            if (confirmed) {
                this.close(true);
            }
        }
    }
    
    /**
     * Initialize builder instance
     * @param {object} templateData - Optional template data for edit mode
     */
    initBuilderInstance(templateData = null) {
        console.log('Initializing builder instance', templateData);
        
        // Check if FreeFormBuilder exists
        if (typeof window.freeFormBuilder === 'undefined') {
            console.error('FreeFormBuilder not found. Make sure template-builder-freeform.js is loaded.');
            return;
        }
        
        // Use global builder instance
        this.builderInstance = window.freeFormBuilder;
        
        // If template data provided, load it
        if (templateData && templateData.canvas_data) {
            this.builderInstance.fromJSON(templateData.canvas_data);
        } else {
            // Clear canvas for new template
            this.builderInstance.clear();
        }
        
        // Setup change tracking
        this.setupChangeTracking();
    }
    
    /**
     * Setup change tracking for builder
     */
    setupChangeTracking() {
        if (!this.builderInstance || !this.builderInstance.canvas) return;
        
        // Listen to canvas events for changes
        const canvas = this.builderInstance.canvas;
        
        canvas.on('object:added', () => this.trackChanges());
        canvas.on('object:modified', () => this.trackChanges());
        canvas.on('object:removed', () => this.trackChanges());
        
        console.log('Change tracking setup');
    }
    
    /**
     * Collect template data from builder
     * @returns {object} Template data
     */
    collectTemplateData() {
        // Get template name
        const name = this.nameInput ? this.nameInput.value.trim() : '';
        
        if (!name) {
            throw new Error('Nama template harus diisi');
        }
        
        if (!this.builderInstance || !this.builderInstance.canvas) {
            throw new Error('Canvas belum diinisialisasi');
        }
        
        // Collect data from builder
        const canvasData = this.builderInstance.toJSON();
        
        const data = {
            name: name,
            description: '',
            grid_type: 'freeform', // New type for free-form canvas
            canvas_data: canvasData
        };
        
        // If editing, include ID
        if (this.mode === 'edit' && this.templateId) {
            data.id = this.templateId;
        }
        
        return data;
    }
    
    /**
     * Clear builder state
     */
    clearBuilderState() {
        console.log('Clearing builder state');
        
        // Destroy builder instance
        if (this.builderInstance) {
            this.builderInstance = null;
        }
    }
    
    /**
     * Track changes in builder
     */
    trackChanges() {
        this.hasUnsavedChanges = true;
    }
}

// Initialize global instance
window.builderModal = null;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.builderModal = new TemplateBuilderModal();
    console.log('TemplateBuilderModal initialized');
});
