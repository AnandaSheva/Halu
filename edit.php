<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account Info</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
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
  height: calc(100vh - 60px);
}

.sidebar {
  width: 220px;
  background: #fff;
  padding: 20px;
  border-right: 1px solid #ddd;
}

.main-content {
  flex: 1;
  padding: 20px;
  overflow-y: auto;
}

.three-col-grid {
  display: grid;
  grid-template-columns: 1fr 2fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
  align-items: start;
}

.card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  position: relative;
}

.double-card {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.full-width {
  grid-column: 1 / -1;
}


.center-cards {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.full-width {
  grid-column: 1 / -1;
  margin-top: 20px;
}


    .nav {
      list-style: none;
      padding: 0;
      margin: 0;
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

    

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    h2 {
      margin: 0;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 20px;
    }

  

    .card h3, .card h4 {
      margin-top: 0;
    }

    .edit-icon {
      position: absolute;
      top: 20px;
      right: 20px;
      color: blue;
      cursor: pointer;
      font-size: 18px;
    }

    
    .delete-icon {
      color: red;
      font-size: 20px;
      cursor: pointer;
      text-decoration: none;
    }

    .info-group {
      margin-bottom: 8px;
    }

    .info-label {
      font-weight: bold;
      display: inline-block;
      width: 120px;
    }

    .profile-img {
      width: 100px;
      height: 100px;
      background-color: #ddd;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    .card img.id-photo {
      width: 100%;
      border-radius: 8px;
      margin: 10px 0;
    }

    .grid-2 {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .grid-full {
      display: grid;
      grid-template-columns: 1fr;
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

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <h2>Account Info</h2>
      <a href="delete.php?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure?')" class="delete-icon">🗑️</a>
    </div>

    <!-- 3 Column Layout -->
    <div class="three-col-grid">
      <!-- Left: Profile -->
      <div class="card">
        <span class="edit-icon">✏️</span>
        <div class="profile-img"></div>
        <h3><?= $data['username'] ?></h3>
        <p>📍 <?= $data['address'] ?? 'Unknown' ?></p>
        <p>📧 <?= $data['email'] ?></p>
        <p>📞 <?= $data['phone'] ?? '-' ?></p>
      </div>

      <!-- Middle: Details + Identity -->
      <div class="double-card">
        <!-- Card 2 Atas -->
        <div class="card">
          <span class="edit-icon">✏️</span>
          <h4>Details</h4>
          <div class="info-group"><span class="info-label">First Name:</span> <?= $data['first_name'] ?? '-' ?></div>
          <div class="info-group"><span class="info-label">Last Name:</span> <?= $data['last_name'] ?? '-' ?></div>
          <div class="info-group"><span class="info-label">Date of Birth:</span> <?= $data['dob'] ?? '-' ?></div>
          <div class="info-group"><span class="info-label">Gender:</span> <?= $data['gender'] ?? '-' ?></div>
        </div>

        <!-- Card 2 Bawah -->
        <div class="card">
        <span class="edit-icon">✏️</span>
        <h4>Other Information</h4>
        <p><?= $data['other_info'] ?? 'None' ?></p>
        </div>
      </div>

      <!-- Right: Other Info -->
      <div class="card">
      <span class="edit-icon">✏️</span>
          <h4>Identity Information</h4>
          <?php if (!empty($data['id_image'])) { ?>
            <img src="uploads/<?= $data['id_image'] ?>" alt="ID Card" class="id-photo">
          <?php } ?>
          <div class="info-group"><span class="info-label">Card Type:</span> Indonesian Identity Card</div>
          <div class="info-group"><span class="info-label">NIK:</span> <?= $data['nik'] ?? '-' ?></div>
          <div class="info-group"><span class="info-label">Name:</span> <?= $data['username'] ?></div>
          <div class="info-group"><span class="info-label">Expire Date:</span> <?= $data['id_expiry'] ?? '-' ?></div>
          <div class="info-group"><span class="info-label">Nationality:</span> <?= $data['nationality'] ?? '-' ?></div>
        
      </div>
    </div>

    <!-- Full Width Bottom: Order History -->
    <div class="card full-width">
      <h4>Order History</h4>
      <p>No data yet.</p>
    </div>
  </div>
</div>


  </main>
</div>

</body>
</html>