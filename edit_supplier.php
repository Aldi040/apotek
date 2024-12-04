<?php
// Koneksi database
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";
include "connect.php";

// Ambil data supplier berdasarkan ID
$edit_supplier = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $query_edit = "SELECT * FROM supplier WHERE ID_SUPPLIER = $edit_id";
    $result_edit = $conn->query($query_edit);

    if ($result_edit && $result_edit->num_rows > 0) {
        $edit_supplier = $result_edit->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Data supplier tidak ditemukan!</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID supplier tidak valid!</div>";
    exit;
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supplier = (int)$_POST['id_supplier'];
    $nama_supplier = $conn->real_escape_string($_POST['nama_supplier']);
    $alamat_supplier = $conn->real_escape_string($_POST['alamat_supplier']);
    $telepon_supplier = $conn->real_escape_string($_POST['telepon_supplier']);
    $email_supplier = $conn->real_escape_string($_POST['email_supplier']);

    $query_update = "UPDATE supplier 
                     SET NAMA_SUPPLIER = '$nama_supplier', 
                         ALAMAT_SUPPLIER = '$alamat_supplier', 
                         TELEPON_SUPPLIER = '$telepon_supplier', 
                         EMAIL_SUPPLIER = '$email_supplier' 
                     WHERE ID_SUPPLIER = $id_supplier";

    if ($conn->query($query_update)) {
        echo "<div class='alert alert-success'>Data supplier berhasil diperbarui!</div>";
        echo "<a href='supplier.php' class='btn btn-primary'>Kembali ke Data Supplier</a>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
</head>
<body>
    <h1 class="mb-4">Edit Supplier</h1>

    <?php if ($edit_supplier): ?>
        <form method="POST">
            <input type="hidden" name="id_supplier" value="<?php echo $edit_supplier['ID_SUPPLIER']; ?>">

            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" 
                    value="<?php echo htmlspecialchars($edit_supplier['NAMA_SUPPLIER']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="alamat_supplier" class="form-label">Alamat Supplier</label>
                <input type="text" class="form-control" id="alamat_supplier" name="alamat_supplier" 
                    value="<?php echo htmlspecialchars($edit_supplier['ALAMAT_SUPPLIER']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="telepon_supplier" class="form-label">Telepon Supplier</label>
                <input type="text" class="form-control" id="telepon_supplier" name="telepon_supplier" 
                    value="<?php echo htmlspecialchars($edit_supplier['TELEPON_SUPPLIER']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email_supplier" class="form-label">Email Supplier</label>
                <input type="email" class="form-control" id="email_supplier" name="email_supplier" 
                    value="<?php echo htmlspecialchars($edit_supplier['EMAIL_SUPPLIER']); ?>" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="supplier.php" class="btn btn-secondary">Batal</a>
        </form>
    <?php endif; ?>
</body>
</html>

<?php include "assets/footer.php"; ?>
