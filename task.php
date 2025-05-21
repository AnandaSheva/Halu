<?php
session_start(); // Add session start
include 'koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Get tasks from database
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM tasks WHERE created_by = $admin_id ORDER BY due_date ASC, due_time ASC";
$result = mysqli_query($conn, $sql);
$tasks = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        /* Alert Styles */
.alert {
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
        /* Modal Styles */
.modal {
    position: fixed;
    z-index: 1100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    margin: auto;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    width: 500px;
    max-width: 90%;
    position: relative;
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #6c757d;
}

.close-modal:hover {
    color: #212529;
}

.modal h2 {
    margin-top: 0;
    margin-bottom: 20px;
    color: #212529;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #495057;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-family: inherit;
    font-size: 14px;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #0d6efd;
    outline: none;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.25);
}

.form-row {
    display: flex;
    gap: 15px;
}

.form-group.half {
    width: 50%;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 25px;
}

.btn-submit {
    background-color: #0d6efd;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-submit:hover {
    background-color: #0b5ed7;
}

.btn-cancel {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background-color: #5c636a;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-delete:hover {
    background-color: #c82333;
}

.delete-confirm {
    text-align: center;
    max-width: 400px;
}

.delete-confirm p {
    margin-bottom: 20px;
    color: #495057;
}

.delete-confirm .form-actions {
    justify-content: center;
}

/* Task status styles */
.task-status {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 12px;
}

.status-pending {
    background-color: #ffc10726;
    color: #ffc107;
    border: 1px solid #ffc107;
}

.status-completed {
    background-color: #28a7451a;
    color: #28a745;
    border: 1px solid #28a745;
}

