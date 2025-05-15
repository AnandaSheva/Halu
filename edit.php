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
      position: relative;
      padding-bottom: 80px; /* Add space for the back button */
    }

    /* Three Col Grid */
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
      margin-top: 20px;
    }

    .center-cards {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    h2 {
      margin: 0;
      font-size: 32px;
      font-weight: 600;
      color: #212529;
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

    /* Back Button Style */
    .back-button {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background-color: #0d6efd;
      color: white;
      border: none;
      border-radius: 50px;
      padding: 12px 24px;
      font-size: 16px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
      transition: all 0.2s ease;
      z-index: 100;
    }

    .back-button:hover {
      background-color: #0b5ed7;
      transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }
      
      .main-content {
        margin-left: 200px;
      }
      
      .back-button {
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        font-size: 14px;
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

      <!-- Back Button -->
      <button class="back-button" onclick="window.history.back()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="19" y1="12" x2="5" y2="12"></line>
          <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back
      </button>
    </div>
  </div>
</body>
</html>