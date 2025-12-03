<?php 
  include 'connection.php';

  $animal_name = strtolower($_POST["animal_name"]);
  $image = strtolower($_POST["image"]);
  $habitat = $_POST["habitat"];
  $type = strtolower($_POST["type"]);

  $sqlIsert = "insert into animals (nom, type_alimentaire, image, habitat_id) values ('$animal_name', '$type', '$image', $habitat);";
  $resultInsert = mysqli_query($conn, $sqlIsert);
  if($resultInsert){
    echo 'success';
    header('location: index.php');
    exit;
  }else{
    echo mysqli_error($conn);
  }

?>