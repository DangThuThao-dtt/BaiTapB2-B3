
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tính điểm tổng kết</title>
</head>
<body>
    <h2>TÍNH ĐIỂM TỔNG KẾT</h2>

    <form method="post">
        <label>Điểm chuyên cần:</label>
        <input type="number" name="cc" min="0" max="10"
               step="any" required>
        <br><br>

        <label>Điểm giữa kỳ:</label>
        <input type="number" name="mid" min="0" max="10"
               step="any" required>
        <br><br>

        <label>Điểm cuối kỳ:</label>
        <input type="number" name="final" min="0" max="10"
               step="any" required>
        <br><br>

        <button type="submit">Tính điểm</button>
    </form>

    <?php
    function finalScore(float $cc, float $mid, float $final): float
    {
        return $cc * 0.10 + $mid * 0.30 + $final * 0.60;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cc = $_POST["cc"];
        $mid = $_POST["mid"];
        $final = $_POST["final"];

        if (
            is_numeric($cc) && $cc >= 0 && $cc <= 10 &&
            is_numeric($mid) && $mid >= 0 && $mid <= 10 &&
            is_numeric($final) && $final >= 0 && $final <= 10
        ) {
            $diemTongKet = finalScore(
                (float)$cc,
                (float)$mid,
                (float)$final
            );

            echo "<h3>Điểm tổng kết: "
                . number_format($diemTongKet, 2)
                . "</h3>";
        } else {
            echo "<p>Vui lòng nhập các điểm từ 0 đến 10!</p>";
        }
    }
    ?>
</body>
</html>
