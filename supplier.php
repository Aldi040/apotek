<?php
// Koneksi database
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";
include "connect.php";

// Proses Hapus Data
if (isset($_GET['hapus'])) {
    $hapus_id = (int)$_GET['hapus'];
    $query_hapus = "DELETE FROM supplier WHERE ID_SUPPLIER = $hapus_id";

    if ($conn->query($query_hapus)) {
        echo "<div class='alert alert-success'>Data berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}

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
        echo "<div class='alert alert-success'>Data berhasil disimpan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $conn->error . "</div>";
    }
}

// Ambil data untuk tabel dan edit
$data_supplier = [];
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Sesuaikan query untuk pencarian
$query = "SELECT * FROM supplier";
if (!empty($search)) {
    $query .= " WHERE NAMA_SUPPLIER LIKE '%$search%'";
}
$query .= " ORDER BY ID_SUPPLIER ASC";

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
</head>
<body>
    <h1 class="mb-4">Data Supplier</h1>
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="tambah_supplier.php" class="btn btn-primary mb-3">Tambah Supplier</a>
        <form method="GET" class="d-flex">
            <input 
                class="form-control w-100 me-2" 
                placeholder="cari nama pelanggan" 
                type="text" 
                name="search" 
                value="<?php echo htmlspecialchars($search); ?>" />
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>
    <table  >
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Supplier</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data_supplier as $supplier): ?>
            <tr>
                <td><?php echo $supplier['ID_SUPPLIER']; ?></td>
                <td><?php echo $supplier['NAMA_SUPPLIER']; ?></td>
                <td><?php echo $supplier['ALAMAT_SUPPLIER']; ?></td>
                <td><?php echo $supplier['TELEPON_SUPPLIER']; ?></td>
                <td><?php echo $supplier['EMAIL_SUPPLIER']; ?></td>
                <td>
                    <div class="d-flex gap-1" >
                    <a href="edit_supplier.php?edit=<?php echo $supplier['ID_SUPPLIER']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?hapus=<?php echo $supplier['ID_SUPPLIER']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php include "assets/footer.php"; ?>
