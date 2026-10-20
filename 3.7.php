
<?php
$data = [
    'name' => '',
    'email' => '',
    'birthday' => ''
];

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['birthday'] = trim($_POST['birthday'] ?? '');

    if ($data['name'] == '') {
        $errors['name'] = 'Vui lòng nhập họ tên.';
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
    }

    if ($data['birthday'] == '') {
        $errors['birthday'] = 'Vui lòng nhập ngày sinh.';
    } else {
        $date = DateTime::createFromFormat('!Y-m-d', $data['birthday']);

        if (!$date || $date->format('Y-m-d') !== $data['birthday']) {
            $errors['birthday'] = 'Ngày sinh không hợp lệ.';
        }
    }

    if (empty($errors)) {
        $success = 'Đăng ký thành công!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký sinh viên</title>
</head>
<body>
    <h2>FORM ĐĂNG KÝ SINH VIÊN</h2>

    <form method="post">
        Họ tên:
        <input type="text" name="name"
               value="<?= htmlspecialchars($data['name']) ?>">
        <br>
        <?= $errors['name'] ?? '' ?>
        <br><br>

        Email:
        <input type="text" name="email"
               value="<?= htmlspecialchars($data['email']) ?>">
        <br>
        <?= $errors['email'] ?? '' ?>
        <br><br>

        Ngày sinh:
        <input type="date" name="birthday"
               value="<?= htmlspecialchars($data['birthday']) ?>">
        <br>
        <?= $errors['birthday'] ?? '' ?>
        <br><br>

        <button type="submit">Đăng ký</button>
    </form>

    <?php if ($success != ''): ?>
        <h3><?= htmlspecialchars($success) ?></h3>
        <p>Họ tên: <?= htmlspecialchars($data['name']) ?></p>
        <p>Email: <?= htmlspecialchars($data['email']) ?></p>
        <p>Ngày sinh: <?= htmlspecialchars($data['birthday']) ?></p>
    <?php endif; ?>
</body>
</html>
