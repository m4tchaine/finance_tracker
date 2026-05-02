<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";
$username = $_SESSION['username'];
$stmt_user = mysqli_prepare($conn, "SELECT id FROM user WHERE username=?");
mysqli_stmt_bind_param($stmt_user, "s", $username);
mysqli_stmt_execute($stmt_user);
$user_id = mysqli_stmt_get_result($stmt_user)->fetch_assoc()['id'] ?? 0;

// Ambil data transaksi
$stmt = mysqli_prepare($conn, "SELECT * FROM transaksi WHERE user_id=? ORDER BY tanggal DESC");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="riwayat.css">
</head>
<body>

<div class="wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile" onclick="window.location.href='profil.php'" style="cursor: pointer;">
            <img src="profile.jpg">
            <p>Ubah Profil</p>
        </div>

        <ul>
            <li onclick="window.location.href='dashboard.php'">🏠 Home</li>
            <li class="active" onclick="window.location.href='riwayat.php'">📄 Riwayat</li>
            <li onclick="window.location.href='grafik.php'">📊 Grafik</li>
            <li onclick="window.location.href='logout.php'">🚪 Logout</li>
        </ul>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <span class="title" style="color: #ffffff; font-size: 24px; font-weight: bold;">Finance Tracker</span>
            </div>

            <div class="user">
                <span>Hii, <?php echo $_SESSION['username']; ?>!👋🏻</span>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Riwayat Transaksi</h2>

            <div class="card-list">

                <?php while($row = mysqli_fetch_assoc($query)) { ?>
                <div class="card <?php echo htmlspecialchars($row['jenis']); ?>">

                    <!-- Icon -->
                    <div class="icon">
                        <?php echo ($row['jenis'] == 'pemasukan') ? '+' : '-'; ?>
                    </div>

                    <!-- Info -->
                    <div class="info">
                        Rp. <?php echo number_format($row['jumlah'],0,',','.'); ?> 
                        / <?php echo htmlspecialchars($row['keterangan']); ?>
                    </div>

                    <!-- Tanggal + Aksi -->
                    <div class="right-container">
                        <div class="tanggal">
                        <?php echo date("d M", strtotime($row['tanggal'])); ?>
                    </div>

                    <div class="aksi">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="edit">✏️</a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" 
                        class="hapus"
                        onclick="return confirm('Yakin mau hapus transaksi ini?')">🗑️</a>
                    </div>
                </div>

                </div>
                <?php } ?>

            </div>
        </div>

    </div>

</div>

</body>
</html>