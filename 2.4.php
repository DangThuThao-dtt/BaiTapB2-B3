
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mảng sinh viên PHP</title>
</head>
<body>
    <h2>DANH SÁCH SINH VIÊN</h2>

    <?php
    $students = [
        ['name' => 'An', 'score' => 8.0],
        ['name' => 'Binh', 'score' => 6.5],
        ['name' => 'Chi', 'score' => 4.5]
    ];

    foreach ($students as $student) {
        echo "Tên: " . $student['name'];
        echo " - Điểm: " . $student['score'];
        echo "<br>";
    }
    ?>
</body>
</html>
