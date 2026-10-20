
<?php
$data = [
    'name' => '',
    'email' => '',
    'subject' => '',
    'content' => ''
];

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data['name'] = trim($_POST['name'] ?? '');
    $data['email'] = trim($_POST['email'] ?? '');
    $data['subject'] = trim($_POST['subject'] ?? '');
    $data['content'] = trim($_POST['content'] ?? '');

    if ($data['name'] == '') {
        $errors['name'] = 'Vui lòng nhập họ tên.';
    } elseif (strlen($data['name']) > 100) {
        $errors['name'] = 'Họ tên không quá 100 ký tự.';
    }

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
    }

    $subjects = ['Ho tro ky thuat', 'Tu van', 'Khac'];

    if (!in_array($data['subject'], $subjects, true)) {
        $errors['subject'] = 'Vui lòng chọn chủ đề hợp lệ.';
    }

    $length = strlen($data['content']);

    if ($length < 10 || $length > 500) {
        $errors['content'] = 'Nội dung phải từ 10 đến 500 ký tự.';
    }

    if (empty($errors)) {
        $success = 'Gửi liên hệ thành công!';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Form liên hệ an toàn</title>
</head>
<body>
    <h2>FORM LIÊN HỆ AN TOÀN</h2>

    <form method="post">
        Họ tên:
        <input type="text" name="name"
               maxlength="100"
               value="<?= htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8') ?>"
               required>
        <br>
        <?= htmlspecialchars($errors['name'] ?? '') ?>
        <br><br>

        Email:
        <input type="email" name="email"
               value="<?= htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8') ?>"
               required>
        <br>
        <?= htmlspecialchars($errors['email'] ?? '') ?>
        <br><br>

        Chủ đề:
        <select name="subject" required>
            <option value="">-- Chọn chủ đề --</option>
            <option value="Ho tro ky thuat"
                <?= $data['subject'] == 'Ho tro ky thuat' ? 'selected' : '' ?>>
                Hỗ trợ kỹ thuật
            </option>
            <option value="Tu van"
                <?= $data['subject'] == 'Tu van' ? 'selected' : '' ?>>
                Tư vấn
            </option>
            <option value="Khac"
                <?= $data['subject'] == 'Khac' ? 'selected' : '' ?>>
                Khác
            </option>
        </select>
        <br>
        <?= htmlspecialchars($errors['subject'] ?? '') ?>
        <br><br>

        Nội dung:
        <br>
        <textarea name="content" rows="5" cols="40"
                  required><?= htmlspecialchars($data['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
        <br>
        <?= htmlspecialchars($errors['content'] ?? '') ?>
        <br><br>

        <button type="submit">Gửi liên hệ</button>
    </form>

    <?php if (!empty($errors)): ?>
        <h3>Vui lòng kiểm tra lại thông tin.</h3>
    <?php endif; ?>

    <?php if ($success != ''): ?>
        <h3><?= htmlspecialchars($success) ?></h3>
        <p>Họ tên: <?= htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <p>Email: <?= htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <p>Chủ đề: <?= htmlspecialchars($data['subject'], ENT_QUOTES, 'UTF-8') ?></p>
        <p>Nội dung: <?= nl2br(htmlspecialchars($data['content'], ENT_QUOTES, 'UTF-8')) ?></p>
    <?php endif; ?>
</body>
</html>
