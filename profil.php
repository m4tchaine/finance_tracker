<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$username = $_SESSION['username'];

// ambil data user
$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username=?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$user = mysqli_stmt_get_result($stmt)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>

<div class="wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile-side" onclick="window.location.href='profil.php'" style="cursor: pointer;">
            <img src="profile.jpg">
            <p>Ubah Profil</p>
        </div>

        <ul>
            <li onclick="window.location.href='dashboard.php'">🏠 Home</li>
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

        <div class="content">
            <h2>Profil</h2> 

            <div class="card">
                <div class="avatar-wrapper">
                    <div class="avatar-circle">
                        <img src="profile.jpg" id="foto-profil">
                    </div>
                </div>

                <div class="card-header">
                    <h3>Edit profil</h3>
                </div>
                <form action="update_profil.php" method="POST" enctype="multipart/form-data">
                    </form>

            <form action="update_profil.php" method="POST" enctype="multipart/form-data">
                <div class="input-box">
                    <span>👤</span>
                    <input type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="Username">
                </div>

                <div class="input-box">
                    <span>🔒</span>
                    <input type="text" name="password" value="<?php echo $user['password']; ?>" placeholder="Password">
                </div>
    
                <button type="submit" class="btn-simpan">Simpan</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>