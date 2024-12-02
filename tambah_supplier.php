<?php
// Koneksi database
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";
include "connect.php";

// Proses Tambah/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_supplier = isset($_POST['id_supplier']) ? (int)$_POST['id_supplier'] : null;
    $nama_supplier = $conn->real_escape_string($_POST['nama_supplier']);
    $alamat_supplier = $conn->real_escape_string($_POST['alamat_supplier']);
    $telepon_supplier = $conn->real_escape_string($_POST['telepon_supplier']);
    $email_supplier = $conn->real_escape_string($_POST['email_supplier']);

    if ($id_supplier) {
        $query = "UPDATE supplier 
                    SET NAMA_SUPPLIER = '$nama_supplier', 
                        ALAMAT_SUPPLIER = '$alamat_supplier', 
                        TELEPON_SUPPLIER = '$telepon_supplier', 
                        EMAIL_SUPPLIER = '$email_supplier' 
                    WHERE ID_SUPPLIER = $id_supplier";
    } else {
        // Proses tambah
        $query = "INSERT INTO supplier (NAMA_SUPPLIER, ALAMAT_SUPPLIER, TELEPON_SUPPLIER, EMAIL_SUPPLIER) 
                VALUES ('$nama_supplier', '$alamat_supplier', '$telepon_supplier', '$email_supplier')";
    }

    if ($conn->query($query)) {
        
        echo "<script>
        alert('Data berhasil disimpan!');
        window.location.href = 'supplier.php'
        </script>";

    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}

// Ambil data untuk tabel dan edit
$data_supplier = [];
$query = "SELECT * FROM supplier ORDER BY ID_SUPPLIER ASC";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data_supplier[] = $row;
    }
}

// Ambil data untuk form edit
$edit_supplier = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $query_edit = "SELECT * FROM supplier WHERE ID_SUPPLIER = $edit_id";
    $result_edit = $conn->query($query_edit);

    if ($result_edit && $result_edit->num_rows > 0) {
        $edit_supplier = $result_edit->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<body>
<div class="container mt-5">
    <!-- Form Tambah/Edit Supplier -->
    <h2 class="mt-4"><?php echo $edit_supplier ? "Edit Supplier" : "Tambah Supplier"; ?></h2>
    <form method="POST" class="mt-3">
        <?php if ($edit_supplier): ?>
            <input type="hidden" name="id_supplier" value="<?php echo $edit_supplier['ID_SUPPLIER']; ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label for="nama_supplier" class="form-label">Nama Supplier</label>
            <input type="text" name="nama_supplier" class="form-control" id="nama_supplier" required
                value="<?php echo $edit_supplier['NAMA_SUPPLIER'] ?? ''; ?>">
        </div>
        <div class="mb-3">
            <label for="alamat_supplier" class="form-label">Alamat Supplier</label>
            <input type="text" name="alamat_supplier" class="form-control" id="alamat_supplier"
                value="<?php echo $edit_supplier['ALAMAT_SUPPLIER'] ?? ''; ?>">
        </div>
        <div class="mb-3">
            <label for="telepon_supplier" class="form-label">Telepon Supplier</label>
            <input type="text" name="telepon_supplier" class="form-control" id="telepon_supplier"
                value="<?php echo $edit_supplier['TELEPON_SUPPLIER'] ?? ''; ?>">
        </div>
        <div class="mb-3">
            <label for="email_supplier" class="form-label">Email Supplier</label>
            <input type="email" name="email_supplier" class="form-control" id="email_supplier"
                value="<?php echo $edit_supplier['EMAIL_SUPPLIER'] ?? ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $edit_supplier ? "Simpan Perubahan" : "Tambah"; ?></button>
    </form>
</div>

</body>
</html>

<?php include "assets/footer.php"; ?>
