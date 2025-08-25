<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Tambodia - Super Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

  <style>
    body {
      background-color: #405672;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #2f3a55;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* ===== Modal Overlay ===== */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 999;
  backdrop-filter: blur(4px);
}

/* ===== Modal Box ===== */
.custom-modal {
  background: #ffffff;
  border-radius: 16px;
  width: 420px;
  padding: 28px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  animation: modalFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  max-width: 90%;
}

.custom-modal h3 {
  font-size: 1.5rem;
  margin-bottom: 20px;
  color: #2c3a67;
  text-align: center;
  font-weight: 700;
  position: relative;
  padding-bottom: 12px;
}

.custom-modal h3::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #35b85a, #3b82f6);
  border-radius: 3px;
}

/* ===== Form Fields ===== */
.custom-modal label {
  font-weight: 600;
  color: #4b596a;
  margin-bottom: 6px;
  display: block;
  font-size: 0.95rem;
}

.form-group {
  margin-bottom: 18px;
  position: relative;
}

.form-group i {
  position: absolute;
  left: 12px;
  top: 36px;
  color: #8896b8;
}

.custom-modal input {
  width: 100%;
  padding: 12px 16px 12px 40px;
  border: 1px solid #d2d9f1;
  border-radius: 10px;
  outline: none;
  font-size: 1rem;
  transition: all 0.2s ease-in-out;
  background-color: #f8faff;
}

.custom-modal input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
  background-color: #fff;
}

.text-muted {
  color: #6c757d;
  font-size: 0.85rem;
}

.mt-1 {
  margin-top: 0.25rem;
}

.d-block {
  display: block;
}

/* Notification styles */
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 15px 25px;
  border-radius: 10px;
  color: white;
  font-weight: 600;
  z-index: 9999;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  transform: translateY(-20px);
  opacity: 0;
  transition: all 0.3s ease;
}

.notification.show {
  transform: translateY(0);
  opacity: 1;
}

