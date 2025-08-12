<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SuperAdmin Dashboard Tambodia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>

<style>
    body {
      background-color: #405672;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #2f3a55;
      min-height: 100vh;
      margin: 0;
      padding: 0;
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
        display: inline-block;  /* biar teks-nya satu blok */
    }

    .tam {
        color: #0084d6;
    }

    .bo {
        color: #a0d5d2;
    }

    .dia {
        color: #1f9e76;
    }


    .nav-link.active {
      background-color: #1f9e76 !important;
      color: #fffff1 !important;
      font-weight: 600;
      border-radius: 0.375rem;
    }
    .nav-link {
      color: #4b596a;
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, color 0.3s ease;
      user-select: none;
    }
    .nav-link:hover:not(.active) {
      background-color: #bcddc9;
      color: #1f9e76;
      cursor: pointer;
    }
    .sidebar-footer-img-container {
        position: relative;
        width: 240px;
        overflow: hidden;
    }

    .sidebar-footer-img {
        width: 100%;
        height: auto;
        display: block;
    }

    .sidebar-footer-gradient {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 500px; /* tinggi overlay */
        background: linear-gradient(to bottom, white, rgba(255,255,255,0));
        z-index: 2;
        pointer-events: none;
    }


    /* Icons from Bootstrap Icons CDN */
    .bi {
      font-size: 1.2rem;
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
      /* Background with subtle gradient */
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
      user-select: none;
    }
    .user-badge .status-indicator {
      width: 16px;
      height: 16px;
      background-color: #44d69e;
      border-radius: 50%;
      box-shadow: 0 0 6px #44d69eaa;
    }
    .card {
      background: white;
      box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
      border-radius: 0.5rem;
      padding: 1.5rem 2rem 2rem 2rem;
      border: none;
    }
    .card h5 {
      font-weight: 600;
      margin-bottom: 1rem;
      color: #273554;
    }
    label {
      font-weight: 500;
      margin-bottom: 0.3rem;
      display: inline-block;
      color: #405672;
    }
    select.form-select {
      max-width: 300px;
      border-radius: 0.5rem;
      padding: 0.55rem 0.75rem;
    }
    textarea {
      width: 100%;
      height: 320px;
      margin-top: 1.25rem;
      padding: 1rem;
      border-radius: 0.5rem;
      border: 1px solid #a7b6d9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 1rem;
      resize: vertical;
      color: #334;
      transition: border-color 0.3s ease;
    }
    textarea:focus {
      outline: none;
      border-color: #1f9e76;
      box-shadow: 0 0 8px #1f9e76aa;
    }
    /* Sidebar icons color */
    .bi-speedometer2 {
      color: #ffffff;
    }
    .bi-pencil-square {
      color: #5a7062;
    }
    .bi-calendar3 {
      color: #5a7062;
    }
    .bi-box-arrow-left {
      color: #5a7062;
    }
    /* Scrollbar styling for textarea */
    textarea::-webkit-scrollbar {
      width: 10px;
    }
    textarea::-webkit-scrollbar-track {
      background: #f0f0f5;
      border-radius: 0.3rem;
    }
    textarea::-webkit-scrollbar-thumb {
      background-color: #a8bee3;
      border-radius: 0.3rem;
    }
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar {
        width: 60px;
        border-right: 3px solid #1f9e76;
        padding-top: 1rem;
      }
    .sidebar-header h1 {
        font-size: 0;
      }
    main.content-area {
        margin-left: 60px;
        padding: 1rem 1rem 1rem 1rem;
      }
    .nav-link {
        font-size: 0;
        justify-content: center;
        padding: 0.5rem 0;
      }
    .nav-link .bi {
        font-size: 1.6rem;
      }
    .nav-link.active {
        border-radius: 0;
      }
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #ffffff;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
    }
    thead {
      background-color: #e0e7ff;
    }
    thead th {
      color: #3b82f6;
      font-weight: 600;
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #c7d2fe;
      user-select: none;
    }
    tbody td {
      padding: 12px 15px;
      border-bottom: 1px solid #e0e7ff;
      color: #475569;
    }
    tbody tr:hover {
      background-color: #f1f5f9;
    }
    .icon-cell {
      width: 40px;
      text-align: center;
      color: #3b82f6;
      cursor: pointer;
      user-select: none;
    }

    .search {
      background-color: #35b85a;
      border: none;
      color: white;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      box-shadow: 0 3px 9px rgba(53, 184, 90, 0.5);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      margin-top: 10px;
    }

    .search:hover {
      background-color: #2e9a4b;
      box-shadow: 0 5px 15px rgba(46, 154, 75, 0.6);
    }
</style>
<!-- css dari dashboard bwangg -->

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
          <a class="nav-link active" href="{{ url('/superadmin') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link" href="{{ url('/superakun') }}">
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
      <div class="user-badge" title="Logged in as Admin">
        <span class="status-indicator" aria-label="online status"></span>
        <span>Username Super Admin</span>
      </div>
    </div>

    <div class="mb-3 form-section">
        <label for="cariFile" class="form-label">Cari Akun</label>
        <input type="text" class="form-control" id="cariFile" placeholder="Cari Nama Akun...">
        <button type="button" class="search">Search</button>
    </div>

    <div class="card">
      <h5>Aktivitas Akun Admin</h5>

       <table>
    <thead>
      <tr>
        <th class="icon-cell">⇤</th>
        <th>Username</th>
        <th>Status</th>
        <th>Time</th>
        <th>Date</th>
        <th>Activity</th>
      </tr>
    </thead>
    <tbody>
      <!-- Example rows -->
      <tr>
        <td class="icon-cell">⇤</td>
        <td>Admin1</td>
        <td>Active</td>
        <td>10:30 AM</td>
        <td>2024-06-01</td>
        <td>Login</td>
      </tr>
      <tr>
        <td class="icon-cell">⇤</td>
        <td>Admin2</td>
        <td>Inactive</td>
        <td>11:15 AM</td>
        <td>2024-06-01</td>
        <td>Logout</td>
      </tr>
    </tbody>
  </table>
    </div>
  </main>
  <script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("cariFile");
    const searchButton = document.querySelector(".search");
    const tableRows = document.querySelectorAll("table tbody tr");

    function filterTable() {
        const keyword = searchInput.value.trim().toLowerCase();

        tableRows.forEach(row => {
            const username = row.cells[1].textContent.toLowerCase();
            if (username.includes(keyword) || keyword === "") {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Klik tombol Search
    searchButton.addEventListener("click", filterTable);

    // Tekan Enter di input
    searchInput.addEventListener("keyup", function (e) {
        if (e.key === "Enter") {
            filterTable();
        }
    });
});
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

