<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Chuẩn bị câu lệnh SQL để tránh SQL Injection
    $stmt = $conn->prepare("SELECT id, username, password, role FROM nguoidung WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra người dùng có tồn tại
    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Kiểm tra mật khẩu: hỗ trợ cả password hash và plain text (nếu CSDL cũ)
        if (password_verify($pass, $row['password']) || $pass === $row['password']) {
            $_SESSION['user'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Chuyển trang tùy theo role
            if ($row['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tên đăng nhập không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5 mb-5">
  <h3 class="mb-4">Đăng nhập hệ thống</h3>
  <form method="POST">
    <div class="form-group">
      <label for="username">Tên đăng nhập:</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="password">Mật khẩu:</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <button type="submit" class="btn btn-hong">Đăng nhập</button>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
