<?php
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";

// Cek apakah parameter ID ada di URL
if (isset($_GET['id'])) {
    $id_obat = intval($_GET['id']); // Mengambil ID_OBAT dari URL

    // Query untuk mendapatkan data obat berdasarkan ID_OBAT
    $obatQuery = "SELECT * FROM OBAT WHERE ID_OBAT = $id_obat";
    $obatResult = mysqli_query($conn, $obatQuery);

    // Jika data tidak ditemukan, tampilkan pesan error
    if (mysqli_num_rows($obatResult) == 0) {
        echo "<script>alert('Data obat tidak ditemukan!'); window.location.href='obat.php';</script>";
        exit;
    }

    $obat = mysqli_fetch_assoc($obatResult);

    // Query untuk mendapatkan daftar supplier
    $supplierQuery = "SELECT ID_SUPPLIER, NAMA_SUPPLIER FROM SUPPLIER";
    $supplierResult = mysqli_query($conn, $supplierQuery);
} else {
    echo "<script>alert('ID Obat tidak valid!'); window.location.href='obat.php';</script>";
    exit;
}

// Proses penyimpanan update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_obat = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $jumlah_stock = intval($_POST['jumlah_stock']);
    $harga = floatval($_POST['harga']);
    $exp_date = mysqli_real_escape_string($conn, $_POST['exp_date']);
    $id_supplier = intval($_POST['supplier']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $query = "UPDATE OBAT SET 
              NAMA_OBAT = '$nama_obat',
              KATREGORI = '$kategori',
              JUMLAH_STOCK = $jumlah_stock,
              HARGA = $harga,
              EXP = '$exp_date',
              ID_SUPPLIER = $id_supplier,
              KETERANGAN = '$keterangan'
              WHERE ID_OBAT = $id_obat";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data obat berhasil diperbarui!'); window.location.href='obat.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data obat: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Edit Data Obat</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="edit_obat.php?id=<?php echo $id_obat; ?>">
                <div class="mb-3">
                    <label for="nama_obat" class="form-label">Nama Obat</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="nama_obat" 
                        name="nama_obat" 
                        value="<?php echo htmlspecialchars($obat['NAMA_OBAT']); ?>" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="kategori" 
                        name="kategori" 
                        value="<?php echo htmlspecialchars($obat['KATREGORI']); ?>" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="jumlah_stock" class="form-label">Jumlah Stock</label>
                    <input 
                        type="number" 
                        class="form-control" 
                        id="jumlah_stock" 
                        name="jumlah_stock" 
                        value="<?php echo $obat['JUMLAH_STOCK']; ?>" 
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
                        value="<?php echo $obat['HARGA']; ?>" 
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
                        value="<?php echo $obat['EXP']; ?>" 
                        required>
                </div>
                <div class="mb-3">
                    <label for="supplier" class="form-label">Supplier</label>
                    <select class="form-select" id="supplier" name="supplier" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php while ($supplier = mysqli_fetch_assoc($supplierResult)): ?>
                            <option value="<?php echo $supplier['ID_SUPPLIER']; ?>" 
                                    <?php echo ($supplier['ID_SUPPLIER'] == $obat['ID_SUPPLIER']) ? 'selected' : ''; ?>>
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
                        required><?php echo htmlspecialchars($obat['KETERANGAN']); ?></textarea>
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
