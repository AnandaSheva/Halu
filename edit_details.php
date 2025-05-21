<?php
include 'koneksi.php';
$id = $_POST['id'] ?? '';
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$dob = $_POST['dob'] ?? '';
$gender = $_POST['gender'] ?? '';

$first_name = mysqli_real_escape_string($conn, $first_name);
$last_name = mysqli_real_escape_string($conn, $last_name);
$dob = mysqli_real_escape_string($conn, $dob);
$gender = mysqli_real_escape_string($conn, $gender);

if ($id) {
    mysqli_query($conn, "UPDATE users SET first_name='$first_name', last_name='$last_name', dob='$dob', gender='$gender' WHERE id='$id'");
    // Tampilkan pesan sukses di halaman edit.php
    header("Location: edit.php?id=$id&status=success&message=Details+updated+successfully");
    exit;
} else {
    // Tampilkan pesan error di halaman edit.php
    header("Location: edit.php?id=$id&status=error&message=Failed+to+update+details");
    exit;
}
?>