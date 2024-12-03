<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";
    
    // Ambil tanggal pertama dari database dan tanggal terakhir adalah hari ini
    $query_mingguan = mysqli_query($conn, "
        SELECT 
            CASE 
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 1 AND 7 THEN 1
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 8 AND 14 THEN 2
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 15 AND 21 THEN 3
                ELSE 4
            END AS minggu,
            SUM(TOTAL_HARGA) AS total
        FROM transaksi 
        WHERE MONTH(TANGGAL_TRANSAKSI) = MONTH(CURDATE())
            AND YEAR(TANGGAL_TRANSAKSI) = YEAR(CURDATE())
        GROUP BY minggu
        ORDER BY minggu ASC
        LIMIT 4
    ");
$query_bulanan = mysqli_query($conn, "SELECT MONTH(TANGGAL_TRANSAKSI) AS bulan, COUNT(*) AS total FROM transaksi GROUP BY MONTH(TANGGAL_TRANSAKSI)");
$query_tahunan = mysqli_query($conn, "SELECT YEAR(TANGGAL_TRANSAKSI) AS tahun, COUNT(*) AS total FROM transaksi GROUP BY YEAR(TANGGAL_TRANSAKSI)");


$bulanan = [];
$tahunan = [];
$bulan_labels = [];
$tahun_labels = [];
$bulan_sekarang = date("n"); // Mendapatkan bulan saat ini
$mingguan = array_fill(0, 4, 0); // Initialize array with 4 zeros
$minggu_labels = [];
$bulan_sekarang = date("F"); // Get current month name

// Create labels for 4 weeks
for ($i = 1; $i <= 4; $i++) {
    $minggu_labels[] = "Minggu ke-" . $i;
}

// Fill in actual data
while ($row = mysqli_fetch_assoc($query_mingguan)) {
    $week_index = $row['minggu'] - 1;
    if ($week_index >= 0 && $week_index < 4) {
        $mingguan[$week_index] = $row['total'];
    }
}

while ($row = mysqli_fetch_assoc($query_bulanan)) {
    $bulanan[] = $row['total'];
    $bulan_name = date("F", mktime(0, 0, 0, $row['bulan'], 1));
    $bulan_labels[] = $bulan_name;
}

while ($row = mysqli_fetch_assoc($query_tahunan)) {
    $tahunan[] = $row['total'];
    $tahun_labels[] = "Tahun " . $row['tahun'];
}
    if(!isset($_POST['show'])){
        // Query untuk mendapatkan tanggal pertama dari transaksi
        $query = mysqli_query($conn, "SELECT MIN(TANGGAL_TRANSAKSI) AS tanggal_awal FROM transaksi");
        $result = mysqli_fetch_assoc($query);
        
        // Tanggal awal adalah tanggal pertama yang ada di transaksi, tanggal akhir adalah hari ini
        $tanggal_awal = $result['tanggal_awal'] ? $result['tanggal_awal'] : "2024-11-01"; // Default tanggal awal jika kosong
        $tanggal_akhir = date("Y-m-d"); // Tanggal hari ini

        // Ambil data transaksi dalam rentang tanggal yang ditemukan
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

    // Query untuk pendapatan hari ini
    $query_hari = mysqli_query($conn, "
        SELECT SUM(TOTAL_HARGA) as total 
        FROM transaksi 
        WHERE DATE(TANGGAL_TRANSAKSI) = CURDATE()
    ");
    $pendapatan_hari = mysqli_fetch_assoc($query_hari);

    // Query untuk pendapatan minggu ini (update query)
    $query_minggu = mysqli_query($conn, "
        SELECT 
            CASE 
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 1 AND 7 THEN 1
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 8 AND 14 THEN 2
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 15 AND 21 THEN 3
                ELSE 4
            END AS minggu,
            SUM(TOTAL_HARGA) as total 
        FROM transaksi 
        WHERE MONTH(TANGGAL_TRANSAKSI) = MONTH(CURDATE())
        AND YEAR(TANGGAL_TRANSAKSI) = YEAR(CURDATE())
        AND CASE 
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 1 AND 7 THEN 1
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 8 AND 14 THEN 2
                WHEN DAY(TANGGAL_TRANSAKSI) BETWEEN 15 AND 21 THEN 3
                ELSE 4
            END = CASE 
                WHEN DAY(CURDATE()) BETWEEN 1 AND 7 THEN 1
                WHEN DAY(CURDATE()) BETWEEN 8 AND 14 THEN 2
                WHEN DAY(CURDATE()) BETWEEN 15 AND 21 THEN 3
                ELSE 4
            END
    ");
    $pendapatan_minggu = mysqli_fetch_assoc($query_minggu);

    // Query untuk pendapatan bulan ini
    $query_bulan = mysqli_query($conn, "
        SELECT SUM(TOTAL_HARGA) as total 
        FROM transaksi 
        WHERE MONTH(TANGGAL_TRANSAKSI) = MONTH(CURDATE())
        AND YEAR(TANGGAL_TRANSAKSI) = YEAR(CURDATE())
    ");
    $pendapatan_bulan = mysqli_fetch_assoc($query_bulan);

    // Query untuk pendapatan tahun ini
    $query_tahun = mysqli_query($conn, "
        SELECT SUM(TOTAL_HARGA) as total 
        FROM transaksi 
        WHERE YEAR(TANGGAL_TRANSAKSI) = YEAR(CURDATE())
    ");
    $pendapatan_tahun = mysqli_fetch_assoc($query_tahun);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



        <style>
        body {
            background-color: #1a2236;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        /* Menu Card Styles */
        .menu-card {
            display: flex;
            align-items: center;
            background-color: #283046;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            padding: 15px 20px;
            margin: 10px 0;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
        }

        .menu-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: #fff;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .menu-content {
            flex: 1;
        }

        .menu-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
        }

        .menu-subtitle {
            font-size: 0.9rem;
            color: #d3d3d3;
        }

        /* Custom Colors */
        .icon-green {
            background-color: #28a745;
        }

        .icon-orange {
            background-color: #ff9800;
        }

        .icon-red {
            background-color: #dc3545;
        }

        .icon-blue {
            background-color: #007bff;
        }

        /* Chart Section */
        .chart-container {
            background-color: #283046;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin-top: 20px;
            width: 100%;
            height: 400px;
            /* Increased height */
        }

        /* Table Section */
        .table-container {
            background-color: #283046;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin-top: 20px;
        }

        /* Trophy Icon Styles */
        .ranking-number {
            font-weight: bold;
            font-size: 1.2em;
            margin: 0 auto;
        }

        .rank-1 {
            color: #FFD700;
        }

        /* Gold */
        .rank-2 {
            color: #C0C0C0;
        }

        /* Silver */
        .rank-3 {
            color: #CD7F32;
        }

        /* Bronze */

        .revenue-label {
            font-size: 1.1rem;
            font-weight: bold;
            color: #fafbfc;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .revenue-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4CAF50;
            margin: 12px 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .revenue-period {
            font-size: 0.9rem;
            color: #a3a3a3;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        </style>
    </head>

    <body>
        <h1>DASHBOARD</h1>
        <div class="container mt-5">
            <!-- Menu Cards -->

            <div class="row">
                <div class="col-md-3">
                    <a href="obat.php" class="text-decoration-none">
                        <div class="menu-card">
                            <div class="menu-icon icon-green">
                                <i class="bi bi-hospital"></i>
                            </div>
                            <div class="menu-content">
                                <div class="menu-title">Obat</div>
                                <div class="menu-subtitle">Info Stok</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="supplier.php" class="text-decoration-none">
                        <div class="menu-card">
                            <div class="menu-icon icon-orange">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="menu-content">
                                <div class="menu-title">Supplier</div>
                                <div class="menu-subtitle">Data Vendor</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="pelanggan.php" class="text-decoration-none">
                        <div class="menu-card">
                            <div class="menu-icon icon-red">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="menu-content">
                                <div class="menu-title">Pelanggan</div>
                                <div class="menu-subtitle">Info Member</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="transaksi.php" class="text-decoration-none">
                        <div class="menu-card">
                            <div class="menu-icon icon-blue">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div class="menu-content">
                                <div class="menu-title">Transaksi</div>
                                <div class="menu-subtitle">Laporan</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Revenue Information -->
            <div class="row mt-4">
                <!-- Daily Revenue -->
                <div class="col-md-3">
                    <div class="menu-card">
                        <div class="menu-icon icon-purple">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="menu-content">
                            <div class="revenue-label">
                                <span>Pendapatan Hari Ini</span>
                            </div>
                            <div class="revenue-amount">
                                <i class="bi bi-currency-dollar"></i>
                                <span>Rp.
                                    <?php echo number_format($pendapatan_hari['total'] ?? 0, 0, ',', '.'); ?></span>
                            </div>
                            <div class="revenue-period">
                                <i class="bi bi-clock"></i>
                                <span><?php echo date('d M Y'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Revenue -->
                <div class="col-md-3">
                    <div class="menu-card">
                        <div class="menu-icon icon-cyan">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="menu-content">
                            <div class="revenue-label">
                                </i>Pendapatan Minggu Ini
                            </div>
                            <div class="revenue-amount">
                                <i class="bi bi-currency-dollar me-1"></i>
                                Rp. <?php echo number_format($pendapatan_minggu['total'] ?? 0, 0, ',', '.'); ?>
                            </div>
                            <div class="revenue-period">
                                <i class="bi bi-calendar3 me-1"></i>
                                <?php 
                                $currentDay = date('j');
                                $currentWeek = 
                                    $currentDay <= 7 ? 1 : 
                                    ($currentDay <= 14 ? 2 : 
                                    ($currentDay <= 21 ? 3 : 4));
                                echo "Minggu ke-" . $currentWeek . " " . date('F');
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="col-md-3">
                    <div class="menu-card">
                        <div class="menu-icon icon-pink">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <div class="menu-content">
                            <div class="revenue-label">
                                Pendapatan Bulan Ini
                            </div>
                            <div class="revenue-amount">
                                <i class="bi bi-currency-dollar me-1"></i>
                                Rp. <?php echo number_format($pendapatan_bulan['total'] ?? 0, 0, ',', '.'); ?>
                            </div>
                            <div class="revenue-period">
                                <i class="bi bi-calendar3-event me-1"></i><?php echo date('F Y'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Yearly Revenue -->
                <div class="col-md-3">
                    <div class="menu-card">
                        <div class="menu-icon icon-gold">
                            <i class="bi bi-pie-chart"></i>
                        </div>
                        <div class="menu-content">
                            <div class="revenue-label">
                                <i class="bi bi-calendar-year me-2"></i>Pendapatan Tahun Ini
                            </div>
                            <div class="revenue-amount">
                                <i class="bi bi-currency-dollar me-1"></i>
                                Rp. <?php echo number_format($pendapatan_tahun['total'] ?? 0, 0, ',', '.'); ?>
                            </div>
                            <div class="revenue-period">
                                <i class="bi bi-calendar4-range me-1"></i>Tahun <?php echo date('Y'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-md-4">
                    <div class="chart-container">
                        <canvas id="mingguanChart"></canvas>
                    </div>
                </div>

                <!-- Chart Bulanan -->
                <div class="col-md-4">
                    <div class="chart-container">
                        <canvas id="bulananChart"></canvas>
                    </div>
                </div>

                <!-- Chart Tahunan -->
                <div class="col-md-4">
                    <div class="chart-container">
                        <canvas id="tahunanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="row mt-4">
            <!-- Top Obat Table -->
            <div class="col-md-4">
                <div class="table-container">
                    <h5>Top Obat</h5>
                    <table class="ranking-table">
                        <thead>
                            <tr>
                            <th colspan="2" style="text-align: center;">Nama Obat</th>

                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    // Fetch top 3 medicines based on quantity
                    $query_top_obat = "SELECT NAMA_OBAT, JUMLAH_STOCK FROM obat ORDER BY JUMLAH_STOCK DESC LIMIT 3";
                    $result_top_obat = mysqli_query($conn, $query_top_obat);
                    $rank = 1;

                    while ($row = mysqli_fetch_assoc($result_top_obat)) {
                        echo "<tr class='ranking-row-$rank'>";
                        echo "<td><div class='ranking-number rank-$rank'><i class='fas fa-trophy'></i></div></td>";
                        echo "<td>{$row['NAMA_OBAT']}</td>";
                        echo "<td>{$row['JUMLAH_STOCK']}</td>";
                        echo "</tr>";
                        $rank++;
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Supplier Table -->
            <div class="col-md-4">
                <div class="table-container">
                    <h5>Top Supplier</h5>
                    <table>
                        <tbody>
                            <?php
                    // Fetch top 3 suppliers
                    $query_top_supplier = "SELECT NAMA_SUPPLIER, KATREGORI FROM supplier JOIN obat ON supplier.ID_SUPPLIER = obat.ID_SUPPLIER GROUP BY NAMA_SUPPLIER ORDER BY COUNT(obat.ID_SUPPLIER) DESC LIMIT 3";
                    $result_top_supplier = mysqli_query($conn, $query_top_supplier);
                    $rank = 1;

                    while ($row = mysqli_fetch_assoc($result_top_supplier)) {
                        echo "<tr class='ranking-row-$rank'>";
                        echo "<td><div class='ranking-number rank-$rank'><i class='fas fa-trophy'></i></div></td>";
                        echo "<td>{$row['NAMA_SUPPLIER']}</td>";
                       
                        echo "</tr>";
                        $rank++;
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Transaksi Table -->
            <div class="col-md-4">
                <div class="table-container">
                    <h5>Transaksi Terkini</h5>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    // Fetch latest transactions
                    $query_transaksi = "SELECT TANGGAL_TRANSAKSI, TOTAL_HARGA FROM transaksi ORDER BY TANGGAL_TRANSAKSI DESC LIMIT 5";
                    $result_transaksi = mysqli_query($conn, $query_transaksi);
                    $count = 1;

                    while ($row = mysqli_fetch_assoc($result_transaksi)) {
                        echo "<tr>";
                        echo "<td>{$count}</td>";
                        echo "<td>{$row['TANGGAL_TRANSAKSI']}</td>";
                        echo "<td>Rp. " . number_format($row['TOTAL_HARGA'], 0, ',', '.') . "</td>";
                        echo "</tr>";
                        $count++;
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>

        <!-- Bootstrap JS & Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        // Chart Mingguan
        var ctxMingguan = document.getElementById('mingguanChart').getContext('2d');
        var mingguanChart = new Chart(ctxMingguan, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($minggu_labels); ?>,
                datasets: [{
                    label: 'Total Penjualan Mingguan',
                    data: <?php echo json_encode($mingguan); ?>,
                    backgroundColor: [
                        '#4CAF50', // Week 1 - Green
                        '#2196F3', // Week 2 - Blue
                        '#FFC107', // Week 3 - Yellow
                        '#F44336' // Week 4 - Red
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff'
                        }
                    }
                }
            }
        });

        // Chart Bulanan
        var ctxBulanan = document.getElementById('bulananChart').getContext('2d');
        var bulananChart = new Chart(ctxBulanan, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($bulan_labels); ?>,
                datasets: [{
                    label: 'Jumlah Pelanggan Bulanan',
                    data: <?php echo json_encode($bulanan); ?>,
                    backgroundColor: [
                        '#FF6B6B', // Red
                        '#4ECDC4', // Turquoise
                        '#45B7D1', // Light Blue
                        '#96CEB4', // Sage Green
                        '#FFEEAD', // Light Yellow
                        '#D4A5A5', // Dusty Rose
                        '#9ED2C6', // Seafoam
                        '#FF9F1C', // Orange
                        '#A06CD5', // Purple
                        '#7DDF64', // Green
                        '#FF8C42', // Coral
                        '#6C88C4' // Blue Gray
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Chart Tahunan
        var ctxTahunan = document.getElementById('tahunanChart').getContext('2d');
        var tahunanChart = new Chart(ctxTahunan, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($tahun_labels); ?>,
                datasets: [{
                    label: 'Jumlah Pelanggan Tahunan',
                    data: <?php echo json_encode($tahunan); ?>,
                    backgroundColor: [
                        '#FF6384', // 2024 - Pink
                        '#36A2EB', // 2023 - Blue
                        '#FFCE56', // 2022 - Yellow
                        '#4BC0C0', // 2021 - Turquoise
                        '#9966FF', // Additional color if needed
                        '#FF9F40' // Additional color if needed
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
        </script>
    </body>

</html>
<?php
    include 'assets/footer.php';
?>