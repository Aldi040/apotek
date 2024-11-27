<?php
    $conn = mysqli_connect ("localhost","root","","apotek");
    if (!$conn){
        die("connection failed:" . mysqli_connect_error());
    }
?>