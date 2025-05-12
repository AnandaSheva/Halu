<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account</title>
<style>

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
  .account-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1px;
}

.account-header h2{
    font-size: 40px;
}

.btn-add {
  background-color: #0d6efd;
  color: #fff;
  padding: 8px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.tabs a {
  margin-right: 15px;
  text-decoration: none;
  color: #555;
  font-weight: 500;
  padding-bottom: 5px;
  border-bottom: 2px solid transparent;
}

.tabs a.active {
  border-bottom: 2px solid #0d6efd;
  color: #0d6efd;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1px;
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
}

th, td {
  padding: 15px 65px;
  text-align: left;
  border-bottom: 1px solid #eee;
  font-size: 14px;
}

.btn-edit, .btn-delete {
  padding: 5px 8px;
  border-radius: 5px;
  font-size: 14px;
  text-decoration: none;
  margin-right: 5px;
}

.btn-edit {
  background: #0dcaf0;
  color: #fff;
}

.btn-delete {
  background: #dc3545;
  color: #fff;
}
/* Popup visibility control */
#popup-toggle:checked ~ .popup-add {
  display: flex;
}

.popup-add {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.popup-boxx {
  background: #fff;
  padding: 30px;
  border-radius: 10px;
  width: 400px;
  position: relative;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  text-align: left; /* ✅ ini bikin tulisan rata kiri */
}

.popup-action {
  display: flex;
  justify-content: flex-end; /* ✅ sejajarkan ke kanan */
  gap: 10px;
  margin-top: 20px;
}

.popup-boxx h3 {
  margin-top: 0;
  margin-bottom: 20px;
}

.popup-boxx label {
  display: block;
  margin-top: 10px;
  font-weight: 500;
}

.popup-boxx input {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.btn-cancel,
.close-btn {
  background: #6c757d;
  color: white;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
  text-decoration: none;
  display: inline-block;
}

.btn-save {
  background: #0d6efd;
  color: white;
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
}
.popup-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.5);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.popup-box {
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  width: 350px;
  max-width: 90%;
  text-align: center;
}

.popup-box h3 {
  margin: 15px 0 10px;
}

.popup-actions {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
}

.popup-actions .btn-cancel,
.popup-actions .btn-save {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
}

.popup-actions .btn-cancel {
  background: #ccc;
}

.popup-actions .btn-save {
  background: #0d6efd;
  color: white;
}

.popup-box .close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 18px;
  cursor: pointer;
}

/* ✅ Dynamic Display Rules for Each Popup */
<?php
$query = mysqli_query($conn, "SELECT id FROM users");
while ($row = mysqli_fetch_assoc($query)) {
    echo "#confirm-delete-{$row['id']}:checked ~ .popup-overlay-{$row['id']} { display: flex; }\n";
}
?>

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

    <main class="main-content">
      <div class="account-header">
        <h2>Account</h2>
        <label for="popup-toggle" class="btn-add">+ Add New Member</label>
      </div>

      <div class="tabs">
        <a href="?role=Customers" class="<?= (!isset($_GET['role']) || $_GET['role'] == 'Customers') ? 'active' : '' ?>">Customers</a>
        <a href="?role=Sellers" class="<?= (isset($_GET['role']) && $_GET['role'] == 'Sellers') ? 'active' : '' ?>">Sellers</a>
      </div>

      <?php
      $role = $_GET['role'] ?? 'Customers';
      $query = mysqli_query($conn, "SELECT * FROM users WHERE role='$role'");
      ?>

<h3><?= mysqli_num_rows($query); ?> Users</h3>
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
          <td style="color: <?= $row['status'] == 'Verified' ? 'green' : 'red'; ?>">
            <?= $row['status'] ?>
          </td>
        <?php } else { ?>
          <td><?= $row['phone'] ?></td>
        <?php } ?>
        <td>
          <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">✏️</a>
          <input type="checkbox" id="confirm-delete-<?= $row['id'] ?>" hidden>
          <label for="confirm-delete-<?= $row['id'] ?>" class="btn-delete">🗑️</label>
          <div class="popup-overlay popup-overlay-<?= $row['id'] ?>">
            <div class="popup-box warning">
              <div class="icon">❗</div>
              <h3>WARNING!</h3>
              <p>Are you sure you want to delete <b><?= $row['username'] ?></b>?</p>
              <div class="popup-actions">
                <label for="confirm-delete-<?= $row['id'] ?>" class="btn-cancel">Cancel</label>
                <form method="post" action="delete.php" style="display:inline;">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <button type="submit" class="btn-save">Confirm</button>
                </form>
              </div>
            </div>
          </div>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
      <!-- Trigger -->


<!-- Hidden checkbox to control popup -->
<input type="checkbox" id="popup-toggle" hidden>

<!-- Popup -->
<div class="popup-add">
  <div class="popup-boxx">
    <h3>Add New <?= $role === 'Sellers' ? 'Seller' : 'Customer' ?></h3>
    <form action="add_user.php" method="post">
      <input type="hidden" name="role" value="<?= $role ?>">

      <label>Username</label>
      <input type="text" name="username" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <?php if ($role === 'Sellers') { ?>
        <label>Status</label>
        <select name="status" required>
          <option value="Verified">Verified</option>
          <option value="Unverified">Unverified</option>
        </select>
      <?php } else { ?>
        <label>Phone Number</label>
        <input type="text" name="phone" required>
      <?php } ?>

      <div class="popup-action">
        <label for="popup-toggle" class="btn-cancel">Close</label>
        <button type="submit" class="btn-save">Save</button>
      </div>
    </form>
  </div>
</div>

    </main>
  </div>
</body>
</html>