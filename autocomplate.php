<?php
include "dataBase.php";

// Arama terimi
$searchTerm = $_GET['searchTerm'];

// Veritabanından önerileri al
$sql = "SELECT name FROM personals WHERE name LIKE :searchTerm";
$conn = $connect->prepare($sql);

$searchTerm = "%" . $searchTerm . "%"; // Arama terimini düzgün bir şekilde biçimlendir
$conn->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$conn->execute();

$results = $conn->fetchAll(PDO::FETCH_ASSOC);

// JSON olarak sonuçları döndür
echo json_encode($results);
?>
