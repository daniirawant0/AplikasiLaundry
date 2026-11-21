<?php
session_start();
include('koneksi.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM "user" WHERE username = :username AND password = :password');
    $stmt->execute([':username' => $username, ':password' => $password]);
    $chek = $stmt->rowCount();

    if ($chek > 0) {
        $_SESSION['login'] = true;
        header("location: dashboard.php");
        exit();
    } else {
        header("location: login.php?error=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Sparklee Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <div class="brand">
            <div class="brand-icon">
                <span class="material-symbols-outlined">local_laundry_service</span>
            </div>
            <div class="brand-text">
                <h1>Sparklee Laundry</h1>
                <p>Panel Administrator</p>
            </div>
        </div>

        <h2>Masuk ke Dashboard</h2>
        <p class="subtitle">Masukkan kredensial admin Anda untuk melanjutkan.</p>

        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert-error">
            <span class="material-symbols-outlined">error</span>
            Username atau Password salah. Silakan coba lagi.
        </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" autocomplete="current-password" required>
            </div>
            <button type="submit" name="submit">Masuk</button>
        </form>
        <div class="back-link">
            <a href="../index.php">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</div>
</body>
</html>
