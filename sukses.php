<?php
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";

// Tangkap data nama pelanggan dan total pembayaran dari parameter URL
$nama_pelanggan = $_GET['nama_pelanggan'] ?? 'Pelanggan';
$total_pembayaran = $_GET['total_pembayaran'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        .success-container {
            text-align: center;
            padding: 50px;
            margin: 50px auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 600px;
        }
        .success-container h1 {
            color: green;
            margin-bottom: 20px;
        }
        .success-container p {
            font-size: 1.2em;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h1>Pembayaran Berhasil</h1>
        <p>Terima kasih, <strong><?= htmlspecialchars($nama_pelanggan) ?></strong>!</p>
        <p>Total pembayaran Anda adalah <strong>Rp <?= number_format($total_pembayaran, 0, ',', '.') ?></strong>.</p>
        <a href="transaksi.php" class="back-button">Kembali ke Halaman Transaksi</a>
    </div>
</body>
</html>
