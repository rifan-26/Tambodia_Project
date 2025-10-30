{{-- SweetAlert2 Global Component --}}
{{-- Include this in your layout or pages to enable modern alerts --}}

<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet" />

<style>
  /* SweetAlert2 Custom Styling */
  .swal2-popup {
    border-radius: 12px !important;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
  }

  .swal2-title {
    color: #2c3a67 !important;
    font-size: 1.5rem !important;
    font-weight: 600 !important;
  }

  .swal2-html-container {
    color: #4b596a !important;
    font-size: 1rem !important;
  }

  .swal2-confirm.btn-danger {
    padding: 0.5rem 1.5rem !important;
    font-size: 0.95rem !important;
    border-radius: 8px !important;
    margin: 0 0.5rem !important;
  }

  .swal2-cancel.btn-secondary {
    padding: 0.5rem 1.5rem !important;
    font-size: 0.95rem !important;
    border-radius: 8px !important;
    margin: 0 0.5rem !important;
  }

  .swal2-confirm.btn-primary {
    padding: 0.5rem 1.5rem !important;
    font-size: 0.95rem !important;
    border-radius: 8px !important;
    margin: 0 0.5rem !important;
    background-color: #1f9e76 !important;
    border-color: #1f9e76 !important;
  }

  .swal2-confirm.btn-primary:hover {
    background-color: #16a085 !important;
    border-color: #16a085 !important;
  }

  .swal2-icon.swal2-success {
    border-color: #1f9e76 !important;
    color: #1f9e76 !important;
  }

  .swal2-icon.swal2-success [class^='swal2-success-line'] {
    background-color: #1f9e76 !important;
  }

  .swal2-icon.swal2-success .swal2-success-ring {
    border-color: rgba(31, 158, 118, 0.3) !important;
  }

  .swal2-icon.swal2-warning {
    border-color: #f39c12 !important;
    color: #f39c12 !important;
  }

  .swal2-icon.swal2-error {
    border-color: #dc3545 !important;
    color: #dc3545 !important;
  }

  .swal2-icon.swal2-info {
    border-color: #3498db !important;
    color: #3498db !important;
  }

  .swal2-icon.swal2-question {
    border-color: #9b59b6 !important;
    color: #9b59b6 !important;
  }

  /* Timer progress bar */
  .swal2-timer-progress-bar {
    background: #1f9e76 !important;
  }

  /* Loading spinner */
  .swal2-loader {
    border-color: #1f9e76 transparent #1f9e76 transparent !important;
  }
</style>

<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

<script>
  // Global SweetAlert2 Helper Functions
  window.SwalHelper = {
    // Success alert
    success: function(title, text = '', timer = 2000) {
      return Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        timer: timer,
        showConfirmButton: timer === 0,
        timerProgressBar: timer > 0,
        confirmButtonColor: '#1f9e76'
      });
    },

    // Error alert
    error: function(title, text = '') {
      return Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonColor: '#1f9e76',
        confirmButtonText: 'OK'
      });
    },

    // Warning alert
    warning: function(title, text = '') {
      return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        confirmButtonColor: '#1f9e76',
        confirmButtonText: 'OK'
      });
    },

    // Info alert
    info: function(title, text = '') {
      return Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        confirmButtonColor: '#1f9e76',
        confirmButtonText: 'OK'
      });
    },

    // Confirm dialog
    confirm: function(title, text = '', confirmText = 'Ya', cancelText = 'Batal') {
      return Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1f9e76',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true,
        focusCancel: true
      });
    },

    // Delete confirmation
    confirmDelete: function(itemName = '') {
      const text = itemName 
        ? `Apakah Anda yakin ingin menghapus "${itemName}"?`
        : 'Apakah Anda yakin ingin menghapus item ini?';
      
      return Swal.fire({
        title: 'Hapus Data?',
        html: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
        reverseButtons: true,
        focusCancel: true,
        customClass: {
          confirmButton: 'btn btn-danger',
          cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
      });
    },

    // Toast notification
    toast: function(message, icon = 'success', position = 'top-end') {
      const Toast = Swal.mixin({
        toast: true,
        position: position,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });

      return Toast.fire({
        icon: icon,
        title: message
      });
    },

    // Loading alert
    loading: function(title = 'Loading...', text = 'Please wait') {
      return Swal.fire({
        title: title,
        text: text,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
    },

    // Close loading
    close: function() {
      Swal.close();
    },

    // Input dialog
    input: function(title, inputType = 'text', placeholder = '') {
      return Swal.fire({
        title: title,
        input: inputType,
        inputPlaceholder: placeholder,
        showCancelButton: true,
        confirmButtonColor: '#1f9e76',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'OK',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
          if (!value) {
            return 'Field ini tidak boleh kosong!';
          }
        }
      });
    }
  };

  // Shorthand aliases
  window.swalSuccess = SwalHelper.success;
  window.swalError = SwalHelper.error;
  window.swalWarning = SwalHelper.warning;
  window.swalInfo = SwalHelper.info;
  window.swalConfirm = SwalHelper.confirm;
  window.swalConfirmDelete = SwalHelper.confirmDelete;
  window.swalToast = SwalHelper.toast;
  window.swalLoading = SwalHelper.loading;
  window.swalClose = SwalHelper.close;
  window.swalInput = SwalHelper.input;
</script>
