
<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_FILES['image']) ||
        $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $message = 'Lỗi upload file.';
    } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        $message = 'Ảnh không được vượt quá 2MB.';
    } else {
        $file = $_FILES['image'];
        $allowed = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($file['tmp_name']);

        if (!isset($allowed[$ext]) || $allowed[$ext] != $mime) {
            $message = 'Chỉ chấp nhận ảnh JPG, PNG hoặc GIF hợp lệ.';
        } else {
            $dir = __DIR__ . '/uploads/';

            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Ngăn thực thi PHP trong thư mục chứa ảnh trên Apache
            file_put_contents(
                $dir . '.htaccess',
                "Options -ExecCGI\nRemoveHandler .php .phtml .php3 .php4 .php5 .php7 .phar\n<FilesMatch \"\\.(php|phtml|php[0-9]?|phar)$\">\nRequire all denied\n</FilesMatch>\n"
            );

            $newName = bin2hex(random_bytes(16)) . '.' . $ext;
            $target = $dir . $newName;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $message = 'Upload ảnh thành công. Tên file: ' . $newName;
            } else {
                $message = 'Không thể lưu ảnh.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload ảnh</title>
</head>
<body>
    <h2>UPLOAD ẢNH AN TOÀN</h2>

    <form method="post" enctype="multipart/form-data">
        Chọn ảnh:
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif" required>
        <br><br>
        <button type="submit">Tải ảnh lên</button>
    </form>

    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
</body>
</html>
