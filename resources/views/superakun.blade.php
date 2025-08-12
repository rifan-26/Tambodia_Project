<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

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
  background: rgba(64, 86, 114, 0.5);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

/* ===== Modal Box ===== */
.custom-modal {
  background: #ffffff;
  border-radius: 10px;
  width: 350px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  animation: fadeIn 0.3s ease-in-out;
}

.custom-modal h3 {
  font-size: 1.3rem;
  margin-bottom: 15px;
  color: #2c3a67;
  text-align: center;
  font-weight: 600;
}

/* ===== Form Fields ===== */
.custom-modal label {
  font-weight: 600;
  color: #4b596a;
  margin-bottom: 5px;
  display: block;
}

.custom-modal input {
  width: 100%;
  padding: 8px 10px;
  border: 1px solid #d2d9f1;
  border-radius: 6px;
  outline: none;
  margin-bottom: 15px;
  font-size: 0.95rem;
  transition: all 0.2s ease-in-out;
}

.custom-modal input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

/* ===== Buttons ===== */
.custom-modal button {
  padding: 8px 15px;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.25s ease, transform 0.2s ease;
}

.custom-modal .btn-save {
  background: #35b85a;
  color: white;
}

.custom-modal .btn-save:hover {
  background: #2e9a4b;
  transform: translateY(-2px);
}

.custom-modal .btn-cancel {
  background: #e5e9f6;
  color: #2f3a55;
}

.custom-modal .btn-cancel:hover {
  background: #d2d9f1;
  transform: translateY(-2px);
}

/* ===== Animation ===== */
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
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
        <img src="{{ asset('img/Desain tanpa judul.svg') }}" alt="Logo-Tambodia">
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
          <a class="nav-link" href="{{ url('/login') }}">
            <i class="bi bi-box-arrow-left"></i> Log Out
          </a>
        </li>
      </ul>
    </div>
    <div class="sidebar-footer-img-container">
      <div class="sidebar-footer-gradient"></div>
    </div>
  </nav>

  <main class="content-area">
    <div class="header-top">
      <h2>Selamat Datang, Super Admin!</h2>
      <div class="user-badge">
        <span class="status-indicator" aria-label="online status"></span>
        <span>Username Super Admin</span>
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
            <th>Password</th>
            <th class="status">Status</th>
            <th class="action-header">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>0001</td>
            <td>Admin1</td>
            <td>admin1234</td>
            <td class="status">Online</td>
            <td class="action-icons">
              <button class="action-btn edit-btn" title="Edit"><i class="bi bi-pencil-fill"></i></button>
              <button class="action-btn delete-btn" title="Delete"><i class="bi bi-trash-fill"></i></button>
            </td>
          </tr>
          <tr>
            <td>0002</td>
            <td>Admin2</td>
            <td>admin1234</td>
            <td class="status">Online</td>
            <td class="action-icons">
              <button class="action-btn edit-btn" title="Edit"><i class="bi bi-pencil-fill"></i></button>
              <button class="action-btn delete-btn" title="Delete"><i class="bi bi-trash-fill"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

<!-- Modal Form Edit -->
<div id="editModal" class="modal-overlay">
  <div class="custom-modal">
    <h3>Edit Data Admin</h3>
    <form id="editForm">
      <label>Nama Akun:</label>
      <input type="text" id="editUsername" required>

      <label>Password:</label>
      <input type="text" id="editPassword" required>

      <button type="submit" class="btn-save">Simpan</button>
      <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
    </form>
  </div>
</div>

<div id="addModal" class="modal-overlay">
  <div class="custom-modal">
    <h3>Tambah Admin</h3>
    <form id="addForm">
      <label>Nama Akun:</label>
      <input type="text" id="addUsername" required>

      <label>Password:</label>
      <input type="text" id="addPassword" required>

      <button type="submit" class="btn-save">Tambah</button>
      <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
    </form>
  </div>
</div>


<script>
  let rowBeingEdited = null;

  function closeEditModal() {
    document.getElementById("editModal").style.display = "none";
  }

  function closeAddModal() {
    document.getElementById("addModal").style.display = "none";
  }

  // === ADD ADMIN ===
  document.querySelector('.add-admin').addEventListener('click', function() {
    document.getElementById("addModal").style.display = "block";
  });

  document.getElementById("addForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const username = document.getElementById("addUsername").value;
    const password = document.getElementById("addPassword").value;

    const tableBody = document.querySelector("table tbody");

    // Buat ID otomatis (ambil ID terakhir + 1)
    let lastId = 0;
    if (tableBody.rows.length > 0) {
      const lastRow = tableBody.rows[tableBody.rows.length - 1];
      lastId = parseInt(lastRow.cells[0].textContent);
    }
    const newId = String(lastId + 1).padStart(4, "0");

    // Buat baris baru
    const newRow = tableBody.insertRow();
    newRow.innerHTML = `
      <td>${newId}</td>
      <td>${username}</td>
      <td>${password}</td>
      <td class="status">Online</td>
      <td class="action-icons">
        <button class="action-btn edit-btn" title="Edit"><i class="bi bi-pencil-fill"></i></button>
        <button class="action-btn delete-btn" title="Delete"><i class="bi bi-trash-fill"></i></button>
      </td>
    `;

    // Pasang ulang event untuk tombol edit/delete di baris baru
    addRowEventListeners(newRow);

    closeAddModal();
    document.getElementById("addForm").reset();
  });

  // === EDIT ADMIN ===
  document.querySelectorAll('.edit-btn').forEach(function(button) {
    button.addEventListener('click', handleEditClick);
  });

  function handleEditClick() {
    rowBeingEdited = this.closest('tr');
    const username = rowBeingEdited.cells[1].textContent.trim();
    const password = rowBeingEdited.cells[2].textContent.trim();

    document.getElementById("editUsername").value = username;
    document.getElementById("editPassword").value = password;

    document.getElementById("editModal").style.display = "block";
  }

  document.getElementById("editForm").addEventListener("submit", function(e) {
    e.preventDefault();
    if (rowBeingEdited) {
      rowBeingEdited.cells[1].textContent = document.getElementById("editUsername").value;
      rowBeingEdited.cells[2].textContent = document.getElementById("editPassword").value;
    }
    closeEditModal();
  });

  // === DELETE ADMIN ===
  document.querySelectorAll('.delete-btn').forEach(function(button) {
    button.addEventListener('click', handleDeleteClick);
  });

  function handleDeleteClick(event) {
    event.preventDefault();
    const konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");
    if (konfirmasi) {
      this.closest('tr').remove();
    }
  }

  // Fungsi untuk pasang event di baris baru
  function addRowEventListeners(row) {
    row.querySelector('.edit-btn').addEventListener('click', handleEditClick);
    row.querySelector('.delete-btn').addEventListener('click', handleDeleteClick);
  }
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
