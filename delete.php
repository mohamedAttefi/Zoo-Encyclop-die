<?php 
    include 'connection.php';

    $id = $_POST["delete"];
    $sqlDelete = "delete from animals where animal_id = $id;";
    $resultDelete = mysqli_query($conn, $sqlDelete);
    if($resultDelete){
        echo 'success';
        header('location: index.php');
    }
    else{
        echo mysqli_error($conn);
    }
?>