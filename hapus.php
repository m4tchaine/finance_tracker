<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
$id = $_GET['id'];
$username = $_SESSION['username'];
$stmt_user = mysqli_prepare($conn, "SELECT id FROM user WHERE username=?");
mysqli_stmt_bind_param($stmt_user, "s", $username);
mysqli_stmt_execute($stmt_user);
$user_id = mysqli_stmt_get_result($stmt_user)->fetch_assoc()['id'] ?? 0;

$stmt = mysqli_prepare($conn, "DELETE FROM transaksi WHERE id=? AND user_id=?");
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);

header("Location: dashboard.php");
exit;
?>