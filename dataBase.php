<?php

$host = "localhost";
$dbName = "task";
$username = "root";
$password = "";

try {
    $connect = new PDO("mysql:host=$host;dbname=$dbName;",$username,$password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>