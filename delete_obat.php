<?php 
    require 'connect.php';
    $id = $_GET['id'];
    $query_obat = mysqli_query($conn, "SELECT * FROM pembelian_obat WHERE ID_OBAT ='$id'");

    if(mysqli_num_rows($query_obat) > 0){
        echo "<script>
            alert('This item can\'t be deleted!');
            window.location.href='obat.php'; 
        </script>";
        exit(); 
    }else{
        $query = "DELETE FROM obat WHERE ID_OBAT='$id'";
    
        if (mysqli_query($conn, $query)) {
        echo "<script>
            window.location.href='obat.php';
        </script>";
        }
        exit();
    }
?>
