
<?php
function calculateAverage(float $midterm, float $final): float {
    return ($midterm + $final) / 2;
}

$students = [
    ['name' => 'An', 'midterm' => 8, 'final' => 9],
    ['name' => 'Binh', 'midterm' => 6, 'final' => 5],
    ['name' => 'Chi', 'midterm' => 4, 'final' => 3]
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng điểm sinh viên</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #999; padding: 10px; text-align: center; }
        th { background: #b0003b; color: white; }
    </style>
</head>
<body>
    <h2>BẢNG ĐIỂM 3 SINH VIÊN</h2>

    <table>
        <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>Giữa kỳ</th>
            <th>Cuối kỳ</th>
            <th>Trung bình</th>
            <th>Kết quả</th>
        </tr>

        <?php foreach ($students as $index => $student): ?>
            <?php
            $average = calculateAverage(
                $student['midterm'],
                $student['final']
            );
            ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= $student['midterm'] ?></td>
                <td><?= $student['final'] ?></td>
                <td><?= number_format($average, 2) ?></td>
                <td><?= $average >= 5 ? 'Đạt' : 'Chưa đạt' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
