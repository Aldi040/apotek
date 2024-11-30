<?php 
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";

    $nama = $_GET['nama'];
    $gender = $_GET['gender'];
    $alamat = $_GET['alamat'];
    $tanggal_transaksi = $_GET['transaksi'];

    $query_obat = mysqli_query($conn, "SELECT * FROM obat");
    $result_obat = mysqli_fetch_all($query_obat, MYSQLI_ASSOC);

    if(isset($_POST['tambah'])){
        $id_obat = $_POST['obat'];
        $qty = $_POST['qty'];

        $query_pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan WHERE NAMA_PELANGGAN='$nama'");
        $result_pelanggan = mysqli_fetch_assoc($query_pelanggan);

        $query_obat2 = mysqli_query($conn, "SELECT * FROM obat WHERE ID_OBAT='$id_obat'");
        $result_obat2 = mysqli_fetch_assoc($query_obat2);
        $harga_obat = $result_obat2['HARGA'];

        if(mysqli_num_rows($query_pelanggan) > 0){

        }else{
            $insert_pelanggan = mysqli_query($conn, "INSERT INTO pelanggan (NAMA_PELANGGAN, JENIS_KELAMIN, ALAMAT) VALUES ('$nama', '$gender', '$alamat')");

            $query_pelanggan2 = mysqli_query($conn, "SELECT ID_PELANGGAN FROM pelanggan WHERE NAMA_PELANGGAN='$nama'");
            $result_pelanggan2 = mysqli_fetch_assoc($query_pelanggan2);

            $id = $result_pelanggan2['ID_PELANGGAN'];
            $insert_obat = mysqli_query($conn, "INSERT INTO pembelian_obat (ID_PELANGGAN, ID_OBAT, QTY) VALUES ('$id', '$id_obat', '$qty')");
            $insert_transaksi = mysqli_query($conn, "INSERT INTO pembelian_obat (ID_PELANGGAN, ID_OBAT, QTY) VALUES ('$id', '$id_obat', '$qty')");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    

    </style>
</head>
<body>
    <form action="" method="post">
    <div class="mt-5 hero">
        <h2>Nama Pelanggan :  <?= $nama  ?></h2>
    </div>
    <div class="d-flex gap-3 main" style="width: 100%;">
        <div class="card" style="width: 40%">
            <div class="card-header">
                Transaksi Obat
            </div>
            <div class="card-body p-3">
                <div>
                    <label for="">Jenis Obat</label>
                    <select name="obat" id="" class="form-control">
                        <option value="none">~Pilih Obat~</option>
                        <?php foreach($result_obat as $value): ?>
                            <option value="<?= $value['ID_OBAT']?>"><?= $value['NAMA_OBAT']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="">Quantity</label>
                    <input type="number" name="qty" class="form-control">
                </div>
                <div class="mt-2">
                    <button class="btn btn-primary" type="submit" name="tambah">Tambah</button>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3 gap-2 mb-2">
                <button class="btn btn-warning" onclick="window.location.href='form_transaksi_pelanggan.php?nama=<?= $nama ?>&gender=<?= $gender ?>&alamat=<?= $alamat ?>&transaksi=<?= $tanggal_transaksi ?>'" type="button"><i class="fa-solid fa-backward"></i></button>
                <button class="btn btn-success">Simpan</button>
                <button class="btn btn-danger" onclick="window.location.href='transaksi.php'" type="button"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        <div class="list-container" style="width: 60%;">
            <div class="title-obat">
                <h2>List Obat yang dibeli</h2>
            </div>
            <div class="daftar-obat">
                <div class="obat">
                    <span>Paracetamol
                    <div>
                        <span class="qty">1 x 15.000</span>
                    </div>
                    </span>
                    <span>15.00</span>
                </div>
                
            </div>
        </div>
    </div>
    </form>

</body>
</html>

