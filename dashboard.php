<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background: #f8f8f8;
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
.main-content {
  flex: 1;
  padding: 20px;
  overflow-y: auto;
}
.cards {
  display: flex;
  gap: 20px;
  margin-bottom: 30px;
}
.card {
  width: 200px;
  padding: 15px;
  display: flex;
  align-items: center;
  gap: 10px;
  border-radius: 10px;
  background: #fff;
  box-shadow: 0 1px 5px rgba(0,0,0,0.05);
  font-size: 14px;
}
.card.yellow {
  background: #fff4cc;
}
.card.green {
  background: #d6f5d6;
}
.chart-section {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
}
.chart-img {
  width: 100%;
  height: auto;
  margin-top: 10px;
  border: 1px dashed #ccc;
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
<!-- Header -->
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

    <!-- Main content -->
    <main class="main-content">
      <!-- Cards -->
      <section class="cards">
        <div class="card yellow">
          <div class="icon">💳</div>
          <div>
            <h3>20</h3>
            <p>Successful Payment</p>
          </div>
        </div>
        <div class="card green">
          <div class="icon">❌</div>
          <div>
            <h3>15</h3>
            <p>Not Pay Yet</p>
          </div>
        </div>
      </section>

      <!-- Chart -->
      <section class="chart-section">
        <h3>Sales Statistics</h3>
        <img src="stastistik.png" alt="Sales Chart" class="chart-img">
      </section>
    </main>
  </div>
</body>
</html>