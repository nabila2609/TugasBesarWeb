<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Proses tambah reservasi (khusus user)
if (isset($_POST['tambah_reservasi']) && $_SESSION['level'] == 'user') {
    $id_paket = $_POST['id_paket'];
    $tanggal_acara = $_POST['tanggal_acara'];
    $jumlah_tamu = $_POST['jumlah_tamu'];
    $status = 'menunggu';

    $stmt = $koneksi->prepare("INSERT INTO nabila_reservasi (id_users, id_paket, tanggal_acara, jumlah_tamu, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $_SESSION['user_id'], $id_paket, $tanggal_acara, $jumlah_tamu, $status);
    if ($stmt->execute()) {
        $sukses = "Reservasi berhasil ditambahkan!";
    } else {
        $error = "Reservasi gagal ditambahkan!";
    }
}

// Query untuk menampilkan reservasi user
$user_id = $_SESSION['user_id'];
$query = "SELECT r.*, p.nama_paket FROM nabila_reservasi r JOIN nabila_paket p ON r.id_paket = p.id WHERE r.id_users = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Reservasi Saya</h2>
    <?php if (isset($sukses)): ?>
        <div class="alert alert-success"><?php echo $sukses; ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($_SESSION['level'] == 'user'): ?>
    <!-- Form tambah reservasi hanya untuk user -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Reservasi Baru</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Pilih Paket</label>
                    <select name="id_paket" class="form-control" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php
                        $paket = $koneksi->query("SELECT * FROM nabila_paket");
                        while ($p = $paket->fetch_assoc()) {
                            echo '<option value="'.$p['id'].'">'.$p['nama_paket'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Acara</label>
                    <input type="date" name="tanggal_acara" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Tamu</label>
                    <input type="number" name="jumlah_tamu" class="form-control" required>
                </div>
                <button type="submit" name="tambah_reservasi" class="btn btn-success">Tambah Reservasi</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Paket</th>
                <th>Tanggal Acara</th>
                <th>Jumlah Tamu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['nama_paket']; ?></td>
                <td><?php echo $row['tanggal_acara']; ?></td>
                <td><?php echo $row['jumlah_tamu']; ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>