.status-cancelled {
    background-color: #6c757d1a;
    color: #6c757d;
    border: 1px solid #6c757d;
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
            position: relative;
        }

        .notification-icon {
            font-size: 20px;
            color: #6c757d;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
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

        /* User Dropdown Menu Styles */
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
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 0; /* margin bawah tidak perlu lagi */
            float: none; /* Hapus float: right; */
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
        
        .task-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px; /* jarak ke bawah */
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <div class="user-info" id="userInfoToggle">
                <span class="username"><?= htmlspecialchars($_SESSION['admin_name']) ?></span>
                <div class="avatar"></div>
                <span class="dropdown-icon">▼</span>
                
                <!-- User Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown">
                    <a href="#" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Profile
                    </a>
                    <a href="#" class="dropdown-item logout" id="logoutBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </a>
                </div>
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
            <div class="task-header">
                <h1 class="page-title">All Tasks</h1>
                <button class="add-task-btn" id="addTaskBtn" type="button">
                    <i class="fas fa-plus"></i>
                    Add New Task
                </button>
            </div>
            
            <!-- Display notification message if any -->
            <?php if (isset($_SESSION['task_message'])): ?>
                <div class="alert alert-<?= $_SESSION['task_message']['type'] ?>">
                    <?= $_SESSION['task_message']['text'] ?>
                </div>
                <?php unset($_SESSION['task_message']); ?>
            <?php endif; ?>
            
            <!-- Tasks Container -->
            <div class="tasks-container">
                <?php if (count($tasks) > 0): ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php 
                            // Calculate countdown
                            $now = new DateTime();
                            $dueDateTime = new DateTime($task['due_date'] . ' ' . $task['due_time']);
                            $interval = $now->diff($dueDateTime);
                            
                            $countdown = '';
                            if ($dueDateTime < $now) {
                                $countdown = "OVERDUE";
                            } else {
                                if ($interval->days > 0) {
                                    $countdown .= $interval->days . " DAYS, ";
                                }
                                $countdown .= $interval->h . " HOURS, ";
                                $countdown .= $interval->i . " MINUTES";
                            }
                            
                            $statusClass = "status-" . $task['status'];
                        ?>
                        <div class="task-card">
                            <h2 class="task-title"><?= htmlspecialchars($task['title']) ?></h2>
                            <div class="task-status <?= $statusClass ?>"><?= ucfirst($task['status']) ?></div>
                            <div class="task-countdown"><?= $countdown ?></div>
                            <p class="task-description"><?= htmlspecialchars($task['description']) ?></p>
                            <div class="task-meta">Due date: <?= date('d F, Y', strtotime($task['due_date'])) ?></div>
                            <div class="task-meta">Time: <?= date('h:i A', strtotime($task['due_time'])) ?></div>
                            <div class="task-actions">
                                <div class="task-action-btn edit-btn" data-id="<?= $task['id'] ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                                <div class="task-action-btn delete-btn" data-id="<?= $task['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Empty Task Card -->
                    <div class="task-card empty-task" id="emptyTaskCard">
                        <i class="fas fa-plus"></i> Add New Task
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div id="taskModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 id="modalTitle">Add New Task</h2>
            <form id="taskForm" method="post" action="add_task.php">
                <input type="hidden" id="task_id" name="task_id" value="">
                <input type="hidden" name="action" id="form_action" value="add">
                
                <div class="form-group">
                    <label for="title">Title*</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group half">
                        <label for="due_date">Due Date*</label>
                        <input type="date" id="due_date" name="due_date" required>
                    </div>
                    
                    <div class="form-group half">
                        <label for="due_time">Due Time*</label>
                        <input type="time" id="due_time" name="due_time" required>
                    </div>
                </div>
                
                <div class="form-group" id="statusGroup" style="display: none;">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-submit">Save Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal" style="display: none;">
        <div class="modal-content delete-confirm">
            <h2>Delete Task</h2>
            <p>Are you sure you want to delete this task? This action cannot be undone.</p>
            <div class="form-actions">
                <button type="button" class="btn-cancel">Cancel</button>
                <form method="post" action="add_task.php" id="deleteForm">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" id="delete_task_id" name="task_id" value="">
                    <button type="submit" class="btn-delete">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add JavaScript at the end of the body -->
    <script>
        // Toggle dropdown menu
        const userInfoToggle = document.getElementById('userInfoToggle');
        const userDropdown = document.getElementById('userDropdown');
        
        userInfoToggle.addEventListener('click', function(e) {
          e.stopPropagation();
          userDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
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

        // Get DOM elements
        const addTaskBtn = document.getElementById('addTaskBtn');
        const emptyTaskCard = document.getElementById('emptyTaskCard');
        const taskModal = document.getElementById('taskModal');
        const deleteModal = document.getElementById('deleteModal');
        const closeModal = document.querySelector('.close-modal');
        const cancelBtns = document.querySelectorAll('.btn-cancel');
        const taskForm = document.getElementById('taskForm');
        const modalTitle = document.getElementById('modalTitle');
        const formAction = document.getElementById('form_action');
        const taskIdField = document.getElementById('task_id');
        const deleteTaskIdField = document.getElementById('delete_task_id');
        const statusGroup = document.getElementById('statusGroup');
        
        // Set default due date to today
        document.getElementById('due_date').valueAsDate = new Date();
        
        // Add event listeners
        addTaskBtn.addEventListener('click', openAddTaskModal);
        if (emptyTaskCard) {
            emptyTaskCard.addEventListener('click', openAddTaskModal);
        }
        
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-id');
                openEditTaskModal(taskId);
            });
        });
        
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const taskId = this.getAttribute('data-id');
                openDeleteModal(taskId);
            });
        });
        
        closeModal.addEventListener('click', closeModals);
        cancelBtns.forEach(btn => {
            btn.addEventListener('click', closeModals);
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === taskModal) {
                closeModals();
            }
            if (event.target === deleteModal) {
                closeModals();
            }
        });
        
        // Functions
        function openAddTaskModal() {
            modalTitle.textContent = 'Add New Task';
            formAction.value = 'add';
            statusGroup.style.display = 'none';
            taskForm.reset();
            document.getElementById('due_date').valueAsDate = new Date();
            taskModal.style.display = 'flex';
        }
        
        function openEditTaskModal(taskId) {
            modalTitle.textContent = 'Edit Task';
            formAction.value = 'edit';
            statusGroup.style.display = 'block';
            
            // Fetch task data
            fetch(`add_task.php?action=get_task&id=${taskId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const task = data.data;
                        taskIdField.value = task.id;
                        document.getElementById('title').value = task.title;
                        document.getElementById('description').value = task.description;
                        document.getElementById('due_date').value = task.due_date;
                        document.getElementById('due_time').value = task.due_time;
                        document.getElementById('status').value = task.status;
                        taskModal.style.display = 'flex';
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Could not load task data',
                            icon: 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while fetching task data',
                        icon: 'error'
                    });
                });
        }
        
        function openDeleteModal(taskId) {
            deleteTaskIdField.value = taskId;
            deleteModal.style.display = 'flex';
        }
        
        function closeModals() {
            taskModal.style.display = 'none';
            deleteModal.style.display = 'none';
        }
        
        // Add SweetAlert for notification messages
        <?php if (isset($_SESSION['task_message'])): ?>
        Swal.fire({
            title: '<?= $_SESSION['task_message']['type'] === 'success' ? 'Success' : 'Error' ?>',
            text: '<?= $_SESSION['task_message']['text'] ?>',
            icon: '<?= $_SESSION['task_message']['type'] ?>',
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end',
            showConfirmButton: false
        });
        <?php unset($_SESSION['task_message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>