.notification.success {
  background: linear-gradient(135deg, #35b85a, #2a9e4b);
}

.notification.error {
  background: linear-gradient(135deg, #ff5252, #d32f2f);
}

/* ===== Buttons ===== */
.modal-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 24px;
  gap: 12px;
}

.custom-modal button {
  padding: 12px 20px;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.25s ease;
  flex: 1;
  font-size: 0.95rem;
}

.custom-modal .btn-save {
  background: linear-gradient(135deg, #35b85a, #2a9e4b);
  color: white;
  box-shadow: 0 4px 12px rgba(53, 184, 90, 0.3);
}

.custom-modal .btn-save:hover {
  background: linear-gradient(135deg, #2e9a4b, #238a3f);
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(53, 184, 90, 0.4);
}

.custom-modal .btn-cancel {
  background: #e5e9f6;
  color: #2f3a55;
}

.custom-modal .btn-cancel:hover {
  background: #d2d9f1;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* ===== Animation ===== */
@keyframes modalFadeIn {
  from { opacity: 0; transform: scale(0.9) translateY(20px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}

.custom-modal {
  opacity: 0;
  transform: scale(0.9) translateY(20px);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.custom-modal.show {
  opacity: 1;
  transform: scale(1) translateY(0);
}


    .card {
      border: none;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      border-radius: 0.75rem;
      margin-bottom: 2rem;
    }

    .sidebar {
      background: linear-gradient( 180deg,#E7FFEA 0%,#ffffff 50%,#dcedff 100%);
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

    .sidebar-header {
      padding: 0;
      margin-top: 20px;
      user-select: none;
      margin-bottom: 20px;
    }

    .sidebar-header img {
      width: 70px;
      margin-left: 20px;
      
    }

    .sidebar-title {
      font-weight: 700;
      font-size: 1.25rem;
      margin: 0;
      display: flex;
      align-items: center;
    }

    .title-text {
      display: inline-block;
    }

    .tam { color: #0084d6; }
    .bo { color: #a0d5d2; }
    .dia { color: #1f9e76; }

    .nav-link {
      color: #4b596a;
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover:not(.active) {
      background-color: #bcddc9;
      color: #1f9e76;
    }

    .nav-link.active {
      background-color: #1f9e76 !important;
      color: #fffff1 !important;
      font-weight: 600;
    }

    .sidebar-footer-img-container {
      width: 100%;
      overflow: hidden;
      position: relative;
    }

    .sidebar-footer-gradient {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 500px;
      background: linear-gradient(to bottom, white, rgba(255, 255, 255, 0));
      z-index: 2;
      pointer-events: none;
    }

    main.content-area {
      margin-left: 240px;
      padding: 1.75rem 2rem 2rem 2rem;
      min-height: 100vh;
      background: linear-gradient(90deg, #ffffff, #e9edfa);
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      position: relative;
    }

    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .header-top h2 {
      margin: 0;
      font-weight: 600;
      font-size: 1.5rem;
      color: #2c3a67;
    }

    .user-badge {
      background: linear-gradient(90deg, #58cbaa, #7cb8f4);
      padding: 0.35rem 1rem;
      border-radius: 2rem;
      color: white;
      font-weight: 600;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.15);
    }

    .user-badge .status-indicator {
      width: 16px;
      height: 16px;
      background-color: #44d69e;
      border-radius: 50%;
      box-shadow: 0 0 6px #44d69eaa;
    }

    .add-admin {
      background-color: #35b85a;
      border: none;
      color: white;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      box-shadow: 0 3px 9px rgba(53, 184, 90, 0.5);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .add-admin:hover {
      background-color: #2e9a4b;
      box-shadow: 0 5px 15px rgba(46, 154, 75, 0.6);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      color: #3b82f6;
    }

    thead tr {
      background-color: #e9eef9;
    }

    thead th {
      text-align: left;
      padding: 14px 12px;
      font-weight: 600;
      border-bottom: 2px solid #d2d9f1;
    }

    tbody tr {
      border-bottom: 1px solid #e5e9f6;
    }

    th.action-header, td.action-icons {
        width: 100px; 
        text-align: center;
        vertical-align: middle;
    }


    tbody td {
      vertical-align: middle;
      color: #5d6b9f;
      padding: 10px 12px;
    }

    .status {
      text-align: center;
      font-weight: 600;
      color: #3b82f6;
    }

    .action-icons {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .action-btn {
      border: none;
      cursor: pointer;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 2px 7px rgb(99 99 99 / 0.12);
    }

    .action-btn:focus {
      outline: 2px solid #3b5bdb;
      outline-offset: 2px;
    }

    .edit-btn {
      background-color: #fff2c3;
      color: #ffc400;
    }

    .edit-btn:hover {
      background-color: #fff2c3;
      box-shadow: 0 4px 12px rgba(252, 202, 0, 0.55);
    }

    .delete-btn {
      background-color: #ffc5b8;
      color: #ff2f00;
    }

    .delete-btn:hover {
      background-color: #ffc5b8;
      box-shadow: 0 4px 12px rgba(229, 77, 58, 0.55);
    }

    .bi {
      font-size: 1.2rem;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 60px;
        padding-top: 1rem;
      }

      main.content-area {
        margin-left: 60px;
        padding: 1rem;
      }

      .nav-link {
        font-size: 0;
        justify-content: center;
      }

      .nav-link .bi {
        font-size: 1.6rem;
      }

      .nav-link.active {
        border-radius: 0;
      }

      .sidebar-header h1 {
        font-size: 0;
      }
    }
  </style>
</head>

<body>
  <nav class="sidebar d-flex flex-column justify-content-between">
    <div>
      <div class="sidebar-header d-flex align-items-center gap-2">
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo Tambodia" style="width:70px; height:70px; margin-left:20px; object-fit:contain;"/>
        <h1 class="sidebar-title">
          <span class="title-text">
            <span class="tam">Tam</span><span class="bo">bo</span><span class="dia">dia</span>
          </span>
        </h1>
      </div>

      <ul class="nav flex-column px-1">
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/superadmin') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link active" href="{{ url('/superakun') }}">
            <i class="bi bi-person"></i> Admin
          </a>
        </li>
        <li class="nav-item mt-1">
          <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
            @csrf
          </form>
          <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Log Out
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <main class="content-area">
    <div class="header-top">
      <h2>Selamat Datang, Super Admin!</h2>
      <div class="user-badge">
        <span class="status-indicator" aria-label="online status"></span>
        <span>{{ $currentUser->name ?? 'Super Admin' }}</span>
      </div>
    </div>

    <div class="card">
      <h5>Admin Account Management</h5>
      <header class="d-flex justify-content-end mb-3">
        <button type="button" class="add-admin">Add Admin +</button>
      </header>

      <table>
        <caption class="sr-only">
          Daftar akun admin yang tersedia. Gunakan tombol "Add Admin" untuk menambahkan akun baru.
        </caption>
        <thead>
          <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Password</th>
            <th class="status">Status</th>
            <th class="action-header">Action</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($admins) && $admins->count() > 0)
            @foreach($admins as $admin)
            <tr data-id="{{ $admin->id }}">
              <td>{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }}</td>
              <td>{{ $admin->name }}</td>
              <td>{{ $admin->email }}</td>
              <td>{{ ucfirst($admin->role) }}</td>
              <td>••••••••</td>
              <td class="status {{ $admin->isOnline() ? 'online' : 'offline' }}">
                {{ $admin->isOnline() ? 'Online' : 'Offline' }}
              </td>
              <td class="action-icons">
                <button class="action-btn edit-btn" title="Edit" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" data-email="{{ $admin->email }}" data-role="{{ $admin->role }}"><i class="bi bi-pencil-fill"></i></button>
                <button class="action-btn delete-btn" title="Delete" data-id="{{ $admin->id }}"><i class="bi bi-trash-fill"></i></button>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="7" class="text-center">Tidak ada data admin</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </main>

<!-- Modal Form Edit -->
<div id="editModal" class="modal-overlay">
  <div class="custom-modal">
    <h3>Edit Data Admin</h3>
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" id="editAdminId" name="id">
      <div class="form-group">
        <label for="editName">Nama Akun:</label>
        <i class="bi bi-person-fill"></i>
        <input type="text" id="editName" name="name" placeholder="Masukkan nama akun" required>
      </div>
      
      <div class="form-group">
        <label for="editEmail">Email:</label>
        <i class="bi bi-envelope-fill"></i>
        <input type="email" id="editEmail" name="email" placeholder="Masukkan email" required>
      </div>

      <div class="form-group">
        <label for="editRole">Role:</label>
        <i class="bi bi-person-gear"></i>
        <select id="editRole" name="role" class="form-select" required>
          <option value="pegawai">Pegawai</option>
          <option value="superadmin">Super Admin</option>
        </select>
      </div>

      <div class="form-group">
        <label for="editPassword">Password:</label>
        <i class="bi bi-lock-fill"></i>
        <input type="password" id="editPassword" name="password" placeholder="Masukkan password">
        <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengubah password</small>
      </div>

      <div class="modal-buttons">
        <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-save">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div id="addModal" class="modal-overlay">
  <div class="custom-modal">
    <h3>Tambah Admin</h3>
    <form id="addForm" action="{{ url('/admin/store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="name">Nama Akun:</label>
        <i class="bi bi-person-fill"></i>
        <input type="text" id="name" name="name" placeholder="Masukkan nama akun" required>
      </div>
      
      <div class="form-group">
        <label for="email">Email:</label>
        <i class="bi bi-envelope-fill"></i>
        <input type="email" id="email" name="email" placeholder="Masukkan email" required>
        <small class="text-muted d-block mt-1">Format: nama@tambodia.com</small>
      </div>

      <div class="form-group">
        <label for="role">Role:</label>
        <i class="bi bi-person-gear"></i>
        <select id="role" name="role" class="form-select" required>
          <option value="pegawai" selected>Pegawai</option>
          <option value="superadmin">Super Admin</option>
        </select>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <i class="bi bi-lock-fill"></i>
        <input type="password" id="password" name="password" placeholder="Masukkan password" required minlength="6">
      </div>

      <div class="modal-buttons">
        <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
        <button type="submit" class="btn-save">Tambah</button>
      </div>
    </form>
  </div>
</div>


<script>
  let rowBeingEdited = null;
  let editingAdminId = null;

  // CSRF Token untuk AJAX requests
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  function showNotification(message, type = 'success') {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = message;
    document.body.appendChild(notification);
    
    // Tampilkan dengan animasi
    setTimeout(() => {
      notification.classList.add('show');
    }, 10);
    
    // Hilangkan setelah 3 detik
    setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => {
        notification.remove();
      }, 300);
    }, 3000);
  }

  function closeEditModal() {
    const modal = document.getElementById("editModal");
    modal.querySelector('.custom-modal').classList.remove('show');
    setTimeout(() => {
      modal.style.display = "none";
    }, 300);
  }

  function closeAddModal() {
    const modal = document.getElementById("addModal");
    modal.querySelector('.custom-modal').classList.remove('show');
    setTimeout(() => {
      modal.style.display = "none";
    }, 300);
  }

  // === ADD ADMIN ===
  document.querySelector('.add-admin').addEventListener('click', function() {
    const modal = document.getElementById("addModal");
    modal.style.display = "flex";
    setTimeout(() => {
      modal.querySelector('.custom-modal').classList.add('show');
    }, 10);
  });

  // Submit Tambah Admin via AJAX
  document.getElementById('addForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success && data.admin) {
        const tableBody = document.querySelector('table tbody');
        // Clear empty message if present
        const emptyRow = tableBody.querySelector('td[colspan="7"]');
        if (emptyRow) tableBody.innerHTML = '';

        const newRow = document.createElement('tr');
        newRow.dataset.id = data.admin.id;
        newRow.innerHTML = `
          <td>${String(data.admin.id).padStart(4, '0')}</td>
          <td>${data.admin.name}</td>
          <td>${data.admin.email}</td>
          <td>${(data.admin.role || '').charAt(0).toUpperCase() + (data.admin.role || '').slice(1)}</td>
          <td>••••••••</td>
          <td class="status online">Online</td>
          <td class="action-icons">
            <button class="action-btn edit-btn" title="Edit" data-id="${data.admin.id}" data-name="${data.admin.name}" data-email="${data.admin.email}" data-role="${data.admin.role}"><i class="bi bi-pencil-fill"></i></button>
            <button class="action-btn delete-btn" title="Delete" data-id="${data.admin.id}"><i class="bi bi-trash-fill"></i></button>
          </td>
        `;
        tableBody.appendChild(newRow);
        addRowEventListeners(newRow);
        showNotification('Admin berhasil ditambahkan!');
        closeAddModal();
        form.reset();
      } else {
        showNotification(data.message || 'Terjadi kesalahan saat menambahkan admin.', 'error');
      }
    })
    .catch(err => {
      console.error(err);
      showNotification('Terjadi kesalahan saat menambahkan admin.', 'error');
    });
  });

  // === EDIT ADMIN ===
  function setupEditButtons() {
    document.querySelectorAll('.edit-btn').forEach(function(button) {
      button.addEventListener('click', handleEditClick);
    });
  }
  
  // Panggil setup saat halaman dimuat
  setupEditButtons();

  function handleEditClick() {
    const button = this;
    editingAdminId = button.dataset.id;
    const name = button.dataset.name;
    const email = button.dataset.email;
    const role = button.dataset.role || 'pegawai';
    
    // Set form action
    const editForm = document.getElementById("editForm");
    editForm.action = `{{ url('/admin') }}/${editingAdminId}`;
    
    // Set form values
    document.getElementById("editAdminId").value = editingAdminId;
    document.getElementById("editName").value = name;
    document.getElementById("editEmail").value = email;
    document.getElementById("editRole").value = role;
    document.getElementById("editPassword").value = ""; // Clear password field

    // Show the modal with animation
    const modal = document.getElementById("editModal");
    modal.style.display = "flex";
    setTimeout(() => {
      modal.querySelector('.custom-modal').classList.add('show');
    }, 10);
  }

  document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault();
    
    const form = this;
    
    if (!editingAdminId) {
      showNotification('ID admin tidak valid.', 'error');
      return;
    }
    
    const name = document.getElementById("editName").value;
    const email = document.getElementById("editEmail").value;
    const password = document.getElementById("editPassword").value;
    
    // Validasi form
    if (!name || !email) {
      showNotification('Nama dan email harus diisi', 'error');
      return;
    }
    
    if (password.trim() !== '' && password.length < 6) {
      showNotification('Password minimal 6 karakter', 'error');
      return;
    }
    
    if (!email.includes('@')) {
      showNotification('Format email tidak valid', 'error');
      return;
    }
    
    // Kirim form dengan AJAX
    const formData = new FormData(form);
    
    // Kirim data ke server dengan AJAX
    fetch(form.action, {
      method: 'POST', // Gunakan POST dengan _method=PUT untuk method spoofing
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Update baris di tabel
        const row = document.querySelector(`tr[data-id="${editingAdminId}"]`);
        if (row) {
          const updated = data.admin || {};
          // Columns: 0=Id, 1=Username, 2=Email, 3=Role
          row.cells[1].textContent = updated.name || name;
          row.cells[2].textContent = updated.email || email;
          if (row.cells[3]) {
            const roleText = (updated.role || '').charAt(0).toUpperCase() + (updated.role || '').slice(1);
            row.cells[3].textContent = roleText || row.cells[3].textContent;
          }
          
          // Update data atribut pada tombol edit
          const editBtn = row.querySelector('.edit-btn');
          if (editBtn) {
            editBtn.dataset.name = updated.name || name;
            editBtn.dataset.email = updated.email || email;
            if (updated.role) editBtn.dataset.role = updated.role;
          }
        }
        
        // Tampilkan notifikasi
        showNotification('Admin berhasil diperbarui!');
        
        // Tutup modal
        closeEditModal();
      } else {
        showNotification(data.message || 'Terjadi kesalahan saat memperbarui admin.', 'error');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('Terjadi kesalahan saat memperbarui admin.', 'error');
    });
  });

  // === DELETE ADMIN ===
  function setupDeleteButtons() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
      button.addEventListener('click', handleDeleteClick);
    });
  }
  
  // Panggil setup saat halaman dimuat
  setupDeleteButtons();

  function handleDeleteClick(event) {
    event.preventDefault();
    const button = this;
    const adminId = button.dataset.id;
    
    if (!adminId) {
      showNotification('ID admin tidak valid.', 'error');
      return;
    }
    
    const konfirmasi = confirm("Apakah Anda yakin ingin menghapus admin ini?");
    if (konfirmasi) {
      // Buat form untuk delete
      const deleteForm = document.createElement('form');
      deleteForm.method = 'POST';
      deleteForm.action = `{{ url('/admin') }}/${adminId}`;
      deleteForm.style.display = 'none';
      
      const tokenInput = document.createElement('input');
      tokenInput.type = 'hidden';
      tokenInput.name = '_token';
      tokenInput.value = csrfToken;
      
      const methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      methodInput.value = 'DELETE';
      
      deleteForm.appendChild(tokenInput);
      deleteForm.appendChild(methodInput);
      document.body.appendChild(deleteForm);
      
      // Kirim form
      deleteForm.submit();
      
      // Hapus baris dari tabel setelah submit
      const row = document.querySelector(`tr[data-id="${adminId}"]`);
      if (row) {
        row.remove();
        
        // Cek apakah tabel kosong
        const tableBody = document.querySelector("table tbody");
        if (tableBody.children.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data admin</td></tr>';
        }
      }
      
      // Tampilkan notifikasi
      showNotification('Admin berhasil dihapus!');
    }
  }

  // Fungsi untuk pasang event di baris baru
  function addRowEventListeners(row) {
    const editBtn = row.querySelector('.edit-btn');
    if (editBtn) {
      editBtn.addEventListener('click', handleEditClick);
    }
    
    const deleteBtn = row.querySelector('.delete-btn');
    if (deleteBtn) {
      deleteBtn.addEventListener('click', handleDeleteClick);
    }
  }
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
