<?php
include 'koneksi.php';

$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];

// Mapping role dari form ke database
$db_role = $role;
if ($role === 'Customers') $db_role = 'user';
if ($role === 'Sellers') $db_role = 'provider';
wadwda
// Escape inputs
$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);

// Password
$password = md5($username);

// Cek email sudah ada
$check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
if (mysqli_num_rows($check_email) > 0) {
    die("Error: Email already exists. <a href='account.php?role=$role'>Go back</a>");
}

if ($role === 'Sellers') {
    $status = $_POST['status'];
    $status = mysqli_real_escape_string($conn, $status);
    $query = "INSERT INTO users (name, email, role, status, password) 
              VALUES ('$username', '$email', '$db_role', '$status', '$password')";
} else {
    $phone = $_POST['phone'];
    $phone = mysqli_real_escape_string($conn, $phone);
    $query = "INSERT INTO users (name, email, role, phone, password) 
              VALUES ('$username', '$email', '$db_role', '$phone', '$password')";
}

if (mysqli_query($conn, $query)) {
    header("Location: account.php?role=$role");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>