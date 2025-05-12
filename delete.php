<?php
include 'koneksi.php';

$id = $_POST['id'] ?? '';

if ($id) {
    $query = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: account.php");
        exit();
    } else {
        echo "Gagal menghapus user: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan!";
}
?>
