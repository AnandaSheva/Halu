<?php
include 'koneksi.php';

$id = $_POST['id'] ?? '';
$role = $_POST['role'] ?? 'Customers';

if ($id) {
    $query = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        // Reset ID agar berurutan kembali
        mysqli_query($conn, "SET @num := 0");
        mysqli_query($conn, "UPDATE users SET id = @num := @num + 1 ORDER BY id");
        mysqli_query($conn, "ALTER TABLE users AUTO_INCREMENT = 1");

        // Redirect ke account.php setelah hapus
        header("Location: account.php?role=$role");
        exit();
    } else {
        echo "Gagal menghapus user: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
