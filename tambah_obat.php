<?php
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";

// Query untuk mendapatkan daftar supplier
$supplierQuery = "SELECT ID_SUPPLIER, NAMA_SUPPLIER FROM SUPPLIER";
$supplierResult = mysqli_query($conn, $supplierQuery);

// Proses penyimpanan data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_obat = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah_stock = intval($_POST['jumlah_stock']);
    $harga = floatval($_POST['harga']);
    $exp_date = mysqli_real_escape_string($conn, $_POST['exp_date']);
    $id_supplier = intval($_POST['supplier']); // Mengambil ID_SUPPLIER dari dropdown
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']); // Mengambil keterangan kegunaan obat

    $query = "INSERT INTO OBAT (NAMA_OBAT, KATREGORI, JUMLAH_STOCK, HARGA, EXP, ID_SUPPLIER, KETERANGAN)
              VALUES ('$nama_obat', '$kategori', $jumlah_stock, $harga, '$exp_date', $id_supplier, '$keterangan')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Obat berhasil ditambahkan!'); window.location.href='obat.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan obat: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<head>
    <title>Obat</title>
</head>
<style>
    .card-body{
        background-color: #232f4d;
    }
</style>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Tambah Obat Baru</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="tambah_obat.php">
                <div class="mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="nama_obat" 
                        name="nama_obat" 
                        placeholder="Masukkan nama obat"
                        required>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="kategori" 
                        name="kategori" 
                        placeholder="Masukkan kategori obat"
                        required>
                </div>
                <div class="mb-3">
                    <label for="jumlah_stock" class="form-label">Jumlah Stock</label>
                    <input 
                        type="number" 
                        class="form-control" 
                        id="jumlah_stock" 
                        name="jumlah_stock" 
                        placeholder="Masukkan jumlah stok"
                        min="0" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        class="form-control" 
                        id="harga" 
                        name="harga" 
                        placeholder="Masukkan harga obat"
                        min="0" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="exp_date" class="form-label">Tanggal Kadaluarsa</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="exp_date" 
                        name="exp_date" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="supplier" class="form-label">Supplier</label>
                    <select class="form-select" id="supplier" name="supplier" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php while ($supplier = mysqli_fetch_assoc($supplierResult)): ?>
                            <option value="<?php echo $supplier['ID_SUPPLIER']; ?>">
                                <?php echo htmlspecialchars($supplier['NAMA_SUPPLIER']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan Kegunaan Obat</label>
                    <textarea 
                        class="form-control" 
                        id="keterangan" 
                        name="keterangan" 
                        rows="3" 
                        placeholder="Masukkan kegunaan obat"
                        required></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="obat.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include "assets/footer.php";
?>
