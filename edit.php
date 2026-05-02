<?php
session_start();
include "koneksi.php";

$id = $_GET['id'];

// ambil data transaksi
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// proses update
if (isset($_POST['update'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($conn, "UPDATE transaksi SET 
        tanggal='$tanggal',
        keterangan='$keterangan',
        jumlah='$jumlah'
        WHERE id='$id'
    ");

    header("Location: riwayat.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Edit Transaksi</h2>

        <form method="POST">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required>

            <label>Keterangan</label>
            <input type="text" name="keterangan" value="<?= $data['keterangan']; ?>" required>

            <label>Nominal</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" required>

            <button type="submit" name="update" class="btn">Update</button>
        </form>

        <a href="riwayat.php" class="cancel">Batal</a>
    </div>
</div>

</body>
</html>