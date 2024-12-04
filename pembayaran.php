<?php
session_start();
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";
// Tangkap ID Pelanggan dan ID Transaksi dari parameter URL
$id_pelanggan = $_GET['id_pelanggan'] ?? null;
$id_transaksi = $_GET['id_transaksi'] ?? null;
$status = $_GET['status'] ?? null;

// Jika parameter tidak ditemukan, arahkan ke halaman transaksi
if (!$id_pelanggan || !$id_transaksi) {
    echo "<script>alert('Data pelanggan atau transaksi tidak ditemukan!'); window.location.href = 'transaksi.php';</script>";
    exit();
}

if (isset($_POST["batal"])) {
    if($status == 'ada'){
        $query_delete_transaksi = mysqli_query($conn, "DELETE FROM transaksi WHERE ID_PELANGGAN = '$id_pelanggan' AND ID_TRANSAKSI = '$id_transaksi'");
    }else{
        $query_delete_transaksi = mysqli_query($conn, "DELETE FROM transaksi WHERE ID_PELANGGAN = '$id_pelanggan' AND ID_TRANSAKSI = '$id_transaksi'");
        $query_delete_pelanggan = mysqli_query($conn, "DELETE FROM pelanggan WHERE ID_PELANGGAN = '$id_pelanggan'");
    }
    session_unset();
    session_destroy();
    echo "<script>
        window.location.href='transaksi.php';
    </script>";
}
// Ambil data transaksi berdasarkan ID Pelanggan dan ID Transaksi
$query_transaksi = mysqli_query($conn, "SELECT t.ID_TRANSAKSI, p.NAMA_PELANGGAN, t.TOTAL_HARGA 
    FROM transaksi t 
    JOIN pelanggan p ON t.ID_PELANGGAN = p.ID_PELANGGAN 
    WHERE t.ID_TRANSAKSI = '$id_transaksi' AND p.ID_PELANGGAN = '$id_pelanggan'");

if (mysqli_num_rows($query_transaksi) == 0) {
    echo "<script>alert('Transaksi tidak ditemukan!'); window.location.href = 'index.php';</script>";
    exit();
}

$result_transaksi = mysqli_fetch_assoc($query_transaksi);
$nama_pelanggan = $result_transaksi['NAMA_PELANGGAN'];
$total_harga = $result_transaksi['TOTAL_HARGA'];

// Proses form pembayaran

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? '';
    $errors = [];

    // Validasi input
    if (empty($metode_pembayaran)) {
        $errors['metode_pembayaran'] = 'Metode pembayaran harus dipilih.';
    }

    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        $update_pembayaran = mysqli_query($conn, "UPDATE transaksi 
            SET METODE_PEMBAYARAN = '$metode_pembayaran' 
            WHERE ID_TRANSAKSI = '$id_transaksi'");

        if ($update_pembayaran) {
            // Redirect ke halaman sukses dengan mengirimkan nama pelanggan dan total pembayaran
            foreach($_SESSION['obat'] as $value){
                $query_update_obat = mysqli_query($conn, "UPDATE obat SET JUMLAH_STOCK = JUMLAH_STOCK - {$value['qty']} WHERE ID_OBAT ='{$value['id_obat']}'");
            }
             
            session_unset();
            session_destroy();

            $encoded_nama = urlencode($nama_pelanggan);
            echo "<script>
                    alert('Pembayaran berhasil!');
                    window.location.href = 'sukses.php?nama_pelanggan=" . urlencode($nama_pelanggan) . "&total_pembayaran=" . urlencode($total_harga) . "';
                  </script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan pembayaran!');</script>";
        }

    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <style>
        .form-container {
            width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        h2, h3 {
            text-align: center;
        }
        .payment-category {
            margin-bottom: 30px;
        }
        .payment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }
        .payment-option {
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-option img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .payment-option:hover, .payment-option.selected {
            border-color: #007bff;
            background-color: #eef6ff;
        }
        .button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Form Pembayaran</h2>
        <p>Nama Pelanggan: <?= htmlspecialchars($nama_pelanggan) ?></p>
        <p>Total Harga: Rp <?= number_format($total_harga, 0, ',', '.') ?></p>

        <form method="POST" id="paymentForm">
            <div class="payment-category">
                <h3>Bank</h3>
                <div class="payment-grid">
                    <div class="payment-option" data-method="BCA">
                        <img src="img_pembayaran/BCA.svg" alt="BCA">
                        <p>BCA</p>
                    </div>
                    <div class="payment-option" data-method="BRI">
                        <img src="img_pembayaran/BRI.svg" alt="BRI">
                        <p>BRI</p>
                    </div>
                    <div class="payment-option" data-method="BNI">
                        <img src="img_pembayaran/BNI.svg" alt="BNI">
                        <p>BNI</p>
                    </div>
                    <div class="payment-option" data-method="BTN">
                        <img src="img_pembayaran/BTN.svg" alt="BTN">
                        <p>BTN</p>
                    </div>
                </div>
            </div>

            <div class="payment-category">
                <h3>E-Wallet</h3>
                <div class="payment-grid">
                    <div class="payment-option" data-method="GoPay">
                        <img src="img_pembayaran/Gopay.svg" alt="GoPay">
                        <p>GoPay</p>
                    </div>
                    <div class="payment-option" data-method="DANA">
                        <img src="img_pembayaran/DANA.svg" alt="DANA">
                        <p>DANA</p>
                    </div>
                    <div class="payment-option" data-method="OVO">
                        <img src="img_pembayaran/OVO.svg" alt="OVO">
                        <p>OVO</p>
                    </div>
                    <div class="payment-option" data-method="LinkAja">
                        <img src="img_pembayaran/LinkAja.svg" alt="LinkAja">
                        <p>LinkAja</p>
                    </div>
                    <div class="payment-option" data-method="ShopeePay">
                        <img src="img_pembayaran/ShopeePay.svg" alt="ShopeePay">
                        <p>ShopeePay</p>
                    </div>
                </div>
            </div>

            <div class="payment-category">
                <h3>Market</h3>
                <div class="payment-grid">
                    <div class="payment-option" data-method="Alfamart">
                        <img src="img_pembayaran/Alfamart.svg" alt="Alfamart">
                        <p>Alfamart</p>
                    </div>
                    <div class="payment-option" data-method="Indomaret">
                        <img src="img_pembayaran/Indomaret.svg" alt="Indomaret">
                        <p>Indomaret</p>
                    </div>
                </div>
            </div>

            <input type="hidden" id="metode_pembayaran" name="metode_pembayaran" required>
            <?php if (isset($errors['metode_pembayaran'])): ?>
                <div class="error"><?= $errors['metode_pembayaran'] ?></div>
            <?php endif; ?>

            <button type="submit" class="button">Proses Pembayaran</button>
        </form>
        <form action="" method="post">
        <button type="submit" class="button" name="batal">batal</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function () {
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('metode_pembayaran').value = this.dataset.method;
            });
        });

        document.getElementById('paymentForm').addEventListener('submit', function (e) {
            if (!document.getElementById('metode_pembayaran').value) {
                e.preventDefault();
                alert('Silakan pilih metode pembayaran.');
            }
        });
    </script>
</body>
</html>
