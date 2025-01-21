<?php
$hostname = "localhost";
$port = 3306;
$username = "root";
$dbPassword = "";
try{
    $conn = new PDO("mysql:host=$hostname; port = $port; dbname=athlete_edge;", $username, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}

?>