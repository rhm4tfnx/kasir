<?php 

    require "functions.php";
    $id = $_GET['id'];
    $query = mysqli_query($conn, "DELETE FROM checkout WHERE id = $id");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script>
        document.location.href = 'index.php';
        </script>";
    }
?>