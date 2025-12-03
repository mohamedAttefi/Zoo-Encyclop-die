<?php
echo $_POST["modifier"];
include 'connection.php';
$new_animal_name = $_POST["animal_name"];
$new_image = $_POST["image"];
$new_habitat = $_POST["habitat"];
$new_type = $_POST["type"];
$id = $_POST["id"];


if (!empty($new_animal_name)) {
    $sql = "update animals set nom = '{$new_animal_name}' where animal_id = $id";
    $result = mysqli_query($conn, $sql);
}
if (!empty($new_image)) {
    $sql = "update animals set image = '{$new_image}' where animal_id = $id";
    $result = mysqli_query($conn, $sql);
}
if (!empty($new_habitat)) {
    $sql = "update animals set habitat_id = {$new_habitat} where animal_id = $id";
    $result = mysqli_query($conn, $sql);
}
if (!empty($new_type)) {
    $sql = "update animals set type_alimentaire = '{$new_type}' where animal_id = $id";
    $result = mysqli_query($conn, $sql);
}

if ($result) {
    echo 'success';
    header("location: index.php");
    exit;
} else {
    echo mysqli_error($conn);
}