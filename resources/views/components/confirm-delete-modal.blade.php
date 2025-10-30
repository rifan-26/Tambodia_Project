<!-- Reusable Confirm Delete Modal Component -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
      <div class="modal-header" style="border-bottom: 1px solid #e9ecef; padding: 20px 25px;">
        <h5 class="modal-title" id="confirmDeleteModalTitle" style="font-weight: 600; color: #dc3545;">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <span id="confirmDeleteModalTitleText">Konfirmasi Hapus</span>
        </h5>
      </div>
      <div class="modal-body" style="padding: 25px;">
        <div id="confirmDeleteModalMessage" style="font-size: 1rem; color: #495057; margin-bottom: 20px;">
          <!-- Message will be inserted here -->
        </div>
        <div id="confirmDeleteModalWarning" style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
          <!-- Warning details will be inserted here -->
        </div>
      </div>
      <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 15px 25px; gap: 10px;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 25px; border-radius: 8px;">
          <i class="bi bi-x-circle me-1"></i> Batal
        </button>
        <button type="button" class="btn btn-danger" id="confirmDeleteModalYes" style="padding: 10px 30px; border-radius: 8px;">
          <i class="bi bi-trash me-1"></i> <span id="confirmDeleteModalYesText">Ya, Hapus!</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Global function to show confirm delete modal
window.showConfirmDeleteModal = function(options) {
  const {
    title = 'Konfirmasi Hapus',
    message = 'Apakah Anda yakin ingin menghapus item ini?',
    warnings = [],
    confirmText = 'Ya, Hapus!',
    onConfirm = () => {}
  } = options;
  
  // Set title
  document.getElementById('confirmDeleteModalTitleText').textContent = title;
  
  // Set message
  document.getElementById('confirmDeleteModalMessage').innerHTML = message;
  
  // Set warnings
  let warningsHtml = '';
  if (Array.isArray(warnings) && warnings.length > 0) {
    warningsHtml = warnings.map(warning => `
      <div style="display: flex; align-items: flex-start; margin-bottom: 8px;">
        <i class="bi bi-info-circle-fill me-2" style="color: #856404; font-size: 1.1rem; flex-shrink: 0;"></i>
        <span style="color: #856404;">${warning}</span>
      </div>
    `).join('');
  } else if (typeof warnings === 'string') {
    warningsHtml = `
      <div style="display: flex; align-items: flex-start;">
        <i class="bi bi-info-circle-fill me-2" style="color: #856404; font-size: 1.1rem; flex-shrink: 0;"></i>
        <span style="color: #856404;">${warnings}</span>
      </div>
    `;
  }
  document.getElementById('confirmDeleteModalWarning').innerHTML = warningsHtml;
  
  // Set confirm button text
  document.getElementById('confirmDeleteModalYesText').textContent = confirmText;
  
  // Remove old event handlers and add new one
  const confirmBtn = document.getElementById('confirmDeleteModalYes');
  const newConfirmBtn = confirmBtn.cloneNode(true);
  confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
  
  newConfirmBtn.addEventListener('click', function() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
    if (modal) {
      modal.hide();
    }
    onConfirm();
  });
  
  // Show modal
  const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
  modal.show();
}
</script>
