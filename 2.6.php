
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>GET và POST</title>
</head>
<body>
    <h2>TÌM KIẾM SINH VIÊN (GET)</h2>

    <form method="get">
        <input type="text" name="search"
               placeholder="Nhập tên sinh viên"
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Tìm kiếm</button>
    </form>

    <?php
    $students = ["An", "Binh", "Chi"];

    if (isset($_GET['search'])) {
        $keyword = trim($_GET['search']);

        echo "<h3>Kết quả tìm kiếm:</h3>";
        $found = false;

        foreach ($students as $student) {
            if (stripos($student, $keyword) !== false) {
                echo htmlspecialchars($student) . "<br>";
                $found = true;
            }
        }

        if (!$found) {
            echo "Không tìm thấy sinh viên.";
        }
    }
    ?>

    <hr>

    <h2>THÊM SINH VIÊN (POST)</h2>

    <form method="post">
        <input type="text" name="name"
               placeholder="Nhập tên sinh viên" required>
        <button type="submit" name="add">Thêm sinh viên</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST"
        && isset($_POST['add'])) {
        $name = trim($_POST['name'] ?? '');

        if ($name !== '') {
            echo "Đã nhận tên sinh viên: "
                . htmlspecialchars($name);
        } else {
            echo "Tên sinh viên không được để trống.";
        }
    }
    ?>
</body>
</html>
