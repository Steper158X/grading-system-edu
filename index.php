<?php
session_start(); // Start session for CSRF token and error messages
require_once 'database.php';
require_once 'includes/functions.php'; // <-- ADDED HERE

// Generate CSRF token 
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$sql = "SELECT * FROM students";
$stmt = $connect->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check for error messages from other pages (like delete.php)
$error_message = '';
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the message after displaying
}

// Check for success messages
$success_message = '';
if (isset($_GET['status']) && $_GET['status'] === 'deleted_successfully') {
    $success_message = 'Student deleted successfully!';
}
if (isset($_GET['status']) && $_GET['status'] === 'created_successfully') {
    $success_message = 'Student added successfully!';
}
if (isset($_GET['status']) && $_GET['status'] === 'updated_successfully') {
    $success_message = 'Student updated successfully!';
}

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแสดงผลคะแนนนักศึกษา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            padding: 4rem 0rem;
        }

        th,
        td {
            vertical-align: middle;
        }
        .action-buttons form {
            margin-bottom: 0; /* Remove bottom margin for inline forms */
        }
    </style>

</head>

<body>

    <div class="container">
        <h2>ระบบแสดงผลคะแนนนักศึกษา</h2>
        <hr>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <a href="create.php" class="btn btn-primary">เพิ่มข้อมูลนักศึกษาใหม่</a>

        <?php if ($students) { ?>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">ไอดีนักศึกษา</th>
                            <th scope="col">ชื่อ-สกุล</th>
                            <th scope="col">คะแนน</th>
                            <th scope="col">เกรด</th>
                            <th scope="col">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($students as $student) {
                            // MODIFIED HERE: Use the calculateGrade function
                            $grade = calculateGrade($student['score']); 

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($student['no']) . "</td>";
                            echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                            echo "<td>" . htmlspecialchars((string)$student['score']) . "</td>";
                            echo "<td>" . htmlspecialchars($grade) . "</td>";
                            echo "<td class='action-buttons'>
                                <a href='edit.php?id={$student['id']}' class='btn btn-warning btn-sm'>แก้ไข</a>
                                <form action='delete.php' method='POST' style='display: inline-block; margin-left: 5px;'>
                                    <input type='hidden' name='id' value='{$student['id']}'>
                                    <input type='hidden' name='csrf_token' value='" . htmlspecialchars($csrf_token) . "'>
                                    <button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete student " . htmlspecialchars(addslashes($student['name']), ENT_QUOTES) . "?');\">ลบ</button>
                                </form>
                                </td>";
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>

        <?php } else { ?>

            <div class="alert alert-danger mt-3 text-center" role="alert">
                ไม่พบข้อมูลนักศึกษา
            </div>

        <?php } ?>


    </div>

</body>

</html>