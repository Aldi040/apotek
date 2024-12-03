<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";
    $query= mysqli_query($conn, "SELECT * FROM transaksi, pelanggan WHERE transaksi.ID_PELANGGAN = pelanggan.ID_PELANGGAN");
    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $hasil = true;

    if(isset($_POST['search'])){
        $hasil = "ada";
        $search = $_POST['sc_nama'];
        $query_pelanggan= mysqli_query($conn, "SELECT * FROM transaksi JOIN pelanggan ON transaksi.ID_PELANGGAN = pelanggan.ID_PELANGGAN WHERE pelanggan.NAMA_PELANGGAN LIKE '$search%'");
        $result = mysqli_fetch_all($query_pelanggan, MYSQLI_ASSOC);
        if(empty($result)){
            $hasil = false;
        }else{
            $hasil = true;
        }
    }
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
            <button class="btn btn-primary" onclick="window.location.href='report_transaksi.php'" type="button">Reporting</button>
            <button class="btn btn-success" onclick="window.location.href='form_transaksi_pelanggan.php'" type="button">Tambah Transaksi</button>
        </form>
        </div>
        <form action="" method="post">
        <div class="d-flex gap-2">
            
                <div>
                    <input type="text" class="form-control" placeholder="Cari Nama Pelanggan..." name="sc_nama">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="search">Search</button>
                </div>

        </div>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if($hasil == true): ?>
            <?php $count = 1; ?>
            <?php foreach($result as $value): ?>
                <tr>
                    <td><?= $count; ?></td>
                    <td><?= $value['NAMA_PELANGGAN'] ?></td>
                    <td><?= $value['TANGGAL_TRANSAKSI'] ?></td>
                    <td><?= "Rp. ". number_format($value['TOTAL_HARGA'], 2, ".", ".") ?></td>
                    <td><?= $value['METODE_PEMBAYARAN'] ?></td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="lihat_detail_transaksi.php?id=<?= htmlspecialchars($value['ID_TRANSAKSI']);?>&id_pelanggan=<?= htmlspecialchars($value['ID_PELANGGAN']);?>&nama_pelanggan=<?= htmlspecialchars($value['NAMA_PELANGGAN']);?>" class="btn btn-success"><i class="fa-solid fa-eye" ></i></a>
                            <a href="delete_product.php?id=<?= $value['ID_TRANSAKSI']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php $count++; ?>
                <?php endforeach; ?>
            <?php else:  ?>
                <tr>
                    <td colspan="6">No Matching Data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
    include "assets/footer.php";
?>