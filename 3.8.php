
<?php
$name = '';
$email = '';
$subject = 'Ho tro ky thuat';
$content = '';
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($name == '') {
        $errors[] = 'Vui lòng nhập họ tên.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ.';
    }

    if (!in_array($subject, [
        'Ho tro ky thuat', 'Tu van', 'Khac'
    ], true)) {
        $errors[] = 'Chủ đề không hợp lệ.';
    }

    if (strlen($content) < 10 || strlen($content) > 500) {
        $errors[] = 'Nội dung phải từ 10 đến 500 ký tự.';
    }

    $imageName = '';

    if (isset($_FILES['avatar']) &&
        $_FILES['avatar']['error'] != UPLOAD_ERR_NO_FILE) {

        if ($_FILES['avatar']['error'] != UPLOAD_ERR_OK) {
            $errors[] = 'Lỗi tải ảnh lên.';
        } elseif ($_FILES['avatar']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'Ảnh không được vượt quá 2MB.';
        } else {
            $file = $_FILES['avatar'];
            $types = [
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif'
            ];

            $ext = strtolower(pathinfo(
                $file['name'], PATHINFO_EXTENSION
            ));
            $mime = mime_content_type($file['tmp_name']);

            if (!isset($types[$ext]) || $types[$ext] != $mime) {
                $errors[] = 'Ảnh phải có định dạng JPG, PNG hoặc GIF.';
            } elseif (getimagesize($file['tmp_name']) === false) {
                $errors[] = 'File không phải ảnh hợp lệ.';
            } else {
                $dir = __DIR__ . '/uploads/';

                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }

                file_put_contents(
                    $dir . '.htaccess',
                    "Options -ExecCGI\nRemoveHandler .php .phtml .php3 .php4 .php5 .php7 .phar\n<FilesMatch \"\\.(php|phtml|php[0-9]?|phar)$\">\nRequire all denied\n</FilesMatch>\n"
                );

                $imageName = bin2hex(random_bytes(16)) . '.' . $ext;

                if (!move_uploaded_file(
                    $file['tmp_name'], $dir . $imageName
                )) {
                    $errors[] = 'Không thể lưu ảnh.';
                }
            }
        }
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
    <title>Form liên hệ</title>
</head>
<body>
    <h2>LIÊN HỆ</h2>

    <form method="post" enctype="multipart/form-data">
        Họ tên:
        <input type="text" name="name"
               value="<?= htmlspecialchars($name) ?>" required>
        <br><br>

        Email:
        <input type="email" name="email"
               value="<?= htmlspecialchars($email) ?>" required>
        <br><br>

        Chủ đề:
        <select name="subject">
            <option value="Ho tro ky thuat"
                <?= $subject == 'Ho tro ky thuat' ? 'selected' : '' ?>>
                Hỗ trợ kỹ thuật
            </option>
            <option value="Tu van"
                <?= $subject == 'Tu van' ? 'selected' : '' ?>>
                Tư vấn
            </option>
            <option value="Khac"
                <?= $subject == 'Khac' ? 'selected' : '' ?>>
                Khác
            </option>
        </select>
        <br><br>

        Nội dung:
        <br>
        <textarea name="content" rows="5" cols="40"
                  required><?= htmlspecialchars($content) ?></textarea>
        <br><br>

        Ảnh đại diện:
        <input type="file" name="avatar"
               accept="image/jpeg,image/png,image/gif">
        <br><br>

        <button type="submit">Gửi liên hệ</button>
    </form>

    <?php foreach ($errors as $error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <?php if ($success != ''): ?>
        <h3><?= htmlspecialchars($success) ?></h3>
        <p>Họ tên: <?= htmlspecialchars($name) ?></p>
        <p>Email: <?= htmlspecialchars($email) ?></p>
        <p>Chủ đề: <?= htmlspecialchars($subject) ?></p>
        <p>Nội dung: <?= htmlspecialchars($content) ?></p>
        <?php if ($imageName != ''): ?>
            <p>Ảnh đã tải lên: <?= htmlspecialchars($imageName) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
