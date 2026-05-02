<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$username_lama = $_SESSION['username'];
$username_baru = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username_baru)) {
    header("Location: profil.php");
    exit;
}

// Gunakan transaksi SQL agar kedua tabel atomic
mysqli_begin_transaction($conn);

try {
    // 1. Update Username di tabel transaksi (karena ini key penghubung)
    $stmt_trx = mysqli_prepare($conn, "UPDATE transaksi SET username=? WHERE username=?");
    mysqli_stmt_bind_param($stmt_trx, "ss", $username_baru, $username_lama);
    mysqli_stmt_execute($stmt_trx);

    // 2. Update user
    $stmt_user = mysqli_prepare($conn, "UPDATE user SET username=?, password=? WHERE username=?");
    mysqli_stmt_bind_param($stmt_user, "sss", $username_baru, $password, $username_lama);
    mysqli_stmt_execute($stmt_user);

    mysqli_commit($conn);
    $_SESSION['username'] = $username_baru;
} catch (Exception $e) {
    mysqli_rollback($conn);
}

header("Location: profil.php");
exit;
?>