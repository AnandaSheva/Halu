<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account Management</title>
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
    }

    /* Account Header Styles */
    .account-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .account-header h1 {
      font-size: 32px;
      font-weight: 600;
      color: #212529;
    }

    .btn-add {
      background-color: #0d6efd;
      color: #fff;
      padding: 10px 16px;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .btn-add:hover {
      background-color: #0b5ed7;
    }

    /* Tabs Styles */
    .tabs {
      display: flex;
      border-bottom: 1px solid #e9ecef;
      margin-bottom: 20px;
    }

    .tabs a {
      padding: 12px 0;
      margin-right: 30px;
      text-decoration: none;
      color: #6c757d;
      font-weight: 500;
      font-size: 16px;
      position: relative;
    }

    .tabs a.active {
      color: #0d6efd;
    }

    .tabs a.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 2px;
      background-color: #0d6efd;
    }

    /* User Count Styles */
    .user-count {
      font-size: 18px;
      font-weight: 500;
      color: #212529;
      margin-bottom: 15px;
    }

    /* Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
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

    /* Operation Buttons */
    .operation-buttons {
      display: flex;
      gap: 8px;
    }

    .btn-edit, .btn-delete {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      border: none;
      color: #fff;
    }

    .btn-edit {
      background-color: #0dcaf0;
    }

    .btn-delete {
      background-color: #dc3545;
    }

    /* Popup Styles */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1010;
    }

    .popup-box {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 400px;
      position: relative;
    }

    .popup-box h3 {
      margin-bottom: 20px;
      font-size: 18px;
      color: #212529;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      font-weight: 500;
      color: #495057;
    }

    .form-group input, .form-group select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      font-size: 14px;
      color: #495057;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 25px;
    }

    .btn-cancel {
      background-color: #6c757d;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      border: none;
    }

    .btn-save {
      background-color: #0d6efd;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      border: none;
    }

    /* Confirmation Dialog */
    .confirm-dialog {
      text-align: center;
    }

    .confirm-dialog .warning-icon {
      font-size: 40px;
      color: #dc3545;
      margin-bottom: 15px;
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
    
    /* Dynamic Display Rules for Each Popup */
    <?php
    $query = mysqli_query($conn, "SELECT id FROM users");
    while ($row = mysqli_fetch_assoc($query)) {
        echo "#confirm-delete-{$row['id']}:checked ~ .popup-overlay-{$row['id']} { display: flex; }\n";
    }
    ?>
    
    #add-user-toggle:checked ~ .popup-add-user {
      display: flex;
    }
  </style>
</head>
<body>
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

    <main class="main-content">
      <div class="account-header">
        <h1>Account</h1>
        <label for="add-user-toggle" class="btn-add">
          <span>+</span> Add New Member
        </label>
      </div>

      <div class="tabs">
        <?php
        $role = isset($_GET['role']) ? $_GET['role'] : 'Customers';
        ?>
        <a href="?role=Customers" class="<?= $role == 'Customers' ? 'active' : '' ?>">Customers</a>
        <a href="?role=Sellers" class="<?= $role == 'Sellers' ? 'active' : '' ?>">Sellers</a>
      </div>

      <?php
      // Count users query
      $countQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='$role'");
      $countResult = mysqli_fetch_assoc($countQuery);
      $totalUsers = $countResult['total'];

      // Fetch users query
      $query = mysqli_query($conn, "SELECT * FROM users WHERE role='$role'");
      ?>

      <div class="user-count"><?= $totalUsers ?> Users</div>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Email Address</th>
            <?php if ($role === 'Sellers') { ?>
              <th>Status</th>
            <?php } else { ?>
              <th>Phone Number</th>
            <?php } ?>
            <th>Operations</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['username'] ?></td>
              <td><?= $row['role'] ?></td>
              <td><?= $row['email'] ?></td>
              <?php if ($role === 'Sellers') { ?>
                <td style="color: <?= $row['status'] == 'Verified' ? '#28a745' : '#dc3545'; ?>">
                  <?= $row['status'] ?>
                </td>
              <?php } else { ?>
                <td><?= $row['phone'] ?></td>
              <?php } ?>
              <td>
                <div class="operation-buttons">
                  <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏️</a>
                  <input type="checkbox" id="confirm-delete-<?= $row['id'] ?>" hidden>
                  <label for="confirm-delete-<?= $row['id'] ?>" class="btn-delete">🗑️</label>
                  
                  <!-- Delete confirmation popup -->
                  <div class="popup-overlay popup-overlay-<?= $row['id'] ?>">
                    <div class="popup-box confirm-dialog">
                      <div class="warning-icon">⚠️</div>
                      <h3>WARNING!</h3>
                      <p>Are you sure you want to delete <b><?= $row['username'] ?></b>?</p>
                      <div class="form-actions">
                        <label for="confirm-delete-<?= $row['id'] ?>" class="btn-cancel">Cancel</label>
                        <form method="post" action="delete.php" style="display:inline;">
                          <input type="hidden" name="id" value="<?= $row['id'] ?>">
                          <button type="submit" class="btn-save">Confirm</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <!-- Add User Popup -->
      <input type="checkbox" id="add-user-toggle" hidden>
      <div class="popup-overlay popup-add-user">
        <div class="popup-box">
          <h3>Add New <?= $role === 'Sellers' ? 'Seller' : 'Customer' ?></h3>
          <form action="add_user.php" method="post">
            <input type="hidden" name="role" value="<?= $role ?>">
            
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" required>
            </div>
            
            <?php if ($role === 'Sellers') { ?>
              <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                  <option value="Verified">Verified</option>
                  <option value="Unverified">Unverified</option>
                </select>
              </div>
            <?php } else { ?>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
              </div>
            <?php } ?>
            
            <div class="form-actions">
              <label for="add-user-toggle" class="btn-cancel">Cancel</label>
              <button type="submit" class="btn-save">Save</button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
</html>