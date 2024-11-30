<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";

    if(!isset($_POST['show'])){
        $tanggal_awal = "2024-11-01";
        $tanggal_akhir = date("Y-m-d");
        $query = mysqli_query($conn, "SELECT * FROM transaksi WHERE TANGGAL_TRANSAKSI >= '$tanggal_awal' AND TANGGAL_TRANSAKSI <= '$tanggal_akhir'");
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        $data = [];
        $tanggal = [];
        foreach($result as $value){
            $data[] = $value['TOTAL_HARGA'];
            $tanggal[] = $value['TANGGAL_TRANSAKSI'];
        }
    }

    $error_date = "";
    if(isset($_POST['show'])){
        $tanggal_awal = $_POST['tanggal_awal'];
        $tanggal_akhir = $_POST['tanggal_akhir'];

        if(empty($tanggal_awal)){
            $tanggal_awal = "2024-11-01";
        }
        if(empty($tanggal_akhir)){
            $tanggal_akhir = date("Y-m-d");
        }
        if(empty($tanggal_awal) && empty($tanggal_akhir)){
            $tanggal_awal = "2024-11-01";
            $tanggal_akhir = date("Y-m-d");
        }
        
        $query = mysqli_query($conn, "SELECT * FROM transaksi WHERE TANGGAL_TRANSAKSI >= '$tanggal_awal' AND TANGGAL_TRANSAKSI <= '$tanggal_akhir'");
        $result = mysqli_fetch_all($query, MYSQLI_ASSOC);
        $data = [];
        $tanggal = [];
        foreach($result as $value){
            $data[] = $value['TOTAL_HARGA'];
            $tanggal[] = $value['TANGGAL_TRANSAKSI'];
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporting</title>


</head>
<body>
    <h1>Laporan Penjualan </h1>
    <form action="" method="post">
        <div style="width: 15%" class="d-flex gap-2 mt-5">
            <input type="date" class="form-control" name="tanggal_awal">
            <p>-</p>
            <input type="date" class="form-control" name="tanggal_akhir">
            <button class="btn btn-success" type="submit" name="show">Show</button>
        </div>
    </form>
    <div>
        <div class="chart">
            <canvas id="mychart"></canvas>
        </div>
    </div>

    <script>
        var chartLaporan = document.getElementById('mychart').getContext('2d');


        var gradient = chartLaporan.createLinearGradient(0, 0, 0, 500);
        gradient.addColorStop(0, 'rgba(75, 192, 192, 0.4)'); 
        gradient.addColorStop(1, 'rgba(153, 102, 255, 0.4)'); 

        new Chart(chartLaporan, {
            type: 'line',
            data: {
                labels: <?= json_encode($tanggal)?>,
                datasets: [{
                    label: 'Total',
                    data: <?= json_encode($data)?>,
                    fill: true, 
                    borderWidth: 2,
                    backgroundColor: gradient, 
                    borderColor: 'rgba(75, 192, 192, 1)', 
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)', 
                    pointBorderColor: 'rgba(255, 255, 255, 1)', 
                    pointHoverBackgroundColor: 'rgba(54, 162, 235, 1)', 
                    pointHoverBorderColor: 'rgba(255, 255, 255, 1)',
                    lineTension: 0.4,
        }]

        },
        options: {
            plugins : {
                legend : {
                    labels : {
                        color : "rgba(75, 192, 192, 1)",
                        font : {
                            size : 20,
                        }
                    }
                }
            },
            scales: {
                y: {
                beginAtZero: true,
                ticks: {
                        color: "rgba(75, 192, 192, 1)",
                        font : {
                            size: 14
                        }
                    },
                }, 
                x: {
                    ticks: {
                        color: "rgba(75, 192, 192, 1)",
                        font : {
                            size: 14
                        }
                    }
                }
            },
        }
    });
    </script>
</body>
</html>
<?php
    include "assets/footer.php";
?>