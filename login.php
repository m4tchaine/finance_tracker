<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Finance Tracker</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="container">

    <div class="login-card">

        <!-- Logo -->
        <div class="logo">
            <img src="logo.png" alt="logo">
        </div>

        <!-- Title -->
        <h3>LOGIN</h3>
        <h2>Finance Tracker</h2>

        <?php if(isset($_GET['error']) && $_GET['error'] == 'notfound'): ?>
            <p style="color: red; text-align: center; margin-bottom: 15px; font-size: 14px;">Username atau Password salah!</p>
        <?php endif; ?>

        <!-- Form -->
        <form action="proses_login.php" method="POST">

            <label>Username</label>
            <div class="input-group">
                <span>👤</span>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <label>Password</label>
            <div class="input-group">
                <span>🔒</span>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">Login</button>

        </form>

    </div>

</div>

</body>
</html>