<?php
session_start();
include 'koneksi.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$response = [
    'success' => false,
    'message' => '',
    'data' => null
];

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Add new task
    if ($action === 'add') {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
        $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
        $due_time = mysqli_real_escape_string($conn, $_POST['due_time']);
        $admin_id = $_SESSION['admin_id'];
        
        $sql = "INSERT INTO tasks (title, description, due_date, due_time, created_by) 
                VALUES ('$title', '$description', '$due_date', '$due_time', '$admin_id')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['task_message'] = [
                'type' => 'success',
                'text' => 'Task added successfully!'
            ];
        } else {
            $_SESSION['task_message'] = [
                'type' => 'error',
                'text' => 'Error: ' . mysqli_error($conn)
            ];
        }
        
        header('Location: task.php');
        exit;
    }
    
    // Update existing task
    else if ($action === 'edit') {
        $task_id = (int)$_POST['task_id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description'] ?? '');
        $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
        $due_time = mysqli_real_escape_string($conn, $_POST['due_time']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        $sql = "UPDATE tasks 
                SET title = '$title', description = '$description', 
                    due_date = '$due_date', due_time = '$due_time', 
                    status = '$status'
                WHERE id = $task_id AND created_by = {$_SESSION['admin_id']}";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['task_message'] = [
                'type' => 'success',
                'text' => 'Task updated successfully!'
            ];
        } else {
            $_SESSION['task_message'] = [
                'type' => 'error',
                'text' => 'Error: ' . mysqli_error($conn)
            ];
        }
        
        header('Location: task.php');
        exit;
    }
    
    // Delete task
    else if ($action === 'delete') {
        $task_id = (int)$_POST['task_id'];
        
        // Begin transaction
        mysqli_begin_transaction($conn);
        
        try {
            // 1. Delete the task
            $sql = "DELETE FROM tasks WHERE id = $task_id AND created_by = {$_SESSION['admin_id']}";
            
            if (!mysqli_query($conn, $sql)) {
                throw new Exception(mysqli_error($conn));
            }
            
            // 2. Get the affected rows
            $affected = mysqli_affected_rows($conn);
            
            if ($affected > 0) {
                // 3. Reorder the IDs for remaining tasks - update all tasks with higher IDs
                $sql_reorder = "SET @count = 0;
                                UPDATE tasks SET id = @count:= @count + 1 
                                ORDER BY created_at, due_date, due_time;
                                ALTER TABLE tasks AUTO_INCREMENT = 1;";
                
                // Execute multiple queries
                if (mysqli_multi_query($conn, $sql_reorder)) {
                    // Clear results to allow next query
                    do {
                        if ($result = mysqli_store_result($conn)) {
                            mysqli_free_result($result);
                        }
                    } while (mysqli_next_result($conn));
                } else {
                    throw new Exception(mysqli_error($conn));
                }
                
                // All good, commit the transaction
                mysqli_commit($conn);
                
                $_SESSION['task_message'] = [
                    'type' => 'success',
                    'text' => 'Task deleted successfully and IDs reordered!'
                ];
            } else {
                throw new Exception('No task found to delete.');
            }
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            mysqli_rollback($conn);
            
            $_SESSION['task_message'] = [
                'type' => 'error',
                'text' => 'Error: ' . $e->getMessage()
            ];
        }
        
        header('Location: task.php');
        exit;
    }
}

// Handle AJAX GET request for editing
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_task') {
    $task_id = (int)$_GET['id'];
    
    $sql = "SELECT * FROM tasks WHERE id = $task_id AND created_by = {$_SESSION['admin_id']}";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $task = mysqli_fetch_assoc($result);
        $response = [
            'success' => true,
            'data' => $task
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Task not found'
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If we get here, something went wrong
header('Location: task.php');
exit;