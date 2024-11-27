<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";

    // Pastikan koneksi database sudah disiapkan dalam file main.php
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $obat = "SELECT * FROM OBAT WHERE NAMA_OBAT LIKE '%$search%' OR KATREGORI LIKE '%$search%'";
    $result = mysqli_query($conn, $obat);
?>

<h1>Tabel Obat</h1>
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <button class="btn btn-primary me-2" onclick="window.location.href='add_product.php'">
            tambah obat
        </button>
        <button class="btn btn-secondary">
            <i class="fas fa-filter"></i>
        </button>
    </div>

    <!-- Search bar di pojok kanan -->
    <form method="GET" class="d-flex">
        <input 
            class="form-control w-100 me-2" 
            placeholder="cari nama atau kategori" 
            type="text" 
            name="search" 
            value="<?php echo htmlspecialchars($search); ?>" />
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Expiry Date</th>
            <th>Stock</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['NAMA_OBAT']); ?></td>
                    <td><?php echo htmlspecialchars($row['KATREGORI']); ?></td>
                    <td><?php echo ($row['JUMLAH_STOCK'] > 0) ? 'Available' : 'Out of Stock'; ?></td>
                    <td><?php echo htmlspecialchars($row['EXP']); ?></td>
                    <td><?php echo htmlspecialchars($row['JUMLAH_STOCK']); ?></td>
                    <td>Rp. <?php echo number_format($row['HARGA'], 2); ?></td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="edit_product.php?id=<?php echo $row['ID_OBAT']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_product.php?id=<?php echo $row['ID_OBAT']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No records found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
    include "assets/footer.php";
?>
