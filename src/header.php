<?php
// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lưu niệm học sinh</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- 🔗 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light mx-1" href="index.php">🏠 Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light mx-1" href="products.php">🛍️ Sản phẩm</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-outline-light mx-1" href="cart.php">🛒 Giỏ hàng</a>
        </li>
        <?php if (isset($_SESSION['user'])): ?>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-light mx-1" href="admin.php">Quản lý sản phẩm</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-light mx-1" href="quanly-donhang.php">Quản lý đơn hàng</a>
            </li>
          <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-warning mx-1" href="logout.php">🚪 Đăng xuất (<?php echo htmlspecialchars($_SESSION['user']); ?>)</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-success mx-1" href="login.php">🔐 Đăng nhập</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-primary mx-1" href="register.php">📝 Đăng ký</a>
            </li>
          <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
