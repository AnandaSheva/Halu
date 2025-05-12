<?php
include 'koneksi.php';

$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];

if ($role === 'Sellers') {
    $status = $_POST['status'];
    $query = "INSERT INTO users (username, email, role, status) VALUES ('$username', '$email', '$role', '$status')";
} else {
    $phone = $_POST['phone'];
    $query = "INSERT INTO users (username, email, role, phone) VALUES ('$username', '$email', '$role', '$phone')";
}

if (mysqli_query($conn, $query)) {
    header("Location: account.php?role=$role");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>