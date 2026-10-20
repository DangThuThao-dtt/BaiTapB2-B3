
<?php
function money(float $value): string {
    return number_format($value, 0, ',', '.') . ' đ';
}

$name = '';
$qty = '';
$price = '';
$total = null;
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $qtyInput = $_POST['qty'] ?? '';
    $priceInput = $_POST['price'] ?? '';

    if ($name === '') {
        $error = 'Vui lòng nhập tên tài liệu.';
    } elseif (!filter_var($qtyInput, FILTER_VALIDATE_INT)
        || (int)$qtyInput < 1) {
        $error = 'Số lượng phải là số nguyên lớn hơn 0.';
    } elseif (!is_numeric($priceInput) || (float)$priceInput < 0) {
        $error = 'Đơn giá phải là số không âm.';
    } else {
        $qty = (int)$qtyInput;
        $price = (float)$priceInput;
        $total = $qty * $price;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn học liệu</title>
</head>
<body>
    <h2>HÓA ĐƠN HỌC LIỆU</h2>

    <form method="post">
        <p>
            Tên tài liệu:
            <input name="name"
                   value="<?= htmlspecialchars($name) ?>" required>
        </p>
        <p>
            Số lượng:
            <input type="number" name="qty" min="1"
                   value="<?= htmlspecialchars((string)$qty) ?>"
                   required>
        </p>
        <p>
            Đơn giá:
            <input type="number" name="price" min="0" step="any"
                   value="<?= htmlspecialchars((string)$price) ?>"
                   required>
        </p>
        <button type="submit">Tính hóa đơn</button>
    </form>

    <?php if ($error !== ''): ?>
        <p style="color:red">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <?php if ($total !== null): ?>
        <h3>KẾT QUẢ HÓA ĐƠN</h3>
        <p>Tên tài liệu: <?= htmlspecialchars($name) ?></p>
        <p>Số lượng: <?= $qty ?></p>
        <p>Đơn giá: <?= money((float)$price) ?></p>
        <p>Thành tiền: <?= money($total) ?></p>
    <?php endif; ?>
</body>
</html>
