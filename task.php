<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Task Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        /* Task specific styles */
        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #212529;
        }
        
        .add-task-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            float: right;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .add-task-btn:hover {
            background-color: #0b5ed7;
        }
        
        .add-task-btn i {
            margin-right: 8px;
        }
        
        .tasks-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 60px;
            gap: 20px;
        }
        
        .task-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: calc(33.33% - 14px);
            padding: 20px;
            position: relative;
            transition: all 0.2s ease;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .task-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #212529;
        }
        
        .task-countdown {
            color: #dc3545;
            font-size: 12px;
            margin-bottom: 15px;
            font-weight: 500;
        }
        
        .task-description {
            font-size: 14px;
            margin-bottom: 20px;
            color: #495057;
        }
        
        .task-meta {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 5px;
        }
        
        .task-actions {
            position: absolute;
            bottom: 20px;
            right: 20px;
            display: flex;
        }
        
        .task-action-btn {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .edit-btn {
            background-color: #0d6efd;
            color: white;
        }
        
        .edit-btn:hover {
            background-color: #0b5ed7;
        }
        
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #c82333;
        }
        
        .empty-task {
            border: 2px dashed #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .empty-task:hover {
            border-color: #0d6efd;
            color: #0d6efd;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        
        .page-item {
            width: 36px;
            height: 36px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            cursor: pointer;
            font-weight: 500;
            border: 1px solid #dee2e6;
            color: #495057;
            transition: all 0.2s ease;
        }
        
        .page-item.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        
        .page-item:hover:not(.active) {
            background-color: #e9ecef;
        }
        
        .page-item.next {
            font-weight: bold;
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .task-card {
                width: calc(50% - 10px);
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            
            .main-content {
                margin-left: 200px;
            }
            
            .task-card {
                width: 100%;
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
    
    <!-- Main Container -->
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
            <h1 class="page-title">All Tasks</h1>
            <button class="add-task-btn">
                <i class="fas fa-plus"></i>
                Add New Task
            </button>
            
            <!-- Tasks Container -->
            <div class="tasks-container">
                <!-- Task Card 1 -->
                <div class="task-card">
                    <h2 class="task-title">Meeting With Boss</h2>
                    <div class="task-countdown">2 DAYS, 3 HOURS, 2 MINUTES, 20 SECONDS</div>
                    <p class="task-description">Membahas tentang statistik penjualan</p>
                    <div class="task-meta">Due date: 30 November, 2025</div>
                    <div class="task-meta">Time: 07.00 AM</div>
                    <div class="task-actions">
                        <div class="task-action-btn edit-btn">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="task-action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Task Card 2 -->
                <div class="task-card">
                    <h2 class="task-title">Meeting With Agent</h2>
                    <div class="task-countdown">2 DAYS, 3 HOURS, 2 MINUTES, 20 SECONDS</div>
                    <p class="task-description">Membahasaan tentang pembayaran</p>
                    <div class="task-meta">Due date: 30 November, 2025</div>
                    <div class="task-meta">Time: 07.00 AM</div>
                    <div class="task-actions">
                        <div class="task-action-btn edit-btn">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="task-action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Task Card 3 -->
                <div class="task-card">
                    <h2 class="task-title">Meeting With Boss</h2>
                    <div class="task-countdown">2 DAYS, 3 HOURS, 2 MINUTES, 20 SECONDS</div>
                    <p class="task-description">Membahas tentang pendapatan bulan ini</p>
                    <div class="task-meta">Due date: 30 November, 2025</div>
                    <div class="task-meta">Time: 07.00 AM</div>
                    <div class="task-actions">
                        <div class="task-action-btn edit-btn">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="task-action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Task Card 4 -->
                <div class="task-card">
                    <h2 class="task-title">Meeting With Boss</h2>
                    <div class="task-countdown">2 DAYS, 3 HOURS, 2 MINUTES, 20 SECONDS</div>
                    <p class="task-description">Membahas tentang statistik penjualan</p>
                    <div class="task-meta">Due date: 30 November, 2025</div>
                    <div class="task-meta">Time: 07.00 AM</div>
                    <div class="task-actions">
                        <div class="task-action-btn edit-btn">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="task-action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Task Card 5 -->
                <div class="task-card">
                    <h2 class="task-title">Meeting With Agent</h2>
                    <div class="task-countdown">2 DAYS, 3 HOURS, 2 MINUTES, 20 SECONDS</div>
                    <p class="task-description">Membahasaan tentang pembayaran</p>
                    <div class="task-meta">Due date: 30 November, 2025</div>
                    <div class="task-meta">Time: 07.00 AM</div>
                    <div class="task-actions">
                        <div class="task-action-btn edit-btn">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <div class="task-action-btn delete-btn">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Empty Task Card -->
                <div class="task-card empty-task">
                    Add New Task
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item next">»</div>
            </div>
        </div>
    </div>
</body>
</html>