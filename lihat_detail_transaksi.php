<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";

    $id_transaksi = $_GET['id'];
    $id_pelanggan = $_GET['id_pelanggan'];
    $nama_pelanggan = $_GET['nama_pelanggan'];

    $query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE ID_TRANSAKSI = '$id_transaksi' AND ID_PELANGGAN = '$id_pelanggan'");
    $result_transaksi = mysqli_fetch_assoc($query_transaksi);

    $query_pembelian_obat = mysqli_query($conn, "SELECT * FROM pembelian_obat WHERE ID_TRANSAKSI = '$id_transaksi' AND ID_PELANGGAN = '$id_pelanggan'");
    $result_pembelian_obat = mysqli_fetch_all($query_pembelian_obat, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        tr, td, th{
            border: 1px solid white;
        }
        th{
            text-align: left;
            background-color: #FF9D3D;
            color: black;
        }
        td{
            background-color: #FFBD73;
            color: black;
        }
        .harga{
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div>
        <h1>Detail Transaksi</h1>
    </div>
    <div class="mt-5">
            <button class="btn btn-primary" type="button" onclick="window.location.href='transaksi.php'">Kembali</button>
    </div>
    <div class="card mt-2">
    <div class="card-body">
        <table class="judul">
            <tr>
                <th>
                    Nama
                </th>
                <td>
                <?= $nama_pelanggan ?>
                </td>
            </tr>
            <tr>
                <th>
                    Tanggal Transaksi
                </th>
                <td>
                <?= date("d-m-Y", strtotime($result_transaksi['TANGGAL_TRANSAKSI'])) ?>
                </td>
            </tr>
            <tr>
                <th>
                    Total Harga
                </th>
                <td>
                <?=  "Rp. ". number_format($result_transaksi['TOTAL_HARGA'], 2, ".", ".")?>
                </td>
            </tr>
            <tr>
                <th>
                    Metode Pembayaran
                </th>
                <td>
                <?= $result_transaksi["METODE_PEMBAYARAN"] ?>
                </td>
            </tr>
        </table>
        <div class="mt-4">
            <h3>List obat yang telah dibeli</h3>
        </div>
        <table>
            <tr>
                <th>NO</th>
                <th>Nama Obat</th>
                <th>Kategori Obat</th>
                <th>Harga</th>
                <th>Kuantitas</th>
            </tr>
            <?php $count = 1; ?>
            <?php foreach($result_pembelian_obat as $value): ?>
                <?php  $query_pembelian_obat = mysqli_query($conn, "SELECT * FROM obat WHERE ID_OBAT = '{$value['ID_OBAT']}'");
                    $result_obat = mysqli_fetch_assoc($query_pembelian_obat);
                ?>
                <tr>
                    <td><?= $count; ?></td>
                    <td><?= $result_obat['NAMA_OBAT'] ?></td>
                    <td><?= $result_obat['KATREGORI'] ?></td>
                    <td><?=  "Rp. ". number_format($result_obat['HARGA'], 2, ".", ".") ?></td>
                    <td><?= $value['QTY'] ?></td>
                </tr>
                <?php $count++; ?>
            <?php endforeach; ?>
        </table>
    </div>
    </div>
</body>
</html>