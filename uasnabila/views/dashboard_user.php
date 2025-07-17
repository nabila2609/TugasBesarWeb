<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 'user') {
    header("Location: ../login.php");
    exit();
}
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Nabila Catering</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_user.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="paket.php">Lihat Paket</a></li>
                <li class="nav-item"><a class="nav-link" href="reservasi.php">Reservasi Saya</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <h2>Selamat datang, <?php echo $_SESSION['nama']; ?></h2>
    <p>Silakan pilih menu di atas untuk melakukan reservasi atau melihat paket catering.</p>
</div>
</body>
</html>