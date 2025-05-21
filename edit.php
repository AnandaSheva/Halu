<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
<script>
  Swal.fire({
    title: 'Success!',
    text: '<?= $_GET['message'] ?? 'Details updated successfully' ?>',
    icon: 'success',
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
</script>
<?php endif; ?>

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
      position: relative;
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
      background: none;
      border: none;
      padding: 0;
      margin-left: 10px;
      vertical-align: middle;
      transition: transform 0.1s;
    }
    .delete-icon:hover {
      transform: scale(1.1);
      background: none;
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

    .modal {
      position: fixed;
      z-index: 2000;
      left: 0; top: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.25);
      display: none;
      align-items: center;
      justify-content: center;
    }
    .modal-content {
      animation: fadeIn .2s;
    }
    @keyframes fadeIn {
      from { transform: translateY(-30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Toggle dropdown menu
    const userInfoToggle = document.getElementById('userInfoToggle');
    const userDropdown = document.getElementById('userDropdown');
    userInfoToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      userDropdown.classList.toggle('show');
    });
    document.addEventListener('click', function() {
      userDropdown.classList.remove('show');
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

    // Delete with confirmation
    document.getElementById('deleteBtn').addEventListener('click', function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Delete Account?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('deleteForm').submit();
        }
      });
    });

    // Ganti script untuk icon edit Details
    document.addEventListener('DOMContentLoaded', function() {
      // Tambahkan id ke icon edit pada bagian Details 
      const cards = document.querySelectorAll('.three-col-grid .card');
      if (cards.length >= 2) {
        // Cari card Details dengan mencari teks "Details" di heading
        cards.forEach(function(card) {
          const heading = card.querySelector('h4');
          if (heading && heading.textContent === 'Details') {
            const editIcon = card.querySelector('.edit-icon');
            if (editIcon) {
              editIcon.id = 'editDetailsBtn';
              editIcon.addEventListener('click', function() {
                document.getElementById('editDetailsModal').style.display = 'flex';
              });
            }
          }
        });
      }
      
      // Pastikan event listener untuk menutup modal sudah ada
      document.getElementById('closeEditDetails').addEventListener('click', function() {
        document.getElementById('editDetailsModal').style.display = 'none';
      });
      
      document.getElementById('cancelEditDetails').addEventListener('click', function() {
        document.getElementById('editDetailsModal').style.display = 'none';
      });
    });
  </script>
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
      <div class="user-info" id="userInfoToggle" style="cursor:pointer;">
        <span class="username">Admin123</span>
        <div class="avatar"></div>
        <span class="dropdown-icon">▼</span>
        <!-- User Dropdown Menu -->
        <div class="user-dropdown" id="userDropdown">
          <a href="#" class="dropdown-item">
            <svg ...></svg>
            Profile
          </a>
          <a href="#" class="dropdown-item logout" id="logoutBtn">
            <svg ...></svg>
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
              <path d="M16 4h2a2 2 0 0 1-2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1-2-2h2"></path>
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
        <button class="delete-icon" id="deleteBtn" title="Delete">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1-2-2h2a2 2 0 0 1-2 2v2"/>
            <line x1="10" y1="11" x2="10" y2="17"/>
            <line x1="14" y1="11" x2="14" y2="17"/>
          </svg>
        </button>
        <form id="deleteForm" method="post" action="delete.php" style="display:none;">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">
          <input type="hidden" name="role" value="<?= $_GET['role'] ?? 'Customers' ?>">
        </form>
      </div>

      <!-- 3 Column Layout -->
      <div class="three-col-grid">
        <!-- Left: Profile -->
        <div class="card">
          <span class="edit-icon">✏️</span>
          <div class="profile-img"></div>
          <h3><?= $data['name'] ?></h3>
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
            <h4>Other Information</h4>
            <div class="info-group">
              <span class="info-label">Account Status:</span>
              <?php 
                $statusClass = '';
                if($data['status'] == 'verified') {
                  $statusClass = 'background-color: #3cd278; color: white;';
                } elseif($data['status'] == 'pending') {
                  $statusClass = 'background-color: #f0c04f; color: white;';
                } elseif($data['status'] == 'rejected') {
                  $statusClass = 'background-color: #f16a6a; color: white;';
                }
              ?>
              <span style="padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: bold; <?= $statusClass ?>">
                <?= ucfirst($data['status']) ?>
              </span>
            </div>
            
            <?php if($data['status'] == 'pending'): ?>
              <div style="margin-top: 15px;">
                <button id="verifyAccountBtn" style="background-color: #3cd278; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">
                  Verify Account
                </button>
              </div>
            <?php endif; ?>
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
          <div class="info-group"><span class="info-label">Name:</span> <?= $data['name'] ?></div>
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

  <!-- Modal Edit Details -->
  <div id="editDetailsModal" class="modal" style="display:none;">
    <div class="modal-content" style="max-width:400px; margin:auto; background:#fff; border-radius:10px; padding:30px; box-shadow:0 4px 20px rgba(0,0,0,0.15); position:relative;">
      <span class="close-modal" id="closeEditDetails" style="position:absolute;top:15px;right:20px;cursor:pointer;font-size:22px;">&times;</span>
      <h3>Edit Details</h3>
      <form id="editDetailsForm" method="post" action="edit_details.php">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="form-group" style="margin-bottom:15px;">
          <label>First Name</label>
          <input type="text" name="first_name" value="<?= htmlspecialchars($data['first_name'] ?? '') ?>" required style="width:100%;padding:8px;">
        </div>
        <div class="form-group" style="margin-bottom:15px;">
          <label>Last Name</label>
          <input type="text" name="last_name" value="<?= htmlspecialchars($data['last_name'] ?? '') ?>" required style="width:100%;padding:8px;">
        </div>
        <div class="form-group" style="margin-bottom:15px;">
          <label>Date of Birth</label>
          <input type="date" name="dob" value="<?= htmlspecialchars($data['dob'] ?? '') ?>" required style="width:100%;padding:8px;">
        </div>
        <div class="form-group" style="margin-bottom:20px;">
          <label>Gender</label>
          <select name="gender" required style="width:100%;padding:8px;">
            <option value="">-- Select --</option>
            <option value="Male" <?= (isset($data['gender']) && $data['gender']=='Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= (isset($data['gender']) && $data['gender']=='Female') ? 'selected' : '' ?>>Female</option>
          </select>
        </div>
        <div style="text-align:right;">
          <button type="button" id="cancelEditDetails" style="margin-right:10px;padding:8px 18px;">Cancel</button>
          <button type="submit" style="background:#0d6efd;color:#fff;padding:8px 18px;border:none;border-radius:4px;">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Add this script at the bottom of the page, before the closing </body> tag -->
  <script>
    // Verify account functionality
    document.addEventListener('DOMContentLoaded', function() {
      const verifyBtn = document.getElementById('verifyAccountBtn');
      
      if(verifyBtn) {
        verifyBtn.addEventListener('click', function() {
          Swal.fire({
            title: 'Verify Account',
            text: "Are you sure you want to verify this account?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3cd278',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, verify it!'
          }).then((result) => {
            if (result.isConfirmed) {
              // Send AJAX request to update status
              fetch('verify_account.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=<?= $data['id'] ?>'
              })
              .then(response => response.json())
              .then(data => {
                if(data.success) {
                  Swal.fire({
                    title: 'Success!',
                    text: 'Account has been verified successfully.',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                  }).then(() => {
                    // Reload the page to show updated status
                    window.location.reload();
                  });
                } else {
                  Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Failed to verify account.',
                    icon: 'error'
                  });
                }
              })
              .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                  title: 'Error!',
                  text: 'An unexpected error occurred.',
                  icon: 'error'
                });
              });
            }
          });
        });
      }
    });
  </script>
</body>
</html>