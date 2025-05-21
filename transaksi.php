<?php
include 'koneksi.php';
session_start(); // Add session start

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Date filter processing
$where = "";
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if (!empty($start_date) && !empty($end_date)) {
    // Format dates for SQL query
    $formatted_start = date('Y-m-d', strtotime($start_date));
    $formatted_end = date('Y-m-d 23:59:59', strtotime($end_date));
    $where = " WHERE DATE(p.date) BETWEEN '$formatted_start' AND '$formatted_end'";
}

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch transactions with user information and apply date filter if set
$query = "SELECT p.*, u.name AS user_name 
          FROM pembayaran p 
          LEFT JOIN users u ON p.user_id = u.id 
          $where
          ORDER BY p.tanggal_pembayaran DESC 
          LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Get total records with filter
$total_query = "SELECT COUNT(*) as total FROM pembayaran p $where";
$total_result = mysqli_query($conn, $total_query);
$total = mysqli_fetch_assoc($total_result)['total'];
$pages = ceil($total / $limit);

// Check for missing columns and update data if needed
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Reset result pointer to beginning
    mysqli_data_seek($result, 0);
    
    // If invoice_id is empty, update all records with invoice_id
    if (empty($row['invoice_id'])) {
        $update_query = mysqli_query($conn, "SELECT id FROM pembayaran");
        while ($update_row = mysqli_fetch_assoc($update_query)) {
            $invoice_id = 'INV-' . sprintf('%06d', $update_row['id']);
            mysqli_query($conn, "UPDATE pembayaran SET invoice_id = '$invoice_id' WHERE id = {$update_row['id']}");
        }
    }
    
    // If date is empty, update date with tanggal_pembayaran
    if (empty($row['date'])) {
        mysqli_query($conn, "UPDATE pembayaran SET date = tanggal_pembayaran WHERE date IS NULL");
    }
    
    // Refresh our result set to get updated data
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transaction Management</title>
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!-- DateRangePicker CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <style>
    /* Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f8f9fa;
      color: #212529;
    }

    /* Topbar Styles */
    .topbar {
      background: #fff;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #e9ecef;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      height: 60px;
    }

    .topbar .logo-section {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-icon {
      width: 30px;
      height: 30px;
      background-color: #0d6efd;
      border-radius: 50%;
    }

    .logo-text {
      font-weight: 600;
      font-size: 18px;
      color: #212529;
    }

    .topbar .right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .notification-icon {
      font-size: 20px;
      color: #6c757d;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      position: relative;
      cursor: pointer;
    }

    .username {
      font-size: 14px;
      font-weight: 500;
    }

    .avatar {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      background-color: #e9ecef;
    }

    .dropdown-icon {
      color: #0d6efd;
      font-size: 14px;
    }
    
    /* User Dropdown Menu */
    .user-dropdown {
      position: absolute;
      top: 45px;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      min-width: 180px;
      display: none;
      z-index: 1001;
    }
    
    .user-dropdown.show {
      display: block;
    }
    
    .dropdown-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #212529;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
      background-color: #f8f9fa;
    }
    
    .dropdown-item.logout {
      color: #dc3545;
      border-top: 1px solid #e9ecef;
    }
    
    .dropdown-item.logout:hover {
      background-color: #fff8f8;
    }

    /* Layout Structure */
    .content-wrapper {
      display: flex;
      height: 100vh;
      padding-top: 60px; /* Height of the topbar */
    }

    /* Sidebar Styles */
    .sidebar {
      width: 230px;
      background: #fff;
      height: calc(100vh - 60px);
      padding: 25px 0;
      border-right: 1px solid #e9ecef;
      position: fixed;
      left: 0;
      top: 60px;
    }

    .nav {
      list-style: none;
    }

    .nav li {
      margin: 8px 0;
      padding: 5px 25px;
    }

    .nav li a {
      color: #495057;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 15px;
      padding: 10px 0;
      transition: all 0.2s ease;
    }

    .nav li.active {
      background-color: rgba(13, 110, 253, 0.05);
      border-left: 3px solid #0d6efd;
    }

    .nav li.active a {
      color: #0d6efd;
      font-weight: 500;
    }

    .nav li:hover a {
      color: #0d6efd;
    }

    /* Main Content Styles */
    .main-content {
      flex: 1;
      padding: 25px 30px;
      margin-left: 230px;
      overflow-y: auto;
    }

    /* Transaction specific styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    h2 {
      font-size: 32px;
      font-weight: 600;
      color: #212529;
    }

    .filter {
      position: relative;
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 5px;
      padding: 8px 15px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #495057;
      cursor: pointer;
    }

    .filter.active {
      background-color: #e2f0ff;
      border-color: #0d6efd;
      color: #0d6efd;
    }

    .date-filter-dropdown {
      position: absolute;
      top: 40px;
      right: 0;
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      padding: 15px;
      min-width: 300px;
      z-index: 1000;
      display: none;
    }

    .date-filter-dropdown.show {
      display: block;
    }

    .filter-form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .filter-form label {
      font-size: 14px;
      color: #495057;
      margin-bottom: 5px;
    }

    .filter-form input[type="date"] {
      padding: 8px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
    }

    .filter-buttons {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .filter-buttons button {
      padding: 8px 15px;
      border-radius: 4px;
      cursor: pointer;
      border: none;
    }

    .apply-filter {
      background-color: #0d6efd;
      color: white;
    }

    .reset-filter {
      background-color: #6c757d;
      color: white;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
    }

    thead {
      background-color: #f8f9fa;
    }

    th {
      padding: 15px 20px;
      text-align: left;
      font-weight: 500;
      font-size: 14px;
      color: #6c757d;
      border-bottom: 1px solid #e9ecef;
    }

    td {
      padding: 15px 20px;
      font-size: 14px;
      border-bottom: 1px solid #e9ecef;
    }

    tbody tr:hover {
      background-color: #f8f9fa;
    }

    .status {
      padding: 6px 10px;
      border-radius: 8px;
      font-size: 12px;
      color: white;
      font-weight: bold;
      display: inline-block;
    }

    .status.verified {
      background-color: #3cd278; /* Green for verified */
    }

    .status.pending {
      background-color: #f0c04f; /* Yellow for pending */
    }

    .status.rejected {
      background-color: #f16a6a; /* Red for rejected */
    }

    /* Pagination styles */
    .pagination {
      margin-top: 20px;
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .pagination a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      text-decoration: none;
      color: #495057;
      transition: all 0.2s ease;
    }

    .pagination a.active {
      background: #0d6efd;
      color: white;
      border-color: #0d6efd;
    }

    .pagination a:hover:not(.active) {
      background-color: #e9ecef;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }
      
      .main-content {
        margin-left: 200px;
      }
    }
  </style>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Moment.js -->
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <!-- DateRangePicker JS -->
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</head>
<body>
  <!-- Header -->
  <header class="topbar">
    <div class="logo-section">
      <div class="logo-icon"></div>
      <span class="logo-text">Admin Logo</span>
    </div>
    <div class="right">
      <div class="notification-icon">🔔</div>
      <div class="user-info" id="userInfoToggle">
        <span class="username"><?= isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name']) : 'Admin' ?></span>
        <div class="avatar"></div>
        <span class="dropdown-icon">▼</span>
        
        <!-- User Dropdown Menu -->
        <div class="user-dropdown" id="userDropdown">
          <a href="#" class="dropdown-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Profile
          </a>
          <a href="#" class="dropdown-item logout" id="logoutBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Logout
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="content-wrapper">
    <!-- Sidebar -->
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>
    <aside class="sidebar">
      <ul class="nav">
        <li class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
          <a href="dashboard.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="7" height="9"></rect>
              <rect x="14" y="3" width="7" height="5"></rect>
              <rect x="14" y="12" width="7" height="9"></rect>
              <rect x="3" y="16" width="7" height="5"></rect>
            </svg>
            Dashboard
          </a>
        </li>
        <li class="<?= $currentPage == 'task.php' ? 'active' : '' ?>">
          <a href="task.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
              <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
              <path d="M9 14l2 2 4-4"></path>
            </svg>
            Task
          </a>
        </li>
        <li class="<?= $currentPage == 'account.php' ? 'active' : '' ?>">
          <a href="account.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Account
          </a>
        </li>
        <li class="<?= $currentPage == 'transaksi.php' ? 'active' : '' ?>">
          <a href="transaksi.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
              <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            Payment
          </a>
        </li>
        <li class="<?= $currentPage == 'calendar.php' ? 'active' : '' ?>">
          <a href="calendar.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            Calendar
          </a>
        </li>
      </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <h2>Transaction</h2>
        <div class="filter <?= (!empty($start_date) && !empty($end_date)) ? 'active' : '' ?>" id="filterToggle">
          <span>📅</span> Filter Date
          
          <!-- Date Filter Dropdown -->
          <div class="date-filter-dropdown" id="dateFilterDropdown">
            <form class="filter-form" id="dateFilterForm">
              <div>
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="<?= $start_date ?>">
              </div>
              <div>
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" value="<?= $end_date ?>">
              </div>
              <div class="filter-buttons">
                <button type="button" class="reset-filter" id="resetFilter">Reset</button>
                <button type="submit" class="apply-filter">Apply Filter</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php if (!empty($start_date) && !empty($end_date)): ?>
        <div style="margin-bottom: 15px; font-size: 14px; color: #0d6efd;">
          Showing transactions from <?= date('F d, Y', strtotime($start_date)) ?> to <?= date('F d, Y', strtotime($end_date)) ?>
          <a href="transaksi.php" style="margin-left: 10px; color: #dc3545;">Clear filter</a>
        </div>
      <?php endif; ?>

      <table>
        <thead>
          <tr>
            <th><input type="checkbox"></th>
            <th>ID Invoice</th>
            <th>Date</th>
            <th>Buyer</th>
            <th>Seller</th>
            <th>Location</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
              // Handle nulls and use appropriate date field
              $invoice_id = !empty($row['invoice_id']) ? $row['invoice_id'] : 'INV-' . sprintf('%06d', $row['id']);
              $date = !empty($row['date']) ? $row['date'] : $row['tanggal_pembayaran'];
              $buyer = !empty($row['buyer']) ? $row['buyer'] : ($row['user_name'] ?? 'Unknown');
              $seller = !empty($row['seller']) ? $row['seller'] : 'System';
              $location = !empty($row['location']) ? $row['location'] : 'Online';
              $status = $row['status']; // Get the status from the database
            ?>
              <tr>
                <td><input type="checkbox"></td>
                <td><?= $invoice_id ?></td>
                <td><?= date("F d, Y, g:i A", strtotime($date)) ?></td>
                <td><?= $buyer ?></td>
                <td><?= $seller ?></td>
                <td><?= $location ?></td>
                <td><span class="status <?= $status ?>"><?= ucfirst($status) ?></span></td>
              </tr>
            <?php } ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align: center; padding: 20px;">No transactions found for the selected date range.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++) { 
          $url_params = $_GET;
          $url_params['page'] = $i;
          $query_string = http_build_query($url_params);
        ?>
          <a href="?<?= $query_string ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
        <?php } ?>
      </div>
    </div>
  </div>

  <script>
    // Toggle user dropdown menu
    const userInfoToggle = document.getElementById('userInfoToggle');
    const userDropdown = document.getElementById('userDropdown');
    
    userInfoToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
    });
    
    // Toggle date filter dropdown
    const filterToggle = document.getElementById('filterToggle');
    const dateFilterDropdown = document.getElementById('dateFilterDropdown');
    
    filterToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      dateFilterDropdown.classList.toggle('show');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function() {
      userDropdown.classList.remove('show');
      dateFilterDropdown.classList.remove('show');
    });
    
    // Stop propagation for dropdowns
    dateFilterDropdown.addEventListener('click', function(e) {
      e.stopPropagation();
    });
    
    // Reset filter
    document.getElementById('resetFilter').addEventListener('click', function() {
      document.getElementById('start_date').value = '';
      document.getElementById('end_date').value = '';
    });
    
    // Logout with confirmation
    document.getElementById('logoutBtn').addEventListener('click', function(e) {
      e.preventDefault();
      
      Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out of your session",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, logout'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'logout.php';
        }
      });
    });

    // Validate date range
    document.getElementById('dateFilterForm').addEventListener('submit', function(e) {
      const startDate = document.getElementById('start_date').value;
      const endDate = document.getElementById('end_date').value;
      
      if (!startDate || !endDate) {
        e.preventDefault();
        Swal.fire({
          title: 'Error',
          text: 'Please select both start and end dates',
          icon: 'error'
        });
      } else if (new Date(endDate) < new Date(startDate)) {
        e.preventDefault();
        Swal.fire({
          title: 'Error',
          text: 'End date must be after start date',
          icon: 'error'
        });
      }
    });
  </script>
</body>
</html>