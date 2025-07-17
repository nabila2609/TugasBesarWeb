<?php

session_start();
include '../config/koneksi.php';

// Hanya admin yang boleh akses
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Proses tambah reservasi (khusus admin)
if (isset($_POST['tambah_reservasi'])) {
    $id_users = $_POST['id_users'];
    $id_paket = $_POST['id_paket'];
    $tanggal_acara = $_POST['tanggal_acara'];
    $jumlah_tamu = $_POST['jumlah_tamu'];
    $status = $_POST['status'];

    // Pastikan bind_param sesuai tipe data di database:
    // id_users (int), id_paket (int), tanggal_acara (string), jumlah_tamu (int), lokasi (string), status (string)
    $stmt = $koneksi->prepare("INSERT INTO nabila_reservasi (id_users, id_paket, tanggal_acara, jumlah_tamu, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $id_users, $id_paket, $tanggal_acara, $jumlah_tamu, $status);
    if ($stmt->execute()) {
        $sukses = "Reservasi berhasil ditambahkan!";
    } else {
        $error = "Gagal menambah reservasi! " . $stmt->error;
    }
}

// Proses update status reservasi
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $koneksi->prepare("UPDATE nabila_reservasi SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        $sukses = "Status reservasi berhasil diupdate!";
    } else {
        $error = "Gagal update status!";
    }
}

// Proses hapus reservasi
if (isset($_POST['hapus_reservasi'])) {
    $id = $_POST['id'];
    $stmt = $koneksi->prepare("DELETE FROM nabila_reservasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $sukses = "Reservasi berhasil dihapus!";
    } else {
        $error = "Gagal menghapus reservasi!";
    }
}

// Ambil data reservasi
$query = "SELECT r.*, u.nama_lengkap, p.nama_paket 
          FROM nabila_reservasi r 
          JOIN nabila_users u ON r.id_users = u.id 
          JOIN nabila_paket p ON r.id_paket = p.id
          ORDER BY r.tanggal_acara DESC";
$result = $koneksi->query($query);

// Ambil data user dan paket untuk form tambah
$users = $koneksi->query("SELECT id, nama_lengkap FROM nabila_users WHERE level='user' OR level='admin'");
$paket = $koneksi->query("SELECT id, nama_paket FROM nabila_paket");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Reservasi - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Kelola Reservasi</h2>
    <?php if (isset($sukses)): ?>
        <div class="alert alert-success"><?php echo $sukses; ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Form tambah reservasi oleh admin -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Tambah Reservasi Baru</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <select name="id_users" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['nama_lengkap']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Paket</label>
                    <select name="id_paket" class="form-control" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php foreach ($paket as $p): ?>
                            <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nama_paket']); ?></option>
                        <?php endforeach; ?>
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
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <button type="submit" name="tambah_reservasi" class="btn btn-success">Tambah Reservasi</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Paket</th>
                <th>Tanggal Acara</th>
                <th>Jumlah Tamu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_paket']); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal_acara']); ?></td>
                <td><?php echo htmlspecialchars($row['jumlah_tamu']); ?></td>
                <td>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <select name="status" class="form-select form-select-sm me-2">
                            <option value="menunggu" <?php if($row['status']=='menunggu') echo 'selected'; ?>>Menunggu</option>
                            <option value="diterima" <?php if($row['status']=='diterima') echo 'selected'; ?>>Diterima</option>
                            <option value="ditolak" <?php if($row['status']=='ditolak') echo 'selected'; ?>>Ditolak</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-primary btn-sm me-1">Update</button>
                    </form>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="hapus_reservasi" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>