<?php
$conn = mysqli_connect("localhost", "root", "", "finance_tracker");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>