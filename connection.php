<?php 
$host = 'localhost';
$username = 'root';
$password = 'ME551234';
$dbName = 'company_db';
$port = 3307;

$conn = new mysqli($host, $username, $password, $dbName, $port);

if($conn->connect_error){
    echo $conn->connect_error;
}
?>