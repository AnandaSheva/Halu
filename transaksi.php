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
<html>
<head>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
    }
    .topbar {
  background: #fff;
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #ddd;
}

.topbar .logo-section {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo-icon {
  width: 30px;
  height: 30px;
}

.logo-text {
  font-weight: bold;
  font-size: 16px;
}

.topbar .right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.topbar .avatar {
  width: 30px;
  height: 30px;
  border-radius: 50%;
}

.content-wrapper {
  display: flex;
  height: calc(100vh - 60px); /* kurangi tinggi header */
}

.sidebar {
  width: 220px;
  background: #fff;
  padding: 20px;
  border-right: 1px solid #ddd;
}

.nav {
  list-style: none;
  padding: 0;
}

.nav li {
  margin: 15px 0;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
}

.nav .active {
  color: #007bff;
  font-weight: bold;
}

    .sidebar {
      width: 200px;
      background: #f4f4f4;
      height: 100vh;
      float: left;
      padding: 20px;
    }

    .main {
      margin-left: 2px;
      padding: 20px;
    }

    table {
      width: 10%;
      border-collapse: collapse;
      margin-top: 2px;
    }

    table th, table td {
      padding: 8px 70px;
      border: 1px solid #eee;
      text-align: left;
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

    .pagination {
      margin-top: 20px;
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .pagination a {
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 50%;
      text-decoration: none;
      color: black;
    }

    .pagination a.active {
      background: #007bff;
      color: white;
    }

    .filter {
      float: right;
    }


    .nav li a {
  color: inherit;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
}

.nav li.active {
  color: #007bff;
  font-weight: bold;
}
  </style>
</head>
<body>

<header class="topbar">
    <div class="left">
      <div class="logo-section">
        <img src="https://via.placeholder.com/30" alt="Logo" class="logo-icon">
        <span class="logo-text">Admin Logo</span>
      </div>
    </div>
    <div class="right">
      <span class="notif">🔔</span>
      <span class="username">Admin123</span>
      <img src="https://via.placeholder.com/25" alt="Avatar" class="avatar">
    </div>
  </header>

  <div class="content-wrapper">
    <!-- Sidebar -->
    <?php
$currentPage = basename($_SERVER['PHP_SELF']); // detect halaman sekarang
?>

<aside class="sidebar">
  <ul class="nav">
    <li class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
      <a href="dashboard.php"><span class="icon">🏠</span> Dashboard</a>
    </li>
    <li class="<?= $currentPage == 'task.php' ? 'active' : '' ?>">
      <a href="task.php"><span class="icon">📝</span> Task</a>
    </li>
    <li class="<?= $currentPage == 'account.php' ? 'active' : '' ?>">
      <a href="account.php"><span class="icon">👤</span> Account</a>
    </li>
    <li class="<?= $currentPage == 'transaksi.php' ? 'active' : '' ?>">
      <a href="transaksi.php"><span class="icon">💳</span> Payment</a>
    </li>
    <li class="<?= $currentPage == 'calendar.php' ? 'active' : '' ?>">
      <a href="calendar.php"><span class="icon">📅</span> Calendar</a>
    </li>
  </ul>
</aside>

<div class="main">
  <h2>Transaction <span class="filter">📅 Filter Date</span></h2>

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

</body>
</html>
