<?php

require_once 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM students WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: index.php');
    } else {
        echo "<script>alert('ลบข้อมูลไม่สำเร็จ')</script>";
    }
} else {
    header('Location: index.php');
}
