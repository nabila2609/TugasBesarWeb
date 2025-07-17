<?php
session_start();
include '../config/koneksi.php';

// Proses tambah paket (khusus admin)
if (isset($_POST['tambah_paket']) && isset($_SESSION['level']) && $_SESSION['level'] == 'admin') {
    $nama_paket = $_POST['nama_paket'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $min_tamu = $_POST['min_tamu'];
    $max_tamu = $_POST['max_tamu'];
    $photo = null;

    // Upload foto jika ada
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo = uniqid('paket_') . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], "../uploads/" . $photo);
    }

    $stmt = $koneksi->prepare("INSERT INTO nabila_paket (nama_paket, deskripsi, harga, min_tamu, max_tamu, photo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiis", $nama_paket, $deskripsi, $harga, $min_tamu, $max_tamu, $photo);
    $stmt->execute();
    $sukses = "Paket berhasil ditambahkan!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Paket Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Paket Catering</h2>
    <?php if (isset($sukses)): ?>
        <div class="alert alert-success"><?php echo $sukses; ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin'): ?>
    <!-- Form tambah paket hanya untuk admin -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Paket Baru</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Minimal Tamu</label>
                    <input type="number" name="min_tamu" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Maksimal Tamu</label>
                    <input type="number" name="max_tamu" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Paket</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <button type="submit" name="tambah_paket" class="btn btn-success">Tambah Paket</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <?php
        $query = "SELECT * FROM nabila_paket";
        $result = $koneksi->query($query);
        while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <?php if (!empty($row['photo'])): ?>
                    <img src="../uploads/<?php echo $row['photo']; ?>" class="card-img-top" alt="Foto Paket">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nama_paket']; ?></h5>
                    <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                    <p class="card-text">Harga: Rp<?php echo number_format($row['harga'],0,',','.'); ?></p>
                    <p class="card-text">Tamu: <?php echo $row['min_tamu'].' - '.$row['max_tamu']; ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>