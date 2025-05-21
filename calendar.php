<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Calendar</title>
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

        /* Calendar styles */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .calendar-title {
            font-size: 24px;
            color: #0d6efd;
            font-weight: 600;
        }
        
        .calendar-controls {
            display: flex;
            align-items: center;
        }
        
        .view-toggle {
            display: flex;
            margin-right: 20px;
        }
        
        .view-toggle button {
            padding: 8px 15px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #666;
        }
        
        .view-toggle button.active {
            font-weight: bold;
            color: #333;
        }
        
        .month-nav {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .month-nav button {
            background: none;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .current-month {
            padding: 8px 15px;
            font-weight: 500;
        }
        
        .calendar-grid {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 8px;
        }
        
        .calendar-grid th {
            padding: 15px;
            text-align: center;
            font-weight: 500;
            color: #333;
            border: 1px solid #e9ecef;
        }
        
        .calendar-grid td {
            height: 100px;
            border: 1px solid #e9ecef;
            vertical-align: top;
            padding: 5px;
        }
        
        .date-number {
            font-size: 18px;
            font-weight: 500;
            text-align: center;
            padding: 5px;
        }
        
        .next-month {
            background-color: #f8f9fa;
            color: #aaa;
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
        <main class="main-content">
            <h1 style="margin-bottom: 30px; font-size: 24px; font-weight: 600;">Calendar</h1>
            
            <div class="calendar-header">
                <div class="calendar-title">November 2018</div>
                
                <div class="calendar-controls">
                    <div class="view-toggle">
                        <button class="active">Month</button>
                        <button>Year</button>
                    </div>
                    
                    <div class="month-nav">
                        <button>&laquo;</button>
                        <div class="current-month">November</div>
                        <button>&raquo;</button>
                    </div>
                </div>
            </div>
            
            <table class="calendar-grid">
                <thead>
                    <tr>
                        <th>Sunday</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>
                            <div class="date-number">01</div>
                        </td>
                        <td>
                            <div class="date-number">02</div>
                        </td>
                        <td>
                            <div class="date-number">03</div>
                        </td>
                        <td>
                            <div class="date-number">04</div>
                        </td>
                        <td>
                            <div class="date-number">05</div>
                        </td>
                        <td>
                            <div class="date-number">06</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date-number">07</div>
                        </td>
                        <td>
                            <div class="date-number">08</div>
                        </td>
                        <td>
                            <div class="date-number">09</div>
                        </td>
                        <td>
                            <div class="date-number">10</div>
                        </td>
                        <td>
                            <div class="date-number">11</div>
                        </td>
                        <td>
                            <div class="date-number">12</div>
                        </td>
                        <td>
                            <div class="date-number">13</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date-number">14</div>
                        </td>
                        <td>
                            <div class="date-number">15</div>
                        </td>
                        <td>
                            <div class="date-number">16</div>
                        </td>
                        <td>
                            <div class="date-number">17</div>
                        </td>
                        <td>
                            <div class="date-number">18</div>
                        </td>
                        <td>
                            <div class="date-number">19</div>
                        </td>
                        <td>
                            <div class="date-number">20</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date-number">21</div>
                        </td>
                        <td>
                            <div class="date-number">22</div>
                        </td>
                        <td>
                            <div class="date-number">23</div>
                        </td>
                        <td>
                            <div class="date-number">24</div>
                        </td>
                        <td>
                            <div class="date-number">25</div>
                        </td>
                        <td>
                            <div class="date-number">26</div>
                        </td>
                        <td>
                            <div class="date-number">27</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date-number">28</div>
                        </td>
                        <td>
                            <div class="date-number">29</div>
                        </td>
                        <td>
                            <div class="date-number">30</div>
                        </td>
                        <td class="next-month">
                            <div class="date-number">01</div>
                        </td>
                        <td class="next-month">
                            <div class="date-number">02</div>
                        </td>
                        <td class="next-month">
                            <div class="date-number">03</div>
                        </td>
                        <td class="next-month">
                            <div class="date-number">04</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="next-month">
                            <div class="date-number">05</div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>