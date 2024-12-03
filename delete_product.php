<?php 
    require 'connect.php';
    $id = $_GET['id'];
    $query = "DELETE FROM transaksi WHERE ID_TRANSAKSI='$id'";

    if (mysqli_query($conn, $query)) {
    echo "<script>
        window.location.href='transaksi.php';
    </script>";
    }
?>