<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";

    // Tangkap parameter filter
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $filterCategory = isset($_GET['filterCategory']) ? $_GET['filterCategory'] : [];
    $filterStatus = isset($_GET['filterStatus']) ? mysqli_real_escape_string($conn, $_GET['filterStatus']) : '';

    // Query untuk mengambil kategori obat dari database
    $categoryQuery = "SELECT DISTINCT KATREGORI FROM OBAT";
    $categoryResult = mysqli_query($conn, $categoryQuery);

    // Query obat dengan pencarian dan filter
    $obat = "SELECT * FROM OBAT WHERE (NAMA_OBAT LIKE '%$search%' OR KATREGORI LIKE '%$search%')";

    // Tambahkan filter kategori jika ada
    if (!empty($filterCategory)) {
        $obat .= " AND KATREGORI IN ('" . implode("','", $filterCategory) . "')";
    }

    // Tambahkan filter status jika ada
    if ($filterStatus === 'available') {
        $obat .= " AND JUMLAH_STOCK > 0";
    } elseif ($filterStatus === 'out_of_stock') {
        $obat .= " AND JUMLAH_STOCK = 0";
    }

    $result = mysqli_query($conn, $obat);
?>

<h1>Tabel Obat</h1>
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <button class="btn btn-primary me-2" onclick="window.location.href='add_product.php'">
            tambah obat
        </button>
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Filter
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

<!-- Modal untuk Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="GET">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="filterCategory" class="form-label">Kategori</label>
                        <?php while ($category = mysqli_fetch_assoc($categoryResult)): ?>
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="filterCategory[]" 
                                    value="<?php echo $category['KATREGORI']; ?>" 
                                    <?php echo (in_array($category['KATREGORI'], $filterCategory)) ? 'checked' : ''; ?> />
                                <label class="form-check-label">
                                    <?php echo htmlspecialchars($category['KATREGORI']); ?>
                                </label>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="mb-3">
                        <label for="filterStatus" class="form-label">Status</label>
                        <select class="form-select" name="filterStatus" id="filterStatus">
                            <option value="">-- Pilih Status --</option>
                            <option value="available" <?php if ($filterStatus === 'available') echo 'selected'; ?>>Available</option>
                            <option value="out_of_stock" <?php if ($filterStatus === 'out_of_stock') echo 'selected'; ?>>Out of Stock</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include "assets/footer.php";
?>
