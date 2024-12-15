<?php

require_once 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM students WHERE id = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        try {

            $student_id = $_POST['student_id'];
            $student_name = $_POST['student_name'];
            $student_score = $_POST['student_score'];

            $sql = "UPDATE students SET no = :student_id, name = :student_name, score = :student_score WHERE id = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
            $stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
            $stmt->bindParam(':student_score', $student_score, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: index.php');
        } catch (PDOException $e) {
            echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ: " . $e->getMessage() . "')</script>";
        }
    } else {
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลนักศีกษา | ระบบแสดงผลคะแนนนักศึกษา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        body {
            font-family: 'Sarabun', sans-serif;
            padding: 4rem 0rem;
        }
    </style>

</head>

<body>

    <div class="container">
        <h2>แก้ไขข้อมูลนักศึกษา</h2>
        <hr>

        <form class="row row-gap-2" action="" method="POST">

            <div class="form-group">
                <label for="student_id">ไอดีนักศึกษา</label>
                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="ไอดีนักศึกษา" value="<?php echo $student['no']  ?>" required>
            </div>

            <div class="form-group">
                <label for="student_name">ชื่อ - สกุล</label>
                <input type="text" class="form-control" id="student_name" name="student_name" placeholder="ชื่อ - สกุล" value="<?php echo $student['name']  ?>" required>
            </div>

            <div class="form-group">
                <label for="student_score">คะแนน</label>
                <input type="number" class="form-control" id="student_score" name="student_score" placeholder="คะแนน" value="<?php echo $student['score']  ?>" min="0" max="100" required>
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary w-100">บันทึกข้อมูล</button>
                <a href="index.php" class="btn btn-secondary w-100 mt-3">กลับหน้าหลัก</a>
            </div>

        </form>


    </div>

</body>

</html>