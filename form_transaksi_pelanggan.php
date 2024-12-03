<?php 
include "assets/header.php";
include "assets/sidebar.php";
include "assets/main.php";

$eror_name = "";
$eror_gender = "";
$eror_alamat = "";
$eror_tanggal = "";

$nama = $gender = $alamat = $tanggal = "";

if (isset($_GET['nama'])){
    $nama = $_GET['nama'];
    $gender = $_GET['gender'] ?? "";
    $alamat = $_GET['alamat'] ?? "";
    $tanggal = $_GET['transaksi'] ?? "";
}

if (isset($_POST['tambah'])) {
    $regex_nama = "/^[A-Za-z\s\-]+$/";
    $nama = $_POST['nama'] ?? "";
    $gender = $_POST['gender'] ?? "";
    $alamat = $_POST['address'] ?? "";
    $tanggal = $_POST['tanggal_transaksi'] ?? "";

    // Validasi
    if (empty($nama)) {
        $eror_name = "Nama harus diisi!";
    } elseif (!preg_match($regex_nama, $nama)) {
        $eror_name = "Nama harus berupa huruf!";
    }

    if (empty($gender)) {
        $eror_gender = "Jenis kelamin harus diisi!";
    }

    if (empty($alamat)) {
        $eror_alamat = "Alamat harus diisi!";
    }

    if (empty($tanggal)) {
        $eror_tanggal = "Tanggal harus diisi!";
    }

    if ($eror_name == "" && $eror_gender == "" && $eror_alamat == "" && $eror_tanggal == "") {
        echo "<script>
                window.location.href='detail_transaksi.php?nama=$nama&gender=$gender&alamat=$alamat&transaksi=$tanggal';
            </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
</head>
<body>
    <form action="" method="post">
        <div class="d-flex justify-content-center mt-5" style="font-family: Tahoma;">
            <div class="card" style="width: 40%; height: 50%;">
                <div class="card-header" style="background-color: #5A639C; color: white;">
                    <h3>Form Tambah Pelanggan</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                        <div>
                            <label for="search">Nama Pelanggan</label>
                            <input type="text" id="search" name="nama" class="form-control" placeholder="Cari.." value="<?= htmlspecialchars($nama) ?>">
                            <script>
                                $(document).ready(function() {
                                    $("#search").autocomplete({
                                        source: function(request, response) {
                                            $.ajax({
                                                url: "search_pelanggan.php",
                                                type: "GET",
                                                data: { term: request.term },
                                                dataType: "json",
                                                success: function(data) {
                                                    response(data);
                                                }
                                            });
                                        },
                                        minLength: 2
                                    });
                                });
                            </script>
                            <p id="eror_input" style="color: red;"><?= $eror_name ?></p>
                        </div>
                    </li>
                    <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                        <div>
                            <label>Jenis Kelamin</label>
                            <div>
                                <input type="radio" value="Laki-Laki" name="gender" <?= $gender == "Laki-Laki" ? 'checked' : "" ?>> Laki-Laki
                                <input type="radio" value="Perempuan" name="gender" <?= $gender == "Perempuan" ? 'checked' : "" ?>> Perempuan
                                <p id="eror_input" style="color: red;"><?= $eror_gender ?></p>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                        <div>
                            <label for="address">Alamat</label>
                            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($alamat) ?>">
                            <p id="eror_input" style="color: red;"><?= $eror_alamat ?></p>
                        </div>
                    </li>
                    <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                        <div>
                            <label for="tanggal_transaksi">Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" class="form-control" value="<?= htmlspecialchars($tanggal) ?>">
                            <p id="eror_input" style="color: red;"><?= $eror_tanggal ?></p>
                        </div>
                    </li>
                    <li class="list-group-item" style="background-color: #5A639C;">
                        <div class="mt-2 d-flex gap-2 justify-content-center p-2">
                            <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                            <button type="button" onclick="window.location.href='transaksi.php'" class="btn btn-danger">Batal</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</body>
</html>
