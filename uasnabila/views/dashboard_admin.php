<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Nabila Catering</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="paket.php">Kelola Paket</a></li>
                <li class="nav-item"><a class="nav-link" href="kelola_reservasi.php">Kelola Reservasi</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <h2>Selamat datang, <?php echo $_SESSION['nama']; ?></h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Paket</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $query = "SELECT COUNT(*) as total FROM nabila_paket";
                        $result = $koneksi->query($query);
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Reservasi Baru</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $query = "SELECT COUNT(*) as total FROM nabila_reservasi WHERE status = 'menunggu'";
                        $result = $koneksi->query($query);
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total User</div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?php
                        $query = "SELECT COUNT(*) as total FROM nabila_users WHERE level = 'user'";
                        $result = $koneksi->query($query);
                        $row = $result->fetch_assoc();
                        echo $row['total'];
                        ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>