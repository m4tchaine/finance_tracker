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

// Hitung saldo
$stmt_masuk = mysqli_prepare($conn, "SELECT SUM(jumlah) as total FROM transaksi WHERE user_id=? AND jenis='pemasukan'");
mysqli_stmt_bind_param($stmt_masuk, "i", $user_id);
mysqli_stmt_execute($stmt_masuk);
$dataMasuk = mysqli_stmt_get_result($stmt_masuk)->fetch_assoc();

$stmt_keluar = mysqli_prepare($conn, "SELECT SUM(jumlah) as total FROM transaksi WHERE user_id=? AND jenis='pengeluaran'");
mysqli_stmt_bind_param($stmt_keluar, "i", $user_id);
mysqli_stmt_execute($stmt_keluar);
$dataKeluar = mysqli_stmt_get_result($stmt_keluar)->fetch_assoc();

$totalMasuk = ($dataMasuk && $dataMasuk['total']) ? $dataMasuk['total'] : 0;
$totalKeluar = ($dataKeluar && $dataKeluar['total']) ? $dataKeluar['total'] : 0;
$saldo = $totalMasuk - $totalKeluar;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
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
            <li class="active" onclick="window.location.href='dashboard.php'">🏠 Home</li>
            <li onclick="window.location.href='riwayat.php'">📄 Riwayat</li>
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

            <!-- Card -->
            <div class="cards">
                <div class="saldo">
                    <p>Saldo</p>
                    <h3>Rp. <?php echo number_format($saldo,0,',','.'); ?></h3>
                </div>

                <div class="pemasukan">
                    <p>Pemasukan</p>
                    <h4>+ Rp. <?php echo number_format($totalMasuk,0,',','.'); ?></h4>
                </div>

                <div class="pengeluaran">
                    <p>Pengeluaran</p>
                    <h4>- Rp. <?php echo number_format($totalKeluar,0,',','.'); ?></h4>
                </div>
            </div>

            <!-- Form -->
            <div class="form-box">
                <h4>Tambah Transaksi</h4>
                <form action="tambah.php" method="POST">
                    <input type="number" name="nominal" placeholder="Rp. Masukkan Nominal" required>

                    <select name="tipe">
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>

                    <input type="text" name="keterangan" placeholder="Masukkan Keterangan" required>

                    <input type="date" name="tanggal" required>
                    
                    <button type="submit">Tambah</button>
                </form>
            </div>

            <!-- Tabel -->
            <div class="table-box">
                <h4>Transaksi Terkini</h4>
                <table>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                    </tr>

                    <?php while($row = mysqli_fetch_assoc($query)) { ?>
                    <tr class="<?php echo htmlspecialchars($row['jenis']); ?>">
                        <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                        <td>
                            <?php 
                            if($row['jenis']=="pemasukan"){
                                echo "+ ";
                            } else {
                                echo "- ";
                            }
                            echo number_format($row['jumlah'],0,',','.');
                            ?>
                        </td>
                    </tr>
                    <?php } ?>

                </table>
            </div>

        </div>

    </div>

</div>

</body>
</html>