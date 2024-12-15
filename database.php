<?php

//connect to database use PDO
$database_name = "students";
$database_user = "root";
$database_password = "root";

try {
    $connect = new PDO("mysql:host=localhost;dbname=$database_name", $database_user, $database_password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<script>alert('Connection failed: " . $e->getMessage() . "')</script>";
}
