<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
        .icon-green { background-color: #28a745; }
        .icon-orange { background-color: #ff9800; }
        .icon-red { background-color: #dc3545; }
        .icon-blue { background-color: #007bff; }

        /* Chart Section */
        .chart-container {
            background-color: #283046;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin-top: 20px;
        }

        /* Table Section */
        .table-container {
            background-color: #283046;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin-top: 20px;
        }

        .table {
            color: #fff;
        }

        .table th {
            color: #d3d3d3;
        }
    </style>
</head>
<body>
    <h1>DASHBOARD</h1>
    <div class="container mt-5">
        <!-- Menu Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="menu-card">
                    <div class="menu-icon icon-green">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Obat</div>
                        <div class="menu-subtitle">Info Stok</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card">
                    <div class="menu-icon icon-orange">
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Supplier</div>
                        <div class="menu-subtitle">Data Vendor</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card">
                    <div class="menu-icon icon-red">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Pelanggan</div>
                        <div class="menu-subtitle">Info Member</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="menu-card">
                    <div class="menu-icon icon-blue">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="menu-content">
                        <div class="menu-title">Transaksi</div>
                        <div class="menu-subtitle">Laporan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="row mt-4">
            <!-- Top Obat Table -->
            <div class="col-md-4">
                <div class="table-container">
                    <h5>Top Obat</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Obat</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Paracetamol</td>
                                <td>120</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Amoxicillin</td>
                                <td>85</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Cetirizine</td>
                                <td>65</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Supplier Table -->
            <div class="col-md-4">
                <div class="table-container">
                    <h5>Top Supplier</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Supplier</th>
                                <th>Jumlah Pasokan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>PT Pharma</td>
                                <td>500</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Bio Medika</td>
                                <td>450</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Apotek Sehat</td>
                                <td>300</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Pelanggan Table -->
            <div class="col-md-4">
                <div class="table-container">
                    <h5>Top Pelanggan</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>Jumlah Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Michael Lee</td>
                                <td>10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Sales',
                    data: [10, 20, 15, 25, 30, 20, 35],
                    borderColor: '#28a745',
                    borderWidth: 2,
                    fill: false
                }]
            }
        });
    </script>
</body>
</html>

<?php
    include "assets/footer.php";
?>