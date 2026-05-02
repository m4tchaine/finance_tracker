<?php
session_start();
include "koneksi.php";

$username = $_SESSION['username'];

// ambil user_id
$stmt = mysqli_prepare($conn, "SELECT id FROM user WHERE username=?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$user = mysqli_stmt_get_result($stmt)->fetch_assoc();
$user_id = $user['id'];

// ambil data dari form
$jumlah = $_POST['nominal'];
$jenis = $_POST['tipe'];
$keterangan = $_POST['keterangan'];
$tanggal = $_POST['tanggal'];

// simpan ke database
$stmt = mysqli_prepare($conn, "INSERT INTO transaksi (user_id, jumlah, jenis, keterangan, tanggal) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "iisss", $user_id, $jumlah, $jenis, $keterangan, $tanggal);
mysqli_stmt_execute($stmt);

// balik ke dashboard
header("Location: dashboard.php");