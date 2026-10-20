
<?php
function isValidScore($score) {
    return is_numeric($score) && $score >= 0 && $score <= 10;
}

function finalScore($cc, $mid, $final) {
    return $cc * 0.1 + $mid * 0.3 + $final * 0.6;
}

$name = $_POST['name'] ?? '';
$cc = $_POST['cc'] ?? '';
$mid = $_POST['mid'] ?? '';
$final = $_POST['final'] ?? '';

$error = '';
$result = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (trim($name) == '') {
        $error = 'Vui lòng nhập họ tên.';
    } elseif (
        !isValidScore($cc) ||
        !isValidScore($mid) ||
        !isValidScore($final)
    ) {
        $error = 'Điểm phải nằm trong khoảng từ 0 đến 10.';
    } else {
        $total = finalScore($cc, $mid, $final);

        if ($total >= 8) {
            $result = 'Giỏi';
        } elseif ($total >= 6.5) {
            $result = 'Khá';
        } elseif ($total >= 5) {
            $result = 'Trung bình';
        } else {
            $result = 'Chưa đạt';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Máy tính điểm học phần</title>
</head>
<body>
    <h2>Máy tính điểm học phần</h2>

    <form method="post">
        Họ tên:
        <input type="text" name="name"
               value="<?= htmlspecialchars($name) ?>" required>
        <br><br>

        Điểm chuyên cần:
        <input type="number" name="cc" min="0" max="10"
               step="any"
               value="<?= htmlspecialchars($cc) ?>" required>
        <br><br>

        Điểm giữa kỳ:
        <input type="number" name="mid" min="0" max="10"
               step="any"
               value="<?= htmlspecialchars($mid) ?>" required>
        <br><br>

        Điểm cuối kỳ:
        <input type="number" name="final" min="0" max="10"
               step="any"
               value="<?= htmlspecialchars($final) ?>" required>
        <br><br>

        <button type="submit">Tính điểm</button>
    </form>

    <?php if ($error != ''): ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <?php if ($result != ''): ?>
        <h3>Kết quả</h3>
        <p>Họ tên: <?= htmlspecialchars($name) ?></p>
        <p>Điểm tổng kết: <?= round($total, 2) ?></p>
        <p>Xếp loại: <?= $result ?></p>
    <?php endif; ?>
</body>
</html>
