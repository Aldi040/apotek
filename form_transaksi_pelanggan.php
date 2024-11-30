<?php 
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";


    if (isset($_GET['nama'])){
        $nama = $_GET['nama'];
        $gender = $_GET['gender'];
        $alamat = $_GET['alamat'];
        $tanggal_transaksi = $_GET['transaksi'];
    }

    $eror_name = "";
    $eror_gender = "";
    $eror_alamat = "";
    $eror_tanggal = "";
    if(isset($_POST['tambah'])){
        $regex_nama = "/^[A-Za-z\s\-]+$/";
        $nama= $_POST['nama'];
        $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
        $alamat = $_POST['address'];
        $tanggal = $_POST['tanggal_transaksi'];

        if(empty($nama)){
            $eror_name = "Nama harus diisi!";
        }
        if(!preg_match($regex_nama, $nama)){
            $eror_name = "Nama harus berupa huruf!";
        }
        if(empty($gender)){
            $eror_gender = "Jenis kelamin harus diisi!";
        }
        
        if(empty($alamat)){
            $eror_alamat = "Alamat harus diisi!";
        }

        if(empty($tanggal)){
            $eror_tanggal = "Tanggal harus diisi";
        }

        if($eror_name == "" && $eror_gender == "" && $eror_alamat == "" && $eror_tanggal == ""){
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
</head>
<body>
    <form action="" method="post">
    <div></div>
    <div class="d-flex justify-content-center mt-5" style="font-family: Tahoma;">
    <div class="card" style="width: 40%; height: 50%;">
        <div class="card-header" style="background-color: #5A639C; color: white;">
            <h3>Form Tambah Pelanggan</h3>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                <div>
                    <label for="">Nama Pelanggan</label>
                    <input type="text" name="nama" class="form-control" value="<?= isset($_GET['nama']) ? $_GET['nama'] : ""?>">
                    <p id="eror_input"><?= $eror_name ?></p>
                </div>
            </li>
            <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                <div>
                    <label for="">Jenis Kelamin</label>
                    <div>
                        <input type="radio" value="Laki-Laki" name="gender" class="me-1" <?= isset($_GET['gender']) && $_GET['gender'] == "Laki-Laki"? 'checked' : ""  ?>> <label for="">Laki-Laki</label>
                        <input type="radio" value="Perempuan" name="gender" class="mx-1" <?= isset($_GET['gender']) && $_GET['gender'] == "Perempuan"? 'checked' : ""  ?>> <label for="">Perempuan</label>
                        <p id="eror_input"><?= $eror_gender ?></p>
                    </div>
                </div>
            </li>
            <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                <div>
                    <label for="">Alamat</label>
                    <input type="text" name="address" class="form-control" value="<?= isset($_GET['alamat']) ? $_GET['alamat'] : ""?>">
                    <p id="eror_input"><?= $eror_alamat ?></p>
                </div>

            </li>
            <li class="list-group-item" style="background-color: #7D8ABC; color: white;">
                <div>
                    <label for="">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" class="form-control" value="<?= isset($_GET['transaksi']) ? $_GET['transaksi'] : ""?>">
                    <p id="eror_input"><?= $eror_tanggal ?></p>
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