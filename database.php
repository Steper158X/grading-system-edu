<?php

//connect to database use PDO
$database_name = getenv('DB_NAME') ?: 'students';
$database_user = getenv('DB_USER') ?: 'root';
$database_password = getenv('DB_PASSWORD') ?: 'root';

try {
    $connect = new PDO("mysql:host=localhost;dbname=$database_name", $database_user, $database_password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Connection failed: ' . $e->getMessage());
    die('Database connection error.');
}

