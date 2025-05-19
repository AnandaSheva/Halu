<?php
include 'koneksi.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch transactions
$result = mysqli_query($conn, "SELECT * FROM transactions ORDER BY date DESC LIMIT $start, $limit");

// Get total records
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions");
$total = mysqli_fetch_assoc($total_result)['total'];
$pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Transaction Management</title>
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

    .status.Completed {
      background-color: #3cd278;
    }

    .status.Pending {
      background-color: #f0c04f;
    }

    .status.Cancelled {
      background-color: #f16a6a;
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
      <div class="user-info">
        <span class="username">Admin123</span>
        <div class="avatar"></div>
        <span class="dropdown-icon">▼</span>
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
        <div class="filter">
          <span>📅</span> Filter Date
        </div>
      </div>

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
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><input type="checkbox"></td>
              <td><?= $row['invoice_id'] ?></td>
              <td><?= date("F d, Y, g:i A", strtotime($row['date'])) ?></td>
              <td><?= $row['buyer'] ?></td>
              <td><?= $row['seller'] ?></td>
              <td><?= $row['location'] ?></td>
              <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++) { ?>
          <a href="?page=<?= $i ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
        <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>