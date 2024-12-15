<?php

require_once 'database.php';


$sql = "SELECT * FROM students";
$stmt = $connect->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
    </style>

</head>

<body>

    <div class="container">
        <h2>ระบบแสดงผลคะแนนนักศึกษา</h2>
        <hr>

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
                            $grade = '';
                            if ($student['score'] >= 80) {
                                $grade = 'A';
                            } elseif ($student['score'] >= 70) {
                                $grade = 'B';
                            } elseif ($student['score'] >= 60) {
                                $grade = 'C';
                            } elseif ($student['score'] >= 50) {
                                $grade = 'D';
                            } else {
                                $grade = 'F';
                            }

                            echo "<tr>";
                            echo "<td>{$student['no']}</td>";
                            echo "<td>{$student['name']}</td>";
                            echo "<td>{$student['score']}</td>";
                            echo "<td>{$grade}</td>";
                            echo "<td>
                                <a href='edit.php?id={$student['id']}' class='btn btn-warning'>แก้ไข</a>
                                <a href='delete.php?id={$student['id']}' class='btn btn-danger'>ลบ</a>
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