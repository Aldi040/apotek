<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";
    $query= mysqli_query($conn, "SELECT * FROM transaksi, pelanggan WHERE transaksi.ID_PELANGGAN = pelanggan.ID_PELANGGAN");
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
</head>
<body>
    <div>
        <h1>Tabel Transaksi</h1>
    </div>
    <div class="my-2 d-flex justify-content-between">
        <form action="">
        <div class="">
            <button class="btn btn-primary" onclick="window.location.href='report_transaksi.php'">Reporting</button>
            <button class="btn btn-success" onclick="window.location.href='form_transaksi_pelanggan.php'" type="button">Tambah Transaksi</button>
        </form>
        </div>
        <form action="" method="post">
        <div class="d-flex gap-2">
            
                <div>
                    <input type="text" class="form-control" placeholder="Cari Nama Pelanggan...">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>

        </div>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($result as $value): ?>
            <tr>
                <td><?= $value['ID_TRANSAKSI'] ?></td>
                <td><?= $value['NAMA_PELANGGAN'] ?></td>
                <td><?= $value['TANGGAL_TRANSAKSI'] ?></td>
                <td><?= "Rp. ". number_format($value['TOTAL_HARGA'], 2, ".", ".") ?></td>
                <td><?= $value['METODE_PEMBAYARAN'] ?></td>
                <td>
                    <div class="d-flex gap-1 justify-content-center">
                        <a href="" class="btn btn-success"><i class="fa-solid fa-eye"></i></a>
                        <a href="edit_product.php?id=<?= $value['ID_TRANSAKSI']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_product.php?id=<?= $value['ID_TRANSAKSI']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<?php
    include "assets/footer.php";
?>