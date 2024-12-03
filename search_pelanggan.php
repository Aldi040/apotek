<?php
include 'connect.php';

if (isset($_GET['term'])) {
    $search = mysqli_real_escape_string($conn, $_GET['term']);
    $query = "SELECT NAMA_PELANGGAN FROM pelanggan WHERE NAMA_PELANGGAN LIKE '%$search%' LIMIT 10";
    $result = mysqli_query($conn, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['NAMA_PELANGGAN'];
    }

    echo json_encode($data); // Output dalam format JSON
}
?>
