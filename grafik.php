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

// Ambil data per bulan
$stmt = mysqli_prepare($conn, "
SELECT 
    MONTH(tanggal) as bulan,
    SUM(CASE WHEN jenis='pemasukan' THEN jumlah ELSE 0 END) as pemasukan,
    SUM(CASE WHEN jenis='pengeluaran' THEN jumlah ELSE 0 END) as pengeluaran
FROM transaksi
WHERE user_id = ? AND YEAR(tanggal) = YEAR(CURDATE())
GROUP BY MONTH(tanggal)
");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);

$pemasukan = array_fill(0, 12, 0);
$pengeluaran = array_fill(0, 12, 0);

while($d = mysqli_fetch_assoc($data)){
    $idx = $d['bulan'] - 1; // 0-based for JS array
    $pemasukan[$idx] = $d['pemasukan'];
    $pengeluaran[$idx] = $d['pengeluaran'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik</title>
    <link rel="stylesheet" href="grafik.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li onclick="window.location.href='riwayat.php'">📄 Riwayat</li>
            <li class="active" onclick="window.location.href='grafik.php'">📊 Grafik</li>
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
            <h2>Grafik</h2>

            <div class="chart-box">
                <canvas id="myChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
            {
                label: 'Pemasukan',
                data: <?php echo json_encode($pemasukan); ?>,
                borderColor: 'green',
                backgroundColor: 'transparent',
                tension: 0.4
            },
            {
                label: 'Pengeluaran',
                data: <?php echo json_encode($pengeluaran); ?>,
                borderColor: 'red',
                backgroundColor: 'transparent',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>

</body>
</html>