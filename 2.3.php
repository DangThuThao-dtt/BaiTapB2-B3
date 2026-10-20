
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xếp loại học lực</title>
</head>
<body>
    <h2>XẾP LOẠI ĐIỂM HỌC SINH</h2>

    <form method="post">
        <label>Nhập điểm:</label>
        <input type="number" name="diem" min="0" max="10"
               step="any" required>
        <button type="submit">Xếp loại</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $diem = $_POST["diem"];

        if (is_numeric($diem) && $diem >= 0 && $diem <= 10) {
            if ($diem >= 8) {
                $xeploai = "Giỏi";
            } elseif ($diem >= 6.5) {
                $xeploai = "Khá";
            } elseif ($diem >= 5) {
                $xeploai = "Trung bình";
            } else {
                $xeploai = "Chưa đạt";
            }

            echo "<h3>Điểm: $diem</h3>";
            echo "<h3>Xếp loại: $xeploai</h3>";
        } else {
            echo "<p>Điểm không hợp lệ! Hãy nhập điểm từ 0 đến 10.</p>";
        }
    }
    ?>
</body>
</html>
