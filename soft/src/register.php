<?php
session_start();
require_once 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if (strlen($username) < 3) {
        $error = "⚠️ Tên đăng nhập phải có ít nhất 3 ký tự.";
    } elseif ($password !== $confirm) {
        $error = "⚠️ Mật khẩu xác nhận không khớp.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "⚠️ Tên đăng nhập đã được sử dụng.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            $insert->bind_param("ss", $username, $hashed);
            if ($insert->execute()) {
                $success = "✅ Đăng ký thành công! Bạn có thể <a href='login.php'>đăng nhập</a> ngay.";
            } else {
                $error = "❌ Có lỗi xảy ra, vui lòng thử lại.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5 mb-5">
  <div class="row justify-connamet-center">
    <div class="col-md-6">
      <div class="card shadow-lg p-4">
        <h3 class="mb-4 text-center">📝 Đăng ký tài khoản</h3>
        
        <?php if ($error): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" class="form-control" required minlength="3">
          </div>
          <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" class="form-control" required minlength="6">
          </div>
          <div class="form-group">
            <label for="confirm">Nhập lại mật khẩu:</label>
            <input type="password" id="confirm" name="confirm" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success btn-block">Đăng ký</button>
        </form>
        
        <p class="mt-3 text-center text-muted">
          Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
