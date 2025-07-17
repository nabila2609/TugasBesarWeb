<?php
include '../config/koneksi.php';

$sukses = null;

if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $level = $_POST['level']; // Ambil level dari form

    // Cek username sudah ada atau belum
    $cek = $koneksi->prepare("SELECT id FROM nabila_users WHERE username = ?");
    $cek->bind_param("s", $username);
    $cek->execute();
    $cek->store_result();
    if ($cek->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO nabila_users (username, password, level, nama_lengkap, email, no_telepon) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssssss", $username, $password, $level, $nama, $email, $telepon);
            if ($stmt->execute()) {
                $sukses = "Pendaftaran berhasil! Silakan login.";
                // Jangan redirect langsung, tampilkan alert sukses
            } else {
                $error = "Pendaftaran gagal! " . $stmt->error;
            }
        } else {
            $error = "Terjadi kesalahan pada server: " . $koneksi->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar - Nabila Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="text-center">Daftar Akun Baru</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($sukses): ?>
                            <div class="alert alert-success"><?php echo $sukses; ?> <a href="../login.php" class="alert-link">Login di sini</a>.</div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telepon" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" required>
                            </div>
                            <div class="mb-3">
                                <label for="level" class="form-label">Daftar Sebagai</label>
                                <select class="form-control" id="level" name="level" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" name="daftar" class="btn btn-success w-100">Daftar</button>
                        </form>
                        <div class="mt-3 text-center">
                            <p>Sudah punya akun? <a href="../login.php">Login disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>